var sportsOrder=new Object();

sportsOrder['Football']=1;
sportsOrder['Basketball']=2;
sportsOrder['Baseball']=3;
sportsOrder['Hockey']=4;
sportsOrder['Tennis']=5;
sportsOrder['Soccer']=6;

/**
 * Stores the selections place into the placebet.
 * This replace the old cookie way to save data.
 */
var _SELECTIONS_ON_BETSLIP = new Object();

/**
 * Its a flag, telling to the page when load site cache or not.
 * Sometimes user click the "Show Lines" button, but categories hasnt changed,
 * in that case, is not mandatory to fetch sute cache. 
 */
var _SPORT_CATEGORIES_HAS_CHANGED = false;

window.addEventListener("load",function() {
  setTimeout(function(){
    $('html, body').animate({
        scrollTop: 0
    }, 400);
  }, 0);
}) 

$(window).ready(function(){
    //Cookie de accountHistory
    $("#txtRisk").click(function (){
        setInputToWriteSpan("txtRisk");
    });
    
    $("#txtBet").click(function (){
        setInputToWriteSpan("txtBet");
    });
    
    $("#txtWin").click(function (){
        setInputToWriteSpan("txtWin");
    });
    $("#riskAmount").click(function (){
        setInputToWriteSpan("riskAmount");
    });
    
    $("#betslip .teaserWinAmount").click(function (){
        setInputToWriteSpan("betslip .teaserWinAmount");
    });
    
    $("#teaserRiskAmount").click(function (){
        setInputToWriteSpan("teaserRiskAmount");
    });
    
      $("#bs_keyboardTable .numeric").click(function (){
        $("#sp_keyboardValue").val($("#sp_keyboardValue").val()+$(this).val())
    });
    
    $("#sp_keyboardDelete").click(function (){
        var len=$("#sp_keyboardValue").val().length;
        $("#sp_keyboardValue").val($("#sp_keyboardValue").val().substring(0, len-1));
    });
    
    $("#sp_keyboardEnter").click(function (){
        $("#"+focusedInput).val($("#sp_keyboardValue").val());
        $("#"+focusedInput).trigger( "keyup" );
        $("#sp_keyboardValue").val("");
    });
    
    
    if(getCookie('ShowAccountHistory') == "true"){
      $("#groupsWrap").hide();
      $("#gameWrap").hide();
      $("#wagersReportWrap").hide();
      $("#balanceReportWrap").hide();
      $("#overviewWrap").hide();
      $("#accountHistoryReportWrap").show();
      loadAccountHistory(0); 
      $(".showAccountHistoryReport").siblings().removeClass("btn-success").addClass("btn-primary");
      $(".showAccountHistoryReport").removeClass("btn-primary").addClass("btn-success");
      $("#accountHistoryReportWrap").removeClass("secret");
      createCookie('ShowAccountHistory', "false", "");
    }
    else{
      $("#accountHistoryReportWrap").addClass("secret");
    }
    
    if(getCookie('ShowWagersReport') == "true"){
        $("#groupsWrap").hide();
        $("#gameWrap").hide();
        $("#accountHistoryReportWrap").hide();
        $("#balanceReportWrap").hide();
        $("#overviewWrap").hide();
        $("#wagersReportWrap").show();
        $("#loadPendings").click();
        loadWagers(1, 0);
        $("#wagersReportWrap").removeClass("secret");
        createCookie('ShowWagersReport', "false", "");
    }
    else{
      $("#wagersReportWrap").addClass("secret");
    }
  
    $("#logout_spotbook_button").click(function(event) {
        // Remember the link href
        var href = this.href;
        // Don't follow the link
        event.preventDefault();
                
        window.location = href;
    });
    
    // Messages not read
    countUnreadMessages();
    
    $("#myOffCanvas").removeClass("activeLeft");
    $("#navbar").removeClass("in");
    
    $("#placeBet").html(getTextJs.sportbook_betslip_YourBetSlipIsEmpty);
    $("#placeBet").css("border", "1px solid #dddddd");
    $("#placeBet").css("background", "linear-gradient(to bottom, #dddddd 0%, #dddddd 100%)");
    $("#placeBet").css("color", "#000000");
    $("#betslip .emptyBetslip").hide();
    $("#betslip .maxAmounts").hide();
    
    setOpenGames();
   $(".chosen-select").chosen({
        width: "100%"
    });
    
    $("#sp_search_button").click(function (){
        var gameNum=$("#sp_search").val();
        var Sport=$("#opt_"+gameNum).attr("sport");
        var subSport=$("#opt_"+gameNum).attr("subsport");
        var League="";
        var parametros = {
             sport: Sport,
             league: subSport,
             periodNum: 0,
             gameNum: gameNum,
             selectedGameNum: gameNum,
             schedule: League,
             priceType: getPriceType()
        };
        $("#gameWrapLong >").remove();
        $.ajax({
            url: "sportbook/getSelectedGame",
            type: 'POST',
            data: parametros,
            cache: false
        })
        .done(function(data){
            $("#groupsWrap").hide();
           $("#gameWrapLong").html(data);
           $("#gameWrap").show();
           setEvents();
        });
    });
});

