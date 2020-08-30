<?php

namespace App\Http\Controllers;

use App\Follow;
use App\Retweet;
use App\Timeline;
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
        $users = $users->whereNotIn('id', $pluck)->take(3);
        
        //filter tweets by returning the tweets of anyone the user follows in ascending order
        // $timeline = Timeline::where('user_id', Auth::id())->orderBy('created_at', 'DESC')->get();
        $timeline = Timeline::whereIn('user_id', $pluck)->orderBy('created_at', 'DESC')->get();
        // dd($timeline);
        //update my timeline by adding the tweets and retweets of the users i followed
        
        
        // following users list
        $followingUsers = Auth::user()->follows->take(3);

        //take all followers
        $followers = Follow::where('following_user_id' , Auth::id())->get();
        //pluck all their id's only for easier query and faster loading
        $followers = $followers->pluck('user_id'); 
        return view('/home', compact(['users', 'timeline', 'followingUsers', 'followers']));
    }
}
