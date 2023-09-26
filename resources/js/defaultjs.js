	function pageLoaderShow()  {
		var pageloadercont2 = `
			<div class="preloader-modal pageloader" style="
				background-color: rgb(255 255 255 / 50%);
			"><div class="preloader" style="
				width: 100px;
				height: 100px;
			">
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto;/* background: rgb(241, 242, 243); */display: block;" width="100px" height="100px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
			<circle cx="28" cy="75" r="11" fill="#353535">
			  <animate attributeName="fill-opacity" repeatCount="indefinite" dur="1s" values="0;1;1" keyTimes="0;0.2;1" begin="0s"></animate>
			</circle>

			<path d="M28 47A28 28 0 0 1 56 75" fill="none" stroke="#666666" stroke-width="10">
			  <animate attributeName="stroke-opacity" repeatCount="indefinite" dur="1s" values="0;1;1" keyTimes="0;0.2;1" begin="0.1s"></animate>
			</path>
			<path d="M28 25A50 50 0 0 1 78 75" fill="none" stroke="#9b9b9b" stroke-width="10">
			  <animate attributeName="stroke-opacity" repeatCount="indefinite" dur="1s" values="0;1;1" keyTimes="0;0.2;1" begin="0.2s"></animate>
			</path>
			</svg>
			</div></div>
		`
		var pageloadercont = `
			<div class="preloader-modal pageloader" style="background-color: rgb(255 255 255 / 50%);">
				<div class="preloader" style="width: 100px;height: 100px;text-align: center;">
					<img src="${logoimage}" style="height:98px;opacity: .75;" class="scaleAni"/>
				</div>
			</div>
		`
		var pageloaderback = $("<div class='preloader-backdrop pageloader' />")
		var pageloader;
		
		$("#app").append( pageloaderback )
		
		if( logoimage ) pageloader = $(pageloadercont2)
		else  pageloader = $(pageloadercont2)
		
		$("#app").append( pageloader )
	}
	function pageLoaderHide()  {
		$(".pageloader").remove()
	}

	/* FOR ANDROID */
	function setFCMToken(token){
		var fcmToken  = localStorage.fcmToken;
		if( token != fcmToken ){
			localStorage.fcmToken = token;
			fcmToken = token
		}
	}
	function getFcmToken() {
		if( typeof Android !='undefined'){
			var fcmToken = Android.getAndroidFcmToken()
			if( fcmToken ){
				setFCMToken( fcmToken )
				return fcmToken
			}
		}
		
		if( typeof gbFcmToken != 'undefined' && gbFcmToken ) {
			setFCMToken(gbFcmToken)
			return gbFcmToken
		}
		var token = localStorage.fcmToken
		return token ?? null
	}
	function showAndroidToast( msg){
		if( typeof Android !='undefined'){
			Android.showToast(msg)
		}
	}

	/* 위치 */
	const getGeo=()=>{
		try{
			if ("geolocation" in navigator) {
			  navigator.geolocation.getCurrentPosition( geosuccess, geofail, {enableHighAccuracy: true,timeout: 10000,maximumAge: 0})
			} else {
			  app.dialog.alert('gps api not fond')
			}
		}catch(e){
			app.dialog.alert('geolocationerror','error')
		}
	}
	const geosuccess = (position)=>{
		app.dialog.alert( `lat:${position.coords.latitude} , lng :${position.coords.longitude} `,'GEO');
	}
	const geofail =(poserr)=>{
		app.dialog.alert( poserr.message ,'GEO ERROR');
	}

	(function() {

		if (navigator.geolocation) {
			function PositionError(code, message) {
				this.code = code;
				this.message = message;
			}

			PositionError.PERMISSION_DENIED = 1;
			PositionError.POSITION_UNAVAILABLE = 2;
			PositionError.TIMEOUT = 3;
			PositionError.prototype = new Error();

			navigator.geolocation._getCurrentPosition = navigator.geolocation.getCurrentPosition;

			navigator.geolocation.getCurrentPosition = function(success, failure, options) {
				var successHandler = function(position) {
					if ((position.coords.latitude == 0 && position.coords.longitude == 0) ||
						(position.coords.latitude == 37.38600158691406 && position.coords.longitude == -122.08200073242188)) 
						return failureHandler(new PositionError(PositionError.POSITION_UNAVAILABLE, 'Position unavailable')); 

					failureHandler = function() {};
					success(position);
				}

				var failureHandler = function(error) {
					failureHandler = function() {};
					failure(error);
				}

				navigator.geolocation._getCurrentPosition(successHandler, failureHandler, options);

				window.setTimeout(function() { failureHandler(new PositionError(PositionError.TIMEOUT, 'Timed out')) }, 10000);
			}
		}
	})();
	/*  / 위치 */

	function gotoLogin(){
		location.replace('/login')
	}
	function getRandom(){
		return Math.random().toString(36).substring(2, 12);
	}
	/* formdata to object */
    const formToObj= (formdata) =>{
        const formDataObj = {};
        formdata.forEach((value, key) => (formDataObj[key] = value));
        return formDataObj;
    }
	var datatable_lang_kor = {
		decimal: "",
		emptyTable: "데이터가 없습니다.",
		info: "_START_ - _END_ (총 _TOTAL_ )",
		infoEmpty: "0",
		infoFiltered: "(전체 _MAX_ 명 중 검색결과)",
		infoPostFix: "",
		thousands: ",",
		lengthMenu: "_MENU_ 개씩 보기",
		loadingRecords: "로딩중...",
		processing: "처리중...",
		search: "검색 : ",
		zeroRecords: "검색된 데이터가 없습니다.",
		paginate: {
			first: "첫 페이지",
			last: "마지막 페이지",
			next: "다음",
			previous: "이전"
		},
		aria: {
			sortAscending: " :  오름차순 정렬",
			sortDescending: " :  내림차순 정렬"
		}
	};
