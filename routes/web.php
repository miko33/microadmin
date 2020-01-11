<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['ipcheck'])->group(function () {
	Auth::routes();
	Route::post('/passcode', 'Auth\LoginController@passcode')->name('passcode');

	Route::middleware('auth')->group(function () {

		Route::get('/', 'HomeController@index');


		Route::match(['get', 'post'], '/videos/trash', 'VideoController@trash');
		Route::match(['put', 'patch'], '/videos/trash/{video}', 'VideoController@restore');
		Route::delete('/videos/trash/{video}', 'VideoController@delete');


		Route::resources([
			'games' => 'GameController',
			'categories' => 'CategoryController',
			'videos' => 'VideoController',
			'users' => 'UserController',
			'user_groups' => 'UserGroupController',
			'user_modules' => 'UserModuleController',
			// 'documentation' => 'DocumentationController',
			// 'microsites' => 'MicroSiteController'
		]);

		Route::prefix('documentation')->group(function(){
			Route::get('/','DocumentationController@index');
			Route::get('/add','DocumentationController@store')->name('adddoc');
		});

		Route::prefix('microsites')->group(function(){
			Route::get('/', 'MicroSiteController@micrositeList')->name('micrositeList');
			Route::post('/store', 'MicroSiteController@store');
			Route::delete('/delete/{site_id}', 'MicroSiteController@delete')->name('delete');
			Route::post('/uploadimage', 'MicroSiteController@uploadimage')->name('uploadimage');
			Route::post('/uploadlocal', 'MicroSiteController@uploadlocal')->name('uploadlocal');
			Route::post('/uploadimg','MicroSiteController@uploadimg')->name('uploadimg');
			Route::post('/selectsliderfrommedia/{hostname}', 'MicroSiteController@selectsliderfrommedia')->name('selectSliderFromMedia');
			Route::get('/{hostname}', 'MicroSiteController@microsite')->name('microsite');
			Route::get('/{hostname}/pages', 'MicroSiteController@pages')->name('microsite.pages');
			Route::get('/{hostname}/menus', 'MicroSiteController@menus')->name('microsite.menus');
			Route::get('/{hostname}/edit/{option}', 'MicroSiteController@editoption')->name('microsite.editoption');
			Route::delete('/{hostname}/deletepage/{page_id}', 'MicroSiteController@deletepage')->name('microsite.deletepage');
			Route::delete('/{hostname}/deletemenu/{menu_id}', 'MicroSiteController@deletemenu')->name('microsite.deletemenu');
			Route::post('/{hostname}/update', 'MicroSiteController@microsite_update')->name('microsite.update');
			Route::get('/{hostname}/createpage', 'MicroSiteController@createpage')->name('createpage');
			Route::post('/{hostname}/storepage', 'MicroSiteController@storepage')->name('storepage');
			Route::get('/{hostname}/editpage/{page_slug}', 'MicroSiteController@editpage')->name('editpage');
			Route::post('/{hostname}/updatepage/', 'MicroSiteController@updatepage')->name('updatepage');
			Route::post('/{hostname}/storeMenu', 'MicroSiteController@storeMenu')->name('storeMenu');
			Route::patch('/{hostname}/updateMenu', 'MicroSiteController@updateMenu')->name('updateMenu');
			Route::get('/{hostname}/getOrderedMenu', 'MicroSiteController@getOrderedMenu')->name('getOrderedMenu');
			Route::post('/{hostname}/reorderMenu', 'MicroSiteController@reorderMenu')->name('reorderMenu');
			Route::post('/{hostname}/saveCustomCss', 'MicroSiteController@saveCustomCss')->name('saveCustomCss');
			Route::get('/{hostname}/footer', 'MicroSiteController@footer')->name('footer');
			Route::post('/{hostname}/createfooter', 'MicroSiteController@createfooter')->name('createfooter');
			Route::delete('/{hostname}/deletefooter/{index}', 'MicroSiteController@deletefooter')->name('deletefooter');
			Route::put('/{hostname}/updatefooter/{index}', 'MicroSiteController@updatefooter')->name('updatefooter');
			Route::get('/{hostname}/updatefooter/{index}/edit', 'MicroSiteController@editfooter')->name('editfooter');
			Route::get('/{hostname}/getSliderImage/', 'MicroSiteController@getSliderImage')->name('getSliderImage');
			Route::delete('/{hostname}/deleteslider/{sliderIndex}', 'MicroSiteController@deleteSliderImage')->name('deleteSliderImage');
			Route::get('/{hostname}/getorderedslider', 'MicroSiteController@getOrderedSlider')->name('getOrderedSlider');
			Route::post('/{hostname}/reorderslider', 'MicroSiteController@reorderSlider')->name('reorderSlider');
			Route::post('/{hostname}/editSlider', 'MicroSiteController@editSlider')->name('editSlider');
			Route::post('/{hostname}/updatehomecontent/', 'MicroSiteController@updateHomeContent')->name('updateHomeContent');
			Route::get('/{hostname}/images', 'MicroSiteController@images')->name('images');
			Route::get('/{hostname}/allPages', 'MicroSiteController@allPages')->name('fetchAllPages');
			Route::post('/{hostname}/clearCache', 'MicroSiteController@clearCache')->name('clearCache');
			Route::delete('/{hostname}/deleteimage/{image_id}', 'MicroSiteController@deleteImage')->name('deleteImage');
			// blog
			Route::get('/{hostname}/blog/{id_blog}', 'MicroSiteController@blog')->name('blog');
			Route::post('/{hostname}/storeblog', 'MicroSiteController@storeBlog')->name('storeBlog');
			Route::get('/{hostname}/blog/{id_blog}/content', 'MicroSiteController@createblogpage')->name('blogpage');
			Route::get('/{hostname}/blog/{id_blog}/content/{page_slug}', 'MicroSiteController@editblogpage')->name('editblogpage');
			Route::post('/{hostname}/blog/createcontent','MicroSiteController@storecontent')->name('storecontent');
			Route::post('/{hostname}/blog/updatecontent','MicroSiteController@updatecontent')->name('updatecontent');
			Route::delete('/{hostname}/blog/{id_blog}/deletecontent/{id_page}', 'MicroSiteController@deletecontent')->name('deleteblog');
			Route::get('/{id_blog}/content', 'MicroSiteController@content')->name('contentblog');
			Route::get('/{id_blog}/list', 'MicroSiteController@listmenu')->name('list.menu');
			Route::get('/{id_blog}/sub/{id_menu}','MicroSiteController@submenu')->name('sublist.menu');
			Route::get('/{id_blog}/allContent', 'MicroSiteController@allContent')->name('fetchAllContent');
			Route::get('/{id_blog}/allmenu', 'MicroSiteController@allmenu')->name('fetchAllMenu');
			Route::post('/{id_blog}/storeMenus','MicroSiteController@storelistMenu')->name('createMenus');
			Route::patch('/{id_blog}/updateMenus', 'MicroSiteController@updatelistMenu')->name('updateMenus');
			Route::delete('/{id_blog}/deletelistmenu/{menu_id}','MicroSiteController@deletelistmenu')->name('deletelist');
		});

		Route::prefix('linkalternatives')->group(function(){
			Route::get('/', 'LinkAlternativeController@linkAlternativeList')->name('linkAlternativeList');
			Route::post('/store', 'LinkAlternativeController@store');
			Route::delete('/delete/{site_id}', 'LinkAlternativeController@delete')->name('linkAlternative.delete');
			Route::post('/uploadimage', 'LinkAlternativeController@uploadimage')->name('linkAlternative.uploadimage');
			Route::get('/{hostname}', 'LinkAlternativeController@linkAlternative')->name('linkAlternative');
			Route::get('/{hostname}/pages', 'LinkAlternativeController@pages')->name('linkAlternative.pages');
			Route::get('/{hostname}/menus', 'LinkAlternativeController@menus')->name('linkAlternative.menus');
			Route::get('/{hostname}/edit/{option}', 'LinkAlternativeController@editoption')->name('linkAlternative.editoption');
			Route::delete('/{hostname}/deletepage/{page_id}', 'LinkAlternativeController@deletepage')->name('linkAlternative.deletepage');
			Route::delete('/{hostname}/deletemenu/{menu_id}', 'LinkAlternativeController@deletemenu')->name('linkAlternative.deletemenu');
			Route::patch('/{hostname}/update', 'LinkAlternativeController@linkAlternative_update')->name('linkAlternative.update');
			Route::get('/{hostname}/createpage', 'LinkAlternativeController@createpage')->name('linkAlternative.createpage');
			Route::post('/{hostname}/storepage', 'LinkAlternativeController@storepage')->name('linkAlternative.storepage');
			Route::get('/{hostname}/editpage/{page_slug}', 'LinkAlternativeController@editpage')->name('linkAlternative.editpage');
			Route::post('/{hostname}/updatepage/', 'LinkAlternativeController@updatepage')->name('linkAlternative.updatepage');
			Route::post('/{hostname}/storeMenu', 'LinkAlternativeController@storeMenu')->name('linkAlternative.storeMenu');
			Route::patch('/{hostname}/updateMenu', 'LinkAlternativeController@updateMenu')->name('linkAlternative.updateMenu');
			Route::get('/{hostname}/getOrderedMenu', 'LinkAlternativeController@getOrderedMenu')->name('linkAlternative.getOrderedMenu');
			Route::post('/{hostname}/reorderMenu', 'LinkAlternativeController@reorderMenu')->name('linkAlternative.reorderMenu');
			Route::post('/{hostname}/saveCustomCss', 'LinkAlternativeController@saveCustomCss')->name('linkAlternative.saveCustomCss');
			Route::post('/{hostname}/updatehomecontent/', 'LinkAlternativeController@updateHomeContent')->name('linkAlternative.updateHomeContent');
			Route::get('/{hostname}/images', 'LinkAlternativeController@images')->name('linkAlternative.images');
			Route::get('/{hostname}/allPages', 'LinkAlternativeController@allPages')->name('linkAlternative.fetchAllPages');
			Route::post('/{hostname}/clearCache', 'LinkAlternativeController@clearCache')->name('linkAlternative.clearCache');
			Route::delete('/{hostname}/deleteimage/{image_id}', 'LinkAlternativeController@deleteImage')->name('linkAlternative.deleteImage');
		});

		Route::prefix('livechats')->group(function(){
			Route::get('/', 'LiveChatController@liveChatList')->name('liveChatList');
			Route::post('/store', 'LiveChatController@store');
			Route::delete('/delete/{site_id}', 'LiveChatController@delete')->name('liveChat.delete');
			Route::post('/uploadimage', 'LiveChatController@uploadimage')->name('liveChat.uploadimage');
			Route::get('/{hostname}', 'LiveChatController@liveChat')->name('liveChat');
			Route::get('/{hostname}/pages', 'LiveChatController@pages')->name('liveChat.pages');
			Route::get('/{hostname}/menus', 'LiveChatController@menus')->name('liveChat.menus');
			Route::get('/{hostname}/edit/{option}', 'LiveChatController@editoption')->name('liveChat.editoption');
			Route::delete('/{hostname}/deletepage/{page_id}', 'LiveChatController@deletepage')->name('liveChat.deletepage');
			Route::delete('/{hostname}/deletemenu/{menu_id}', 'LiveChatController@deletemenu')->name('liveChat.deletemenu');
			Route::patch('/{hostname}/update', 'LiveChatController@liveChat_update')->name('liveChat.update');
			Route::get('/{hostname}/createpage', 'LiveChatController@createpage')->name('liveChat.createpage');
			Route::post('/{hostname}/storepage', 'LiveChatController@storepage')->name('liveChat.storepage');
			Route::get('/{hostname}/editpage/{page_slug}', 'LiveChatController@editpage')->name('liveChat.editpage');
			Route::post('/{hostname}/updatepage/', 'LiveChatController@updatepage')->name('liveChat.updatepage');
			Route::post('/{hostname}/storeMenu', 'LiveChatController@storeMenu')->name('liveChat.storeMenu');
			Route::patch('/{hostname}/updateMenu', 'LiveChatController@updateMenu')->name('liveChat.updateMenu');
			Route::get('/{hostname}/getOrderedMenu', 'LiveChatController@getOrderedMenu')->name('liveChat.getOrderedMenu');
			Route::post('/{hostname}/reorderMenu', 'LiveChatController@reorderMenu')->name('liveChat.reorderMenu');
			Route::post('/{hostname}/saveCustomCss', 'LiveChatController@saveCustomCss')->name('liveChat.saveCustomCss');
			Route::post('/{hostname}/updatehomecontent/', 'LiveChatController@updateHomeContent')->name('liveChat.updateHomeContent');
			Route::get('/{hostname}/images', 'LiveChatController@images')->name('liveChat.images');
			Route::get('/{hostname}/allPages', 'LiveChatController@allPages')->name('liveChat.fetchAllPages');
			Route::post('/{hostname}/clearCache', 'LiveChatController@clearCache')->name('liveChat.clearCache');
			Route::delete('/{hostname}/deleteimage/{image_id}', 'LiveChatController@deleteImage')->name('liveChat.deleteImage');
		});
	});
});
