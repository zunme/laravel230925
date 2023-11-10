<template>
    <div class="popup pop-{{$pagename}}" data-backdrop="true">
        <div class="page noselect" data-name="pop_{{$pagename}}">
            <div class="navbar">
                <div class="navbar-bg"></div>
                <div class="navbar-inner">
                    <div class="left"></div>
                    <div class="title">파트너정보</div>
                    <div class="right">
                        <a href="#" class="link popup-close">Close</a>
                    </div>
                </div>
            </div>

            <div class="page-content pop-page-{{$pagename}}">
                ${ info ? $h`
                <form @submit=${prevent}>
                    <my-input-lists data=${info} list=${inputSet}></my-input-lists>
                    <div class="tw-w-full tw-flex tw-justify-end">
                        <button type="button"
                            class="tw-inline-flex tw-px-4 tw-py-1 tw-bg-green-700 tw-text-white tw-rounded"
                            @click=${saveDefault}
                        >
                            기본정보 저장
                        </button>
                    </div>
                </form>
                <form @submit=${prevent}>
                    <my-input-lists list=${inputSetPwd}></my-input-lists>
                    <div class="tw-w-full tw-flex tw-justify-end">
                        <button type="button"
                            class="tw-inline-flex tw-px-4 tw-py-1 tw-bg-green-700 tw-text-white tw-rounded"
                            @click=${savePwd}
                        >
                            비밀번호변경
                        </button>
                    </div>
                </form>
                <form @submit=${prevent}>
                </form>
                `:''}
                <div class="tw-mb-10">
                    ${( (parseInt(props.id)|0) != 0 ) ? $h`
                        @if( !config('site.use_sigungu',false) )
                            <section class="content-section">
                                <div class="block-title">가능지역(시/도)</div>
                                <form id="avail_sido_form">
                                    <div class="tw-grid tw-grid-cols-5 tw-gap-4">
                                        ${areasArr.map( item=>$h`
                                            <label class="checkbox_outer_label">
                                                <input type="checkbox" class="tw-mr-4" name="areas[]" value="${item.val}" id="area_${item.val}"
                                                    checked=${ isset(item.val, area_selected) }
                                                />
                                                <div class="label_box_inner tw-bg-gray-400 tw-flex tw-items-center tw-px-4 tw-py-4 tw-rounded-lg">
                                                    <span>${item.label}</span>
                                                </div>
                                            </label>
                                        `)}
                                    </div>
                                    <!--div class="tw-flex tw-justify-end">
                                        <a href="#" class="tw-inline-flex tw-px-4 tw-py-1 tw-bg-green-700 tw-text-white tw-rounded" @click=${updateItem}>저장</a>
                                    </div-->
                                </form>
                            </section>
                        @else
                            <section class="content-section">
                                <div class="block-title">가능지역(시군구)</div>
                                <form id="avail_sigungu_form">
                                    <div class="accordion-list">
                                        ${sigungu ? $h`
                                            ${sigungu.map(sido=>$h`
                                                <div class="accordion-item after-line">
                                                    <div class="accordion-item-toggle accordion-toggle-icon relative tw-bg-gray-200">${sido.short_name}</div>
                                                    <div class="accordion-item-content">
                                                        <div class="tw-py-2 tw-px-8 tw-flex tw-flex-wrap tw-gap-2">
                                                        ${sido.gungu.map( item =>$h`
                                                            <label class="checkbox_outer_label">
                                                                <input type="checkbox" class="tw-mr-4" name="gungu[]" value="${item.sido_cd}${item.sigungu_cd}" id="gungu_${item.id}"
                                                                    checked=${ isset(`${item.sido_cd}${item.sigungu_cd}`, area_selected) }
                                                                />
                                                                <div class="label_box_inner tw-bg-gray-400 tw-flex tw-items-center tw-px-4 tw-py-4 tw-rounded-lg">
                                                                    <span>${item.sgg}</span>
                                                                </div>
                                                            </label>
                                                        `)}
                                                        </div>
                                                    </div>
                                                </div>
                                            `)}
                                        `:''}
                                    </div>
                                </form>
                            </section>
                        @endif
                        <div class="tw-w-full tw-flex tw-justify-end">
                            <a href="#" class="tw-inline-flex tw-px-4 tw-py-1 tw-bg-green-700 tw-text-white tw-rounded" @click=${updateItemSigungu}>저장</a>
                        </div>
                    `:''}
                </div>
            </div>
        </div>
    </div>
