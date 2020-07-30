<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Notifications\Reacted;
use App\Logics\DateFormatter;

class Comment extends Model
{
    public function owner()
    {
        return $this->belongsTo('App\User','user_id');
    }

    public function post()
    {
        return $this->belongsTo('App\Post');
    }


    public function replies()
    {
        return $this->hasMany('App\Reply');
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

        return $this->getStats();
    }

    public function notifyWithMsg($msg)
    {
        $user=auth()->user();
        if($this->user_id!=$user->id)
        {   
            $msg.=" your commennt.";
            $source=["name"=>"comment","id"=>$this->id];
        $this->owner->notify(new Reacted($user->getImage(),$user->name." $msg",$source));
    }
    }

    public function unlike()
    {
        $this->likes()->where('user_id',auth()->id())->delete();
        return $this->getStats();
    }

    public function getLikeStats()
    {   
        
        $count=$this->likes()->count();
        
        if($count)
        {            
            if($count > 1)
                return "$count likes&nbsp;&nbsp;";
            else
                return "$count like&nbsp;&nbsp;"; 
            
        }
        return null;            
    }

    public function isLiked()
    {
        return $this->likes()->where('user_id',auth()->id())->exists() ? 'Liked' : 'Like';
    }

    public function getReplyStats()
    {   
        
        $count=$this->replies()->count();
        
        if($count)
        {            
            if($count > 1)
                return "$count replies";
            else
                return "$count reply"; 
            
        }
        return null;            
    }

    public function getReplies()
    {
         return $this->replies()->with('owner:id,name','comment:id')->orderBy('created_at','desc')->get();
    }

    public function getStats()
    {
         
        return $this->getLikeStats().$this->getReplyStats();
    
    }

    public function getCreatedAtAttribute($value)
    {
        $d=new DateFormatter(strtotime($value));
        return $d->getFormattedTime();
    }
}
