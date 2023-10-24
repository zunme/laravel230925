<template>
    <div class="page mainpage page-{{$pagename}}">
      <div class="page-content" style="font-size:14px;">
          <section class="content-section">
                <div class="block-title tw-mt-2 tw-mb-2">파트너 리스트</div>
                <div class="datatable-table1 table-length-hide table-filter-hide">
                    <form id="form_dist_search" @submit=${prevent}>
                        <div class="tw-flex tw-gap-5 tw-justify-end newsearchwrap tw-border-init">
                            <div  class="tw-flex tw-gap-2 tw-pl-[5px]">
                                <select  class="tw-flex tw-justify-between tw-select tw-bg-gray-300/50 tw-border tw-border-gray-300 
                                tw-text-gray-900 tw-text-sm tw-rounded-lg tw-block tw-w-full tw-px-[10px] tw-py-[6px]" 
                                    name="sidoCode" @change=${redraw} >
                                    <option value="">지역</option>
                                    ${Object.keys(sidoCodes).map( item =>$h`
                                        <option value="${item}">${sidoCodes[item]}</option>
                                    `)}
                                </select>
                                <select  class="tw-flex tw-justify-between tw-select tw-bg-gray-300/50 tw-border tw-border-gray-300 
                                tw-text-gray-900 tw-text-sm tw-rounded-lg tw-block tw-w-full tw-px-[10px] tw-py-[6px]" name="searchtype">
                                    <option value="partners.userid">아이디</option>
                                    <option value="partners.name">이름</option>
                                    <option value="partners.tel">전화번호</option>
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
                            </tr>
                        </thead>
                    </table>
                </div>
          </section>
      </div>
    </div>
  </template>
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
	  .floating-label{
        position: absolute;
        z-index: 1;
        background-color: rgb(171 171 171 / 90%);
        top: -12px;
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
        console.log( flashdata.value )

        var sidoCodes = @json( config("customsido.simple"));

        var datatable, datatableapi;
	    var datatable_id ='{{$pagename}}_datatable';
        var datatable_url = "/api/djemals/partner";

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
                        var frm_data = $("#form_dist_search").serializeArray();
                        $.each(frm_data, function(key, val) {
                            data[val.name] = val.value;
                        });
                        return data;
                    },
                    error: function (xhr, error, code) {
                        if( xhr.status == '401'){
                            window.location.reload()
                        }else{
                            app.dialog.alert("[오류] 데이터를 가져올수 없습니다",'ADMIN');
                        }
                    }
                },
                "columns" : [
                    {"data" : "id",name:"id", className: "tw-hidden md:tw-table-cell","searchable": false,orderable: true, visible:true
                        , render: function ( data, type, row, meta ) {
                            return data ?? ''
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
                    //jQuery(`#${datatable_id}`).on('click', 'a.search-child', searchDistChild );
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
            app.popup.close()
            app.dialog.close()
            //jQuery('#form_dist_search input[name="searchstr"]').unbind();
            //jQuery('#form_agency_search input[name="searchstr"]').unbind();
            jQuery(`#${datatable_id}`).off('click', 'tr', changeRowColor );
            //jQuery(`#${datatable_id}`).off('click', 'a.changePct', openPctPop );
            datatable.destroy()
            //custEvents.off("dist_change", reloadtable )
        })
        return $render;
    }
  </script>  