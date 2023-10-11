<template>
  <div class="page mainpage page-{{$pagename}}">
	  <x-front.header title="{{config('app.name')}}"  />
	  
	  <div class="toolbar toolbar-top tw-pt-1 tw-px-1">
			<div class="tw-flex tw-gap-x-1">
				<!--select multiple
					class="tw-select tw-bg-gray-50 tw-border-init tw-border tw-border-gray-300 
						   tw-text-gray-900 tw-text-sm 
						   tw-rounded-lg 
						   focus:tw-ring-blue-500 focus:tw-border-blue-500 
						   tw-block 
						   tw-w-full tw-p-2.5"
					@change=${searchlist}
				>
					<option value="">지역</option>
					${sido.map(item=>$h`
					<option value="${item.key}">${item.val}</option>
					`)}
				</select-->
				<div class="tw-border-init tw-flex tw-items-center tw-flex-1">
				  <a href="#" 
					 class=" smart-select smart-select-init1 focus:tw-border-blue-500 focus:tw-ring-blue-500 
							tw-bg-gray-50 tw-block tw-border tw-border-gray-300 tw-flex-1 tw-min-w-0 tw-p-2.5 tw-rounded-lg tw-rounded-none tw-text-gray-900 tw-text-xs"
					 data-open-in="sheet"
					 >
					<!-- "multiple" attribute for multiple select-->
					<select name="sidos" multiple>
						${sido.map(item=>$h`
						<option value="${item.key}">${item.val}</option>
						`)}
					</select>
					<div class="item-content">
					  <div class="item-inner tw-flex tw-text-blue-600">
						<div class="item-title tw-w-4">
							<i class="fa-solid fa-location-dot"></i>
						</div>
						<div class="item-after selectedline">
							전체지역
						</div>
					  </div>
					</div>
				  </a>
				</div>
				<div class="tw-flex tw-border-init">
				  <input type="text" id="cal_{{$glbRandomId}}"
						 class="tw-rounded-none tw-rounded-l-lg tw-bg-gray-50 
								tw-border tw-border-gray-300 tw-text-gray-900 
								focus:tw-ring-blue-500 focus:tw-border-blue-500 tw-block tw-flex-1 tw-min-w-0 tw-w-40 tw-text-xs tw-p-2.5 " 
						 placeholder="출발일" />
				  	<span class="tw-inline-flex tw-items-center tw-px-3 tw-text-sm tw-text-gray-900 tw-bg-gray-200 
						tw-border tw-border-l-0 tw-border-gray-300 tw-rounded-r-md">
						<svg class="tw-w-4 tw-h-4 tw-text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 448 512">
							  <path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z"/>
						</svg>
				  	</span>
				</div>

				<!--div class="tw-flex tw-border-init">
					<span class="tw-inline-flex tw-items-center tw-px-3 tw-text-sm tw-text-red-500 tw-bg-gray-100 tw-border tw-border-red-300 tw-rounded-md tw-text-lg">
						<i class="fa-solid fa-ellipsis tw-w-4 tw-h-4 tw-text-center tw-self-auto"></i>
					</span>
				</div-->

				<label class="tw-flex tw-border-init">
					<input type="checkbox" style="display:none;" @change=${searchlist}/>
					<span class="checkbox-icon tw-inline-flex tw-items-center tw-px-3 tw-text-sm tw-bg-gray-100 tw-border tw-rounded-md tw-text-lg">
						<i class="fa-solid fa-van-shuttle"></i>
					</span>
				</label>
			</div>
	  </div>
	  
      <div class="page-content">
		<div class="page-content-container">
			<!-- content -->
			<div class="block-title tw-text-base">
				파트너홈
			</div>
			<div>

				<div class="list media-list ">
				  <ul>
					${data.map( item=>$h`
					<li class="tw-bg-white tw-mb-4">
					  <a class="item-link">
						<div class="item-content">
						  <div class="item-inner">
							<div class="item-text tw-flex tw-gap-x-2 tw-text-xs tw-mb-1">
								<div class="tw-rounded-full tw-bg-red-500 tw-text-white tw-px-[10px] tw-py-[3px]">
									<span>왕복</span>
									<i class="fa-solid fa-arrow-right-arrow-left tw-ml-0.5"></i>
								</div>
								<div class="tw-rounded-full tw-bg-blue-500 tw-text-white tw-px-[10px] tw-py-[3px]">
									<span>편도</span>
									<i class="fa-solid fa-arrow-right-long tw-ml-0.5"></i>
								</div>
								<div class="tw-rounded-full tw-bg-gray-200 tw-text-black tw-px-[10px] tw-py-[3px]">
									<span>목적</span>
								</div>
								<div class="tw-rounded-full tw-bg-gray-200 tw-text-black tw-px-[10px] tw-py-[3px]">
									<span>인원</span>
									<span>20</span>
									<span>명</span>
								</div>
								
							</div>
							<div class="item-title-row2 tw-flex tw-gap-x-2 tw-text-base tw-font-semibold">
								<i class="fa-solid fa-location-arrow tw-mt-1"></i>
							  	<div class="item-title2">출발지 주소</div>
							</div>
							<div class="item-title-row2 tw-flex tw-gap-x-2 tw-text-base tw-font-semibold">
								<i class="fa-solid fa-signs-post tw-mt-1"></i>
							  	<div class="item-title2">도착지 주소</div>
							</div>
							<div class="item-sub-row2 tw-flex tw-gap-x-2 tw-items-center tw-text-sm tw-text-gray-800">
								<i class="fa-regular fa-calendar"></i>
							  	<div class="item-title2">
									<span>2023-10-04</span>
									<span class="tw-ml-2">(수)</span>
									<span class="tw-ml-2">당일</span>
								</div>
							</div>
							<div class="item-text icon-badge tw-flex tw-justify-end tw-gap-x-2 tw-text-xs">
								<div class="tw-rounded-full tw-bg-gray-200 tw-text-black tw-px-[10px] tw-py-[3px]">
									<i class="fa-solid fa-diamond-turn-right"></i>
									<span>경유</span>
								</div>
								<div class="tw-rounded-full tw-bg-gray-200 tw-text-black tw-px-[10px] tw-py-[3px]">
									<i class="fa-solid fa-van-shuttle"></i>
									<span>차종만가능</span>
								</div>
								<div class="tw-rounded-full tw-bg-gray-200 tw-text-black tw-px-[10px] tw-py-[3px]">
									<i class="fa-solid fa-map-pin"></i>
									<span>입찰</span>
									<span>1</span>
								</div>
							</div>
						  </div>
						</div>
					  </a>
					</li>
					`)}


				  </ul>
				</div>
				
			</div>
			<!-- /content -->
				<!-- test 
				<div class="hbox tw-justify-around">
					<button type="button" @click=${getPlace}>
						위취
					</button>
					<button type="button" @click="${getToekn}">
						fcm
					</button>
				</div>
				-->
			
			
		</div>
	  </div>
  </div>
