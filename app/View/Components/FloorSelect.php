<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FloorSelect extends Component
{
    /**
     * Create a new component instance.
     */
    public $name;
    public $holder;
    public function __construct($name="", $holder="")
    {
        $this->name = $name;
        $this->holder = $holder;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.floor-select');
    }
}
