<?php

namespace App\Http\Controllers;

use App\Like;
use App\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function store(){
        $tweet = Tweet::findOrFail(request()->tweet_id);

        $user = $tweet->likes()->create([
            'user_id' => Auth::id()
        ]);
        
        return redirect()->back();
    }

    public function destroy(){
        $tweet = Tweet::findOrFail(request()->tweet_id);
        $like = Like::where(['likeable_id' => $tweet->id, 'user_id' => Auth::id()])->delete();
        return redirect()->back();
    }
}
