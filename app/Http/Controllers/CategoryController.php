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

class CategoryController extends Controller
{

    public function __construct()
    {

        $this->middleware('pageaccess:category,view')->except('show');
        $this->middleware('pageaccess:category,create')->only('store');
        $this->middleware('pageaccess:category,alter')->only(['edit', 'update']);
        $this->middleware('pageaccess:category,drop')->only('destroy');

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

            $data = DB::table($this->table)->get();
            foreach ($data as $key => $value) {
                $videoCount = DB::table(request()->get('game').'_videos')
                                    ->where('category_id', 'like', '%'.$value->id.'%')
                                        ->count();

                $data[$key]->count = $videoCount;
            }

            $row['data'] = $data;

            if (General::page_access(Auth::user()->group_id, 'category', 'alter')) {
                $row['alter'] = true;
            }

            if (General::page_access(Auth::user()->group_id, 'category', 'drop')) {
                $row['drop'] = true;
            }

            return response()->json($row);
        }
        $create = (request()->get('create')) ? request()->get('create') : "";
        return view('pages.category.category', compact('create'));
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
            'game' => 'required',
            'name' => 'required|alpha_dash|max:25|',
            'slug' => 'required|alpha_dash',
        ]);

        $validator->sometimes('name', 'unique:'.$this->table.',name', function($input) {
            return $input->game != null;
        });

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        DB::table($this->table)->insert(
            [
                'name' => $request->name,
                'slug' => $request->slug,
                'created_at' => $this->general->datetime
            ]
        );

        return response()->json(['heading' => 'Success!', 'text' => $request->get('name').' has been created.', 'icon' => 'success']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        $query = Game::findOrFail($id);
        
        $tblName = Division::find($query->division_id)->name.'_'.$query->name;
        // dd($tblName);
        $category = DB::table($tblName.'_categories');

        $data = [];

        foreach ($category->get() as $key => $value) {

            $c = [

                'id' => (string) $value->id,
                'name' => $value->name.'|'.$value->slug,

            ];

            array_push($data, $c);

        }

        return $data;

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

        $category = DB::table($this->table)->where('id', $id)->first();

        $game = explode('_', request()->get('game'));

        $data = [
            'game' => ['input_type' => 'select2', 'input_value' => request()->get('game')],
            'name' => ['input_value' => $category->name],
            'slug' => ['input_value' => $category->slug]
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
            'game' => 'required',
            'name' => [
                'required',
                'max:255',
                Rule::unique($this->table, 'name')
                        ->ignore($id)
            ],
            'slug' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        DB::table($this->table)
                    ->where('id', $id)
                        ->update(
                            [
                                'name' => $request->name,
                                'slug' => $request->slug,
                                'updated_at' => $this->general->datetime
                            ]
                        );

        return response()->json(['heading' => 'Success!', 'text' => $request->get('name').' has been updated.', 'icon' => 'success']);
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

        $videoCount = DB::table(request()->get('game').'_videos')
                            ->where('category_id', 'like', '%'.$id.'%')
                                ->count();

        $rules = [
            'inputName' => [
            'bail',
            'required',
            Rule::exists($this->table, 'name')->where('id', $id),
            function($attribute, $value, $fail) use ($videoCount) {
                if ($videoCount > 0) {
                    return $fail('Remove the '.$videoCount.' video(s) from this category.');
                }
            },
            ],
        ];

        $messages = [
        'required' => 'The category name field is required.',
        'exists' => 'The selected category name is invalid.'
        ];

        $validator = Validator::make(request()->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        // DB::table($this->table)->where('id', $id)->delete();

        return response()->json(['heading' => 'Deleted!', 'text' => request()->get('inputName').' has been deleted.', 'icon' => 'error']);

    }
}
