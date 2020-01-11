<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use DB;

use App\Game;
use App\Division;
use App\General;
use App\LiveChatMenu;
use App\LiveChatInfo;
use App\LiveChatMedia;
use App\LiveChatPage;
use App\LiveChatOptions;

use Validator;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

use App\DataTables\LiveChatDataTable;
use App\DataTables\liveChatGamesDataTable;

use \Carbon\Carbon;
use Ixudra\Curl\Facades\Curl;


class LiveChatController extends Controller
{

    /**
     * The game dataTable instance.
     */
    protected $dataTable;
    protected $dataTable2;


    /**
     * Create a new controller instance.
     *
     * @param  liveChatGamesDataTable  $dataTable
     * @return void
     */
    public function __construct(liveChatGamesDataTable $dataTable, LiveChatDataTable $dataTable2)
    {

        $this->general = new General;

        $this->dataTable = $dataTable;
        $this->dataTable2 = $dataTable2;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function liveChatList()
    {
        $division_id = explode(',', json_decode(Auth::user()->division)->id);
        $query = Division::OfId($division_id)->get();

        if (request()->get('game') !== null) {
            $game = Game::where('id', request()->get('game'))->first();

            return $this->dataTable2->with('game_id', request()->get('game'))->render('pages.livechat.livechats', ['game' => $game, 'divisions' => $query]);
        }

        return $this->dataTable->with('division', request()->get('id'))->render('pages.game.game', ['divisions' => $query]);

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'game_id' => 'required',
            'hostname' => 'required|unique:mysqlmicrosite.livechat_info,hostname',
            'title' => 'required',
            'keyword' => 'required',
            'description' => 'required',
            'custom_tag' => 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $available_options = [
            'home_content' => json_encode(['api_link' => '', 'title' => '', 'footer_text' => '', 'livechat_url' => '', 'header_color' => '#ffffff', 'font_color' => '#ffffff', 'playnow_color' => '#ffffff', 'register_color' => '#ffffff', 'content' => '', 'title' => '']),
            'menu_order' => '[]'
        ];

        $newLiveChat = LiveChatInfo::updateOrCreate(
            [
                'game_id' => $request->game_id,
                'hostname' => $request->hostname
            ],
            [
                'home_title' => $request->title,
                'meta_keywords' => $request->keyword,
                'meta_description' => $request->description,
                'custom_tag' => $request->custom_tag
            ]
        );

        foreach ($available_options as $key => $options) {
            $option = new LiveChatOptions;
            $option->site_id = $newLiveChat->id;
            $option->option_name = $key;
            $option->value = $options;
            $option->save();
        }
        return response()->json(['heading' => 'Success!', 'text' => $request->get('hostname').' has been saved.', 'icon' => 'success'], 200);
    }

    public function liveChat($hostname)
    {
        $data = LiveChatInfo::where('hostname', $hostname)->first();
        if(!$data) {
            abort(404);
        }
        $data->pages = $data->pages;
        $data->options = $data->options;
        $data->menus = $data->menus;
        $data->menuOrder = $data->orderedMenu;

        $livechat =  $data;
        $microsite_breadcrumb = "Link alternative info & page list";
        return view('pages.livechat.livechat', compact('livechat', 'microsite_breadcrumb'));
    }

    public function createpage($hostname)
    {
        $livechat = LiveChatInfo::where('hostname', $hostname)->first();
        $microsite_breadcrumb = "Create and customize a page";
        return view('pages.livechat.livechatpage', compact('microsite_breadcrumb', 'livechat'));
    }

    public function editpage($hostname, $page_slug)
    {
        $livechat = LiveChatInfo::where('hostname', $hostname)->firstOrFail();
        $page = LiveChatPage::where('site_id', $livechat->id)->where('slug', $page_slug)->firstOrFail();
        $microsite_breadcrumb = "Create and customize a page";
        return view('pages.livechat.livechatpage', compact('microsite_breadcrumb', 'livechat', 'page'));
    }

    public function storepage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'newslug' => 'required|alpha_dash',
            'content' => 'required',
            'meta_keywords' => 'nullable',
            'meta_description' => 'nullable',
            'site_id' => 'required|numeric',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        
        $slug = $request->newslug;
        $check_slug = LiveChatPage::where('slug', $slug)->where('site_id', $request->site_id)->orderBy('id', 'asc')->first();
        
        $request->merge(['slug' => $slug]);
        // dd($request);
        $newpage = LiveChatPage::create($request->all());
        if ($check_slug) {
            $newpage->slug = $slug."-".$newpage->id;
            $newpage->save();
        }
        $newpage->livechat->clearCache();
        if ($request->ajax()) {
            return response()->json(['heading' => 'Success!', 'text' => 'Page "'.$newpage->title.'" has been saved.', 'icon' => 'success', 'page' => $newpage], 200);
        }
    }

