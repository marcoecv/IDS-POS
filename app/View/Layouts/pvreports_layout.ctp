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
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
        <title><?php echo $this->fetch('title'); ?></title>
        <link rel="stylesheet" href="<?php echo $urlCur; ?>/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="<?php echo $urlCur; ?>/bootstrap/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="<?php echo $urlCur; ?>/css/jquery-ui.css">
        <link rel="stylesheet" href="<?php echo $urlCur; ?>/css/bmdash.min.css">
        <link rel="stylesheet" href="/css/jqbtk.css">
        <?php $this->Html->css('bmdashassdas'); ?>


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
        <script src="<?php echo $urlCur; ?>/plugins/less/less.min.js" type="text/javascript"></script>
        <script src='<?php echo $urlCur; ?>/bootstrap/js/jquery-1.9.1.js'></script>
        <script src='<?php echo $urlCur; ?>/bootstrap/js/jquery-ui.js'></script>
        <script src="<?php echo $urlCur; ?>/js/jsxcompressor.min.js"></script>
        <script src='<?php echo $urlCur; ?>/js/jquery-ui.js'></script>
        <script src='<?php echo $urlCur; ?>/bootstrap/js/bootstrap.min.js'></script>
        <script src='<?php echo $urlCur; ?>/bootstrap/js/offcanvas.js?v=<?php echo $browser_cache_version; ?>'></script>

        <script src='<?php echo $urlCur; ?>/js/plugins/datepicker/bootstrap-datepicker.js'></script>
        <script src='<?php echo $urlCur; ?>/js/app.min.js'></script>
        <script src='<?php echo $urlCur; ?>/js/dashboard.js'></script>
        <script src="/js/jqbtk.js"></script>

        <?php echo $this->Html->css('plugins/bootstrap-datetimepicker.min'); ?>
        <?php echo $this->Html->css('plugins/chosen/chosen.min'); ?>
        <?php echo $this->Html->script('plugins/chosen/chosen.jquery.min'); ?>
        <?php echo $this->Html->script('plugins/bootstrap-datetimepicker'); ?>

        <?php echo $this->Html->script('plugins/Spin.js?=' . $browser_cache_version); ?>
        <?php echo $this->Html->script('functions.js?=' . $browser_cache_version); ?>
        <?php echo $this->element('appLang'); ?>
        
    </head>
    <body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
        <script>
            var _LINE_TYPES = '<?php echo $this->App->getDomain('LineTypes'); ?>';
            var availableCategories = <?= json_encode($availableCategories) ?>;
        </script>
        <div class="wrapper">

            <?php echo $this->element('Sportbook/header', array('username' => $usersAuth['customerId'], 'company' => $usersAuth['db'])); ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper ">
                <!-- Content Header (Page header) -->
                <section class="content-header ">
                    
                </section>

                 Main content 
                <section class="content  myOffCanvas " id='myOffCanvas'>
                    <div class='left'>
                        <?php echo $this->element('PvReports/leftmenu'); ?>
                    </div>
                    <div class='center'>
                        
                    </div>

                    <div class='right'>
                        
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
            /*
             function ajustScroller(){
             var padding=$('body').css('padding-top');
             padding=padding.replace("px", "");
             padding=parseFloat(padding);
             
             var newHeight=$(window).height()-padding+1;
             $(".myOffCanvas .left").height(newHeight);
             $(".myOffCanvas .center").height(newHeight);
             $(".myOffCanvas .right").height(newHeight);
             }
             
             function initScroller(){
             ajustScroller();
             $('.scroller').slimscroll({
             size: '5px',
             height: '100%',
             wheelStep: 1,
             color: "#A4A4A4"
             });
             }
             */

            // Transtion sportbook
            $('#loader-wrapper').animate({opacity: 0}, 3000, function () {
                $(this).remove();
            });

            function setBodyType() {
                var winSize = getCurrentSize();

                var body = $("body");

                if (!body.hasClass(winSize))
                    body.addClass(winSize);

                if (body.hasClass("xs") && winSize != "xs")
                    body.removeClass('xs');

                if (body.hasClass("sm") && winSize != "sm")
                    body.removeClass('sm');

                if (body.hasClass("md") && winSize != "md")
                    body.removeClass('md');

                if (body.hasClass("lg") && winSize != "lg")
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

            $(document).ready(function () {
                window.onresize = function () {
                    setBodyType();
                    //ajustScroller();
                };
                setBodyType();
                //initScroller();
            });
        </script>
        <?php echo $this->element('Sportbook/footer', array('username' => $usersAuth['customerId'], 'company' => $usersAuth['db'])); ?>
    </body>
</html>
