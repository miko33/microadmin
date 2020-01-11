<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinkAlternativeOptions extends Model
{
    protected $connection = 'mysqlmicrosite';
    protected $table = 'linkalternative_options';
    protected $fillable = ['site_id', 'option_name', 'value'];

    public function linkalternative()
    {
        return $this->belongsTo('\App\LinkAlternativeInfo', 'site_id', 'id');
    }
}
