<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CommentBox extends Component
{
    public $comment;
    public function __construct($comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.comment-box');
    }
}
