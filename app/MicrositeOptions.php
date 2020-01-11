<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MicrositeOptions extends Model
{
    protected $connection = 'mysqlmicrosite';
    protected $table = 'microsite_options';
    protected $fillable = ['site_id', 'option_name', 'value'];

    public function microsite()
    {
        return $this->belongsTo('\App\MicrositeInfo', 'site_id', 'id');
    }
}
