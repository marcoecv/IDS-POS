/**
 * Stores the selections place into the placebet.
 * This replace the old cookie way to save data.
 */
var _SELECTIONS_ON_BETSLIP = new Object();

$("#userbar").removeAttr('style', 'display: block !important');
$("#navbar").removeAttr('style', 'display: block !important'); 
    
function getCurrentSize(){
    var width=window.innerWidth;

    if(width>=1200)
        return 'lg';
    else if(width>=992)
        return 'md';
    else if(width>=768)
        return 'sm';
    else
        return 'xs';
}

function showHeaderMenu(){
    if (_CUSTOMER_ADMIN) {
      $("#navbar .nav .mainMenu a .icoAgent").parents(".mainMenu").css("display", "inline-block");
    }
    else{
      $("#navbar .nav .mainMenu a .icoAgent").parents(".mainMenu").css("display", "none");
    }
    
    if (_LIVEBET_STATUS) {
      $("#navbar .nav .mainMenu a .icoLive").parents(".mainMenu").css("display", "inline-block");
    }
    else{
      $("#navbar .nav .mainMenu a .icoLive").parents(".mainMenu").css("display", "none");
    }
    
    if (_CASINO_STATUS) {
      $("#navbar .nav .mainMenu a .icoCasino").parents(".mainMenu").css("display", "inline-block");
    }
    else{
      $("#navbar .nav .mainMenu a .icoCasino").parents(".mainMenu").css("display", "none");
    }
    
    if (_THEME != "Sportsroom") {
      $("#navbar .nav .mainMenu a .icoLiveCasino").parents(".mainMenu").css("display", "inline-block");
    }
    else{
      $("#navbar .nav .mainMenu a .icoLiveCasino").parents(".mainMenu").css("display", "none");
    }
    
    if (_LIVEDEALER_STATUS && getCurrentSize() != "xs") {
      $("#navbar .nav .mainMenu a .icoLiveDealer").parents(".mainMenu").css("display", "inline-block");
    }
    else{
      $("#navbar .nav .mainMenu a .icoLiveDealer").parents(".mainMenu").css("display", "none");
    }
    
    if (_THEME == "Betlatino") {
        if (_HORSE_STATUS) {
            $("#navbar .nav .mainMenu a .icoRace").parents(".mainMenu").css("display", "inline-block");
        }
        else{
            $("#navbar .nav .mainMenu a .icoRace").parents(".mainMenu").css("display", "none");
        }
    }
    
    if (_MENU_OPTIONS.indexOf("Message") !== -1) {
      $("#navbar .nav .mainMenu a .icon-envelope").parents(".mainMenu").css("display", "inline-block");
    }
    else{
      $("#navbar .nav .mainMenu a .icon-envelope").parents(".mainMenu").css("display", "none");
    }
    
    if (_MENU_OPTIONS.indexOf("Support") !== -1) {
      $("#navbar .nav .mainMenu a .icon-envelope").parents(".mainMenu").css("display", "inline-block");
    }
    else{
      $("#navbar .nav .mainMenu a .icon-envelope").parents(".mainMenu").css("display", "none");
    }
    
    if (getCurrentSize() != 'xs') {
        $("#navbar .logo").css("display", "block");
        
        var countMenus = 0;
        $("#navbar .mainMenu").each(function(){
            if($(this).css("display")!="none"){
              countMenus++;
            }
        });
        
        //var countMenus = (_CUSTOMER_ADMIN ? $("#navbar .mainMenu").size() : $("#navbar .mainMenu").size() - 1);
        $("#navbar .mainMenu").css("width", (100.00 / countMenus).toString() + "%");
    }
    else{
        $("#navbar .logo").css("display", "none");
        $("#navbar .mainMenu").css("width", "100%");
    }
}

function myRound(num, decs){
    var aux=Math.pow(10, decs); 
    return Math.round(num*aux)/aux;
}

