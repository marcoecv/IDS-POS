<script type="text/javascript" src="<?= $productionServer?>/design/client/js/betgames.js"></script>
<script type="text/javascript">
    var _bt = _bt || [];
    _bt.push(['server', '<?= $productionServer?>']);
    _bt.push(['partner', '<?= $patnerCode?>']);
    _bt.push(['token', '<?= $token?>']);
    _bt.push(['language', '<?= $language?>']);
    _bt.push(['timezone', '-5']);    
    _bt.push(['current_game', '5']);
    _bt.push(['odds_format', '<?= $typeOdds?>']);    
    BetGames.frame(_bt);
    
    $(window).ready(function(){
        $('#navbar li').removeClass('active');
        $("#navbar .nav .mainMenu a .icoLiveCasino").parents(".mainMenu").addClass('active');
    });
</script>
<style>
    body.lg #betgames_div_iframe,
	body.sm #betgames_div_iframe,
	body.md #betgames_div_iframe{
        -webkit-overflow-scrolling: touch;
        overflow-y: scroll;
        height: 100%;
        padding-top: 30px;
		margin-left: 9px;
        position: absolute;
        width: 100%;
    }
    @media screen and (max-width: 767px) {
        #iframe-container{
            padding-top: 0px;        
        } 
    }
	
	#betgames_iframe_1{
		height: 100%;
		width: 100%;
		background: #FFFFFF;
		max-width: 1300px;
	}
    
    #content{
            max-width: 1300px;
            margin:auto;
            overflow-y: auto !important;
    }
        
    .navbar-custom.mobile{
        margin: auto;
    }
    
    .mainHeader .navbar-right{
            margin-right: 0px;
    }
</style>
