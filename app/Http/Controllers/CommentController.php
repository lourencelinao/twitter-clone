<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Like;
use App\Retweet;
use App\Timeline;
use App\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function tweet(){
        $tweet = Tweet::findOrFail(request()->tweet_id);
        $data = request()->validate([
            'reply' => 'required | max: 255'
        ]);
        $comment = $tweet->comments()->create([
            'user_id' => Auth::id(),
            'body' => $data['reply']
        ]);

        $comment->timeline()->create([
            'user_id' => Auth::id(),
            'created_at' => $comment->created_at
        ]);

        
        return redirect()->back();
    }

    public function comment(){
        $comment = Comment::findOrFail(request()->comment_id);
        $data = request()->validate([
            'reply' => 'required | max: 255'
        ]);
        $comment = $comment->comments()->create([
            'user_id' => Auth::id(),
            'body' => $data['reply']
        ]);

        $comment->timeline()->create([
            'user_id' => Auth::id(),
            'created_at' => $comment->created_at
        ]);

        
        return redirect()->back();
    }

    public function destroy(Comment $comment){
        //delete on timeline table
        Timeline::where(['timelineable_id' => $comment->id, 'timelineable_type' => 'App\Comment'])->delete();
        //delete all likes of the comment
        Like::where(['likeable_id' => $comment->id, 'likeable_type' => 'App\Comment'])->delete();
        //delete all retweets of the comment
        Retweet::where([
            'retweetable_id' => $comment->id,
            'retweetable_type' => 'App\Comment'
            ])->delete();
        
        //delete comment
        $comment->delete();
        return redirect()->back();
    }
    
}
