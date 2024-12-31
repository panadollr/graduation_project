<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FilterDropdown extends Component
{
    public $items;
    public $label;
    public $selectedLabel ;
    public $clickAction;

    /**
     * Create a new component instance.
     */
    public function __construct($items, $label, $selectedLabel = "Tất cả", $clickAction)
    {
        $this->items = $items;
        $this->label = $label;
        $this->selectedLabel = $selectedLabel;
        $this->clickAction = $clickAction;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.filter-dropdown');
    }
}
