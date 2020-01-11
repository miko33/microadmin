<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MicrositeInfo;

class APIMicrositeController extends Controller
{
    public function info($hostname)
    {
        $data = MicrositeInfo::where('hostname', $hostname)->first();
        if(!$data) {
            return response()->json([
                'msg' => '404! Data not found'
            ], 404);
        }
        return response()->json($data->apidata);
    }

    public function pages($hostname)
    {
        $data = MicrositeInfo::where('hostname', $hostname)->first();
        if(!$data) {
            return response()->json([
                'msg' => '404! Data not found'
            ], 404);
        }
        return response()->json($data->pages()->select(['slug', 'updated_at'])->get());
    }

    public function pageinfo($hostname, $slug)
    {
        $data = MicrositeInfo::where('hostname', $hostname)->first();
        if(!$data) {
            return response()->json([
                'msg' => '404! Data not found'
            ], 404);
        }
        $page = $data->pages()->where('slug', $slug)->first();
        if(!$page) {
            return response()->json([
                'msg' => '404! Page not found'
            ], 404);
        }
        return response()->json($page->apidata);
    }
}
