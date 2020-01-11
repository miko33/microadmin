<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use DB;

use App\Game;
use App\Division;
use App\General;
use App\MicrositeInfo;
use App\MicrositePage;
use App\MicrositeMenu;
use App\MicrositeOptions;
use App\MicrositeMedia;
use App\BlogCategory;
use App\BlogMedia;
use App\BlogMenu;
use App\BlogPage;
use App\BlogOptions;

use Validator;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Storage;


use App\DataTables\MicrositesDataTable;
use App\DataTables\micrositeGamesDataTable;

use \Carbon\Carbon;
use Ixudra\Curl\Facades\Curl;


class MicroSiteController  extends Controller
{

    /**
     * The game dataTable instance.
     */
    protected $dataTable;
    protected $dataTable2;


    /**
     * Create a new controller instance.
     *
     * @param  micrositeGamesDataTable  $dataTable
     * @return void
     */
    public function __construct(micrositeGamesDataTable $dataTable, MicrositesDataTable $dataTable2)
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
    public function micrositeList() //microsites list too
    {
        $division_id = explode(',', json_decode(Auth::user()->division)->id);
        $query = Division::OfId($division_id)->get();

        if (request()->get('game') !== null) {
            $game = Game::where('id', request()->get('game'))->first();

            return $this->dataTable2->with('game_id', request()->get('game'))->render('pages.microsite.microsites', ['game' => $game, 'divisions' => $query]);
        }

        return $this->dataTable->with('division', request()->get('id'))->render('pages.game.game', ['divisions' => $query]);

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'game_id' => 'required',
            'hostname' => 'required|unique:mysqlmicrosite.microsite_info,hostname',
            'template' => 'required',
            'title' => 'required',
            'keyword' => 'required',
            'description' => 'required',
            'blogs' => 'required',
            'custom_tag' => 'nullable'
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $available_options = [
            'home_slider_images' => '[]',
            'home_content' => json_encode(['info' => '', 'title' => '', 'subtitle' => '', 'home_image' => '', 'home_header_logo' => '', 'home_logo' => '', 'footer_text' => '', 'content_footer' => '']),
            'footer_buttons' => '[]',
            'menu_order' => '[]'
        ];

        $template_options = [
                '1' => [
                    'home_slider_images', 'home_content', 'footer_buttons', 'menu_order'
                ],
                '2' => [
                    'home_content', 'footer_buttons', 'menu_order'
                ],
                '3' => [
                    'home_slider_images', 'home_content', 'footer_buttons', 'menu_order'
                ],
                '4' => [
                    'home_slider_images', 'home_content', 'footer_buttons', 'menu_order'
                ],
                '5' => [
                    'home_content','menu_order'
                ],
                '6' => [
                    'home_content'
                ]
            ];
            // dd($request->all());

        $newMicrosite = MicrositeInfo::updateOrCreate(
            [
                'game_id' => $request->game_id,
                'hostname' => $request->hostname,
                'template_id' => $request->template
            ],
            [
                'home_title' => $request->title,
                'meta_keywords' => $request->keyword,
                'meta_description' => $request->description,
                'custom_tag' => $request->custom_tag,
                'blogs' => $request->blogs
            ]
        );
        // dd($newMicrosite);

        if(array_key_exists($request->template, $template_options)) {
            foreach ($template_options[$request->template] as $key => $value) {
                if(array_key_exists($value, $available_options)) {
                    $option = new MicrositeOptions;
                    $option->site_id = $newMicrosite->id;
                    $option->option_name = $value;
                    $option->value = $available_options[$value];
                    $option->save();
                }
            }
        }

        return response()->json(['heading' => 'Success!', 'text' => $request->get('hostname').' has been saved.', 'icon' => 'success'], 200);
    }

    public function microsite($hostname)
    {
        $data = MicrositeInfo::where('hostname', $hostname)->first();
        if(!$data) {
            abort(404);
        }
        $data->pages = $data->pages;
        $data->blog =$data->blog;
        $data->options = $data->options;
        $data->menus = $data->menus;
        $data->menuOrder = $data->orderedMenu;

        $microsite =  $data;
        $microsite_breadcrumb = "Site info & page list";
        return view('pages.microsite.microsite', compact('microsite', 'microsite_breadcrumb'));
    }

