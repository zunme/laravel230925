<template>
    <div class="popup pop-{{$pagename}}" data-backdrop="true">
        <div class="page noselect" data-name="pop_{{$pagename}}">
            <div class="navbar">
                <div class="navbar-bg"></div>
                <div class="navbar-inner">
                    <div class="left"></div>
                    <div class="title">이사 신청 정보</div>
                    <div class="right">
                        <a href="#" class="link popup-close">Close</a>
                    </div>
                </div>
            </div>
            <div class="page-content pop-page-{{$pagename}}">
                <section class="content-section">
                  <form @submit=${prevent}>
                    ${info ? $h`
                    <my-input-lists data=${info} list=${inputSet}></my-input-lists>
                    <div class="tw-px-10 tw-flex tw-justify-end tw-gap-x-4">
                        <a href="#" class="tw-inline-flex tw-px-4 tw-py-1 tw-bg-red-700 tw-text-white tw-rounded" @click=${removeItem}>삭제</a>
                        <a href="#" class="tw-inline-flex tw-px-4 tw-py-1 tw-bg-green-700 tw-text-white tw-rounded" @click=${saveItem}>저장</a>
                    </div>
                    `:''}

                    </form>
                </section>
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
</style>

<script>
  export default async (props, { $$f7 ,$on, $update }) => {
    let defaultid = '{{$glbRandomId}}';
    let app_name = '{{config('app.name')}}'
    var info;
    
    const prevent=(e)=>{
        e.preventDefault()
        return false;
    } 
    const saveItem = (e)=>{
        app.dialog.confirm('저장하시겠습니까?',app_name, saveItemPrc )
    }
    const saveItemPrc = (e)=>{
        var id = props.id
        app.dialog.alert('기능이 구현되지 않았습니다.')
    }
    const removeItem = (e)=>{
        app.dialog.confirm('삭제하시겠습니까?','2424-2424', removeItemPrc )
    }
    const removeItemPrc = (e)=>{
        var id = props.id
        app.dialog.alert('기능이 구현되지 않았습니다.')
    }
	let inputSet = [
			{'type':'text', 'name':'move_type_label','label':'이사유형','disabled':true,'readonly':false, 'required':true, 'icon':{'ico':null, 'class':''}},

            {'type':'text', 'name':'name','label':'신청인 이름','disabled':true,'readonly':false, 'required':true, 'icon':{'ico':null, 'class':''}},
            {'type':'text', 'name':'tel','label':'전화번호','disabled':true,'readonly':false, 'required':true, 'icon':{'ico':null, 'class':''}},

            {'type':'date', 'name':'move_date','label':'이사일','disabled':false,'readonly':false, 'required':true, 'icon':{'ico':null, 'class':''}},
			{'type':'select', 'name':'req_status','label':'진행상태','disabled':false,'readonly':false, 'required':true, 'icon':{'ico':null, 'class':''}
                ,'options':[
                    {val:'Ready',label:'Ready'},
                    {val:'Matching',label:'Matching'},
                    {val:'Matched',label:'Matched'},
                    {val:'Done',label:'Done'},
                ]
            },
			{'type':'text', 'name':'from_address','label':'출발지','disabled':true,'readonly':false, 'required':true, 'icon':{'ico':null, 'class':''}},
            {'type':'select', 'name':'from_floor','label':'출발지 층','disabled':true,'readonly':false, 'required':true, 'icon':{'ico':null, 'class':''}
                ,'options':@json( config("moveinfo.floor"))
            },

            {'type':'text', 'name':'to_address','label':'도착지','disabled':true,'readonly':false, 'required':true, 'icon':{'ico':null, 'class':''}},
            {'type':'select', 'name':'to_floor','label':'도착지 층','disabled':true,'readonly':false, 'required':true, 'icon':{'ico':null, 'class':''}
                ,'options':@json( config("moveinfo.floor"))
            },

            {'type':'select', 'name':'keep','label':'보관이사','disabled':false,'readonly':false, 'required':true, 'icon':{'ico':null, 'class':''}
                ,'options':[
                    {val:'Y',label:'보관이사 신청'},
                    {val:'N',label:'보관이사 미신청'},
                ]
            },
		]
 
    function getData(){
        axios.get(`/api/djemals/reqinfo/${props.id}`).then(res=>{
            info = res.data.data
            $update();
        })
    }

    $on('popupOpened', (popup) => {
        getData()
    });
    $on('popupClose', () => {
      app.dialog.close()
    });
    return $render
  }
</script>