<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinkAlternativeMedia extends Model
{
    protected $connection = 'mysqlmicrosite';
    protected $table = 'linkalternative_media';
    protected $fillable = ['site_id', 'url'];

    public function linkalternative()
    {
        return $this->belongsTo('\App\LinkAlternativeInfo', 'site_id', 'id');
    }
}
