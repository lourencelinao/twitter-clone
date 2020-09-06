<?php

namespace App\Http\Controllers;

use App\Follow;
use App\Retweet;
use App\Timeline;
use App\Tweet;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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
        // $timeline = Timeline::whereIn('user_id', $pluck)->whereHasMorph(
        //     'timelineable',
        //     ['App\Tweet', 'App\Retweet', 'App\Comment']
        // )->orderBy('created_at', 'DESC')->get();
        
        //take all the tweets of the people i followed including my tweets
        $timeline = Timeline::whereIn('user_id', $pluck)->whereHasMorph(
            'timelineable',
            ['App\Tweet']
        )->get();
        
        //take all retweets of the people I follow
        $retweets = Timeline::whereIn('user_id', $pluck)->whereHasMorph(
            'timelineable',
            ['App\Retweet']
        )->get();
        
        //pushing $retweets to $timeline by filtering them based if the user of the retweeted tweet is not followed by the auth user
        //tl;dr it takes all the retweets of the users I follow where the owner of the tweet isnt someone I followed
        for($i = 0; $i < count($retweets); $i++){
            if(!$pluck->contains($retweets[$i]->timelineable->retweetable->user_id)){
                $timeline->push($retweets[$i]);
            }
        }
        //this sorts by created_at but the indexes arent affected, instead of 0, 1, 2, it became 4, 7, 2, 1
        //thus when outputing using for loop, the sorting by created_at is not applied,
        $timeline = $timeline->sortByDesc('created_at');

        //creating new collection for transfering of data
        $sorted = new Collection();

        //transfering of data to new collection so that the indexes are correct, 
        //i.e 0, 1, 2 and the data inside is correct aswell
        foreach($timeline as $timeline){
            $sorted->push($timeline);
        }
        //assigning sorted to timeline for accessing in home blade
        $timeline = $sorted;
  
        // following users list
        $followingUsers = Auth::user()->follows->take(3);

        //take all followers
        $followers = Follow::where('following_user_id' , Auth::id())->get();
        //pluck all their id's only for easier query and faster loading
        $followers = $followers->pluck('user_id'); 
        return view('/home', compact(['users', 'timeline', 'followingUsers', 'followers']));
    }


}
