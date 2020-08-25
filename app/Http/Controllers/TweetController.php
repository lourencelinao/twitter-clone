<?php

namespace App\Http\Controllers;

use App\User;
use App\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TweetController extends Controller
{
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
        
        Auth::user()->tweets()->create([
            'body' => $data['tweet']
        ]);
        return redirect('/home');
    }
}
