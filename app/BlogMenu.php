<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogMenu extends Model
{
  protected $connection = 'mysqlmicrosite';
  protected $table = 'blog_menu';
  protected $primaryKey = 'id_menu';
  protected $fillable = ['id_site','url','title','sub_menu','is_external','type','sub_menu','sequence_to'];
  protected $appends = ['originalUrl'];


  public function getUrlAttribute()
  {
      if($this->attributes['is_external'] == "0")
          return @BlogPage::find($this->attributes['url'])->slug;
      return $this->attributes['url'];
  }

  public function blog()
  {
    return $this->belongsTo('\App\BlogOptions','id_site', 'id_blog');
  }
  public function getOriginalUrlAttribute()
  {
      return $this->attributes['url'];
  }
}
