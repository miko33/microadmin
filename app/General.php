<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;
use DB;
use Auth;
use Request;

class General extends Model
{
    //

    public function __construct()
    {

		$this->date	= date('Y-m-d');
		$this->datetime	= date('Y-m-d H:i:s');
		$this->timestamp = date_timestamp_get(date_create());

    }

    public static function breadcrumb($segment)
    {
    	return DB::table('user_modules')->where('permanent_link', $segment)->first();
    }

    public static function page_access($group_id, $page, $type)
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

	public function module($group_id = null)
	{
    	if (Auth::check() && $group_id != null) {

    		$result = DB::table('user_groups')->where('id', $group_id)->first();
			
    		$access = json_decode($result->access)->view;
			
			$menus = [];
			$i = 0;

			$load_parent = DB::table('user_modules')
								->select(['id', 'icon', 'name', 'permanent_link'])
									->where('published', 1)
										->whereNull('parent_id')
											->whereIn('id', explode(',', $access))
												->orderBy('order', 'asc');

			foreach ($load_parent->get() as $main) 
			{
				$menus[$i]['main'] = $main;
				$child = DB::table('user_modules')  
								->select(['id', 'icon', 'name', 'permanent_link'])
									->where('published', 1)
										->whereIn('id', explode(',', $access))
											->where('parent_id', $main->id)
												->orderBy('order', 'asc');
				$menus[$i]['sub'] = $child->get();
				$i++;
			}
			
			return $this->menu($menus);

    	}
	}

	private function menu($menu)
	{
		$html = '<ul class="nav in side-menu">';

		for ($i=0; $i < sizeof($menu); $i++)
		{

			$url = Request::segment(2) != null ? Request::segment(1). '/' .Request::segment(2) : Request::segment(1);

			if (sizeof($menu[$i]['sub']) == 0) {
				$html .= '<li class="'. ($url == $menu[$i]['main']->permanent_link ? 'active' : '') .'">';
					$html .= '<a href="' . url($menu[$i]['main']->permanent_link) . '"><i class="' . $menu[$i]['main']->icon . '"></i> <span class="hide-menu">' . $menu[$i]['main']->name . '</span></a>';
				$html .= '</li>';
			} else {
				$permanent_link = array_map(function($d) { return $d->permanent_link; }, $menu[$i]['sub']->toArray());
				$html .= '<li class="menu-item-has-children'. (in_array($url, $permanent_link) ? ' active' : '') .'">';
					$html .= '<a href="javascript:void(0);"><i class="' . $menu[$i]['main']->icon . '"></i> <span class="hide-menu">' . $menu[$i]['main']->name . '</span></a>';
					$html .= '<ul class="list-unstyled sub-menu">';
						foreach ($menu[$i]['sub'] as $sub) 
						{
							$html .= '<li '. ($url == $sub->permanent_link ? 'class="active"' : '') .'>';
								$html .= '<a href="' . url($sub->permanent_link) . '"><i class="' . $sub->icon . '"></i> ' . $sub->name . '</a>';
							$html .= '</li>';
						}
					$html .= '</ul>';
				$html .= '</li>';
			}
		}

		$html .= '</ul>';

		return $html;
	}


	// YOUTUBE APIv3

	public function duration($time) {

		$date = new \DateTime('00:00');
		$date->add(new \DateInterval($time));

		return $date->format('H:i:s');

	}


}