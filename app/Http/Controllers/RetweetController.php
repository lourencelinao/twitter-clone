<?php

namespace App\Http\Controllers;

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
        
        $test = $tweet->retweets()->create([
            'user_id' => Auth::id()
        ]);
        return redirect()->back();
    }
}
