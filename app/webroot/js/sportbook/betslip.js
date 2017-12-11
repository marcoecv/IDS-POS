var _BETSLIP_TYPE = 'straight';
var _AMOUNT_SELECTIONS_ON_BETSLIP = 0;
var _AMOUNT_SELECTIONS_ON_BETSLIP_NO_OPEN = 0;
var _MAX_SELECTIONS_ALLOWED = {
    'straight' : 15,
    'parlay' : 15,
    'rndrobin' : 0,
    'teaser' : 0,
    'ifbet' : 15,
    'reverse' : 15
};
var _MIN_SELECTIONS_ALLOWED  = {
    'straight' : 1,
    'parlay' : 2,
    'rndrobin' : 2,
    'teaser' : 0,
    'ifbet' : 2,
    'reverse' : 2
};
var _CONTINUE_ON_PUSH_FLAG = "N";
var _TEASER_TYPE = "";
var _TEASER_AMOUNT = "";
var _TEASER_AMOUNT_TYPE = "";
var _FREE_PLAY_CHECKED = "0";
var _LIMITS = {};
var _ROUND_ROBIN_TYPE = 2;
var _LIMITS_AJAX = null;
var _GLOBAL_RISK_AMOUNT = "0";
var _GLOBAL_WIN_AMOUNT = "0";
var _PARLAY_RISK = "0";
var _ROUND_ROBIN_RISK = "0";
var _REVERSE_AMOUNT = "0";
var _SHOW_GLOBAL_MESSAGES = false;
var _ERROR = false;
var _TRIGGERED_BY = "";
var _BETSLIP_IS_ENABLED = false;

$(window).ready(function(){
    $("#roundRobinSelectorWrap").hide();
    $("#teaserSelectorWrap").hide();
    $("#ContinueOnPushFlagWrapIfBet").hide();
    $("#ContinueOnPushFlagWrapReverse").hide();
    $("#betslip .betslipTypeSelector .option").unbind("click");
    $("#betslip .betslipTypeSelector .option").click(function(){
        _BETSLIP_TYPE = $(this).attr('select');
        updateBetSlip();
        $("#txtBet").val("");
        $('#riskAmount').val("");
        if($(this).attr('select') !== "rndrobin"){
            $("#placeBetWrap").css("display", "block");
        }else{
            $("#placeBetWrap").css("display", "none");
        }
    });
    
    $("#teaserSelectorModal .selectTeaser").unbind("click");
    $("#teaserSelectorModal .selectTeaser").click(function(){
        _TEASER_TYPE = $(this).attr("teaserName");
	updateBetSlip();
    }); 
    
    $("#betslip #openTeaserSelector").unbind("click");
    $("#betslip #openTeaserSelector").click(function(){
	$('#teaserSelectorModal').modal();
    });
    var cbmBetType = new DropDown($('#cbmBetType') );
    $(document).click(function() {
        // all dropdowns
        $('.wrapper-dropdown-5').removeClass('active');
    });
    $("#cbmBetType ul li a").unbind('click');
    $("#cbmBetType ul li a").bind('click',function(e){
        e.preventDefault();
        var sel = $(this).attr('data-val');
        $('#opSelectedetType').html(sel);
        _BETSLIP_TYPE = sel;
        updateBetSlip();
    });
    setInterval(closeBalloons, 2000);
    updateBetSlip();
});

/**
 * Takes info from customer and completes information used by the betslip.
 * @return {undefined}
 */
function completeCustomerInfoForBetslip(){
    try{
        var parlaysInfo = siteCache.customer.parlayInfo.parlayDetails;
        for(var id in parlaysInfo){
            var GamesPicked = parseInt(parlaysInfo[id]['GamesPicked']);
            if(_MAX_SELECTIONS_ALLOWED['parlay']<GamesPicked){
                _MAX_SELECTIONS_ALLOWED['parlay']=GamesPicked;
                _MAX_SELECTIONS_ALLOWED['rndrobin']=GamesPicked;
            }
        }
    }catch(e){
//        console.log("ERROR>>>>>> LOADING PARLAY");
    }
}




















/*  _   _           _       _         ____       _       _ _
   | | | |_ __   __| | __ _| |_ ___  | __ )  ___| |_ ___| (_)_ __
   | | | | '_ \ / _` |/ _` | __/ _ \ |  _ \ / _ \ __/ __| | | '_ \
   | |_| | |_) | (_| | (_| | ||  __/ | |_) |  __/ |_\__ \ | | |_) |
    \___/| .__/ \__,_|\__,_|\__\___| |____/ \___|\__|___/_|_| .__/
         |_|                                                |_|*/
















function calculateCuota(){
    var cuota=1;
    $.each(_SELECTIONS_ON_BETSLIP,function (key,val){
        cuota*=val["Dec"];
    })
    return Math.round(cuota * 100) / 100;
}

/**
 * Updates all the betslip.
 * Update selections, check for errors and change selections.
 * This little guy does all the betslip job!!
 * @return {undefined}
 */
function updateBetSlip(){
    _ERROR = false;
    _SHOW_GLOBAL_MESSAGES = false;
    if (getCookie('selectedSideCanvas') != '') {
        if (getCookie('selectedSideCanvas') == "center") {
            $("#myOffCanvas").removeClass('activeLeft');
            $("#myOffCanvas").removeClass('activeRight');
        }
        else{
            $("#myOffCanvas").addClass('active' + getCookie('selectedSideCanvas').charAt(0).toUpperCase() + getCookie('selectedSideCanvas').slice(1));
        }
    }
    
    //We must update the teaser max allowed selections according to selected teaser
    _MAX_SELECTIONS_ALLOWED['teaser']=getMaxSelectionsAllowedTeaser();
    _MIN_SELECTIONS_ALLOWED['teaser']=getMinSelectionsAllowedTeaser();
    //Change DOM element's CSS according to selected bet type
    changeStyles();
    //Compute the threshold teaser for each selection on betslip
    computeThresholdTeaser();
    //Compute win and risk amounts for selection
    computeBetslipSelectionsAmounts();
    //Validates and display Free play check
    updateFreePlayCheck();
    //Create selections on betslip or update them
    var updateSelectionsResult=updateBetslipSelections();
    //Highlight every selection on betslip on the lines overview
    hightLigthSelectionOnBetslip();
    
    var maxToWin=computeMaxWinAmount();
    if(maxToWin!=null)
	maxToWin=myRound(maxToWin, 2);    
    var maxRisk=myRound(computeMaxRiskAmount(), 2);
    //INSERTAR CALCULO DE CUOTA///////////////////////////////////////////////////////////////////////////////////////////////////////
    var cuota=calculateCuota();
    
    computeAmountsSelections(maxRisk, maxToWin);
    
    var customer=siteCache['customer'];
    var AvailableBalance=parseFloat(customer['AvailableBalance']);
    var FreePlayBalance=parseFloat(customer['FreePlayBalance']);
    var totalAmounts=getTotalAmounts();

    if(totalAmounts['risk']>AvailableBalance){
        _SHOW_GLOBAL_MESSAGES=true;
        _ERROR=true;
        if(_TRIGGERED_BY == "placeBet") $(".globalMessages .lowBalanceError").show();
        else $(".globalMessages .lowBalanceError").hide();
    }else{
        $(".globalMessages .lowBalanceError").hide();
    }
    
    if(totalAmounts['riskFP']>FreePlayBalance){
        _SHOW_GLOBAL_MESSAGES=true;
        _ERROR=true;
        if(_TRIGGERED_BY == "placeBet") $(".globalMessages .lowFreePlayError").show();
        else $(".globalMessages .lowFreePlayError").hide();
    }else{
        $(".globalMessages .lowFreePlayError").hide();
    }
    
    if(updateSelectionsResult['amountError']){
        _SHOW_GLOBAL_MESSAGES=true;
        _ERROR=true;
        if(_TRIGGERED_BY == "placeBet") $(".globalMessages .amountError").show();
        else $(".globalMessages .amountError").hide();
    }else{
        $(".globalMessages .amountError").hide();
    }
    
    if(updateSelectionsResult['unavailableError']){
    	_SHOW_GLOBAL_MESSAGES=true;
        _ERROR=true;
        if(_TRIGGERED_BY == "placeBet") $(".globalMessages .unavailableError").show();
        else $(".globalMessages .unavailableError").hide();
    }else{
        $(".globalMessages .unavailableError").hide();
    }
    
    if(updateSelectionsResult['changeSelectionError']){
        _SHOW_GLOBAL_MESSAGES=true;
        _ERROR=true;
    	$(".globalMessages .changeSelectionError").show();
        $("#betslip #acceptChangesWrap").show();
    }else{
    	$(".globalMessages .changeSelectionError").hide();
        $("#betslip #acceptChangesWrap").hide();
    }
    
    if(updateSelectionsResult['restWagerError']){
        _SHOW_GLOBAL_MESSAGES=true;
        _ERROR=true;
        if(_TRIGGERED_BY == "placeBet") $(".globalMessages .restWagerError").show();
        else $(".globalMessages .restWagerError").hide();
    }else{
        $(".globalMessages .restWagerError").hide();
    }
    
    if(_BETSLIP_TYPE=='teaser'){
        var teaser=siteCache.customer.teasers[_TEASER_TYPE];
        console.log(siteCache.customer.teasers);
        
        if(typeof teaser != "undefined"){
            if(_MAX_SELECTIONS_ALLOWED[_BETSLIP_TYPE]<_AMOUNT_SELECTIONS_ON_BETSLIP){
                _SHOW_GLOBAL_MESSAGES=true;
                _ERROR=true;
                $(".globalMessages .maxSelectionAllowedError .maxSelectionsAllowed").html(_AMOUNT_SELECTIONS_ON_BETSLIP);
                if(_TRIGGERED_BY == "placeBet") $(".globalMessages .maxSelectionAllowedError").show();
                else $(".globalMessages .maxSelectionAllowedError").hide();
            }else{
                $(".globalMessages .maxSelectionAllowedError").hide();
            }
            
            if(_AMOUNT_SELECTIONS_ON_BETSLIP>0 && _MIN_SELECTIONS_ALLOWED[_BETSLIP_TYPE]>_AMOUNT_SELECTIONS_ON_BETSLIP){
                _SHOW_GLOBAL_MESSAGES=true;
                _ERROR=true;
                $(".globalMessages .minSelectionAllowedError .minSelectionsAllowed").html(_MIN_SELECTIONS_ALLOWED[_BETSLIP_TYPE]);
                if(_TRIGGERED_BY == "placeBet") $(".globalMessages .minSelectionAllowedError").show();
                else $(".globalMessages .minSelectionAllowedError").hide();
            }else{
                $(".globalMessages .minSelectionAllowedError").hide();
            }
        }
    }else{
        if(_MAX_SELECTIONS_ALLOWED[_BETSLIP_TYPE]<_AMOUNT_SELECTIONS_ON_BETSLIP){
            _SHOW_GLOBAL_MESSAGES=true;
            _ERROR=true;
            $(".globalMessages .maxSelectionAllowedError .maxSelectionsAllowed").html(_MAX_SELECTIONS_ALLOWED[_BETSLIP_TYPE]);
//            if(_TRIGGERED_BY == "placeBet") $(".globalMessages .maxSelectionAllowedError").show();
//            else $(".globalMessages .maxSelectionAllowedError").hide();
            $(".globalMessages .maxSelectionAllowedError").show();
        }else{
            $(".globalMessages .maxSelectionAllowedError").hide();
        } 
        if(_AMOUNT_SELECTIONS_ON_BETSLIP>0 && _MIN_SELECTIONS_ALLOWED[_BETSLIP_TYPE]>_AMOUNT_SELECTIONS_ON_BETSLIP){
            _SHOW_GLOBAL_MESSAGES=true;
            _ERROR=true;
            $(".globalMessages .minSelectionAllowedError .minSelectionsAllowed").html(_MIN_SELECTIONS_ALLOWED[_BETSLIP_TYPE]);
            if(_TRIGGERED_BY == "placeBet") $(".globalMessages .minSelectionAllowedError").show();
            else $(".globalMessages .minSelectionAllowedError").hide();
        }else{
            $(".globalMessages .minSelectionAllowedError").hide();
        }
    }
        
    var errorsSelections=getErrorsSelectionsBetslip();
    if (errorsSelections != null) {
        for(var i in errorsSelections){
            _SHOW_GLOBAL_MESSAGES=true;
            _ERROR=true;
        }
        if(typeof(errorsSelections['illegalHookupSelectionErrors'])!='undefined' 
            || typeof(errorsSelections['gameDenyErrors'])!='undefined' 
            || typeof(errorsSelections['illegalSportsErrors'])!='undefined'){
            _SHOW_GLOBAL_MESSAGES=true;
            _ERROR=true;
            if(_TRIGGERED_BY == "placeBet") $(".globalMessages .illegalSelectionBetTypeError").show();
            else $(".globalMessages .illegalSelectionBetTypeError").hide();
        }else{
            $(".globalMessages .illegalSelectionBetTypeError").hide();
        }
        
        if(	typeof(errorsSelections['illegalHookupCombinationErrors'])!='undefined' || 
        typeof(errorsSelections['sameGameDenyErrors'])!='undefined' ||
        typeof(errorsSelections['illegalHookupCombinationErrors'])!='undefined'){
            _SHOW_GLOBAL_MESSAGES=true;
            _ERROR=true;
            if(_TRIGGERED_BY == "placeBet") $(".globalMessages .illegalHookupCombinationErrors").show();
            else $(".globalMessages .illegalHookupCombinationErrors").hide();
        }else{
            $(".globalMessages .illegalHookupCombinationErrors").hide();
        }
    }else{
        $(".globalMessages .illegalSelectionBetTypeError").hide();
         $(".globalMessages .illegalHookupCombinationErrors").hide();
    }
    if(checkOpenBetDenyError()){
    	_SHOW_GLOBAL_MESSAGES=true;
        _ERROR=true;
        if(_TRIGGERED_BY == "placeBet") $(".globalMessages .openBetDenyError").show();
        else $(".globalMessages .openBetDenyError").hide();
    }else{
        $(".globalMessages .openBetDenyError").hide();
    }

    if(_SHOW_GLOBAL_MESSAGES/* && _TRIGGERED_BY == "placeBet"*/)
        $("#betslip .globalMessages").show();
    else
        $("#betslip .globalMessages").hide();
    
    $("#betslip .emptyBetslip").hide();
     
    if(isNaN(maxToWin) || maxToWin == ""){
        maxToWin = 0;
    }
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $("#betslip .maxToWin").html(maxToWin);
    $("#betslip .maxRisk").html(maxRisk);
    $("#betslip .cuotaValue").html(cuota);
    
    if(_BETSLIP_TYPE == "rndrobin" && ($.trim($("#riskAmount").val()) == "" || $.trim($("#riskAmount").val()) == "0")){
        $("#betslip .maxToWin").html("");
        $("#betslip .maxRisk").html("");
    }
    
    if(($('#betslip #roundRobinType').val() > _ROUND_ROBIN_TYPE)){
        $("#betslip #roundRobinType").val(_ROUND_ROBIN_TYPE);
        $("#betslip #roundRobinType option[value=" + _ROUND_ROBIN_TYPE + "]").attr('selected','selected');
    }
    
    if(_BETSLIP_TYPE == "rndrobin"){
        if (_AMOUNT_SELECTIONS_ON_BETSLIP < 3) {
            $("#betslip #placeBetWrap").hide();
        }
        else $("#betslip #placeBetWrap").show(); 
    }
    
    markBlockedSelections();
    sortElements();
    markSelectionsErrorBetslip();
    
    if(!isNaN(maxToWin) && _GLOBAL_WIN_AMOUNT!=maxToWin){
        _GLOBAL_WIN_AMOUNT = maxToWin;
    }
    
    if($("body.xs #betslip .fpSelectorWrap").attr("style") == "display: none;"){
        $("body.xs #betslip .selection .amount").css("width", "75%");
    }
    else{
        $("body.xs #betslip .selection .amount").css("width", "70%");
    }
    
    $('body.xs #betslip .message').each(function() { 
        if ($(this).attr("style") == "display: block;") {
            $(this).parent().css("display","block");
        }
    });
    
    //Valida si ya hay algo en el betslip
    if(_AMOUNT_SELECTIONS_ON_BETSLIP==0) {
        $("#placeBet").html(getTextJs['sportbook_betslip_YourBetSlipIsEmpty']);
        $("#placeBet").css("border", "1px solid #dddddd");
        $("#placeBet").css("background", "linear-gradient(to bottom, #dddddd 0%, #dddddd 100%)");
        $("#placeBet").css("color", "#000000");
        $("#betslip .emptyBetslip").hide();
        _BETSLIP_IS_ENABLED = false;
    }else{
        $("#placeBet").html(getTextJs['sportbook_betslip_PlaceBet']);
        $("#placeBet").css("border", "1px solid #BDBDBD");
        $("#placeBet").css("background", "linear-gradient(to bottom, #FFDF1B 0%, #FFDF1B 100%)");
        $("#placeBet").css("color", "#000000");
        $("#betslip .emptyBetslip").hide();
        _BETSLIP_IS_ENABLED = true;
    }
    _TRIGGERED_BY = "";
}

















/*   ____  _         _
    / ___|| |_ _   _| | ___  ___
    \___ \| __| | | | |/ _ \/ __|
     ___) | |_| |_| | |  __/\__ \
    |____/ \__|\__, |_|\___||___/
               |___/ */




















/**
 * Opens and closes DOM elements according to bet type selected
 */
function changeStyles(){
    $("#betslip .betslipTypeSelector .option").removeClass('selected');
    $("#betslip .betslipTypeSelector .option."+_BETSLIP_TYPE).addClass('selected');
    $("#cbmBetType").val(_BETSLIP_TYPE);
    $("#shopping-cart").html(_AMOUNT_SELECTIONS_ON_BETSLIP);
    if(_AMOUNT_SELECTIONS_ON_BETSLIP<=0)
        $("#shopping-cart").hide();
    else
        $("#shopping-cart").show();
    $("#betslip .ifLabel").hide();
    $("#betslip #addOpenBetWrap").hide();
    $("#betslip #roundRobinSelectorWrap").hide();
    $("#betslip #teaserSelectorWrap").hide();
    $("#betslip .teaserAmounts").hide();
    $("#betslip #ContinueOnPushFlagWrapIfBet").hide();
    $("#betslip #ContinueOnPushFlagWrapReverse").hide();
    $("#betslip .reverseAmountWrap").hide();
    $("#betslip .lowLimitError").hide();
    $("#betslip .highLimitError").hide();
    $("#betslip").removeClass("hideOdds");
    $("#betslip .selection .amountMenu").hide();
    $("#betslip .globalAmount").hide();
    //$("#riskAmount").val('');
    $("#betslip .allAmountMenu").hide();
    
    switch(_BETSLIP_TYPE){
        case 'straight':            
            if(_AMOUNT_SELECTIONS_ON_BETSLIP > 1)
                $("#betslip .maxAmounts").show();            
            else
                $("#betslip .maxAmounts").hide();
             
            if(_AMOUNT_SELECTIONS_ON_BETSLIP>1)
                $("#betslip .allAmountMenu").show();
            else
                $("#betslip .allAmountMenu").hide();
            
            $("#betslip .selection .amountMenu").show();
        break;
        case 'parlay':
            $("#betslip .maxAmounts .maxLimitWrap").show();
            

            if(_AMOUNT_SELECTIONS_ON_BETSLIP > 1) 
                $("#betslip .maxAmounts").show();  
            else
                $("#betslip .maxAmounts").hide();
            

            if(_AMOUNT_SELECTIONS_ON_BETSLIP>0)
                $("#betslip .globalAmount").show();
            else
                $("#betslip .globalAmount").hide();
            

            if(_MAX_SELECTIONS_ALLOWED['parlay']>_AMOUNT_SELECTIONS_ON_BETSLIP && _AMOUNT_SELECTIONS_ON_BETSLIP_NO_OPEN>=1)
                $("#betslip #addOpenBetWrap").show();
            else
                $("#betslip #addOpenBetWrap").hide();
        break;
        case 'rndrobin':
            for(var x = 0; x < $('#betslip #roundRobinType option').size() + 1; x++){
                if ((x + 1) > _AMOUNT_SELECTIONS_ON_BETSLIP && (x + 1) > 2) {
                    $("#betslip #roundRobinType option[value=" + (x + 1) + "]").hide();
                }
                else{
                    $("#betslip #roundRobinType option[value=" + (x + 1) + "]").show();
                }
            }

            if($('#betslip #roundRobinType').val() > _AMOUNT_SELECTIONS_ON_BETSLIP){
                $("#betslip #roundRobinType").val(_AMOUNT_SELECTIONS_ON_BETSLIP);
                $("#betslip #roundRobinType option[value=" + _AMOUNT_SELECTIONS_ON_BETSLIP + "]").attr('selected','selected');
            }
            
            if(_AMOUNT_SELECTIONS_ON_BETSLIP > 1) {
                $("#betslip .maxAmounts").show();
            }
            else{
                $("#betslip .maxAmounts").hide();
            }

            $("#betslip #roundRobinSelectorWrap").show();           

            if(_AMOUNT_SELECTIONS_ON_BETSLIP>0)
                $("#betslip .globalAmount").show();
            else
                $("#betslip .globalAmount").hide();
        break;
        case 'teaser':
            if(_AMOUNT_SELECTIONS_ON_BETSLIP > 1)
                $("#betslip .maxAmounts").show();            
            else
                $("#betslip .maxAmounts").hide();
            

            $("#betslip #teaserSelectorWrap").show();

            if(_MAX_SELECTIONS_ALLOWED['teaser']>_AMOUNT_SELECTIONS_ON_BETSLIP && _AMOUNT_SELECTIONS_ON_BETSLIP_NO_OPEN>=1)
                $("#betslip #addOpenBetWrap").show();
            else
                $("#betslip #addOpenBetWrap").hide();
        break;
        case 'ifbet':
            if(_AMOUNT_SELECTIONS_ON_BETSLIP > 1) 
                $("#betslip .maxAmounts").show();            
            else
                $("#betslip .maxAmounts").hide();
            
            $("#ContinueOnPushFlagWrapIfBet").show();
            $("#betslip .selection").first().find(".ifLabel").hide();
            $("#betslip .selection").first().siblings().find(".ifLabel").show();
            $("#betslip .ContinueOnPushFlag").val(_CONTINUE_ON_PUSH_FLAG);           

            if(_AMOUNT_SELECTIONS_ON_BETSLIP>1)
                $("#betslip .allAmountMenu").show();
            else
                $("#betslip .allAmountMenu").hide();
            
            $("#betslip .selection .amountMenu").show();
        break;
        case 'reverse':
            if(_AMOUNT_SELECTIONS_ON_BETSLIP > 1) 
                $("#betslip .maxAmounts").show();            
            else
                $("#betslip .maxAmounts").hide();
            

            $("#betslip #ContinueOnPushFlagWrap").show();
            $("#betslip #ContinueOnPushFlagWrapReverse").show();
            $("#betslip .ContinueOnPushFlag").val(_CONTINUE_ON_PUSH_FLAG);
            $("#betslip .reverseAmountWrap").show();
        break;
    }
}

