<?php

namespace App\Http\Controllers;

use App\Follow;
use App\Timeline;
use App\Tweet;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
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
        $pluck->push(Auth::id());
        $users = $users->whereNotIn('id', $pluck);
        $followingUsers = Auth::user()->follows->take(3);
        return view('user.index', compact(['users', 'followingUsers']));
    }

    public function show(User $user){
        // //retrieve all the tweets of the user
        // $tweets = $user->tweets()->latest()->get();

        //take all users except the user 
        $users = User::all()->except($user->id);
        //take all the user id of the all the user follows
        $pluck = Auth::user()->follows->pluck('id');
        //add the current auth user to the array
        $pluck->push(Auth::id());
        //retrieve all users that the user did not follow
        $users = $users->whereNotIn('id', $pluck)->take(5);
        //retrieve likes
        $likes = $user->likes->sortByDesc('created_at');
        $profile = $user;
        $following = Auth::user()->follows;

        //take all followers
        $followers = Follow::where('following_user_id' , Auth::id())->get();
        //pluck all their id's only for easier query and faster loading
        $followers = $followers->pluck('user_id'); 

        //filter tweets by returning the tweets and retweets of the user in ascending order
        $timeline = Timeline::where('user_id', $user->id)->orderBy('created_at', 'DESC')->get();
        return view('user.show', compact(['timeline', 'users', 'profile', 'following', 'likes', 'followers']));
    }

    public function update(User $user){
        $data = request()->validate([
            'name' => 'required | max:255',
            'description' => 'max: 255'
        ]);
        $user = User::findOrFail($user->id);
        $user->update($data);
        return redirect()->back();
        
    }

    public function following(User $user){
        $followingUsers = $user->follows;
        $users = User::all()->except($user->id);
        $pluck = $user->follows->pluck('id');
        $pluck->push($user->id);
        $users = $users->whereNotIn('id', $pluck)->take(5);
        return view('user.show-following', compact(['followingUsers', 'users']));
    }

    public function followers(User $user){
        //take followers collection
        $followers = Follow::where('following_user_id', $user->id)->get();
        //initialize array
        $pluck = array();
        //retrieve user id's
        for($i = 0; $i < count($followers); $i++){
            array_push($pluck, $followers[$i]->user_id);
        }
        //retrieve user class
        $followers = User::whereIn('id', $pluck)->get();
        
        return view('user.show-followers', compact('followers'));
    }
}
