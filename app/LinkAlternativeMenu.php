<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinkAlternativeMenu extends Model
{
    protected $connection = 'mysqlmicrosite';
    protected $table = 'linkalternative_menus';
    protected $fillable = ['site_id', 'title', 'url', 'is_external'];
    protected $appends = ['originalUrl'];

    public function linkalternative()
    {
        return $this->belongsTo('\App\LinkAlternativeInfo', 'site_id', 'id');
    }

    public function getUrlAttribute()
    {
        if($this->attributes['is_external'] == "0")
            return @LinkAlternativePage::find($this->attributes['url'])->slug;
        return $this->attributes['url'];
    }

    public function getOriginalUrlAttribute()
    {
        return $this->attributes['url'];
    }
}
