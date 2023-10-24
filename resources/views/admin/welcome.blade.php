@php
	$user = \Auth::guard('web')->user();
	$assets_version = '20230925150003';
	$menu = [
		["url"=>'request','title'=>'신청내역'],
		["url"=>"partner",'title'=>'파트너'],
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
			const store = Framework7.createStore({
				state: {
					token:null,
					flash :null,
				},
				actions:{
					//store.dispatch('flash',{flash: {'ooo':'fff'} })
					flash({state, dispatch}, {flash} ){
						state.flash = flash
					},
					clear({state}){
						state.flash =null
					},
				},
				getters: {
					flash:({state, dispatch})=>{
						return state.flash
					},
				}
			})
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

			];
			@endverbatim
			let logoimage ;
		</script>
		<script src="/build/js/defaultjs.js?version={{$assets_version}}" defer></script>
		<script src="/js/appinit.js?ver={{\Carbon\Carbon::now()->format('YmdHis')}}" defer></script>
		<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>

		<link href="/css/datatables.css" rel="stylesheet" />
		<script src="/js/datatables.js"></script>
<script>
	function getUrlParams() {     
		var params = {};  		
		window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi, 
			function(str, key, value) { 
				params[key] = value; 
			}
		);     
		return params; 
	}
	function logoutAdm() {
		axios.post("/djemals/logout").then((t=>{
			//store.dispatch("updateToken", ""),	
			//localStorage.setItem("login_check_time", moment().subtract(7, 'days') )
			//location.replace('/djemals')
		}))
	}
	const simpleDateFormat = (created_at)=>{
		if (!created_at)
			return '';
		return moment().format('YY-MM-DD') == moment(created_at).format('YY-MM-DD') ? moment(created_at).format('HH:mm') : moment(created_at).format('YY-MM-DD')
	}
	const dateTimeFormat = (created_at)=>{
		if (!created_at)
			return '';
		return moment(created_at).format('YYYY-MM-DD HH:mm:ss')
	}
	const dateFormat = (created_at)=>{
		if (!created_at)
			return '';
		return moment(created_at).format('YYYY-MM-DD')
	}
	const changeRowColor=(e)=>{
		$$("tr.selectedRow").removeClass('selectedRow')
		$$(e.target).closest('tr').addClass('selectedRow')
		selectedRow = $$(e.target).closest('tr').attr('id')
	}
	Framework7.registerComponent(
		'my-search-inputs',
		(props, { $h }) => {
			var wrap_class = "list-strong-ios list-dividers-ios inset-ios";
			var data = ( props.hasOwnProperty('data') ) ? props.data : {};
			
			//string => object 데이터로 변경
			//ex (string)"key1.key2" => value of object.key1.key2
			const multiIndex=(obj,is)=>{  // obj,['1','2','3'] -> ((obj['1'])['2'])['3']
				return is.length ? multiIndex(obj[is[0]],is.slice(1)) : obj
			}
			const pathIndex=(is)=> {   // obj,'1.2.3' -> multiIndex(obj,['1','2','3'])
				return multiIndex(data,is.split('.')) ?? ''
			}
			
			return () => $h`
	<div class="list ">
		<ul>
		${props.list.map( item =>$h`
			${item.type=='hidden' ? $h`
				<input type="hidden" 
					value="${ data[item.name] ?? ''}" 
					name="${item.name}" />
			`:''}
			${item.type=='text' || item.type=='password' || item.type=='number' ? $h`
				<div>123</div>
			`:''}
			
			${item.type=='select' ? $h`
			<div>123</div>
			`:''}
			${item.type=='date' || item.type=='datetime' ? $h`
				<div>123</div>
			`:''}
		`)}
		</ul>
	</div>
			`
		}
	)

