<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use DB;

use Validator;
use Illuminate\Validation\Rule;

use App\Game;
use App\Division;
use App\General;
use App\Trash;

use Alaouy\Youtube\Facades\Youtube;

use Illuminate\Support\Facades\Storage as Storage;

use \Carbon\Carbon;
class VideoController extends Controller
{

    public function __construct()
    {
        $this->middleware('pageaccess:game,view')->except(['trash', 'restore', 'delete', 'show']);
        $this->middleware('pageaccess:game,create')->only(['create', 'store']);
        $this->middleware('pageaccess:game,alter')->only(['edit', 'update']);
        $this->middleware('pageaccess:game,drop')->only('destroy');

        $this->middleware('pageaccess:trash,view')->only('trash');
        $this->middleware('pageaccess:trash,edit')->only('restore');
        $this->middleware('pageaccess:trash,drop')->only('delete');

        $this->general = new General;

        $this->table = request()->get('game').request()->get('prefix');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        if (request()->ajax()) {
            switch (request()->type) {
                case 'category':
                        return response()->json(DB::table($this->table)->get());
                    break;
                case 'videos':

                $category_id = request()->category;

                if (request()->get('searchQuery') != "") {
                    $searchQuery = request()->get('searchQuery');
                    $video = DB::table($this->table)->where('title', 'LIKE', "%$searchQuery%");
                } else {
                    $video = DB::table($this->table);
                }
                

                $video = $video->where('status', '!=', 3)
                                    ->where(function($query) use ($category_id) {
                                        for ($i=0; $i < count($category_id); $i++) { 
                                            $query->orWhere('category_id', 'like', '%'.$category_id[$i].'%');
                                        }
                                    });

                            if (request()->page == 'all') {
                                $q['data'] = $video->get();
                                $q['from'] = 1;
                                $q['to'] = $video->count();
                                $q['total'] = $video->count();
                            } else {
                                $q = $video->paginate(5);
                            }

                            $permission = collect([]);

                            if (General::page_access(Auth::user()->group_id, 'video', 'alter')) {
                                $permission['alter'] = true;
                            }

                            if (General::page_access(Auth::user()->group_id, 'video', 'drop')) {
                                $permission['drop'] = true;
                            }

                            $data = $permission->merge($q);
                    
                        return response()->json($data);
                    break;
            }
        }

        return view('pages.video.video');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        if ($request->ajax()) {

            $inputName = array_keys($request->all())[0];

            $videoId = $request->has('youtube_id') ? $request->youtube_id : Youtube::parseVidFromURL($request->youtube_url);

            $data = Youtube::getVideoInfo($videoId);

            if ($data == false) {
                return response()->json(['errors' => [$inputName => 'The '.$inputName.' is invalid.']]);
            }

            $data->url = $request->youtube_url;

            return response()->json($data);

        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'game' => 'required',
        ]);

        $validator->sometimes(['title', 'slug', 'youtube_id', 'category'], 'required', function($input) {
            return $input->game != null;
        });

