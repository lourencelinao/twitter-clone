<?php

namespace App\Http\Controllers;

use App\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function store(){
        $follow = new Follow();
        $follow->user_id = Auth::id();
        $follow->following_user_id = request()->user_id;
        $follow->save();
        return redirect('/home');
    }
}
