<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('pageaccess:home,view');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date =null;
        $videos = 0;
        $category = 0;
        $start = null;
        $end = null;
        if ($request->has('game')) {
            $game = $request->get('game');
            $start = $request->get('start');
            $end = $request->get('end');
            $videos = DB::table($game."_videos")->count();
            $category =DB::table($game."_categories")->count();

            $date = DB::table($game."_videos")
            ->select(DB::raw('count(*) count, date(created_at) as date'))
            ->whereDate('created_at','>=',date_format(date_create($start),"Y-m-d"))
            ->whereDate('created_at','<=',date_format(date_create($end),"Y-m-d"))
            ->groupBy(DB::raw('date(created_at)'))
            ->orderBy(DB::raw('date(created_at)'),'ASC')
            ->get();

         // dd($category);
        }

        $ids = explode(',', json_decode(Auth::user()->division)->id);
        $query = DB::table('divisions as d')
        ->join('games as g', 'g.division_id', '=', 'd.id')
        ->select('d.name', DB::raw('group_concat(g.name) as game'))
        ->whereIn('d.id', $ids)
        ->groupBy('d.id', 'd.name')
        ->get();

        return view('home', ['divisions' => $query,'video'=> $videos, 'category' => $category, 'dates' => $date, 'startdate' => $start, 'endDate' => $end ]);
    }
}
