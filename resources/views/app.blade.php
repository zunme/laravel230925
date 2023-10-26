@php
	$user = \Auth::guard('web')->user();
	$assets_version = '20230925150003';
@endphp
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	  
	<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
	<script src="https://kit.fontawesome.com/483598c605.js" crossorigin="anonymous"></script>
	<link href="https://hangeul.pstatic.net/hangeul_static/css/nanum-square.css" rel="stylesheet" />

	<!-- https://developer-1px.github.io/adorable-css/tutorial -->
	<script src="/js/libraries.js?version={{$assets_version}}"></script>
	<script src="/js/tailwind.ext.js?version={{$assets_version}}"></script>
	
    @vite(['resources/js/svelte.js'])
	<link rel="modulepreload" href="https://baselaravel.run.goorm.site/js/_commonjsHelpers-de833af9.js" />
	<link rel="modulepreload" href="https://baselaravel.run.goorm.site/js/app-59af0827.js" />
	<script type="module" src="https://baselaravel.run.goorm.site/js/app-59af0827.js" data-navigate-track="reload"></script>
	<script src="/js/jquery-93b17483.js"></script>
	  
    @inertiaHead
  </head>
  <body>
    @inertia
  </body>
</html>