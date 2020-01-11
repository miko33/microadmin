<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App;
use DB;

class PageAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $page, $type)
    {
        if ($this->validate(Auth::user()->group_id, $page, $type)) {
            return $next($request);
        }

        abort(403);
    }

    private function validate($group_id, $page, $type)
    {
        $data  = DB::table('user_groups')
                        ->where('id', $group_id)
                            ->first()->access;

        $array = ['view', 'create', 'alter', 'drop'];

        if(in_array($type, $array)) {
            $module_id = explode(',', json_decode($data)->{$type});

            $access = DB::table('user_modules')
                            ->whereIn('id', $module_id)
                                ->get()
                                    ->pluck('alias')->toArray();

            $page = explode('|', $page);

            for ($i=0; $i < sizeof($page); $i++) 
            {
                if (in_array($page[$i], $access)) {
                    return true;
                }
            }

        }

        return false;
    }

}