<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
    <head>
        <?php
        App::uses('Folder', 'Utility');
        App::uses('File', 'Utility');

        $urlCur = Router::url($this->here, true);
        $urlCur = strtolower($urlCur);
        $protocol = substr($urlCur, 0, stripos($urlCur, "//") + 2);
        $urlCur = str_replace($protocol, "", $urlCur);
        $urlCur = substr($urlCur, 0, stripos($urlCur, "/"));
        $urlCur = $protocol . $urlCur;

        $currentPath = getcwd();
        $searchPath = "app/";
        $currentPath = substr($currentPath, 0, strpos($currentPath, $searchPath)) . $searchPath;

        $theme = $this->App->getDomain('theme');
        ?>

        <?php global $browser_cache_version; ?>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
        <title><?php echo $this->fetch('title'); ?></title>
        <link rel="stylesheet" href="<?php echo $urlCur; ?>/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="<?php echo $urlCur; ?>/bootstrap/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="<?php echo $urlCur; ?>/plugins/Font-Awesome/3.0.2/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo $urlCur; ?>/plugins/Font-Awesome/3.0.2/css/font-awesome-ie7.min.css">
        <link rel="stylesheet" href="<?php echo $urlCur; ?>/css/jquery-ui.css">
        <link rel="stylesheet" href="<?php echo $urlCur; ?>/css/bmdash.min.css">
        <link rel="stylesheet" href="<?php echo $urlCur; ?>/css/skins/_all-skins.min.css">
        <link rel="stylesheet" href="<?php echo $urlCur; ?>/css/datepicker3.css">
        <link rel="stylesheet" href="/css/jqbtk.css">
        <?php $this->Html->css('bmdashassdas'); ?>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link rel="stylesheet/less" type="text/css" href="<?php echo $urlCur; ?>/css/offcanvas.less?v=<?php echo $browser_cache_version; ?>"/>
        <link rel="stylesheet" href="<?php echo $urlCur; ?>/css/bootstrap_fix.css?v=<?php echo $browser_cache_version; ?>">
        <link rel="stylesheet/less" type="text/css" href="<?php echo $urlCur; ?>/css/sportbook_header.less?v=<?php echo $browser_cache_version; ?>"/>
        <link rel="stylesheet/less" type="text/css" href="<?php echo $urlCur; ?>/css/sportbook_sportsmenu.less?v=<?php echo $browser_cache_version; ?>"/>
        <link rel="stylesheet/less" type="text/css" href="<?php echo $urlCur; ?>/css/sportbook_icons.less?v=<?php echo $browser_cache_version; ?>"/>
        <link rel="stylesheet/less" type="text/css" href="<?php echo $urlCur; ?>/css/sportbook_site.less?v=<?php echo $browser_cache_version; ?>"/>
        <link rel="stylesheet/less" type="text/css" href="<?php echo $urlCur; ?>/css/sportbook_betslip.less?v=<?php echo $browser_cache_version; ?>">
        <link rel="stylesheet/less" type="text/css" href="<?php echo $urlCur; ?>/css/sportbook_wagerReport.less?v=<?php echo $browser_cache_version; ?>">
        <link rel="stylesheet/less" type="text/css" href="<?php echo $urlCur; ?>/css/sportbook_overview.less?v=<?php echo $browser_cache_version; ?>"/>
        <link rel="stylesheet/less" type="text/css" href="<?php echo $urlCur; ?>/css/sportbook_games.less?v=<?php echo $browser_cache_version; ?>"/>
        
        <?php
        echo $this->Html->css('sportbook_custom.less?=' . $browser_cache_version, ['rel' => 'stylesheet/less']);
        echo $this->Html->css('sportbook'); //main Layout styles
        ?>
        <?php echo $this->Html->css('plugins/chosen/chosen.min'); ?>
        <?php echo $this->Html->script('plugins/chosen/chosen.jquery.min'); ?>
        
        <script src="<?php echo $urlCur; ?>/plugins/less/less.min.js" type="text/javascript"></script>
        <script src="<?php echo $urlCur; ?>/js/jsxcompressor.min.js"></script>
        <script src='<?php echo $urlCur; ?>/bootstrap/js/bootstrap.min.js'></script>
        <script src='<?php echo $urlCur; ?>/plugins/montrezorro-bootstrap-checkbox/js/bootstrap-checkbox.js'></script>
        <script src='<?php echo $urlCur; ?>/bootstrap/js/offcanvas.js?v=<?php echo $browser_cache_version; ?>'></script>
        <script src='<?php echo $urlCur; ?>/js/jquery.balloon.js'></script>
        <script src='<?php echo $urlCur; ?>/js/plugins/datepicker/bootstrap-datepicker.js'></script>
        <script src='<?php echo $urlCur; ?>/js/app.min.js'></script>
        <script src='<?php echo $urlCur; ?>/js/dashboard.js'></script>
        <script src="/js/jqbtk.js"></script>

        <?php echo $this->Html->css('plugins/bootstrap-datetimepicker.min'); ?>

        <?php echo $this->Html->script('functions.js?=' . $browser_cache_version); ?>
        <?php echo $this->Html->script('plugins/Spin.js?='.$browser_cache_version); ?>
	<?php echo $this->Html->script('functions'.$minify.'.js?='.$browser_cache_version); ?>
	<?php echo $this->Html->script('sportbook/sportbook'.$minify.'.js?='.$browser_cache_version); ?>
	<?php echo $this->Html->script('sportbook/cache_updater'.$minify.'.js?='.$browser_cache_version); ?>
	<?php echo $this->Html->script('sportbook/leftmenu'.$minify.'.js?='.$browser_cache_version); ?>
	<?php echo $this->Html->script('sportbook/game'.$minify.'.js?='.$browser_cache_version); ?>
	<?php echo $this->Html->script('sportbook/betslip'.$minify.'.js?='.$browser_cache_version); ?>
	<?php echo $this->Html->script('sportbook/wagers_report'.$minify.'.js?='.$browser_cache_version); ?>
	<?php echo $this->Html->script('sportbook/overview'.$minify.'.js?='.$browser_cache_version); ?>
        <?php echo $this->element('appLang'); ?>
        <?php echo $this->element('Sportbook/numkeyboardModal'); ?>

    </head>
    <body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
        <script>
            var _LINE_TYPES = '<?php echo $this->App->getDomain('LineTypes'); ?>';
            var availableCategories = <?= json_encode($availableCategories) ?>;
            
            var _FAVORITES = <?= json_encode($favorites) ?>;            
            var _LINES_LAYOUT = '<?= isset($formatDisplay) && $formatDisplay != "" ? strtolower(formatDisplay) : "american" ?>';
           
            
        </script>
        <div class="wrapper">

            <?php echo $this->element('Sportbook/header', array('username' => $usersAuth['customerId'], 'company' => $usersAuth['db'])); ?>
            <div class="content-wrapper ">
                <section class="content-header ">
                    <div class="leftFloat">
                        <table id="headerTable">
                            <tr>
                                <td>
                                    <select name="sp_search" id="sp_search" class="chosen-select headerSelect">
                                    </select>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-info" id="sp_search_button">Search</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col col-md-2" style="width: 34%">
                        <?php if ($fullCustomer['CustomerID'] != $usersAuth['player']) { ?>
                            <h3 style="margin-top: 0px;">
                                <small id="playerId"><?php echo $fullCustomer['CustomerID'] ?></small>
                                <span
                                    id="playerName"><?php echo $fullCustomer['NameFirst'] . $fullCustomer['NameLast'] ?></span>
                            </h3>
                        <?php } ?>
                    </div>
                    <div class="floatRight" style="width: 34%">
                        <button class="btn btn-info " onclick="window.location.replace('/DashboardAdmin')" style=" width:109PX; float: right; margin-left:10PX;  ">LOBBY
                        </button>
                        <button class="btn btn-info" 
                                onclick="window.location.replace('/cashier/cajero')" style=" width:115PX; float: right; margin-left:10PX;">CAJA
                        </button>
                        <?php 
                            if($formatDisplay=="American"){
                        ?>
                          <button class="btn btn-info" 
                                onclick="document.getElementById('form-id').submit();" style=" width:115PX; float: right; margin-left:10PX;">CABALLOS
                        </button>
                        <?php 
                            }
                        ?>
                        <form id="form-id" method="Post" action="/Pages/racebook">
                            <input type="hidden" id="CustomerID" name="CustomerID" value="<?=$fullCustomer["CustomerID"]?>">
                            
                        </form>
                        
                    </div>
                    <!--                    <div class="rigntFloat availableDiv">
                                <span class="availableSpan">
                                    <b>Available:</b> $<?php echo $fullCustomer['Available'] ?>
                                </span>
                            </div>-->
                </section>

                <!-- Main content -->
                <section class="content  myOffCanvas " id='myOffCanvas'>
                    <div id="loader-wrapper"></div>

                    <div class='left'>
                        <div class='scroller'>
                            <?php echo $this->element('Sportbook/leftmenu'); ?>
                        </div>
                    </div>
                    <div class='center'>
                        <!--<div class='wrap-loading-games'><div id='loading-games'></div></div>-->
                        <div class='scroller'>
                            <?php
                            $serviceName = 'accounts';
                            try {
                                ini_set('soap.wsdl_cache_enabled', 0);
                                ini_set('soap.wsdl_cache_ttl', 0);

                                $soapLdapAcc = new SoapClient(Configure::read('service.' . $serviceName), array('trace' => TRUE, 'cache_wsdl' => WSDL_CACHE_NONE));

                                $result_status = $soapLdapAcc->getStatusLoad(array("account" => $usersAuth["customerId"], "session" => $usersAuth["customerId"], "appid" => "", "userid" => ""));
                                $response_status = json_decode($result_status->return, true);
                                $response_status = $response_status["results"]["row1"];

                                if ($response_status["Active"] == "N") {
                                    echo "<div class='errorMessage'><label>Wagering has been suspended or your browser is not accepting cookies. Please contact your agent for more information.</label></div>";
                                } else {
                                    $dir = new Folder($currentPath . "View/Themed/" . $theme . "/webroot/img/custom_site/banner_central");
                                    $files = $dir->find('.*\.png');

                                    if (sizeof($files) > 0) {
                                        if (sizeof($files) > 1) {
                                            ?>
                                            <header id="myCarousel" class="carousel slide carousel-fade">
                                                <!-- Indicators -->
                                                <ol class="carousel-indicators">
                                                    <?php
                                                    for ($i = 0; $i < sizeof($files); $i++) {
                                                        if ($i == 0) {
                                                            ?>
                                                            <li data-target="#myCarousel" data-slide-to="<?php echo $i; ?>"
                                                                class="active"></li>
                                                                <?php
                                                            } else {
                                                                ?>
                                                            <li data-target="#myCarousel" data-slide-to="<?php echo $i; ?>"></li>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </ol>
                                                <!-- Wrapper for slides -->
                                                <div class="carousel-inner">
                                                    <?php
                                                    $countBannerImages = 0;
                                                    foreach ($files as $file) {
                                                        $banner = $urlCur . "/theme/" . $theme . "/img/custom_site/banner_central/" . $file;
                                                        if ($countBannerImages == 0) {
                                                            ?>
                                                            <div class="item active">
                                                                <div class="fill"
                                                                     style="background-image:url('<?php echo $banner; ?>');"></div>
                                                            </div>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <div class="item">
                                                                <div class="fill"
                                                                     style="background-image:url('<?php echo $banner; ?>');"></div>
                                                            </div>
                                                            <?php
                                                        }
                                                        $countBannerImages++;
                                                    }
                                                    ?>
                                                </div>
                                            </header>
                                            <script>
                                                $('.carousel').carousel({
                                                    interval: 5000 //changes the speed
                                                });
                                            </script>
                                            <?php
                                        } else {
                                            $banner = $urlCur . "/theme/" . $theme . "/img/custom_site/banner_central/" . $files[0];
                                            ?>
                                            <div class='banner'>
                                                <img src="<?php echo $banner; ?>" height="200px" width="780px"/>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <div id="content">
                                        <div id="loading">
                                            <img class='loadingImage' src='<?php echo $urlCur; ?>/images/ico-loading.gif'
                                                 alt=''/>
                                        </div>
                                        <?php //echo $this->fetch('content');
                                        ?>

                                        <div id='groupsWrap' class=''>
					<div id='groupsWrapLong' class='sort'></div>
					<!--<div id='groupsWrapShort' class='sort visible-xs'></div>-->
				</div>
				<div id='gameWrap'>
					<div id='gameWrapLong'></div>
				</div> 
				<div id='overviewWrap' >
					<?php //echo $this->element('Sportbook/overview');?>
				</div>
                                        <!--<div id='overviewWrap'>-->
                                        <?php //echo $this->element('Sportbook/overview');
                                        ?>
                                        <!--</div>-->
                                        <div id='wagersReportWrap' class='secret'>
                                            <?php echo $this->element('Sportbook/wagersReport'); ?>
                                        </div>
                                        <div id='accountHistoryReportWrap' class='secret'>
                                            <?php echo $this->element('Sportbook/accountHistory'); ?>
                                        </div>
                                        <div id='balanceReportWrap' class='secret'>
                                            <?php echo $this->element('Sportbook/balanceReport'); ?>
                                        </div>
                                        <div id="printView" class='secret' style="display: block">
                                            <?php echo $this->element('Sportbook/printview'); ?>
                                        </div>
                                        <?php echo $this->element('Sportbook/backToTopButton'); ?>
                                    </div>
                                    <?php //echo $this->element('Sportbook/footer');
                                    ?>
                                    <div id='size'></div>
                                <?php } ?>
                                <?php
                            } catch (Exception $e) {
                                
                            };
                            ?>
                        </div>
                    </div>

                    <div class='right'>
                        <div id="betslipSelectionsDiv" class='scroller'>
                            <?php echo $this->element('Sportbook/betslip'); ?>
                            <?php
                            $dir = new Folder($currentPath . "View/Themed/" . $theme . "/webroot/img/custom_site/banner_betslip");
                            $files = $dir->find('.*\.png');

                            if (sizeof($files) > 0) {
                                if (sizeof($files) > 1) {
                                    ?>
                                    <header id="myCarousel" class="carousel slide carousel-fade">
                                        <!-- Indicators -->
                                        <ol class="carousel-indicators">
                                            <?php
                                            for ($i = 0; $i < sizeof($files); $i++) {
                                                if ($i == 0) {
                                                    ?>
                                                    <li data-target="#myCarousel" data-slide-to="<?php echo $i; ?>"
                                                        class="active"></li>
                                                        <?php
                                                    } else {
                                                        ?>
                                                    <li data-target="#myCarousel" data-slide-to="<?php echo $i; ?>"></li>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </ol>
                                        <!-- Wrapper for slides -->
                                        <div class="carousel-inner">
                                            <?php
                                            $countBannerImages = 0;
                                            foreach ($files as $file) {
                                                $banner = $urlCur . "/theme/" . $theme . "/img/custom_site/banner_betslip/" . $file;
                                                if ($countBannerImages == 0) {
                                                    ?>
                                                    <div class="item active">
                                                        <div class="fill"
                                                             style="background-image:url('<?php echo $banner; ?>');"></div>
                                                    </div>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <div class="item">
                                                        <div class="fill"
                                                             style="background-image:url('<?php echo $banner; ?>');"></div>
                                                    </div>
                                                    <?php
                                                }
                                                $countBannerImages++;
                                            }
                                            ?>
                                        </div>
                                    </header>
                                    <script>
                                        $('.carousel').carousel({
                                            interval: 5000 //changes the speed
                                        });
                                    </script>
                                    <?php
                                } else {
                                    $banner = $urlCur . "/theme/" . $theme . "/img/custom_site/banner_betslip/" . $files[0];
                                    ?>
                                    <div class='banner'>
                                        <img src="<?php echo $banner; ?>" height="300px" width="300px"/>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 1.1.0
                </div>
                <strong>Copyright &copy; 2016 <a href="http://jueguelo.com">BM Datos</a>.</strong> All rights
                reserved.
            </footer>

            <div class="control-sidebar-bg"></div>
        </div>
        <?php echo $this->element('Sportbook/betslipModal'); ?>
        <?php echo $this->element('Sportbook/teaserSelectorModal'); ?>
        <?php echo $this->element('Sportbook/print_compressedData'); ?>
        <?php echo $this->element('Sportbook/oddsStyleConstants'); ?>
        <?php echo $this->element('Sportbook/transactiondetailsmodal'); ?>
        <?php echo $this->element('Sportbook/linedisplaytypemodal'); ?>

        <?php echo $this->element('google-analytics'); ?>
	<script>

		var sizeBody= 'lg';
		
		$(window).scroll(function () {
            if ($(this).scrollTop() > 50) 
                $('#back-to-top').fadeIn();
            else
                $('#back-to-top').fadeOut();
        });
        // scroll body to 0px on click
        $('#back-to-top').click(function () {
			window.scrollTo(0,0);
            return false;
        });
        
        $('#back-to-top').tooltip('show');
		$('.tooltip').hide();
		// Transtion sportbook
		$('#loader-wrapper').animate({opacity: 0}, 3000, function() {$(this).remove(); });
		
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
			
		}
		
		setBodyType();

		//Show loading gadget
		new Spinner({
				lines: 9, // The number of lines to draw
				length: 8, // The length of each line
				width: 12, // The line thickness
				radius: 16, // The radius of the inner circle
				color: '#333', // #rbg or #rrggbb
				speed: 1.4, // Rounds per second
				trail: 60, // Afterglow percentage
				scale: 0.4,
				shadow: false // Whether to render a shadow
		}).spin(document.getElementById("loading-games"));

		$(document).ready(function(){
			window.onresize = function(){
				setBodyType();
				var body=$("body");
				if (sizeBody != body.attr('class')){
					sizeBody = body.attr('class');
				}
			};
			setBodyType();
			$("#myOffCanvas").addClass('activeLeft');
		});
		
		createCookie('selectedCategories', "", -1);
		
		//setInterval(function(){ loadFullGamesData("auto"); }, cacheUpdateInterval); 
	</script>
        <?php echo $this->element('Sportbook/footer', array('username' => $usersAuth['customerId'], 'company' => $usersAuth['db'])); ?>
    </body>
</html>