    public function createpage($hostname)
    {
        $microsite = MicrositeInfo::where('hostname', $hostname)->first();
        $microsite_breadcrumb = "Create and customize a page";
        return view('pages.microsite.micropage', compact('microsite_breadcrumb', 'microsite'));
    }

    public function editpage($hostname, $page_slug)
    {
        $microsite = MicrositeInfo::where('hostname', $hostname)->firstOrFail();
        $page = MicrositePage::where('site_id', $microsite->id)->where('slug', $page_slug)->firstOrFail();
        $microsite_breadcrumb = "Create and customize a page";
        return view('pages.microsite.micropage', compact('microsite_breadcrumb', 'microsite', 'page'));
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
        $check_slug = MicrositePage::where('slug', $slug)->where('site_id', $request->site_id)->orderBy('id', 'asc')->first();

        $request->merge(['slug' => $slug]);
        // dd($request);
        $newpage = MicrositePage::create($request->all());
        if ($check_slug) {
            $newpage->slug = $slug."-".$newpage->id;
            $newpage->save();
        }
        $newpage->microsite->clearCache();
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

        $page = MicrositePage::where('slug', $request->slug)->where('site_id', $request->site_id)->first();

        $slug = $request->newslug;
        $check_slug = MicrositePage::where('slug', $slug)->where('site_id', $request->site_id)->where('id', "!=", $page->id)->orderBy('id', 'asc')->first();
        // dd($check_slug);

        $page->title = $request->title;
        $page->slug = $slug;
        if ($check_slug) {
            $page->slug = $slug."-".$page->id;
        }
        $page->content = $request->content;
        $page->meta_keywords = $request->meta_keywords;
        $page->meta_description = $request->meta_description;
        // dd($page);
        $page->save();

        $page->microsite->clearCache();

        if ($request->ajax()) {
            return response()->json(['heading' => 'Success!', 'text' => 'Page "'.$page->title.'" has been updated.', 'icon' => 'success', 'page' => $page], 200);
        }
    }

    function selectsliderfrommedia(Request $request, $hostname)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $microsite = MicrositeInfo::where('hostname', $hostname)->first();
        $home_slider_images = $microsite->getOptionAttribute('home_slider_images');
        $home_slider_images[] = [
            'url' => $request->image,
            'alt' => ''
        ];
        $microsite->setOptionAttribute('home_slider_images', $home_slider_images);

        return response()->json(['heading' => 'Success!', 'text' => 'New slider has been saved', 'icon' => 'success', 'sliders' => $home_slider_images], 200);
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

        $microsite = MicrositeInfo::where('hostname', $request->hostname)->first();
        // dd($microsite);

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

        if ($request->slider) {
            $home_slider_images = $microsite->getOptionAttribute('home_slider_images');
            $home_slider_images[] = [
                'url' => $imageUrl,
                'alt' => ''
            ];
            $microsite->setOptionAttribute('home_slider_images', $home_slider_images);

            if($imageUrl != 'Invalid image!')
                MicrositeMedia::create(['site_id' => $microsite->id, 'url' => $imageUrl]);

            return response()->json(['heading' => 'Success!', 'text' => 'New slider has been saved', 'icon' => 'success', 'sliders' => $home_slider_images], 200);
        }

        if($imageUrl != 'Invalid image!')
            MicrositeMedia::create(['site_id' => $microsite->id, 'url' => $imageUrl]);

