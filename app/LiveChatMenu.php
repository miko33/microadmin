<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LiveChatMenu extends Model
{
    protected $connection = 'mysqlmicrosite';
    protected $table = 'livechat_menus';
    protected $fillable = ['site_id', 'title', 'url', 'is_external'];
    protected $appends = ['originalUrl'];

    public function livechat()
    {
        return $this->belongsTo('\App\LiveChatInfo', 'site_id', 'id');
    }

    public function getUrlAttribute()
    {
        if($this->attributes['is_external'] == "0")
            return @LiveChatPage::find($this->attributes['url'])->slug;
        return $this->attributes['url'];
    }

    public function getOriginalUrlAttribute()
    {
        return $this->attributes['url'];
    }
}
