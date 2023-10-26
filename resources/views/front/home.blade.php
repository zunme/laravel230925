@php
$random = \Str::random('8');;
@endphp
<template>
  <div class="page mainpage page-{{$pagename}}">
	<div class="navbar">
		<div class="navbar-bg"></div>
		<div class="navbar-inner navbar-inner-centered-title">
			<div class="left"></div>
			<div class="title hbox! pack! font(18px) font(16)!" style="left: 22px;">
				<div class="tw-pr-[40px]">
					<img src="/images/2424.jpg" class="tw-h-[42px]"/>
				</div>
				<div class="hbox! pack! tw-gap-x-[16px] tw-hidden sm:tw-flex">
					<a href="#">이사 TIP</a>
					<a href="#">사회공헌</a>
					<a href="#">이사현황</a>
					<a href="#" class="tw-text-mainbg">상담원연결</a>
				</div>
			</div>
			<div class="right">
				<a class="sm:tw-hidden_ link icon-only panel-open" data-panel="right">
					<i class="fa-solid fa-bars"></i>
				</a>
			</div>
		</div>
	</div>
      <div class="page-content noselect">
		<div class="page-content-inner">
			<div class="tw-h-80 tw-bg-mainbg">
				<div id="test"></div>
			</div>
			<div class="">
				<form id="{{$random}}_formMoveReg">
					<div class="
						tw-grow tw-max-w-[800px] tw-ml-auto tw-mr-auto tw-mt-[-30px] tw-bg-white tw-min-h-[10vh]
						tw-rounded-xl tw-px-4 tw-py-4 sm:tw-px-10 sm:tw-py-10
						box-shadow tw-mb-10
						">
						<div class="tw-text-base tw-font-semibold tw-text-gray-600 tw-text-center tw-mb-6">이사종류 선택하고 잘하는 업체 찾아보세요</div>
						<div class="tw-grid tw-grid-cols-2 tw-gap-4 md:tw-grid-cols-4 md:tw-gap-2 md:tw-gap-4 tw-mb-4">
							<label>
								<input type="radio" name="move_type" value="1" class="radiobox-radio"  data-required="이사유형을 선택해주세요"  required/>
								<div class="radiobox vbox pack tw-rounded-lg">
									<!--i class="fa-solid fa-house"></i-->
									<img src="/icons/icon_home.png" />
									<div class="tw-mt-2 tw-text-center">
										<div class="tw-text-sm tw-font-semibold">1톤이상의</div>
										<div class="tw-text-lg tw-font-bold">가정이사</div>
									</div>
								</div>
							</label>
							<label>
								<input type="radio" name="move_type" value="1" class="radiobox-radio" />
								<div class="radiobox vbox pack tw-rounded-lg">
									<!--i class="fa-solid fa-building"></i-->
									<img src="/icons/icon_office.png" />
									<div class="tw-mt-2 tw-text-center">
										<div class="tw-text-sm tw-font-semibold">회사, 공장, 병원 등</div>
										<div class="tw-text-lg tw-font-bold">사무실이사</div>
									</div>
								</div>
							</label>
							<label>
								<input type="radio" name="move_type" value="1" class="radiobox-radio" />
								<div class="radiobox vbox pack tw-rounded-lg">
									<!--i class="fa-solid fa-house-user"></i-->
									<img src="/icons/icon_oneroom.png" />
									<div class="tw-mt-2 tw-text-center">
										<div class="tw-text-sm tw-font-semibold">1톤 이하</div>
										<div class="tw-text-lg tw-font-bold">원룸이사</div>
									</div>
								</div>
							</label>
							<label>
								<input type="radio" name="move_type" value="1" class="radiobox-radio" />
								<div class="radiobox vbox pack tw-rounded-lg">
									<!--i class="fa-solid fa-truck-ramp-box"></i-->
									<img src="/icons/icon_keep.png" />
									<div class="tw-mt-2 tw-text-center">
										<div class="tw-text-sm tw-font-semibold">안전하고 깔끔한</div>
										<div class="tw-text-lg tw-font-bold">보관이사</div>
									</div>
								</div>
							</label>
						</div>
						<div class="tw-mb-4">
							<label class="tw-block tw-mb-2 tw-text-sm tw-font-medium tw-text-gray-900">이사날짜</label>
							<input class="tw-select tw-cal tw-bg-gray-300/50 tw-border tw-border-gray-300 
								tw-text-gray-900 tw-text-sm tw-rounded-lg tw-block tw-w-full tw-p-2.5
								calendar-modal-inp
								" 
								type="text" readonly name="move_date" data-required="이사날짜를 선택해주세요" required
								/>

							<label class="tw-block tw-mb-2 tw-text-sm tw-font-medium tw-text-gray-900 tw-mt-4">출발지주소</label>
							<input type="hidden" name="from_zip" />
							<input class="tw-input-search tw-cal tw-bg-gray-300/50 tw-border tw-border-gray-300 
								tw-text-gray-900 tw-text-sm tw-rounded-lg tw-block tw-w-full tw-p-2.5 tw-mb-2" 
								type="text" name="from_address" @click=${openDaum} data-type="from" data-required="출발지주소를 입력해주세요" required
							/>

							<a href="#" class="smart-select"  data-open-in="popup" data-page-title="출발지 층수 선택">
								<select name="from_floor" data-required="출발지 층수를 선택해주세요" required>
									<option value="">층수선택</option>
									<option value="-1">지하</option>
									<option value="1">1층</option>
								</select>
								<div class="item-content">
									<div class="tw-flex tw-justify-between tw-select tw-bg-gray-300/50 tw-border tw-border-gray-300 
									tw-text-gray-900 tw-text-sm tw-rounded-lg tw-block tw-w-full tw-p-2.5">
										<!-- Select label -->
										<div class="item-title"></div>
										<!-- Selected value, not required -->
										<div class="item-after">층수를 선택해 주세요</div>
									</div>
								</div>
							</a>

							<label class="tw-block tw-mb-2 tw-text-sm tw-font-medium tw-text-gray-900 tw-mt-4">도착지주소</label>
							<input type="hidden" name="to_zip" />
							<input class="tw-input-search tw-cal tw-bg-gray-300/50 tw-border tw-border-gray-300 
								tw-text-gray-900 tw-text-sm tw-rounded-lg tw-block tw-w-full tw-p-2.5 tw-mb-2" 
								type="text" name="to_address" @click=${openDaum} data-type="to"  data-required="도착지주소를 입력해주세요"
							/>

							<a href="#" class="smart-select"  data-open-in="popup" data-page-title="도착지 층수 선택">
								<select name="to_floor" data-required="도착지 층수를 선택해주세요">
									<option value="">층수선택</option>
									<option value="-1">지하</option>
									<option value="1">1층</option>
								</select>
								<div class="item-content">
									<div class="tw-flex tw-justify-between tw-select tw-bg-gray-300/50 tw-border tw-border-gray-300 
									tw-text-gray-900 tw-text-sm tw-rounded-lg tw-block tw-w-full tw-p-2.5">
										<!-- Select label -->
										<div class="item-title"></div>
										<!-- Selected value, not required -->
										<div class="item-after">층수를 선택해 주세요</div>
									</div>
								</div>
							</a>

							<div class="flex items-center tw-mt-4">
								<input type="checkbox" value="Y" name="keep"
									class="tw-w-4 tw-h-4 tw-text-blue-600 tw-bg-gray-100 tw-border-gray-300 tw-rounded 
										focus:tw-ring-blue-500 focus:tw-ring-2" />
								<label class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300 tw-tect-maincolor">보관 이사 필요</label>
							</div>

							<div class="tw-flex tw-justify-center">
								<button type="button" 
									class="tw-bg-mainbg tw-inline-flex tw-mt-8 tw-px-[30px] tw-py-[6px] tw-rounded tw-text-white"
									@click=${reg}
									>
									어쩌구저쩌구
								</button>
							</div>
						</div>
					</div>
				</form>
				<!-- 실시간 -->
				<div class="now-log-bg tw-pt-10 tw-pb-20 tw-mb-10">
					<div class="tw-flex tw-justify-center">
						<img src="/images/nowlogo.png" style="max-width:700px; width:80vw"/>
					</div>
					<div class="tw-bg-amber-200 tw-px-2 tw-py-10">
						<div class="tw-grow tw-max-w-[800px] tw-ml-auto tw-mr-auto">

							<div class="slidewrapper v-slider tw-h-[228px]">
							<!-- Slides -->
							@for($i=0; $i < 10; $i++)
									<div class="slide">
									<div class="tw-grid tw-grid-cols-5 tw-border-b-2 tw-px-4 tw-py-2 tw-text-sm tw-items-center">
										<div class="tw-flex tw-justify-start">이사타입1</div>
										<div class="tw-flex tw-justify-center">위치1</div>
										<div class="tw-flex tw-justify-center">이*름1</div>
										<div class="tw-flex tw-justify-center">2023-10-161</div>
										<div class="tw-flex tw-justify-end">
											<span class="tw-bg-gray-500 tw-inline-flex tw-px-[10px] tw-py-[3px] tw-rounded-sm tw-text-white">신규등록2</span>
										</div>
									</div>
									</div>
							@endfor
							</div>

						</div>
					</div>
				</div>
				<!-- / 실시간 -->

				<!-- 리뷰 -->
				<div class="tw-px-4 tw-py-10 tw-mb-10">
					<div class="swiper mySwiper ">
						<div class="swiper-wrapper">
							@for($i=0; $i<20; $i++)
							<div class="swiper-slide">
								<div class="tw-bg-gray-300 tw-flex tw-p-2 tw-rounded-lg">
									<div>
										<i class="fa-regular fa-user tw-px-1"></i>
									</div>
									<div class="tw-flex-grow">
										<div>
											<i class="fa-solid fa-star"></i>
											<i class="fa-solid fa-star"></i>
											<i class="fa-solid fa-star"></i>
											<i class="fa-solid fa-star"></i>
											<i class="fa-regular fa-star"></i>
										</div>
										<div>
											user / 2023-10-16
										</div>
										<div class="line-clamp(2)">
											어쩌구 저쩌구 저쩌구 저쩌구 어쩌구 저쩌구 저쩌구 저쩌구
											어쩌구 저쩌구 저쩌구 저쩌구 어쩌구 저쩌구 저쩌구 저쩌구
											어쩌구 저쩌구 저쩌구 저쩌구 어쩌구 저쩌구 저쩌구 저쩌구
										</div>
									</div>
								</div>
							</div>
							@endfor
						</div>
					</div>
				</div>
				<!-- / 리뷰 -->

				<div>
					<div class="tw-grow tw-max-w-[400px] tw-ml-auto tw-mr-auto">
						@for($i=0; $i<5 ; $i++)
						<div class="tw-flex tw-py-6 tw-px-5 tw-rounded-xl box-shadow tw-bg-white tw-mb-4 tw-text-lg">
							<div class="tw-pr-2 tw-text-mainbg">
								<i class="fa-solid fa-circle-info"></i>
							</div>
							<div class="tw-font-bold">
								전국 어디서나 동일한 서비스
							</div>
						</div>
						@endfor
					</div>
				</div>

				<div>
					<div class="tw-grid tw-grid-cols-3 tw-gap-4">
						<div class="tw-bg-gray-200 square">
							<a class="square-inner" href="/login/required/{{$random}}">loginpop</a>
						</div>
						<div class="tw-bg-gray-200 square">
							<div class="square-inner">123</div>
						</div>
						<div class="tw-bg-gray-200 square">
							<div class="square-inner">123</div>
						</div>
					</div>
				</div>
			</div>
			<!-- content -->
			<!-- /content -->
		</div>
	  </div>
  </div>
