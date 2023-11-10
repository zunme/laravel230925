<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CalendarCustom extends Component
{
    /**
     * Create a new component instance.
     */
    public $calendar_name;
    public $calendar_holder;
    public function __construct($name="move_date",$holder="이사날짜 선택")
    {
        $this->calendar_name = $name;
        $this->calendar_holder = $holder;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.calendar-custom');
    }
}
