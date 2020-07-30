<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Notifications\Reacted;
use App\Logics\DateFormatter;

class Post extends Model
{   

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

    public function getCommentStats()
    {   
        
        $count=$this->comments()->count();
        
        if($count)
        {            
            if($count > 1)
                return "$count comments&nbsp;&nbsp;";
            else
                return "$count comment&nbsp;&nbsp;"; 
            
        }
        return null;            
    }

    public function getSaveStats()
    {   
        
        $count=$this->saves()->count();
        
        if($count)
        {            
            if($count > 1)
                return "$count saves";
            else
                return "$count save"; 
            
        }
        return null;            
    }

    public function getStats()
    {
        return $this->getLikeStats().$this->getCommentStats().$this->getSaveStats();
    }


	public function owner()
    {
        return $this->belongsTo('App\User','user_id');
    }

    public function likes()
    {
        return $this->morphMany('App\Like', 'likeable');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function saves()
    {
        return $this->hasMany('App\Save');
    }

    public function raters()
    {
        return $this->belongsToMany('App\User', 'rates')->withPivot('rate_type', 'rate_value')->withTimestamps();
    }

    public function isUserRated()
    {
        return $this->belongsToMany('App\User', 'rates')->withPivot('rate_type','rate_value')->wherePivot('user_id', auth()->id());
    }


    public function getRating()
    {   
        
        $rater=$this->raters()->where('id',auth()->id())->first();

        return $rater ? $rater->pivot->rate_type : "Rate";

    }

    public function getUserRating($id)
    {   
        
        $rater=$this->raters()->where('id',$id)->first();

        return $rater ? "Rated ".$rater->pivot->rate_type : "";

    }

    public function getAvgRating()
    {
        if($this->raters()->exists())
        {
        
            $avgRating=$this->raters()->avg("rate_value");

            return "Rating $avgRating";
        }

        return "Not rated yet";
    }

    public function isLiked()
    {
        return $this->likes()->where('user_id',auth()->id())->exists() ? 'Liked' : 'Like';
    }

    public function isSaved()
    {
        return $this->saves()->where('user_id',auth()->id())->exists() ? 'Saved' : 'Save';
    }
    public function like()
    {
        $liker=new Like;
        $liker->user_id=auth()->id();
        $this->likes()->save($liker);

        

        $this->notifyWithMsg('liked');

        return $this->getStats();
    }

    public function notifyWithMsg($msg)
    {
        $user=auth()->user();
        if($this->user_id!=$user->id)
        {   
            $msg.=" your post.";
            $source=["name"=>"post","id"=>$this->id];
        $this->owner->notify(new Reacted($user->getImage(),$user->name." $msg",$source));
    }
    }

    public function unlike()
    {
        $this->likes()->where('user_id',auth()->id())->delete();
        return $this->getStats();
    }

    public function savepost()
    {
        $saver=new Save;
        $saver->user_id=auth()->id();
        $this->saves()->save($saver);

        $this->notifyWithMsg('saved');

        return $this->getStats();
    }

    public function unsave()
    {
        $this->saves()->where('user_id',auth()->id())->delete();
        return $this->getStats();
    }

    public function getComments()
    {
         return $this->comments()->with('owner:id,name','post:id')->orderBy('created_at','desc')->get();
    }
    
    public function savers()
    {
        return $this->belongsToMany('App\User', 'saves');
    }

    public function getCreatedAtAttribute($value)
    {   
        $d=new DateFormatter(strtotime($value));
        return $d->getFormattedTime();
    }


}
