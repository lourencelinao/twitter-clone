<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $fillable = [
        'user_id', 'following_user_id'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
