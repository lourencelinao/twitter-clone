<?php

namespace App\View\Components;

use Illuminate\View\Component;

class RetweetBox extends Component
{
    public $retweet;
    public function __construct($retweet)
    {
        $this->retweet = $retweet;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.retweet-box');
    }
}
