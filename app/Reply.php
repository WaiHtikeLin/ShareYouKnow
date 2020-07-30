<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Notifications\Reacted;
use App\Logics\DateFormatter;

class Reply extends Model
{
    public function owner()
    {
        return $this->belongsTo('App\User','user_id');
    }

    public function comment()
    {
        return $this->belongsTo('App\Comment');
    }


        public function likes()
   	{
        return $this->morphMany('App\Like', 'likeable');
    }


    public function like()
    {
        $liker=new Like;
        $liker->user_id=auth()->id();
        $this->likes()->save($liker);

        $this->notifyWithMsg("liked");

        return $this->getLikeStats();
    }

    public function notifyWithMsg($msg)
    {
        $user=auth()->user();
        if($this->user_id!=$user->id)
        {   
            $msg.=" your reply.";
            $source=["name"=>"reply","id"=>$this->id];
        $this->owner->notify(new Reacted($user->getImage(),$user->name." $msg",$source));
    }
    }

    public function unlike()
    {
        $this->likes()->where('user_id',auth()->id())->delete();
        return $this->getLikeStats();
    }

    public function getLikeStats()
    {   
        
        $count=$this->likes()->count();
        
        if($count)
        {            
            if($count > 1)
                return "$count likes";
            else
                return "$count like"; 
            
        }
        return null;            
    }

    public function isLiked()
    {
        return $this->likes()->where('user_id',auth()->id())->exists() ? 'Liked' : 'Like';
    }

    public function getCreatedAtAttribute($value)
    {
        $d=new DateFormatter(strtotime($value));
        return $d->getFormattedTime();
    }
    
}
