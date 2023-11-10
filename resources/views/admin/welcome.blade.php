@php
	$user = \Auth::guard('web')->user();
	$assets_version = '20230925150003';
	$menu = [
		["url"=>'request','title'=>'신청내역'],
		["url"=>"partner",'title'=>'파트너'],
		['url'=>'review','title'=>'리뷰'],
	];

@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
	  class="ios ios-translucent-bars ios-translucent-modals device-pixel-ratio-1 device-desktop device-windows"
	  style="
		--white-shade : #dfdfdf
		--f7-safe-area-bottom: 34px;
		 font-size:16px;
		--f7-navbar-bg-color-rgb : 255,255,255;
		--f7-bars-translucent-opacity : 1;
		--f7-navbar-text-color:#444;
		--f7-navbar-height:36px;
		--f7-navbar-link-color:#444;
		--f7-font-family: nanumsquare -apple-system, SF Pro Text, SF UI Text, system-ui, Helvetica Neue, Helvetica, Arial, sans-serif;
		--f7-toolbar-font-size:14px;
		--f7-list-font-size:14px;
			 
		--f7-toolbar-inner-padding-left:16px;
		--f7-toolbar-inner-padding-right:16px;
		--f7-toolbar-link-color: #1e293b;
		color:#1e293b;
		--f7-text-color::#1e293b;
			 
			 
		--f7-ios-primary: #007aff;
		--f7-ios-primary-shade: #0066d6;
		--f7-ios-primary-tint: #298fff;
		--f7-ios-primary-rgb: 0, 122, 255;
		--f7-page-bg-color:#efefef;
			"
