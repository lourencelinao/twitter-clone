<?php

namespace App\Http\Controllers;

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

    public function destroy(Retweet $retweet){
        // dd($retweet);
        //check if retweeted tweet is owned by the user
        // if($retweet->user_id == Auth::id()){
        //     //delete retweet in timeline table
        //     $retweet->timeline()->delete();
        //     // //delete tweet in timeline table
        //     // $retweet->retweetable->timeline()->where('user_id', Auth::id())->delete();
        //     //delete retweet in retweet table
        //     $retweet->delete();
        //     //delete tweet in tweet table
        //     // $retweet->retweetable->delete();
        // }else{

        // }
        // dd($retweet);
        $retweet->timeline()->where('user_id', Auth::id())->delete();
        $retweet->delete();

        return redirect()->back();
    }
}
