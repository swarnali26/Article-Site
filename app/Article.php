<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
class Article extends Model
{   
    protected $table='Articles';
    protected $primaryKey='id';
    protected $hidden=['created_at','updated_at'];
     
   protected $fillable =['title','description'];

}