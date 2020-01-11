<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ixudra\Curl\Facades\Curl;

class LiveChatInfo extends Model
{
    protected $connection = 'mysqlmicrosite';
    protected $table = 'livechat_info';
    protected $fillable = ['game_id', 'hostname', 'meta_keywords', 'meta_description', 'home_title', 'custom_tag'];

    public function scopeOfGame($query, $game_id)
    {
        return $query->whereIn('game_id', $game_id);
    }

    public function options()
    {
        return $this->hasMany('\App\LiveChatOptions', 'site_id');
    }

    public function menus()
    {
        return $this->hasMany('\App\LiveChatMenu', 'site_id');
    }

    public function pages()
    {
        return $this->hasMany('\App\LiveChatPage', 'site_id');
    }

    public function images()
    {
        return $this->hasMany('\App\LiveChatMedia', 'site_id');
    }

    public function game()
    {
        return $this->belongsTo('\App\Game', 'game_id', 'id');
    }

    public function getOptionAttribute($option_name, $assoc = false)
    {
        $data = $this->options()->where('option_name', $option_name)->select('value')->first();
        if($data) {
            $data = json_decode($data['value'], $assoc);
        }
        return $data;
    }

    public function setOptionAttribute($option_name, $values)
    {
        $data = $this->options()->where('option_name', $option_name)->first();
        if($data) {
            $data->value = json_encode($values);
            $data->save();
        } else {
            $data = new \App\LiveChatOptions;
            $data->site_id = $this->attributes['id'];
            $data->option_name = $option_name;
            $data->value = json_encode($values);
            $data->save();
        }
        return $data;
    }

    public function getApiMenuDataAttribute()
    {
        return $this->getOrderedMenuAttribute();
    }

    public function getOrderedMenuAttribute()
    {
        $orders = $this->getOptionAttribute('menu_order', true);
        $return_data = []; $idx = 0;
        if($orders) {
            foreach ($orders as $key => $data) {
                $menu = $this->menus()->find($data['id']);
                if($menu) {
                    $return_data[$idx] = [
                        'id' => $menu->id,
                        'title' => $menu->title,
                        'url' => $menu->url,
                        'is_external' => $menu->is_external == 1
                    ];
                    if(array_key_exists('children', $data) && is_array($data['children'])) {
                        $return_data[$idx]['children'] = [];
                        foreach ($data['children'] as $key2 => $children) {
                            $menu = $this->menus()->find($children['id']);
                            if($menu) {
                                $return_data[$idx]['children'][] = [
                                    'id' => $menu->id,
                                    'title' => $menu->title,
                                    'url' => $menu->url,
                                    'is_external' => $menu->is_external == 1
                                ];
                            }
                        }
                    }
                    $idx++;
                }
            }
            return $return_data;
        } else {
            return [];
        }
    }

    public function getApidataAttribute()
    {
        $invalidHtmlTags = [
            "/\<\!DOCTYPE html\>/", "/\<html\>/", "/\<head\>/", "/\<body\>/", "/\<\/body\>/", "/\<\/head\>/", "/\<\/html\>/"
        ];
        $home_content = $this->getOptionAttribute('home_content');
        if(property_exists($home_content, 'info')) {
            $home_content->info = preg_replace($invalidHtmlTags, '', $home_content->info);
        }
        return [
            'hostname' => $this->attributes['hostname'],
            'meta_keywords' => $this->attributes['meta_keywords'],
            'meta_description' => $this->attributes['meta_description'],
            'home_title' => $this->attributes['home_title'],
            'home_content' => $home_content,
            'menus' => $this->getApiMenuDataAttribute(),
            'custom_css' => $this->getOptionAttribute('custom_css'),
            'custom_tags' => $this->attributes['custom_tag'],
            'updated_at' => $this->attributes['updated_at'],
        ];
    }

    public function clearCache()
    {
        // $key = env('API_REFRESH_KEY');
        // $data = Curl::to('http://' . $this->attributes['hostname'] . '/refreshcache/' . base64_encode($this->attributes['hostname'] . ':' . $key))
        //     ->asJsonResponse()
        //     ->allowRedirect(true)
        //     ->get();
        // return $data;
        return false;
    }
}
