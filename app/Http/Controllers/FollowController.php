<?php

namespace App\Http\Controllers;

use App\Follow;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function store(){
        $follow = new Follow();
        $follow->user_id = Auth::id();
        $follow->following_user_id = request()->user_id;
        $follow->save();
        return redirect()->back();
    }

    public function destroy(){
        $user = User::findOrFail(request()->user_id);
        $follow = Follow::where(['user_id' => Auth::id(), 'following_user_id' => $user->id])->delete();
        return redirect()->back();
    }
}
