<?php
$urlCur = Router::url($this->here, true);
$urlCur = strtolower($urlCur);
$protocol = substr($urlCur, 0, stripos($urlCur, "//") + 2);
$urlCur = str_replace($protocol, "", $urlCur);
$urlCur = substr($urlCur, 0, stripos($urlCur, "/"));
$urlCur = $protocol . $urlCur;

$theme = $this->App->getDomain('theme');
$infoGeneral = Configure::read('InfoGeneral');
$menuOptions = Configure::read('MenuOptions');
$cashier = Configure::read('CashierType');
?>

<script>
    var _CUSTOMER_INFO = <?php echo json_encode($usersAuth['fullCustomerInfo']); ?>;
    var _CUSTOMER_ADMIN = <?php echo json_encode($usersAuth['accessAdmin']); ?>;
    var _LIVEBET_STATUS = <?php echo json_encode($usersAuth["liveBetStatus"]); ?>;
    var _CASINO_STATUS = <?php echo json_encode($usersAuth["casinoStatus"]); ?>;
    var _LIVEDEALER_STATUS = <?php echo json_encode($usersAuth["casinoStatus"]); ?>;
    var _HORSE_STATUS = <?php echo json_encode($usersAuth["horseStatus"]); ?>;
    var _MENU_OPTIONS = "<?php echo Configure::read('MenuOptions'); ?>";
    var _INFO_GENERAL = "<?php echo Configure::read('InfoGeneral'); ?>";
    var _THEME = '<?php echo lcfirst($this->App->getDomain('theme')); ?>';
    var _BET_TYPES = "<?php echo Configure::read('BetTypes'); ?>";
    _THEME = _THEME.charAt(0).toUpperCase() + _THEME.slice(1);
</script>

<?php echo $this->Html->script('/js/sportbook_header'); ?>

<header class="main-header">
    <!-- Logo -->
    <header class="main-header">
        <!-- Logo -->
        <a href="/DashboardAdmin" class="logo" style="width: 100px";>
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>LOBBY</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">LOBBY</span>
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
                            <a onclick="deactiveBox();" class="dropdown-toggle">
                            <span class="hidden-xs" style="font-size: 20px;"><i
                                    class="fa fa-power-off"></i> Logout</span>
                            </a>

                        </li>
                    </ul>
                </div>
    </nav>

</header>


<script>
    $(document).ready(function () {
        $('.linkHeader').bind('click', function (e) {
            e.preventDefault();
            var href = $(this).attr('href');
            var param = $(this).attr('data-lnk');
            $.ajax({
                type: "POST",
                url: "/Sportbook/getPermissionAjax",
                data: {'param': param},
                dataType: "json",
                success: function (data) {
                    if (data == true) {
                        $(location).attr('href', href);
                    } else {
                        alert('you do not have permission');
                    }
                },
                error: function (request, status, error) {
                    console.log(error)
                }
            });
        })
    });
</script>