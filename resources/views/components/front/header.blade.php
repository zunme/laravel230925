<div class="navbar">
    <div class="navbar-bg"></div>
    <div class="navbar-inner navbar-inner-centered-title">
    <div class="left">
        @if($left =='back')
        <a class="link back"><i class="icon icon-back"></i></a>
        @endif
    </div>
    <div class="title hbox! pack! font(18px) font(16)! ">
    @if ( $title !='')
		@if( config('site.imglogo') )
        <img class="" src="{{config('site.imglogo')}}" alt="logo" /> 
		@endif
        <div class="">{{$title}}</div>
        
    @else
        @if( config('site.logo') !='')
        <div class="" style="position:relative;">
            <!--img class="tw-w-6 tw-h-6 tw-mr-2 tw--rotate-45" src="{{config('site.logo')}}" alt="logo" / -->
            <img class="tw-h-6 tw-mr-2" src="{{config('site.logo')}}" alt="logo" />
        </div>
        @endif
    @endif
    </div>
    @if( $menu=="view" )
    <div class="right">
        <a class="link icon-only panel-open" data-panel="right"><i class="fa-solid fa-bars"></i></a>
    </div>
    @endif
    </div>
</div>