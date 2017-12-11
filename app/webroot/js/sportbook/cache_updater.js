var lastUpdateDomTime=null;
var _SPORT_CATEGORIES_HAS_CHANGED = false;
var _SELECTED_GAME = false;
var siteCache = {};
var cacheUpdateInterval=60000;
var lastCompressedData=null;

function updateDom(){
    $("#gameWrapLong").empty();
    $("#gameWrapShort").empty();
    //updateLeftmenu();
    updateGroupCategories();
    updateGroupCategoriesShort();
    updateSelectedGame();
    updateSelectedGameShort(); 
    setEvents();
    sortElements();
    addOddColorToGames();
    updateCustomer();
    
}

function calculexcecutionTime(start, event){
    var end = new Date().getTime();
    var time = end - start;
}

function processCompressedData(compressedData){
    
    if(lastCompressedData!=compressedData){
        lastCompressedData=compressedData;
        siteCache=JSON.parse(JXG.decompress(compressedData));
        if (siteCache.lines.games.length === 0 && firstLoadingGamesLines) {
            showMessage("SAVE", "No lines available at the moment", null);
        }
        
        var PriceType = getPriceType(); 
        siteCache.customer.PriceType = PriceType;
        
        //processs here...
        updateDom();  
    }
}

function updateCustomer(customer){
    customer=siteCache.customer;
    $(".FreePlayBalance").html(formatnumeric(myRound(customer.FreePlayBalance, 2), 2, false));
    $(".CurrentBalance").html(formatnumeric(myRound(customer.CurrentBalance, 2), 2, false));
    $(".AvailableBalance").html(formatnumeric(myRound(customer.AvailableBalance, 2), 2, false));
    $("#CurrentBalance, .CurrentBalance").html(formatnumeric(myRound(customer.CurrentBalance, 2), 2, false));
    $("#AvailableBalance").html(formatnumeric(myRound(customer.AvailableBalance, 2), 2, false));
    $("#PendingWager").html(formatnumeric(myRound(customer.PendingWager, 2), 2, false));
    $(".PendingWagerBalance").html(formatnumeric(myRound(customer.PendingWager, 2), 2, false));
    $("#AvailablePending").html(formatnumeric(myRound(customer.PendingWager, 2), 2, false));
    
    $(".CasinoBalance").html(formatnumeric(myRound(customer.CasinoBalance, 2), 2, false)*-1);
    $(".CustomerID").html(customer.CustomerID);
    
    completeCustomerInfoForBetslip();
}

function CalculatePriceAdj() {
    var controlCode = 'Spread';
    //var sportSubType = 'NFL';
    var line = 3.5;
    var lineAdj = 115;
    
    
	var wagerType= controlCode.substring(0, 1);
	var buy = 0;
	var buyMax = 0;
	var buyOn3 = 0;
	var buyOff3 = 0;
	var buyOn7 = 0;
	var buyOff7 = 0;
	var	progressivePointBuyingFlag = 'N';

	if(controlCode.substring(0, 1) == "S") {
		buy = 10;
		buyMax = 2;
		buyOn3 = 20;
		buyOff3 = 20;
		buyOn7 = 10;
		buyOff7 = 10;
	} else {
		buy = 10;
		buyMax = 2;
		buyOn3 = 10;
		buyOff3 = 10;
		buyOn7 = 10;
		buyOff7 = 10;
	}

	var cost = 0;
	var wrkLineAdj = lineAdj;
	
	if(wrkLineAdj < 0) {
		wrkLineAdj *= -1;
	}

	if(progressivePointBuyingFlag == 'Y') {

	} else {
		for(var i = 0.5; i <= wrkLineAdj; i+=0.5) {
			switch(wagerType) {
				case 'L':
					cost += buy;
					break;
				case 'S':
					if(line + i == 3 || line + i == -3) {
						cost += buyOn3;
					} else {
						if(line + i - 0.5 == 3 || line + i - 0.5 == -3) {
							cost += buyOff3;
						} else {
							if(line + i == 7 || line + i == -7) {
								cost += buyOn7;
							} else {
								if(line + i - 0.5 == 7 || line + i - 0.5 == -7) {
									cost += buyOff7;
								} else {
									cost += buy;
								}
							}
						}
					}
				break;
			}
		}
	}
	return cost;
}