function closeBalloons(){
    var balloons = $(".balloon-div");
    $.each(balloons, function(index, content){
        $(content).fadeOut(500);
    });
}


















    /*  _       _     _   _____       ____       _       _ _
       / \   __| | __| | |_   _|__   | __ )  ___| |_ ___| (_)_ __
      / _ \ / _` |/ _` |   | |/ _ \  |  _ \ / _ \ __/ __| | | '_ \
     / ___ \ (_| | (_| |   | | (_) | | |_) |  __/ |_\__ \ | | |_) |
    /_/   \_\__,_|\__,_|   |_|\___/  |____/ \___|\__|___/_|_| .__/
                                                            |_|*/
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                                                        
 /**
  * Triggered when user click over a selection.
  * Gather selection information and place it into the betslip.
  * @return {undefined}
  */                                                      
function addToBetslipClick(){
    var clickedElement=$(this);
    var selectionId=clickedElement.attr('selectionid');
    
    if(typeof(_SELECTIONS_ON_BETSLIP[selectionId])=='undefined' && !clickedElement.hasClass('blocked')){
	var maxOrder=getNextOrderSelectionOnBetSlip();
	var choseTeam = clickedElement.attr("chosenteamid");
        var TotalPointsOU = clickedElement.attr("totalpointsou");
        var threshold = clickedElement.attr("threshold");
        threshold = threshold == "" ? clickedElement.find(".threshold").text() :  threshold; 
        var oddsUS = clickedElement.attr("us");
        var oddsDecimal = clickedElement.attr("dec");
        var gameNum = clickedElement.attr("gamenum");
        var isMainbet = clickedElement.attr("mainbet");
        var isFuture = clickedElement.attr("isfuture");
        var periodNumber = clickedElement.attr("periodnumber");
        var betType = clickedElement.attr("bettypeis");
        var contestNum = clickedElement.attr("contestnum");
        var contestantNum = clickedElement.attr("contestantnum");
        var sporttype = clickedElement.attr("sporttype");
        var subsporttype = clickedElement.attr("sportsubtype");
        var parlayrestriction = clickedElement.attr("parlayrestriction");
        var groupdescription = clickedElement.attr("groupdescription");
        var betdescription = clickedElement.attr("betdescription"); 
        var listedpitcherhome = clickedElement.attr("listedpitcher1");
        var listedpitcheraway = clickedElement.attr("listedpitcher2");
        var isparlay = clickedElement.attr("isparlay");
        var isstraight = clickedElement.attr("isStraight");
        var isteaser = clickedElement.attr("isteaser");
        var scheduletext = clickedElement.attr("scheduletext");
        
        var awayTeamID = $("tr[gamenum='"+gameNum+"'].away").find(".teamName").eq(0).text();
        var homeTeamID = $("tr[gamenum='"+gameNum+"'].home").find(".teamName").eq(0).text();
        var selectionOnBetslip = makeSelectionForBetslip(   maxOrder,
                                                            selectionId,
                                                            threshold,
                                                            oddsUS,
                                                            '0',
                                                            '0',
                                                            oddsDecimal,
                                                            '0',
                                                            0,
                                                            gameNum,
                                                            isMainbet,
                                                            isFuture,
                                                            periodNumber,
                                                            betType,
                                                            choseTeam,
                                                            TotalPointsOU,
                                                            contestNum,
                                                            contestantNum,
                                                            sporttype,
                                                            subsporttype,
                                                            parlayrestriction,
                                                            0,
                                                            groupdescription,
                                                            betdescription,
                                                            listedpitcherhome,
                                                            listedpitcheraway,
                                                            awayTeamID,
                                                            homeTeamID,
                                                            isparlay,
                                                            isstraight,
                                                            isteaser,
                                                            scheduletext);
        
	_SELECTIONS_ON_BETSLIP[selectionId]=selectionOnBetslip;           
       
	clickedElement.showBalloon({position: "top center", 
				    contents:'<center>Added to Betslip</center>', 
				    offsetY:-5,
				    maxLifetime: 1500,
				    showDuration: 0,
				    showAnimation: function(d){this.fadeIn(d);},
				    hideDuration: 500,
				    hideAnimation: function(d){this.fadeOut(d);},
                                    classname: "balloon-div",
				    css:{
					backgroundColor: '#facc2e',
					color: 'black',
					border: 'solid 1px #2E2E2E'
				    }});
                 
        _AMOUNT_SELECTIONS_ON_BETSLIP++;
        _AMOUNT_SELECTIONS_ON_BETSLIP_NO_OPEN++;
        loadSelectionsOnBetslipLimits();
    updateBetSlip();
    }else if(!clickedElement.hasClass('blocked')){
	delete _SELECTIONS_ON_BETSLIP[selectionId];
        _AMOUNT_SELECTIONS_ON_BETSLIP--;
        _AMOUNT_SELECTIONS_ON_BETSLIP_NO_OPEN--;
        loadSelectionsOnBetslipLimits();
        updateBetSlip();
    }
    
}

/**
 * Creates a selection object.
 * This method is used when a selection is clicked or when an open selection has been added.
 * 
 * @return {makeSelectionForBetslip.selectionOnBetslip|Object}
 */
function makeSelectionForBetslip(maxOrder, selectionId, threshold, oddsUS, oddsNum, oddsDen, oddsDecimal, isFreePlay, isOpenSelection, gameNum, isMainbet, isFuture, periodNumber, betType, choseTeam, TotalPointsOU, contestNum, contestantNum, sporttype, subsporttype, parlayrestriction, thresholdteaser, groupdescription, betdescription, listedpitcherhome, listedpitcheraway, awayTeamID, homeTeamID,isparlay,isstraight,isteaser,scheduletext){
    var selectionOnBetslip=new Object();
    selectionOnBetslip['order']=maxOrder;
    selectionOnBetslip['selectionId']=selectionId;
    selectionOnBetslip['threshold']=threshold;
    selectionOnBetslip['US']=oddsUS;
    selectionOnBetslip['Num']=oddsNum;
    selectionOnBetslip['Den']=oddsDen;
    selectionOnBetslip['Dec']=oddsDecimal;
    selectionOnBetslip['fp']=isFreePlay;
    selectionOnBetslip['isOpenSelection']=isOpenSelection;
    selectionOnBetslip['GameNum']=gameNum;
    selectionOnBetslip['isMainBet']=isMainbet;
    selectionOnBetslip['isFuture']= typeof isFuture === "undefined" ? "0" : isFuture;
    selectionOnBetslip['PeriodNumber']=periodNumber;
    selectionOnBetslip['betType']=betType;
    selectionOnBetslip['ChosenTeamID']=choseTeam;
    selectionOnBetslip['TotalPointsOU']=TotalPointsOU;
    selectionOnBetslip['ContestNum']=contestNum;
    selectionOnBetslip['ContestantNum']=contestantNum;
    selectionOnBetslip['SportType']=sporttype;
    selectionOnBetslip['SubSportType']=subsporttype;
    selectionOnBetslip['thresholdTeaser']=thresholdteaser;
    selectionOnBetslip['ParlayRestriction']=parlayrestriction;
    selectionOnBetslip['groupdescription']=groupdescription; 
    selectionOnBetslip['betdescription']=betdescription;   
    selectionOnBetslip['isStraight'] = isstraight;
    selectionOnBetslip['isParlay'] = isparlay;//(isMainbet == "1" && betType != "C") ? 1 : 0;
    selectionOnBetslip['isTeaser'] = isteaser; //(isMainbet == "1" && betType != "C") ? 1 : 0;
    selectionOnBetslip['listedpitcherhome'] = listedpitcherhome;
    selectionOnBetslip['listedpitcheraway'] = listedpitcheraway;
    selectionOnBetslip['scheduletext'] = scheduletext;
    selectionOnBetslip['awayTeamID'] = awayTeamID;
    selectionOnBetslip['homeTeamID'] = homeTeamID;
    selectionOnBetslip['moreOdds']={}; 
    selectionOnBetslip['pitcherOptions']={};
    computePoints(selectionOnBetslip);
    computePitchers(selectionOnBetslip);    
    selectionOnBetslip['originalSelection']=$.extend(true, {}, selectionOnBetslip);
    return selectionOnBetslip;
}

/**
 * Return the next integer order for betslip
 * @return {getNextOrderSelectionOnBetSlip.order|Number}
 */
function getNextOrderSelectionOnBetSlip(){
    var maxOrder=0;
    for(var selectionId in _SELECTIONS_ON_BETSLIP){
	var selectionOnBetslip=_SELECTIONS_ON_BETSLIP[selectionId];
	var order=parseInt(selectionOnBetslip['order'])
	if(maxOrder<order)
	    maxOrder=order;
    }
    return maxOrder+1;
}

/**
 * Highlight the selected selections on the overview
 * @return {undefined}
 */
function hightLigthSelectionOnBetslip() {
    $(".selection").removeClass("onBetslip");
    $(".addToBetslip").removeClass("onBetslip");

    $.each(_SELECTIONS_ON_BETSLIP, function(key, value) {
        var item = $("button[selectionid='" + key + "']");
        item.addClass("onBetslip");

        var item = $("li[selectionid='" + key + "']");
        item.addClass("onBetslip");
    });  
}
















/*  _   _ _   _ _
   | | | | |_(_) |___
   | | | | __| | / __|
   | |_| | |_| | \__ \
    \___/ \__|_|_|___/*/
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
 
/**
 * Return the max allowed amount of selections according to selected teaser type
 * @return {Number}
 */
function getMaxSelectionsAllowedTeaser(){
    var teasers=siteCache['customer']['teasers'];
    
    if(typeof(teasers[_TEASER_TYPE])!='undefined')
	return parseInt(teasers[_TEASER_TYPE]['MaxPicks']);
    
    return 0;
}

function getMinSelectionsAllowedTeaser(){
    var teasers=siteCache['customer']['teasers'];
    
    if(typeof(teasers[_TEASER_TYPE])!='undefined')
	return parseInt(teasers[_TEASER_TYPE]['MinPicks']);
    
    return 0;
}

function checkLimitsHookup(limit, risk, toWin){
    if(isIsset(limit)){ $(".maxbet .limit").html(limit['high']);}
    var error=false;
    if(_AMOUNT_SELECTIONS_ON_BETSLIP>0 && limit!=null){
	var bet=risk;
	if(toWin!=null && bet>toWin) 
	    bet=toWin;
        
        var useHigherInstead = false;
        if(_BETSLIP_TYPE == "parlay"){
            if(parseFloat(toWin) >= (parseFloat(siteCache.customer.ParlayMaxPayout)/100) && parseFloat(limit['high']) > (parseFloat(siteCache.customer.ParlayMaxPayout)/100))
                useHigherInstead = true;
        }
        
        if(useHigherInstead)
            bet = Math.max(parseFloat(risk), parseFloat(toWin));
                
    var combine = combineSelectionsOnBetslip();
    var combineLength = _BETSLIP_TYPE === "rndrobin" ? combine.length : 1;
        
	if((parseFloat(limit['low'])*combineLength) > bet){
        
        if (_TRIGGERED_BY === "placeBet"){
            error=true;
            $("#betslip .lowLimitError .amount").html(limit['low']);
            $("#betslip .lowLimitError").show();
        }
  
	}else
	    $("#betslip .lowLimitError").hide();
        
	if((parseFloat(limit['high'])*combineLength)<bet){
	    error=true;
	    $("#betslip .highLimitError .amount").html(limit['high']);
	    $("#betslip .highLimitError .betedAmount").html(limit['betedAmount']);
	    $("#betslip .highLimitError .total").html(limit['total']);
	    $("#betslip .highLimitError").show();
	}else
	    $("#betslip .highLimitError").hide();
    }else{
	$("#betslip .lowLimitError").hide();
	$("#betslip .highLimitError").hide();
    }
    
    return error;
}

/**
 * Validates the free play check and CSS
 * @return {undefined}
 */
function updateFreePlayCheck(){
    var customer=siteCache['customer'];
    var FreePlayBalance=parseFloat(customer['FreePlayBalance']);

    if(FreePlayBalance<=0 || _BETSLIP_TYPE != "straight"){
        $("#betslip .maxAmounts .maxRiskWrap").css("width", "100%");
        $("#betslip .maxAmounts .maxToWinWrap").css("width", "100%");
        $("#betslip .teaserAmounts .maxRiskWrap").css("width", "50%");
        $("#betslip .teaserAmounts .maxToWinWrap").css("width", "50%");
        
        $("#betslip .globalFreePlayWrap").hide();
        $("#betslip .fpSelectorWrap").hide();
        $("#betslip .amountMenu .amount").css("width", "65%");
        $("#betslip .selection .selectionDescWrap .oddsWrap").css("width", "30.5%");
    }
    else{
        $("#betslip .maxAmounts .maxRiskWrap").css("width", "100%");
        $("#betslip .maxAmounts .maxToWinWrap").css("width", "100%");
        $("#betslip .teaserAmounts .maxRiskWrap").css("width", "43.5%");
        $("#betslip .teaserAmounts .maxToWinWrap").css("width", "43.5%");
        
        if(_AMOUNT_SELECTIONS_ON_BETSLIP>0){
             $("#betslip .globalFreePlayWrap").show();
        }else{
            $("#betslip .globalFreePlayWrap").hide();
        }
       
        if($("#betslip .fpSelectorWrap").css("visibility") != "hidden"){
            $("#betslip .fpSelectorWrap").show();
            $("#betslip .amountMenu .amount").css("width", "60%");
            $("#betslip .selection .selectionDescWrap .oddsWrap").css("width", "45%");
        }
        else {
            $("#betslip .fpSelectorWrap").hide();
            $("#betslip .amountMenu .amount").css("width", "65%");
            $("#betslip .selection .selectionDescWrap .oddsWrap").css("width", "30%");
        }
    }
    
    if(FreePlayBalance<=0){
	if(_FREE_PLAY_CHECKED=='1')
	    _FREE_PLAY_CHECKED='0';
	
	for(var selectionId in _SELECTIONS_ON_BETSLIP){
	    if(_SELECTIONS_ON_BETSLIP[selectionId]['fp']=='1'){
		_SELECTIONS_ON_BETSLIP[selectionId]['fp']=0;
	    }
	}
    }
     
    var freePlayCheck=$("#betslip .globalFreePlayWrap input");
    if(_FREE_PLAY_CHECKED=='1' && !freePlayCheck.is(':checked'))
	freePlayCheck.click();
    else if(_FREE_PLAY_CHECKED!='1' && freePlayCheck.is(':checked'))
	freePlayCheck.click();
}


/**
 * Loads selections on betslip limits
 * @return {undefined}
 */
function loadSelectionsOnBetslipLimits(){
    if(_LIMITS_AJAX != null)
        _LIMITS_AJAX.abort();
    
    if(_AMOUNT_SELECTIONS_ON_BETSLIP_NO_OPEN>0){
        _LIMITS_AJAX = $.ajax({
            url: "/Sportbook/getselectionslimits",
            dataType: "json",                    
            cache: false,
            method: "POST",
            data: {selectionsOnBetslip:JSON.stringify(_SELECTIONS_ON_BETSLIP),roundrobinType:_ROUND_ROBIN_TYPE,fullcustomerAgent: $("#sp_CustomerID").val()}
        })
        .done(function(data){
            _LIMITS = data;
            updateBetSlip();
        });
    }
}

/**
 * Updates selection on betslip info into the DOM 
 * @return {updateBetslipSelections.sportbook_betslipAnonym$3}
 */
function updateBetslipSelections(){
    //removing selections not in the betslip
    var selectionsHtml=$("#betslip .selection");
    for(var i=0; i<selectionsHtml.length; i++){
	var selectionHtml=selectionsHtml.eq(i);
	if(typeof(_SELECTIONS_ON_BETSLIP[selectionHtml.attr("selectionId")])=='undefined')
	    selectionHtml.remove();
    }
    
    //drawing new selections and updating currents.
    
    var unavailableError=false;
    var amountError=false;
    var changeSelectionError=false;
    var restWagerError=false;
    for(var selectionId in _SELECTIONS_ON_BETSLIP){
	var selectionOnBetslip=_SELECTIONS_ON_BETSLIP[selectionId];
	if(selectionOnBetslip['isOpenSelection']!='1'){
            var selectionResult=drawSelectionBetslip(selectionOnBetslip);

            if(selectionResult['unavailableError'])
                unavailableError=true;

            if(selectionResult['amountError'])
                amountError=true;

            if(selectionResult['changeSelectionError'])
                changeSelectionError=true;

            if(selectionResult['restWagerError'])
                    restWagerError=true;
	}else{
	    drawSelectionOpenSelectionBetslip(selectionOnBetslip);
	}
    }
    
    return {"unavailableError":unavailableError, "amountError":amountError, "changeSelectionError":changeSelectionError, "restWagerError":restWagerError};
}

/**
 * Draw selection on betslip
 * @param {type} selectionOnBetslip
 * @return {drawSelectionBetslip.sportbook_betslipAnonym$6}
 */
