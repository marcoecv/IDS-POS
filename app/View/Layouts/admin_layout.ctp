<!DOCTYPE html>
<html>
<head>
    <?php global $browser_cache_version; ?>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
    <title><?php echo $this->fetch('title'); ?></title>
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/css/jquery-ui.css">

    <link rel="stylesheet" href="/css/responsiveMenu.css">
    <link rel="stylesheet" href="/css/responsiveMobile.css">
    <link rel="stylesheet" href="/plugins/montrezorro-bootstrap-checkbox/css/bootstrap-checkbox.css">
    <link rel="stylesheet" href="/css/bmdash.min.css">
    <link rel="stylesheet" href="/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="/css/blue.css">
    <link rel="stylesheet" href="/css/morris.css">
    <link rel="stylesheet" href="/css/jquery-jvectormap-1.2.2.css">
    <link rel="stylesheet" href="/css/datepicker3.css">
    <link rel="stylesheet" href="/css/daterangepicker.css">
    <link rel="stylesheet" href="/css/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="/js/plugins/datatables/jquery.dataTables_themeroller.css">
    <link rel="stylesheet" href="/js/plugins/datatables/jquery.dataTables.min.css">
    <link rel="stylesheet" href="/js/plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="/js/plugins/iCheck/all.css">


    <link rel="stylesheet" href="/css/jqbtk.css">
    <link rel="stylesheet" href="/css//plugins/key.css">
    <link rel="stylesheet" href="/css/plugins/keyboard.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">

    <!--  <link rel="stylesheet" href="/bootstrap/css/jquery.dataTables.min.css">-->
    <link rel="stylesheet"
          href="/plugins/montrezorro-bootstrap-checkbox/css/bootstrap-checkbox.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' type='text/css'>
    <link rel='stylesheet' href='http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css'
          type='text/css'>
    <?php $this->Html->css('bmdash'); ?>

    <link rel="stylesheet" href="/css/sportbook_header.css?v=<?php echo $browser_cache_version; ?>">
    <link rel="stylesheet" href="/css/sportbook_sportsmenu.css?v=<?php echo $browser_cache_version; ?>">
    <link rel="stylesheet" href="/css/sportbook_icons.css?v=<?php echo $browser_cache_version; ?>">
    <link rel="stylesheet" href="/css/admin/main.css?v=<?php echo $browser_cache_version; ?>">
    <link rel="stylesheet" href="/css/awesome-bootstrap-checkbox.css?v=<?php echo $browser_cache_version; ?>">
    <link rel="stylesheet" href="/plugins/Font-Awesome/3.0.2/css/font-awesome.min.css">
    <link rel="stylesheet" href="/plugins/Font-Awesome/3.0.2/css/font-awesome-ie7.min.css">
    <?php echo $this->fetch('css'); ?>
    <script src='/js/jquery-1.11.2.min.js'></script>
    <script src='/js/jquery-ui.js'></script>
    <script src='/bootstrap/js/bootstrap.js'></script>
    <script src='/plugins/montrezorro-bootstrap-checkbox/js/bootstrap-checkbox.js'></script>
    <script src='/js/functions.js?v=<?php echo $browser_cache_version; ?>'></script>
    <script src='/js/sportsarray.js?v=<?php echo $browser_cache_version; ?>'></script>
    <script src='/js/admin/admin.js?v=<?php echo $browser_cache_version; ?>'></script>
    <script src='/js/plugins/Spin.js'></script>
    <script src='/js/plugins/datatables/jquery.dataTables.min.js'></script>
    <script src='/js/plugins/datatables/dataTables.bootstrap.js'></script>
    <script src='/js/plugins/datatables/dataTables.rowsGroup.js'></script>
    <script src='/js/plugins/iCheck/icheck.min.js'></script>
    <script src='/js/plugins/moment.min.js'></script>
    <script src='/js/plugins/accounting.min.js'></script>

    <?php echo $this->Html->css('plugins/bootstrap-datetimepicker.min'); ?>
    <?php echo $this->Html->script('plugins/bootstrap-datetimepicker'); ?>
    <?php echo $this->Html->css('plugins/chosen/chosen.min'); ?>
    <?php echo $this->Html->script('plugins/chosen/chosen.jquery.min'); ?>

    <script src='/js/plugins/morris/morris.min.js'></script>
    <script src='/js/plugins/sparkline/jquery.sparkline.min.js'></script>
    <script src='/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'></script>
    <script src='/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js'></script>
    <script src='/js/plugins/knob/jquery.knob.js'></script>
    <script src='/js/plugins/daterangepicker/daterangepicker.js'></script>
    <script src='/js/plugins/datepicker/bootstrap-datepicker.js'></script>
    <script src='/js/plugins/slimScroll/jquery.slimscroll.min.js'></script>


    <script src="/js/jqbtk.js"></script>
    <script src='/js/plugins/keyboard/jquery.mousewheel.js'></script>
    <script src='/js/plugins/keyboard/jquery.keyboard.js'></script>
    <script src='/js/plugins/keyboard/jquery.keyboard.extension-typing.js'></script>
    <script src='/js/plugins/keyboard/jquery.keyboard.extension-autocomplete.js'></script>


    <script src="/js/app.min.js"></script>

    <?php echo $this->element('appLang');?>
    <?php echo $this->fetch('script'); ?>


</head>

<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">

<input type="hidden" id="baseurl" name="baseurl" value="<?= ($this->Html->url('/')) ? $this->Html->url('/') : '/'; ?>"/>
<input type="hidden" id="saveChangesBefore" name="saveChangesBefore" value="0"/>

<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="/DashboardAdmin" class="logo" style="width: 100px">
            <b>LOBBY</b>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" style="margin-left: 100px;">

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->

                <!-- Notifications: style can be found in dropdown.less -->
                <!-- Tasks: style can be found in dropdown.less -->
                <!-- User Account: style can be found in dropdown.less -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <a onclick="deactiveBox()" class="dropdown-toggle">
                            <span class="hidden-xs" style="font-size: 20px;"><i
                                    class="fa fa-power-off"></i> Logout</span>
                            </a>

                        </li>
                    </ul>
                </div>
    </nav>

</header>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">

                <?php echo $this->fetch('content'); ?>
            </div>
            <!-- /.row -->
            <!-- Main row -->

            <!-- /.row (main row) -->

        </section>
        <!-- /.content -->
    </div>


</div>
<!-- ./wrapper -->
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<script src='/js/plugins/keyboard/key.js'></script>

</body>
</html>
