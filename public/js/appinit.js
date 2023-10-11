var $$ = Dom7;
let _authToken = localStorage.authToken ?? ''
const setAuthToken=(token)=>{
	localStorage.authToken = token;
	_authToken = token
	setAxiosToken()
}
const setAxiosToken =()=>{
	axios.defaults.headers.common['Authorization'] = `Bearer ${_authToken}`
	hiddenAxios.defaults.headers.common['Authorization'] = `Bearer ${_authToken}`
}
const helperObjectToArray=( obj)=>{
	return Object.keys(obj ).map(item => { return {'key':item, 'val':obj[item] } } );
}

routes.push(
	{
        path: '(.*)',
        content: `
            <div class="page">
                <div class="navbar">
                    <div class="navbar-bg"></div>
                    <div class="navbar-inner navbar-inner-centered-title">
                        <div class="left">
                            <a class="link back"><i class="icon icon-back"></i></a>
                        </div>
                        <div class="title tw-flex tw-font-bold tw-items-center tw-text-[18px] tw-text-gray-600/90" style="left: -2px;">
                            <div class="" style="position:relative;">
                                <span>페이지가 없습니다</span>
                            </div>
                        </div>
                        <div class="right">
                        
                        </div>
                    </div>
                </div>
                <div class="page-content">
                    <div id="notfound">
                        <div class="notfound">
                            <div class="notfound-404">
                                <h1>Oops!</h1>
                            </div>
                            <div class="notfond-text">
                                <h2>404 - Page not found</h2>
                                <p>The page you are looking for might have been removed had its name changed or is temporarily unavailable.</p>
                                <a href="/" class="link external">Go To Homepage</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `,
    }
);

var app = new Framework7({
    el: '#app',
    theme:'ios',
    colors: {
    // specify primary color theme
        primary: '#01d9a6'
    },
    // store.js,
    // routes.js,
    routes: routes,
    pushState: true,
	uniqueHistory: true,
	
    view: {
        iosDynamicNavbar: false,
        xhrCache: false,
        cache: false,
        componentCache:false,

        stackPages: false,
        pushState: true,
        pushStateSeparator: '',
        uniqueHistory: true,
        history: true,
        browserHistory : true,
        browserHistorySeparator: '',

    },
    cache: false,
        
    panel: {
        swipe: false,
        //panel descktop 보이기
        //visibleBreakpoint: 400,
    },
    popup: {
        closeOnEscape: true,
    },
    sheet: {
        closeOnEscape: true,
    },
    popover: {
        closeOnEscape: true,
    },
    actions: {
        closeOnEscape: true,
    },
    vi: {
        placementId: 'pltd4o7ibb9rc653x14',
    },
    toast: {
        closeTimeout: 1500,
        closeButton: false,
        destroyOnClose:true,
    }
	,on:{
		init: function(){
			_authToken = localStorage.authToken ?? ''
			setAxiosToken()
		},
		routerAjaxStart: function(xhr, options){ pageLoaderShow() },
        routerAjaxComplete: function(xhr, options){ pageLoaderHide() },
		pageInit: function( page){
			if( gtagid && gtagid != '' ){
				const { href, pathname } = window.location;
				/*
				gtag('config', gtagid , {
						page_title: page.route.name ?? 'oksusupay',
						page_location: href,
						page_path:  pathname //page.route.path
				})
				*/;
				 gtag('event', 'page_view', {
					page_title: page.route.name ?? 'oksusupay',
					page_location: href,
					page_path:  pathname //page.route.path
				 });
			}
			
		},

	}
});

	/* framework7 전용 */