>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="robots" content="index">
        <meta property="og:site_name" content="@yield('meta_site_name', env('APP_NAME') )"/>
        <meta property="og:type" content="website"/>

    @if( empty($meta) )
        <meta property="og:title" content="{{ config('app.name', 'app') }}">
        <meta property="og:image" content="{{\URL::to( '/' )}}{{config('site.imglogo')}}">
        <meta property="og:description" content="{{ config('site.description', '') }}">
        <meta name="description" content="{{ config('site.description', '') }}">
        <meta property="og:url" content="{{\URL::to( '/' )}}">
    @else
        <meta name="description" content="{{$meta->description}}"/>
        <meta property="og:title" content="{{$meta->title}}"/>
        <meta property="og:description" content="{{$meta->description}}"/>
        <meta property="og:image" content="{{$meta->image}}"/>
        <meta property="og:url" content="{{$meta->url}}"/>
    @endif
        <meta name="keywords" content="{{ config('site.keywords', '') }}">
		<!-- 강제 https-->
        <!--meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"-->
        
        <title>{{ config('app.name', 'app') }}</title>

		<link rel="icon" href="/favicon.png"/> 
		<link rel="apple-touch-icon" href="/favicon.png"/> 

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://kit.fontawesome.com/483598c605.js" crossorigin="anonymous"></script>
		<link href="https://hangeul.pstatic.net/hangeul_static/css/nanum-square.css" rel="stylesheet" />
		
		<!-- https://developer-1px.github.io/adorable-css/tutorial -->
		<script src="/js/libraries.js?version={{$assets_version}}"></script>
		<script src="/js/tailwind.ext.js?version={{$assets_version}}"></script>

		@vite(['resources/css/app.css', 'resources/js/app.js'])
		<script src="/js/jquery-93b17483.js"></script>
		<!-- GTAG -->
		@if( config('site.gtag_id',null) )
		<script async src="https://www.googletagmanager.com/gtag/js?id={{ config('site.gtag_id','') }}"></script>
		<script>
		  var gtagid = '{{ config('site.gtag_id','') }}' ;
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', '{{ config('site.gtag_id','') }}');
		</script>
		@else
		<script>
			var gtagid =''
		</script>
		@endif
		
		<!-- framework7 -->
		<link rel="stylesheet" href="/css/framework7.css">

		<link rel="stylesheet" href="/css/default.css?version={{$assets_version}}">
		<style>
			.noselect {
				-webkit-touch-callout: none;
				-webkit-user-select: none;
				-khtml-user-select: none;
				-moz-user-select: none;
				-ms-user-select: none;
				user-select: none;
			}
			.square {
				position: relative;
			}
			.square:after {
				content: "";
				display: block;
				padding-bottom: 100%;
			}
			.square .square-inner {
				position: absolute;
				width: 100%;
				height: 100%;
			}
			button{
				width:auto;
			}
			.tw-border-init , .tw-border-init *, .tw-border-init :before, .tw-border-init :after {
                box-sizing: border-box;
				border-width: 0;
				border-style: solid;
				border-color: #e5e7eb;
				border: 0 solid #e5e7eb;
            }
			.tw-solid{
				border-style: solid !important;
			}
            .nanumsquare{
                font-family: 'NanumSquare';
            }
            .nanumsquare-bold{
                font-family: 'NanumSquareBold';
            }
            .nanumsquare-extra-bold{
                font-family: 'NanumSquareExtraBold';
            }
			input.tw-input-search:not([size]) {
				background-image:url('/images/mag.svg');
				background-position: right 0.75rem center !important;
				background-repeat: no-repeat !important;
				background-size: 0.75em 0.75em !important;
				padding-right: 2.5rem !important;
				-webkit-print-color-adjust: exact;
				print-color-adjust: exact;
			}
			.box-shadow {
				--f7-elevation: 0px 3px 5px -1px rgba(0, 0, 0, 0.2),0px 5px 8px 0px rgba(0, 0, 0, 0.14),0px 1px 14px 0px rgba(0, 0, 0, 0.12);
				box-shadow: var(--f7-elevation)!important;
			}
			@media (min-width: 601px) {
				.sheet-modal.smart-select-sheet{
					--f7-elevation: 0px 3px 5px -1px rgba(0, 0, 0, 0.2),0px 5px 8px 0px rgba(0, 0, 0, 0.14),0px 1px 14px 0px rgba(0, 0, 0, 0.12);
					width: 600px;
					left: 50%;
					margin-left: -300px;
					border: 1px solid #c9c9c9 !important;
					box-shadow: var(--f7-elevation)!important;
					border-bottom: none !important;
				}
			}
		</style>
		<style>
		.content-section{
			padding:10px;
		}
		.table-length-hide .dataTables_length{
			display:none;
		}
		.table-filter-hide .dataTables_filter{
			display:none;
		}
		.datatable-table1 input, .datatable-table1 select {
		    display: inline-block;
		}
		.datatable-table1 td, .datatable-table1 th{
			min-width:60px;
		}
		table.dataTable.display>tbody>tr.selectedRow>* {
				box-shadow: inset 0 0 0 9999px rgb(33 150 243 / 20%) !important;
		}
		input[type="number"]::-webkit-outer-spin-button,
		input[type="number"]::-webkit-inner-spin-button {
			-webkit-appearance: none;
			-moz-appearance: none;
			appearance: none;
		}
		input[type=number] {
			-moz-appearance: textfield;
		}
		</style>
		<script src="/js/framework7.custom.js"></script>
		<!-- https://ant.design/components/overview/ -->
		
		<!-- pico  https://picocss.com/docs/ -->
		<!--script src="
		https://cdn.jsdelivr.net/npm/@picocss/pico@1.5.10/css/postcss.config.min.js
		"></script>
		<link href="
		https://cdn.jsdelivr.net/npm/@picocss/pico@1.5.10/css/pico.min.css
		" rel="stylesheet"-->
    </head>
    <body>
		<div id="app" class="">
			<div class="panel panel-right panel-floating panel-resizable panel-init">
				<div class="view">
					<div class="page">
						<div class="toolbar toolbar-bottom" style="--f7-toolbar-height: 46px;">
							<div class="toolbar-inner">
								<a href="#" class="link tw-grow" onClick="logoutAdm()">로그아웃</a>
							</div>
						</div>
						<div class="page-content tw-bg-gray-100 tw-text-black">
							<div class="list accordion-list leftmenu">
								<ul class="custom-menu-list">
									@foreach( $menu as $menuitem)
									<li class="links-list">
										<a href="/djemals/{{$menuitem['url']}}" class="panel-close">{{$menuitem['title']}}</a>
									</li>
									@endforeach
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-left panel-push panel-init" id="leftmenu">
				<div class="page">
				  <div class="toolbar toolbar-bottom" style="--f7-toolbar-height: 46px;">
					  <div class="toolbar-inner">
						  <a href="#" class="link tw-grow" onClick="logoutAdm()">로그아웃</a>
					  </div>
				  </div>
				  <div class="page-content tw-bg-gray-100 tw-text-black">
					<div class="list accordion-list leftmenu">
						<ul class="custom-menu-list">
							@foreach( $menu as $menuitem)
							<li class="links-list">
								<a href="/djemals/{{$menuitem['url']}}" class="panel-close">{{$menuitem['title']}}</a>
							</li>
							@endforeach
						</ul>
					</div>
				  </div>
				</div>
			</div>

			<div class="view view-main view-init safe-areas" data-url="/">
				<div class="navbar">
					<div class="navbar-bg"></div>
					<div class="navbar-inner tw-justify-between">
						<div></div>
						<div class="title" style="position:unset;">
							{{config("app.name")}} 어드민
						</div>
						<div class="tw-m-w-[44px] tw-ml-4">
							<a class="link icon-only panel-open" data-panel="right">
								<i class="fa-solid fa-bars"></i>
							</a>
						</div>
					</div>
				</div>
			</div>
			
		</div>
		
		<script>
			let userdata = @json($user);
			@verbatim
			var routes = [
				{
					path: '/djemals',
					componentUrl: '/djemals/pages/home',
					//beforeEnter:[checkAuth],
					name: 'home',
				},
				{
					path: '/djemals/login',
					componentUrl: '/djemals/pages/login',
					//beforeEnter:[checkAuth],
					name: 'login',
				},
				{
					path: '/djemals/request',
					componentUrl: '/djemals/pages/requestlist',
					name: 'requestlist',
				},
				{
					path: '/djemals/partner',
					componentUrl: '/djemals/pages/partnerlist',
					name: 'partnerlist',
				},
				{
					path: '/djemals/review',
					componentUrl: '/djemals/pages/reviewlist',
					name: 'reviewlist',
				},
					//기본팝업
				{
					path: '/djemals/popup/:type',
					popup: {
						closeByBackdropClick : true,
						componentUrl: '/djemals/popup/view/{{type}}' ,
					},
				},
				{
					path: '/djemals/popup/:type/:id',
					popup: {
						closeByBackdropClick : true,
						componentUrl: '/djemals/popup/view/{{type}}' ,
					},
				},
				{
					path: '/djemals/popup/:type/:id/:subid',
					popup: {
						closeByBackdropClick : true,
						componentUrl: '/djemals/popup/view/{{type}}' ,
					},
				},
			];
			@endverbatim
			let logoimage ;
		</script>
		<script src="/build/js/defaultjs.js?version={{$assets_version}}" defer></script>
		<script src="/js/appinit.js?ver={{\Carbon\Carbon::now()->format('YmdHis')}}" defer></script>
		<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>

		<link href="/css/datatables.css" rel="stylesheet" />
		<script src="/js/datatables.js"></script>
		<script src="/js/helpers.js?version={{$assets_version}}"></script>
		<script src="/js/framework7component.js?version={{$assets_version}}"></script>
	</body>
</html>
		