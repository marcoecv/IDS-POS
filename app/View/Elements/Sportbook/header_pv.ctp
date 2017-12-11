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


    <!-- Logo -->
    <header class="main-header">
        <!-- Logo -->
        <div style=" background-color: #2F3C42;  height: 35px;   " >
            
         
             <a href="/DashboardAdmin" class="logo btn btn-info " style="width: 100px;height: 34px;float: left; color:  whitesmoke;">
           LOBBY
             </a>
    
            <span style=" color: whitesmoke;float: left;font-size: 20px;margin-left: 1%;margin-top: 4px;"> <?= $userhorse ?> </span>
            

            
            
             <div class="col-lg-3" style=" float: right;">
    <div class="input-group">
         <span class="input-group-btn">
             <button class="btn btn-success" style="margin-left: 10px;" type="button" onclick="printTicket3($('#blr').val());">Imprimir Tiquetes</button>
      </span>
            <input type="text" class="form-control" id="blr" placeholder="">
      
    
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->

            <button class="btn btn-success " style=" width:110px; margin-left: 10px; float:right;  " onclick="window.location.replace('/PvReports')">REPORTES</button>
            <button class="btn btn-success" style=" width:110px;margin-left: 10px; float:right; " onclick="window.location.replace('/cashier/cajero')">CAJA</button>
            <button class="btn btn-success" style=" width:110px; margin-left: 10px; float:right;" onclick="window.location.replace('/sportbook/index/<?=$userhorse ?>')">SPORTBOOK</button>
           

            
        </div>
     
       
                            

</header>


<script>
    $(document).ready(function () {
        
        
        jQuery.ajaxSetup({
    error:function(err){
     if (err.status === 403){
     window.location.replace('/DashboardAdmin');
     } 
    }
   });
        
        $('#blr').on('keypress', function (e) {
         if(e.which === 13){

            //Disable textbox to prevent multiple submit
            $(this).prop('disabled', true);
printTicket3($('#blr').val());
            //Do Stuff, submit, etc..
         }
   });
        
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
    
    function printTicket3(blr) {

    var left = (screen.width / 2) - (450 / 2);
    var top = (screen.height / 2) - (700 / 2);
    $('#blr').val("");
    $('#blr').prop('disabled', false);
    var res = blr.split(" ");
    

             var w = window.open("/Printview/belrtike?U=<?= $userhorse ?>&blrtiket=" + blr, "", "width=450,height=700, top=" + top + ", left=" + left);

    
 

}
    
    
</script>