function drawSelectionBetslip(selectionOnBetslip){
    var oddsStyle=getOddsStyle();
    var unavailableError=false;
    var changeSelectionError=false;
    var amountError=false;
    var restWagerError=false;
    var awayTeamID = selectionOnBetslip['awayTeamID'];
    var homeTeamID = selectionOnBetslip['homeTeamID'];
    
    
    var selectedThreshold=selectionOnBetslip['threshold'];
   
    var selectionContainerId="betslip_selection_"+selectionOnBetslip['selectionId'];
    
    if($("#"+selectionContainerId).length==0){
	
	var pitcherWrap="";
   
	if(selectionOnBetslip['SportType']=='Baseball'){
	    if(typeof(selectionOnBetslip['pitcherOptions'])!='undefined'){
          
                var pitcherSelector="";
                if(countObject(selectionOnBetslip['pitcherOptions'])>1){
                    pitcherSelector+=	"<select class='pitcherSelector form-control'>";
                    for(var i in selectionOnBetslip['pitcherOptions']){
                        var option=selectionOnBetslip['pitcherOptions'][i];
                        pitcherSelector+=   "<option value='"+option+"'>"+option+"</option>";
                    }
                    pitcherSelector+=	"</select>";
                }else{
                    for(var i in selectionOnBetslip['pitcherOptions'])
                    pitcherSelector=selectionOnBetslip['pitcherOptions'][i]+"<input type='hidden' name='pitcherSelector' class='pitcherSelector' value='"+selectionOnBetslip['pitcherOptions'][i]+"' />";
                }
                pitcherWrap="<div class='pitcherSelectorWrap'>"+pitcherSelector+"</div>";
	    }
	}
    
        var globalFreePlay = false;
        if ($("#globalFreePlay").is(":checked")) {
            globalFreePlay = true;
        }
    
	var html="";

	var html= "<div class='selection secret' id='"+selectionContainerId+"' selectionId='"+selectionOnBetslip['selectionId']+"' order='"+selectionOnBetslip['order']+"'>";
			html += "<div class='ifLabel secret margin-bottom'>IF</div>";
			html += "<div class='panel panel-default'  >";
			    html += "<div class='panel-heading pannel-heading-2'>";
				html += "<div class='selectionTitleTable'>";
				    html += "<div class='ellipsisTitle'>";
                                    if(!selectionOnBetslip['isFuture'] || awayTeamID != "")
                                        html += homeTeamID+" vs "+awayTeamID;
                                    else {
                                        html += selectionOnBetslip['groupdescription']; 
                                    }
				    html += "</div>";
				    html += "<div class='removeFromBetslipWrap'>";
					html += "<span class='glyphicon glyphicon-remove removeFromBetslip' selectionid='"+selectionOnBetslip['selectionId']+"' aria-hidden='true'></span>";
				    html += "</div>";
				html += "</div>";
			    html += "</div>";
			    html += "<div class='panel-body'>";
                html += "<div>";
                if(!selectionOnBetslip['isFuture'] || awayTeamID != "")
                    html += "<div class='descBet'> "+selectionOnBetslip['groupdescription']+" - "+selectionOnBetslip['betdescription']+" </div>";
                else {
                    html += "<div class='descBet'> "+selectionOnBetslip['betdescription']+" </div>";
                }		
                
                 if(pitcherWrap === ''){
                     html += "<div class='desc' style='width:50%'>"+selectionOnBetslip['ChosenTeamID'] + "</div>";
                     html += "<div class='selectionDescWrap' style='width:35%'>";
                      html += "<div class='oddsWrap' style='width:1%'>";
                       html += "<div class='defaultOdds'>";
                        html += "<span class='threshold'></span> <span class='odds'></span>";
                       html += "</div>";
                       html += "<select class='buyPoints form-control sort' id='sele_buyPoints'></select>";
                      html += "</div>";
                     html += "</div>";
                 }else{
                    
                     html += "<div class='desc'>"+selectionOnBetslip['ChosenTeamID'] + "</div>";
                    
                 }
                if(selectionOnBetslip['SportType']=='Baseball'){ 	
                    html += "<div class='descBet'> "+selectionOnBetslip['listedpitcherhome']+" </div>"; 	
                    html += "<div class='descBet'> "+selectionOnBetslip['listedpitcheraway']+" </div>"; 	
                }
                html += "<div style='clear:both;'></div>";
                html += "</div>";
                
                if(pitcherWrap !== ''){
                    
                    html += "<div class='selectionDescWrap'>";
                    html += pitcherWrap;
				    html += "<div class='oddsWrap'>";
					html += "<div class='defaultOdds'>";
					    html += "<span class='threshold'></span> <span class='odds'></span>";
					html += "</div>";
					html += "<select class='buyPoints form-control sort' id='sele_buyPoints'></select>";
				    html += " </div>";
				html += "</div>";
				html += "<div class='margin-bottom'></div>";
                    
                }
                
				
               
                html += "<div class='maxbet'>";
                        html += getTextJs["sportbook_betslip_MaxAmount"]+": <span class='limit'></span>";
                     html += "</div>";
				//html += "<div class='amountMenu secret'>";
                                html += "<div class='amountMenu'>";
				    html += "<div class='table'>";
                                        html += "<div class='cell riskWrap' onclick='setInputToWriteSpan(&quot;risk_" + selectionOnBetslip['selectionId'] + "&quot;)'><label style='width:21%;'>"+getTextJs['sportbook_betslip_Risk']+":</label><input id='risk_" + selectionOnBetslip['selectionId'] + "' type='number' pattern='[0-9]*' inputmode='numeric' name='risk' value='' class='amount riskAmount' style='float: right;' /></div>";
					html += "<div class='cell winWrap' onclick='setInputToWriteSpan(&quot;win_" + selectionOnBetslip['selectionId'] + "&quot;)'><label style='width:21%;'>"+getTextJs['sportbook_betslip_Win']+":</label><input  id='win_" + selectionOnBetslip['selectionId'] + "'  type='number' pattern='[0-9]*' inputmode='numeric' name='win' value='' class='amount winAmount' style='float: right;' /></div>";
					html += "<div class='cell fpSelectorWrap'>FP:&nbsp;<input type='checkbox' name='selectionFreePlay' class='selectionFreePlay' " + (globalFreePlay ? "checked='checked'" : "") + " value='1'/></div>";
				    html += "</div>";
				html += "</div>";
				html += "<div class='messages'>";
				    html += "<div class='secret margin-top message hightLimitMessage'>";
					html += "<span class='glyphicon glyphicon-usd' aria-hidden='true'></span> ";
					html += getTextJs['sportbook_betslip_BetAmountHasToBeUnder']+" <span class='limit'></span><br/>(Bet:<span class='betedAmount'></span>/<span class='total'></span>)";
				    html += "</div>";
				    html += "<div class='secret margin-top message lowLimitMessage'>";
					html += "<span class='glyphicon glyphicon-usd' aria-hidden='true'></span> ";
					html += getTextJs['sportbook_betslip_BetAmountHasToBeOver']+" <span class='limit'></span>";
				    html += "</div>";
				    html += "<div class='secret margin-top message unavailbleMessage'>";
					html += "<span class='glyphicon glyphicon-ban-circle' aria-hidden='true'></span> ";
					html += getTextJs['sportbook_betslip_SelectionUnavailable'];
				    html += "</div>";
                                    html += "<div class='secret margin-top message transactionFailed' style='display:none'>";
                                    html += "<span class='glyphicon glyphicon-ban-circle' aria-hidden='true'></span> ";
                                    html += "<span id='TransactionMessage'></span>"
                                    html += "</div>";
				    html += "<div class='secret margin-top message changeSelectionError'>";
					html += "<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span> ";
					html += getTextJs['sportbook_betslip_SelectionChanged'];
					html += "<button class='btn btn-success btn-xs acceptChangesSelection' type='button'>Accept</button>";
				    html += "</div>";
				html += "</div>";
			    html += "</div>";
			html += "</div>";
		    html += "</div>";
                    
	$("#betslip .selections").append(html);
        updateFreePlayCheck();
    
	$('#'+selectionContainerId+' .selectionFreePlay').checkbox({
		buttonStyle: 'btn-base',
		buttonStyleChecked: 'btn-success',
		checkedClass: 'icon-check',
		uncheckedClass: 'icon-check-empty'
	});
	
	$('#'+selectionContainerId).show();
	
	setBetslipEvents();
        
    }
    
    var selectionAux=$.extend({}, selectionOnBetslip['originalSelection']);

    if(_BETSLIP_TYPE=='teaser' && selectionOnBetslip['thresholdTeaser'] != 0){
        
        selectionAux['threshold']=selectionOnBetslip['thresholdTeaser'];
    }
    updateSelection(selectionAux, $("#"+selectionContainerId+" .defaultOdds"), oddsStyle);
    

    var showBuyPoints=false;
    var optionsIDs=new Object();
    if(typeof(selectionOnBetslip['moreOdds'])!='undefined'){
	var buyPoints=$("#"+selectionContainerId+" .buyPoints");
         var PriceType =  siteCache['customer']['PriceType'];  // A- American / F -  fractional
         if(PriceType == "A"){
            for(var i in selectionOnBetslip['moreOdds']){
                showBuyPoints=true;
                var selectionAux=selectionOnBetslip['moreOdds'][i];
              
                selectionAux['betType']=selectionOnBetslip['betType'];
                selectionAux['ChosenTeamID']=selectionOnBetslip['ChosenTeamID'];
                
                var optionID=sanitiazeId(selectionContainerId+"_"+selectionAux['threshold']);
                optionsIDs[optionID]=true;
                
                if($("#"+optionID).length==0)
                    buyPoints.append("<option id='"+optionID+"' value='"+selectionAux['threshold']+"'></option>");
                var selectionAuxFort = formatThreshold(selectionAux);
                selectionAuxFort = (selectionAuxFort.charAt(0) == "U" || selectionAuxFort.charAt(0) == "O" ? selectionAuxFort.slice(1) : selectionAuxFort);
                $("#"+optionID).html(selectionAuxFort+" "+formatOdds(selectionAux, oddsStyle));
                $("#"+optionID).attr("order", selectionAux['threshold']);
                
                if(selectionAux['threshold']==selectionOnBetslip['threshold'])
                    $("#"+optionID).addClass('default');
                else
                    $("#"+optionID).removeClass('default');
                
                if(selectionAux['threshold'] == selectedThreshold)
                    $("#"+optionID).prop('selected', true);
            } 
         }else{
            for(var i in selectionOnBetslip['moreOdds']){
                showBuyPoints=true;
                var selectionAux=selectionOnBetslip['moreOdds'][i];
                selectionAux['betType']=selectionOnBetslip['betType'];
                selectionAux['ChosenTeamID']=selectionOnBetslip['ChosenTeamID'];
                var optionID=sanitiazeId(selectionContainerId+"_"+selectionAux['threshold']);
                optionsIDs[optionID]=true;
                
                if($("#"+optionID).length==0)
                    buyPoints.append("<option id='"+optionID+"' value='"+selectionAux['threshold']+"'></option>");
                    
                var selectionAuxFort = formatThreshold(selectionAux);
                selectionAuxFort = (selectionAuxFort.charAt(0) == "U" || selectionAuxFort.charAt(0) == "O" ? selectionAuxFort.slice(1) : selectionAuxFort);
                $("#"+optionID).html(selectionAuxFort+" "+FixedNumbers(selectionAux['Dec']));
                $("#"+optionID).attr("order", selectionAux['threshold']);

                if(selectionAux['threshold']==selectionOnBetslip['threshold'])
                    $("#"+optionID).addClass('default');
                else
                    $("#"+optionID).removeClass('default');
                
                if(selectionAux['threshold'] == selectedThreshold)
                    $("#"+optionID).prop('selected', true);
            }     
         }
    }
    
    if(typeof(selectionOnBetslip['pitcher'])!='undefined'){
        $("#"+selectionContainerId+" .pitcherSelector").val(selectionOnBetslip['pitcher']);
    }
    
    //removing old options
    var optionsHtml=$("#"+selectionContainerId+" .buyPoints option");
    for(var i=0; i<optionsHtml.length; i++){
        var optionHtml=optionsHtml.eq(i);
        if(typeof(optionsIDs[optionHtml.attr('id')])=='undefined')
            optionHtml.remove();
    }
    
 
    if(showBuyPoints && (_BETSLIP_TYPE=='straight' || _BETSLIP_TYPE=='parlay')){
        $("#"+selectionContainerId+" .defaultOdds").hide();
        $("#"+selectionContainerId+" .buyPoints").show();
        $("#"+selectionContainerId+" .oddsWrap").addClass("buyPointsOn");
    }else{
        $("#"+selectionContainerId+" .defaultOdds").show();
        $("#"+selectionContainerId+" .buyPoints").hide();
        $("#"+selectionContainerId+" .oddsWrap").removeClass("buyPointsOn");
    }
    
    $("#"+selectionContainerId+" .winAmount").val(selectionOnBetslip['winAmount']);
    $("#"+selectionContainerId+" .riskAmount").val(selectionOnBetslip['riskAmount']);
    
    //verifying FP check
    var freePlayCheck=$("#"+selectionContainerId+" .fpSelectorWrap input");
    if(selectionOnBetslip['fp']=='1' && !freePlayCheck.is(':checked'))
        freePlayCheck.click();
    if(selectionOnBetslip['fp']!='1' && freePlayCheck.is(':checked'))
        freePlayCheck.click();
    
    //verifirying if selection change
    var finalSelection=getFinalOddsSelection(selectionOnBetslip);
    //showing messages
    if(finalSelection['threshold']!=selectionOnBetslip['threshold'] || finalSelection['US']!=selectionOnBetslip['US']){
        changeSelectionError=true;
        $("#"+selectionContainerId+" .messages .changeSelectionError").show();
        $("#"+selectionContainerId+" .acceptChangesWrap").show();
    }
    else{
        $("#"+selectionContainerId+" .messages .changeSelectionError").hide();
        $("#"+selectionContainerId+" .acceptChangesWrap").hide();
    }
    
    // Max Bet
    if(_BETSLIP_TYPE=='straight' || _BETSLIP_TYPE=='ifbet' || _BETSLIP_TYPE=='reverse'){
        if(typeof _LIMITS['straight'] != "undefined")
            if (typeof _LIMITS['straight'][selectionOnBetslip['selectionId']] != "undefined")
                $("#"+selectionContainerId+" .maxbet .limit").html(_LIMITS['straight'][selectionOnBetslip['selectionId']]['high']);
    }else if(_BETSLIP_TYPE=='parlay' || _BETSLIP_TYPE=='rndrobin'){
        if (typeof _LIMITS['parlay'] != "undefined")
            $("#betslip .maxAmounts  .maxLimit").html(_LIMITS['parlay']['high']);
    }else if(_BETSLIP_TYPE=='teaser'){
        if (typeof _LIMITS['teaser'] != "undefined")
            $("#"+selectionContainerId+" .maxbet .limit").html(_LIMITS['teaser']['high']);
    }else{
        $("#"+selectionContainerId+" .maxbet .limit").html("");
    }   
    
    
        
    if(_BETSLIP_TYPE=='straight' && isNaN(parseFloat(selectionOnBetslip['riskAmount']))){
        amountError=true;
    }
    
    // Restriction Wager error
    if(_BETSLIP_TYPE=='straight' && selectionOnBetslip['isStraight'] != 1){
        restWagerError=true;
    }
    
    if((_BETSLIP_TYPE=='parlay' || selectionOnBetslip=='rndrobin') && selectionOnBetslip['isParlay'] != 1){
        restWagerError=true;
    }
    if(_BETSLIP_TYPE=='teaser' && selectionOnBetslip['isTeaser'] != 1){
        restWagerError=true;
    }
     
    var lowLimitError=false;
    var highLimitError=false;
    var betAmount=Math.min(parseFloat(selectionOnBetslip['riskAmount']), parseFloat(selectionOnBetslip['winAmount'])); 
    if(_BETSLIP_TYPE=='straight' || _BETSLIP_TYPE=='ifbet'){
        if(typeof _LIMITS['straight'] != "undefined"){
            var selectionId=selectionOnBetslip['selectionId'];
            if(typeof(_LIMITS['straight'][selectionId])!='undefined'){
                if(betAmount<parseFloat(_LIMITS['straight'][selectionId]['low'])){
                    $("#"+selectionContainerId+" .messages .lowLimitMessage .limit").html(_LIMITS['straight'][selectionId]['low']);
                    $("#"+selectionContainerId+" .messages .lowLimitMessage").show();
                    amountError=true;
                    lowLimitError=true;
                }
    
                if(betAmount>parseFloat(_LIMITS['straight'][selectionId]['high'])){
                    $("#"+selectionContainerId+" .messages .hightLimitMessage .limit").html(_LIMITS['straight'][selectionId]['high']);
                    $("#"+selectionContainerId+" .messages .hightLimitMessage .betedAmount").html(_LIMITS['straight'][selectionId]['betedAmount']);
                    $("#"+selectionContainerId+" .messages .hightLimitMessage .total").html(_LIMITS['straight'][selectionId]['total']);
                    $("#"+selectionContainerId+" .messages .hightLimitMessage").show();
                    amountError=true;
                    highLimitError=true;
                }
            }
        }
    }
    if(!lowLimitError)
        $("#"+selectionContainerId+" .messages .lowLimitMessage").hide();
  
    if(!highLimitError)
        $("#"+selectionContainerId+" .messages .hightLimitMessage").hide();
    
    return {"unavailableError":unavailableError, "amountError":amountError, "changeSelectionError":changeSelectionError, "restWagerError":restWagerError};
}

function updateSelection(selection, selectionHtml, oddsStyle){
    if (selectionHtml.parents('.selection').hasClass('contestant')) {
        selectionHtml.removeClass('secret');
        var odd =  parseInt(selection['MoneyLine']);
        odd = odd > 0 ? "+"+odd : odd;
        selectionHtml.find(".odds").html(odd);
    }else{
        selectionHtml.removeClass('secret');
        var selectionFort = formatThreshold(selection);
        
        if(typeof selectionFort !== 'undefined'){
            selectionFort = (selectionFort.charAt(0) == "U" || selectionFort.charAt(0) == "O" ? selectionFort.slice(1) : selectionFort);
        }else{
            selectionFort = "";
        }
        
        selectionHtml.find(".threshold").html(selectionFort);
         var PriceType =  siteCache['customer']['PriceType'];  // A- American / F -  fractional
         if(PriceType == "A"){
               selectionHtml.find(".odds").html(formatOdds(selection, oddsStyle));
         }else{
               selectionHtml.find(".odds").html(FixedNumbers(selection['Dec']));
         }
    }
}

function removeFromBetSlip(selectionId){
    if(typeof _SELECTIONS_ON_BETSLIP[selectionId] != "undefined"){
        delete _SELECTIONS_ON_BETSLIP[selectionId];
        _AMOUNT_SELECTIONS_ON_BETSLIP--;
        _AMOUNT_SELECTIONS_ON_BETSLIP_NO_OPEN--;
        updateBetSlip();
    }
}

function removeFromBetslipClick(){
    var selectionid=$(this).attr("selectionid");
    removeFromBetSlip(selectionid);
}

function setAllAmountsBetslip(selectedAmountType, selectedAmount){
    for(var selectionId in _SELECTIONS_ON_BETSLIP){
	_SELECTIONS_ON_BETSLIP[selectionId]['selectedAmount']=selectedAmount;
	_SELECTIONS_ON_BETSLIP[selectionId]['selectedAmountType']=selectedAmountType;
    }
}

function checkOpenBetDenyError(){    
    if(_BETSLIP_TYPE=='parlay'){
	return false;
    }
    
    if(_BETSLIP_TYPE=='teaser'){
	return false;
    }
    
    for(var selectionId in _SELECTIONS_ON_BETSLIP)
	if(_SELECTIONS_ON_BETSLIP[selectionId]['isOpenSelection']=='1')
	    return true;
    
    return false;
}

function markSelectionsErrorBetslip(){
    var selectionsInfo=new Object();
    for(var selectionId in _SELECTIONS_ON_BETSLIP){
	var selectionOnBetslip=_SELECTIONS_ON_BETSLIP[selectionId];
	if(selectionOnBetslip['isOpenSelection']!='1')
	    selectionsInfo[selectionId]=_SELECTIONS_ON_BETSLIP[selectionId]['originalSelection'];
    }
    
    var errors=getSelectionsError(selectionsInfo);
    
    var errorsIDs=new Object();
    for(var type in errors){
	var errorsType=errors[type];
	for(var i=0; i<errorsType.length; i++)
	    for(var j=0; j<errorsType[i].length; j++)
		errorsIDs[errors[type][i][j]]=true;
    }
    
    for(var selectionId in _SELECTIONS_ON_BETSLIP){
	var betslipSelectionId="betslip_selection_"+selectionId;
	if(typeof(errorsIDs[selectionId])!='undefined'){
	    $("#"+betslipSelectionId).addClass("error");
	}
	else
	    $("#"+betslipSelectionId).removeClass("error");
    }
}
function addOpenSelectionToBetslipClick(){
    var order=getNextOrderSelectionOnBetSlip(_SELECTIONS_ON_BETSLIP);
    var selectionId="openSelection_"+order;
    var selectionOnBetslip = makeSelectionForBetslip(   order,
                                                        selectionId,
                                                        '0',
                                                        '0',
                                                        '0',
                                                        '0',
                                                        '0',
                                                        '0',
                                                        1,
                                                        '0',
                                                        '0',
                                                        '0',
                                                        '',
                                                        '',
                                                        '',
                                                        '',
                                                        '',
                                                        '',
                                                        '',
                                                        '',
                                                        '',
                                                        0,
                                                        '',
                                                        '',
                                                        '',
                                                        '',
                                                        '',
                                                        '');
                                                        
    _SELECTIONS_ON_BETSLIP[selectionId]=selectionOnBetslip;
    _AMOUNT_SELECTIONS_ON_BETSLIP++;    
    updateBetSlip();
}

function drawSelectionOpenSelectionBetslip(selectionCookieInfo){
    var selectionContainerId="betslip_selection_"+selectionCookieInfo['selectionId'];
    if($("#"+selectionContainerId).length==0){
	var html=   "<div class='secret selection openSelection margin-bottom' id='"+selectionContainerId+"' selectionId='"+selectionCookieInfo['selectionId']+"' order='"+selectionCookieInfo['order']+"'>"+
			"<div class='selectionTitleTable'>"+
			    "<div class='ellipsisTitle'>"+
				"Open Selection"+
			    "</div>"+
			    "<div class='removeFromBetslipWrap'>"+
				"<span class='glyphicon glyphicon-remove removeFromBetslip' selectionid='"+selectionCookieInfo['selectionId']+"' aria-hidden='true'></span>"+
			    "</div>"+
			"</div>"+
		    "</div>";
	    
	$("#betslip .selections").append(html);
	$('#'+selectionContainerId).show();
	
	setBetslipEvents();
    }
}

