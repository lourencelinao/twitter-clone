<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Like;
use App\Retweet;
use App\Timeline;
use App\User;
use App\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TweetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $users = User::all()->except(Auth::id());

        //pluck the id's of anyone the user follows
        $pluck = Auth::user()->follows->pluck('id');
        //add user id into the array of users he followed
        $pluck = $pluck->push(Auth::id());

        //filter the users by removing the users who he followed by using whereNotIn
        $users = $users->whereNotIn('id', $pluck)->take(5);
        
        //filter tweets by returning the tweets of anyone the user follows
        $tweets = Tweet::whereIn('user_id', $pluck)->latest()->get();
        return view('/tweet', compact(['users', 'tweets']));
    }

    public function store(){
        $data = request()->validate([
            'tweet' => 'required | max: 255'
        ]);
        
        //store in tweet table
        $tweet = Auth::user()->tweets()->create([
            'body' => $data['tweet']
        ]);
        // dd($tweet->id);
        $tweet->timeline()->create(['user_id' => Auth::id(), 'created_at' => $tweet->created_at]);
        
        return redirect()->back();
    }

    public function show(User $user, Tweet $tweet){
        $user = User::findOrFail($user->id);
        $tweet = Tweet::findorFail($tweet->id);
        $comments = $tweet->comments;
        return view('tweet.show', compact(['user', 'tweet', 'comments']));
    }

    public function destroy(Tweet $tweet){

        //delete the retweets of the tweet in the timeline table
        $retweets = $tweet->retweets;
        for ($i=0; $i < count($retweets); $i++) { 
            // $retweets[$i]->timeline()->where('retweetable_id')->delete();
            Timeline::where(['timelineable_id' => $retweets[$i]->id, 'timelineable_type' => 'App\Retweet' ])->delete();
        }
        //delete the retweets of the tweet in the retweet table
        Retweet::where([
            'retweetable_id' => $tweet->id,
            'retweetable_type' => 'App\Tweet'
            ])->delete();
        //delete likes of the tweet
        Like::where('likeable_id', $tweet->id)->delete();

        //delete tweet on the timeline table
        $tweet->timeline()->delete();

        //delete tweet on the tweet table
        $tweet->delete();
        return redirect()->back();
    }
}
