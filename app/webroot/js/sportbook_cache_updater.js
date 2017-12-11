var lastUpdateDomTime=null;

function updateDom(){
    $("#gameWrapLong").empty();
    $("#gameWrapShort").empty();
    //updateLeftmenu();
    updateGroupCategories();
   // updateGroupCategoriesShort();
    updateSelectedGame();
    //updateSelectedGameShort(); 
    setEvents();
    sortElements();
    addOddColorToGames();
    updateBetSlip();
    hightLigthSelectionOnBetslip();
    updateCustomer();
}

function calculexcecutionTime(start, event){
    var end = new Date().getTime();
    var time = end - start;
}

var siteCache = {};
var cacheUpdateInterval=60000;
var lastCompressedData=null;

function addGameLinesToCache(compressedDataObj){
    $.each(compressedDataObj["lines"]["games"],function (key,val){
        siteCache["lines"]["games"][key]=val;
    });
    $.each(compressedDataObj["futures"]["games"],function (key,val){
        siteCache["futures"]["games"][key]=val;
    });
    $.each(compressedDataObj["props"]["games"],function (key,val){
        siteCache["props"]["games"][key]=val;
    });
}
function deleteSiteCacheLines(){
    $.each($(".leftMenuCheckBox"),function (){
        $(this).prop("checked",false);
    });
    siteCache["lines"]["games"]=[];
    siteCache["props"]["games"]=[];
    siteCache["futures"]["games"]=[];
}

function processCompressedData(compressedData){
    var compressedDataObj=JSON.parse(compressedData);
    if(siteCache["lines"]===undefined){
        siteCache=compressedDataObj;
    }else{
        addGameLinesToCache(compressedDataObj);
    }
    var PriceType = getPriceType(); 
    siteCache['customer']['PriceType'] = PriceType;
    
	//processs here...
	updateDom();
    
}

function updateCustomer(customer){
    var customer=siteCache['customer'];
    $(".FreePlayBalance").html(formatnumeric(myRound(customer['FreePlayBalance'], 2), 2, false));
    $(".CurrentBalance").html(formatnumeric(myRound(customer['CurrentBalance'], 2), 2, false));
    $(".AvailableBalance").html(formatnumeric(myRound(customer['AvailableBalance'], 2), 2, false));
    $("#CurrentBalance").html(formatnumeric(myRound(customer['CurrentBalance'], 2), 2, false));
    $("#AvailableBalance").html(formatnumeric(myRound(customer['AvailableBalance'], 2), 2, false));
    $("#PendingWager").html(formatnumeric(myRound(customer['PendingWager'], 2), 2, false));
    $(".PendingWagerBalance").html(formatnumeric(myRound(customer['PendingWager'], 2), 2, false));
    $("#AvailablePending").html(formatnumeric(myRound(customer['PendingWager'], 2), 2, false));
    $(".CasinoBalance").html(formatnumeric(myRound(customer['CasinoBalance'], 2), 2, false));
    $(".CustomerID").html(customer['CustomerID']);
}

var loadingFullGamesData=false;
var firstLoadingGamesLines=false;
function loadFullGamesData(callbackFunction){
    
      var selectedCateogies=new Object();
    var checks=$("#sportsMenu input:checked");
    for(var i=0; i<checks.length; i++){
        var value=checks.eq(i).val();
        selectedCateogies[value]=value;
    }
    alert(65465)
    if(!loadingFullGamesData){
        $("#userbar").css("display", "block !important");
        if(callbackFunction == undefined && callbackFunction != "auto") $('#loading').css('display', 'block');
        loadingFullGamesData=true;
        try{
            $.ajax({
                url: "/Sportbook/getsitecachecompresed",
                type: 'POST',
                data:{
                    "gamenum":$("#sp_search").val(),
                    "categori":JSON.stringify(encodeObject(selectedCateogies))
                    
                },
                dataType: "json",
                cache: false
            })
            .done(function(data){
                processCompressedData(data['compressedData']);
                if(searchFlag){
                var scrolled=600;
                $("#content").animate({
                        scrollTop:  $("#content").height()+scrolled
                   });
               }
            })
            .error(function(jqXHR, textStatus, errorThrown){
                setTimeout(loadFullGamesData, cacheUpdateInterval);
            })
            .always(function(){
                loadingFullGamesData=false;
                firstLoadingLines=true;
                //if(callbackFunction == undefined && callbackFunction != "auto") $('#loading-games, .wrap-loading-games').removeClass('active');
                if(callbackFunction == undefined && callbackFunction != "auto") $('#loading').css('display', 'none');
                if(typeof(callbackFunction)=='function'){
                callbackFunction();
                }
            });
        }catch (err) {
            console.log(err);
            //if(callbackFunction == undefined && callbackFunction != "auto") $('#loading-games, .wrap-loading-games').removeClass('active');
            if(callbackFunction == undefined && callbackFunction != "auto") $('#loading').css('display', 'none');
        }
    }
}

//verify if another browser changed selections
function verifyBetslipSelectionsChange(){
    var cookieLastTimeBetslipChange=getLastTimeBetslipChange();
    if(cookieLastTimeBetslipChange!="" && lastTimeBetslipChange<parseInt(cookieLastTimeBetslipChange)){
	lastTimeBetslipChange=cookieLastTimeBetslipChange;
        updateDom();
    }
}

function getInfoCustomer(){
   /* $.ajax({
        type: "POST",
        url: "/Pages/getInfoCustomer",
        dataType: "json",    
        async: true,
        success: function(data){
            siteCache['customer']['AvailableBalance'] = data;
            updateCustomer();
        },
        error: function (request, status, error) {
            //alert(request.responseText);
        }
    });*/
}

$(document).ready(function(){
    if(typeof(compressedData)!="undefined"){
        processCompressedData(compressedData);
    }else{
        siteCache['customer'] = _CUSTOMER_INFO;
        
        var strLineTypeFormat = readCookie("LineTypeFormat");
        
        var PriceType = getPriceType();
        siteCache['customer']['PriceType'] = PriceType;
       // getInfoCustomer();
        updateCustomer();
        if(Object.keys(getSelectionsOnBetslip()).length === 0)
            updateBetSlip();
       // loadOverview();
       // loadFullGamesData();
    }
    
    //setInterval(verifyBetslipSelectionsChange, 1000);
   // setInterval(function(){ loadFullGamesData("auto"); }, cacheUpdateInterval); 
});