function setOpenGames(){
    $.ajax({
        url:"Sportbook/getOpenGamesForSearch",
        type: 'POST',
        async: false,
        dataType: 'json',
        success: function (data) {
            var select=$("#sp_search");
            $.each(data,function (key,val){
                select.append("<option id='opt_"+val["GameNum"]+"' value='"+val["GameNum"]+"' sport='"+val["SportType"]+"' subsport='"+val["SportSubType"]+"'>"+val["Team1RotNum"]+" "+val["Team1ID"]+" vs "+val["Team2RotNum"]+" "+val["Team2ID"]+"</option>");
            });
        }
    })
}

function setInputToWrite(element) {
    focusedInput = $(element).attr("id");
    $("#numericKeyboardModal").modal("toggle");
}

function setInputToWriteSpan(elementID) {
    focusedInput = $("#" + elementID).attr("id");
    $("#numericKeyboardModal").modal("toggle");
}
//store data in a cookie
function createCookie(name, value, days){
  var expires = '';
  if(days){
      var date = new Date();
      date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
      expires = "; expires=" + date.toGMTString();
  }
  else{
      expires = "";
  }
  document.cookie = name + "=" + value+expires + "; path=/";
}

////////////////////////////////
//reads all the the informacion from a cookie
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

/**
 * Event collapse element (bootstrap)
 * @param {Object} element target receives the event
 */
function eventCollapse(element){
    $(element).unbind('click');
    $(element).bind('click', function(){
        var target = $(this).attr('href');
        if ($(this).hasClass("collapsed")){
            $(this).removeClass("collapsed");
            $(target).removeClass('in');
        }else{
            $(this).addClass("collapsed");
            $(target).addClass('in');
        }
    });
    // the element must have, class='collapsed' end el attribut href='#id_element'
}

function toObject(arr){
    var rv = {};
    for(var i in arr){
      if (arr !== null){
        rv[i] = arr[i];
      }
    }
    return rv;
}

function getCurrentTimeMs(){
    return (new Date()).getTime();
}


function saveOddsStyle(oddsStyle){
    createCookie('oddsStyle', oddsStyle, "");
}

function getOddsStyle(){
    var oddsStyle=getCookie('oddsStyle');
    if(oddsStyle===''){
      oddsStyle=ODDS_STYLE_US;
      saveOddsStyle(oddsStyle);
    }
    return oddsStyle;
}

function getSelectedCategories(){
    var info=getCookie('selectedCategories');
    if(info==="")
      return new Object();
    return decodeObject(toObject(jQuery.parseJSON(info)));
}

function saveSelectedCategories(categories){
    createCookie('selectedCategories', JSON.stringify(encodeObject(categories)), 30);
}

function decodeObject(obj){
    var myObj = $.extend( {}, obj);
    for(var i in myObj){
	if(typeof(myObj[i])=='object')
	    myObj[i]=decodeObject(myObj[i]);
	else
	    myObj[i]=unescape(decodeURIComponent(myObj[i]));
    }
    return myObj;
}

function encodeObject(obj){
    var myObj = $.extend( {}, obj);
    for(var i in myObj){
	if(typeof(myObj[i])=='object')
	    myObj[i]=encodeObject(myObj[i]);
	else
	    myObj[i]=escape(encodeURIComponent(myObj[i]));
    }
    return myObj;
}


