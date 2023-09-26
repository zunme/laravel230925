<div class="navbar">
      <div class="navbar-bg"></div>
      <div class="navbar-inner navbar-inner-centered-title ">
        <div class="left">
          @if(isset($left) && $left =='back')
			<a class="link back"><i class="fa-solid fa-arrow-left"></i></a>
		  @endif
        </div>
        <div class="title tw-flex tw-items-center">
			{{$title}}
		</div>
		@if( $menu=="view" )
        <div class="right">
		  <a class="link icon-only panel-open" data-panel="left"><i class="fa-solid fa-bars"></i></a>
        </div>
		@endif
      </div>
    </div>