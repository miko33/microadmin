<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogPage extends Model
{
    protected $connection = 'mysqlmicrosite';
    protected $table = 'blog_page';
    protected $primaryKey ='id_page';
    protected $fillable = ['id_site','slug','title','meta_keywords','meta_description','content','featured_image'];

    public function blog()
    {
      return $this->belongsTo('\App\BlogOptions','id_site', 'id_blog');
    }
}
