<template>
<div class="page no-toolbar no-navbar no-swipeback login-screen-page tw-bg-gray-200 dark:tw-bg-gray-900">
		<div class="page-content login-screen-content tw-bg-gray-200 dark:tw-bg-gray-900 tw-border-init tw-solid">
						<section class="">
			  <div class="tw-flex tw-flex-col tw-items-center tw-justify-center tw-px-6 tw-py-8 tw-mx-auto md:tw-h-screen lg:tw-py-0">
				  <a href="#" class="tw-flex tw-items-center tw-mb-6 tw-text-2xl tw-font-semibold tw-text-gray-900 dark:tw-text-white">
					  					  	<span>{{config('app.name')}}</span>
					  					  
				  </a>
				  <div class="tw-w-full tw-bg-white tw-rounded-lg tw-shadow dark:tw-border md:tw-mt-0 sm:tw-max-w-md xl:tw-p-0 dark:tw-bg-gray-800 dark:tw-border-gray-700">
					  <div class="tw-p-6 tw-space-y-4 md:tw-space-y-6 sm:tw-p-8">
						  <h1 class="tw-text-xl tw-font-bold tw-leading-tight tw-tracking-tight tw-text-gray-900 md:tw-text-2xl dark:tw-text-white">
							  
						  </h1>
						  <form class="tw-space-y-4 md:tw-space-y-6" action="#" id="form${randomid}">
							  <div>
								  <label class="tw-block tw-mb-2 tw-text-sm tw-font-medium tw-text-gray-900 dark:tw-text-white">아이디</label>
								  <input type="text" name="userid"
										 class="tw-bg-gray-50 tw-border tw-border-gray-300 tw-text-gray-900 sm:tw-text-sm tw-rounded-lg focus:tw-ring-blue-600 focus:tw-border-blue-600 tw-block tw-w-full tw-p-2.5 dark:tw-bg-gray-700 dark:tw-border-gray-600 dark:tw-placeholder-gray-400 dark:tw-text-white dark:tw-focus:ring-blue-500 dark:tw-focus:border-blue-500 tw-solid" 
										 placeholder="name@company.com" required=""
										 />
							  </div>
							  <div>
								  <label for="password" class="tw-block tw-mb-2 tw-text-sm tw-font-medium tw-text-gray-900 dark:tw-text-white">패스워드</label>
								  <input type="password" name="password" placeholder="••••••••" 
										 class="tw-bg-gray-50 tw-border tw-border-gray-300 tw-text-gray-900 sm:tw-text-sm tw-rounded-lg focus:tw-ring-blue-600 focus:tw-border-blue-600 tw-block tw-w-full tw-p-2.5 dark:tw-bg-gray-700 dark:tw-border-gray-600 dark:tw-placeholder-gray-400 dark:tw-text-white dark:tw-focus:ring-blue-500 dark:tw-focus:border-blue-500 tw-solid" required="" />
							  </div>
							  <div class="tw-flex tw-items-center tw-justify-between">
								  <div class="tw-flex tw-items-start">
									  <div class="tw-flex tw-items-center tw-h-5">
										<input 
											   type="checkbox" 
											   name="remember_me"
											   class="tw-w-4 tw-h-4 tw-border tw-border-gray-300 tw-rounded tw-bg-gray-50 
													  tw-focus:ring-3 tw-focus:ring-blue-300 dark:tw-bg-gray-700 dark:tw-border-gray-600 dark:tw-focus:ring-blue-600
													  dark:tw-ring-offset-gray-800" 
										/>
									  </div>
									  <div class="tw-ml-3 tw-text-sm">
										<label for="remember" class="tw-text-gray-500 dark:tw-text-gray-300">기억하기</label>
									  </div>
								  </div>
								  <!--a href="/forgot-password" class="external tw-text-sm tw-font-medium tw-text-blue-600 tw-hover:underline dark:tw-text-blue-500">비밀번호 찾기</a-->
							  </div>
							  <button type="button" 
									  class="button button-fill color-primary p(20/10)! tw-font-bold tw-text-base tw-text-center tw-w-full"
									  @click=${signIn}
							  >
								  로그인
							  </button>
							  <p class="tw-text-right tw-text-sm tw-font-light tw-text-gray-500 dark:tw-text-gray-400">
								  <!--a href="/forgot-password">패스워드 찾기</a-->
								  <a href="/join" class="tw-font-medium tw-text-gray-600">가입하기</a>
							  </p>
						  </form>
					  </div>
				  </div>
			  </div>
			</section>
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
		
		const signIn = () => {
			let form = new FormData(document.getElementById('form' + randomid))
			axios.post( '/login', form ).then( res=>{
				if (false && app.views.main.router.currentRoute.hasOwnProperty('name') && app.views.main.router.currentRoute.name=='login') app.views.main.router.back()
				else {
					var url = '/'
					if (app.views.main.router.url !='/login') url = app.views.main.router.currentRoute.url
					else url = app.views.main.history[0]
					console.log ( "replace "+ url)
					window.location.replace(url)
				}
			})
		}
        return $render;
    }
</script> 