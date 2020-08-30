<?php

namespace App\View\Components;

use Illuminate\View\Component;

class UserBox extends Component
{

    public $user;
    public $followers;
    public function __construct($user, $followers)
    {
        $this->user = $user;
        $this->followers = $followers;
    }


    public function render()
    {
        return view('components.user-box');
    }
}
