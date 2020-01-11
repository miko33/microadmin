<?php

namespace App\Http\Controllers;

use App\UserGroup;
use App\General;

use Illuminate\Http\Request;

use Auth;
use DB;

use Validator;
use Illuminate\Validation\Rule;

class UserGroupController extends Controller
{

    public function __construct()
    {

        $this->middleware('pageaccess:user_group,view');
        $this->middleware('pageaccess:user_group,create')->only('store');
        $this->middleware('pageaccess:user_group,alter')->only('update');
        $this->middleware('pageaccess:user_group,drop')->only('destroy');

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
            $user_group['data'] = UserGroup::all();

            $permission = collect([]);

            if (General::page_access(Auth::user()->group_id, 'user_group', 'alter')) {
                $permission['alter'] = true;
            }

            if (General::page_access(Auth::user()->group_id, 'user_group', 'drop')) {
                $permission['drop'] = true;
            }

            $data = $permission->merge($user_group);

            return response()->json($data);
        }

        return view('pages.user.user_group');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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
            'name' => 'required|max:25|unique:user_groups',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $view = is_array($request->view) ? implode(',', $request->view) : '';
        $create = is_array($request->create) ? implode(',', $request->create) : '';
        $alter = is_array($request->alter) ? implode(',', $request->alter) : '';
        $drop = is_array($request->drop) ? implode(',', $request->drop) : '';
        $game = is_array($request->game_filter) ? implode(',', $request->game_filter) : '';

        $access = json_encode([
            'game' => $game,
            'view' => $view,
            'create' => $create,
            'alter' => $alter,
            'drop' => $drop
        ]);

        $user_group = new UserGroup();
        $user_group->name = $request->name;
        $user_group->access = $access;
        $user_group->save();

        return response()->json(['heading' => 'Success!', 'text' => ucwords($request->name) . ' has been created.', 'icon' => 'success']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function show(UserGroup $userGroup)
    {
        //

        $user_group = UserGroup::find($userGroup);

        $access = json_decode($user_group->first()->access);

        $view = json_encode(explode(',', $access->view));
        $create = json_encode(explode(',', $access->create));
        $alter = json_encode(explode(',', $access->alter));
        $drop = json_encode(explode(',', $access->drop));

        $game = json_encode(explode(',', $access->game));

        $data = (object) [
            'game' => $game,
            'view' => $view,
            'create' => $create,
            'alter' => $alter,
            'drop' => $drop
        ];

        return response()->json($data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(UserGroup $userGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserGroup $userGroup)
    {
        //

        $view = is_array($request->view) ? implode(',', $request->view) : '';
        $create = is_array($request->create) ? implode(',', $request->create) : '';
        $alter = is_array($request->alter) ? implode(',', $request->alter) : '';
        $drop = is_array($request->drop) ? implode(',', $request->drop) : '';
        $game = is_array($request->game_filter) ? implode(',', $request->game_filter) : '';

        $access = json_encode([
            'game' => $game,
            'view' => $view,
            'create' => $create,
            'alter' => $alter,
            'drop' => $drop
        ]);

        $userGroup->name = $request->name;
        $userGroup->access = $access;
        $userGroup->save();

        return response()->json(['heading' => 'Success!', 'text' => ucwords($request->name) . ' has been updated.', 'icon' => 'success']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserGroup $userGroup)
    {
        //

        $name = $userGroup->name;

        $userGroup->delete();

        return response()->json(['heading' => 'Deleted!', 'text' => ucwords($name) . ' has been deleted.', 'icon' => 'error']);

    }
}
