<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    protected $fillable = [
        'user_id', 'body'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function likes(){
        return $this->morphMany('App\Like', 'likeable' );
        // return $this->morphMany('App\Like', 'likeable', $type = 'App\Tweet', $id = 'likeable_type', 'user_id' );
    }

    public function retweets(){
        return $this->morphMany('App\Retweet', 'retweetable');
    }
}
