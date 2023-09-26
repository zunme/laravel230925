<?php

namespace App\View\Components\Front;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header extends Component
{
    /**
     * Create a new component instance.
     */
	public $left;
	public $title;
	public $menu;
	
    public function __construct($title='', $left=null, $menu="view")
    {
		//if($title=='') $title = config('app.name');
        $this->title = $title;
		$this->left = $left;
		$this->menu = $menu;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.front.header');
    }
}