</template>
<style>
	.page.page-{{$pagename}} {
		--f7-block-margin-vertical : 1rem;
		--f7-list-margin-vertical : 0.9rem;
	}
	.icon-badge > div > i + span{
		margin-left:5px;
	}
	.caledar{
		font-size:12px;
	}
	.selectedline {
		overflow: hidden !important;
		text-overflow: ellipsis !important;
		padding-left: 10px !important;
		min-width: 0;
		max-height: 1rem;
		max-width:98% !important;
	}
	input[type=checkbox] + span.checkbox-icon {
		--tw-text-opacity: 1 !important;
    	color: rgb(107 114 128 / var(--tw-text-opacity)) !important;
		--tw-border-opacity: 1 !important;
    	border-color: rgb(209 213 219 / var(--tw-border-opacity)) !important;
	}
	input[type=checkbox]:checked + span.checkbox-icon{
		--tw-text-opacity: 1 !important;
    	color: rgb(239 68 68 / var(--tw-text-opacity)) !important;
		--tw-border-opacity: 1 !important;
    	border-color: rgb(252 165 165 / var(--tw-border-opacity)) !important;
	}
	/*
	sheet-modal
	tw-grid tw-grid-cols-3 md:tw-grid-cols-4 lg:tw-grid-cols:5
	*/