</template>

<style>
  .popup.pop-{{$pagename}}{
	--f7-popup-tablet-height : 80vh;
	--f7-popup-tablet-width: 80vw;
	--f7-navbar-title-margin-left:16px;
    --f7-list-margin-vertical:10px;
  }
  .page-content.pop-page-{{$pagename}} {
    padding-left: 10px;
    padding-right: 10px;
  }
  .popup.pop-{{$pagename}} .item-input-outline.item-content .item-title+.item-input-wrap {
        margin-top: -16px;
    }
    .checkbox_outer_label input[type=checkbox]{
        display:none;
    }
    input[type=checkbox] + div.label_box_inner{
        --tw-bg-opacity: 1 !important;
        background-color: rgb(209 213 219 / var(--tw-bg-opacity)) !important;
    }
    input[type=checkbox]:checked + div.label_box_inner{
        background-color: rgb(8 145 178 / var(--tw-bg-opacity)) !important;
        color:white;
    }
    input[type=checkbox] + div.label_box_inner:before{
        /*content:url('/icons/empty_check_circle.svg');*/
        content: "\f058";
        box-sizing: border-box;
        display:inline-block;
        font-family: "Font Awesome 6 Pro";
        font-size:26px;
        color:#666;
        margin-right:10px;
        font-weight: 400;
    }
    input[type=checkbox]:checked + div.label_box_inner:before{
        color:blue;
        font-weight: 900;
    }
    .accordion-item-toggle.accordion-toggle-icon{
        padding:8px 36px 8px 16px;
    }
    .accordion-toggle-icon:before{
        font-family: framework7-core-icons;
        font-weight: 400;
        font-style: normal;
        line-height: 1;
        letter-spacing: normal;
        text-transform: none;
        white-space: nowrap;
        word-wrap: normal;
        direction: ltr;
        -webkit-font-smoothing: antialiased;
        text-rendering: optimizeLegibility;
        -moz-osx-font-smoothing: grayscale;
        font-feature-settings: 'liga';
        text-align: center;
        display: block;
        width: 100%;
        height: 100%;
        font-size: 20px;
        position: absolute;
        top: 50%;
        width: 8px;
        height: 14px;
        margin-top: -7px;
        font-size: var(--f7-list-chevron-icon-font-size);
        line-height: 14px;
        color: var(--f7-list-chevron-icon-color);
        pointer-events: none;
        right: calc(var(--f7-list-item-padding-horizontal) + var(--f7-safe-area-right));
        content: 'chevron_down';
        width: 14px;
        height: 8px;
        margin-top: -4px;
        line-height: 8px;
    }
    .accordion-item-opened .accordion-toggle-icon:before{
        content: 'chevron_up';
        width: 14px;
        height: 8px;
        margin-top: -4px;
        line-height: 8px;
    }
    .after-line{
        position:relative;
    }
    .after-line:after{
        content: '';
        position: absolute;
        background-color: var(--f7-list-item-border-color);
        display: block;
        z-index: 15;
        top: auto;
        right: auto;
        bottom: 0;
        left: 0;
        height: 1px;
        width: 100%;
        transform-origin: 50% 100%;
        transform: scaleY(calc(1 / var(--f7-device-pixel-ratio)));
    }
</style>

