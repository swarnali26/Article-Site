<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
class User extends Model
{   
    protected $table='Users';
    protected $primaryKey= 'userid';
    protected $fillable=['firstname','lastname','email','password','phone'] ; 
   
    public function article()
    {
        return $this->hasMany('App\Article','userid','userid');
    }
}