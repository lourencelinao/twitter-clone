<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retweet extends Model
{
    public $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function retweetable(){
        return $this->morphTo();
    }

    public function timeline(){
        return $this->morphMany('App\Timeline', 'timelineable');
    }
}
