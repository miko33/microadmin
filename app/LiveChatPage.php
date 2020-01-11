<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LiveChatPage extends Model
{
    protected $connection = 'mysqlmicrosite';
    protected $table = 'livechat_pages';
    protected $fillable = ['title', 'content', 'site_id', 'slug', 'meta_keywords', 'meta_description'];

    public function livechat()
    {
        return $this->belongsTo('\App\LiveChatInfo', 'site_id', 'id');
    }

    public function getApidataAttribute()
    {
        $invalidHtmlTags = [
            "/\<\!DOCTYPE html\>/", "/\<html\>/", "/\<head\>/", "/\<body\>/", "/\<\/body\>/", "/\<\/head\>/", "/\<\/html\>/"
        ];
        $content = preg_replace($invalidHtmlTags, '', $this->attributes['content']);

        return [
            'slug' => $this->attributes['slug'],
            'title' => $this->attributes['title'],
            'content' => $content,
            'meta_keywords' => (strlen($this->attributes['meta_keywords']) > 0 ? $this->attributes['meta_keywords'] : $this->microsite->meta_keywords),
            'meta_description' => (strlen($this->attributes['meta_description']) > 0 ? $this->attributes['meta_description'] : $this->microsite->meta_description),
            'created_at' => $this->attributes['created_at']
        ];
    }
}
