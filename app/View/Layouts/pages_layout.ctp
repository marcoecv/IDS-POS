<!DOCTYPE html>
<html>
    <head>
        <?php
            $urlCur = Router::url($this->here, true);
            $urlCur = strtolower($urlCur);
            $protocol = substr($urlCur, 0, stripos($urlCur, "//") + 2);
            $urlCur = str_replace($protocol, "", $urlCur);
            $urlCur = substr($urlCur, 0, stripos($urlCur, "/"));
            $urlCur = $protocol.$urlCur;
            
            $theme = $this->App->getDomain('theme');
        ?>
        <?php global $browser_cache_version;?>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
        
        <link rel="stylesheet" href="<?php echo $urlCur; ?>/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="<?php echo $urlCur; ?>/bootstrap/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="<?php echo $urlCur; ?>/css/jquery-ui.css">
          <!--  <link rel="stylesheet" href="/bootstrap/css/jquery.dataTables.min.css">-->
        <link rel="stylesheet" href="<?php echo $urlCur; ?>/plugins/montrezorro-bootstrap-checkbox/css/bootstrap-checkbox.css">
        <link rel="stylesheet" href="<?php echo $urlCur; ?>/plugins/Font-Awesome/3.0.2/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo $urlCur; ?>/plugins/Font-Awesome/3.0.2/css/font-awesome-ie7.min.css">
        <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' type='text/css' >
        <link rel='stylesheet' href='http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css' type='text/css' >
        
        <link rel="stylesheet/less" type="text/css" href="<?php echo $urlCur; ?>/css/offcanvas.less?v=<?php echo $browser_cache_version;?>" />
        <link rel="stylesheet" href="<?php echo $urlCur; ?>/css/bootstrap_fix.css?v=<?php echo $browser_cache_version;?>">
   <link rel="stylesheet/less" type="text/css"
              href="<?php echo $urlCur; ?>/css/sportbook_header.less?v=<?php echo $browser_cache_version; ?>"/>
        <link rel="stylesheet/less" type="text/css" href="<?php echo $urlCur; ?>/css/sportbook_icons.less?v=<?php echo $browser_cache_version;?>" />
        <link rel="stylesheet/less" type="text/css" href="<?php echo $urlCur; ?>/css/sportbook_site.less?v=<?php echo $browser_cache_version;?>" />
    
        <?php echo $this->Html->css('sportbook_custom.less?='.$browser_cache_version, ['rel' => 'stylesheet/less']); ?>
        
        <?php echo $this->Html->css('sportbook_external_app', array('inline' => false)); ?>
        <?php echo $this->Html->css('plugins/chosen.min'); ?>
        <?php echo $this->Html->script('plugins/chosen.jquery.min'); ?>
          <?php
        echo $this->Html->css('sportbook_custom.less?=' . $browser_cache_version, ['rel' => 'stylesheet/less']);
        echo $this->Html->css('sportbook'); //main Layout styles
        ?>
        <script src="<?php echo $urlCur; ?>/plugins/less/less.min.js" type="text/javascript"></script>       
        <script src='<?php echo $urlCur; ?>/bootstrap/js/jquery-1.9.1.js'></script>
        <script src='<?php echo $urlCur; ?>/bootstrap/js/jquery-ui.js'></script>
        <script src="<?php echo $urlCur; ?>/js/jsxcompressor.min.js"></script>
        <script src='<?php echo $urlCur; ?>/js/jquery-ui.js'></script>
        <script src='<?php echo $urlCur; ?>/js/jquery.balloon.js'></script>
        <script src='<?php echo $urlCur; ?>/bootstrap/js/bootstrap.min.js'></script>
        <script src='<?php echo $urlCur; ?>/js/alasql/alasql.min.js'></script>
        <script src='<?php echo $urlCur; ?>/js/alasql/linq.min.js'></script>
        <!--script type="text/javascript" src="/js/slim-scroll/jquery.slimscroll.js"></script-->
        <script src='<?php echo $urlCur; ?>/js/jssor.js'></script>
        <script src='<?php echo $urlCur; ?>/js/jssor.slider.js'></script>
        <script src='<?php echo $urlCur; ?>/plugins/montrezorro-bootstrap-checkbox/js/bootstrap-checkbox.js'></script>
        <script src='<?php echo $urlCur; ?>/bootstrap/js/offcanvas.js?v=<?php echo $browser_cache_version;?>'></script>
        
        <?php echo $this->Html->script('plugins/Spin.js?='.$browser_cache_version); ?>
        <?php echo $this->Html->script('functions.js?='.$browser_cache_version); ?>
    </head>
    <body class='md' style="background-image: url('<?php echo $urlCur; ?>/theme/Jueguelo/img/custom_site/backSportbook.png');">
        
        <script>
            var _LINE_TYPES = '<?php echo $this->App->getDomain('LineTypes'); ?>';
            var availableCategories = <?= json_encode($availableCategories)?>;
        </script>
        <center>
            <div id="loader-wrapper"></div>
            <div class="maxLengthMainWrap">
                <?php echo $this->element('Sportbook/header_pv',array('username'=>$usersAuth['customerId'], 'company'=>$usersAuth['db']));?>
                <?php echo $this->fetch('content'); ?>
            </div>
        </center>
        
        <?php //echo $this->element('Sportbook/footer',array('username'=>$usersAuth['customerId'], 'company'=>$usersAuth['db']));?>
    </body>
    <style>
        body.xs .navbar-custom.mobile .nav li a .mainMenuLi .mainMenuContent {
            margin-left: calc((100% - 125px)/2);
        }
    
        .maxLengthMainWrap{
            max-width: 100%;
            position: inherit;
            margin-top: 0px;
        }
        
        #my_iframe{
            height: 100%;
            width: 100%;
            background: #FFFFFF;
            max-width: 1300px;
            border: hidden;
        }
        
		body.xs #my_iframe{
			margin-top: 10px;
		}
		
        body.xs #divHeader{
            background-image: none;
        }
        
        body.xs .maxLengthMainWrap{
            position: inherit;
        }
    </style>
    <script>		
		function setBodyType(){
			var winSize=getCurrentSize();
			
			var body=$("body");
			
			if(!body.hasClass(winSize))
				body.addClass(winSize);
			
			if(body.hasClass("xs") && winSize!="xs")
				body.removeClass('xs');
			
			if(body.hasClass("sm") && winSize!="sm")
				body.removeClass('sm');
			
			if(body.hasClass("md") && winSize!="md")
				body.removeClass('md');
			
			if(body.hasClass("lg") && winSize!="lg")
				body.removeClass('lg'); 
			
			$("#my_iframe").height($(window).height() - $("#divHeader").height());
			$("#my_iframe").width($(window).width()-10);
		}
		
		setBodyType();

		$(document).ready(function(){
			window.onresize = function(){
				setBodyType();
				//ajustScroller();
			};
                        
     
                        
			setBodyType();
			//initScroller();
		});
    </script>
</html>
