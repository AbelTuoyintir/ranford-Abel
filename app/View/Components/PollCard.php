<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PollCard extends Component
{
    
    public $poll;
    public $class;
    public $statusAnimation;
    /**
     * Create a new component instance.
     */
    public function __construct($poll, $class = '', $statusAnimation = '')
    {
        $this->poll = $poll;
        $this->class = $class;
        $this->statusAnimation = $statusAnimation;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('Components.poll-card');
    }
}