function getUpdatedLinesForSelectionsOnBetslip(){   
    $.ajax({
        url: "/Sportbook/getUpdateLinesForBetslip",
        dataType: "json",                    
        cache: false,
        method: "POST",
        data: {selectionsOnBetslip:JSON.stringify(filterSelections())}
    })
    .done(function(data){
        var someSelectionHasChanged = false;
        var mustRefreshScreenData = false;
        for(var selectionID in data){
            var originalSelection = _SELECTIONS_ON_BETSLIP[selectionID]["originalSelection"];
            
            if(selectionsHasOddsChanged(originalSelection, data[selectionID])){
                someSelectionHasChanged = true; 
                //We need to update the more points object, to update them in the betslip
                originalSelection["moreOdds"] = {};                
                computePoints(originalSelection);
                //Let's update the object in order to update betslip
                _SELECTIONS_ON_BETSLIP[selectionID]["moreOdds"] = originalSelection["moreOdds"];
                _SELECTIONS_ON_BETSLIP[selectionID]["originalSelection"]["US"] = data[selectionID]["US"];
                _SELECTIONS_ON_BETSLIP[selectionID]["originalSelection"]["Dec"] = data[selectionID]["dec"];
                _SELECTIONS_ON_BETSLIP[selectionID]["originalSelection"]["threshold"] = data[selectionID]["threshold"]; 
                
                if($("button[selectionid='"+selectionID+"']").length > 0)
                    mustRefreshScreenData = true;
                
            }
        }
        
        //If some selection has change so we must update the betslip
        if(someSelectionHasChanged){
//            console.log("CAMBIANDO");
            updateBetSlip();
        }
    });    
}

function selectionsHasOddsChanged(betslipSelection, updatedLine){
    if(typeof(betslipSelection) == "undefined" || typeof(updatedLine) == "undefined"){
        return false;
    }
    
    if( betslipSelection["US"] == updatedLine["US"] &&
        betslipSelection["Dec"] == updatedLine["dec"] &&
        betslipSelection["threshold"] == updatedLine["threshold"] )
        return false;
    
    return true;
}



















/*  __  __       _   _
   |  \/  | __ _| |_| |__
   | |\/| |/ _` | __| '_ \
   | |  | | (_| | |_| | | |
   |_|  |_|\__,_|\__|_| |_|*/
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
/**
 * Computes the threshold teaser for all selections on betslip
 * @return {undefined}
 */
function computeThresholdTeaser(){
    if(_BETSLIP_TYPE !== 'teaser')
	return;
    
    for(var selectionId in _SELECTIONS_ON_BETSLIP){
	var selectionOnBetslip = _SELECTIONS_ON_BETSLIP[selectionId];
	
	if(selectionOnBetslip['isOpenSelection']=='1')
	    continue;
	
	var SportSubType= typeof selectionOnBetslip['SubSportType'] !== 'undefined' ? selectionOnBetslip['SubSportType'].trim() : "";
	var SportType= typeof selectionOnBetslip['SportType'] !== 'undefined' ? selectionOnBetslip['SportType'].trim() : "";
	var betType=selectionOnBetslip['betType'];
	var teaser=siteCache['customer']['teasers'][_TEASER_TYPE];
	
	if( teaser==null ||
	    typeof(teaser)=='undefined' || 
	    typeof(teaser['SportTypes'][SportType])=='undefined' || 
	    typeof(teaser['SportTypes'][SportType][betType])=='undefined' ||
	    typeof(teaser['SportTypes'][SportType][betType][SportSubType])=='undefined')
	    continue;
	
	var points=parseFloat(teaser['SportTypes'][SportType][betType][SportSubType]);
	var threshold=parseFloat(selectionOnBetslip['threshold']);
	var thresholdTeaser=threshold;
	
	if(betType=='S')
	    thresholdTeaser=threshold+points;
        
	if(betType=='L')
	    thresholdTeaser=selectionOnBetslip['ChosenTeamID']=='Over'? threshold-points : threshold+points;
	
	if(thresholdTeaser!=selectionOnBetslip['thresholdTeaser'])
	    _SELECTIONS_ON_BETSLIP[selectionId]['thresholdTeaser']=thresholdTeaser;
	
    }
}

/**
 * Computes risk and win amount for each selection on betslip
 * @return {undefined}
 */
function computeBetslipSelectionsAmounts(){
    for(var selectionId in _SELECTIONS_ON_BETSLIP){
	var selectionOnBetslip=_SELECTIONS_ON_BETSLIP[selectionId];
	
	if(selectionOnBetslip['isOpenSelection']=='1')
	    continue;
	
	var finalSelection=getFinalOddsSelection(selectionOnBetslip);
	
	var selectedAmount=parseFloat(selectionOnBetslip['selectedAmount']);
	var winAmount="";
	var riskAmount="";
	if(!isNaN(selectedAmount)){
	    var selectedAmountType=selectionOnBetslip['selectedAmountType'];
	    
	    if(selectedAmountType=='winAmount' || (selectedAmountType=='betAmount' && parseFloat(finalSelection['US'])<0)){
		winAmount=selectionOnBetslip['selectedAmount'];
		riskAmount=computeRiskAmount(finalSelection, selectedAmount);
	    }
	    else{
		riskAmount=selectionOnBetslip['selectedAmount'];
		winAmount=computeWinAmount(finalSelection, selectedAmount);
	    }
	}
	if(selectionOnBetslip['riskAmount']!=riskAmount || selectionOnBetslip['winAmount']!=winAmount){
	   _SELECTIONS_ON_BETSLIP[selectionId]['riskAmount'] = riskAmount;
           _SELECTIONS_ON_BETSLIP[selectionId]['winAmount'] = winAmount;
       }
    }
}

/**
 * Checks if points were applied and returns data according to new points change
 * @param {type} selection
 * @param {type} selectionOnBetslip
 * @return {selection@arr;moreOdds}
 */
function getFinalOddsSelection(selectionOnBetslip){
    var selectedThreshold = selectionOnBetslip['threshold'];
    var selection = selectionOnBetslip['originalSelection'];
    var finalSelection=null;
    if(typeof(selection['moreOdds'])!='undefined')
	for(var threshold in selection['moreOdds'])
	    if(parseFloat(threshold)==parseFloat(selectedThreshold)){
		finalSelection=selection['moreOdds'][threshold];
		break;
	    }

    if(finalSelection===null)
	finalSelection=selection;
    
    return finalSelection;
}

/**
 * Computes the risk amount for selection
 * @param {type} selection
 * @param {type} winAmount
 * @return {String}
 */
function computeRiskAmount(selection, winAmount){
    var oddsStyle=getOddsStyle();
    if(oddsStyle==ODDS_STYLE_DECIMAL){
	var hnk=parseFloat(selection['Dec'])-1;
	return myRound(winAmount/hnk, 2);
    }
    if(oddsStyle==ODDS_STYLE_FRACTIONAL){
	var num=parseInt(selection['Num']);
	var den=parseInt(selection['Den']);
	return myRound(winAmount*den/num, 2);
    }
    if(oddsStyle==ODDS_STYLE_HONGKONG){
	var hnk=parseFloat(selection['Dec'])-1;
	return myRound(winAmount/hnk, 2);
    }
    if(oddsStyle==ODDS_STYLE_US){
	var oddsUs=parseFloat(selection['US']);
	return oddsUs>0? myRound(100*winAmount/oddsUs, 2) :  myRound(-oddsUs*winAmount/100, 2);
    }
    return "";
}

/**
 * Computes the win amount for selection
 * @param {type} selection
 * @param {type} riskAmount
 * @return {String}
 */
function computeWinAmount(selection, riskAmount){
    var oddsStyle=getOddsStyle();
    if(oddsStyle==ODDS_STYLE_DECIMAL){
	var hnk=parseFloat(selection['Dec'])-1;
	return myRound(riskAmount*hnk, 2);
    }
    if(oddsStyle==ODDS_STYLE_FRACTIONAL){
	var num=parseInt(selection['Num']);
	var den=parseInt(selection['Den']);
	return myRound(riskAmount*num/den, 2);
    }
    if(oddsStyle==ODDS_STYLE_HONGKONG){
	var hnk=parseFloat(selection['Dec'])-1;
	return myRound(riskAmount*hnk, 2);
    }
    if(oddsStyle==ODDS_STYLE_US){
	var oddsUs=parseFloat(selection['US']);
	return oddsUs>0? myRound(oddsUs*riskAmount/100, 2) : myRound(-100*riskAmount/oddsUs, 2);
    }
    return "";
}

function computeMaxWinAmount(){
    switch(_BETSLIP_TYPE){
        case 'straight':
        case 'ifbet':
            return computeStraightToWin();
        case 'parlay':
            return computeParlayToWin();
        case 'rndrobin':
            return computeRoundRobinToWin();
        case 'teaser':
            return getTeaserWin();
        case 'reverse':
            return getReverseMaxWin();       
    }
    return 0;
}

function computeStraightToWin(){
    var toWin=0;
    for(var SelectionID in _SELECTIONS_ON_BETSLIP)
	toWin+=parseFloat(_SELECTIONS_ON_BETSLIP[SelectionID]['winAmount']);
    return toWin;
}

function computeParlayToWin(){
    var SelectionsID=new Array();
    for(var SelectionID in _SELECTIONS_ON_BETSLIP)
	SelectionsID.push(SelectionID);
    return computeParlayToWinAux(SelectionsID);
}

function computeRoundRobinToWin(){
    var combinations=combineSelectionsOnBetslip();
    var maxWin=0;
    for(var i=0; i<combinations.length; i++){
	maxWin+=computeParlayToWinAux(combinations[i], _SELECTIONS_ON_BETSLIP);
    }
    return maxWin;
}

function getTeaserWin(){    
    if(_TEASER_AMOUNT_TYPE=='win')
	return _TEASER_AMOUNT;
    
    if(isNaN(parseFloat(_TEASER_AMOUNT)))
	return "";
    
    _TEASER_AMOUNT=parseFloat(_TEASER_AMOUNT);
    var PayCard=getCurrentPayCard();
    return PayCard!=null? _TEASER_AMOUNT*parseFloat(PayCard['MoneyLine'])/parseFloat(PayCard['ToBase']) : 0;
}

function getReverseMaxWin(){
    var odds=getReverseOdds();
    
    if(odds['maxOdds']==null || odds['maxOdds']==0)
        return 0;
    
    return odds['maxOdds']>0? _REVERSE_AMOUNT*odds['maxOdds']/100 : -_REVERSE_AMOUNT*100/odds['maxOdds'];
}

function getReverseOdds(){
    var combs=getReverseCombinations();
    
    var selectionIds=new Object();
    for(var i=0; i<combs.length; i++){
	var comb=combs[i];
	for(var j=0; j<comb.length; j++)
	    selectionIds[comb[j]['selectionId']]=true;
    }
    
    var posibilities=getSelectionPosibilities(selectionIds);
    
    var minOdds=null;
    var maxOdds=null;
    for(var k=0; k<posibilities.length; k++){
	var posibility=posibilities[k];
	var Odds=0;
	for(var i=0; i<combs.length; i++){
	    var comb=combs[i];
	    
	    for(var j=0; j<comb.length; j++){
		var sel=comb[j];
		var selOdds=parseInt(sel['US']);
		var id=sel['selectionId'];
		
		if(posibility[id]=='W'){
		    Odds+=selOdds>0? selOdds: 100;
		}
		if(posibility[id]=='L'){
		    Odds+=selOdds>0? -100: selOdds;
		    break;
		}
		if(posibility[id]=='X'){
		    if(_CONTINUE_ON_PUSH_FLAG!='Y')
			break;
		}
	    }
	}
	if(minOdds==null || minOdds>Odds)
	    minOdds=Odds;
	if(maxOdds==null || maxOdds<Odds)
	    maxOdds=Odds;
    }
    
    return {"minOdds":minOdds, "maxOdds":maxOdds};
}

function getSelectionPosibilities(selectionIds){
    var posibilities=[{}];
    
    for(var id in selectionIds){
	var posibilities2=[];
	for(var i=0; i<posibilities.length; i++){
	    var posibility=posibilities[i];
	    
	    var posibilityWin=$.extend({}, posibility);
	    var posibilityLose=$.extend({}, posibility);
	    var posibilityTie=$.extend({}, posibility);
	    
	    posibilityWin[id]='W';
	    posibilities2.push(posibilityWin);
	    
	    posibilityLose[id]='L';
	    posibilities2.push(posibilityLose);
	    
	    posibilityTie[id]='X';
	    posibilities2.push(posibilityTie);
	}
	
	posibilities=posibilities2;
    }
    return posibilities;
}

function getReverseCombinations(){    
    var combs=new Array();
    for(var selectionID1 in _SELECTIONS_ON_BETSLIP)
	for(var selectionID2 in _SELECTIONS_ON_BETSLIP)
	    if(selectionID1!=selectionID2)
		combs.push([_SELECTIONS_ON_BETSLIP[selectionID1], _SELECTIONS_ON_BETSLIP[selectionID2]]);
    return combs;
}

function getCurrentPayCard(){
    var teaser=siteCache.customer.teasers[_TEASER_TYPE];
    if(typeof teaser != "undefined"){
	for(var i in teaser['PayCard']){
	    var PayCard=teaser['PayCard'][i];
	    if(PayCard['GamesWon']==_AMOUNT_SELECTIONS_ON_BETSLIP && PayCard['GamesPicked']==_AMOUNT_SELECTIONS_ON_BETSLIP)
		return PayCard;
	}
    }
    return null;
}

function computeParlayToWinAux(SelectionsID){
    var amount = _GLOBAL_RISK_AMOUNT;
    
    if(amount == 0) return 0;
    
    var customer = siteCache.customer;
    var parlayInfo = customer['parlayInfo'];
    var creditAcct = customer['CreditAcctFlag'] == 'Y';
    var maxParlayPayout = parseFloat(customer['ParlayMaxPayout'])/100;
    var items = getSelectionsForParlay(SelectionsID);
    var maxPayoutMoneyLineItems = 0;
    var winning = 0;
    
    if (countObject(items) == 1) {
        var item = null;
        for (var selid in items) {
            item = items[selid];
            if(item["isOpenSelection"] == 0)
                break;
        }
        var odds = (item['US'] >= 0) ? (1 + (item['US']/ 100)) : (1 + (100 / Math.abs(item['US'])));
	winning = (odds-1)*amount;
    }else{
        var oddsA = 1;
        var oddsB = 1;
        var flatItems = 0;
        var normalItems = 0;
        var oddsM = 1;
        for(var selectionID in items){
            
            if(items[selectionID]["isOpenSelection"] == 1)
                continue;
            
            var sportType = items[selectionID]["SportType"];
            var betType = items[selectionID]["betType"];
            
            var odds = (parseFloat(items[selectionID]['US']) >= 0) ? (1 + (parseFloat(items[selectionID]['US'])/ 100)) : (1 + (100 / Math.abs(parseFloat(items[selectionID]['US']))));
            maxPayoutMoneyLineItems++;
            
            var flatSportTypes = ["Basketball","Football"];
            var flatBetTypes = ["S","L"];
            if($.inArray(sportType, flatSportTypes) > -1 && $.inArray(betType, flatBetTypes) > -1) {
                oddsA *= odds;
                flatItems++;
            } else {
                oddsM *= odds;
                normalItems++;
            }
        }       
        
        if(flatItems > 1) {
            var chart = getParlayChart(parlayInfo, flatItems);
            
            if(chart == null) return 0;
            
            for(var i = 0; i < flatItems; i++) {
                oddsB *= (chart['DefaultPrice'] >= 0) ? (1 + (chart['DefaultPrice'] / 100)) : (1 + (100 / Math.abs(chart['DefaultPrice'])));
            }
            var oddsC = chart['MoneyLine']/chart['ToBase'];
            winning = ((oddsA-1) / (oddsB-1)) * oddsC * amount;
        } else if (flatItems == 1) {
            winning = (oddsA-1) * amount;
        } else {
            winning = 0;
        }
        if (normalItems > 0) {
            if (winning != 0) {
                winning += (parseFloat(winning)+parseFloat(amount)) * (parseFloat(oddsM)-1);
            } else {
                winning = amount * (oddsM-1);
            }
        }
    }
    
    winning = creditAcct ? winning : (parseFloat(winning) + parseFloat(amount));
    winning = parseFloat(winning).toFixed(2); 

    var chart = getParlayChart(parlayInfo, maxPayoutMoneyLineItems);
    if(chart['MaxPayoutMoneyLine'] != 0 && chart['MaxPayoutToBase'] != 0){
        var winningMaxPayout = (parseFloat(amount) * parseFloat(chart['MaxPayoutMoneyLine']) )/ parseFloat(chart['MaxPayoutToBase']);
        winning =  parseFloat(winning) > parseFloat(winningMaxPayout) ? winningMaxPayout: winning;
    }
     
    winning = parseFloat(maxParlayPayout) < parseFloat(winning) && maxParlayPayout > 0 ? maxParlayPayout:winning;
    
    return parseFloat(winning);
} 

function getSelectionsForParlay(selectionsIDs){
    var selections = {};
    for(var index in selectionsIDs){
        selections[selectionsIDs[index]] = _SELECTIONS_ON_BETSLIP[selectionsIDs[index]];
    }
    return selections;
}

function searchParlayDetail(GamesPicked, parlayDetails){
    for(var i in parlayDetails)
	if(parlayDetails[i]['GamesPicked']==GamesPicked)
	    return parlayDetails[i];
    return null;
}

function getParlayChart(parlayInfo, gamesPicked){
    if(typeof(parlayInfo.ownParlay) == "undefined")
        return null;
    if(typeof(parlayInfo.ownParlay.DefaultPrice) == "undefined")
        return null;
    if(typeof(parlayInfo.parlayDetails) == "undefined")
        return null;
    
    var parlayDetail = searchParlayDetail(gamesPicked, parlayInfo["parlayDetails"]);
    var x=0, y=1, x2=0, y2=1;
    if(parlayDetail != null){
        var myregexp = /(.+)\s*to\s*(.+)/;
        var match = myregexp.exec(parlayDetail['Pays_X_to_Y']);
        if(match != null){
            x=parseFloat(match[1]);
            y=parseFloat(match[2]);
        }
        var match = myregexp.exec(parlayDetail['Max_Payout_X_to_Y']);
        if(match != null){
            x2=parseFloat(match[1]);
            y2=parseFloat(match[2]);
        }
    }
    var object = {
        "DefaultPrice":parlayInfo.ownParlay.DefaultPrice,
        "ToBase":y,
        "MoneyLine":x,
        "MaxPayoutMoneyLine":x2,
        "MaxPayoutToBase":y2
    };
    return object;
}

function combineSelectionsOnBetslip(){
    var ids=new Array();
    for(var selectionId in _SELECTIONS_ON_BETSLIP)
	ids.push(selectionId);
    
    var min=2;
    return combineArray(ids, min, _ROUND_ROBIN_TYPE);
}

function combineArray(arr, min, max){
    var combs=new Array();
    for(var i=0; i<arr.length; i++){
	var length=combs.length;
	for(var j=0; j<length; j++){
	    var comb=(combs[j]).slice();
	    comb.push(arr[i]);
	    combs.push(comb);
	}
	combs.push([arr[i]]);
    }
    
    var res=new Array();
    for(var i=0; i<combs.length; i++){
	var comb=combs[i];
	if(min<=comb.length && comb.length<=max)
	    res.push(comb);
    }
    return res;
}

function computeMaxRiskAmount(){
    switch(_BETSLIP_TYPE){
        case 'straight':
            return computeStraightRisk();
        case 'parlay':
            return _PARLAY_RISK;
        case 'rndrobin':
            return computeRoundRobinRisk();
        case 'teaser':
            return getTeaserRisk();
        case 'ifbet':
            return getIfBetMaxRisk();
        case 'reverse':
            return getReverseMaxRisk();   
    }
}

function computeStraightRisk(){
    var risk=0;
    for(var SelectionID in _SELECTIONS_ON_BETSLIP)
	risk+=parseFloat(_SELECTIONS_ON_BETSLIP[SelectionID]['riskAmount']);
    return risk;
}

function computeRoundRobinRisk(){
    var combinations=combineSelectionsOnBetslip();
    return _ROUND_ROBIN_RISK*combinations.length;
}

function getTeaserRisk(){
    var amount=_TEASER_AMOUNT;
    
    if(_TEASER_AMOUNT_TYPE=='risk')
	return amount;
    
    if(isNaN(parseFloat(amount)))
	return "";
    
    amount=parseFloat(amount);
    var PayCard=getCurrentPayCard();
    return PayCard!=null? amount*parseFloat(PayCard['ToBase'])/parseFloat(PayCard['MoneyLine']) : 0;
}

function getIfBetMaxRisk(){
    var selectionsArray=getSelectionsOnBetslipArraySortedOrder();
    return getIfBetMaxRiskAux(selectionsArray);
}

