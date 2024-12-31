<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SwitchToggle extends Component
{
    public $id;
    public $checked;
    public $callback;

    /**
     * Create a new component instance.
     */
    public function __construct($id, $checked = false, $callback = '')
    {
        $this->id = $id;
        $this->checked = $checked;
        $this->callback = $callback;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.switch-toggle');
    }
}
