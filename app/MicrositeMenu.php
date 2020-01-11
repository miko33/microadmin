<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MicrositeMenu extends Model
{
    protected $connection = 'mysqlmicrosite';
    protected $table = 'microsite_menus';
    protected $fillable = ['site_id', 'title', 'url', 'is_external'];
    protected $appends = ['originalUrl'];

    public function microsite()
    {
        return $this->belongsTo('\App\MicrositeInfo', 'site_id', 'id');
    }

    public function getUrlAttribute()
    {
        if($this->attributes['is_external'] == "0")
            return @MicrositePage::find($this->attributes['url'])->slug;
        return $this->attributes['url'];
    }

    public function getOriginalUrlAttribute()
    {
        return $this->attributes['url'];
    }
}
