@php
	$user = \Auth::guard('web')->user();
	$assets_version = '20230925150002';
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
	  class="ios ios-translucent-bars ios-translucent-modals device-pixel-ratio-1 device-desktop device-windows"
	  style="
		--white-shade : #dfdfdf
		--f7-safe-area-bottom: 34px;font-size:16px;
		--f7-navbar-bg-color-rgb : var(--f7-theme-color-rgb);
		--f7-navbar-text-color:#dfdfdf;
		--f7-navbar-height:48px;
		--f7-navbar-link-color:#dfdfdf;
		--f7-font-family: nanumsquare -apple-system, SF Pro Text, SF UI Text, system-ui, Helvetica Neue, Helvetica, Arial, sans-serif;
		--f7-toolbar-font-size:14px;
		--f7-list-font-size:14px;
		--f7-list-item-min-height:36px;
			 
		--f7-toolbar-inner-padding-left:16px;
		--f7-toolbar-inner-padding-right:16px;
		--f7-toolbar-link-color: #1e293b;
		color:#1e293b;
		--f7-text-color::#1e293b;
			 
			 
		--f7-ios-primary: #007aff;
		--f7-ios-primary-shade: #0066d6;
		--f7-ios-primary-tint: #298fff;
		--f7-ios-primary-rgb: 0, 122, 255;

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
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        
        <title>{{ config('app.name', 'app') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://kit.fontawesome.com/483598c605.js" crossorigin="anonymous"></script>
		<link href="https://hangeul.pstatic.net/hangeul_static/css/nanum-square.css" rel="stylesheet" />
		
		<!-- https://developer-1px.github.io/adorable-css/tutorial -->
		<script src="https://unpkg.com/adorable-css"></script>
        
		<script src="https://cdn.tailwindcss.com"></script>
		<script>
            tailwind.config ={
                prefix: 'tw-',
                theme: {
                    screens: {
                        sm: '480px',
                        md: '768px',
                        lg: '976px',
                        xl: '1440px',
                        '2xl':'1800px'
                    },
									colors:{
					light: {
						50:  '#fdfdfd',
						100: '#fcfcfc',
						200: '#fafafa',
						300: '#f8f9fa',
						400: '#f6f6f6',
						500: '#f2f2f2',
						600: '#f1f3f5',
						700: '#e9ecef',
						800: '#dee2e6',
						900: '#dde1e3',
					  },
					  dark: {
						50: '#4a4a4a',
						100: '#3c3c3c',
						200: '#323232',
						300: '#2d2d2d',
						400: '#222222',
						500: '#1f1f1f',
						600: '#1c1c1e',
						700: '#1b1b1b',
						800: '#181818',
						900: '#0f0f0f',
					  },
					'mandy': {
						'50': '#fef2f3',
						'100': '#fde6e7',
						'200': '#fbd0d5',
						'300': '#f7aab2',
						'400': '#f27a8a',
						'500': '#ea546c',
						'600': '#d5294d',
						'700': '#b31d3f',
						'800': '#961b3c',
						'900': '#811a39',
						'950': '#48091a',
					},
					'picton-blue': {
						'50': '#f0f8fe',
						'100': '#ddeefc',
						'200': '#c3e3fa',
						'300': '#9bd1f5',
						'400': '#6bb8ef',
						'500': '#53a1ea',
						'600': '#337fdd',
						'700': '#2a6acb',
						'800': '#2856a5',
						'900': '#264b82',
						'950': '#1b2e50',
					},

				},
                    extend: {},
                },
                corePlugins: {
                    preflight: false,
                },
                plugins: [],
                important: true,
            }
        </script>
		<style>
			.tw-border-init , .tw-border-init *, .tw-border-init :before, .tw-border-init :after {
                box-sizing: border-box;
				border-width: 0;
				border-style: solid;
				border-color: #e5e7eb;
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
		</style>
		@vite(['resources/css/app.css', 'resources/js/app.js'])
		
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
		<style>
			button{
				width:auto;
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
		<div id="app" class="tw-border-init">
			<div class="panel panel-right panel-floating panel-resizable panel-init">
				<div class="view">
					<div class="page">
						<div class="toolbar toolbar-top">
							<div class="toolbar-inner">
							@if( $user )
								<a href="/my" class="link panel-close">
									<div>
										<i class="fa-solid fa-user tw-p-[5px] tw-rounded-[50%] tw-text-white bg-color-primary"></i> {{$user->name}}님
									</div>
								</a>
							@else
								<a href="/join" class="link menutop-left panel-close"><i class="fa-solid fa-signature tw-mr-[8px]"></i> 가입하기</a>
								<a href="/login" class="link menutop-right panel-close"><i class="fa-solid fa-right-to-bracket tw-mr-[8px]"></i> 로그인</a>
							@endif
							</div>
						</div>
						<div class="toolbar toolbar-bottom">
							<div class="toolbar-inner tw-justify-center">
								<a href="/" class="link panel-close tw-w-[50%]">
									<!--img class="tw-h-6 tw-mr-2" src="{{config('site.imglogo')}}" alt="logo" /--> 
									<div class="tw-h-6 tw-leading-[27px]">{{ config('app.name', 'app') }}</div>
								</a>
								@if( $user )
								<a href="#" class="link panel-close tw-flex tw-flex-col tw-leading-[22px] tw-w-[50%]"
									 onclick="logout()"><i class="fa-solid fa-right-from-bracket"></i>로그아웃
								</a>
								@endif
							</div>
						</div>
						<div class="page-content">
						
							<div class="list accordion-list leftmenu">
								<ul class="custom-menu-list">
									@if( $user )
										<li class="links-list">
											<a href="/my" class="panel-close">내정보 변경</a>
										</li>
										<li class="accordion-item">
											<a class="item-content item-link" href="#"><div class="item-inner">
													<div class="item-title display-flex">
														<span>menu</span>
													</div>
												</div></a>
											<div class="accordion-item-content">
												<div class="list list-dividers">
													<ul>
														<li>
															<a class="item-content item-link panel-close" href="/contract/list"><div class="item-inner">
																	<div class="item-title display-flex ">menu-1</div>
																</div></a>
														</li>
													</ul>
												</div>
											</div>
										</li>
										<li class="links-list">
											<a href="/payment/list" class="panel-close">menu2</a>
										</li>
									@endif
										<li class="links-list">
											<a href="/service-guide" class="panel-close">이용안내</a>
										</li>
										<li class="links-list">
											<a href="/faq" class="panel-close">자주묻는질문</a>
										</li>
										<li class="links-list">
											<a href="/notice" class="panel-close">공지사항</a>
										</li>
								</ul>
							</div>
						
						</div>
						
					</div>
				</div>
			</div>
			
			<div class="view view-main view-init safe-areas" data-url="/"></div>
			
		</div>

		
		<script>
			let userdata = @json($user);
			var routes = [
				{
					path: '/',
					componentUrl: '/pages/home',
					//beforeEnter:[checkAuth],
					name: 'home',
				},
				{
					path: '/login',
					componentUrl: '/pages/login',
					//beforeEnter:[checkAuth],
					name: 'login',
				},
			];
			let logoimage ;
			
		</script>
		<script src="/build/js/defaultjs.js?version={{$assets_version}}" defer></script>
		<script src="/js/appinit.js?ver={{\Carbon\Carbon::now()->format('YmdHis')}}" defer></script>
	</body>
</html>
		