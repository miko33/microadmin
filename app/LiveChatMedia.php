<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LiveChatMedia extends Model
{
    protected $connection = 'mysqlmicrosite';
    protected $table = 'livechat_media';
    protected $fillable = ['site_id', 'url'];

    public function livechat()
    {
        return $this->belongsTo('\App\LiveChatInfo', 'site_id', 'id');
    }
}
