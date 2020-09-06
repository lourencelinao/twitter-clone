<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Retweet;
use App\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RetweetController extends Controller
{
    public $guarded = [];
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(){
        $tweet = Tweet::findOrFail(request()->tweet_id);
        
        $retweet = $tweet->retweets()->create([
            'user_id' => Auth::id()
        ]);
        $retweet->timeline()->create([
            'user_id' => Auth::id()
        ]); 
        return redirect()->back();
    }


    public function comment(){
        $comment = Comment::findOrFail(request()->comment_id);
        $comment = $comment->retweets()->create([
            'user_id' => Auth::id()
        ]);
        $comment->timeline()->create([
            'user_id' => Auth::id()
        ]); 
        return redirect()->back();
    }

    public function destroy(Retweet $retweet){    
        $retweet->timeline()->where(['user_id' => Auth::id()])->delete();
        $retweet->delete();

        return redirect()->back();
    }
}
