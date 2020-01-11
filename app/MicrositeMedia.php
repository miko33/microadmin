<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MicrositeMedia extends Model
{
    protected $connection = 'mysqlmicrosite';
    protected $table = 'microsite_media';
    protected $fillable = ['site_id', 'url'];

    public function microsite()
    {
        return $this->belongsTo('\App\MicrositeInfo', 'site_id', 'id');
    }
}
