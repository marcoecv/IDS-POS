<?php
	$urlCur = Router::url($this->here, true);
	$urlCur = strtolower($urlCur);
	$protocol = substr($urlCur, 0, stripos($urlCur, "//") + 2);
	$urlCur = str_replace($protocol, "", $urlCur);
	$urlCur = substr($urlCur, 0, stripos($urlCur, "/"));
	$urlCur = $protocol.$urlCur;
?>


<?php echo $this->Html->script('jquery-1.11.2.min'); ?>
<?php echo $this->Html->script('jquery-ui'); ?>
<?php echo $this->Html->script('../bootstrap/js/bootstrap.min'); ?>
<?php echo $this->Html->script('../bootstrap/js/offcanvas'); ?>
<?php echo $this->Html->script('/js/functions'); ?>

<?php echo $this->Html->css('../bootstrap/css/bootstrap', array('inline' => false)); ?>
<?php echo $this->Html->css('../bootstrap/css/bootstrap-theme.min', array('inline' => false)); ?>
<link rel="stylesheet/less" type="text/css" href="<?php echo $urlCur; ?>/css/sportbook_header.less" />
<link rel="stylesheet/less" type="text/css" href="<?php echo $urlCur; ?>/css/sportbook_custom.less" />
<?php echo $this->Html->css('sportbook_external_app', array('inline' => false)); ?>
<?php echo $this->Html->script('/plugins/less/less.min'); ?>

<?php if(isset($usersAuth)){ ?>
<?php echo $this->element('Sportbook/header',array('username'=>@$usersAuth['customerId'], 'company'=>@$usersAuth['db']));?>

<style>
	html,body{
		overflow:hidden;
		background-color: #212225;
	}
	
	#wrapper .overlay {
      background-color: black;
      opacity: 0.2;
      height: 200px;
      width: 100%;
      position: absolute;
      background-size: 60px 60px;
      background-image: url("/images/loading.gif");
      background-position: center;
      background-repeat: no-repeat;
      z-index: 9999 !important;
      display: none;
    }
	
    body.xs .navbar-custom.mobile .nav li a .mainMenuLi .mainMenuContent {
		margin-left: calc((100% - 125px)/2);
	}
	
	#content{
		overflow: hidden;	
	}
	
	#container #content {
		overflow-y: hidden;
	}
	
	#my_iframe{
		/*padding-top: 100px;*/
		padding-bottom: 0px;
		width: 100%;
		height: 100%;
		border-width: 0px;
	}
</style>

<div id="wrapper" class="scroll-wrapper" style="overflow:hidden;background-color:#212225;">
	<div class='overlay' id="divLoading"></div>
    <iframe id='my_iframe' crossorigin="anonymous" class='cashier' src="" height="950" width="100%" scrolling="no" style="overflow:hidden;"></iframe> 
</div>

<script>
    var _urlMobile = "<?php echo $url['mobile']; ?>";
	var _urlDesktop = "<?php echo $url['desktop']; ?>";

	//comienza el loading
	$("#wrapper .overlay").height($(window).height());
	$("#wrapper .overlay").width($(window).width());
	$("#wrapper .overlay").css("display", "block");
	
	setInterval(function(){ getInfoCustomer(); }, 1000);
	
    $(document).ready(function(){		
        $('#navbar li').removeClass('active');
		$("#navbar .nav .mainMenu a .icoCashier").parents(".mainMenu").addClass('active');

		var url=document.URL;
		var isSafari = (/Safari/.test(navigator.userAgent)) && !(/Chrome/.test(navigator.userAgent)); 
		if (isSafari == true) {
				window.location.href = _urlDesktop;
				//$('#my_iframe').attr('src', _urlMobile);
		}else{
			if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
				$('#my_iframe').attr('src', _urlMobile);
			}else{
				$('#my_iframe').attr('src', _urlDesktop);
			}
			$('#my_iframe').load();
		}
		
		$('#my_iframe').on('load', function(){
			$("#wrapper .overlay").css("display", "none");
		});
    });
</script>
<?php } ?>
