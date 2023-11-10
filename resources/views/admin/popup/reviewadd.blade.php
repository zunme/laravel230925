<template>
    <div class="popup pop-{{$pagename}}" data-backdrop="true">
        <div class="page noselect" data-name="pop_{{$pagename}}">
            <div class="navbar">
                <div class="navbar-bg"></div>
                <div class="navbar-inner">
                    <div class="left"></div>
                    <div class="title">리뷰작성</div>
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
                        ${ info.id ? $h`
                            <a href="#" class="tw-inline-flex tw-px-4 tw-py-1 tw-bg-green-700 tw-text-white tw-rounded" @click=${updateItem}>수정</a>
                        `:$h`
                            <a href="#" class="tw-inline-flex tw-px-4 tw-py-1 tw-bg-green-700 tw-text-white tw-rounded" @click=${saveItem}>저장</a>
                        `}
                        
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
        var form = $(e.target).closest('form')
        var formdata = new FormData(form[0]);
        app.dialog.confirm('저장하시겠습니까?',app_name, function(){
            axios.post('/api/djemals/review',formdata).then(res=>{
                toastr('저장하였습니다')
                custEvents.emit('reviewChanged',{})
                app.popup.close()
            })
        })
    }
    const updateItem = (e) =>{
        var form = $(e.target).closest('form')
        var formdata = new FormData(form[0]);
        app.dialog.confirm('수정하시겠습니까?',app_name, function(){
            formdata.append("_method", "put");
            axios.post(`/api/djemals/review/${info.id}`,formdata).then(res=>{
                toastr('수정하였습니다')
                custEvents.emit('reviewChanged',{} )
                app.popup.close()
            })
        })
    }
    const saveItemPrc = (e)=>{
        var id = props.id
        
    }
    const removeItem = (e)=>{
        app.dialog.confirm('삭제하시겠습니까?','2424-2424', removeItemPrc )
    }
    const removeItemPrc = (e)=>{
        var id = props.id
        app.dialog.alert('기능이 구현되지 않았습니다.')
    }
    let movetype = @json(config('site.move_type')) ;
    let movetype_options=[];
    let star_points=[{val:5,label:"5"},{val:4,label:"4"},{val:3,label:"3"},{val:2,label:"2"},{val:1,label:"1"}];

    for (var key in movetype){
        movetype_options.push({val:key,label:movetype[key].title})
    }
	let inputSet = [
            {'type':'hidden', 'name':'move_request_id'},
            {'type':'select', 'name':'move_type','label':'이사유형','disabled':false,'readonly':false, 'required':true, 'icon':{'ico':null, 'class':''}
                ,'options':movetype_options
            },
            {'type':'text', 'name':'name','label':'이름','disabled':false,'readonly':false, 'required':true, 'icon':{'ico':null, 'class':''}},
            {'type':'select', 'name':'star_point','label':'점수','disabled':false,'readonly':false, 'required':true, 'icon':{'ico':null, 'class':''}
                ,'options':star_points
            },
            {'type':'text', 'name':'area','label':'지역','disabled':false,'readonly':false, 'required':true, 'icon':{'ico':null, 'class':''}},
            {'type':'date', 'name':'move_date','label':'이사일','disabled':false,'readonly':false, 'required':true, 'icon':{'ico':null, 'class':''}},
            {'type':'date', 'name':'write_at','label':'작성일','disabled':false,'readonly':false, 'required':true, 'icon':{'ico':null, 'class':''}},
            {'type':'select', 'name':'use_front','label':'프론트 보이기','disabled':false,'readonly':false, 'required':true, 'icon':{'ico':null, 'class':''}
                ,'options':[
                    {'val':'Y', 'label':'노출'},
                    {'val':'N', 'label':'비노출'}
                ]
            },
            {'type':'textarea', 'name':'comment','label':'내용','disabled':false,'readonly':false, 'required':true,hidemedia:true,},
		]
 
    function getData(){
        console.log (typeof props.subid)
        if( typeof props.id != 'undefined' && props.id>0){
            axios.get(`/api/djemals/reqreview/${props.id}`).then(res=>{
                info = res.data.data
                $update();
            })
        }else if( typeof props.subid != 'undefined' && props.subid>0){
            axios.get(`/api/djemals/review/${props.subid}`).then(res=>{
                info = res.data.data
                $update();
            })
        }else {
            info = []
            $update();
        }
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