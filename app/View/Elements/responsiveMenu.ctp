<div class="responsive-menu">
    <div class="responsive-menu-item" id="menuHome">
        <a href="<?= ($this->Html->url('/')) ? $this->Html->url('/DashboardAdmin') : '/DashboardAdmin'; ?>">
            <?php echo $this->element('responsiveMenuIcons/home');?>
            <br><span><?php echo __('HOME');?></span>
        </a>
    </div>
    <div class="responsive-menu-item" id="menuSportbook">
        <a href="<?= ($this->Html->url('/')) ? $this->Html->url('/Sportbook') : '/Sportbook'; ?>">
            <?php echo $this->element('responsiveMenuIcons/sportsbook');?>
            <br><span><?php echo __('SPORTSBOOK');?></span>
        </a>
    </div>
    <div class="responsive-menu-item" id="menuLive">
        <a href="<?= ($this->Html->url('/')) ? $this->Html->url('/#') : '/#'; ?>">
            <?php echo $this->element('responsiveMenuIcons/live');?>
            <br><span><?php echo __('LIVE');?></span>
        </a>
    </div>
    <div class="responsive-menu-item" id="menuRacebook">
        <a href="<?= ($this->Html->url('/')) ? $this->Html->url('/#') : '/#'; ?>">
            <?php echo $this->element('responsiveMenuIcons/race');?>
            <br><span><?php echo __('RACE');?></span>
        </a>
    </div>
    <div class="responsive-menu-item" id="menuCasino">
        <a href="<?= ($this->Html->url('/')) ? $this->Html->url('/#') : '/#'; ?>">
            <?php echo $this->element('responsiveMenuIcons/casino');?>
            <br><span><?php echo __('CASINO');?></span>
        </a>
    </div>
</div>
<script>
    var _CUSTOMER_INFO = <?php echo json_encode($authUser['fullCustomerInfo']); ?>;
	var _CUSTOMER_ADMIN = <?php echo json_encode($authUser['accessAdmin']); ?>;
	var _LIVEBET_STATUS = <?php echo json_encode($authUser["liveBetStatus"]); ?>;
	var _CASINO_STATUS = <?php echo json_encode($authUser["casinoStatus"]); ?>;
	var _HORSE_STATUS = <?php echo json_encode($authUser["horseStatus"]); ?>;
    
    SetMenus();
    
    function SetMenus(){
        if (_LIVEBET_STATUS) {
            $("#menuLive").show();
        }
        else {
            $("#menuLive").hide();
        }
        
        if (_CASINO_STATUS) {
            $("#menuCasino").show();
        }
        else {
            $("#menuCasino").hide();
        }
        
        if (_HORSE_STATUS) {
            $("#menuRacebook").show();
        }
        else {
            $("#menuRacebook").hide();
        }
        
        var countMenus = 0;
        $(".responsive-menu-item").each(function(){
            if($(this).css("display")=="block"){
              countMenus++;
            }
        });
        
        $(".responsive-menu-item").css("width", (100.00 / countMenus).toString() + "%");
    }
</script>