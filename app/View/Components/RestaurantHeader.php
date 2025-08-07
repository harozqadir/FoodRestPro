<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RestaurantHeader extends Component
{
    /**
     * Create a new component instance.
     */
     public $title;
    public $subtitle;
    public $icon;
    public $actionRoute;
    public $actionText;
    public $actionIcon;

    public function __construct($title, $subtitle, $icon = null, $actionRoute = null, $actionText = null, $actionIcon = null)
    {
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->icon = $icon;
        $this->actionRoute = $actionRoute;
        $this->actionText = $actionText;
        $this->actionIcon = $actionIcon;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.restaurant-header');
    }
}
