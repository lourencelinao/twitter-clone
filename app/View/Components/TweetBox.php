<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TweetBox extends Component
{
    
    public $tweet;
    public function __construct($tweet)
    {
        $this->tweet = $tweet;
    }

    
    public function render()
    {
        return view('components.tweet-box');
    }
}
