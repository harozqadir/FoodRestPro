<?php

namespace App\View\Components;

use Illuminate\View\Component;

class RoleSelect extends Component
{
    public $role;
    

    /**
     * Create a new component instance.
     *
     * @param mixed $role
     */
    public function __construct($role = null)
    {
        $this->role = $role;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.role-select');
    }
}
