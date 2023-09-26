<template>
  <div class="page mainpage page-{{$pagename}}">
	  <x-front.header title="{{config('app.name')}}"  />
      <div class="page-content">
		<div>
			<!-- content -->
			<div>
				<div class="hbox tw-justify-around">
					<button type="button" @click=${getPlace}>
						위취
					</button>
					<button type="button" @click="${getToekn}">
						fcm
					</button>
				</div>
			</div>
			<!-- /content -->
		</div>
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
		const getPlace = ()=>{
			getGeo()
		}
		const getToekn = ()=>{
			var token = getFcmToken()
			toastr(token)
		}
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
	/*
	  export default (props, { $, $f7, $f7router }) => {
		console.log( $f7router.currentRoute )
		const randomid = getRandom();
		const signIn = () => {
			let form = new FormData(document.getElementById('form' + randomid))
			axios.post( '/login', form ).then( res=>{
				if (app.views.main.router.currentRoute.hasOwnProperty('name') && app.views.main.router.currentRoute.name=='login') app.views.main.router.back()
				else reloadpage();
			})
		}

		return $render;
	  };
  */
</script>  