Framework7.registerComponent(
	 /*
	 	.. 옵션 object 를 array 로
	 	.. Object.entries( objectdata ) :: object=> array;
		
		.. 사용법
		 .. click을 사용한다면 click 용 function 우선 선언
		const openDaum = (e)=>{
			openDaumPostPop('auto_contract')
		}
		
		let inputSet = [
			{'type':'hidden', 'name':'id'},
			{'type':'text', 'name':'contract.contract_address1','label':'계약 주소1',hidemedia:true,'readonly':true},
			{'type':'text', 'name':'contract_zip','label':'우편번호','disabled':false,'readonly':true, 'required':true, 'icon':{'ico':null, 'class':''}},
			{'type':'text', 'name':'contract.contract_address','label':'계약 주소','disabled':false,'readonly':true, 'required':false,hidemedia:true, 'click':openDaum, 'click_name':'변경' },
			{'type':'select', 'name':'confirmed','label':'상태', 'required':true, 'icon':{'ico':null, 'class':''}
				,'options':[
					{val:'confirmed', label:'승인'},
					{val:'denied', label:'거부'},
					{val:'ready' , label:'승인대기'},
				], 그외 class 지정가능
			},
		];
		${data ? $h`
			<my-input-lists data=${data} list=${inputSet}></my-input-lists>
		`:''}
	*/
		'my-input-lists',
		(props, { $h }) => {
			var wrap_class = "list-strong-ios list-dividers-ios inset-ios";
			var data = ( props.hasOwnProperty('data') ) ? props.data : {};
			
			//string => object 데이터로 변경
			//ex (string)"key1.key2" => value of object.key1.key2
			const multiIndex=(obj,is)=>{  // obj,['1','2','3'] -> ((obj['1'])['2'])['3']
				return is.length ? multiIndex(obj[is[0]],is.slice(1)) : obj
			}
			const pathIndex=(is)=> {   // obj,'1.2.3' -> multiIndex(obj,['1','2','3'])
				return multiIndex(data,is.split('.')) ?? ''
			}
			
			return () => $h`
	<div class="list ">
		<ul>
		${props.list.map( item =>$h`
			${item.type=='hidden' ? $h`
				<input type="hidden" 
					value="${ data[item.name] ?? ''}" 
					name="${item.name}" />
			`:''}
			${item.type=='text' || item.type=='password' || item.type=='number' || item.type=='file' ? $h`
				<li class="item-content item-input item-input-outline ${item.class_li ?? ''}">
					${item.hidemedia ? '':$h`
					<div class="item-media">
						${ !item.hasOwnProperty('icon') ? $h`
						<i class="fa-solid fa-square tw-text-xl tw-text-stone-500"></i>
						`:$h`
							${ !item.icon.ico ? $h`
								${ (item.readonly || item.disabled) ? $h`
									<i class="fa-solid fa-square-xmark tw-text-xl tw-text-stone-500 ${item.icon.class??''}"></i>
								`:$h`
									${ (item.required) ? $h`
										<i class="fa-solid fa-square tw-text-xl tw-text-sky-800 ${item.icon.class??''}"></i>
									`:$h`
										<i class="fa-solid fa-square tw-text-xl tw-text-sky-300 ${item.icon.class??''}"></i>
									`}
								`}
							`:$h`
								${item.icon.ico}
							`}
						`}
					</div>
					`}
					<div class="item-inner ${item.class_item_innder ?? ''}">
						<div class="item-title item-label">${item.label ?? ''}</div>
						<div class="item-input-wrap ${ item.click ? $h`tw-flex`:''} ${item.class_input_wrap ?? ''} ${item.type=='file' ? 'tw-flex tw-item-center':''} ">
							${item.type=='file' ? $h`
								<input type="file" placeholder="${item.holder??''}" class="${item.class_input ?? ''}" 
									name="${item.name}" 
									readonly=${item.readonly==true} 
									required=${item.required==true} 
									disabled=${item.disabled==true} 
								/>
								${ data[item.name] ? $h`
								<a class="link external button button-fill color-green tw-text-white button-small tw-w-[100px]" href="${ data[item.name] ?? ''}" target="_blank">보기</a>
								`:''}
							`:$h`
								<input type="${item.type}" placeholder="${item.holder??''}" class="${item.class_input ?? ''}" 
									value="${ pathIndex(item.name) ?? ''}" 
									name="${item.name}" 
									readonly=${item.readonly==true} 
									required=${item.required==true} 
									disabled=${item.disabled==true} 
								/>
								${item.click ? $h`
									<button type="button" class="button button-fill color-red button-small tw-w-auto"  @click=${item.click} >${item.click_name ?? '확인'}</button>
								`:$h`
									<span class="input-clear-button"></span>
								`}
							`}
						</div>
					</div>
				</li>
			`:''}
			
			${item.type=='select' ? $h`
				<li class="item-content item-input item-input-outline ${item.class_li ?? ''}">
					${item.hidemedia ? '':$h`
					<div class="item-media">
						${ !item.hasOwnProperty('icon') ? $h`
						<i class="fa-solid fa-square tw-text-xl tw-text-stone-500"></i>
						`:$h`
							${ !item.icon.ico ? $h`
								${ (item.readonly || item.disabled) ? $h`
									<i class="fa-solid fa-square-xmark tw-text-xl tw-text-stone-500 ${item.icon.class??''}"></i>
								`:$h`
									${ (item.required) ? $h`
										<i class="fa-solid fa-square tw-text-xl tw-text-sky-800 ${item.icon.class??''}"></i>
									`:$h`
										<i class="fa-solid fa-square tw-text-xl tw-text-sky-300 ${item.icon.class??''}"></i>
									`}
								`}
							`:$h`
								${item.icon.ico}
							`}
						`}
					</div>
					`}
					<div class="item-inner ${item.class_item_innder ?? ''}">
						<div class="item-title item-label">${item.label ?? ''}</div>
						<div class="item-input-wrap input-dropdown-wrap ${item.class_input_wrap ?? ''}">
							<select class="input-with-value ${item.class_input ?? ''}"
								name="${item.name}"
								readonly=${item.readonly==true} 
								required=${item.required==true} 
								disabled=${item.disabled==true} 
							>
								${item.options.map(opt=>$h`
									<option value="${opt.val ?? ''}" selected=${opt.val== pathIndex(item.name) } >${opt.label ?? '선택해주세요'}</option>
								`)}
							</select>
									
						</div>
					</div>
				</li>
			`:''}
			${item.type=='date' || item.type=='datetime' ? $h`
				<li class="item-content item-input item-input-outline ${item.class_li ?? ''}">
					${item.hidemedia ? '':$h`
					<div class="item-media">
						${ !item.hasOwnProperty('icon') ? $h`
						<i class="fa-solid fa-square tw-text-xl tw-text-stone-500"></i>
						`:$h`
							${ !item.icon.ico ? $h`
								${ (item.readonly || item.disabled) ? $h`
									<i class="fa-solid fa-square-xmark tw-text-xl tw-text-stone-500 ${item.icon.class??''}"></i>
								`:$h`
									${ (item.required) ? $h`
										<i class="fa-solid fa-square tw-text-xl tw-text-sky-800 ${item.icon.class??''}"></i>
									`:$h`
										<i class="fa-solid fa-square tw-text-xl tw-text-sky-300 ${item.icon.class??''}"></i>
									`}
								`}
							`:$h`
								${item.icon.ico}
							`}
						`}
					</div>
					`}
					<div class="item-inner ${item.class_item_innder ?? ''}">
						<div class="item-title item-label">${item.label ?? ''}</div>
						<div class="item-input-wrap ${ item.click ? $h`tw-flex`:''} ${item.class_input_wrap ?? ''} ">
							<input type="${item.type=='date' ? 'date' : 'datetime-local'}" placeholder="${item.holder??''}" class="${item.class_input ?? ''}" 
									value="${ item.type=='date' ? (pathIndex(item.name) ? moment(pathIndex(item.name)).format('Y-MM-DD'):'') :   ( pathIndex(item.name) ? moment(pathIndex(item.name)).format('Y-MM-DD HH:mm:ss') :'') }" 
									name="${item.name}" 
									readonly=${item.readonly==true} 
									required=${item.required==true} 
									disabled=${item.disabled==true} 
							/>
							${item.click ? $h`
								<button type="button" class="button button-fill color-red button-small tw-w-auto"  @click=${item.click} >${item.click_name ?? '확인'}</button>
							`:$h`
								<span class="input-clear-button"></span>
							`}
						</div>
					</div>
				</li>
			`:''}
		`)}
		</ul>
	</div>
			`
		}
);

