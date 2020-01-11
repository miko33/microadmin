<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

use Auth;
use DB;

class DivisionComposer
{

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if (Auth::check()) {
            $ids = explode(',', json_decode(Auth::user()->division)->id);

            $divisions = DB::table('divisions as d')
                            ->join('games as g', 'g.division_id', '=', 'd.id')
                                ->select('d.name', DB::raw('group_concat(g.name) as game'))
                                    ->whereIn('d.id', $ids)
                                        ->groupBy('d.id', 'd.name')
                                            ->get();

            $view->with('divisions', $divisions);
        }
    }
}