function getSelectionsOnBetslipArraySortedOrder(){    
    var selections=new Array();
    var idsInArray=new Object();

    do{
	var selectionIdToAdd=null;
	var minOrder=null;
	for(var selectionID in _SELECTIONS_ON_BETSLIP){
	    var selectionOnBetslip=_SELECTIONS_ON_BETSLIP[selectionID];
	    var order=parseInt(selectionOnBetslip['order']);
	    
	    if(typeof(idsInArray[selectionID])=='undefined')
		if(minOrder==null || minOrder>=order){
		    minOrder=order;
		    selectionIdToAdd=selectionID;
		}
	}
	if(selectionIdToAdd!=null){
	    selections.push(_SELECTIONS_ON_BETSLIP[selectionIdToAdd]);
	    idsInArray[selectionIdToAdd]=true;
	}
    }while(selectionIdToAdd!=null);
    
    return selections;
}

function getIfBetMaxRiskAux(selectionsArray){
    var balance=0;
    var maxRisk=0;
    for(var i=0; i<selectionsArray.length; i++){
	var selection=selectionsArray[i];
	var riskAmount=parseFloat(selection['riskAmount']);
	var winAmount=parseFloat(selection['winAmount']);
	
	if(balance<riskAmount){
	    maxRisk+=riskAmount-balance;
	    balance=riskAmount;
	}
	balance+=_CONTINUE_ON_PUSH_FLAG=='Y'? 0 : winAmount;
    }
    return maxRisk;
}

function getReverseMaxRisk(){
    var odds=getReverseOdds();
    
    if(odds['minOdds']==null || odds['minOdds']==0)
        return 0;
    
    return odds['minOdds']>0? _REVERSE_AMOUNT*100/odds['minOdds'] : -_REVERSE_AMOUNT*odds['minOdds']/100;
}

function computeAmountsSelections(maxRisk, maxToWin){
    if(_BETSLIP_TYPE=='straight' || _BETSLIP_TYPE=='ifbet')
        _GLOBAL_RISK_AMOUNT = computeMaxRiskAmount();
        
    if(_BETSLIP_TYPE=='parlay'){        
        if(checkLimitsHookup(_LIMITS['parlay'], maxRisk, maxToWin)){
            _SHOW_GLOBAL_MESSAGES=true;
            _ERROR=true;
        }        
        _GLOBAL_RISK_AMOUNT = computeMaxRiskAmount();
    }
    
    if(_BETSLIP_TYPE=='rndrobin'){
        if(checkLimitsHookup(_LIMITS['roundRobin'], maxRisk, maxToWin)){
            _SHOW_GLOBAL_MESSAGES=true;
            _ERROR=true;
        }
    }
    
    if(_BETSLIP_TYPE=='teaser'){        
        var teaserRisk=myRound(getTeaserRisk(), 2);
        var teaserWin=myRound(getTeaserWin(), 2);
        var currentInputTeaserRisk=myRound($("#betslip .teaserRiskAmount").val(), 2);
        var currentInputTeaserWin=myRound($("#betslip .teaserWinAmount").val(), 2);
       
        if(_TEASER_AMOUNT_TYPE=='win' || currentInputTeaserRisk!=teaserRisk)
            $("#betslip .teaserRiskAmount").val(teaserRisk);
        if(_TEASER_AMOUNT_TYPE=='risk' || currentInputTeaserWin!=teaserWin)
            $("#betslip .teaserWinAmount").val(teaserWin);
        
        var currentGlobalRisk=_GLOBAL_RISK_AMOUNT;
        if(currentGlobalRisk!=teaserRisk)
           _GLOBAL_RISK_AMOUNT = teaserRisk;
        
        if(_GLOBAL_WIN_AMOUNT!=teaserWin){
            _GLOBAL_WIN_AMOUNT = teaserWin;
        }
        
        var teaser=siteCache.customer.teasers[_TEASER_TYPE];

        if(typeof teaser != "undefined"){
            $("#betslip .teaserAmounts").show();   
            $("#currentTeaserType").html(teaser['TeaserName']);
            $("#currentTeaserType").removeClass("nonSelected");
        }else{
            $("#betslip .teaserAmounts").hide();
            $("#currentTeaserType").html("Please select a teaser");
            $("#currentTeaserType").addClass("nonSelected");
        }
        
        if(checkLimitsHookup(_LIMITS['teaser'], teaserRisk, teaserWin)){
            _SHOW_GLOBAL_MESSAGES=true;
            _ERROR=true;
        }
    }
        
    if(_BETSLIP_TYPE=='reverse'){
        $("#betslip .reverseAmount").val(_REVERSE_AMOUNT);        
        if(checkLimitsHookup(_LIMITS['reverse'], _REVERSE_AMOUNT, _REVERSE_AMOUNT)){
            _SHOW_GLOBAL_MESSAGES=true;
            _ERROR=true;
        }
        _GLOBAL_RISK_AMOUNT = computeMaxRiskAmount();
    }
}

function getErrorsSelectionsBetslip(){
    var selectionsInfo=new Object();
    var selectionsOnBetslip=getSelectionsOnBetslip();
    for(var selectionId in _SELECTIONS_ON_BETSLIP){
	var selectionOnBetslip=selectionsOnBetslip[selectionId];
	if(selectionOnBetslip['isOpenSelection']!='1')
	    selectionsInfo[selectionId] =_SELECTIONS_ON_BETSLIP[selectionId]['originalSelection'];
    }
    
    return getSelectionsError(selectionsInfo);
}

function getTotalAmounts(){    
    var risk=0;
    var win=0;
    var riskFP=0;
    var winFP=0;
    
    if(_BETSLIP_TYPE=='straight'){
	for(var selectionId in _SELECTIONS_ON_BETSLIP){
	    if(_SELECTIONS_ON_BETSLIP[selectionId]['fp']=='1'){
		riskFP+=parseFloat(_SELECTIONS_ON_BETSLIP[selectionId]['riskAmount']);
		winFP+=parseFloat(_SELECTIONS_ON_BETSLIP[selectionId]['winAmount']);
	    }
	    else{
		risk+=parseFloat(_SELECTIONS_ON_BETSLIP[selectionId]['riskAmount']);
		win+=parseFloat(_SELECTIONS_ON_BETSLIP[selectionId]['winAmount']);
	    }
	}
    }
    
    if(_BETSLIP_TYPE=='parlay'){
	risk=_GLOBAL_RISK_AMOUNT;
	win=computeParlayToWin();
    }
    
    if(_BETSLIP_TYPE=='rndrobin'){
	risk=computeRoundRobinRisk();
	win=computeRoundRobinToWin();
    }
    
    if(_BETSLIP_TYPE=='teaser'){
	risk=getTeaserRisk();
	win=getTeaserWin();
    }
    
    if(_BETSLIP_TYPE=='ifbet'){
	risk=getIfBetMaxRisk();
	win=getIfBetMaxRisk();
    }
    
    if(_BETSLIP_TYPE=='reverse'){
	risk=getReverseMaxRisk();
	win=getReverseMaxWin();
    }
    
    return {'risk': risk, 'win': win, 'riskFP': riskFP, 'winFP': winFP};
}




















/*  _____                 _
   | ____|_   _____ _ __ | |_ ___
   |  _| \ \ / / _ \ '_ \| __/ __|
   | |___ \ V /  __/ | | | |_\__ \
   |_____| \_/ \___|_| |_|\__|___/ */
                                                                                                
                                                                                                
                                                                                                
                                                                                                
                                                                                                
                                                                                                
                                                                                                
                                                                                                
                                                                                                
                                                                                                
                                                                                                
                                                                                                
                                                                                                
                                                                                                
                                                                                                
                                                                                                
                                                                                                
                                                                                                
                                                                                                
                                        
function setBetslipEvents(){
    $(".removeFromBetslip").unbind("click");
    $(".removeFromBetslip").click(removeFromBetslipClick);
    
    $("#betslip .selection .amount").unbind("keyup");
    $("#betslip .selection .amount").keyup(function(){
	var element=$(this);
	setTimeout(function(){        
	    var selection=element.parents('.selection');
	    var selectionId=selection.attr('selectionid');
	    var selectedAmountType=element.hasClass('riskAmount')? 'riskAmount':'winAmount';
	    var selectedAmount=element.val();
	    _SELECTIONS_ON_BETSLIP[selectionId]['selectedAmountType']=selectedAmountType;
	    _SELECTIONS_ON_BETSLIP[selectionId]['selectedAmount']=selectedAmount;
            updateBetSlip();
	}, 300);
    });
    
    $("#betslip .allAmountMenu .amount").unbind("focus");
    $("#betslip .allAmountMenu .amount").focus(function(){
	$("#betslip .allAmountMenu .amount").val("");
    });
    
    $("#betslip .allAmountMenu .amount").unbind("keyup");
    $("#betslip .allAmountMenu .amount").keyup(function(){
	var element=$(this);
	setTimeout(function(){
	    element.parent().siblings().find('.amount').val("");

	    var selectedAmountType="betAmount";
	    if(element.hasClass('riskAmount'))
		selectedAmountType="riskAmount";
	    if(element.hasClass('winAmount'))
		selectedAmountType="winAmount";

	    var selectedAmount=element.val().trim();
	    if(selectedAmount!=""){
		setAllAmountsBetslip(selectedAmountType, selectedAmount);
	    }
	    updateBetSlip();
	}, 300);
    });
    
    $("#betslip .selection .buyPoints ").unbind("change");
    $("#betslip .selection .buyPoints ").change(function(){
	var selection=$(this).parents('.selection');
	var selectionId=selection.attr('selectionid');
	_SELECTIONS_ON_BETSLIP[selectionId]['threshold']=$(this).val();
	acceptChangesSelection(selectionId);
	updateBetSlip();
    });
    
    $("#betslip .globalFreePlayWrap input").unbind("click");
    $("#betslip .globalFreePlayWrap input").click(function(){
	_FREE_PLAY_CHECKED = $(this).is(':checked') ? '1':'0';
	updateBetSlip();
    });
    
    $("#betslip .fpSelectorWrap input").unbind("click");
    $("#betslip .fpSelectorWrap input").click(function(){
	var selection=$(this).parents('.selection');
	var selectionId=selection.attr('selectionid');	
	_SELECTIONS_ON_BETSLIP[selectionId]['fp']=$(this).is(':checked')? '1':'0';
	updateBetSlip();
    });
    
    $("#placeBet").unbind("click");
    $("#placeBet").click(function(){
         $("#placeBet").prop( "disabled", true );
        placebet();
        updateBetSlip();
    });
    
    $("#placeBetFull").unbind("click");
    $("#placeBetFull").click(function(){
	placebet();
	updateBetSlip();
    });
    
    $("#acceptChanges").unbind("click");
    $("#acceptChanges").click(function(){
	acceptChanges();
	updateBetSlip();
    });
    
    $("#betslip .selection .acceptChangesSelection").unbind("click");
    $("#betslip .selection .acceptChangesSelection").click(function(){
	var selection=$(this).parents('.selection');
	acceptChangesSelection(selection.attr('selectionId'));
	updateBetSlip("sportbook");
    });
    
    
    $("#betslip .selection .pitcherSelector").unbind("change");
    $("#betslip .selection .pitcherSelector").change(function(){
	var pitcherSelector=$(this);
	setTimeout(function(){
	    var selection=pitcherSelector.parents('.selection');
	    var selectionId=selection.attr('selectionid');	    
	    _SELECTIONS_ON_BETSLIP[selectionId]['pitcher']=pitcherSelector.val();
	    acceptChangesSelection(selectionId);
	    updateBetSlip();
	}, 300);
    });
    
    $("#betslip .globalAmount .riskAmount").unbind("keyup");
    $("#betslip .globalAmount .riskAmount").keyup(function(){
	var input=$(this);
	setTimeout(function(){
            _GLOBAL_RISK_AMOUNT = input.val();
	    updateBetSlip();
	}, 300);
    });
    
    $("#betslip #roundRobinType").unbind("change");
    $("#betslip #roundRobinType").change(function(){ 
	_ROUND_ROBIN_TYPE = $(this).val();
	updateBetSlip();
    });
    
    

    $("#betslip .reverseAmount").unbind("keyup");
    $("#betslip .reverseAmount").keyup(function(){
	var input=$(this);
	setTimeout(function(){
	    _REVERSE_AMOUNT = input.val();
	    updateBetSlip("sportbook");
	}, 300);
    });
    
    $("#betslip .teaserRiskAmount").unbind("keyup");
    $("#betslip .teaserRiskAmount").keyup(function(){
	var input=$(this);
	setTimeout(function(){
	    _TEASER_AMOUNT = input.val();
            _TEASER_AMOUNT_TYPE = "risk";
	    updateBetSlip();
	}, 300);
    });    
    
    $("#betslip .teaserWinAmount").unbind("keyup");
    $("#betslip .teaserWinAmount").keyup(function(){
	var input=$(this);
	setTimeout(function(){
	    _TEASER_AMOUNT = input.val();
            _TEASER_AMOUNT_TYPE = "win";
	    updateBetSlip();
	}, 300);
    });   
    
    $(".addOpenSelectionToBetslip").unbind("click");
    $(".addOpenSelectionToBetslip").click(addOpenSelectionToBetslipClick);
    
    $("#betslip .ContinueOnPushFlag").unbind("change");
    $("#betslip .ContinueOnPushFlag").change(function(){
	_CONTINUE_ON_PUSH_FLAG = $(this).val();
	updateBetSlip();
    });
}

function changeGenTypeBet(object){
    $("#txtRisk").hide();
    $("#txtWin").hide();
    $("#txtBet").hide();
    
    $(object).parents(".table").find("button").removeClass("btn-success");
    $(object).addClass("btn-success");
    
    $($(object).attr("target")).show();
}

function txtRiskChange(objectTxt){
    switch(_BETSLIP_TYPE){
        case 'parlay':
            _PARLAY_RISK = $(objectTxt).val();
        break;
        case 'rndrobin':
            _ROUND_ROBIN_RISK = $(objectTxt).val();
        break;
    }
}

function DropDown(el) {
    this.cbmBetType = el;
    this.initEvents();
}

DropDown.prototype = {
    initEvents : function(){
        var obj = this;
        obj.cbmBetType.on('click', function(event){
            $(this).toggleClass('active');
            event.stopPropagation();
        });
    }
}
















/*  ____       _       _
   |  _ \ ___ (_)_ __ | |_ ___
   | |_) / _ \| | '_ \| __/ __|
   |  __/ (_) | | | | | |_\__ \
   |_|   \___/|_|_| |_|\__|___/*/
                 





















function computePoints(selection){
    if(selection['isMainBet'] == '1' && selection['betType'] != 'C' && selection['betType'] != 'M' && selection['PeriodNumber'] == '0'){
        if(selection['SportType'].toLowerCase() == 'basketball' || selection['SportType'].toLowerCase() == 'football'){
            //SELL POINTS
            if(typeof _BUY_SELL_POINTS['sell'] != 'undefined' && typeof _BUY_SELL_POINTS['sell']['BasketballSpreadSell'] != 'undefined'){
                if(selection['SportType'].toLowerCase() == 'football' && selection['SubSportType'].toLowerCase() == 'college'){
                    if(selection['betType'] == 'L')
                        computeMoreOddsSelection(selection, (selection['TotalPointsOU'] == "O" ? 0.5 : -0.5), -parseInt(_BUY_SELL_POINTS['sell']['CollegeFootballTotalSell']), parseInt(_BUY_SELL_POINTS['sell']['CollegeFootballTotalSellMax']), -parseInt(_BUY_SELL_POINTS['sell']['CollegeFootballTotalSell']), -parseInt(_BUY_SELL_POINTS['sell']['CollegeFootballTotalSell']), -parseInt(_BUY_SELL_POINTS['sell']['CollegeFootballTotalSell']), -parseInt(_BUY_SELL_POINTS['sell']['CollegeFootballTotalSell']));
                    if(selection['betType'] == 'S')
                        computeMoreOddsSelection(selection, -0.5, -parseInt(_BUY_SELL_POINTS['sell']['CollegeFootballSpreadSell']), parseInt(_BUY_SELL_POINTS['sell']['CollegeFootballSpreadSellMax']), -parseInt(_BUY_SELL_POINTS['sell']['CollegeFootballSpreadSellOn3']), -parseInt(_BUY_SELL_POINTS['sell']['CollegeFootballSpreadSellOn7']), -parseInt(_BUY_SELL_POINTS['sell']['CollegeFootballSpreadSellOff3']), -parseInt(_BUY_SELL_POINTS['sell']['CollegeFootballSpreadSellOff7']));
                }else if(selection['SportType'].toLowerCase() == 'football'){
                    if(selection['betType'] == 'L')
                        computeMoreOddsSelection(selection, (selection['TotalPointsOU'] == "O" ? 0.5 : -0.5), -parseInt(_BUY_SELL_POINTS['sell']['FootballTotalSell']), parseInt(_BUY_SELL_POINTS['sell']['FootballTotalSellMax']), -parseInt(_BUY_SELL_POINTS['sell']['FootballTotalSell']), -parseInt(_BUY_SELL_POINTS['sell']['FootballTotalSell']), -parseInt(_BUY_SELL_POINTS['sell']['FootballTotalSell']), -parseInt(_BUY_SELL_POINTS['sell']['FootballTotalSell']));
                    if(selection['betType'] == 'S')
                        computeMoreOddsSelection(selection, -0.5, -parseInt(_BUY_SELL_POINTS['sell']['FootballSpreadSell']), parseInt(_BUY_SELL_POINTS['sell']['FootballSpreadSellMax']), -parseInt(_BUY_SELL_POINTS['sell']['FootballSpreadSellOn3']), -parseInt(_BUY_SELL_POINTS['sell']['FootballSpreadSellOn7']), -parseInt(_BUY_SELL_POINTS['sell']['FootballSpreadSellOff3']), -parseInt(_BUY_SELL_POINTS['sell']['FootballSpreadSellOff7']));
                }else if(selection['SportType'].toLowerCase() == 'basketball'){
                    if(selection['betType'] == 'L')
                        computeMoreOddsSelection(selection, (selection['TotalPointsOU'] == "O" ? 0.5 : -0.5), -parseInt(_BUY_SELL_POINTS['sell']['BasketballTotalSell']), parseInt(_BUY_SELL_POINTS['sell']['BasketballTotalSellMax']), -parseInt(_BUY_SELL_POINTS['sell']['BasketballTotalSell']), -parseInt(_BUY_SELL_POINTS['sell']['BasketballTotalSell']), -parseInt(_BUY_SELL_POINTS['sell']['BasketballTotalSell']), -parseInt(_BUY_SELL_POINTS['sell']['BasketballTotalSell']));
                    if(selection['betType'] == 'S')
                        computeMoreOddsSelection(selection, -0.5, -parseInt(_BUY_SELL_POINTS['sell']['BasketballSpreadSell']), parseInt(_BUY_SELL_POINTS['sell']['BasketballSpreadSellMax']), -parseInt(_BUY_SELL_POINTS['sell']['BasketballSpreadSell']), -parseInt(_BUY_SELL_POINTS['sell']['BasketballSpreadSell']), -parseInt(_BUY_SELL_POINTS['sell']['BasketballSpreadSell']), -parseInt(_BUY_SELL_POINTS['sell']['BasketballSpreadSell']));
                }
            }
            //BUY POINTS
            if(typeof _BUY_SELL_POINTS['buy'] != 'undefined' && typeof _BUY_SELL_POINTS['buy']['BasketballSpreadBuy'] != 'undefined'){
                if(selection['SportType'].toLowerCase() == 'football' && selection['SubSportType'].toLowerCase() == 'college'){
                    if(selection['betType'] == 'L')
                        computeMoreOddsSelection(selection, (selection['TotalPointsOU'] == "O" ? -0.5 : 0.5), parseInt(_BUY_SELL_POINTS['buy']['CollegeFootballTotalBuy']), parseInt(_BUY_SELL_POINTS['buy']['CollegeFootballTotalBuyMax']), parseInt(_BUY_SELL_POINTS['buy']['CollegeFootballTotalBuy']), parseInt(_BUY_SELL_POINTS['buy']['CollegeFootballTotalBuy']), parseInt(_BUY_SELL_POINTS['buy']['CollegeFootballTotalBuy']), parseInt(_BUY_SELL_POINTS['buy']['CollegeFootballTotalBuy']));
                    if(selection['betType'] == 'S')
                        computeMoreOddsSelection(selection, 0.5, parseInt(_BUY_SELL_POINTS['buy']['CollegeFootballSpreadBuy']), parseInt(_BUY_SELL_POINTS['buy']['CollegeFootballSpreadBuyMax']), parseInt(_BUY_SELL_POINTS['buy']['CollegeFootballSpreadBuyOn3']), parseInt(_BUY_SELL_POINTS['buy']['CollegeFootballSpreadBuyOn7']), parseInt(_BUY_SELL_POINTS['buy']['CollegeFootballSpreadBuyOff3']), parseInt(_BUY_SELL_POINTS['buy']['CollegeFootballSpreadBuyOff7']));
                }else if(selection['SportType'].toLowerCase() == 'football'){
                    if(selection['betType'] == 'L')
                        computeMoreOddsSelection(selection, (selection['TotalPointsOU'] == "O" ? -0.5 : 0.5), parseInt(_BUY_SELL_POINTS['buy']['FootballTotalBuy']), parseInt(_BUY_SELL_POINTS['buy']['FootballTotalBuyMax']), parseInt(_BUY_SELL_POINTS['buy']['FootballTotalBuy']), parseInt(_BUY_SELL_POINTS['buy']['FootballTotalBuy']), parseInt(_BUY_SELL_POINTS['buy']['FootballTotalBuy']), parseInt(_BUY_SELL_POINTS['buy']['FootballTotalBuy']));
                    if(selection['betType'] == 'S')
                        computeMoreOddsSelection(selection, 0.5, parseInt(_BUY_SELL_POINTS['buy']['FootballSpreadBuy']), parseInt(_BUY_SELL_POINTS['buy']['FootballSpreadBuyMax']), parseInt(_BUY_SELL_POINTS['buy']['FootballSpreadBuyOn3']), parseInt(_BUY_SELL_POINTS['buy']['FootballSpreadBuyOn7']), parseInt(_BUY_SELL_POINTS['buy']['FootballSpreadBuyOff3']), parseInt(_BUY_SELL_POINTS['buy']['FootballSpreadBuyOff7']));
                }else if(selection['SportType'].toLowerCase() == 'basketball'){
                    if(selection['betType'] == 'L')
                        computeMoreOddsSelection(selection, (selection['TotalPointsOU'] == "O" ? -0.5 : 0.5), parseInt(_BUY_SELL_POINTS['buy']['BasketballTotalBuy']), parseInt(_BUY_SELL_POINTS['buy']['BasketballTotalBuyMax']), parseInt(_BUY_SELL_POINTS['buy']['BasketballTotalBuy']), parseInt(_BUY_SELL_POINTS['buy']['BasketballTotalBuy']), parseInt(_BUY_SELL_POINTS['buy']['BasketballTotalBuy']), parseInt(_BUY_SELL_POINTS['buy']['BasketballTotalBuy']));
                    if(selection['betType'] == 'S')
                        computeMoreOddsSelection(selection, 0.5, parseInt(_BUY_SELL_POINTS['buy']['BasketballSpreadBuy']), parseInt(_BUY_SELL_POINTS['buy']['BasketballSpreadBuyMax']), parseInt(_BUY_SELL_POINTS['buy']['BasketballSpreadBuy']), parseInt(_BUY_SELL_POINTS['buy']['BasketballSpreadBuy']), parseInt(_BUY_SELL_POINTS['buy']['BasketballSpreadBuy']), parseInt(_BUY_SELL_POINTS['buy']['BasketballSpreadBuy']));
                }
            }
        }
    }
}       

