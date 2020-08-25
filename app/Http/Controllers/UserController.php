<?php

namespace App\Http\Controllers;

use App\Tweet;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(){
        $users = User::all()->except(Auth::id());

        //pluck the id's of anyone the user follows
        $pluck = Auth::user()->follows->pluck('id');
        //add user id into the array of users he followed
        $pluck->push(Auth::id());
        $users = $users->whereNotIn('id', $pluck);
        
        return view('user.index', compact(['users']));
    }

    public function show(User $user){
        //retrieve all the tweets of the user
        $tweets = $user->tweets;

        //take all users except the user 
        $users = User::all()->except($user->id);
        //take all the user id of the all the user follows
        $pluck = $user->follows->pluck('id');
        //add the current auth user to the array
        $pluck->push(Auth::id());
        //retrieve all users that the user did not follow
        $users = $users->whereNotIn('id', $pluck)->take(5);

        $profile = $user;
        return view('user.show', compact(['tweets', 'users', 'profile']));
    }
}
