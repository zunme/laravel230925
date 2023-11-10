<div x-data="{
    open:false,
    open_sub : false,
    name :'',
    tel:'',
    checkedAll:false,
    checked:false,
    agree1:false,
    agree2:false,
    agree3:false,
    agree4:false,
    goto(){
        location.replace('/v2')
    },
    submodal(){
        this.open = false;
        this.open_sub = true;
    },
    checkForm() {
        var formdata = new FormData( document.getElementById(`main_home_form`) )
        formdata.append('to_data', JSON.stringify(toAddress) ) 
        formdata.append('from_data', JSON.stringify(fromAddress) ) 
        formdata.append('ispop', this.open )
        axios.post( '/move/reg', formdata).then(res=>{
            var data = res.data
            if( data.message =='Unauthorized'){
                this.open = true
            }else{
                this.submodal()
            }
        }).catch(function (error) {
            var data, message;
            window.test = error
            try{
                message =error.response.data.errors[Object.keys(test.response.data.errors)[0]][0]
            }catch(e){
                try{
                    message = error.response.data.message ?? '오류가 발생하였습니다.'
                }catch(e){
                    message = '오류가 발생하였습니다'
                }
            }
            Toastify({
                text: message,
                duration: 1500,
                newWindow: false,
                close: false,
                gravity: 'bottom',
                position: 'center',
                offset: {
                    x: 0, 
                    y: '30vh'
                },
                stopOnFocus: false,
                style: {
                    'background': 'black',color:'white'
                },
                //onClick: function(){}
            }).showToast();
        })
    },
    changeCheck(value){
        this.agree1 = this.agree2 = this.agree3 = this.agree4 = this.checkedAll
    },
    changedAgree(){
        if( this.agree1 && this.agree2 && this.agree3 && this.agree4 )  this.checkedAll = true;
        else this.checkedAll = false
    }
}">
<input type="hidden" name="name" x-model="name" />
<input type="hidden" name="tel" x-model="tel" />
<input type="hidden" name="agree1" x-model="agree1" />
<input type="hidden" name="agree2" x-model="agree2" />
<input type="hidden" name="agree3" x-model="agree3" />
<input type="hidden" name="agree4" x-model="agree4" />

<button type="button" class="btn_common btn__estimate btn__popup__getestimate" @click="checkForm()">이사견적 받기</button>

<template x-teleport="body">
    <div class="popup getestimate" :class="{ 'active':open }">
        <div class="content">
            <button class="popup__close_new" @click="open = false">
                <img src="./img/popup_close.png" alt="close">
            </button>
            <h2>기본정보</h2>

            <div class="getestimate__search">
                <input type="text" x-model="name" placeholder="고객명">
                <input type="number" x-model="tel" placeholder="휴대폰번호">

                <div class="br1"></div>

                <label class="checkboxLabel2">
                    <input type="checkbox" value="Y" x-model="checkedAll" @change="changeCheck(event)">
                    <i></i>
                    <b>전체 동의합니다.</b>
                </label>
                <div class="checkboxLabel2_outer">
                    <label class="checkboxLabel2">
                        <input type="checkbox" value="Y" x-model="agree1" @change="changedAgree()">
                        <i></i>
                        <p>
                            <span>만 14세 이상입니다.</span>
                            <span class="c_violet">(필수)</span>
                        </p>
                    </label>
                    <label class="checkboxLabel2">
                        <input type="checkbox" value="Y"  x-model="agree2"  @change="changedAgree()">
                        <i></i>
                        <p>
                            <span>개인정보 수집 및 이용 동의</span>
                            <span class="c_violet">(필수)</span>
                            <a href="javascript:;">보기</a>
                        </p>
                    </label>
                    <label class="checkboxLabel2">
                        <input type="checkbox" value="Y" x-model="agree3" @change="changedAgree()">
                        <i></i>
                        <p>
                            <span>개인정보 제3자 제공 동의</span>
                            <span class="c_violet">(필수)</span>
                            <a href="javascript:;">보기</a>
                        </p>
                    </label>
                    <label class="checkboxLabel2">
                        <input type="checkbox" value="Y" x-model="agree4" @change="changedAgree()">
                        <i></i>
                        <p>
                            <span>광고 수신 동의(선택)</span>
                            <a href="javascript:;">보기</a>
                        </p>
                    </label>
                </div>
                <button class="btn_common_popup" @click="checkForm()">견적 신청</button>
            </div>
        </div>
        <div class="bg_new" @click="open = false"></div>
    </div>
</template>

<template x-teleport="body">
    <div class="popup estimate" :class="{ 'active':open_sub }">
        <div class="content">
            <button class="popup__close_new"  @click="goto()">
                <img src="./img/popup_close.png" alt="close">
            </button>
            <h2 class="pc">이사업체를 찾는중입니다.</h2>

            <div class="estimate__search">
                <div class="estimate__search__inner">
                    <h3 class="mo">이사업체를 찾는중입니다.</h3>
                    <img src="./img/ico_estimate_search.png" alt="search">
                    <b>24시간 내</b><span>에 조건에 맞는</span><br>
                    <b>최대 3개 이사업체</b><span>의 정보를</span><br>
                    <span>알림톡 또는 문자로 보내드리겠습니다.</span>
                </div>
            </div>
        </div>
        <div class="bg_new"  @click="goto()"></div>
    </div>
</template>

</div>