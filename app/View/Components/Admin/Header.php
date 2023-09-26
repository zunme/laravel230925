<?php

namespace App\View\Components\Admin;

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
	
    public function __construct($title='ADMIN', $left=null, $menu="view")
    {
        $this->title = $title;
		$this->left = $left;
		$this->menu = $menu;
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.header');
    }
}