function searchContestantInOtherEvents(events, contestantId){
    for(var contestNum in events){
      if (events !== null){
        var contest=events[contestNum];
        for(var contestantNum in contest.props){
            if(contestantNum===contestantId){
                return contest.props[contestantNum];
            }
        }
      }
    }
    return null;
}

function getGroupInfo(groupId){
    var groupInfo={};
    if(groupId===undefined)
        return groupInfo;
    
    var regex = /^group_(.*)_(.*)_(.*)$/;
    var match = regex.exec(groupId);
    if(match!==null){
        groupInfo.Sport=match[1];
        groupInfo.League=match[2];
        groupInfo.PeriodNum=match[3];
    }
    return groupInfo;
}

function getSelectionInfoContestant(selectionId, isOnTicket){
    if(isOnTicket==1){
	
    }
    var contestantId = selectionId.substr(selectionId.indexOf("_")+1, selectionId.lenght);
    var selectionInfo=searchContestantInOtherEvents(siteCache.OtherEventsFutures, contestantId);

    if(selectionInfo!==null)
        return selectionInfo;
    
    selectionInfo=searchContestantInFutureProps(siteCache.futureProps, contestantId);
    if(selectionInfo!==null)
        return selectionInfo;
    
    return null;
}


function masiveOpenContainers(clicked){
    var toggleContainersParent=$(clicked).parents(".toggleContainersParent");
    toggleContainersParent.find(".toggleContainers .openAll").hide();
    toggleContainersParent.find(".toggleContainers .closeAll").show();
    
    var containersForMasiveToggle=toggleContainersParent.find(".containerForMasiveToggle");
    for(var i=0; i<containersForMasiveToggle.length; i++){
      var containerForMasiveToggle=containersForMasiveToggle.eq(i);
      var title=containerForMasiveToggle.find(".title");
      if(title.attr('aria-expanded')==='false' || title.attr('aria-expanded')===false)
        title.click();
    }
}

function masiveCloseContainers(clicked){
    var toggleContainersParent=$(clicked).parents(".toggleContainersParent");
    toggleContainersParent.find(".toggleContainers .openAll").show();
    toggleContainersParent.find(".toggleContainers .closeAll").hide();
    
    var containersForMasiveToggle=toggleContainersParent.find(".containerForMasiveToggle");
    for(var i=0; i<containersForMasiveToggle.length; i++){
      var containerForMasiveToggle=containersForMasiveToggle.eq(i);
      var title=containerForMasiveToggle.find(".title");
      if(title.attr('aria-expanded')!='false')
          title.click();
    }
}

/**
 * THIS FUNCTION MUST BE THE SAME AS THE LINES SERVICE ONE
 * @param {type} id
 * @returns {unresolved}
 */