function getCookie(c_name){   
    if (document.cookie.length > 0){
        var c_start = document.cookie.indexOf(c_name + "=");
        if(c_start != -1){
            c_start = c_start + c_name.length + 1;
            c_end = document.cookie.indexOf(";", c_start);
            if(c_end == -1)
                c_end = document.cookie.length;
            return unescape(document.cookie.substring(c_start, c_end));
        }
    }
    return "";
}

function countSelectionsOnBetslip(){
    var selectionsOnBetslip=getSelectionsOnBetslip();
    var count=0;
    for(var selectionId in selectionsOnBetslip)
    count++;
    return count;
}

function getSelectionsOnBetslip(){
     return _SELECTIONS_ON_BETSLIP;
}

function updateCustomer(customer){
    var customer=siteCache['customer'];
    $(".FreePlayBalance").html(formatnumeric(myRound(customer['FreePlayBalance'], 2), 2, false));
    $(".CurrentBalance").html(formatnumeric(myRound(customer['CurrentBalance'], 2), 2, false));
    $(".AvailableBalance").html(formatnumeric(myRound(customer['AvailableBalance'], 2), 2, false));
    $("#CurrentBalance").html(formatnumeric(myRound(customer['CurrentBalance'], 2), 2, false));
    $("#AvailableBalance").html(formatnumeric(myRound(customer['AvailableBalance'], 2), 2, false));
    $("#PendingWager").html(formatnumeric(myRound(customer['PendingWager'], 2), 2, false));
    $("#AvailablePending").html(formatnumeric(myRound(customer['PendingWager'], 2), 2, false));
    $(".PendingWagerBalance").html(formatnumeric(myRound(customer['PendingWager'], 2), 2, false));
    $(".CasinoBalance").html(formatnumeric(myRound(customer['CasinoBalance'], 2), 2, false));
    $(".CustomerID").html(customer['CustomerID']);
    
    $("#shopping-cart").html(countSelectionsOnBetslip());
}

function getInfoCustomer(){
    //Register
  /*  $.ajax({
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

var siteCache = {};
$(document).ready(function(){
    $("#divHeader").css("display", "block");
    
   // getInfoCustomer();
    
    showHeaderMenu();
    $("#divBalance").css("width", ($(window).width() - (53*4)).toString() + "px");

    $(window).resize(function() { 
        showHeaderMenu();
        $("#divBalance").css("width", ($(window).width() - (53*4)).toString() + "px");
    });
    
    $(".showAccountHistoryReport").parent().click(function() {
        var url = window.location.href.toLowerCase();
        if (url.indexOf("sportbook") == -1) {
            createCookie('ShowAccountHistory', "true", "");
            window.location = url.substring(0, url.indexOf("/pages") + 1) + "Sportbook";
        }
    });
    $(".showWagersReport").parent().click(function() {
        var url = window.location.href.toLowerCase();
        if (url.indexOf("sportbook") == -1) {
            createCookie('ShowWagersReport', "true", "");
            window.location = url.substring(0, url.indexOf("/pages") + 1) + "Sportbook";
        }
    });
    
    $(window).resize(function() { 
        showHeaderMenu();
        $("#divBalance").css("width", ($(window).width() - (53*4)).toString() + "px");
    });
    
    siteCache['customer'] = _CUSTOMER_INFO;
    updateCustomer();
    
    $("#btnHeaderLeft").click(function(){
        var url = window.location.href.toLowerCase();
        if (url.indexOf("sportbook") == -1) {
            window.location = url.substring(0, url.indexOf("/pages") + 1) + "sportbook";
        }
    });
    
    $("#btnHeaderRight").click(function(){
        var url = window.location.href.toLowerCase();
        if (url.indexOf("sportbook") == -1) {
            window.location = url.substring(0, url.indexOf("/pages") + 1) + "sportbook";
        }
    });
    
    $("#userbar").attr('style', 'display: block !important');
    $("#navbar").attr('style', 'display: block !important');
});