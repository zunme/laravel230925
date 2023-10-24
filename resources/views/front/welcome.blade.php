@php
	$user = \Auth::guard('web')->user();
	$assets_version = '20230925150003';
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
	  class="ios ios-translucent-bars ios-translucent-modals device-pixel-ratio-1 device-desktop device-windows"
	  style="
		--white-shade : #dfdfdf
		--f7-safe-area-bottom: 34px;font-size:16px;
		--f7-navbar-bg-color-rgb : 255,255,255;
		--f7-bars-translucent-opacity : 1;
		--f7-navbar-text-color:#444;
		--f7-navbar-height:60px;
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
						<div class="page-content" style="		--f7-list-item-min-height:36px;">
						
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
				{
					path:'/login/required/:id',
					async: function ({ app, to, resolve }) {
						console.log(to);
						fetch('/checkuser')
							.then((res) => res.json())
							.then(function (data) {
								if( !data.data.logined){
									resolve(
										{
											popup: {
												closeByBackdropClick : true,
												componentUrl: '/popup/view/login' ,
											},
										},
									);
								}else {
									custEvents.emit('logined', null)
								}
							});
					},
					name: 'reg',
				}
			];
			let logoimage ;
			
		</script>
		<script src="/build/js/defaultjs.js?version={{$assets_version}}" defer></script>
		<script src="/js/appinit.js?ver={{\Carbon\Carbon::now()->format('YmdHis')}}" defer></script>
		<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
		<script src="/js/custom.js?ver={{\Carbon\Carbon::now()->format('YmdHis')}}"></script>
	</body>
</html>
		