Framework7.registerComponent(
    // component name
    'draw-star',

    // component function
    (props, { $h }) => {
      var pointsprop = props.points
      var classname = (typeof props.classname =='string' ? props.classname:'')
      var points = 0;
      if( typeof pointsprop== 'string'){
        points = parseFloat(pointsprop)
        if( isNaN(points) ) points = 0
      }else if ( typeof pointsprop== 'number'){
        points = pointsprop;
      } else {
        points = (typeof pointsprop=='object' && typeof pointsprop.star_total !='undefined') ? pointsprop.star_total : 0;
      }
      let retstr = ''
      for(var i =1; i <=5;i++){
        points = points - 1
        if( points >= 0 ) retstr += `<i class="fa-solid fa-star full_score"></i>`
        else if( points >= -0.5 ) retstr += `<i class="fa-regular fa-star-half-stroke harf_score"></i>`
        else retstr += `<i class="fa-regular fa-star none_score"></i>`
      }
      return () => $h`<div class="${classname}" innerHTML=${retstr}></div>`;
    }
)
	 /*
	 <star-point addclass="tw-flex" inputname="star_point_inp" valuedisplay="left"></star-point>
	 */
Framework7.registerComponent(
	'star-point',
	(props, { $update,$onMounted, $h }) => {
		let _starpoint = 0;
		let _stars = []
		const starpoint = (e)=>{
			const nodes = [...e.target.parentElement.children];
			const index = nodes.indexOf(e.target);
  			_starpoint = index;
			$update()
		}
		$onMounted(() => {
			console.log ( props )
			var starlen = ( typeof props.starlen =='undefined') ? 5 : parseInt(props.starlen);
			_stars = Array.from(Array(starlen))
			$update()
		})
		return()=>$h`
		<div class="stars-rating ${props.hasOwnProperty('addclass') ? props.addclass : '' }" @click=${starpoint}>
		
		 ${props.hasOwnProperty('valuedisplay') && props.valuedisplay =='left' ? $h`
			<div class="stars-rating-before">
				${_starpoint}
			</div>
		`:''}
			<div class="stars-rating-inner">
				<input type="hidden" value="${_starpoint}" name="${props.hasOwnProperty('inputname') ? props.inputname : 'starpoints' }" />
				${_stars.map( (item, index)=>$h`
					${index  < _starpoint ? $h`
						<i class="star-point-solid fa-star fa-solid"></i>
					`:$h`
						<i class="star-point-regular fa-star fa-regular"></i>
					`}

				`)}
			</div>
			${props.hasOwnProperty('valuedisplay') && props.valuedisplay =='right' ? $h`
			<div class="stars-rating-after">
				${_starpoint}
			</div>
			`:''}
		</div>
		`
	}
)
Framework7.registerComponent(
    'draw-star-empty',
    (props, { $h }) => {
      var classname = (typeof props.classname =='string' ? props.classname:'')
      return () => $h`
      <div class="${classname}">
        <i class="fa-regular fa-star none_score"></i>
        <i class="fa-regular fa-star none_score"></i>
        <i class="fa-regular fa-star none_score"></i>
        <i class="fa-regular fa-star none_score"></i>
        <i class="fa-regular fa-star none_score"></i>
      </div>
      `;
    }
)
</script>
	</body>
</html>
		