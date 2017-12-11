<style>
    body.lg .iframe-container,
	body.sm .iframe-container,
	body.md .iframe-container{
        -webkit-overflow-scrolling: touch;
        overflow-y: scroll;
        height: 100%;
        padding-top: 30px;
		margin-left: 9px;
        position: absolute;
        width: 100%;
    }
    @media screen and (max-width: 767px) {
        .iframe-container{
            padding-top: 0px;        
        } 
    }
</style>

<div class="iframe-container">
	 <iframe id='my_iframe'></iframe>
</div>

<script> 
	var _urlMobile = "<?php echo $url['mobile']; ?>";
	var _urlDesktop = "<?php echo $url['desktop']; ?>";
	
    $(document).ready(function(){
        $('#navbar li').removeClass('active');
        $("#navbar .nav .mainMenu a .icoLiveDealer").parents(".mainMenu").addClass('active');

		var url=document.URL;
		var isSafari = (/Safari/.test(navigator.userAgent)) && !(/Chrome/.test(navigator.userAgent)); 
		if (isSafari == true && url.indexOf("livebettingchecked")<0) {
				window.location.href = "http://horses.wager-info.com/initSession.php?url="+url; 
		}else{
			if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
				$('#my_iframe').attr('src', _urlMobile);
			}else{
				$('#my_iframe').attr('src', _urlDesktop);
			}
			$('#my_iframe').load();
		}
		
		$(window).resize(function() { 	
			if(getCurrentSize() != "xs"){
				loadIframe("my_iframe", _urlDesktop);
			}
			else{
				loadIframe("my_iframe", _urlMobile);
			}
		});
    });
	
	function loadIframe(iframeName, url) {
		var $iframe = $('#' + iframeName);
		if ($iframe.length) {
			$iframe.attr('src',url);
			$iframe.load();
			return false;
		}
		return true;
	}
</script>

 