function computeMoreOddsSelection(selection, deltaThreshold, deltaRisk, halfPointsAmount, on3, on7, off3, off7){		
    if(halfPointsAmount !=0 && deltaThreshold!=0 && deltaRisk!=0){
        var threshold = parseFloat(selection["threshold"]);
        var oddsUS = parseInt(selection["US"]);
        var addRisk = 0;
        var morePointsCount = 0;
        var penalty=false;
        while(morePointsCount<=halfPointsAmount){
            penalty=false;
            if(Math.abs(threshold)==3){
                penalty=true;
                addRisk=off3;
            }				

            if(Math.abs(threshold)==7){
                penalty=true;
                addRisk=off7;
            }

            threshold+=deltaThreshold;

            if(Math.abs(threshold)==3){
                penalty=true;
                addRisk=on3;
            }

            if(Math.abs(threshold)==7){
                penalty=true;
                addRisk=on7;
            }

            if(!penalty)
                addRisk=deltaRisk;

            if(addRisk==0)
                break;

            oddsUS = riskIncrement(oddsUS, addRisk);
            
            if(typeof selection.moreOdds[threshold] == "undefined")
                selection.moreOdds[threshold] = {};
            
            selection.moreOdds[threshold]['US'] = oddsUS;
            selection.moreOdds[threshold]['threshold'] = threshold;
            selection.moreOdds[threshold]['Dec'] = convertOddsToDecimal(oddsUS);
            morePointsCount++;
        }

        if(morePointsCount>0){
            if(typeof selection.moreOdds[threshold] == "undefined")
                selection.moreOdds[threshold] = {};
            selection.moreOdds[threshold]['US'] = selection["US"];
            selection.moreOdds[threshold]['threshold'] = selection["threshold"];
            selection.moreOdds[threshold]['Dec'] = selection["Dec"];
        }
    }
}

function riskIncrement(oddsUS, increment){
    return oddsUS > 0 ? computeOdds(100+increment, oddsUS) : computeOdds(-oddsUS+increment, 100);
}

function computeOdds(risk, win){
    var odds = risk < win ? win+100-risk : -(risk+100-win);
    if(odds==-100)
        odds=100;
    return odds;
}

function acceptChanges(){
    for(var selectionId in _SELECTIONS_ON_BETSLIP)
	acceptChangesSelection(selectionId);
}

function acceptChangesSelection(selectionId){
    var finalSelection=getFinalOddsSelection(_SELECTIONS_ON_BETSLIP[selectionId]);
    _SELECTIONS_ON_BETSLIP[selectionId]['US']=finalSelection['US'];
    _SELECTIONS_ON_BETSLIP[selectionId]['Dec']=finalSelection['Dec'];
    _SELECTIONS_ON_BETSLIP[selectionId]['Num']=finalSelection['Num'];
    _SELECTIONS_ON_BETSLIP[selectionId]['Den']=finalSelection['Den'];
    _SELECTIONS_ON_BETSLIP[selectionId]['threshold']=finalSelection['threshold'];   
}

function computePitchers(selection){
    if(selection["SportType"] == "Baseball"){
        if(typeof selection["listedpitcherhome"] !== "undefined" && typeof selection["listedpitcheraway"] !== "undefined" 
                && selection["listedpitcherhome"] !== "" && selection["listedpitcheraway"] !== ""){            
            if(selection['PeriodNumber'] == '0'){
                if(selection['betType'] == 'M'){
                    selection['pitcherOptions']['at'] = 'at';
                    selection['pitcherOptions']['lv'] = 'lv';
                    selection['pitcherOptions']['lh'] = 'lh';
                    selection['pitcherOptions']['lp'] = 'lp';
                }else{
                    selection['pitcherOptions']['lp'] = 'lp';
                }
            }else if(selection['PeriodNumber'] == '0' || selection['PeriodNumber'] == '1'){ //1st Half
                selection['pitcherOptions']['lp'] = 'lp';
            }else{
                selection['pitcherOptions']['at'] = 'at';
            }
        }else{
            selection['pitcherOptions']['at'] = 'at';
        }
        //baseball pitcher default selection
        if(typeof(selection['pitcherOptions'])!='undefined'){
            var customer=siteCache['customer'];
            var defaultOption="";
            if(customer['BaseballAction'].trim()=='Listed')
                defaultOption='lp';
            if(customer['BaseballAction'].trim()=='Action')
                defaultOption='at';

            var initialOption=null;
            for(var i in selection['pitcherOptions']){
                var option=selection['pitcherOptions'][i];

                if(initialOption==null)
                    initialOption=option;

                if(defaultOption==option){
                    initialOption=option;
                    break;
                }
            }
            selection['pitcher']=initialOption;
        }
    }    
}

function changeGlobalFreePlay(){
    if ($("#globalFreePlay").is(":checked")) {
        $("#betslip .fpSelectorWrap input[name='selectionFreePlay']").attr('checked', true);
    }
    else{
        $("#betslip .fpSelectorWrap input[name='selectionFreePlay']").attr('checked', false);
    }
}

function countObject(obj){
    var count=0;
    for(var i in obj)
	count++;
    return count;
}



















/*  ____  _                _          _
   |  _ \| | __ _  ___ ___| |__   ___| |_
   | |_) | |/ _` |/ __/ _ \ '_ \ / _ \ __|
   |  __/| | (_| | (_|  __/ |_) |  __/ |_
   |_|   |_|\__,_|\___\___|_.__/ \___|\__|*/



















function placebet(){  
    if(_BETSLIP_IS_ENABLED){
        _TRIGGERED_BY = "placeBet";
        getDelay(function(delay){            
            animateProgressBarBetslip(delay); 
            if(_ERROR)
                return;
            updateBetSlip();
            
            var blnShowMessages = false;
            $('#betslip .message').each(function() { 
                if ($(this).attr("style") == "display: block;") {
                    blnShowMessages = true;
                }
            });
            if (blnShowMessages) {
                $("#betslip .globalMessages").show();
            }
            else{
                $("#betslip .globalMessages").hide();
            }
            
            var blnShowGlobalMessages = false;
            $(".globalMessages .message").each(function() { 
                if ($(this).attr("style") == "display: block;") {
                    blnShowGlobalMessages = true;
                }
            });
            
           
            
            if(!blnShowGlobalMessages && !blnShowMessages){
                $("#placeBet").button('loading');
                
                var filteredSelections = {};
                //Filter selections on betslip
                for (var index in _SELECTIONS_ON_BETSLIP){                                     
                    if(typeof filteredSelections[index] === "undefined")
                        filteredSelections[index] = {};
                    
                    filteredSelections[index]["Dec"]                = _SELECTIONS_ON_BETSLIP[index]["Dec"];
                    filteredSelections[index]["Den"]                = _SELECTIONS_ON_BETSLIP[index]["Den"];
                    filteredSelections[index]["Num"]                = _SELECTIONS_ON_BETSLIP[index]["Num"];
                    filteredSelections[index]["US"]                 = _SELECTIONS_ON_BETSLIP[index]["US"];
                    filteredSelections[index]["riskAmount"]         = _SELECTIONS_ON_BETSLIP[index]["riskAmount"];
                    filteredSelections[index]["selectedAmount"]     = _SELECTIONS_ON_BETSLIP[index]["selectedAmount"];
                    filteredSelections[index]["selectedAmountType"] = _SELECTIONS_ON_BETSLIP[index]["selectedAmountType"];
                    filteredSelections[index]["selectionId"]        = _SELECTIONS_ON_BETSLIP[index]["selectionId"];
                    filteredSelections[index]["threshold"]          = _SELECTIONS_ON_BETSLIP[index]["threshold"];
                    filteredSelections[index]["thresholdTeaser"]    = _SELECTIONS_ON_BETSLIP[index]["thresholdTeaser"];
                    filteredSelections[index]["winAmount"]          = _SELECTIONS_ON_BETSLIP[index]["winAmount"];
                    filteredSelections[index]["fp"]                 = _SELECTIONS_ON_BETSLIP[index]["fp"];
                    filteredSelections[index]["pitcher"]            = _SELECTIONS_ON_BETSLIP[index]["pitcher"];
                    filteredSelections[index]["isOpenSelection"]    = _SELECTIONS_ON_BETSLIP[index]["isOpenSelection"];
                    filteredSelections[index]["order"]              = _SELECTIONS_ON_BETSLIP[index]["order"];
                    filteredSelections[index]["GameNum"]            = _SELECTIONS_ON_BETSLIP[index]["GameNum"];
                    filteredSelections[index]["isMainBet"]          = _SELECTIONS_ON_BETSLIP[index]["isMainBet"];
                    filteredSelections[index]["isFuture"]           = _SELECTIONS_ON_BETSLIP[index]["isFuture"];
                    filteredSelections[index]["PeriodNumber"]       = _SELECTIONS_ON_BETSLIP[index]["PeriodNumber"];
                    filteredSelections[index]["betType"]            = _SELECTIONS_ON_BETSLIP[index]["betType"];
                    filteredSelections[index]["ChosenTeamID"]       = _SELECTIONS_ON_BETSLIP[index]["ChosenTeamID"];
                    filteredSelections[index]["TotalPointsOU"]      = _SELECTIONS_ON_BETSLIP[index]["TotalPointsOU"];
                    filteredSelections[index]["ContestNum"]         = _SELECTIONS_ON_BETSLIP[index]["ContestNum"];
                    filteredSelections[index]["ContestantNum"]      = _SELECTIONS_ON_BETSLIP[index]["ContestantNum"];
                }
                
                //Fin aplica FreeHalfs
                
                $.ajax({
                url: "/Sportbook/placebet",
                dataType: "json",
                cache: false,
                method: "POST",
                data: { 
                    selectionsOnBetslip:JSON.stringify(filteredSelections), 
                    betslitpType       : _BETSLIP_TYPE,
                    globalRiskAmount   : _GLOBAL_RISK_AMOUNT,
                    globalToWinAmount  : _GLOBAL_WIN_AMOUNT,
                    teaserType         : _TEASER_TYPE,
                    teaserAmount       : _TEASER_AMOUNT,
                    reverseAmount      : _REVERSE_AMOUNT,
                    isFreePlay         : _FREE_PLAY_CHECKED == "1" ? "Y" : "N",
                    roundRobinType     : _ROUND_ROBIN_TYPE,
                    ContinueOnPushFlag : _CONTINUE_ON_PUSH_FLAG,
                    LineTypeFormat     : siteCache.customer.PriceType,
                    fullcustomerAgent: $("#sp_CustomerID").val()
                }
                })
                .done(function(data){
                        $("input[name='win']").val("");
                        $("input[name='risk']").val("");
                        $("#betslip #riskAmount").val("");
                        $("#betslip .maxToWin").html("");
                        $("#betslip .maxRisk").html("");
                        
                           $("#placeBet").prop( "disabled", false );
                        $("#betslip .serverMessages .messages .message").hide().remove();
                                
                  
                  
                  
                    var arr = [];
                    var ticketsToPrint=[]; 
                    $.each(data, function (key, val) {
                        if(val['status']==='1'){
                            _SELECTIONS_ON_BETSLIP = {};
                            _GLOBAL_RISK_AMOUNT = "";
                            _TEASER_TYPE = "";
                            _TEASER_AMOUNT = "";
                            _REVERSE_AMOUNT = "";
                            _FREE_PLAY_CHECKED = "0";
                            _CONTINUE_ON_PUSH_FLAG = "N";
                            _AMOUNT_SELECTIONS_ON_BETSLIP = 0;
                            _AMOUNT_SELECTIONS_ON_BETSLIP_NO_OPEN = 0;
                            _LIMITS = {};
                            
                            arr.push(val["ticket"]);
                            ticketsToPrint.push(val["ticket"]["ticketNumber"]);
                            $("#txtBet").val("");
//                            showTicketModal(val['ticket']);
                        }else if(val['status']==='0'){
                            $("#TransactionMessage").text("Seleccion Fallo("+val["ChosenTeamID"]+")")
                            $("#betslip .transactionFailed").show();
                            setTimeout(function(){
                                $("#betslip .transactionFailed").hide();
                            }, 5000);
                        }else{
                            var hasServerMessages=false;
        
                            for(var i in val['messages']){
                            hasServerMessages=true;
                            var message=val['messages'][i];
                            $("#betslip .serverMessages .messages").append( "<div class='margin-top message serverMessage'>"+
                                                        "<span class='glyphicon glyphicon-ban-circle' aria-hidden='true'></span> "+message+
                                                    "</div>");
                            }
                            if(hasServerMessages){
                                $("#betslip .serverMessages").show();
                                setTimeout(function(){
                                    $("#betslip .serverMessages").hide();
                                }, 5000);
                            } else{
                            $("#betslip .serverMessages").hide();        
                            }
                        }
                    });
                    
                        if (arr.length > 0) {
                            var ticketType;
                            if ($("#sp_CustomerID").val().toUpperCase() === $("#sp_AuthCustomerID").val().toUpperCase())
                                ticketType = 1;
                            else
                                ticketType = 2;
                            printTicket(ticketsToPrint, ticketType);
                              updateBetSlip();
                        }
                })
                .error(function(){
                    
                })
                .always(function(){
                    setTimeout(function(){
                       $("#placeBet").button('reset');
                    }, 500);
                });
            }
        });
    }
}

function filterSelections(){
    var filteredSelections = {};
    //Filter selections on betslip
    for (var index in _SELECTIONS_ON_BETSLIP){                                     
        if(typeof filteredSelections[index] === "undefined")
            filteredSelections[index] = {};

        filteredSelections[index]["Dec"]                = _SELECTIONS_ON_BETSLIP[index]["Dec"];
        filteredSelections[index]["Den"]                = _SELECTIONS_ON_BETSLIP[index]["Den"];
        filteredSelections[index]["Num"]                = _SELECTIONS_ON_BETSLIP[index]["Num"];
        filteredSelections[index]["US"]                 = _SELECTIONS_ON_BETSLIP[index]["US"];
        filteredSelections[index]["riskAmount"]         = _SELECTIONS_ON_BETSLIP[index]["riskAmount"];
        filteredSelections[index]["selectedAmount"]     = _SELECTIONS_ON_BETSLIP[index]["selectedAmount"];
        filteredSelections[index]["selectedAmountType"] = _SELECTIONS_ON_BETSLIP[index]["selectedAmountType"];
        filteredSelections[index]["selectionId"]        = _SELECTIONS_ON_BETSLIP[index]["selectionId"];
        filteredSelections[index]["threshold"]          = _SELECTIONS_ON_BETSLIP[index]["threshold"];
        filteredSelections[index]["thresholdTeaser"]    = _SELECTIONS_ON_BETSLIP[index]["thresholdTeaser"];
        filteredSelections[index]["winAmount"]          = _SELECTIONS_ON_BETSLIP[index]["winAmount"];
        filteredSelections[index]["fp"]                 = _SELECTIONS_ON_BETSLIP[index]["fp"];
        filteredSelections[index]["pitcher"]            = _SELECTIONS_ON_BETSLIP[index]["pitcher"];
        filteredSelections[index]["isOpenSelection"]    = _SELECTIONS_ON_BETSLIP[index]["isOpenSelection"];
        filteredSelections[index]["order"]              = _SELECTIONS_ON_BETSLIP[index]["order"];
        filteredSelections[index]["GameNum"]            = _SELECTIONS_ON_BETSLIP[index]["GameNum"];
        filteredSelections[index]["isMainBet"]          = _SELECTIONS_ON_BETSLIP[index]["isMainBet"];
        filteredSelections[index]["isFuture"]           = _SELECTIONS_ON_BETSLIP[index]["isFuture"];
        filteredSelections[index]["PeriodNumber"]       = _SELECTIONS_ON_BETSLIP[index]["PeriodNumber"];
        filteredSelections[index]["betType"]            = _SELECTIONS_ON_BETSLIP[index]["betType"];
        filteredSelections[index]["ChosenTeamID"]       = _SELECTIONS_ON_BETSLIP[index]["ChosenTeamID"];
        filteredSelections[index]["TotalPointsOU"]      = _SELECTIONS_ON_BETSLIP[index]["TotalPointsOU"];
        filteredSelections[index]["ContestNum"]         = _SELECTIONS_ON_BETSLIP[index]["ContestNum"];
        filteredSelections[index]["ContestantNum"]      = _SELECTIONS_ON_BETSLIP[index]["ContestantNum"];
        filteredSelections[index]["scheduleText"]       = _SELECTIONS_ON_BETSLIP[index]["scheduletext"];
        filteredSelections[index]["sportType"]          = _SELECTIONS_ON_BETSLIP[index]["SportType"];
        filteredSelections[index]["subSportType"]       = _SELECTIONS_ON_BETSLIP[index]["SubSportType"];
        
    }
    return filteredSelections;
}

function getDelay(callback){
    $.ajax({
	url: "/Sportbook/getdelay",
	dataType: "json",
	cache: false
    })
    .done(function(data){
	callback(data["delay"]);
    })
    .error(function(){

    })
    .always(function(){
    });
}

function animateProgressBarBetslipAux(start, end){
    var now=new Date().getTime();
    if(now<end){
	var width=Math.round(100*(now-start)/(end-start));
	$("#betslip #placeBetWrap #placebetBar .progress-bar").width(width+"%");
	$("#betslip #placeBetWrapFull #placebetBarFull .progress-bar").width(width+"%");
	setTimeout(function(){
	    animateProgressBarBetslipAux(start, end);
	}, 100);
    }
    else{
	$("#betslip #placeBetWrap #placebetBar .progress-bar").width("100%");
	$("#betslip #placeBetWrapFull #placebetBarFull .progress-bar").width("100%");
    }
}

function animateProgressBarBetslip(delay){
    var start=new Date().getTime();
    var end=start+delay*1000;
    animateProgressBarBetslipAux(start, end);    
}

