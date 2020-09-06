<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function comments(){
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function likes(){
        return $this->morphMany('App\Like', 'likeable' );
    }

    public function timeline(){
        return $this->morphMany('App\Timeline', 'timelineable');
    }

    public function retweets(){
        return $this->morphMany('App\Retweet', 'retweetable');
    }
}
