<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogMedia extends Model
{
  protected $connection = 'mysqlmicrosite';
  protected $table = 'blog_media';
  protected $fillable = ['id_site','url'];

  public function blog()
  {
    return $this->belongsTo('\App\BlogOptions','id_site', 'id_blog');
  }
}
