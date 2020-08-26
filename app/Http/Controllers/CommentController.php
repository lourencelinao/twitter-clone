<?php

namespace App\Http\Controllers;

use App\Tweet;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function homeComment(Tweet $tweet){
        $tweet = Tweet::findOrFail($tweet->id);

        return view('comment.homecomment');
    }
}
