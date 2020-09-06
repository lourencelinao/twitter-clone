<?php

namespace App\Http\Controllers;

use App\Follow;
use App\Retweet;
use App\Timeline;
use App\Tweet;
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
        // //take all tweet id of the followed user inside the timeline table
        // $pluck = $user->tweets->pluck('id');
        // //take all the tweets using the plucked id
        // $timeline = Timeline::whereIn('timelineable_id', $pluck)->where('timelineable_type', 'App\Tweet')->get();
        // //delete tweet inside timeline
        // for($i = 0; $i < count($timeline); $i++){
        //     $timeline[$i]->delete();
        // }
        //delete follow
        Follow::where(['user_id' => Auth::id(), 'following_user_id' => $user->id])->delete();
        return redirect()->back();
    }


}
