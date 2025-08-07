<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public $label;

    public function __construct($label = 'دروستکردن')
    {
        $this->label = $label;
    }

    public function render()
    {
        return view('components.button');
    }

}
