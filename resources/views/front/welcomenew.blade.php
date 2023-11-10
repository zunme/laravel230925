@php
	$user = \Auth::guard('web')->user();
	$assets_version = '20230925150003';
@endphp
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="user-scalable=yes, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width">
    <title>이사할때 2424-2424</title>

    <script src="/js/libraries.js?version={{$assets_version}}"></script>
    <script src="/js/tailwind.ext.js?version={{$assets_version}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js" integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/locale/ko.min.js" integrity="sha512-3kMAxw/DoCOkS6yQGfQsRY1FWknTEzdiz8DOwWoqf+eGRN45AmjS2Lggql50nCe9Q6m5su5dDZylflBY2YjABQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="/js/jquery-93b17483.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>



    <link type="text/css" href="./style/default.css" rel="stylesheet">
    <link type="text/css" href="./style/swiper-bundle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./style/jquery-ui.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link type="text/css" href="/style/common.css" rel="stylesheet">
    <link type="text/css" href="/style/style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <!--script src="./script/jquery.1.12.0.min.js"></script-->
    <script src="./script/jquery-ui.js"></script>
    <script src="./script/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="./script/script.js"></script>
    <link type="text/css" href="/css/modal.css?ver=20231102160003" rel="stylesheet">
    <style>
        input.right-icon{
            padding-right: 80px;
        }
        input.right-icon + img {
            position: absolute;
            top: 50%;
            right: 27px;
            width: 27px;
            transform: translateY(-50%);
        }
        .tw-border-init, .tw-border-init *, .tw-border-init :before, .tw-border-init :after {
            box-sizing: border-box;
            border-width: 0;
            border-style: solid;
            border-color: #e5e7eb;
            border: 0 solid #e5e7eb;
        }
        .popup .popup__close_new {
            position: absolute;
            right: 40px;
            top: 40px;
        }
        .popup .bg_new {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.0);
        }
        .calendar-day-text{
            width: 38px;
            height: 38px;
            /* display: flex; */
            /* align-items: center; */
            border-radius: 50%;

            display: flex;
            flex-flow: row;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }
        .selected .calendar-day-text{
            background-color: blue;
            color: wheat;
        }
        .son{
            content: '';
            display: block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #ed1c24;
            position: absolute;
            right: 18px;
            top: 2px;
        }
        .floor__list label {
            display: block;
            text-align: center;
            border-top: 1px solid #d4d4d4;
        }

        .floor__list label > input[type=radio]{
            display:none;
        }
        .floor__list label > input[type=radio] + div{
            font-size: 20px;
            font-weight: 600;
            padding: 20px 0;
            background-color:white;
        }
        .floor__list label > input[type=radio]:checked + div{
            background-color:#afcffb;
        }
        input[type=text].placeholder {
            color :#bbb !important;
        }
    </style>
</head>

