<template>
    <div class="page mainpage page-{{$pagename}}">
      <div class="page-content" style="font-size:14px;">
          <section class="content-section">
                <div class="block-title tw-mt-2 tw-mb-2">신청내역</div>
                <div class="datatable-table1 table-length-hide table-filter-hide">
                    <form id="form_{{$pagename}}_search" @submit=${prevent}>
                        <div class="tw-flex tw-gap-5 tw-justify-end newsearchwrap tw-border-init">

                            <div  class="tw-flex tw-gap-2 tw-pl-[5px]">
                                <div class="relative">
                                    <div class="floating-label absolute tw-text-xs">등록일</div>
                                    <input 
                                    class="tw-cal tw-bg-gray-300/50 tw-border tw-border-gray-300 
                                        tw-text-gray-900 tw-text-sm tw-rounded-lg tw-block tw-min-w-[140px] tw-px-[10px] tw-py-[6px]" 
                                    type="date" 
                                    name="created_at" 
                                    placeholder="등록일"
                                    @change=${redraw}
                                    />
                                </div>
                                <div class="relative">
                                    <div class="floating-label absolute tw-text-xs">이사일</div>
                                    <input 
                                    class="tw-cal tw-bg-gray-300/50 tw-border tw-border-gray-300 
                                        tw-text-gray-900 tw-text-sm tw-rounded-lg tw-block tw-min-w-[140px] tw-px-[10px] tw-py-[6px]" 
                                    type="date" 
                                    name="move_date" 
                                    placeholder="이사일"
                                    @change=${redraw}
                                    />
                                </div>
                                <div class="relative">
                                    <div class="floating-label absolute tw-text-xs">진행상태</div>
                                    <select  class="tw-flex tw-justify-between tw-select tw-bg-gray-300/50 tw-border tw-border-gray-300 
                                        tw-text-gray-900 tw-text-sm tw-rounded-lg tw-block tw-min-w-[140px] tw-px-[10px] tw-py-[6px]" 
                                        name="req_status"
                                        @change=${redraw}
                                        >
                                        <!--option value="users.userid">아이디</option-->
                                        <option value="">전체</option>
                                        <option value="Ready">Ready</option>
                                        <option value="Matching">Matching</option>
                                        <option value="Matched">Matched</option>
                                        <option value="Done">Done</option>
                                    </select>
                                </div>
                                <select  class="tw-flex tw-justify-between tw-select tw-bg-gray-300/50 tw-border tw-border-gray-300 
                                tw-text-gray-900 tw-text-sm tw-rounded-lg tw-block tw-w-full tw-min-w-[100px] tw-px-[10px] tw-py-[6px]" name="searchtype">
                                    <!--option value="users.userid">아이디</option-->
                                    <option value="move_requests.name">이름</option>
                                    <option value="move_requests.tel">전화번호</option>
                                    <option value="move_requests.from_address">출발주소</option>
                                    <option value="move_requests.to_address">도착주소</option>
                                </select>
                                <input 
                                    class="tw-input-search tw-cal tw-bg-gray-300/50 tw-border tw-border-gray-300 
								           tw-text-gray-900 tw-text-sm tw-rounded-lg tw-block tw-min-w-[200px] tw-px-[10px] tw-py-[6px]" 
                                    type="text" 
                                    name="searchstr" />
                            </div>
                            <a href="#" class="tw-cal tw-bg-blue-400 tw-text-white
                                    tw-border tw-border-gray-300 
                                    tw-text-sm tw-rounded-lg tw-inline-block tw-w-auto tw-px-[10px] tw-py-[6px]"
                                @click=${redraw}
                                >
                                검색
                            </a>
                            <a href="#" class="tw-cal tw-bg-white tw-text-blue-900
                                    tw-border tw-border-gray-300 
                                    tw-text-sm tw-rounded-lg tw-inline-block tw-w-auto tw-px-[10px] tw-py-[6px]"
                                    @click=${reloadtable}
                                >
                                <i class="fa-solid fa-rotate-right"></i>
                            </a>
                            <a href="/djemals/popup/addrequest" class="tw-cal tw-bg-white tw-text-blue-900
                                    tw-border tw-border-gray-300 
                                    tw-text-sm tw-rounded-lg tw-inline-block tw-w-auto tw-px-[10px] tw-py-[6px]"
                                    @click=${reloadtable}
                                >
                                <i class="fa-solid fa-plus"></i>
                            </a>
                        </div>
                    </form>
                    <table id="{{$pagename}}_datatable" class="display" style="width:100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Front</th>
                                <th>유형</th>
                                <th>진행상태</th>
                                <th>이사일</th>
                                <th>이름</th>
                                <th>전화번호</th>
                                <th>출발지역</th>
                                <th>도착지역</th>
                                <th>출발주소</th>
                                <th>출발층</th>
                                <th>도착주소</th>
                                <th>도착층</th>
                                <th>보관</th>
                                <th>리뷰</th>
                                <th>알림</th>
                                <th>작성일</th>
                            </tr>
                        </thead>
                    </table>
                </div>
          </section>
      </div>
    </div>
  </template>
  <style>
    .floating-label{
        position: absolute;
        z-index: 1;
        background-color: rgb(171 171 171 / 90%);
        top: -8px;
        left: 14px;
        padding: 0px 5px;
        border-radius: 2px;
        color: white;
    }
  </style>
  <script>
    export default function (props, ctx) {
        var $$f7router = ctx.$f7router;
        var $$el = ctx.$el;
        var $$f7 = ctx.$f7;
        var $$onMounted = ctx.$onMounted;
        var $$on = ctx.$on;
        
        var flashdata = store.getters.flash
        store.dispatch('clear')
        console.log ( flashdata.value)
        let inputSet = [
            {'type':'date', 'name':'created_at','label':'등록일'},
            {'type':'date', 'name':'move_date','label':'이사일'},
            {'type':'select', 'name':'confirmed','label':'진행상태',
				'options':[
					{val:'', label:'전체'},
					{val:'Ready', label:'신청'},
					{val:'Matching' , label:'진행중'},
				]
			},
            {'type':'select', 'name':'searchtype','label':'',
				'options':[
					{val:'move_requests.name', label:'이름'},
					{val:'move_requests.tel', label:'전화번호'},
					{val:'move_requests.from_address' , label:'출발주소'},
                    {val:'move_requests.move_requests.to_address' , label:'도착주소'},
				]
			},
			{'type':'text', 'name':'searchstr','placeholder':'검색어'},
        ]

        var datatable, datatableapi;
	    var datatable_id ='{{$pagename}}_datatable';
        var datatable_url = "/api/djemals/requestlist";
        var params = getUrlParams();

        if (!window.changeFrontView) {
            window.changeFrontView = function(e) {
                 var data = {
                    '_method' : 'PUT',
                    'is_use_front' : ( $(e.target).prop('checked') ) ? 'Y' : 'N',

                 }
                 var id = $(e.target).val()
                 axios.post( `/api/djemals/usefront/${id}`, data ).then( res=>{
                    $(e.target).prop( 'checked', !$(e.target).prop('checked') )
                    toastr("변경하였습니다");
                })
                return false;
            };
        };
        const reloadtable = ()=> {
            datatable.ajax.reload(null,false);
        }
        const redraw=()=>{
            datatable.search('').draw();
        }
        const prevent=(e)=>{
			e.preventDefault()
			redraw()
			return false;
		}
        const drawDtTable = () =>{
            datatable = jQuery(`#${datatable_id}`).removeAttr('width')
            .DataTable({
                "bStateSave": false,
                "processing": true,
                "serverSide": true,
                "lengthMenu": [
                    [30,-1],[30,'ALL'],
                ],
                "autoWidth": true,
                "language" : datatable_lang_kor,
                "order": [0,'desc'],
                fixHeader:{
                    header:true,
                    footer:false,
                },
                scrollX:true,
                scrollY:true,
                scrollCollapse:true,
                search: {
                    return: true,
                },
                "ajax": {
                    'url' : datatable_url,
                    'data' : function (data){
                        var frm_data = $("#form_{{$pagename}}_search").serializeArray();
                        $.each(frm_data, function(key, val) {
                            data[val.name] = val.value;
                        });
                        return data;
                    },
                    error: function (xhr, error, code) {
                        if( xhr.status == '401'){
                            //window.location.reload()
                            app.dialog.alert("[오류] 데이터를 가져올수 없습니다",'code : 401');
                        }else{
                            app.dialog.alert("[오류] 데이터를 가져올수 없습니다",'ADMIN');
                        }
                    }
                },
                "columns" : [
                    {"data" : "id",name:"move_requests.id", className: "tw-hidden md:tw-table-cell","searchable": false,orderable: true, visible:true},
                    {"data" : "use_front",name:"move_requests.use_front","searchable": false,orderable: true, visible:true
                        , render: function ( data, type, row, meta ) {
                            var checked=''
                            if( data =='Y') checked=` checked `
                            
                            return `
                                <input type="checkbox" name="fronts[]" readonly value="${row.id}" data-oldval="${data}" ${checked}/>
                            `
                        }
                    },
                    {"data" : "move_type_label",name:"move_requests.move_type", className: "","searchable": false,orderable: false, visible:true
                        
                    },

                    {"data" : "req_status_label",name:"move_requests.req_status_label", className: "","searchable": false,orderable: false, visible:true
                        , render: function ( data, type, row, meta ) {
                            return `<a href="/djemals/popup/reqinfo/${row.id}">${data}</a>`
                        }
                    },
                    {"data" : "move_date",name:"move_requests.move_date", className: "","searchable": false,orderable: true, visible:true
                        , render: function ( data, type, row, meta ) {
                            return dateFormat(data)
                        }
                    },
                    {"data" : "name",name:"move_requests.name", className: "","searchable": false,orderable: false, visible:true},
                    {"data" : "tel",name:"move_requests.tel", className: "","searchable": false,orderable: false, visible:true},
                    {"data" : "from_sido",name:"move_requests.from_sido", className: "","searchable": false,orderable: false, visible:true
                        , render: function ( data, type, row, meta ) {
                            return `${row.from_sido} ${row.from_sigungu}`
                        }
                    },
                    {"data" : "to_sido",name:"move_requests.to_sido", className: "","searchable": false,orderable: false, visible:true
                        , render: function ( data, type, row, meta ) {
                            return `${row.to_sido} ${row.to_sigungu}`
                        }
                    },
                    {"data" : "from_address",name:"move_requests.from_address", className: "","searchable": false,orderable: false, visible:true},
                    {"data" : "from_floor",name:"move_requests.from_floor", className: "","searchable": false,orderable: false, visible:true
                        , render: function ( data, type, row, meta ) {
                            return (data == '-1' ? '지하' : data) +'층'
                        }
                    },
                    {"data" : "to_address",name:"move_requests.to_address", className: "","searchable": false,orderable: false, visible:true},
                    {"data" : "to_floor",name:"move_requests.to_floor", className: "","searchable": false,orderable: false, visible:true
                        , render: function ( data, type, row, meta ) {
                            return (data == '-1' ? '지하' : data) +'층'
                        }
                    },
                    {"data" : "keep",name:"move_requests.keep", className: "","searchable": false,orderable: false, visible:true},
                    {"data" : "review",name:"review.id", className: "tw-hidden md:tw-table-cell","searchable": false,orderable: true, visible:true
                        , render: function ( data, type, row, meta ) {
                            return `<a href="/djemals/popup/reviewadd/${row.id}">${row.review ? 'Y':'N'}</a>`
                        }
                    },
                    {"data" : "matching_cnt",name:"move_requests.matching_cnt", className: "","searchable": false,orderable: false, visible:true},
                    {"data" : "created_at",name:"move_requests.created_at", className: "tw-hidden md:tw-table-cell","searchable": false,orderable: true, visible:true
                        , render: function ( data, type, row, meta ) {
                            return dateTimeFormat(data)
                        }
                    },
                ],
                "preDrawCallback": function( settings ) {
                },
                "drawCallback": function( settings ) {
                },
                "initComplete": function(settings, json) {
                    datatableapi = this.api();
                    var textBox = jQuery(`#${datatable_id}_filter label input`)
                    //jQuery( "#memberlisttable_{{$glbRandomId}}_filter label input" ).unbind();
                    textBox.unbind();
                    inputbox = jQuery(`#${datatable_id}_search input[name="searchstr"]`)
                    setTimeout(() => {
                        inputbox.bind('keydown input', function(e){
                            if(e.keyCode == 8 && !inputbox.val() || e.keyCode == 46 && !inputbox.val()) {
                                    // do nothing ¯\_(ツ)_/¯
                            } else if(e.keyCode == 13) {
                                e.preventDefault();
                                redraw()
                            }
                        } );                        
                    }, 300);
                    jQuery(`#${datatable_id}`).on('click', 'input[name="fronts[]"]', changeFrontView );
                    //jQuery(`#${datatable_id}`).on('click', 'a.changePct', openPctPop );
                },
            });
        }
        $$on('pageBeforeIn', (e, page) => {
        })
        $$on('pageAfterIn', (e, page) => {
            drawDtTable()
            jQuery(`#${datatable_id}`).on('click', 'tr', changeRowColor );
            //custEvents.on("dist_change", reloadtable )
        })
        $$on('pageBeforeOut',()=>{
            console.log( "before out")
            app.popup.close()
            app.dialog.close()
            jQuery(`#${datatable_id}`).off('click', 'input[name="fronts[]"]', changeFrontView );
            //jQuery('#form_dist_search input[name="searchstr"]').unbind();
            //jQuery('#form_agency_search input[name="searchstr"]').unbind();
            jQuery(`#${datatable_id}`).off('click', 'tr', changeRowColor );
            //jQuery(`#${datatable_id}`).off('click', 'a.changePct', openPctPop );
            datatable.destroy()
            //custEvents.off("dist_change", reloadtable )
        })
        $$on('pageAfterOut',()=>{
            
        });
        return $render;
    }
  </script>  