function ApplyHalfPointAdjustment(gameNum, riskAmt, toWinAmt, sportType, periodNumber, wagerType, finalLine, controlCode) {
    //var halfPointMaxBet = Session("halfPointMaxBet");
    var halfPointMaxBet = 100;
    //var halfPointBasketballFlag = Session("halfPointBasketballFlag");
    var halfPointBasketballFlag = "Y";
    //var halfPointBasketballDow = Session("halfPointBasketballDow");
    var halfPointBasketballDow = 0;
    //var halfPointFootballFlag = Session("halfPointFootballFlag");
    var halfPointFootballFlag = "Y";
	//var halfPointFootballDow = Session("halfPointFootballDow");
    var halfPointFootballDow = 0;

    finalLine = parseFloat(finalLine);
    
	var volumeAmt = 0;
	var currDate = new Date();
	var dow = currDate.getDay();
	if(dow < 1) {
		dow = 7;
	}

	if(riskAmt > toWinAmt) {
		volumeAmt = toWinAmt;
	} else {
		volumeAmt = riskAmt;
	}

	if(halfPointBasketballFlag == "Y" &&
		sportType == "Basketball" &&
		volumeAmt <= halfPointMaxBet &&
		periodNumber == 0) {
		if(halfPointBasketballDow == 0 ||
		   halfPointBasketballDow == dow) {
			if(wagerType == "S") {
				if(CheckForPrevBetOnGame(gameNum, wagerType) == true) {
					return finalLine;
				}
				finalLine += 0.5;
				return finalLine;
			}
			if(wagerType == "L") {
				if(controlCode == "1") {
					if(CheckForPrevBetOnGame(gameNum, wagerType) == true) {
						return finalLine;
					}
					finalLine -= 0.5;
					return finalLine;
				} else {
					if(CheckForPrevBetOnGame(gameNum, wagerType) == true) {
						return finalLine;
					}
					finalLine += 0.5;
					return finalLine;
				}
			}
		}
	}
		
	if(halfPointFootballFlag == "Y" &&
		sportType == "Football" &&
		volumeAmt <= halfPointMaxBet &&
		periodNumber == 0) {
		if(halfPointFootballDow == 0 ||
		   halfPointFootballDow == dow) {
			if(wagerType == "S") {
				if(finalLine != -3.5 &&
				   finalLine != -3 &&
				   finalLine != 2.5 &&
				   finalLine != 3) {
					if(CheckForPrevBetOnGame(gameNum, wagerType) == true) {
						return finalLine;
					}
					finalLine += 0.5;
					return finalLine;
				}
			}
			if(wagerType == "L") {
				if(controlCode.substr(1, 1) == "1") {
					if(CheckForPrevBetOnGame(gameNum, wagerType) == true) {
						return finalLine;
					}
					finalLine -= 0.5;
					return finalLine;
				} else {
					if(CheckForPrevBetOnGame(gameNum, wagerType) == true) {
						return finalLine;
					}
					finalLine += 0.5;
					return finalLine;
				}
			}
		}
	}
	return finalLine;
}

function CheckForPrevBetOnGame(gameNum, wagerType) {
    var betFound = false;
    $.ajax({
        url: "/Sportbook/CheckForPrevBetOnGame",
        dataType: "json",
        cache: false,
        asyn: false,
        data: {"gameNum": gameNum, "wagerType": wagerType}
    })
    .done(function(data){
        if(0 < parseFloat(data["BetCount"]) + 0) {
			betFound = true;
		}
    })
    .error(function(){
    })
    .always(function(){
    });
    return betFound;
}

function showTicketModal(ticket){
    getInfoCustomer();
    
    if(getCurrentSize() == 'xs'){
        _BETSLIP_TYPE = 'straight';
    }
    $("#betslipModal .modal-title").html("Ticket Number: "+ticket['ticketNumber']);
    
    var selectionsHTML = "";
    
    for(var sel in ticket['items']){
        ticket['items'][sel]['index'] = parseInt(sel)+1;
        selectionsHTML += getSelectionHTML(ticket['items'][sel], ticket['type']);
    }
    
    var eachParlayAmount= "";
        
    if(typeof ticket['eachParlayAmount'] !== 'undefined'){
        eachParlayAmount = '<span class="selectionDesc"> Amount Per Parlay: '+ticket['eachParlayAmount']+'</span><br>';
    }    
        
    //Create global risk and win label
    var riskWinGlobalHTML = '<center class="winRiskCenter border-bottom"><b>'+ 
                                eachParlayAmount+
                                '<span class="selectionDesc"> Total Risk '+ticket['globalRisk']+'  To   Win  '+ticket['globalWin']+'</span>'+ 
                            '</b></center>';
    riskWinGlobalHTML = ticket['globalRisk'] == "" || ticket['globalWin'] == "" ? "" : riskWinGlobalHTML;
    
    //Create main modal body
    var mainHTML = '<div class="ticket border-left border-right">'+
                        '<div class="wager border-bottom">'+  
                            '<div class="betType">'+
                                '<center>'+ticket['title']+'</center>'+
                            '</div>'+
                        '</div>'+
                        '<div class="selections-container">'+
                            selectionsHTML+
                        '</div>'+
                        riskWinGlobalHTML+
                    '</div>';
    $('#betslipModal .modal-body').html(mainHTML);  
    $('#betslipModal').modal();
}

function getSelectionHTML(selection, betType){
    
    if(selection['isOpenSelection'] == "0"){
        selection['baseballPitchers'] = selection['baseballPitchers'] != "" ? selection['baseballPitchers']+"<br>" : "";
        var winRiskLabel = betType === "parlay" ? '' : 'Risk '+selection['risk']+' to Win '+selection['win']+'<br>';
        winRiskLabel =  betType === "roundrobin" ? '' : winRiskLabel;
        winRiskLabel =  betType === "teaser" ? '' : winRiskLabel;
        winRiskLabel =  betType === "reverse" ? '' : winRiskLabel;
        var freePlayDesc = selection.freePlay == '1' ? "*** FREE PLAY ***<br>" : "";
        selection['sportDescription'] = selection['sportDescription'].trim() == "" || selection['sportDescription'].trim() == "-" ? "" : selection['sportDescription']+"<br>"; 
        selection['chosenTeam'] = selection['chosenTeam'].trim() !== "" ? selection['chosenTeam']+"<br>" : "";
        
        var pointsLabel = selection.points == "" ? "" : selection.points+"<br>";
        var matchUp = selection.matchUp == "" ? "" : selection.matchUp+"<br>";
        var gameDate = selection.gameDate.indexOf("12/31/1969")>-1 ? "" : 'Game Date: '+selection.gameDate+' (EST)<br>';
                
        return  '<div class="item border-bottom center">'+
                        '<div class="gameDesc"><b>Selection #'+selection['index']+'</b></div>'+
                        '<div class="betDesc">'+
                            selection['sportDescription']+ 
                            matchUp+
                            selection['chosenTeam']+
                            selection['line']+'<br>'+  
                            pointsLabel+
                            selection['baseballPitchers']+
                            winRiskLabel+
                            gameDate+
                            freePlayDesc+
                        '</div>'+
                '</div>';
    }else{
        return  '<div class="item border-bottom center">'+
                        '<div class="gameDesc"><b>Selection #'+selection['index']+'</b></div>'+
                        '<div class="betDesc">'+
                            'Open Selection'+
                        '</div>'+
                '</div>';
    }
}

function printTicket(data, tickettype) {
    var params = JSON.stringify(data);
    var params = params.replace(/\+/g, "%2B");
    var left = (screen.width / 2) - (450 / 2);
    var top = (screen.height / 2) - (700 / 2);
    var w = window.open("/Printview/index?params=" + encodeURI(params) + "&type=" + tickettype, "", "width=450,height=700, top=" + top + ", left=" + left);

}





















/*  ____  _            _      ____       _           _   _
   | __ )| | ___   ___| | __ / ___|  ___| | ___  ___| |_(_) ___  _ __  ___
   |  _ \| |/ _ \ / __| |/ / \___ \ / _ \ |/ _ \/ __| __| |/ _ \| '_ \/ __|
   | |_) | | (_) | (__|   <   ___) |  __/ |  __/ (__| |_| | (_) | | | \__ \
   |____/|_|\___/ \___|_|\_\ |____/ \___|_|\___|\___|\__|_|\___/|_| |_|___/*/























function markBlockedSelections(){
    $(".addToBetslip").removeClass("blocked");
    if(_BETSLIP_TYPE === "parlay" || _BETSLIP_TYPE === "teaser" || _BETSLIP_TYPE === "ifbet" || _BETSLIP_TYPE === "rndrobin"){
        var selectionsInfo=new Object();
        for(var selectionId in _SELECTIONS_ON_BETSLIP){
            var selectionOnBetslip=_SELECTIONS_ON_BETSLIP[selectionId];
            if(selectionOnBetslip['isOpenSelection']!='1')
                selectionsInfo[selectionId]=_SELECTIONS_ON_BETSLIP[selectionId];
        }

        var htmlSelections=$(".addToBetslip");

        for(var i=0; i<htmlSelections.length; i++){
            var htmlSelection=htmlSelections.eq(i);
            var selectionId=htmlSelection.attr('selectionid');
            if(typeof selectionId != "undefined" && typeof(selectionsInfo[selectionId])=='undefined'){
                selectionsInfo[selectionId]=createNewSelectionFromHTML(htmlSelection, selectionId);

                var errors=getSelectionsError(selectionsInfo);

                var hasErrors=false;

                for(var type in errors)
                    if(errors[type].length>0){
                        hasErrors=true;
                        break;
                    }
                if(hasErrors)
                    htmlSelection.addClass("blocked");
                else
                    htmlSelection.removeClass("blocked");

                delete selectionsInfo[selectionId];

            }else{
                htmlSelection.removeClass("blocked");
            }
        }        
    }
}

function createNewSelectionFromHTML(clickedElement, selectionId){
    var maxOrder=getNextOrderSelectionOnBetSlip();
    var choseTeam = clickedElement.attr("chosenteamid");
    var TotalPointsOU = clickedElement.attr("totalpointsou");
    var threshold = clickedElement.attr("threshold");
    threshold = threshold == "" ? clickedElement.find(".threshold").text() :  threshold; 
    var oddsUS = clickedElement.attr("us");
    var oddsDecimal = clickedElement.attr("dec");
    var gameNum = clickedElement.attr("gamenum");
    var isMainbet = clickedElement.attr("mainbet");
    var isFuture = clickedElement.attr("future");
    var periodNumber = clickedElement.attr("periodnumber");
    var betType = clickedElement.attr("bettypeis");
    var contestNum = clickedElement.attr("contestnum");
    var contestantNum = clickedElement.attr("contestannum");
    var sporttype = clickedElement.attr("sporttype");
    var subsporttype = clickedElement.attr("sportsubtype");
    var parlayrestriction = clickedElement.attr("parlayrestriction");
    var groupdescription = clickedElement.attr("groupdescription");
    var betdescription = clickedElement.attr("betdescription"); 
    var listedpitcherhome = clickedElement.attr("listedpitcher1");
    var listedpitcheraway = clickedElement.attr("listedpitcher2");
    var isparlay = clickedElement.attr("isparlay");
	var isstraight = clickedElement.attr("isstraight");
	var isteaser = clickedElement.attr("isteaser");
    var awayTeamID = $("tr[gamenum='"+gameNum+"'].away").find(".teamName").eq(0).text();
    var homeTeamID = $("tr[gamenum='"+gameNum+"'].home").find(".teamName").eq(0).text();
    return makeSelectionForBetslip( maxOrder,
                                    selectionId,
                                    threshold,
                                    oddsUS,
                                    '0',
                                    '0',
                                    oddsDecimal,
                                    '0',
                                    0,
                                    gameNum,
                                    isMainbet,
                                    isFuture,
                                    periodNumber,
                                    betType,
                                    choseTeam,
                                    TotalPointsOU,
                                    contestNum,
                                    contestantNum,
                                    sporttype,
                                    subsporttype,
                                    parlayrestriction,
                                    0,
                                    groupdescription,
                                    betdescription,
                                    listedpitcherhome,
                                    listedpitcheraway,
                                    awayTeamID,
                                    homeTeamID,
                                    isparlay,
                                    isstraight,
                                    isteaser);
}















/*  __     __        _  __         ____       _           _   _
    \ \   / /__ _ __(_)/ _|_   _  / ___|  ___| | ___  ___| |_(_) ___  _ __  ___
     \ \ / / _ \ '__| | |_| | | | \___ \ / _ \ |/ _ \/ __| __| |/ _ \| '_ \/ __|
      \ V /  __/ |  | |  _| |_| |  ___) |  __/ |  __/ (__| |_| | (_) | | | \__ \
       \_/ \___|_|  |_|_|  \__, | |____/ \___|_|\___|\___|\__|_|\___/|_| |_|___/
                           |___/*/
                       
                       
                    












        




function getGameDenyErrorsHookup(selectionsInfo){
    var errors=new Array();
    for(var i in selectionsInfo){
	var selectionInfo=selectionsInfo[i];
	
	if(selectionInfo==null)
	    continue;
	
	if(selectionInfo['ParlayRestriction']=='D')
	    errors.push([selectionInfo['selectionId']]);
    }
    return errors;
}

function getSameGameDenyErrorsHookup(selectionsInfo){
    var errors=new Array();
    
    var groupedSelections=new Object();
    for(var i in selectionsInfo){
	var selectionInfo=selectionsInfo[i];
	
	if(selectionInfo==null)
	    continue;
	
	var gameNum=selectionInfo['GameNum'];
	
	if(selectionInfo['ParlayRestriction']=='S'){
	    if(typeof(groupedSelections[gameNum]))
		groupedSelections[gameNum]=new Array();
	    groupedSelections[gameNum].push(selectionInfo['selectionId']);
	}
    }
    
    for(var gameNum in groupedSelections){
	var gameSelections=groupedSelections[gameNum];
	if(gameSelections.length>1)
	    errors.push(gameSelections);
    }
    
    return errors;
}

function illegalHookupSelectionError(selectionsInfo){
    var errors=new Array();
    
    for(var i in selectionsInfo){
        var selectionInfo=selectionsInfo[i];
        
        if(selectionInfo==null)
            continue;
            
        if(selectionInfo['betType']=='E')
            errors.push([selectionInfo['selectionId']]);
        
        if(selectionInfo['SportType']=='Hockey' && selectionInfo['PeriodNumber']!='0')
            errors.push([selectionInfo['selectionId']]);
        
        if(parseInt(selectionInfo['PeriodNumber'])>=3)
            errors.push([selectionInfo['selectionId']]);
        
        if(selectionInfo['betType']=="S" || selectionInfo["betType"]=="L"){
            var threshold=parseFloat(selectionInfo["threshold"]);
            if(Math.abs(myRound(threshold%1, 2))==0.25 || Math.abs(myRound(threshold%1, 2))==0.75)
            errors.push([selectionInfo['selectionId']]);
        }
        
        if(!selectionInfo['isMainBet']){
            errors.push([selectionInfo['selectionId']]);
        }   
    
        if(_BETSLIP_TYPE === "parlay" && selectionInfo['isParlay']=='0'){
            errors.push([selectionInfo['selectionId']]);
        }

    }
        
    return errors;
}