<script>
  export default async (props, { $$f7 ,$on, $update }) => {
    let defaultid = '{{$glbRandomId}}';
    let app_name = '{{config('app.name')}}'
    var checked = true;
    var area_selected={};
    var areas = @json( config('customsido.simple') );
    var areasArr = [];
    var sigungu;
    var info;

    for (var key in areas){
        areasArr.push({val:key,label:areas[key]})
    }
    let inputSet = [
        {'type':'text', 'name':'userid','label':'아이디','disabled': ( (parseInt(props.id)|0) != 0 ? true: false ),'readonly':false, 'required':true, 'icon':{'ico':null, 'class':''}},
        {'type':'text', 'name':'name','label':'이름','disabled':false,'readonly':false, 'required':true, 'icon':{'ico':null, 'class':''}},
        {'type':'text', 'name':'tel','label':'전화번호','disabled':false,'readonly':false, 'required':true, 'icon':{'ico':null, 'class':''}},
    ];
    let inputSetPwd=[
        {'type':'text', 'name':'password','label':'비밀번호','disabled': ( (parseInt(props.id)|0) != 0 ? false: true ),'readonly':false, 'required':true, 'icon':{'ico':null, 'class':''}},
    ];
    const prevent=(e)=>{
        e.preventDefault()
        return false;
    } 
    
    const updateItem = (e) =>{
        var form = $(e.target).closest('form')
        var formdata = new FormData(form[0]);
        app.dialog.confirm('수정하시겠습니까?',app_name, function(){
            formdata.append("_method", "put");
            axios.post(`/api/djemals/partner/${props.id}/area`,formdata).then(res=>{
                toastr('수정하였습니다')
                custEvents.emit('areaChanged',{partner_id: props.id})
            })
        })
    }
    const updateItemSigungu=()=>{
        @if( !config('site.use_sigungu',false) )
            var formdata = new FormData( document.getElementById('avail_sido_form') );
        @else
            var formdata = new FormData( document.getElementById('avail_sigungu_form') );
        @endif
        
        app.dialog.confirm('수정하시겠습니까?',app_name, function(){
            formdata.append("_method", "put");
            axios.post(`/api/djemals/partner/${props.id}/area`,formdata).then(res=>{
                toastr('수정하였습니다')
                custEvents.emit('areaChanged',{partner_id: props.id})
                app.popup.close()
            })
        })
    }

    const saveDefault=(e)=>{
        var form = $(e.target).closest('form')
        var formdata = new FormData(form[0]);
        app.dialog.confirm('수정하시겠습니까?',app_name, function(){
            formdata.append("_method", "put");
            axios.post(`/api/djemals/partner/${props.id}`,formdata).then(res=>{
                toastr('수정하였습니다')
                custEvents.emit('partnerInfoChanged',{partner_id: props.id})
            })
        })
    }
    const savePwd=(e)=>{
        var form = $(e.target).closest('form')
        var formdata = new FormData(form[0]);
        app.dialog.confirm('수정하시겠습니까?',app_name, function(){
            formdata.append("_method", "put");
            axios.post(`/api/djemals/partner/${props.id}/pwd`,formdata).then(res=>{
                toastr('수정하였습니다')
            })
        })
    }
    function getData(){
        if( typeof props.id != 'undefined' && (parseInt(props.id)|0) != 0 ){
            axios.get(`/api/djemals/partner/${props.id}/area`).then(res=>{
                var temp = res.data.data
                for( var key of temp ){
                    console.log ( key)
                    area_selected[key] = true;
                    //$(`#area_${key}`).prop('checked',true)
                }
                $update();
            })
            axios.get(`/api/djemals/partner/${props.id}`).then(res=>{
                info = res.data.data
                $update();
            })
        }
    }
    function getSigungu(){
        axios.get(`/api/sigungu`).then(res=>{
            sigungu =  res.data.data
            $update();
            console.log ( sigungu )
        })
    }
    $on('popupOpened', (popup) => {
        getData()
        getSigungu()
    });
    $on('popupClose', () => {
      app.dialog.close()
    });
    return $render
  }
</script>