        $validator->sometimes('slug', 'alpha_dash|unique:'.$this->table, function($input) {
            return $input->game != null;
        });

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->has('category')) {
                $errors->add('category[]', 'The category field is required.');
            }

            return response()->json([
                'errors' => $errors
            ]);
        }

        $thumbnails = json_decode($request->thumbnails);

        if ($request->custom_thumbnail) {
            $fldr = explode('_', $request->game);
            $file = $request->custom_thumbnail;
            $ext = $file->guessClientExtension();
            $path = 'thumbnails' . '/' .$fldr[0] . '/' . $fldr[1] . '/' . $request->slug;
            $filename = 'cstmdefault.'.$ext;
            $file->storeAs($path, $filename, 'public');

            $thumbnails->custom = $filename;
        }

        $statistics = json_decode($request->statistics);

        DB::table($this->table)->insert(
            [
                'category_id' => json_encode($request->category),
                'youtube_id' => $request->youtube_id,
                'title' => $request->title,
                'slug' => $request->slug,
                'description' => $request->description,
                'thumbnails' => json_encode($thumbnails, JSON_UNESCAPED_SLASHES),
                'duration' => $request->duration,
                'viewCount' => $statistics->viewCount,
                'likeCount' => $statistics->likeCount,
                'dislikeCount' => $statistics->dislikeCount,
                'favoriteCount' => $statistics->favoriteCount,
                'commentCount' => $statistics->commentCount,
                'author'    => Auth::user()->name,
                'status'    => $request->has('status') ? 1 : 0,
                'published_at'  => $request->publishedAt,
                'created_at' => $this->general->datetime
            ]
        );

        return response()->json(['heading' => 'Success!', 'text' => $request->get('title').' has been created.', 'icon' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if (request()->ajax()) {
            $searchQuery = str_replace(' ', '_', $request->search);
            
            $validator = Validator::make(['page' => $request->page, 'limit' => $request->limit, 'query' => $searchQuery], [ 
                'query' => ['nullable', 'alpha_dash'],
                'page' => ['nullable', 'numeric'],
                'limit' => ['nullable', 'numeric'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ]);
            }
            
            

            $query = Game::findOrFail($id);

            $tblName = Division::find($query->division_id)->name.'_'.$query->name;

            if ($request->page) {
                $videos = DB::table($tblName.'_videos')->where('title', 'LIKE', "%$searchQuery%")->where(['status' => 1])->paginate(request()->get('limit'));
            } else {
                $videos = DB::table($tblName.'_videos')->where('title', 'LIKE', "%$searchQuery%")->where(['status' => 1])->get();
            }

            $data = [];

            foreach ($videos as $value) {
                $q = DB::table($tblName.'_categories')->whereIn('id', json_decode($value->category_id))->get();

                $c = array_pluck($q, 'name');

                $published_at = substr((str_replace('T', ' ', $value->published_at)), 0, -5);

                $published = new Carbon($published_at);
                $now = Carbon::now();
                $difference = $published->diff($now)->days < 1 ? 'today' : $published->diffForHumans($now, true);
                if ($difference == 'today') {
                    $difference = $difference;
                } else {
                    $difference = $difference.' ago';
                }

                $video = [

                    'id' => (string) $value->id,
                    'youtube_id' => $value->youtube_id,
                    'category' => $c,
                    'title' => $value->title,
                    'slug' => $value->slug,
                    'description' => $value->description,
                    'thumbnails' => json_decode($value->thumbnails),
                    'duration' => $this->general->duration($value->duration),
                    'viewCount' => number_format($value->viewCount),
                    'likeCount' => number_format($value->likeCount),
                    'dislikeCount' => number_format($value->dislikeCount),
                    'commentCount' => number_format($value->commentCount),
                    'favoriteCount' => number_format($value->favoriteCount),
                    'published_at' => $difference,

                ];

                array_push($data, $video);
            }

            return response()->json($data, 200);;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $video = DB::table($this->table)->where('id', $id)->first();

        $g = str_replace('_', '/', request()->get('game'));

        $thumbnails = json_decode($video->thumbnails, true);

        $thumbnailSet = ['custom', 'high', 'maxres', 'default'];
        for ($i=0; $i < sizeof($thumbnailSet); $i++) {
            if (array_key_exists($thumbnailSet[$i], $thumbnails) && in_array('default', $thumbnailSet)) {
                $thumbnail = ($thumbnailSet[$i] == 'custom') ? '/storage/thumbnails/'.$g.'/'.$video->slug.'/'.$thumbnails[$thumbnailSet[$i]]: $thumbnails[$thumbnailSet[$i]];
                array_splice($thumbnailSet, 3, 1);
            }
        }

        $data = [
            'game' => ['input_type' => 'select2', 'input_value' => request()->get('game')],
            'status' => ['input_type' => 'checkbox', 'input_value' => $video->status],
            'youtube_id' => ['input_value' => $video->youtube_id],
            'title' => ['input_value' => $video->title],
            'slug' => ['input_value' => $video->slug],
            'description' => ['input_value' => $video->description],
            'category[]' => ['input_type' => 'multiselect', 'input_value' => $video->category_id],
            'thumbnails' => ['input_value' => json_encode($thumbnails)],
            'duration' => ['input_value' => $video->duration],

            'lightbox-popup-video' => ['input_type' => 'parent', 'link' => 'https://www.youtube.com/watch?v='.$video->youtube_id, 'thumbnail' => $thumbnail],

            'statistics' => [
                'input_type' => 'object',
                'input_value' => [
                    'viewCount' => $video->viewCount,
                    'likeCount' => $video->likeCount,
                    'dislikeCount' => $video->dislikeCount,
                    'favoriteCount' => $video->favoriteCount,
                    'commentCount' => $video->commentCount
                ],
                'input_fadeIn' => '#videoContainer',
            ]
        ];

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validator = Validator::make($request->all(), [
            'youtube_id' => 'required',
            'title' => [
                'required',
                Rule::unique($this->table, 'title')
                        ->ignore($id)
            ],
            'slug' => [
                'required',
                Rule::unique($this->table, 'slug')
                        ->ignore($id)
            ],
            'category' => 'required',   
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->has('category')) {
                $errors->add('category[]', 'The category field is required.');
            }

            return response()->json([
                'errors' => $errors
            ]);
        }


        $thumbnails = json_decode($request->thumbnails);

        if ($request->custom_thumbnail) {
            $fldr = explode('_', $request->game);
            $file = $request->custom_thumbnail;
            $ext = $file->guessClientExtension();
            $path = 'thumbnails' . '/' .$fldr[0] . '/' . $fldr[1] . '/' . $request->slug;
            $filename = 'cstmdefault.'.$ext;
            $file->storeAs($path, $filename, 'public');

            $thumbnails->custom = $filename;
        }

        $statistics = json_decode($request->statistics);

        DB::table($this->table)
                ->where('id', $id)
                    ->update(
                        [
                            'category_id' => json_encode($request->category),
                            'youtube_id' => $request->youtube_id,
                            'title' => $request->title,
                            'slug' => $request->slug,
                            'description' => $request->description,
                            'thumbnails' => json_encode($thumbnails, JSON_UNESCAPED_SLASHES),
                            'status'    => $request->has('status') ? 1 : 0,
                            'updated_at' => $this->general->datetime
                        ]
                    );

        return response()->json(['heading' => 'Success!', 'text' => $request->get('title').' has been updated.', 'icon' => 'success']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        DB::table($this->table)->whereIn('id', explode(',', $id))->update(['status' => 3]);

        return response()->json(['heading' => 'Deleted!', 'text' => 'The video(s) has been moved to the Trash.']);

    }


    /**
     *
     * Video Trash.
     * 
     */

    public function trash()
    {

        if (request()->ajax()) {
            switch (request()->type) {
                case 'category':
                        return response()->json(DB::table($this->table)->get());
                    break;
                case 'videos':
                $category_id = request()->category;
                $video = DB::table($this->table)
                            ->where('status', 3)
                            ->where(function($query) use ($category_id) {
                                for ($i=0; $i < count($category_id); $i++) { 
                                    $query->orWhere('category_id', 'like', '%'.$category_id[$i].'%');
                                }
                            })->paginate(5);
                        return response()->json($video);
                    break;
            }
        }
        $microsite_breadcrumb = "Manage trashed videos";
        return view('pages.video.trash', compact('microsite_breadcrumb'));
    }

    public function restore($id)
    {

        DB::table($this->table)->whereIn('id', explode(',', $id))->update(['status' => 1]);

        return response()->json(['heading' => 'Success!', 'text' => 'The video(s) has been moved to the Videos.', 'icon' => 'success']);
    }

    public function delete($id)
    {
        //

        $query = DB::table($this->table);

        if ($id == 'all') {
            $query->where('status', 3);
        } else {
            $query->whereIn('id', explode(',', $id));
        }

        $query->delete();

        return response()->json(['heading' => 'Deleted!', 'text' => 'The video(s) has been deleted.']);

    }

}
