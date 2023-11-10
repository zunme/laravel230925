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
                
                <form @submit=${prevent}>
                    <my-input-lists data=${info} list=${inputSet}></my-input-lists>
                    <div class="tw-w-full tw-flex tw-justify-end">
                        <button type="button"
                            class="tw-inline-flex tw-px-4 tw-py-1 tw-bg-green-700 tw-text-white tw-rounded"
                            @click=${saveDefault}
                        >
                            파트너 생성
                        </button>
                    </div>
                </form>
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
    let info={}
    
    let inputSet = [
        {'type':'text', 'name':'userid','label':'아이디','disabled': ( (parseInt(props.id)|0) != 0 ? true: false ),'readonly':false, 'required':true, 'icon':{'ico':null, 'class':''}},
        {'type':'text', 'name':'name','label':'이름','disabled':false,'readonly':false, 'required':true, 'icon':{'ico':null, 'class':''}},
        {'type':'text', 'name':'tel','label':'전화번호','disabled':false,'readonly':false, 'required':true, 'icon':{'ico':null, 'class':''}},
        {'type':'text', 'name':'password','label':'비밀번호','disabled': false,'readonly':false, 'required':true, 'icon':{'ico':null, 'class':''}},
    ];
    const prevent=(e)=>{
        e.preventDefault()
        return false;
    } 

    const saveDefault=(e)=>{
        var form = $(e.target).closest('form')
        var formdata = new FormData(form[0]);

        app.dialog.confirm('생성하시겠습니까?',app_name, function(){
            axios.post(`/api/djemals/partner`,formdata).then(res=>{
                toastr('생성하였습니다')
                custEvents.emit('partnerInfoChanged',{partner_id: props.id})
                app.popup.close()
                setTimeout(function(){
                    app.views.main.router.navigate(`/djemals/popup/partner/${res.data.data.id}`)
                }, 100)
            })
        })
    }
    $on('popupOpened', (popup) => {
    });
    $on('popupClose', () => {
      app.dialog.close()
    });
    return $render
  }
</script>