<body class="ios">
    <header>
        <div class="maxWidthWrap">
            <h1>
                <a href="./index.html">
                    <img src="./img/logo.png" alt="2424-2424">
                </a>
            </h1>
            <nav>
                <a href="https://blog.naver.com/move_2424" target="_blank">이사TIP</a>
                <a href="#receipt">이사현황</a>
                <a href="#society">사회공헌</a>
                <a href="tel:2424-2424" class="link-connect">상담원 연결</a>
            </nav>
        </div>
    </header>
    
    <main style="overflow-y:scroll">
        <section class="section__visual">
            <div class="swiper visualSwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="./img/banner/WEB_BANNER1.png" alt="안전하고 체계적인 이사시스템" class="pc">
                        <img src="./img/banner/MOBILE_BANNER1.png" alt="안전하고 체계적인 이사시스템" class="mo">
                    </div>
                    <div class="swiper-slide">
                        <img src="./img/banner/WEB_BANNER2.png" alt="이사를 부탁해" class="pc">
                        <img src="./img/banner/MOBILE_BANNER2.png" alt="이사를 부탁해" class="mo">
                    </div>
                    <div class="swiper-slide">
                        <img src="./img/banner/WEB_BANNER3.png" alt="싹다 옮겨드림" class="pc">
                        <img src="./img/banner/MOBILE_BANNER3.png" alt="싹다 옮겨드림" class="mo">
                    </div>
                    <div class="swiper-slide">
                        <img src="./img/banner/WEB_BANNER4.png" alt="체크리스트" class="pc">
                        <img src="./img/banner/MOBILE_BANNER4.png" alt="체크리스트" class="mo">
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </section>


        <section class="section__estimate">
            <form onSubmit="prevent(e)" id="main_home_form">
            <div class="maxWidthWrap">
                <div class="contentbox">
                    <h2>이사 종류 선택하고 잘하는 이사업체 찾아보세요!</h2>

                    <div class="itembox">
                        <label class="item">
                            <div class="box">
                                <img src="./img/icon_home.png" alt="home">
                            </div>
                            <p>1톤 이상의</p>
                            <b>가정이사</b>
                            <input type="radio"  name="move_type" value="1">
                        </label>
                        <label class="item">
                            <div class="box">
                                <img src="./img/icon_office.png" alt="office">
                            </div>
                            <p>회사, 공장, 병원 등</p>
                            <b>사무실이사</b>
                            <input type="radio"  name="move_type" value="2">
                        </label>
                        <label class="item">
                            <div class="box">
                                <img src="./img/icon_oneroom.png" alt="oneroom">
                            </div>
                            <p>1톤 이하</p>
                            <b>원룸이사</b>
                            <input type="radio"  name="move_type" value="3">
                        </label>
                        <label class="item">
                            <div class="box">
                                <img src="./img/icon_keep.png" alt="keep">
                            </div>
                            <p>안전하고 깔끔한</p>
                            <b>보관이사</b>
                            <input type="radio"  name="move_type" value="4">
                        </label>
                    </div>

                    <h3>이사날짜</h3>
                    <x-calendar-custom name="move_date" holder="이사날짜 선택" />
                    <h3>출발지 주소</h3>
                    <div class="relative">
                        <input type="hidden" name="from_zip" />
                        <input type="text" class="tw-pr-[80px]" 
                            style="background: #edeff5 url(/img/icon_serach.png) 97% /27px no-repeat !important;" 
                            name="from_address" placeholder="주소" readonly="" onClick="makeAddr('from')">
                    </div>              

                    <div class="h10"></div>
                    
                    <x-floor-select name="from" holder="층수"></x-floor-select>

                    <h3>도착지 주소</h3>
                    <div class="relative tw-mb-[10px]">
                        <input type="hidden" name="to_zip" />
                        <input type="text" class="tw-pr-[80px]" 
                            style="background: #edeff5 url(/img/icon_serach.png) 97% /27px no-repeat !important;" 
                            name="to_address" placeholder="주소" readonly="" onClick="makeAddr('to')">
                    </div> 
                    <x-floor-select name="to" holder="층수"></x-floor-select>

                    <label class="checkboxLabel">
                        <input type="checkbox" value="Y" name="keep">
                        <i></i>
                        <span>보관이사 필요</span>
                    </label>
                    <x-move-req-button />
                </div>

            </div>
            </form>
        </section>
        <a href="tel:2424-2424" class="box__call">
            <img src="./img/img_headphone.png" alt="headphone">
            <div class="text">
                <h3>상담원 바로연결 클릭</h3>
                <h4>2424-2424</h4>
            </div>
        </a>

        <section class="section__receipt" id="receipt">
            <h2>
                <img src="./img/img_now.png" alt="실시간 접수 현황" class="pc">
                <img src="./img/img_now_mobile.png" alt="실시간 접수 현황" class="mo">
            </h2>

            <div class="receipt__list__outer">
                <div class="receipt__list">
                    <div class="receipt__list__inner">
                        @foreach( $req as $row)
                        <div class="item">
                            <span>{{$row['move_type_label']}}</span>
                            <span>{{$row['from_sido_label']}} {{$row['from_sigungu']}}</span>
                            <span>{{!$row['name'] ? '***' : $row['name']}}</span>
                            <span>{{$row['move_date']->toDateString()}}</span>
                            <div class="mark {{$row['req_status']=='Ready' ?'new':''}}">{{$row['req_status_label']}}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="section__review">
            <h2>
                <span>실제 고객님들의</span>
                <b>생생한 후기</b>
            </h2>
            <h3>최고의서비스에 만족하신 이사이사 고객님의 찐후기 </h3>

            <!-- Slider main container -->
            <div class="swiper swiperReview scroll-container">
                <!-- Additional required wrapper -->
                <div class="scroll-content">
                    @foreach($review as $row)
                    <div class="reviewItem">
                        <div class="top">
                            <img src="./img/ico_profile.png" alt="profile">
                            <div class="grade">
                                @for( $i =0; $i < $row['star_point'];$i++)
                                <img src="./img/ico_star.png" alt="star">
                                @endfor
                            </div>
                            <b>{{$row['star_point']}}</b>
                        </div>
                        <div class="btm">
                            <span>{{$row['name_marked']}}</span>
                            <span>{{$row['write_at']->format('y.m.d')}}</span>
                            <p>{{$row['area']}} / {{$row['move_date']->diffForHumans()}}</p>
                            <p>{{$row['comment']}}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <a href="tel:2424-2424" class="btn_common btn__estimate">우수업체 추천받기</a>
            </div>
        </section>

        <section class="section__why2424">
            <h2>
                <span>왜</span>
                <img src="./img/logo2.png" alt="2424-2424">
                <span>를 선택해야 할까요?</span>
            </h2>

            <div class="whybox1" data-aos="fade-up" data-aos-duration="2000" data-aos-anchor-placement="top-center">
                <span class="num"><span>1</span></span>
                <span class="text">전국 어디서나 동일한 서비스</span>
            </div>
            <div class="whybox1" data-aos="fade-up" data-aos-duration="2000" data-aos-anchor-placement="top-center">
                <span class="num"><span>2</span></span>
                <span class="text">전용자재 사용으로 안전한 이사</span>
            </div>
            <div class="whybox1" data-aos="fade-up" data-aos-duration="2000" data-aos-anchor-placement="top-center">
                <span class="num"><span>3</span></span>
                <span class="text">우수업체 직거래 서비스 </span>
            </div>
            <div class="whybox1" data-aos="fade-up" data-aos-duration="2000" data-aos-anchor-placement="top-center">
                <span class="num"><span>4</span></span>
                <span class="text">불필요한 이사비용 최대 20% 절약</span>
            </div>

            <div class="whybox2">
                <div class="box box1">
                    <p>최적화된 동선, 배치</p>
                </div>
                <div class="box box2">
                    <p>꼼꼼한 마무리</p>
                </div>
                <div class="box box3">
                    <p>베테랑 전문가</p>
                </div>
            </div>
        </section>

        <section class="section__society" id="society">
            <div class="maxWidthWrap">
                <h2>사회공헌</h2>
                <p>이사이사는 사단법인여성행복누리를 지원하는 사회공헌기업입니다.<br>
                    계열사의 수입 일부분을 미혼모들의 인간다운 삶과 권리보장을 통해 행복한 공동체 조성(생명사랑과 존중)에 사용됩니다.<br>
                    청소년 미혼모, 미혼임산모, 미혼한부모 가족들이 안정된 생활을 유지할 수 있도록 주거와 생계를 지원하고 다양한 취ㆍ창업 교육을 실시하여 경제적으로 자립할 수 있도록 모든 지원을
                    아끼지
                    않겠습니다.</p>

                <div class="societybox">
                    <div class="box box1">
                        <p>청소년 미혼모 생계지원(외부전경)</p>
                    </div>
                    <div class="box box2">
                        <p>다양한 취업ㆍ창업 교육</p>
                    </div>
                    <div class="box box3">
                        <p>미혼모 가정 물품지원</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="section__support">
            <div class="maxWidthWrap">
                <img src="./img/img_logo_other_mo.png" alt="광명아우름, 여성행복누리" class="mo logos">
                <h2 class="mo">미혼모ㆍ한부모가정을 위한 값진 지원</h2>
                <p>엄마와 아기의 행복한 공간<br>
                    사단법인여성행복누리/광명아우름</p>

                <p class="pc">미혼모ㆍ한부모가정을 위한 값진 지원<br>
                    엄마와 아기의 행복한 공간</p>
                <h2 class="pc">사단법인여성행복누리/광명아우름</h2>
                <img src="./img/img_logo_other.png" alt="광명아우름, 여성행복누리" class="pc">

                <a href="https://www.ihappynanum.com/Nanum/B/ISF08DI8CA
                " class="btn_common btn__estimate" target="_blank">정기 후원하기</a>
            </div>
        </section>

        <section class="section__contact">
            <h2>파트너 입점 문의</h2>
            <p>이사업체 및 용달업체 파트너 상시 모집</p>

            <a href="tel:010-7100-8356" class="btn_common btn__estimate">파트너 제휴 문의</a>
        </section>
    </main>
    
    <footer>
        <div class="maxWidthWrap">
            <div class="link">
                <a href="javascript:;">회사소개</a>
                <a href="javascript:;">이용약관</a>
                <a href="javascript:;">개인정보</a>
            </div>
            <a href="./index.html" class="footer__logo">
                <img src="./img/logo.png" alt="2424-2424">
            </a>
            <p>©이사이사. 2424, Inc. All Rights Reserved.</p>
            <p>대표이사 : 서은교 주소 : 경기도 광명시 오리로 619번길 11 예원빌딩</p>
        </div>
    </footer>



    <div class="custpopup-backdrop"></div>
    <div class="custpopup demo-popup modal-in modal-out close-only prev-escape">
        <div class="page">
            <div class="navbar">
                <div class="navbar-bg"></div>
                <div class="navbar-inner">
                    <div class="title" style="left: 260.5px;">Popup Title</div>
                    <div class="right">
                        <a class="link popup-close">Close</a>
                    </div>
                </div>
            </div>
            <div class="page-content">
                <div class="block"></div>
            </div>
        </div>
    </div>
    <div class="custpopup demo-popup2 modal-in modal-out close-only prev-escape">
        <div class="page">
            <div class="navbar">
                <div class="navbar-bg"></div>
                <div class="navbar-inner">
                    <div class="title" style="left: 260.5px;">Popup Title2</div>
                    <div class="right">
                        <a class="link popup-close">Close</a>
                    </div>
                </div>
            </div>
            <div class="page-content">
                <div class="block"></div>
            </div>
        </div>
    </div>        
        
    <script>
        let fromAddress, toAddress;
        const prevent=(e)=>{
			e.preventDefault()
			return false;
		}
        function removeThis(e) {
            $(e.target).closest('.popup').remove()
        }
        function setData(type, data){
            $(`input[name=${data.target_type}_zip]`).val( data.postcode )
			$(`input[name=${data.target_type}_address]`).val( data.addr + data.extraAddr )
			if( data.target_type == 'from') {
				fromAddress = data.orgdata;
			}
			else if(data.target_type == 'to') {
				toAddress = data.orgdata;
			}
        }
        const makeAddr=( type)=>{
            var self = this
            var newpopstr = `<div class="popup searchAddress active" id="addr_pop">
                    <div class="content">
                        <button class="popup__close" onClick = "removeThis(event)">
                            <img src="./img/popup_close.png" alt="close">
                        </button>
                        <h2>출발지를 검색해주세요.</h2>
                        <div class="" id="postWrap"></div>
                    </div>
            </div>`
            $("body").append( newpopstr  )
            setTimeout(() => {
            new daum.Postcode({
                oncomplete: function(data) {
                    var addr = ''; // 주소 변수
                    var addr_jibun ='';

                    var extraAddr = ''; // 참고항목 변수
                    addr = data.roadAddress;
                    addr_jibun = data.jibunAddress;
                    if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                        extraAddr += data.bname;
                    }
                    // 건물명이 있고, 공동주택일 경우 추가한다.
                    if(data.buildingName !== '' && data.apartment === 'Y'){
                        extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                    }
                    // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                    if(extraAddr !== ''){
                        extraAddr = ' (' + extraAddr + ')';
                    }
                    let retdata = {
                        addr : addr,
                        addr_jibun : addr_jibun,
                        extraAddr : extraAddr,
                        postcode:data.zonecode,
                        user_Select : data.userSelectedType === 'R' ? 'road':'jibun',
                        orgdata : data,
                        target_type :type,
                    }
                    setData(type, retdata)
                    $("#addr_pop").remove();
                },
                width : '100%',
                height : '100%'
            }).embed(document.getElementById('postWrap'))  
            },10);
        }


        const openCustPop=( target )=>{
            $(".custpopup-backdrop").addClass("backdrop-in")
            $(`.custpopup${target}`).removeClass('modal-out')
        }
        const closeCustPop=(target)=>{
            var poplength = $(".custpopup").length
            if(poplength == 1 ) {
                $(".custpopup-backdrop").removeClass("backdrop-in")
            }
            $(target).addClass("modal-out")
            if( !$(target).hasClass("close-only")){
                setTimeout( function(){
                    $(target).closest('.custpopup').remove()
                },1000)
            }
        }
        $(document).on("click", "a.popup-close", function () {
            var self = this
            closeCustPop( $(self).closest('.custpopup') )
        })
        $(document).on("click", ".custpopup-backdrop", function () {
            $()
            var self = $(this).next()
            if( $(self).hasClass("custpopup") && !$(self).hasClass("modal-out") && !$(self).hasClass("prev-escape") ){
                closeCustPop(self)
            }
        })
    </script>

</body>

</html>