<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ixudra\Curl\Facades\Curl;

class BlogOptions extends Model
{
    protected $connection = 'mysqlmicrosite';
    protected $table = 'blog_options';
    protected $primaryKey = 'id_blog';
    protected $fillable = ['id_blog','site_id','title','meta_keywords','meta_description','custom_tag'];

    public function microsite()
    {
      return $this->belongsTo('\App\MicrositeInfo', 'site_id', 'id');
    }
    public function page()
    {
      return $this->hasMany('\App\BlogPage','id_site');
    }

    public function list()
    {
      // return $this->hasMany('\App\BlogMenu','id_site');
      return $this->hasOne('\App\BlogMenu','id_site');
    }

    public function media()
    {
      return $this->hasMany('\App\BlogMedia','id_site');
    }

    public function category()
    {
      return $this->hasMany('\App\BlogCategory','id_site');
    }
}