function CreateBuyPointsOption() {
    var line = 3.5;
    var lineAdj = 115;
    var controlCode = 'Spread';
    var price, controlPrefix, sportSubType;
    
    
	var buyStr = "<SELECT id=";
	buyStr += controlPrefix;
	buyStr += "buyToSelect name=";
	buyStr += controlPrefix;
	buyStr += "buyToSelect>";
	buyStr += "<OPTION VALUE=0 SELECTED>Buy no points</OPTION>";
	
	var buy = 0;
	var buyMax = 0;
	var buyOn3 = 0;
	var buyOff3 = 0;
	var buyOn7 = 0;
	var buyOff7 = 0;
	if(controlCode.substr(0, 1) == "S") {
		buy = Session("spreadBuy");
		buyMax = Session("spreadBuyMax");
		buyOn3 = Session("spreadBuyOn3");
		buyOff3 = Session("spreadBuyOff3");
		buyOn7 = Session("spreadBuyOn7");
		buyOff7 = Session("spreadBuyOff7");
	}
    else {
		buy = Session("totalBuy");
		buyMax = Session("totalBuyMax");
		buyOn3 = Session("totalBuy");
		buyOff3 = Session("totalBuy");
		buyOn7 = Session("totalBuy");
		buyOff7 = Session("totalBuy");
	}
		
	for(var i = 1; i <= buyMax; i++) {
		if(buyOn3 === 0 && (line + lineAdj * i == 3 || line + lineAdj * i == -3)) {
			break;
		}
		if(buyOff3 === 0 && (line + lineAdj * (i - 1) == 3 || line + lineAdj * (i - 1) == -3)) {
			break;
		}
		if(buyOn7 === 0 && (line + lineAdj * i == 7 || line + lineAdj * i == -7)) {
			break;
		}
		if(buyOff7 === 0 && (line + lineAdj * (i - 1) == 7 || line + lineAdj * (i - 1) == -7)) {
			break;
		}
		buyStr += '<OPTION VALUE=';
		buyStr += lineAdj * i;
		buyStr += ">Buy ";
		if(i / 2 > 0.5) {
			buyStr += Math.floor(i / 2);
		}
		if(i % 2 > 0) {
			buyStr += "&frac12";
		}
		if(i > 2) {
			buyStr += " points to ";
		} else {
			buyStr += " point to ";
		}
		var showSign = true;
		var evForZero = true;
		if(controlCode.substr(0, 1) == "L") {
			showSign = false;
			evForZero = false;
		}
		//var up = true;
		buyStr += AdjustLine(line, lineAdj * i, evForZero, showSign);
		buyStr += ' for ';
		var cost = CalculatePriceAdj(line, lineAdj * i, controlCode, sportSubType);
		var finalPrice = price - cost;
		if(price > 0 && finalPrice < 100) {
			finalPrice = (finalPrice - 200);
		}
		if(finalPrice > 0) {
			buyStr += "+";
		}
		buyStr += finalPrice;
		buyStr += "</OPTION>";
	}
	buyStr += "</SELECT>";
	Response.Write(buyStr);
}


function newSorter(container, elementName){
    $.each(container, function(index, data){
        $(data).find(elementName).sort(function (a, b) {
            return +a.dataset.order - +b.dataset.order;
        })
        .appendTo( $(data) );
    }); 
}


var loadingFullGamesData=false;
var firstLoadingGamesLines=false;
function loadFullGamesData(callbackFunction){
 
    if (selectedGameNum!==null) {
       return;
    }
    var countCategories = (getCookie('selectedCategories').slice(1,  (getCookie('selectedCategories').length - 1))).length;
    var body=$("body");
    var sizeBody = body.attr('class');
    
    if (countCategories > 0){
        $("#overviewWrap, #gameWrap, #wagersReportWrap, #balanceReportWrap, #accountHistoryReportWrap, #accountSportbook").hide();
        $("#userbar").css("display", "block !important");
        if(callbackFunction === undefined && callbackFunction !== "auto") $('#loading').css('display', 'block');
        loadingFullGamesData=true;
        
        var periods = getPeriods();
        
        try{
            var parametros = {
                period: periods,
                sizeBody:sizeBody
            };
            
            $.ajax({
                url: "/Sportbook/getsitecachecompresed",
                type: 'POST',
                data: parametros,
                cache: false
            })
            .done(function(data){
                $("#groupsWrap").show();
                $("#groupsWrapLong").html(data);
 
                assignEventOdds();
                setEvents();
                assignEventPeriod();
                updateBetSlip("sportbook");
                
            })
            .error(function(){
                //setTimeout(loadFullGamesData(), cacheUpdateInterval);
            })
            .always(function(){
                loadingFullGamesData=false;
                firstLoadingLines=true;
                if(callbackFunction === undefined && callbackFunction !== "auto") $('#loading').css('display', 'none');
                if(typeof(callbackFunction)=='function'){
                    callbackFunction();
                }
            });
        }catch (err) {
            console.log(err);
            if(callbackFunction === undefined && callbackFunction !== "auto") $('#loading').css('display', 'none');
        }   
    }
    
}

//verify if another browser changed selections
function verifyBetslipSelectionsChange(){
    var cookieLastTimeBetslipChange=getLastTimeBetslipChange();
    if(cookieLastTimeBetslipChange!=="" && lastTimeBetslipChange<parseInt(cookieLastTimeBetslipChange)){
	lastTimeBetslipChange=cookieLastTimeBetslipChange;
	updateDom();
    }
}

$(document).ready(function(){
        siteCache.customer = _CUSTOMER_INFO;
        //var strLineTypeFormat = readCookie("LineTypeFormat");
        var PriceType = getPriceType();
        siteCache.customer.PriceType = PriceType;
        getInfoCustomer();
        updateCustomer();
        loadLiveOverview();
        loadOverviewGames();
//        loadSellBuyPoints();
        setEvents();
    //setInterval(verifyBetslipSelectionsChange, 1000);

});

var _BUY_SELL_POINTS = {};
function loadSellBuyPoints(){
    $.ajax({
        url: "/Sportbook/getUserPoints",
        type: 'POST',
        data: {},
        cache: false,
        dataType: 'JSON'
    })
    .done(function(data){
        _BUY_SELL_POINTS = data;
    });
}

function debugCalls(error){
    return;
    var e=new Error();
    var stack=error.stack;
    var stacks=stack.split("@");
    var functionName=stacks[0];
    var fileInfo=stacks[1].split(":");
}