</style>
<script>
    export default function (props, ctx) {
        var $$f7router = ctx.$f7router;
        var $$el = ctx.$el;
        var $$f7 = ctx.$f7;
        var $$onMounted = ctx.$onMounted;
        var $$on = ctx.$on;
		
		var sido = helperObjectToArray( @json(config('customsido.simple')) );
		var randomid ='{{$glbRandomId}}';
		let calendarModal;
		
		let data = ['1','2']
		
		const getPlace = ()=>{
			getGeo()
		}
		const getToekn = ()=>{
			var token = getFcmToken()
			toastr(token)
		}
		const makeCal=()=>{
			axios('/getHolidays').then( res =>{
				var events=[]
				holidays = res.data.data.map( item=>{
					var date = moment( item.locdate,'YYYYMMDD')
					
					events.push({
						date: date,
						color: '#ff0000'
					});
					
					return {
						cssClass: 'day-holiday',
						range: {
							from: date,
							to: date
						}
					}
				})
				calendarModal = $$f7.calendar.create({
					inputEl: '#cal_{{$glbRandomId}}',
					openIn: 'customModal',
					header: true,
					footer: true,
					dateFormat:`yyyy-mm-dd`,
					events: events,
					//multiple: true,
					rangePicker: true,
					headerPlaceholder:'출발일을 선택해주세요',
					toolbarCloseText:'확인',
					dayNames:'',
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

					disabled:{
						to: moment().toDate(),
					},
/*
    disabled: function (date) {
        if (date.getFullYear() === 2015 && date.getMonth() === 10) {
            return true;
        }
        else {
            return false;
        }
    },
*/
					on: {
						'change': function(m){
							 //$$f7.calendar.close()
						},
						'close': function(e){
							searchlist()
						}
					}
				});
			})
		}
		
		const searchlist=()=>{
			console.log ( "call search")
		}
		const chagedsido = (smartSelect) =>{
			var values =  smartSelect.getValue()
			if( values.length == 0 ){
				$(".page-{{$pagename}} .selectedline").text("전체지역")
			}else {
				searchlist()
			}
		}
		const chageclass = () =>{
			$(".sheet-modal-inner > .page-content > div.list > ul").addClass("tw-grid tw-grid-cols-3 md:tw-grid-cols-4 lg:tw-grid-cols:5")
			$(".sheet-modal-inner > .page-content > div.list").removeClass("list-dividers-ios list-strong-ios");
		}
		$$on('pageBeforeIn', (e, page) => {
        })
        $$on('pageAfterIn', (e, page) => {
			makeCal();
			$(".force-checked").prop('checked', true)
			app.on('smartSelectOpen', chageclass )
			app.on('smartSelectClose', chagedsido )
        })
        $$on('pageBeforeOut',()=>{
			if( calendarModal ) calendarModal.destroy();
			app.off('smartSelectOpen', chageclass )
			app.off('smartSelectClose', chagedsido )
        })

        return $render;
    }
	/*
	  export default (props, { $, $f7, $f7router }) => {
		console.log( $f7router.currentRoute )
		const randomid = getRandom();
		const signIn = () => {
			let form = new FormData(document.getElementById('form' + randomid))
			axios.post( '/login', form ).then( res=>{
				if (app.views.main.router.currentRoute.hasOwnProperty('name') && app.views.main.router.currentRoute.name=='login') app.views.main.router.back()
				else reloadpage();
			})
		}

		return $render;
	  };
  */
</script>  