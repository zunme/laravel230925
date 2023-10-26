<?php
 
namespace App\Http\Controllers;
 
use Inertia\Inertia;
use Inertia\Response;
 
class SvelteController {
    public function index(): Response
    {	
		$move_type =[];
		foreach( config('site.move_type') as $key=>$row){
			$row['id'] = $key;
			$move_type[] = $row;
		}
		return Inertia::render('Index', [
            'title' => 'Laravel 10.., Inertia.js, Svelte, Tailwind CSS',
			'move_type' =>$move_type,
        ]);
		/*
        return Inertia::render('Welcome', [
            'title' => 'Laravel 10, Inertia.js, Svelte, Tailwind CSS',
        ]);
		*/
    }
}