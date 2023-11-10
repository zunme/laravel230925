$(function(){
    activePopup()
    swiperSlideVisual()
    // swiperSlideReview()
    activeItem()
    //setCalendar()
    //activefloorList()
    //addressAPI()
    slideReview()
    AOS.init();
})


function slideReview() {
    var scrollContainer = document.querySelector(".scroll-container");
    var scrollContent = document.querySelector(".scroll-content");

    var scrollAmount = 2; // Adjust scrolling speed (you can use negative values to reverse the direction)
    var animationFrame;

    function scroll() {
        scrollContainer.scrollLeft += scrollAmount;
        if (scrollContainer.scrollLeft >= scrollContent.scrollWidth - scrollContainer.clientWidth) {
            scrollContainer.scrollLeft = 0;
        }

        animationFrame = requestAnimationFrame(scroll);
    }
/*
    scrollContainer.addEventListener("mouseenter", function () {
        cancelAnimationFrame(animationFrame);
    });

    scrollContainer.addEventListener("mouseleave", function () {
        scroll();
    });
 */
    scroll(); // Start the scrolling animation
}

function activePopup(){

    $('.btn__popup__calendar').on('click', function(){
        $('.popup.calendar').addClass('active')
    })

    $('.btn__popup__searchAddress').on('click', function(){
        $('.popup.searchAddress').addClass('active')
    })

    $('.btn__popup__floor').on('click', function(){
        $('.popup.floor').addClass('active')
    })

    /*
    $('.btn__popup__getestimate').on('click', function(){
        $('.popup.getestimate').addClass('active')
    })
    */

    $('.btn__popoup__estimate').on('click', function(){
        $('.popup.getestimate').removeClass('active')
        setTimeout(function(){
            $('.popup.estimate').addClass('active')
        },100)
    })

    $('.popup .popup__close, .popup .bg').on('click', function(){
        $('.popup').removeClass('active')
    })
}

function swiperSlideVisual(){
    var swiper = new Swiper(".visualSwiper", {
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        pagination : { // 페이징 설정
            el : '.swiper-pagination',
            clickable : true, // 페이징을 클릭하면 해당 영역으로 이동, 필요시 지정해 줘야 기능 작동
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
}

function swiperSlideReview(){
    var swiper = new Swiper(".swiperReview", {
        slidesPerView: 4.8,
        spaceBetween: 30,
        centeredSlides: true,
        autoplay:{
            delay:2000,
        },
        loop:true,
        speed:1000,
    });
}

function activeItem(){
    $('.section__estimate .itembox .item').on('click', function(){
        if( $(this).find('input').prop('checked') ){
            $('.section__estimate .itembox .item').removeClass('active')
            $(this).addClass('active')
        }
    })
}

function activefloorList(){
    $('.floor__list a').on('click', function(){
        $('.floor__lista').removeClass('active')
        $(this).addClass('active')
    })
}

function setCalendar(){
    var selectedDates = ["2023-10-25", "2023-11-22", ""]; // 손 없는 날/금-토요일은 가격이 비쌀수 있어요.

    function createCalendar(year, month, index) {
        var monthNames = ["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"];
        var monthName = monthNames[month - 1];

        var container = $("<div class='calendar'></div>").appendTo("#calendar-container");

        var maxDate = new Date();
        maxDate.setDate(maxDate.getDate() + 56);

        container.datepicker({
            inline: true,
            minDate: 0,
            maxDate: maxDate,
            beforeShowDay: highlightSpecificDate,
            onSelect: function (dateText) {
                // selectedDates[index] = dateText;
                setTimeout(()=> {
                    $('.ui-state-default').css({background:'#fff', color:"#333"})
                    $('.ui-state-default.ui-state-active').css({background:'#5e6eff', color:'#fff'})
                },100)
                updateSelectedDates();
            },
            dayNamesMin: ["일", "월", "화", "수", "목", "금", "토"],
        });

        container.datepicker("setDate", new Date(year, month - 1, 1));

        container.prepend("<h2>" + year + "년 " + monthName + "</h2>");

        container.find(".ui-datepicker-next, .ui-datepicker-prev").remove();

        function highlightSpecificDate(date) {
            var today = new Date();
            var formattedDate = $.datepicker.formatDate('yy-mm-dd', date);

            if (formattedDate === selectedDates[index]) {
                return [true, 'selected', ''];
            } else if (date.getTime() === today.getTime()) {
                return [true, 'today', ''];
            } else {
                return [true, '', ''];
            }
        }
    }

    function updateSelectedDates() {
        $(".calendar").each(function (index) {
            if (selectedDates[index] === "") {
                $(this).find(".selected").removeClass("selected");
            } else {
                $(this).find(".ui-state-active").removeClass("ui-state-active");
            }
        });
    }

    createCalendar(2023, 10, 0);
    createCalendar(2023, 11, 1);
    createCalendar(2023, 12, 2);
}


function addressAPI(){
    // https://postcode.map.daum.net/guide#sample
    var element_wrap = document.getElementById('postWrap');
    function foldDaumPostcode() {
        // iframe을 넣은 element를 안보이게 한다.
        element_wrap.style.display = 'none';
    }
    sample3_execDaumPostcode()
    // foldDaumPostcode()

    function sample3_execDaumPostcode() {
        // 현재 scroll 위치를 저장해놓는다.
        var currentScroll = Math.max(document.body.scrollTop, document.documentElement.scrollTop);
        new daum.Postcode({
            oncomplete: function(data) {
                // 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var addr = ''; // 주소 변수
                var extraAddr = ''; // 참고항목 변수

                //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                    addr = data.roadAddress;
                } else { // 사용자가 지번 주소를 선택했을 경우(J)
                    addr = data.jibunAddress;
                }

                // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
                if(data.userSelectedType === 'R'){
                    // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                    // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
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
                    // 조합된 참고항목을 해당 필드에 넣는다.
                    document.getElementById("sample3_extraAddress").value = extraAddr;
                } else {
                    document.getElementById("sample3_extraAddress").value = '';
                }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                document.getElementById('sample3_postcode').value = data.zonecode;
                document.getElementById("sample3_address").value = addr;
                // 커서를 상세주소 필드로 이동한다.
                document.getElementById("sample3_detailAddress").focus();

                // iframe을 넣은 element를 안보이게 한다.
                // (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서 사라지지 않는다.)
                element_wrap.style.display = 'none';

                // 우편번호 찾기 화면이 보이기 이전으로 scroll 위치를 되돌린다.
                document.body.scrollTop = currentScroll;
            },
            // 우편번호 찾기 화면 크기가 조정되었을때 실행할 코드를 작성하는 부분. iframe을 넣은 element의 높이값을 조정한다.
            onresize : function(size) {
                element_wrap.style.height = size.height+'px';
            },
            width : '100%',
            height : '100%'
        }).embed(element_wrap);

        // iframe을 넣은 element를 보이게 한다.
        element_wrap.style.display = 'block';
    }
}