<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    protected $connection = 'mysqlmicrosite';
    protected $table ='blog_category';
    protected $fillable = ['id_site','name_category','slug'];

    public function blog()
    {
      return $this->belongsTo('\App\BlogOptions','id_site', 'id_blog');
    }
}