function sanitiazeId(id){
    id=id.replace(/ /g, "_B");
    id=id.replace(/\-/g, "_M");
    id=id.replace(/\+/g, "_P");
    id=id.replace(/\./g, "_D");
    id=id.replace(/\(/g, "_O");
    id=id.replace(/\)/g, "_C");
    id=id.replace(/\//g, "_S");
    id=id.replace(/@/g, "_A");
    id=id.replace(/&/g, "_R");
    id=id.replace(/[^\w\s]/g, "");
    id=id.toLowerCase();
    return id;
}


function timeStampToDateFormat(timestamp){
    var now = new Date();
    var date = new Date(parseInt(timestamp));
    if(now.getYear()==date.getYear() && now.getMonth()==date.getMonth() && now.getDate()==date.getDate())
	return getTextJs["sportbook_Today"];
    return (date.getMonth()+1)+"/"+(date.getDate());
}
function timeStampToDateyearFormat(timestamp){
    var now = new Date();
    var date = new Date(parseInt(timestamp));
    return (date.getMonth()+1)+"/"+(date.getDate()+"/"+(date.getFullYear()));
}

function timeStampToTimeFormat(timestamp){
    var date = new Date(parseInt(timestamp));
    var hours=date.getHours();
    var am=hours>=12? "p" : "a";
    hours=hours>12? hours-12 : hours;
    
    var minutes=date.getMinutes();
    minutes=minutes<10? "0"+minutes: minutes;
    
    return hours+":"+minutes+am;
}

function formatOdds(selection, oddsStyle){
    switch(oddsStyle){
      case ODDS_STYLE_DECIMAL: 
          return selection.Dec;
    
      case ODDS_STYLE_FRACTIONAL: 
          return selection.Num+"/"+selection.Den;		
    
      case ODDS_STYLE_HONGKONG: 
          return Math.round((parseFloat(selection.Dec)-1)*1000)/1000;
    
      default:
          var oddsUS=parseInt(selection.US);
          if(oddsUS>0)
        return "+"+oddsUS;
          return oddsUS;
    }
    return selection.US;
}

function  convertOddsToDecimal(OddsAmerican){
    var conversion = 0;
    var oddsamerican  = parseFloat(OddsAmerican);
    if(oddsamerican > 0){
    //Convertir +
        conversion = (OddsAmerican /100)+1;
    }else{
    //Convertir -
      var positivosiempre = OddsAmerican * -1;
      conversion = (100 /positivosiempre)+1;
    }
    return conversion;
}

function formatFracionalHtml(number){
    number=parseFloat(number);
    var sign="";
    if(number<0)
    sign="-";

    number=Math.abs(number);
    var intVal=Math.floor(number);
    var decVal=number-intVal;

    var decValFrac="";
    if(decVal==0.5)
      decValFrac="&frac12;";
    if(decVal==0.75)
      decValFrac="&frac34;";
    if(decVal==0.25)
      decValFrac="&frac14;";

    if(decValFrac==="")
      return sign+""+number;

    if(intVal===0)
      return sign+""+decValFrac;

    return sign+""+intVal+""+decValFrac;
}

function formatSpread(spread){
    spread=(""+spread).trim();
    if(spread===0 || spread==="0" || spread==="" || spread==="0.0")
      return "PK";

    spread=parseFloat(spread);
    var spreadDec=spread-Math.floor(spread);
    if(spreadDec==0.25 || spreadDec==0.75){
      var spread1=spread-0.25;
      var spread2=spread+0.25;
      if(spread1<0)
          return formatSpread(spread2)+','+formatSpread(spread1);
      else
          return formatSpread(spread1)+','+formatSpread(spread2);
    }

    return spread>0? "+"+formatFracionalHtml(spread): formatFracionalHtml(spread);
}

function formatTotal(total){
    total=parseFloat(total);
    var totalDec=total-Math.floor(total);
    if(totalDec==0.25 || totalDec==0.75){
	var total1=total-0.25;
	var total2=total+0.25;
	if(total1<0)
	    return formatTotal(total2)+','+formatTotal(total1);
	else
	    return formatTotal(total1)+','+formatTotal(total2);
    }

    return formatFracionalHtml(total);
}

function formatThreshold(selection){
    if(selection.betType =='M')
        return "";
    if(selection.betType =='S')
      return formatSpread(selection.threshold);

    if(selection.betType == 'L' || selection.betType == 'E'){
      var total=formatTotal(selection.threshold);
        
      if(selection.ChosenTeamID.toLowerCase()=='over')
        total = "O"+total;
    
      if(selection.ChosenTeamID.toLowerCase()=='under')
        total = "U"+total;
      return total;
    }

    if (selection.betType =='C'){
       if (selection.threshold ==='' || selection.threshold===undefined){
          return "";
       }else if((selection.ChosenTeamID.toLowerCase()=='over') || selection.ChosenTeamID.toLowerCase()=='under'){
          return formatTotal(selection.threshold);
       }else{
          return formatSpread(selection.threshold);
       }
    }

    return selection.threshold;
}

function myRound(num, decs){
    var aux=Math.pow(10, decs); 
    return Math.round(num*aux)/aux;
}

var selectedGameNum=null;
function setEvents(){
    $(".showAccount").unbind("click");
    $(".showAccount").click(function(e){
        e.preventDefault();
        $("#accountSportbook").show();
        $("#groupsWrap, #gameWrap, #overviewWrap").hide();
        $("#wagersReportWrap").show();
        $("#loadPendings").click();
        loadWagers(1, 0);
        cleanLeftMenuSelectedCategories();
    });
    
    $(".showBalanceReport").unbind("click");
    $(".showBalanceReport").click(function(e){
        e.preventDefault();
        $("#groupsWrap").hide();
        $("#gameWrap").hide();
        $("#accountHistoryReportWrap").hide();
        $("#wagersReportWrap").hide();
        $("#groupsWrap").hide();
        $("#gameWrap").hide();
        $("#accountHistoryReportWrap").hide();
        $("#balanceReportWrap").show();
        $("#overviewWrap").hide();
        $("#wagersReportWrap").hide();
        loadweeklyBalance();
    });
    
    $(".showWagersReport").unbind("click");    
    $(".showWagersReport").click(function(e){
        e.preventDefault();
        $(this).addClass('btn-success');
        $(".showAccountHistoryReport").removeClass('btn-success');
        $(".showBalanceReport").removeClass('btn-success');
        $("#groupsWrap, #gameWrap, #accountHistoryReportWrap, #balanceReportWrap, #overviewWrap").hide();
        $("#wagersReportWrap").show();
        $("#loadPendings").click();
        loadWagers(1, 0);
    });
    
    $(".showAccountHistoryReport").unbind("click");
    $(".showAccountHistoryReport").click(function(e){
        e.preventDefault();
        $(this).addClass('btn-success');
        $(".showWagersReport").removeClass('btn-success');
        $(".showBalanceReport").removeClass('btn-success');
        
        $("#groupsWrap, #gameWrap, #wagersReportWrap, #balanceReportWrap, #overviewWrap").hide();
        $("#accountHistoryReportWrap").show();
        loadAccountHistory(0);
    });

    $(".showOverview").unbind("click");
    $(".showOverview").click(function(e){
        e.preventDefault();
        $("#groupsWrap, #gameWrap, #wagersReportWrap, #balanceReportWrap, #accountHistoryReportWrap, #accountSportbook").hide();
        $("#overviewWrap").show();
        loadOverview();
        cleanLeftMenuSelectedCategories();
    });
    
    $(".selectGame").unbind("click");
    $(".selectGame").click(function(e){
        e.preventDefault();
        
        var groupInfo = {};
        var schedule = $(this).parents('#betID').attr('schedule');
 
        groupInfo.Sport=$(this).parents('#betID').attr('sport');
        groupInfo.League=$(this).parents('#betID').attr('league');
        groupInfo.PeriodNum=$(this).parents('#betID').attr('period');
        
        selectedGameNum=$(this).attr("GameNum");
        
        showSelectedGame(selectedGameNum, groupInfo, schedule);
        
        $("#groupsWrap").hide();
        $("#gameWrap").show();
        $("#wagersReportWrap").hide();
        $("#balanceReportWrap").hide();
        $("#accountHistoryReportWrap").hide();
        $("#overviewWrap").hide();
    });
    
    $(".get-back-button").unbind("click");
    $(".get-back-button").click(function(){
        selectedGameNum=null;
        $("#gameWrap").hide();
        $("#groupsWrap").show();
    });
    
    
    
    $("#betslip #openTeaserSelector").unbind("click");
    $("#betslip #openTeaserSelector").click(function(){
        $('#teaserSelectorModal').modal();
    });
    
    $(".addToBetslip").unbind("click");
    $(".addToBetslip").click(addToBetslipClick);

    $(".iconDeleteLeague").unbind("click");
    $(".iconDeleteLeague").click(function(){
        var id=$(this).attr("league");
        var idParent=$(this).attr("idParent");        
        deleteElementLoadLines(id);
        var menuOption = '';
       
       
        if (idParent !== ''){
          
            if (idParent ==='futureProps'){              
              menuOption = id.replace("propsgroupswraplong_bfuture_bprops_b","eventItem_");
              menuOption = menuOption+'_future_bprops';
              $("#"+menuOption).find('input[type="checkbox"]').prop('checked',false);
              
            }else{
               $("#"+idParent).html(function(){
                  var children = $(this).children('*').length;                
                  if (children === 0){
                    var menuOption = idParent.replace("group","eventItem");
                    $("#"+menuOption).find('input[type="checkbox"]').prop('checked',false);                  
                    $("#"+idParent).remove();
                  }
                  
               });
            }          
            
        }else{
           menuOption = id.replace("group","eventItem");        
           $("#"+menuOption).find('input[type="checkbox"]').prop('checked',false);
        }
 
    });
}

/**
 * Description:  Return only 2 decimals, methodo  generic.
 * @param {String} number
 * @returns {float} 2  decimals.
 * @author: Josue Alfaro Ramirez
 * @date:  3/31/2016
 **/
function FixedNumbers(number){
    var convert = parseFloat(number);
    return  convert.toFixed(2);
}
/**
 * 
 * @param {type} valor
 * @returns {String|type}
 * General method  to change  decimals  to  fractions
 */
function changeUpdaterDataDecimals(value) {
    if(isIsset(value)){
        if ((value === 0 || value === '0.0'))
            return "pk";
            
        var valueSplit = value.split("."); 
        if(valueSplit.length > 1){
            var num = valueSplit[0];
            var decimal =  valueSplit[1];
            switch (decimal) {
                case "0":
                  return num;
                  break;
                case "25":
                    if(num===0)
                        return "¼";
                      else
                        return num + "¼";
                    break;
                case "5":
                    if(num===0)
                        return "½";
                      else
                        return num + "½";
                    break;
                case "75":
                     if(num===0)
                        return "¾";
                      else
                        return num + "¾";
                    break;
                    default :
                        return valor;
            }
        }
    }
    return value; 
}

function changeLineFormat(newFormat){
    $.ajax({
        url:"/Sportbook/setCustomerslineFormat",
        type: 'POST',
        data: {
            "formatType":newFormat
        },
        success: function (data) {
            alert("You have to exit and log in back to see this changes");
        }
    });
}

/**
 * update Setting
 * 
 * @param   {string} lineFormat
 * @param   {string} lang     
 */
function updateSetting(lineFormat){
  
  $.ajax({
     url:"/Sportbook/setCustomerslineFormat",
     type: 'POST',
     dataType: 'json',
     data: {
         "formatType":lineFormat}
     }).done(function(data) {
         siteCache.customer.PriceType = lineFormat;
         if (data == '1'){
            getInfoCustomer();
            alert("You have to exit and log in back to see this changes");
         }
     })
     .fail(function(){
         console.log(data);
     });
}

/**
 * get Price Type : Decimal / American
 * 
 * @returns {string} letter 
 */
function getPriceType(){
  var PriceType = 'A';
  if (isIsset(siteCache.customer) && isIsset(siteCache.customer.PriceType)){
     PriceType = $.trim(siteCache.customer.PriceType);
  }
  return PriceType;
}

/*  ____             _
   / ___|  ___  _ __| |_ ___ _ __
   \___ \ / _ \| '__| __/ _ \ '__|
    ___) | (_) | |  | ||  __/ |
   |____/ \___/|_|   \__\___|_|*/

function sorElement(parent){
    var childrens=parent.children();
    var previous=null;
    for(var i=0; i<childrens.length; i++){
	var current=childrens.eq(i);
	if(previous!=null){
	    var currentOrder=typeof(current.attr('order'))!="undefined"? parseFloat(current.attr('order')) : null;
	    var previousOrder=typeof(previous.attr('order'))!="undefined"? parseFloat(previous.attr('order')) : null;
	    
	    if(currentOrder==null)
		continue;
	    
	    if((currentOrder!=null && previousOrder==null) || currentOrder<previousOrder){
		current.insertBefore(previous);
		sorElement(parent);
		return;
	    }
	}
	previous=current;
    }
}

function sortElements(){
    $(".sort").each(function(){
	sorElement($(this));
    });
}


function getTeams(){
    $.ajax({
        url: "/Sportbook/getTeamsforFind",
        type: 'POST',
        data:{
            "teamName":$("#sp_search").val()
        },complete: function (jqXHR, textStatus) {
            $("#sp_search").trigger("chosen:updated");
        },
        success:function (data){
            var obj=JSON.parse(data);
            var select=$("#sp_search");
            select.append(new Option("",""));
            $.each(obj, function (key,val){
                var option=val["SportType"]+"*"+val["SportSubType"]+"*"+val["ScheduleText"]+"*"+val["Team1RotNum"]+"-"+val["Team1ID"]+" vs "+val["Team2RotNum"]+"-"+val["Team2ID"]+"@"+val["GameNum"];
                var opt=new Option(option,option);
                select.append(opt);
            });
            


        }
    });
}