const toastr = t=>{
        app.toast.create({
            text: t,
            destroyOnClose: true,
            position: "center",
            closeTimeout: 4000,
        }).open()
}
, inlinePhotoViewComponent = (t,{$: e, $f7: o, $ref: n, $h: a})=>{
        let c = "string" == typeof t.class ? t.class : "";
        const r = n=>{
            var a = parseInt(e(n.target).data("index"));
            o.photoBrowser.create({
                photos: t.photos,
                type: "page",
                backLinkText: "Back",
                theme: "dark",
                on: {
                    closed: function(t) {
                        t.destroy()
                    }
                }
            }).open(a)
        }
        ;
        return ()=>a`
    <div class="inline-thumb-list ${c}">
        <ul class="display-flex">
        ${t.photos.map(((t,e)=>a`
        <li>
            <a href="#" class="link" data-index="${e}" @click=${r} style="background-image:url(${t.url});"></a>
        </li>
        `))}
        </ul>
    </div>
    `
}

function login(){
	app.views.main.router.navigate('/login');
}

function logout() {
	axios.post("/logout",{fcm:getFcmToken()}).then((t=>{
		_firstLoginCheck = false;
		app.panel.close()
		location.replace("/");
		return;
	}))
}

const reloadpage=()=>{
	app.views.main.router.navigate(app.views.main.router.currentRoute.url, {
		reloadCurrent: true,
		ignoreCache: true,
	});
}

const openDaumPostPop =(type)=>{
  var dynamicPopup = app.popup.create({
      content: `
      <div class="popup popup-daumpost">
          <div class="page noselect" data-name="daumpost">
              <div class="navbar">
                  <div class="navbar-bg"></div>
                  <div class="navbar-inner">
                      <div class="left"></div>
                      <div class="title">주소찾기</div>
                      <div class="right">
                          <a href="#" class="link popup-close" id="daumpost_close">Close</a>
                      </div>
                  </div>
              </div>
              <div class="page-content pop-page-daumpost">
                  <div id="postcode_wrap" style="height:100%"></div>
              </div>
          </div>
      </div>
      `,
      // Events
      on: {
          open: function (popup) {
              //console.log('Popup open');
          },
          opened: function (popup) {
              //console.log('Popup opened');
              setTimeout(() => {
				var height = $$(".popup-daumpost > .page").height() - 74;
				console.log ( height );
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
                          custEvents.emit('post_code', retdata)
                          app.popup.close();
                      },
                      width : '100%',
                      height : '100%'
                  }).embed(document.getElementById('postcode_wrap'))  
              },300);
          },
      }
  });
  dynamicPopup.on('closed', function (popup) {
      dynamicPopup.destroy();
      $$(".popup.popup-daumpost").remove()
      dynamicPopup = null;
  });
  dynamicPopup.open();
};

function loadsheet(t, e, o) {
    void 0 === t && (t = "/new_common/popup/accessterms.html"),
    "boolean" != typeof o && (o = !1),
    "string" != typeof e && (e = ""),
    app.request({
        url: t,
        statusCode: {
            404: function(t) {
                alert("page not found")
            }
        }
    }).then((t=>{
        var n = t.data;
        o && (n = nl2br(t.data)),
        app.sheet.create({
            content: `\n          <div class="sheet-modal dynamic-sheet">\n            <div class="toolbar">\n              <div class="toolbar-inner">\n                <div class="left"></div>\n                <div class="title">${e}</div>\n                <div class="right">\n                  <a class="link sheet-close">Done</a>\n                </div>\n              </div>\n            </div>\n            <div class="sheet-modal-inner">\n              <div class="page-content" style="padding-bottom: 30px;padding-left: 20px;padding-right: 20px;">\n              ${n}\n              </div>\n            </div>\n          </div>\n        `,
            on: {
                open: function(t) {
                    console.log("Sheet open")
                },
                opened: function(t) {
                    console.log("Sheet opened")
                },
                closed: function(t) {
                    t.destroy()
                }
            }
        }).open()
    }
    ))
}

const joinChannel=()=>{
    if( userdata && userdata.id){
        Echo.channel(`private-private.${userdata.id}`)
            .listen('.privateevent', (e) => {
            if(  e.message && e.message.type ) custEvents.emit( e.message.type , e.message.data )
        });
    }
}
function callCustEvent( type, data ){
    custEvents.emit( type , data )
}
	
window.custEvents = new Framework7.Events;
document.addEventListener("DOMContentLoaded", function(){
	if( typeof Echo != 'undefined' ){
		joinChannel()
	}
});

	