function illegalHookupCombinationError(selectionsInfo){
    var sameGameAllows=new Object();
    sameGameAllows["Basketball_S_0_L_0"]=true;
    sameGameAllows["Basketball_S_0_L_1"]=true;
    sameGameAllows["Basketball_S_0_L_2"]=true;
    sameGameAllows["Basketball_M_0_L_0"]=true;
    sameGameAllows["Basketball_M_0_L_1"]=true;
    sameGameAllows["Basketball_M_0_L_2"]=true;
    sameGameAllows["Basketball_L_0_S_1"]=true;
    sameGameAllows["Basketball_L_0_M_1"]=true;
    sameGameAllows["Basketball_L_0_S_2"]=true;
    sameGameAllows["Basketball_L_0_M_2"]=true;
    sameGameAllows["Basketball_S_1_L_1"]=true;
    sameGameAllows["Basketball_S_1_L_2"]=true;
    sameGameAllows["Basketball_M_1_L_1"]=true;
    sameGameAllows["Basketball_M_1_L_2"]=true;
    sameGameAllows["Basketball_L_1_S_2"]=true;
    sameGameAllows["Basketball_L_1_M_2"]=true;
    sameGameAllows["Basketball_S_2_L_2"]=true;
    sameGameAllows["Basketball_M_2_L_2"]=true;
    sameGameAllows["Football_S_0_L_0"]=true;
    sameGameAllows["Football_S_0_L_1"]=true;
    sameGameAllows["Football_S_0_L_2"]=true;
    sameGameAllows["Football_M_0_L_0"]=true;
    sameGameAllows["Football_M_0_L_1"]=true;
    sameGameAllows["Football_M_0_L_2"]=true;
    sameGameAllows["Football_L_0_S_1"]=true;
    sameGameAllows["Football_L_0_M_1"]=true;
    sameGameAllows["Football_L_0_S_2"]=true;
    sameGameAllows["Football_L_0_M_2"]=true;
    sameGameAllows["Football_S_1_L_1"]=true;
    sameGameAllows["Football_S_1_L_2"]=true;
    sameGameAllows["Football_M_1_L_1"]=true;
    sameGameAllows["Football_M_1_L_2"]=true;
    sameGameAllows["Football_L_1_S_2"]=true;
    sameGameAllows["Football_L_1_M_2"]=true;
    sameGameAllows["Football_S_2_L_2"]=true;
    sameGameAllows["Football_M_2_L_2"]=true;
    sameGameAllows["Hockey_L_1_M_1"]=true;
    sameGameAllows["Baseball_M_0_L_0"]=true;
    sameGameAllows["Baseball_M_0_L_1"]=true;
    sameGameAllows["Baseball_M_0_L_2"]=true;
    sameGameAllows["Baseball_L_0_M_1"]=true;
    sameGameAllows["Baseball_L_0_M_2"]=true;
    sameGameAllows["Baseball_M_1_L_1"]=true;
    sameGameAllows["Baseball_M_1_L_2"]=true;
    sameGameAllows["Baseball_L_1_M_2"]=true;
    sameGameAllows["Baseball_M_2_L_2"]=true;
    
    var sameSportAllows=new Object();
    sameSportAllows["Basketball_S_0_S_0"]= true;
    sameSportAllows["Basketball_S_0_M_0"]= true;
    sameSportAllows["Basketball_S_0_L_0"]= true;
    sameSportAllows["Basketball_S_0_S_1"]= true;
    sameSportAllows["Basketball_S_0_M_1"]= true;
    sameSportAllows["Basketball_S_0_L_1"]= true;
    sameSportAllows["Basketball_S_0_S_2"]= true;
    sameSportAllows["Basketball_S_0_M_2"]= true;
    sameSportAllows["Basketball_S_0_L_2"]= true;
    sameSportAllows["Basketball_M_0_M_0"]= true;
    sameSportAllows["Basketball_M_0_L_0"]= true;
    sameSportAllows["Basketball_M_0_S_1"]= true;
    sameSportAllows["Basketball_M_0_M_1"]= true;
    sameSportAllows["Basketball_M_0_L_1"]= true;
    sameSportAllows["Basketball_M_0_S_2"]= true;
    sameSportAllows["Basketball_M_0_M_2"]= true;
    sameSportAllows["Basketball_M_0_L_2"]= true;
    sameSportAllows["Basketball_L_0_L_0"]= true;
    sameSportAllows["Basketball_L_0_S_1"]= true;
    sameSportAllows["Basketball_L_0_M_1"]= true;
    sameSportAllows["Basketball_L_0_L_1"]= true;
    sameSportAllows["Basketball_L_0_S_2"]= true;
    sameSportAllows["Basketball_L_0_M_2"]= true;
    sameSportAllows["Basketball_L_0_L_2"]= true;
    sameSportAllows["Basketball_S_1_S_1"]= true;
    sameSportAllows["Basketball_S_1_M_1"]= true;
    sameSportAllows["Basketball_S_1_L_1"]= true;
    sameSportAllows["Basketball_S_1_S_2"]= true;
    sameSportAllows["Basketball_S_1_M_2"]= true;
    sameSportAllows["Basketball_S_1_L_2"]= true;
    sameSportAllows["Basketball_M_1_M_1"]= true;
    sameSportAllows["Basketball_M_1_L_1"]= true;
    sameSportAllows["Basketball_M_1_S_2"]= true;
    sameSportAllows["Basketball_M_1_M_2"]= true;
    sameSportAllows["Basketball_M_1_L_2"]= true;
    sameSportAllows["Basketball_L_1_L_1"]= true;
    sameSportAllows["Basketball_L_1_S_2"]= true;
    sameSportAllows["Basketball_L_1_M_2"]= true;
    sameSportAllows["Basketball_L_1_L_2"]= true;
    sameSportAllows["Basketball_S_2_S_2"]= true;
    sameSportAllows["Basketball_S_2_M_2"]= true;
    sameSportAllows["Basketball_S_2_L_2"]= true;
    sameSportAllows["Basketball_M_2_M_2"]= true;
    sameSportAllows["Basketball_M_2_L_2"]= true;
    sameSportAllows["Basketball_L_2_L_2"]= true;
    sameSportAllows["Football_S_0_S_0"]= true;
    sameSportAllows["Football_S_0_M_0"]= true;
    sameSportAllows["Football_S_0_L_0"]= true;
    sameSportAllows["Football_S_0_S_1"]= true;
    sameSportAllows["Football_S_0_M_1"]= true;
    sameSportAllows["Football_S_0_L_1"]= true;
    sameSportAllows["Football_S_0_S_2"]= true;
    sameSportAllows["Football_S_0_M_2"]= true;
    sameSportAllows["Football_S_0_L_2"]= true;
    sameSportAllows["Football_M_0_M_0"]= true;
    sameSportAllows["Football_M_0_L_0"]= true;
    sameSportAllows["Football_M_0_S_1"]= true;
    sameSportAllows["Football_M_0_M_1"]= true;
    sameSportAllows["Football_M_0_L_1"]= true;
    sameSportAllows["Football_M_0_S_2"]= true;
    sameSportAllows["Football_M_0_M_2"]= true;
    sameSportAllows["Football_M_0_L_2"]= true;
    sameSportAllows["Football_L_0_L_0"]= true;
    sameSportAllows["Football_L_0_S_1"]= true;
    sameSportAllows["Football_L_0_M_1"]= true;
    sameSportAllows["Football_L_0_L_1"]= true;
    sameSportAllows["Football_L_0_S_2"]= true;
    sameSportAllows["Football_L_0_M_2"]= true;
    sameSportAllows["Football_L_0_L_2"]= true;
    sameSportAllows["Football_S_1_S_1"]= true;
    sameSportAllows["Football_S_1_M_1"]= true;
    sameSportAllows["Football_S_1_L_1"]= true;
    sameSportAllows["Football_S_1_S_2"]= true;
    sameSportAllows["Football_S_1_M_2"]= true;
    sameSportAllows["Football_S_1_L_2"]= true;
    sameSportAllows["Football_M_1_M_1"]= true;
    sameSportAllows["Football_M_1_L_1"]= true;
    sameSportAllows["Football_M_1_S_2"]= true;
    sameSportAllows["Football_M_1_M_2"]= true;
    sameSportAllows["Football_M_1_L_2"]= true;
    sameSportAllows["Football_L_1_L_1"]= true;
    sameSportAllows["Football_L_1_S_2"]= true;
    sameSportAllows["Football_L_1_M_2"]= true;
    sameSportAllows["Football_L_1_L_2"]= true;
    sameSportAllows["Football_S_2_S_2"]= true;
    sameSportAllows["Football_S_2_M_2"]= true;
    sameSportAllows["Football_S_2_L_2"]= true;
    sameSportAllows["Football_M_2_M_2"]= true;
    sameSportAllows["Football_M_2_L_2"]= true;
    sameSportAllows["Football_L_2_L_2"]= true;
    sameSportAllows["Hockey_S_0_S_0"]= true;
    sameSportAllows["Hockey_S_0_M_0"]= true;
    sameSportAllows["Hockey_S_0_L_0"]= true;
    sameSportAllows["Hockey_M_0_M_0"]= true;
    sameSportAllows["Hockey_M_0_L_0"]= true;
    sameSportAllows["Hockey_L_0_L_0"]= true;
    sameSportAllows["Baseball_S_0_S_0"]= true;
    sameSportAllows["Baseball_S_0_M_0"]= true;
    sameSportAllows["Baseball_S_0_L_0"]= true;
    sameSportAllows["Baseball_S_0_S_1"]= true;
    sameSportAllows["Baseball_S_0_M_1"]= true;
    sameSportAllows["Baseball_S_0_L_1"]= true;
    sameSportAllows["Baseball_S_0_S_2"]= true;
    sameSportAllows["Baseball_S_0_M_2"]= true;
    sameSportAllows["Baseball_S_0_L_2"]= true;
    sameSportAllows["Baseball_M_0_M_0"]= true;
    sameSportAllows["Baseball_M_0_L_0"]= true;
    sameSportAllows["Baseball_M_0_S_1"]= true;
    sameSportAllows["Baseball_M_0_M_1"]= true;
    sameSportAllows["Baseball_M_0_L_1"]= true;
    sameSportAllows["Baseball_M_0_S_2"]= true;
    sameSportAllows["Baseball_M_0_M_2"]= true;
    sameSportAllows["Baseball_M_0_L_2"]= true;
    sameSportAllows["Baseball_L_0_L_0"]= true;
    sameSportAllows["Baseball_L_0_S_1"]= true;
    sameSportAllows["Baseball_L_0_M_1"]= true;
    sameSportAllows["Baseball_L_0_L_1"]= true;
    sameSportAllows["Baseball_L_0_S_2"]= true;
    sameSportAllows["Baseball_L_0_M_2"]= true;
    sameSportAllows["Baseball_L_0_L_2"]= true;
    sameSportAllows["Baseball_S_1_S_1"]= true;
    sameSportAllows["Baseball_S_1_M_1"]= true;
    sameSportAllows["Baseball_S_1_L_1"]= true;
    sameSportAllows["Baseball_S_1_S_2"]= true;
    sameSportAllows["Baseball_S_1_M_2"]= true;
    sameSportAllows["Baseball_S_1_L_2"]= true;
    sameSportAllows["Baseball_M_1_M_1"]= true;
    sameSportAllows["Baseball_M_1_L_1"]= true;
    sameSportAllows["Baseball_M_1_S_2"]= true;
    sameSportAllows["Baseball_M_1_M_2"]= true;
    sameSportAllows["Baseball_M_1_L_2"]= true;
    sameSportAllows["Baseball_L_1_L_1"]= true;
    sameSportAllows["Baseball_L_1_S_2"]= true;
    sameSportAllows["Baseball_L_1_M_2"]= true;
    sameSportAllows["Baseball_L_1_L_2"]= true;
    sameSportAllows["Baseball_S_2_S_2"]= true;
    sameSportAllows["Baseball_S_2_M_2"]= true;
    sameSportAllows["Baseball_S_2_L_2"]= true;
    sameSportAllows["Baseball_M_2_M_2"]= true;
    sameSportAllows["Baseball_M_2_L_2"]= true;
    sameSportAllows["Baseball_L_2_L_2"]= true;
    sameSportAllows["Soccer_S_0_S_0"]= true;
    sameSportAllows["Soccer_S_0_M_0"]= true;
    sameSportAllows["Soccer_S_0_L_0"]= true;
    sameSportAllows["Soccer_S_0_S_1"]= true;
    sameSportAllows["Soccer_S_0_M_1"]= true;
    sameSportAllows["Soccer_S_0_L_1"]= true;
    sameSportAllows["Soccer_S_0_S_2"]= true;
    sameSportAllows["Soccer_S_0_M_2"]= true;
    sameSportAllows["Soccer_S_0_L_2"]= true;
    sameSportAllows["Soccer_M_0_M_0"]= true;
    sameSportAllows["Soccer_M_0_L_0"]= true;
    sameSportAllows["Soccer_M_0_S_1"]= true;
    sameSportAllows["Soccer_M_0_M_1"]= true;
    sameSportAllows["Soccer_M_0_L_1"]= true;
    sameSportAllows["Soccer_M_0_S_2"]= true;
    sameSportAllows["Soccer_M_0_M_2"]= true;
    sameSportAllows["Soccer_M_0_L_2"]= true;
    sameSportAllows["Soccer_L_0_L_0"]= true;
    sameSportAllows["Soccer_L_0_S_1"]= true;
    sameSportAllows["Soccer_L_0_M_1"]= true;
    sameSportAllows["Soccer_L_0_L_1"]= true;
    sameSportAllows["Soccer_L_0_S_2"]= true;
    sameSportAllows["Soccer_L_0_M_2"]= true;
    sameSportAllows["Soccer_L_0_L_2"]= true;
    sameSportAllows["Soccer_S_1_S_1"]= true;
    sameSportAllows["Soccer_S_1_M_1"]= true;
    sameSportAllows["Soccer_S_1_L_1"]= true;
    sameSportAllows["Soccer_S_1_S_2"]= true;
    sameSportAllows["Soccer_S_1_M_2"]= true;
    sameSportAllows["Soccer_S_1_L_2"]= true;
    sameSportAllows["Soccer_M_1_M_1"]= true;
    sameSportAllows["Soccer_M_1_L_1"]= true;
    sameSportAllows["Soccer_M_1_S_2"]= true;
    sameSportAllows["Soccer_M_1_M_2"]= true;
    sameSportAllows["Soccer_M_1_L_2"]= true;
    sameSportAllows["Soccer_L_1_L_1"]= true;
    sameSportAllows["Soccer_L_1_S_2"]= true;
    sameSportAllows["Soccer_L_1_M_2"]= true;
    sameSportAllows["Soccer_L_1_L_2"]= true;
    sameSportAllows["Soccer_S_2_S_2"]= true;
    sameSportAllows["Soccer_S_2_M_2"]= true;
    sameSportAllows["Soccer_S_2_L_2"]= true;
    sameSportAllows["Soccer_M_2_M_2"]= true;
    sameSportAllows["Soccer_M_2_L_2"]= true;
    sameSportAllows["Soccer_L_2_L_2"]= true;
    sameSportAllows["Tennis_S_0_S_0"]= true;
    sameSportAllows["Tennis_S_0_M_0"]= true;
    sameSportAllows["Tennis_S_0_L_0"]= true;
    sameSportAllows["Tennis_S_0_S_1"]= true;
    sameSportAllows["Tennis_S_0_M_1"]= true;
    sameSportAllows["Tennis_S_0_L_1"]= true;
    sameSportAllows["Tennis_S_0_S_2"]= true;
    sameSportAllows["Tennis_S_0_M_2"]= true;
    sameSportAllows["Tennis_S_0_L_2"]= true;
    sameSportAllows["Tennis_M_0_M_0"]= true;
    sameSportAllows["Tennis_M_0_L_0"]= true;
    sameSportAllows["Tennis_M_0_S_1"]= true;
    sameSportAllows["Tennis_M_0_M_1"]= true;
    sameSportAllows["Tennis_M_0_L_1"]= true;
    sameSportAllows["Tennis_M_0_S_2"]= true;
    sameSportAllows["Tennis_M_0_M_2"]= true;
    sameSportAllows["Tennis_M_0_L_2"]= true;
    sameSportAllows["Tennis_L_0_L_0"]= true;
    sameSportAllows["Tennis_L_0_S_1"]= true;
    sameSportAllows["Tennis_L_0_M_1"]= true;
    sameSportAllows["Tennis_L_0_L_1"]= true;
    sameSportAllows["Tennis_L_0_S_2"]= true;
    sameSportAllows["Tennis_L_0_M_2"]= true;
    sameSportAllows["Tennis_L_0_L_2"]= true;
    sameSportAllows["Tennis_S_1_S_1"]= true;
    sameSportAllows["Tennis_S_1_M_1"]= true;
    sameSportAllows["Tennis_S_1_L_1"]= true;
    sameSportAllows["Tennis_S_1_S_2"]= true;
    sameSportAllows["Tennis_S_1_M_2"]= true;
    sameSportAllows["Tennis_S_1_L_2"]= true;
    sameSportAllows["Tennis_M_1_M_1"]= true;
    sameSportAllows["Tennis_M_1_L_1"]= true;
    sameSportAllows["Tennis_M_1_S_2"]= true;
    sameSportAllows["Tennis_M_1_M_2"]= true;
    sameSportAllows["Tennis_M_1_L_2"]= true;
    sameSportAllows["Tennis_L_1_L_1"]= true;
    sameSportAllows["Tennis_L_1_S_2"]= true;
    sameSportAllows["Tennis_L_1_M_2"]= true;
    sameSportAllows["Tennis_L_1_L_2"]= true;
    sameSportAllows["Tennis_S_2_S_2"]= true;
    sameSportAllows["Tennis_S_2_M_2"]= true;
    sameSportAllows["Tennis_S_2_L_2"]= true;
    sameSportAllows["Tennis_M_2_M_2"]= true;
    sameSportAllows["Tennis_M_2_L_2"]= true;
    sameSportAllows["Tennis_L_2_L_2"]= true;
    
    var errorTmp=new Object();
    var errors=new Array();
    for(var i in selectionsInfo){
	for(var j in selectionsInfo){
	    if(i==j)
		continue;
	    
	    var selectionInfo1=selectionsInfo[i];
	    var selectionInfo2=selectionsInfo[j];
	    
	    if(selectionInfo1==null || selectionInfo2==null)
		continue;
	        
	    var combinationID1=selectionInfo1["SportType"]+"_"+selectionInfo1["betType"]+"_"+selectionInfo1["PeriodNumber"]+"_"+selectionInfo2["betType"]+"_"+selectionInfo2["PeriodNumber"];
	    var combinationID2=selectionInfo2["SportType"]+"_"+selectionInfo2["betType"]+"_"+selectionInfo2["PeriodNumber"]+"_"+selectionInfo1["betType"]+"_"+selectionInfo1["PeriodNumber"];
	
	    var ids1=selectionInfo1['selectionId']+"_"+selectionInfo2['selectionId'];
	    var ids2=selectionInfo2['selectionId']+"_"+selectionInfo1['selectionId'];
	    if(typeof(errorTmp[ids1])=='undefined' && typeof(errorTmp[ids2])=='undefined'){
		if(selectionInfo1['GameNum']==selectionInfo2['GameNum'] && typeof(sameGameAllows[combinationID1])=='undefined' && typeof(sameGameAllows[combinationID2])=='undefined'){
		    errorTmp[ids1]=true;
		    errors.push([selectionInfo1['selectionId'], selectionInfo2['selectionId']]);
		}
	    
		if(selectionInfo1['SportType']==selectionInfo2['SportType'] && typeof(sameSportAllows[combinationID1])=='undefined' && typeof(sameSportAllows[combinationID2])=='undefined'){
		    errorTmp[ids1]=true;
		    errors.push([selectionInfo1['selectionId'], selectionInfo2['selectionId']]);
		}
	    }
	}
    }
    
    return errors;
}

function getIllegalTeaserCombinationErrors(selectionsInfo){
    var sameSportAllows=new Object();
    sameSportAllows["Basketball_S_0_S_0"]= true;
    sameSportAllows["Basketball_S_0_L_0"]= true;
    sameSportAllows["Basketball_L_0_L_0"]= true;
    sameSportAllows["Football_S_0_S_0"]= true;
    sameSportAllows["Football_S_0_L_0"]= true;
    sameSportAllows["Football_L_0_L_0"]= true;
    
    var errorTmp=new Object();
    var errors=new Array();
    for(var i in selectionsInfo){
	for(var j in selectionsInfo){
	    if(i==j)
		continue;
	    
	    var selectionInfo1=selectionsInfo[i];
	    var selectionInfo2=selectionsInfo[j];
	    
	    if(selectionInfo1==null || selectionInfo2==null)
		continue;
	    
	    
	    var combinationID1=selectionInfo1["SportType"]+"_"+selectionInfo1["betType"]+"_"+selectionInfo1["PeriodNumber"]+"_"+selectionInfo2["betType"]+"_"+selectionInfo2["PeriodNumber"];
	    var combinationID2=selectionInfo2["SportType"]+"_"+selectionInfo2["betType"]+"_"+selectionInfo2["PeriodNumber"]+"_"+selectionInfo1["betType"]+"_"+selectionInfo1["PeriodNumber"];
	
	    var ids1=selectionInfo1['selectionId']+"_"+selectionInfo2['selectionId'];
	    var ids2=selectionInfo2['selectionId']+"_"+selectionInfo1['selectionId'];
	
	    if(typeof(errorTmp[ids1])=='undefined' && typeof(errorTmp[ids2])=='undefined'){
		if(selectionInfo1['SportType']==selectionInfo2['SportType'] && typeof(sameSportAllows[combinationID1])=='undefined' && typeof(sameSportAllows[combinationID2])=='undefined'){
		    errorTmp[ids1]=true;
		    errors.push([selectionInfo1['selectionId'], selectionInfo2['selectionId']]);
		}
	    }
	}
    }
    
    return errors;
}

function illegalHookupSelectionTeaserErrors(selectionsInfo){    
    var errors=new Array();

    for(var i in selectionsInfo){
        var selectionInfo=selectionsInfo[i];
        if(selectionInfo['PeriodNumber']!='0')
            errors.push([selectionInfo['selectionId']]);
    }
 
    return errors;
}

function getSelectionsHookupError(selectionsInfo){
    var errors=new Object();
    
    var gameDenyErrors=getGameDenyErrorsHookup(selectionsInfo);
    var sameGameDenyErrors=getSameGameDenyErrorsHookup(selectionsInfo);
    var illegalHookupSelectionErrors=illegalHookupSelectionError(selectionsInfo);
    var illegalHookupCombinationErrors=illegalHookupCombinationError(selectionsInfo);
    
    if(gameDenyErrors.length>0) errors["gameDenyErrors"]=gameDenyErrors;
    if(sameGameDenyErrors.length>0) errors["sameGameDenyErrors"]=sameGameDenyErrors;
    if(illegalHookupSelectionErrors.length>0) errors["illegalHookupSelectionErrors"]=illegalHookupSelectionErrors;
    if(illegalHookupCombinationErrors.length>0) errors["illegalHookupCombinationErrors"]=illegalHookupCombinationErrors;

    return errors;
}

function getStraightSelectionsError(selectionsInfo){
    var errors=new Array();
    var errorsObject=new Object();
    var counter = 0;
    for(var i in selectionsInfo){
        var selectionInfo=selectionsInfo[i];
        if(selectionInfo['isStraight']=='0'){
            errors.push([selectionInfo['selectionId']]);
            counter++;
        }
    }
    
    if(counter>0){
        errorsObject["illegalHookupSelectionErrors"]=errors;

        return errorsObject;
    }else{
        return null;
    }
}

function getParlaySelectionsError(selectionsInfo){
    
    return getSelectionsHookupError(selectionsInfo);
}

function getIllegalSportsTeaserSelectionsError(selectionsInfo, teaser){
    var errors=new Array();
    
    for(var i in selectionsInfo){
        var selectionInfo=selectionsInfo[i];
        
        if(selectionInfo==null)
            continue;
            
        var SportSubType=selectionInfo['SubSportType'].trim();
        var SportType=selectionInfo['SportType'].trim();
        var betType=selectionInfo['betType'];
        
        if(typeof(teaser['SportTypes'][SportType])=='undefined' || 
            typeof(teaser['SportTypes'][SportType][betType])=='undefined' || 
            typeof(teaser['SportTypes'][SportType][betType][SportSubType])=='undefined' || 
            teaser['SportTypes'][SportType][betType][SportSubType]<=0){
            errors.push([selectionInfo['selectionId']]);
            continue;
        }
    }
    return errors;
}

function getSameGameTeaserSelectionsError(selectionsInfo){
    var errors=new Array();
    var gamesNums=new Object();
    for(var i in selectionsInfo){
	var selectionInfo=selectionsInfo[i];
	var gameNum=selectionInfo['GameNum'];
	if(typeof(gamesNums[gameNum])!='undefined')
	    errors.push(selectionInfo['selectionId']);
	gamesNums[gameNum]=true;
    }
    return errors;
}

function getTeaserSelectionsError(selectionsInfo, teaserType){
    var errors=new Object();
    var teaser=siteCache.customer.teasers[_TEASER_TYPE];
    if(typeof teaser != "undefined"){
	var illegalSportsErrors=getIllegalSportsTeaserSelectionsError(selectionsInfo, teaser);
	var gameDenyErrors=getGameDenyErrorsHookup(selectionsInfo);
	var sameGameDenyErrors=getSameGameDenyErrorsHookup(selectionsInfo);
	var illegalHookupCombinationErrors=getIllegalTeaserCombinationErrors(selectionsInfo);
	var illegalHookupSelectionErrors=illegalHookupSelectionTeaserErrors(selectionsInfo);
	
	if(illegalSportsErrors.length>0) errors["illegalSportsErrors"]=illegalSportsErrors;
	if(gameDenyErrors.length>0) errors["gameDenyErrors"]=gameDenyErrors;
	if(sameGameDenyErrors.length>0) errors["sameGameError"]=sameGameDenyErrors;
	if(illegalHookupCombinationErrors.length>0) errors["illegalHookupCombinationErrors"]=illegalHookupCombinationErrors;
	if(illegalHookupSelectionErrors.length>0) errors["illegalHookupSelectionErrors"]=illegalHookupSelectionErrors;
    }
    
    return errors;
}

function getSelectionsError(selectionsInfo){

    if(_BETSLIP_TYPE=='straight')
	return getStraightSelectionsError(selectionsInfo);
    
    if(_BETSLIP_TYPE=='parlay')
	return getParlaySelectionsError(selectionsInfo);
    
    if(_BETSLIP_TYPE=='rndrobin')
	return getParlaySelectionsError(selectionsInfo);
    
    if(_BETSLIP_TYPE=='teaser')
	return getTeaserSelectionsError(selectionsInfo, _TEASER_TYPE);
    
    if(_BETSLIP_TYPE=='ifbet')
	return getParlaySelectionsError(selectionsInfo);
    
    
    if(_BETSLIP_TYPE=='reverse')
	return getParlaySelectionsError(selectionsInfo);
    
    return null;
}
