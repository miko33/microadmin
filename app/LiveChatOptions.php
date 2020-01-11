<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LiveChatOptions extends Model
{
    protected $connection = 'mysqlmicrosite';
    protected $table = 'livechat_options';
    protected $fillable = ['site_id', 'option_name', 'value'];

    public function livechat()
    {
        return $this->belongsTo('\App\LiveChatInfo', 'site_id', 'id');
    }
}
