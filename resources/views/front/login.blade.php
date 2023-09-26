<template>
<div class="page no-navbar no-toolbar no-swipeback login-screen-page">
  <div class="page-content login-screen-content">
    <div class="login-screen-title">{{config("app.name")}}</div>
    <form>
      <div class="list">
        <ul>
          <li class="item-content item-input">
            <div class="item-inner">
              <div class="item-title item-label">아이디</div>
              <div class="item-input">
                <input type="text" name="username" placeholder="아이디" />
              </div>
            </div>
          </li>
          <li class="item-content item-input">
            <div class="item-inner">
              <div class="item-title item-label">패스워드</div>
              <div class="item-input">
                <input type="password" name="password" placeholder="패스워드" />
              </div>
            </div>
          </li>
        </ul>
      </div>
      <div class="list">
        <ul>
          <li><a href="#" class="list-button">회원가입</a></li>
        </ul>
        <div class="block-footer">
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
          <p><a href="#" class="close-login-screen">Close Login Screen</a></p>
        </div>
      </div>
    </form>
  </div>
</div>
</template>
<script>
    export default function (props, ctx) {
        var $$f7router = ctx.$f7router;
        var $$el = ctx.$el;
        var $$f7 = ctx.$f7;
        var $$onMounted = ctx.$onMounted;
        var $$on = ctx.$on;
		
		var randomid ='{{$glbRandomId}}';
		
		$$on('pageBeforeIn', (e, page) => {
            console.log( "before in")
        })
        $$on('pageAfterIn', (e, page) => {
			console.log( "pageAfterIn")
        })
        $$on('pageAfterOut',()=>{
			console.log( "pageAfterOut")
        })
        function logout(){
            logout_global();
        }
        return $render;
    }
</script> 