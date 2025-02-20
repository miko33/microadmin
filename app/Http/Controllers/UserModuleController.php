<?php

namespace App\Http\Controllers;

use App\UserModule;
use Illuminate\Http\Request;

class UserModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        if (request()->ajax()) {

            $menus = [];
            $i = 0;

            $user_module = UserModule::whereNull('parent_id');

            foreach ($user_module->get() as $main) 
            {
                $menus[$i]['parent'] = $main;
                $menus[$i]['sub'] = UserModule::where('parent_id', $main->id)->get();
                $i++;
            }

            return response()->json($menus);
        }

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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserModule  $userModule
     * @return \Illuminate\Http\Response
     */
    public function show(UserModule $userModule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserModule  $userModule
     * @return \Illuminate\Http\Response
     */
    public function edit(UserModule $userModule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserModule  $userModule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserModule $userModule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserModule  $userModule
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserModule $userModule)
    {
        //
    }
}
