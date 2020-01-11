<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Cache-Control, X-Requested-With, Content-Type');

Route::middleware('auth:api')->get('/test', function (Request $request) {
    return $request->user();
});

Route::get('game/{game_id}/{video_id?}', 'GameController@show');

Route::get('category/{game_id}', 'CategoryController@show');

Route::get('video/{game_id}', 'VideoController@show');

Route::get('microsite/{hostname}/page/{slug}', 'APIMicrositeController@pageinfo');
Route::get('microsite/{hostname}/pages', 'APIMicrositeController@pages');
Route::get('microsite/{hostname}', 'APIMicrositeController@info');

Route::get('linkalternative/{hostname}/page/{slug}', 'APILinkAlternativeController@pageinfo');
Route::get('linkalternative/{hostname}/pages', 'APILinkAlternativeController@pages');
Route::get('linkalternative/{hostname}', 'APILinkAlternativeController@info');

Route::get('livechat/{hostname}/page/{slug}', 'APILiveChatController@pageinfo');
Route::get('livechat/{hostname}/pages', 'APILiveChatController@pages');
Route::get('livechat/{hostname}', 'APILiveChatController@info');