    public function updatepage(Request $request, $hostname)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'newslug' => 'required|alpha_dash',
            'content' => 'required',
            'meta_keywords' => 'nullable',
            'meta_description' => 'nullable',
            'site_id' => 'required|numeric',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        
        $page = LiveChatPage::where('slug', $request->slug)->where('site_id', $request->site_id)->first();
        
        $slug = $request->newslug;
        $check_slug = LiveChatPage::where('slug', $slug)->where('site_id', $request->site_id)->where('id', "!=", $page->id)->orderBy('id', 'asc')->first();
        
        $page->title = $request->title;
        $page->slug = $slug;
        if ($check_slug) {
            $page->slug = $slug."-".$page->id;
        }
        $page->content = $request->content;
        $page->meta_keywords = $request->meta_keywords;
        $page->meta_description = $request->meta_description;
        $page->save();

        $page->livechat->clearCache();

        if ($request->ajax()) {
            return response()->json(['heading' => 'Success!', 'text' => 'Page "'.$page->title.'" has been updated.', 'icon' => 'success', 'page' => $page], 200);
        }
    }

    public function uploadimage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|string',
            'hostname' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        
        $livechat = LiveChatInfo::where('hostname', $request->hostname)->first();

        $response = Curl::to('https://microcdn.dewacdn.club/y32WsUYnoP48.php')
            ->withData([
                'image_base64' => $request->image
            ])
            ->asJsonResponse()
            ->post();

        if(is_object($response) && property_exists($response, 'success')) {
            if($response->success == 1) {
                $imageUrl = "https://microcdn.dewacdn.club/" . $response->filename;
            } else {
                $imageUrl = @$response->msg;
            }
        } else {
            $imageUrl= 'Invalid image!';
        }

        if($imageUrl != 'Invalid image!')
            LiveChatMedia::create(['site_id' => $livechat->id, 'url' => $imageUrl]);

        return response()->json(['location' => $imageUrl], 200);
    }


    public function delete($site_id)
    {
        $rules = [
            'inputName' => [
            'required',
                Rule::exists('mysqlmicrosite.livechat_info', 'hostname')->where('hostname', $site_id)
            ],
        ];

        $messages = [
            'required' => 'The hostname field is required.',
            'exists' => 'The selected hostname is invalid.'
        ];

        $validator = Validator::make(request()->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $livechatinfo = LiveChatInfo::where('hostname', $site_id)->first();
        if($livechatinfo) {
            $livechatinfo->clearCache();
            $livechatinfo->options()->delete();
            $livechatinfo->menus()->delete();
            $livechatinfo->pages()->delete();
            $livechatinfo->delete();
            return response()->json(['heading' => 'Deleted!', 'text' => request()->get('inputName').' has been deleted.', 'icon' => 'error']);
        } else {
            return response()->json(['heading' => 'Failed to delete!', 'text' => 'Seems like ' . request()->get('inputName').' is not exist in the database.', 'icon' => 'error']);
        }

    }

    public function liveChat_update($hostname, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'hostname' => 'required|unique:mysqlmicrosite.livechat_info,hostname,' . $hostname . ',hostname',
            'title' => 'required',
            'keywords' => 'required',
            'description' => 'required',
            'custom_tag' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $data = LiveChatInfo::where([
            'hostname' => $hostname,
            'id' => $request->post('id')
        ])->firstOrFail();
        $data->clearCache();
        $data->hostname = $request->post('hostname');
        $data->home_title = $request->post('title');
        $data->meta_keywords = $request->post('keywords');
        $data->meta_description = $request->post('description');
        $data->custom_tag = $request->post('custom_tag');
        $data->save();
        
        return response()->json([
            'heading' => 'Success',
            'text' => 'Link alternative has been succesfully updated',
            'icon' => 'success'
        ]);
    }

    public function pages($hostname, Request $request)
    {
        $livechat = LiveChatInfo::where('hostname', $hostname)->firstOrFail();
        $pages = $livechat->pages()->where('title', 'like', '%' . $request->get('searchQuery') . '%');
        return response()->json($pages->paginate(10));
    }

    public function menus($hostname, Request $request)
    {
        $livechat = LiveChatInfo::where('hostname', $hostname)->firstOrFail();
        $menus = $livechat->menus()->where('title', 'like', '%' . $request->get('searchQuery') . '%');
        return response()->json($menus->paginate(5));
    }

    public function deletepage($hostname, $id)
    {
        $livechat = LiveChatInfo::where('hostname', $hostname)->firstOrFail();
        $page = $livechat->pages()->where('id', $id)->first();
        if($page) {
            $page->delete();
            $livechat->clearCache();
            return response()->json(['heading' => 'Deleted!', 'text' => 'Page ' . $page->title.' has been deleted.', 'icon' => 'error']);
        } else {
            return response()->json(['heading' => 'Failed to delete!', 'text' => 'Seems like the page you are trying to delete does not exist in the database.', 'icon' => 'error']);
        }
    }

    public function deletemenu($hostname, $id)
    {
        $livechat = LiveChatInfo::where('hostname', $hostname)->firstOrFail();
        $menus = $livechat->getOptionAttribute('menu_order', true);
        foreach ($menus as $key => $menu) {
            if($menu['id'] == $id) {
                if(is_array(@$menu['children']) && count($menu['children']) > 0) {
                    foreach ($menu['children'] as $key => $children) {
                        $menu = $livechat->menus()->where('id', $children['id'])->first();
                        if($menu) {
                            return response()->json(['heading' => 'Failed to delete!', 'text' => 'The menu you are trying to delete has childrens.', 'icon' => 'error']);
                        }
                    }
                }
                break;
            }
        }
        $menu = $livechat->menus()->where('id', $id)->first();
        if($menu) {
            $menu->delete();
            $livechat->clearCache();
            return response()->json(['heading' => 'Deleted!', 'text' => 'Menu ' . $menu->title.' has been deleted.', 'icon' => 'error']);
        } else {
            return response()->json(['heading' => 'Failed to delete!', 'text' => 'Seems like the menu you are trying to delete does not exist in the database.', 'icon' => 'error']);
        }
    }


    public function storeMenu(Request $request, $hostname)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'url' => 'required_if:is_external,1',
            'page' => 'required_if:is_external,0',
            'is_external' => 'required:in,0,1'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $livechat = LiveChatInfo::where('hostname', $hostname)->firstOrFail();

        $menu_order = LiveChatOptions::where('site_id', $livechat->id)->where('option_name', 'menu_order')->firstOrFail();
        $ordered_value = json_decode($menu_order->value, true);
        
        $newMenu = new LiveChatMenu;
        $newMenu->title = $request->title;
        $newMenu->site_id = $livechat->id;
        $newMenu->is_external = $request->is_external;
        if($request->is_external == "1") {
            $newMenu->url = $request->url;
        } else {
            $newMenu->url = $request->page;
        }
        $newMenu->save();

        $ordered_value[] = ["id" => $newMenu->id];
        $menu_order->value = json_encode($ordered_value);
        $menu_order->save();
        
        $livechat->clearCache();
        
        return response()->json(['heading' => 'Success!', 'text' => 'Menus "'. $newMenu->title.'" has been saved.', 'icon' => 'success']);
    }
    public function updateMenu(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'url' => 'required_if:is_external,1',
            'page' => 'required_if:is_external,0',
            'is_external' => 'required:in,0,1'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $menu = LiveChatMenu::where('id', $request->id)->firstOrFail();
        $menu->title = $request->title;
        $menu->is_external = $request->is_external;
        if($request->is_external == "1") {
            $menu->url = $request->url;
        } else {
            $menu->url = $request->page;
        }
        $menu->save();
        $menu->livechat->clearCache();

        return response()->json(['heading' => 'Success!', 'text' => 'Menus "'. $menu->title.'" has been updated.', 'icon' => 'success']);
    }
    public function getOrderedMenu($hostname)
    {
        $livechat = LiveChatInfo::where('hostname', $hostname)->firstOrFail();

        return response()->json($livechat->orderedMenu, 200);
    }
    public function reorderMenu(Request $request, $hostname)
    {  
        // dd($request->order);
        $livechat = LiveChatInfo::where('hostname', $hostname)->firstOrFail();
        $menu_order = LiveChatOptions::where('site_id', $livechat->id)->where('option_name', 'menu_order')->firstOrFail();
        $menu_order->value = json_encode($request->order);
        $menu_order->save();
        $livechat->clearCache();

        return response()->json(['heading' => 'Success!', 'text' => 'Menus for ' . $hostname.' has been reordered.', 'icon' => 'success']);
    }
    

    public function editoption($hostname, $option)
    {
        $livechat = LiveChatInfo::where('hostname', $hostname)->firstOrFail();
        switch($option) {
            case 'home_content':
                return $this->editHomeContent($livechat);
            break;
            default:
                abort(404);
            break;
        }
    }

    public function editHomeContent(LiveChatInfo $livechat)
    {
        $microsite_breadcrumb = "Edit home content of " . $livechat->hostname;
        $option = $livechat->getOptionAttribute('home_content');
        return view('pages.livechat.homecontent', compact('microsite_breadcrumb', 'livechat', 'option'));
    }

    public function updateHomeContent(Request $request, $hostname)
    {
        $livechat = LiveChatInfo::where('hostname', $hostname)->firstOrFail();
        $option = [
            'api_link' => $request->api_link,
            'title' => $request->title,
            'footer_text' => $request->footer_text,
            'livechat_url' => $request->livechat_url,
            'content' => $request->content,
            'header_color' => $request->header_color,
            'home_header_logo' => $request->home_header_logo_url,
            'favicon' => $request->favicon_url,
            'font_color' => $request->font_color,
            'playnow_color' => $request->playnow_color,
            'register_color' => $request->register_color
        ];
        $livechat->setOptionAttribute('home_content', $option);
        $livechat->clearCache();

        return response()->json(['heading' => 'Success!', 'text' => 'Content updated', 'icon' => 'success']);
    }
    
    public function images($hostname)
    {
        $livechat = LiveChatInfo::where('hostname', $hostname)->with('images')->firstOrFail();
        $images = $livechat->images()->paginate(5);
        $microsite_breadcrumb = "Manage images of " . $livechat->hostname;
        if (request()->ajax()) {
            return response()->json(['images' => $images], 200);
        }
        return view('pages.livechat.manageimages', compact('livechat', 'images', 'microsite_breadcrumb'));
    }

    public function allPages($hostname)
    {
        $livechat = LiveChatInfo::where('hostname', $hostname)->firstOrFail();
        return response()->json($livechat->pages()->select('id', 'slug', 'title')->get());
    }

    public function deleteImage($hostname, $image_id)
    {
        $livechat = LiveChatInfo::where('hostname', $hostname)->firstOrFail();
        $image = $livechat->images->where('id', $image_id)->first();

        $response = Curl::to('https://microcdn.dewacdn.club/y32WsUYnoP48.php')
            ->withData([
                'url' => $image->url,
                'action' => 'delete'
            ])
            ->asJsonResponse()
            ->post();
        
        if (is_object($response) && property_exists($response, 'success')) {
            if($response->success == 1 || $response->msg == "File not found!") {
                $image->delete();

                return response()->json(['heading' => 'Success!', 'text' => 'Slider deleted.', 'icon' => 'success']);
            }
        }

        return response()->json(['heading' => 'Error!', 'text' => 'Error.', 'icon' => 'time']);
    }

    public function saveCustomCss($hostname, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'css' => 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        $livechat = LiveChatInfo::where('hostname', $hostname)->firstOrFail();
        $option = $livechat->getOptionAttribute('custom_css', true);
        $option['value'] = $request->post('css');
        $livechat->setOptionAttribute('custom_css', $option);
        $livechat->clearCache();
        
        return response()->json(['heading' => 'Success!', 'text' => 'Custom css succesfully updated.', 'icon' => 'success']);        
    }

    // public function clearCache($hostname, Request $request)
    // {
    //     $livechat = LiveChatInfo::where('hostname', $hostname)->firstOrFail();
    //     $status = $livechat->clearCache();
    //     if(@$status->status == 1) {
    //         return response()->json(['heading' => 'Success!', 'text' => 'Cache succesfully cleared.', 'icon' => 'success']);        
    //     }
    //     return response()->json(['heading' => 'Success!', 'text' => 'Failed to clear cache.', 'icon' => 'error']);        
    // }
}

