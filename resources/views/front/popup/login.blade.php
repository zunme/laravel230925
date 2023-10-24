<template>
    <div class="popup pop-{{$pagename}}" data-backdrop="true">
        <div class="page noselect" data-name="pop_{{$pagename}}">
            <div class="navbar">
                <div class="navbar-bg"></div>
                <div class="navbar-inner">
                    <div class="left"></div>
                    <div class="title">기본정보</div>
                    <!--div class="right">
                        <a href="#" class="link popup-close">Close</a>
                    </div-->
                </div>
            </div>
            <div class="page-content pop-page-{{$pagename}}">
            content
            </div>
        </div>
    </div>
</template>

<style>
  .popup.pop-{{$pagename}}{
	--f7-popup-tablet-height : 70vh;
	--f7-popup-tablet-width: 600px;
	--f7-navbar-title-margin-left:16px;
  }
  .page-content.pop-page-{{$pagename}} {
    padding-left: 10px;
    padding-right: 10px;
  }
</style>

<script>
  export default async (props, { $$f7 ,$on, $update }) => {
    let defaultid = '{{$glbRandomId}}';
    
    $on('popupOpened', (popup) => {
      console.log ("popopen")
    });
    $on('popupClose', () => {
      console.log ("popopclose")
    });
    return $render
  }
</script>