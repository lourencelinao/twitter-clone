<?php

namespace App\Http\Controllers;

use App\Retweet;
use App\Tweet;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::all()->except(Auth::id());

        //pluck the id's of anyone the user follows
        $pluck = Auth::user()->follows->pluck('id');
        //add user id into the array of users he followed
        $pluck = $pluck->push(Auth::id());

        //filter the users by removing the users who he followed by using whereNotIn
        $users = $users->whereNotIn('id', $pluck)->take(5);
        
        //filter tweets by returning the tweets of anyone the user follows
        $timeline = [];
        $tweets = Tweet::whereIn('user_id', $pluck)->latest()->get();
        // array_push($timeline, $tweets);
        // // dd($timeline[0][0]);
        // $retweets = Retweet::whereIn('user_id', $pluck)->latest()->get();
        // array_push($timeline, $retweets);
        // // dd($timeline);
        // $timeline = $timeline->collapse();
        // dd($timeline);
        // dd($retweets[0]->retweetable);
        return view('/home', compact(['users', 'tweets']));
    }
}
