<?php

namespace App;

use App\Like;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{	
	public $timestamps = false;
    
    public function likeable()
    {
        return $this->morphTo();
    }

    public function liker()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
