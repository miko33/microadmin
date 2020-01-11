<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use DB;

use App\Game;
use App\Division;
use App\General;

use Validator;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

use App\DataTables\GamesDataTable;

use \Carbon\Carbon;
class GameController extends Controller
{

    /**
     * The game dataTable instance.
     */
    protected $dataTable;

    /**
     * Create a new controller instance.
     *
     * @param  GamesDataTable  $dataTable
     * @return void
     */
    public function __construct(GamesDataTable $dataTable)
    {
        $this->middleware('pageaccess:game,view')->except('show');
        $this->middleware('pageaccess:game,create')->only('store');
        $this->middleware('pageaccess:game,alter')->only(['edit', 'update']);
        $this->middleware('pageaccess:game,drop')->only('destroy');

        $this->general = new General;

        $this->dataTable = $dataTable;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // dd(Auth::user());
        $division_id = explode(',', json_decode(Auth::user()->division)->id);
        $query = Division::OfId($division_id)->get();

        return $this->dataTable->with('division', request()->get('id'))->render('pages.game.game', ['divisions' => $query]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'game_division' => 'required',
            'game_name' => [
                'required',
                'alpha_dash',
                'max:255',
                Rule::unique('games', 'name')
                        ->where('division_id', $request->game_division)
            ],
            'game_url' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $this->createTable($request);

        $game = new Game([
            'division_id' => $request->get('game_division'),
            'name' => $request->get('game_name'),
            'url' => $request->get('game_url')
        ]);
        $game->save();

        return response()->json(['heading' => 'Success!', 'text' => $request->get('game_name').' has been created.', 'icon' => 'success']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $video = null)
    {
        //

        if (request()->ajax()) {
            $query = Game::findOrFail($id);

            $tblName = Division::find($query->division_id)->name.'_'.$query->name;
            // dd(Division::find($query->division_id));
            $videos = DB::table($tblName.'_videos')->where(['status' => 1]);

            if ($video) {
                $p = $videos->where(['id' => $video]);
            }

            $page =request()->get('page');
            if ($page && is_numeric($page)) {
                $p = $videos->paginate(request()->get('limit'));
            } else {
                $p = $videos->get();
            }

            // if (empty(sizeof($p))) {
            //     abort(404);
            // }

            $data = [];

            foreach ($p as $key => $value) {

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

            return $data;
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

        $game = Game::find($id);

        $data = [

            'game_division' => ['input_type' => 'select2', 'input_value' => $game->division_id],
            'game_name' => ['input_value' => $game->name],
            'game_url' => ['input_value' => $game->url]

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
            'game_division' => 'required',
            'game_name' => [
                'required',
                'max:255',
                Rule::unique('games', 'name')
                        ->where('division_id', $request->game_division)
                        ->ignore($id)
            ],
            'game_url' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        return response()->json(['heading' => 'Success!', 'text' => $request->get('game_name').' has been updated.', 'icon' => 'success']);

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

        $rules = [
            'inputName' => [
            'required',
            Rule::exists('games', 'name')->where('id', $id)
            ],
        ];

        $messages = [
        'required' => 'The game name field is required.',
        'exists' => 'The selected game name is invalid.'
        ];

        $validator = Validator::make(request()->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $game = Game::find($id);

        $division = Division::find($game->division_id);

        $nameArray = ['categories', 'videos'];

        foreach ($nameArray as $key => $value) {
            $tblName = $division->name.'_'.$game->name.'_'.$value;
            $this->dropTable($tblName);
        }

        $game->delete();

        return response()->json(['heading' => 'Deleted!', 'text' => request()->get('inputName').' has been deleted.', 'icon' => 'error']);

    }

    private function createTable($request)
    {

        $division = Division::OfId([$request->get('game_division')])->get();
        // dd($division);
        $name = $division[0]->name . '_'  . $request->get('game_name');

        if (Schema::hasTable($name . '_categories') && Schema::hasTable($name . '_videos')) { return response()->json(['status' => false]); }

        Schema::create($name . '_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });

        Schema::create($name . '_videos', function (Blueprint $table) {
            $table->increments('id');
            $table->text('category_id');
            $table->string('youtube_id');
            $table->string('title');
            $table->string('slug');
            $table->text('description');
            $table->text('thumbnails');
            $table->string('duration');
            $table->bigInteger('viewCount');
            $table->bigInteger('likeCount');
            $table->bigInteger('dislikeCount');
            $table->bigInteger('commentCount');
            $table->bigInteger('favoriteCount');
            $table->string('author');
            $table->tinyInteger('status')->default(1);
            $table->string('published_at');
            $table->timestamps();
        });

    }

    private function dropTable($name)
    {

        Schema::drop($name);

    }
}