        return response()->json(['location' => $imageUrl], 200);
    }

    public function uploadlocal(Request $request)
    {
      $validator = Validator::make($request->all(), [
           'imagelocal' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
       ]);



       if ($validator->fails()) {
           return response()->json(['heading' => 'Failed!', 'errors' => $validator->errors()]);
       }else{

       $microsite = MicrositeInfo::where('hostname',$request->hostname)->first();

           $fileimage = $request->file('imagelocal');
           $name = $fileimage->getClientOriginalName();
           $path = Storage::put('tmp/'.$name,file_get_contents($fileimage->getPathName()));

           if($path==true){
            $DO = Storage::disk('DO')->put('tmp/'.$name,file_get_contents($fileimage->getPathName()),'public');
            $Urlimage = "https://sgp1.digitaloceanspaces.com/splashimage/tmp/" . $name;
            $home = $microsite->getOptionAttribute('home_slider_images');

            if($DO==true)
               Storage::delete('tmp/'.$name);
               MicrositeMedia::create(['site_id' => $microsite->id, 'url' => $Urlimage]);

               return response()->json(['heading' => 'Success!', 'text' => 'New slider has been saved', 'icon' => 'success'], 200);
           }
       }
    }

    public function delete($site_id)
    {
        $rules = [
            'inputName' => [
            'required',
                Rule::exists('mysqlmicrosite.microsite_info', 'hostname')->where('hostname', $site_id)
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

        $micrositeinfo = MicrositeInfo::where('hostname', $site_id)->first();
        if($micrositeinfo) {
            $micrositeinfo->clearCache();
            $micrositeinfo->options()->delete();
            $micrositeinfo->menus()->delete();
            $micrositeinfo->pages()->delete();
            foreach ($micrositeinfo->images()->get() as $key => $image) {
                Curl::to('https://microcdn.dewacdn.club/y32WsUYnoP48.php')
                    ->withData([
                        'url' => $image->url,
                        'action' => 'delete'
                    ])
                    ->post();
            }
            $micrositeinfo->images()->delete();
            $micrositeinfo->delete();
            return response()->json(['heading' => 'Deleted!', 'text' => request()->get('inputName').' has been deleted.', 'icon' => 'error']);
        } else {
            return response()->json(['heading' => 'Failed to delete!', 'text' => 'Seems like ' . request()->get('inputName').' is not exist in the database.', 'icon' => 'error']);
        }

    }

    public function microsite_update($hostname, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'hostname' => 'required|unique:mysqlmicrosite.microsite_info,hostname,' . $hostname . ',hostname',
            'title' => 'required',
            'keywords' => 'required',
            'description' => 'required',
            'blogs' => 'nullable',
            'custom_tag' => 'nullable'
        ]);

        // dd($request->all(),$validator->errors(),$validator->fails());
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $data = MicrositeInfo::where([
            'hostname' => $hostname,
            'id' => $request->post('id')
        ])->firstOrFail();
        $data->clearCache();
        $data->hostname = $request->post('hostname');
        $data->home_title = $request->post('title');
        $data->meta_keywords = $request->post('keywords');
        $data->meta_description = $request->post('description');
        $data->custom_tag = $request->post('custom_tag');
        $data->blogs = $request->post('blogs');
        $data->save();

        return response()->json([
            'heading' => 'Success',
            'text' => 'Microsite has been succesfully updated',
            'icon' => 'success'
        ]);
    }

    public function pages($hostname, Request $request)
    {
        $microsite = MicrositeInfo::where('hostname', $hostname)->firstOrFail();
        $pages = $microsite->pages()->where('title', 'like', '%' . $request->get('searchQuery') . '%');
        return response()->json($pages->paginate(10));
    }

    public function menus($hostname, Request $request)
    {
        $microsite = MicrositeInfo::where('hostname', $hostname)->firstOrFail();
        $menus = $microsite->menus()->where('title', 'like', '%' . $request->get('searchQuery') . '%');
        return response()->json($menus->paginate(5));
    }

    public function deletepage($hostname, $id)
    {
        $microsite = MicrositeInfo::where('hostname', $hostname)->firstOrFail();
        // dd($microsite->hostname);
        $page = $microsite->pages()->where('id', $id)->first();
        if($page) {
            $page->delete();
            $microsite->clearCache();
            return response()->json(['heading' => 'Deleted!', 'text' => 'Page ' . $page->title.' has been deleted.', 'icon' => 'error']);
        } else {
            return response()->json(['heading' => 'Failed to delete!', 'text' => 'Seems like the page you are trying to delete does not exist in the database.', 'icon' => 'error']);
        }
    }

    public function deletemenu($hostname, $id)
    {
        $microsite = MicrositeInfo::where('hostname', $hostname)->firstOrFail();
        $menus = $microsite->getOptionAttribute('menu_order', true);
        foreach ($menus as $key => $menu) {
            if($menu['id'] == $id) {
                if(is_array(@$menu['children']) && count($menu['children']) > 0) {
                    foreach ($menu['children'] as $key => $children) {
                        $menu = $microsite->menus()->where('id', $children['id'])->first();
                        if($menu) {
                            return response()->json(['heading' => 'Failed to delete!', 'text' => 'The menu you are trying to delete has childrens.', 'icon' => 'error']);
                        }
                    }
                }
                break;
            }
        }
        $menu = $microsite->menus()->where('id', $id)->first();
        if($menu) {
            $menu->delete();
            $microsite->clearCache();
            return response()->json(['heading' => 'Deleted!', 'text' => 'Menu ' . $menu->title.' has been deleted.', 'icon' => 'error']);
        } else {
            return response()->json(['heading' => 'Failed to delete!', 'text' => 'Seems like the menu you are trying to delete does not exist in the database.', 'icon' => 'error']);
        }
    }


    public function storeMenu(Request $request, $hostname)
    {

      // rrr
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'url' => 'required_if:is_external,1',
            'page' => 'required_if:is_external,0',
            'is_external' => 'required:in,0,1'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $microsite = MicrositeInfo::where('hostname', $hostname)->firstOrFail();

        $menu_order = MicrositeOptions::where('site_id', $microsite->id)->where('option_name', 'menu_order')->firstOrFail();
        $ordered_value = json_decode($menu_order->value, true);

        $newMenu = new MicrositeMenu;
        $newMenu->title = $request->title;
        $newMenu->site_id = $microsite->id;
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

        $microsite->clearCache();

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

        $menu = MicrositeMenu::where('id', $request->id)->firstOrFail();
        // dd($request->all(),$menu);
        $menu->title = $request->title;
        $menu->is_external = $request->is_external;
        if($request->is_external == "1") {
            $menu->url = $request->url;
        } else {
            $menu->url = $request->page;
        }
        $menu->save();
        $menu->microsite->clearCache();

        return response()->json(['heading' => 'Success!', 'text' => 'Menus "'. $menu->title.'" has been updated.', 'icon' => 'success']);
    }
    public function getOrderedMenu($hostname)
    {
        $microsite = MicrositeInfo::where('hostname', $hostname)->firstOrFail();
        // dd($microsite->or);

        return response()->json($microsite->orderedMenu, 200);
    }
    public function reorderMenu(Request $request, $hostname)
    {
      // mmm
        // dd($request->order);
        $microsite = MicrositeInfo::where('hostname', $hostname)->firstOrFail();
        $menu_order = MicrositeOptions::where('site_id', $microsite->id)->where('option_name', 'menu_order')->firstOrFail();
        $menu_order->value = json_encode($request->order);
        $menu_order->save();
        $microsite->clearCache();

        return response()->json(['heading' => 'Success!', 'text' => 'Menus for ' . $hostname.' has been reordered.', 'icon' => 'success']);
    }


    public function editoption($hostname, $option)
    {
        $microsite = MicrositeInfo::where('hostname', $hostname)->firstOrFail();
        switch($option) {
            case 'home_content':
                return $this->editHomeContent($microsite);
            break;
            case 'footer_buttons':
                return $this->editFooterButtons($microsite);
            break;
            case 'home_slider_images':
                return $this->manageSliderImage($microsite);
            break;
            default:
                abort(404);
            break;
        }
    }

    public function editHomeContent(MicrositeInfo $microsite)
    {
        $microsite_breadcrumb = "Edit home content of " . $microsite->hostname;
        $option = $microsite->getOptionAttribute('home_content');
        return view('pages.microsite.homecontent', compact('microsite_breadcrumb', 'microsite', 'option'));
    }

    public function updateHomeContent(Request $request, $hostname)
    {
        $microsite = MicrositeInfo::where('hostname', $hostname)->firstOrFail();
        if($microsite->template_id == 1) {
            $option = ['title' => $request->content_title, 'subtitle' => $request->content_subtitle, 'info' => $request->content, 'favicon' => $request->favicon, 'home_header_logo' => $request->home_header_logo, 'display_play_reg_btn' => $request->display_play_reg_btn, 'colorscheme' => $request->colorscheme];
        } else if($microsite->template_id == 2) {
            $option = ['title' => $request->content_title, 'subtitle' => $request->content_subtitle, 'info' => $request->content, 'home_image' => $request->home_image, 'home_header_logo' => $request->home_header_logo, 'home_logo' => $request->home_logo, 'footer_text' => $request->footer_text, 'favicon' => $request->favicon, 'colorscheme' => $request->colorscheme];
        } else if($microsite->template_id == 3) {
            $option = ['title' => $request->content_title, 'info' => $request->content, 'favicon' => $request->favicon, 'home_header_logo' => $request->home_header_logo, 'video_url' => $request->video_url, 'description' => $request->description, 'colorscheme' => $request->colorscheme, 'title2' => $request->content_title2];
        } else if($microsite->template_id == 4) {
            $option = ['title' => $request->content_title, 'info' => $request->content, 'favicon' => $request->favicon, 'home_header_logo' => $request->home_header_logo,  'home_logo' => $request->home_logo, 'titleBottom' => $request->content_title_bottom, 'descriptionBottom' => $request->content_bottom];
        }else if ($microsite->template_id == 5) {
            $option = ['title' => $request->content_title, 'info' => $request->content, 'title2' => $request->content_title2, 'content_footer' => $request->content_footer, 'favicon' => $request->favicon, 'home_header_logo' => $request->home_header_logo, 'home_logo' => $request->home_logo, 'display_play_reg_btn' => $request->display_play_reg_btn , 'colorscheme' => $request->colorscheme];
        }else if ($microsite->template_id == 6) {
            $option = ['title' => $request->content_title, 'info' => $request->content, 'subtitle' => $request->content_subtitle, 'favicon' => $request->favicon, 'home_header_logo' => $request->home_header_logo];
        }
        $microsite->setOptionAttribute('home_content', $option);
        $microsite->clearCache();

        return response()->json(['heading' => 'Success!', 'text' => 'Content updated', 'icon' => 'success']);
    }

    public function editFooterButtons(MicrositeInfo $microsite)
    {
        $microsite_breadcrumb = "Edit footer buttons of " . $microsite->hostname;
        return view('pages.microsite.footerbuttons', compact('microsite_breadcrumb', 'microsite'));
    }

    public function createfooter($hostname, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'url' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $microsite = MicrositeInfo::where('hostname', $hostname)->firstOrFail();
        $option = $microsite->getOptionAttribute('footer_buttons');
        $data = json_decode(json_encode([
            'url' => $request->post('url'),
            'title' => $request->post('title')
        ]));
        array_push($option, $data);
        $microsite->setOptionAttribute('footer_buttons', $option);
        $microsite->clearCache();

        return response()->json(['heading' => 'Success!', 'text' => 'Footer succesfully created.', 'icon' => 'success']);
    }

    public function footer($hostname)
    {
        $microsite = MicrositeInfo::where('hostname', $hostname)->firstOrFail();
        $option = $microsite->getOptionAttribute('footer_buttons');
        return response()->json($option);
    }

    public function deletefooter($hostname, $index)
    {
        $microsite = MicrositeInfo::where('hostname', $hostname)->firstOrFail();
        $option = $microsite->getOptionAttribute('footer_buttons');
        array_splice($option, $index, 1);
        $microsite->setOptionAttribute('footer_buttons', $option);
        $microsite->clearCache();
        return response()->json(['heading' => 'Success!', 'text' => 'Footer succesfully removed.', 'icon' => 'error']);
    }

    public function editfooter($hostname, $index)
    {
        $microsite = MicrositeInfo::where('hostname', $hostname)->firstOrFail();
        $option = $microsite->getOptionAttribute('footer_buttons');
        $data = @$option[$index];
        $data = [
                'title' => [
                    'input_value' => @$data->title
                ], 'url' => [
                    'input_value' => @$data->url
                ]
            ];
        $microsite->clearCache();
        return response()->json($data);
    }

    public function updatefooter($hostname, $index, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'url' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        $microsite = MicrositeInfo::where('hostname', $hostname)->firstOrFail();
        $option = $microsite->getOptionAttribute('footer_buttons');
        $option[$index] = json_decode(json_encode([
            'url' => $request->post('url'),
            'title' => $request->post('title')
        ]));
        $microsite->setOptionAttribute('footer_buttons', $option);
        $microsite->clearCache();
        return response()->json(['heading' => 'Success!', 'text' => 'Footer succesfully updated.', 'icon' => 'success']);
    }

    public function manageSliderImage(MicrositeInfo $microsite)
    {
        $microsite_breadcrumb = "Manage slider images of " . $microsite->hostname;
        $options = $microsite->getOptionAttribute('home_slider_images', false);
        $options2 = $microsite->getOptionAttribute('home_slider_alt', false);
        return view('pages.microsite.sliderimages', compact('microsite_breadcrumb', 'microsite', 'options', 'options2'));
    }

    public function getSliderImage($hostname)
    {
        $microsite = MicrositeInfo::where('hostname', $hostname)->firstOrFail();
        $sliders = $microsite->getOptionAttribute('home_slider_images');

        return response()->json(['sliders' => $sliders]);
    }

    public function deleteSliderImage($hostname, $sliderIndex)
    {
        $microsite = MicrositeInfo::where('hostname', $hostname)->firstOrFail();
        $sliders = $microsite->getOptionAttribute('home_slider_images');
        array_splice($sliders, $sliderIndex, 1);
        $microsite->setOptionAttribute('home_slider_images', $sliders);
        $microsite->clearCache();
        return response()->json(['heading' => 'Success!', 'text' => 'Slider deleted.', 'icon' => 'success']);
    }

    public function editSlider($hostname, Request $request)
    {
        $microsite = MicrositeInfo::where('hostname', $hostname)->firstOrFail();
        $sliders = $microsite->getOptionAttribute('home_slider_images');
        if(array_key_exists($request->key, $sliders)) {
            $data = $sliders[$request->key];
            $sliders[$request->key] = [
                'url' => $data->url,
                'alt' => $request->alt
            ];
            $microsite->setOptionAttribute('home_slider_images', $sliders);
        }
        return response()->json(['heading' => 'Success!', 'text' => 'Slider updated.', 'icon' => 'success']);
    }

    public function getOrderedSlider($hostname)
    {
        $microsite = MicrositeInfo::where('hostname', $hostname)->firstOrFail();
        $sliders = $microsite->getOptionAttribute('home_slider_images');

        return response()->json(['sliders' => $sliders], 200);
    }

    public function reorderSlider(Request $request, $hostname)
    {
        // dd($request->order);
        $reorderedSlider = [];
        $microsite = MicrositeInfo::where('hostname', $hostname)->firstOrFail();
        $sliders = $microsite->getOptionAttribute('home_slider_images');
        foreach ($request->order as $order) {
            $reorderedSlider[] = @$sliders[$order['id']];
        }
        $microsite->setOptionAttribute('home_slider_images', $reorderedSlider);
        $microsite->clearCache();
        return response()->json(['heading' => 'Success!', 'text' => 'Sliders for ' . $hostname.' has been reordered.', 'icon' => 'success']);
    }

    public function images($hostname)
    {
        $microsite = MicrositeInfo::where('hostname', $hostname)->with('images')->firstOrFail();
        $images = $microsite->images()->paginate(5);
        $microsite_breadcrumb = "Manage images of " . $microsite->hostname;
        if (request()->ajax()) {
            return response()->json(['images' => $images], 200);
        }
        return view('pages.microsite.manageimages', compact('microsite', 'images', 'microsite_breadcrumb'));
    }

    public function allPages($hostname)
    {
        $microsite = MicrositeInfo::where('hostname', $hostname)->firstOrFail();
        return response()->json($microsite->pages()->select('id', 'slug', 'title')->get());
    }

    public function deleteImage($hostname, $image_id)
    {
        $microsite = MicrositeInfo::where('hostname', $hostname)->firstOrFail();
        $image = $microsite->images->where('id', $image_id)->first();

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
        $microsite = MicrositeInfo::where('hostname', $hostname)->firstOrFail();
        $option = $microsite->getOptionAttribute('custom_css', true);
        $option['value'] = $request->post('css');
        $microsite->setOptionAttribute('custom_css', $option);
        $microsite->clearCache();

        return response()->json(['heading' => 'Success!', 'text' => 'Custom css succesfully updated.', 'icon' => 'success']);
    }

    public function clearCache($hostname, Request $request)
    {
        $microsite = MicrositeInfo::where('hostname', $hostname)->firstOrFail();
        $status = $microsite->clearCache();
        if(@$status->status == 1) {
            return response()->json(['heading' => 'Success!', 'text' => 'Cache succesfully cleared.', 'icon' => 'success']);
        }
        return response()->json(['heading' => 'Error!', 'text' => 'Failed to clear cache.', 'icon' => 'error']);
    }


    // Blog //
    public function storeBlog(Request $request, $hostname)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'keyword' => 'required',
            'description' => 'required',
            'custom' => 'nullable',
        ]);

        // dd($request->all(),$validator->errors(),$validator->fails());

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $microsite = MicrositeInfo::where('hostname', $hostname)->firstOrFail();

        $blog = new BlogOptions;
        $blog->title = $request->title;
        $blog->site_id = $microsite->id;
        $blog->meta_keywords = $request->keyword;
        $blog->meta_description = $request->description;
        $blog->custom_tag = $request->custom;

        $blog->save();

        return response()->json(['heading' => 'Success!', 'text' => 'Blog "'. $blog->title.'" has been saved.', 'icon' => 'success']);
    }

    public function blog($hostname , $id_blog)
    {
      $blog = BlogOptions::where('id_blog', $id_blog)->first();
      if(!$blog){
        abort(404);
      }

      $title = $blog->title;
      $blog->list = $blog->list;
      $blogs = $blog;
      $microsite = MicrositeInfo::where('hostname', $hostname)->firstOrFail();
      $microsite_breadcrumb = "Manage Blog";

      return view('pages.blogs.manageblog', compact('microsite_breadcrumb','microsite','blogs'));

    }
    public function content(Request $request,$id_blog)
    {
        $blog = BlogOptions::where('id_blog', $id_blog)->firstOrFail();
        $pages = $blog->page()->where('title', 'like', '%' . $request->get('searchQuery') . '%');
        return response()->json($pages->paginate(10));
    }

    public function listmenu(Request $request,$id_blog)
    {
        $blog = BlogOptions::where('id_blog', $id_blog)->firstOrFail();
        // dd($blog->list());
        $menus = $blog->list()->where('title', 'like', '%' . $request->get('searchQuery') . '%');
        return response()->json($menus->paginate(5));
    }

    public function subMenu(Request $request,$id_blog,$id_menu)
    {
      $blog = BlogOptions::where('id_blog', $id_blog)->firstOrFail();
      $submen = $blog->list()->where('type', 'submenu')->where('submenu', $id_menu)->orderBy('sequence_to')->get();
      return response()->json($submen);
    }

    public function allContent($id_blog)
    {
        $blog = BlogOptions::where('id_blog', $id_blog)->firstOrFail();
        return response()->json($blog->page()->select('id_page', 'slug', 'title')->get());
    }

    public function allmenu($id_blog)
    {
        $blog = BlogOptions::where('id_blog', $id_blog)->firstOrFail();
        return response()->json($blog->list()->select('id_menu','url','is_external','title')->get());
    }

    public function createblogpage($hostname, $id_blog)
    {
      $blog = BlogOptions::where('id_blog', $id_blog)->firstOrFail();
      $microsite = MicrositeInfo::where('hostname', $hostname)->firstOrFail();
      $microsite_breadcrumb = "Create and customize a Content";
      return view('pages.blogs.blogpage', compact('microsite_breadcrumb', 'microsite' ,'blog'));
    }

    public function editblogpage($hostname, $id_blog, $page_slug)
    {
      $blog = BlogOptions::where('id_blog', $id_blog)->firstOrFail();
      $microsite = MicrositeInfo::where('hostname', $hostname)->firstOrFail();
      $page = BlogPage::where('id_site', $blog->id_blog)->where('slug', $page_slug)->firstOrFail();
      $microsite_breadcrumb = "Create and customize a Content";
      return view('pages.blogs.blogpage', compact('microsite_breadcrumb', 'microsite' ,'blog','page'));
    }

    public function storecontent(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'title' => 'required',
        'newslug' => 'required|alpha_dash',
        'content' => 'required',
        'meta_keywords' => 'nullable',
        'meta_description' => 'nullable',
        'id_site' => 'required|numeric',
      ]);

      if ($validator->fails()) {
          return response()->json(['errors' => $validator->errors()]);
      }

      $slug = $request->newslug;
      $check_slug = BlogPage::where('slug',$slug)->where('id_site', $request->id_site)->orderBy('id_page', 'asc')->first();

      $request->merge(['slug' => $slug]);

      $newpage = BlogPage::create($request->all());
      if ($check_slug) {
        $newpage->slug = $slug."-".$newpage->id_page;
        $newpage->save();
      }

      // $newpage->microsite->clearCache();
      if ($request->ajax()) {
          return response()->json(['heading' => 'Success!', 'text' => 'Content "'.$newpage->title.'" has been saved.', 'icon' => 'success', 'page' => $newpage], 200);
      }

    }

    public function updatecontent(Request $request, $id_blog)
    {

      $validator = Validator::make($request->all(), [
        'title' => 'required',
        'newslug' => 'required|alpha_dash',
        'content' => 'required',
        'meta_keywords' => 'nullable',
        'meta_description' => 'nullable',
        'id_site' => 'required|numeric',
      ]);

      if ($validator->fails()) {
          return response()->json(['errors' => $validator->errors()]);
      }

      $page = BlogPage::where('slug', $request->slug)->where('id_site',$request->id_site)->first();

      $slug = $request->newslug;
      $check_slug = BlogPage::where('slug', $slug)->where('id_site', $request->id_site)->where('id_page', "!=", $page->id_page)->orderBy('id_page', 'asc')->first();

      $page->title = $request->title;
      $page->slug = $slug;
      if ($check_slug) {
          $page->slug = $slug."-".$page->id_page;
      }
      $page->content = $request->content;
      $page->meta_keywords = $request->meta_keywords;
      $page->meta_description = $request->meta_description;
      // dd($page);
      $page->save();

      if ($request->ajax()) {
          return response()->json(['heading' => 'Success!', 'text' => 'Page "'.$page->title.'" has been updated.', 'icon' => 'success', 'page' => $page], 200);
      }

    }
    public function deletecontent($hostname, $id_blog,$id_page)
    {
        $blog = BlogOptions::where('id_blog', $id_blog)->firstOrFail();
        $page = $blog->page()->where('id_page', $id_page)->first();
        // dd($blog);
        if($page) {
            $page->delete();
            return response()->json(['heading' => 'Deleted!', 'text' => 'Page ' . $page->title.' has been deleted.', 'icon' => 'error']);
        } else {
            return response()->json(['heading' => 'Failed to delete!', 'text' => 'Seems like the page you are trying to delete does not exist in the database.', 'icon' => 'error']);
        }
    }

    public function storelistMenu(Request $request, $id_blog)
    {
      // fff
      $validator= Validator::make($request->all(), [
        'title' => 'required',
        'url' => 'required_if:is_external,1',
        'page' => 'required_if:is_external,0',
        'is_external' => 'required:in,0,1',
      ]);

      if ($validator->fails()) {
          return response()->json(['errors' => $validator->errors()]);
      }

      $blog = BlogOptions::where('id_blog', $id_blog)->firstOrFail();

      $newMenu = new BlogMenu;
      $newMenu->title = $request->title;
      $newMenu->id_site = $blog->id_blog;
      $newMenu->is_external = $request->is_external;
      $newMenu->save();
      return response()->json(['heading' => 'Success!', 'text' => 'Menus "'. $newMenu->title.'" has been saved.', 'icon' => 'success']);

    }

    public function updatelistMenu(Request $request, $id_blog)
    {
        $validator = Validator::make($request->all(), [
            'id_menu' => 'required',
            'title' => 'required',
            'url' => 'required_if:is_external,1',
            'page' => 'required_if:is_external,0',
            'is_external' => 'required:in,0,1'
        ]);

        // dd($request->menuId);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $menu = BlogMenu::where('id_menu', $request->id_menu)->firstOrFail();
        // dd($menu);
        $menu->title = $request->title;
        $menu->is_external = $request->is_external;
        if($request->is_external == "1") {
            $menu->url = $request->url;
        } else {
            $menu->url = $request->page;
        }
        $menu->save();
        return response()->json(['heading' => 'Success!', 'text' => 'Menus "'. $menu->title.'" has been updated.', 'icon' => 'success']);
    }

    public function deletelistmenu($id_blog,$id_menu)
    {
        $blog = BlogOptions::where('id_blog', $id_blog)->firstOrFail();
        $menu = $blog->list()->where('id_menu', $id_menu)->first();
        if($menu) {
            $menu->delete();
            // $blog->clearCache();
            return response()->json(['heading' => 'Deleted!', 'text' => 'Menu ' . $menu->title.' has been deleted.', 'icon' => 'error']);
        } else {
            return response()->json(['heading' => 'Failed to delete!', 'text' => 'Seems like the menu you are trying to delete does not exist in the database.', 'icon' => 'error']);
        }
    }

    public function uploadimg(Request $request)
    {
      $validator = Validator::make($request->all(),[
        'image' => 'required|string'
      ]);
      if ($validator->fails()) {
          return response()->json(['errors' => $validator->errors()]);
      }

      $blog = BlogOptions::where('id_blog', $request->id_blog)->first();

      $fileimage = $request->file('image');
      $DO = Storage::disk('DO')->put('tmp/'.$fileimage,'public');
      $Urlimage = "https://sgp1.digitaloceanspaces.com/splashimage/tmp/" . $fileimage;

    }
}
