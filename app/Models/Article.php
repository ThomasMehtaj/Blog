<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public function likes(){

        return $this->belongsToMany(User::class,'likes');
    }
}