</template>
<style>
	.radiobox-radio{
		display:none;
	}
	.radiobox{
		padding:20px 10px;
	}
	.radiobox > i{
		font-size: 30px;
	}
	.radiobox-radio + .radiobox{
		background-color:#eee;
		border:1px solid #ddd !important;
		color:#555;
	}
	.radiobox-radio:checked + .radiobox{
		background-color:#afcffb;
		border:1px solid #94b8eb !important;
		color:#333;
	}
	.radiobox > img {
		max-width:100px;
	}
	.calendar-day-next, .calendar-day-prev {
		color: #858585 !important;
	}
	.calendar-day-disabled {
		color: var(--f7-calendar-disabled-text-color) !important;
		cursor: auto;
	}
	.calendar-day-has-events {
		/*color: inherit;*/
	}

	.caneldar-footer-dot{
		width:4px;
		height:4px;
		background-color:#ff9800;
		border-radius: 4px;
		display: inline-block;
		margin-right:4px;
	}
	.now-log-bg {
		background-color : #f7c200;
	}
	.bx-wrapper {
		/*max-width: 100%;
		height: 228px;
		overflow-y: hidden;*/
		border:0px !important #FFF !important;
		background: none !important;
	}

</style>
<script>
    export default function (props, ctx) {
        var $$f7router = ctx.$f7router;
        var $$el = ctx.$el;
        var $$f7 = ctx.$f7;
        var $$onMounted = ctx.$onMounted;
        var $$on = ctx.$on;
		var calendarModal;
		var sonDays=[];
		let fromAddress={};
		let toAddress={};
		let mainFormCall = {target:null, 'callid' : null};

		var vslider;

		var randomid ='{{$random}}';
		const getPlace = ()=>{
			getGeo()
		}
		const getToekn = ()=>{
			var token = getFcmToken()
			toastr(token)
		}

		const reg=(e)=>{
			//if(!mainFormCall.target) mainFormCall.target = (e.target).closest('form');
			/*todo remove*/
			regPrc(true);return;
			if( !formValidate( document.getElementById(`${randomid}_formMoveReg`) ) ) return false;
			regPrc(true);
		}
		const regPrc = (popuse )=>{
			//console.log ( mainFormCall.target )
			var formdata = new FormData( document.getElementById(`${randomid}_formMoveReg`) )
			formdata.append('to_data', JSON.stringify(toAddress) ) 
			formdata.append('from_data', JSON.stringify(fromAddress) ) 
			axios.post( '/move/reg', formdata).then(res=>{
				data = res.data.data
				if ( data.login_need ){
					if(popuse) {
						mainFormCall = Math.random().toString(36).substring(2, 12);
						app.views.main.router.navigate(`/login/required/${mainFormCall}`)
					}
				}else{
					;
				}
			})
		}
		const loginEventCall = (data)=>{
			if( data.callEvent && mainFormCall == data.callEvent ) regPrc(false);
		}

		const openDaum = (e)=>{
            openDaumPostPop($$(e.target).data('type'))
        }
		const addresschange=( data)=>{
			$$(`input[name=${data.target_type}_zip]`).val( data.postcode )
			$$(`input[name=${data.target_type}_address]`).val( data.addr + data.extraAddr )
			if( data.target_type == 'from') {
				fromAddress = data.orgdata;
			}
			else if(data.target_type == 'to') {
				toAddress = data.orgdata;
			}
			console.log( data )
		}
		const createcalendar=()=>{
			axios.get('/api/common/sondays').then( res=>{
				res.data.map( item=>{
					sonDays.push({
						date: moment( item.date ),
						color: '#ff9800'
					});
				})
			 } ).then( calendar() )
			 setTimeout(() => {
				createVerticalSlider()
				createReview()
			 }, 400);
		}
		const createVerticalSlider = () =>{
			vslider = $('.v-slider').bxSlider({
				mode: 'vertical',
				auto: true,
				controls:false,
				speed:800,
				autoDelay:0,
				autoControls: false,
				stopAutoOnClick: false,
				minSlides: 5,
				maxSliders:5,
				pager:false,
				slideMargin: 2,
			});
		}
		const createReview=()=>{
			swiper = new Swiper(".mySwiper", {
				slidesPerView: 1,
				spaceBetween: 10,
				centeredSlides: false,
				autoplay: {
					delay: 2500,
					disableOnInteraction: false,
				},
				breakpoints: {
					640: {
					slidesPerView: 2.2,
					},
					768: {
					slidesPerView: 4.2,
					},
				},
			});
		}
		
		const calendar=()=>{
			calendarModal = $$f7.calendar.create({
					inputEl: '.calendar-modal-inp',
					openIn: 'customModal',
					header: true,
					footer: true,
					dateFormat:`yyyy-mm-dd`,
					events: sonDays,
					
					rangesClasses: [
						 {
							// string CSS class name for this range in "cssClass" property
							cssClass: 'day-sun', //string CSS class
							// Date Range in "range" property
							range: function (date) {
								return  date.getDay() == 0
							}
						},
						{
							// string CSS class name for this range in "cssClass" property
							cssClass: 'day-sat', //string CSS class
							// Date Range in "range" property
							range: function (date) {
								return  date.getDay() == 6
							}
						},
					],
					
					disabled: function (date) {
						return !moment(date).isBetween( moment().add(1,'days'), moment().add(2,'months'))
	
					},
					
					renderToolbar:function(){
						return `
						<div class="toolbar toolbar-top">
							<div class="toolbar-inner">
								<div class="calendar-year-selector">
									<a class="link icon-only calendar-prev-year-button">
										<i class="icon icon-prev"></i>
									</a>
									<a class="current-year-value link"></a>
									<a class="link icon-only calendar-next-year-button">
										<i class="icon icon-next"></i>
									</a>
								</div>
								<div class="calendar-month-selector">
									<a class="link icon-only calendar-prev-month-button">
										<i class="icon icon-prev"></i>
									</a>
									<a class="current-month-value link"></a>
									<a class="link icon-only calendar-next-month-button">
										<i class="icon icon-next"></i>
									</a>
								</div>
							</div>
						</div>						
						`
					},
					on: {
						open(calendar) {
      						calendar.$el.find('.calendar-footer').addClass("tw-bg-gray-700 tw-justify-center tw-text-sm tw-text-white").html(`
								<div class="caneldar-footer-custom tw-flex tw-items-center">
									<span class="caneldar-footer-dot"></span>
									손없는날/금~토요일은 가격이 비쌀 수 있어요
								</div>
							`)
						},
						'change': function(m){
							 $$f7.calendar.close()
						}
					}
				});
		}
		$$on('pageBeforeIn', (e, page) => {
            console.log( "before in")
        })
        $$on('pageAfterIn', (e, page) => {
			//r.makeData()
			createcalendar()
			custEvents.on("post_code", addresschange )
			custEvents.on("logined", loginEventCall )
			
        })
        $$on('pageAfterOut',()=>{
			if( calendarModal ) calendarModal.destroy();
			custEvents.off("post_code", addresschange )
			custEvents.off("logined", loginEventCall )
        })
        function logout(){
            logout_global();
        }
        return $render;
    }
</script>  