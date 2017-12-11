var iniHasValorArray=new Array();
var posEjecutions = 0, posRefresh = 0, btnPeriodSelected = null; btnTypeDataSelected = "", oldPeriod = "", clickAutomaticoTypeBet = false;
var hasSpread=false, hasMoneyline=false, hasTotal=false, hasTeamTotal=false;

$( document ).ready(function() {
    $("#divBalance").css("width", ($(window).width() - (53*4)).toString() + "px");

    $(window).resize(function() {
        var periodID=null;
        if(btnPeriodSelected != null){
            $.each(btnPeriodSelected.split(','), function(key, value) {
                periodID = value;
                periodID = periodID.replace("btnPeriod_", "");
                setMenuHeaderBetsSize(periodID);
            });
        }
        
        $("#divBalance").css("width", ($(window).width() - (53*4)).toString() + "px");
    });
});

function setMenuHeaderBetsSize(periodID){
    //ajuste de tabnla de botonera abajo de periodos
    if($("#"+ periodID + " .table-games").size() > 0){
        setTimeout(function(){
            var tdWith = $(window).width() - 182;
            var textWidth = tdWith - $("body.xs .table-games").find(".gameInfo").find(".RotNum").first().width() - 15;
            $("#"+ periodID + " #trNameHeaderButton").width(tdWith);
            $("#"+ periodID + " .table-games").find(".gameInfo").find(".TeamName").css("width", textWidth + "px");
        }, 100);
    }
}

function getShortDescription(description){
    var words = description.split(" ");
    var res="";
    for(var i=0; i<words.length; i++){
	var word=words[i];
	if(word!="")
	    res+=word.charAt(0);
    }
    return res;
}

function getSubGroupFuturePropsShort(groupID, contestNum, oddsStyle){
    return 'group_contest_short_'+contestNum;
}

function addSubGroupFuturePropsShort(groupID, contestNum, oddsStyle){
    var html = '<div id="group_contest_short_'+contestNum+'" class="table-games futureProps" contestId="'+contestNum+'">';
    html += "<div class='title header collapsed' data-toggle='collapse' href='#list_group_short_"+contestNum+"'>";
        html += "<div class='ellipsis'>";
            html += "<div class='titleText'></div>";
        html += "</div>";
        html += "<div class='toggle-icon'></div>";
    html += "</div>";
    html +=  "<ul id ='list_group_short_"+contestNum+"' class='selectionList row sort collapse'></ul>";
    html += '</div>';
    $('#body_short_'+groupID+" .props").append(html);
    eventCollapse($('#groupsWrapShort #group_contest_'+contestNum+' .title'));
    return 'group_contest_short_'+contestNum;
}
 

function addGroupFuturePropShort (futureID, futureData, oddsStyle){
    
    var sportType = getSportTypeWithPropId(futureID);
    var futureIdParced = futureID.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g,'');
    var groupID=sanitiazeId("group_"+sportType+"_"+futureIdParced+"_future_props");
   
    if($("#body_short_"+groupID).length==0){
        var html = "<div class='group' id='"+groupID+"' order='"+sportsOrder[sportType]+"'>"+
            "<div class='groupTitle h4 ellipsis'>"+
                "<div>"+
                   "Future Props " + sportType+" ("+ futureID.replace('.','') +")"+ 
               "</div>"+
            "</div>"+
            "<div id='body_short_"+groupID+"' class='margin-bottom' >"+
                 "<div class='props'></div>"+
            "</div>"+
            "</div>";
        $("#groupsWrapShort").append(html);
    }
    $('#body_short_'+groupID+" .props").html('');
    var groupVisible = false;
    for(var contentType2 in futureData){
        var bets = futureData[contentType2]['bets'];
        for(var contestNum in bets){
            var contest = bets[contestNum];
            if (getFuturePropsShort(groupID, getSubGroupFuturePropsShort(groupID, contestNum, oddsStyle), contest, oddsStyle)) {
                var ContestID = addSubGroupFuturePropsShort(groupID, contestNum, oddsStyle);
                addFuturePropsShort(groupID, ContestID, contest, oddsStyle);
                groupVisible = true;
            }
        }
    }
    if (!groupVisible) {
        $("#" + groupID).hide();
    }
    
    return groupID;
}

function addPeriodSelectorShort(groupID, periods){
    var sliderID="slider_"+groupID;
    
    //verify if slider has all periods or extra periods
    var targets1=new Object();
    var targets2=new Object();
    if($("#"+sliderID).length>0){
        var toggleContainers=$("#"+sliderID+" .toggle-container");
        for(var i in periods){
            var period=periods[i];
            var periodID=getPeriodID(groupID, period["PeriodNumber"]);
            targets1["#"+periodID]=true;
        }
        
        var toggleContainers=$("#"+sliderID+" .toggle-container");
        for(var j=0; j<toggleContainers.length; j++){
            var toggleContainer=toggleContainers.eq(j);
            targets2[toggleContainer.attr('target')]=true;
        }
        
        for(var target in targets1)
            if(typeof(targets2[target])=='undefined')
            $("#"+sliderID).remove();
        
        for(var target in targets2)
            if(typeof(targets1[target])=='undefined')
            $("#"+sliderID).remove();
        }
        
        //creating a new slider
        if($("#"+sliderID).length==0){
        var displayPieces=0;
        var periodButtonsHtml="";
        var countPeriods = 0;
        
        for(var i in periods){
            countPeriods++;
        }
        
        var maxWidth = countPeriods <= 5 ? 98.00 : 96.00;
        var widthButton = parseFloat(maxWidth / countPeriods).toFixed(2);
        
        for(var i in periods){
            displayPieces++;
            var period=periods[i];
            var periodID=getPeriodID(groupID, period["PeriodNumber"]);
            periodButtonsHtml+=	"<div style='display:left;'>"+
                        "<button class='btn btn-primary btn-sm btn-md toggle-container' id='btnPeriod_" + periodID + "' style='width: " + widthButton + "%;' type='button' target='#"+periodID+"'>"+
                            "<span class='long-period-name'>"+$.trim(period['description'])+"</span><span class='short-period-name'>"+$.trim(period['description_short'])+"</span>"+
                        "</button>"+
                    "</div>";
        }
    
        var html=  "<div id="+sliderID+" class='subGroupSelector' style='width: 100%;'>"+
                "<div u='slides' class='buttonsWrap' style='width: 100%;'>"+
                    periodButtonsHtml+
                "</div>"+
                "</div>";
        
        /*var html=  "<div id="+sliderID+" class='subGroupSelector' style='position: relative; top: 0px; left: 0px; height: 32px; width: " + ($(window).width() - 10).toString() + "px; overflow: hidden; float:left;'>"+
                "<div u='slides' class='buttonsWrap' style='cursor: move; position: absolute; left: 0px; top: 0px; height: 32px; width: " + ($(window).width() - 10).toString() + "px; overflow: hidden; float:left;'>"+
                    periodButtonsHtml+
                "</div>"+
                "</div>";*/
    
        $("#"+groupID+" .sliderWrap").html(html);
        
        /*var options = {
            //$SlideWidth: 40,
            //$SlideSpacing: 3,
            $DisplayPieces: (displayPieces>1? displayPieces-1: 1)
            };
        var jssor = new $JssorSlider$(sliderID, options);*/
        
        $("#"+sliderID+" .toggle-container").click(function(){
            $($(this).attr("target")).siblings(".period").hide();
            $($(this).attr("target")).show();
            $(this).parents('.buttonsWrap').find(".toggle-container").removeClass('btn-success').addClass('btn-primary');
            $(this).addClass('btn-success');
            
            var currentPeriod = $(this).attr("id");
            
            //reemplaza el existente, si es el caso
            if (btnPeriodSelected.indexOf(currentPeriod) == -1) {
                var arraySelectedPeriods = btnPeriodSelected.split(',');
                btnPeriodSelected = "";
                $.each(arraySelectedPeriods, function(key, value) {
                    if (arraySelectedPeriods[key].indexOf(currentPeriod.substring(0, currentPeriod.lastIndexOf('_'))) != -1) {
                        arraySelectedPeriods[key] = currentPeriod;
                    }
                    btnPeriodSelected = btnPeriodSelected + "," + arraySelectedPeriods[key];
                });
                btnPeriodSelected = btnPeriodSelected.substring(1);
            }
            
            var periodID = currentPeriod.replace("btnPeriod_", "");
            ChangeMenuTypeBet($("#"+periodID+" .betTypeSelector .toggle_bettype"), periodID);
            setMenuHeaderBetsSize(periodID);
            
            if(iniHasValorArray["iniHasSpread" + "_" + periodID] && _LINE_TYPES.indexOf("Spread") != -1){
                clickAutomaticoTypeBet = true;
                $("#"+periodID+" .betTypeSelector .spreadSelectorLi .toggle_bettype").click();
            }
            else if(iniHasValorArray["iniHasMoneyline" + "_" + periodID] && _LINE_TYPES.indexOf("MoneyLine") != -1){
                clickAutomaticoTypeBet = true;
                $("#"+periodID+" .betTypeSelector .moneylineSelectorLi .toggle_bettype").click();
            }
            /*else if(iniHasValorArray["iniHasTotal" + "_" + periodID] && _LINE_TYPES.indexOf("Total") != -1){
                clickAutomaticoTypeBet = true;
                $("#"+periodID+" .betTypeSelector .totalSelectorLi .toggle_bettype").click();
            }*/
            else if(iniHasValorArray["iniHasTeamTotal" + "_" + periodID] && _LINE_TYPES.indexOf("TeamTotal") != -1){
                clickAutomaticoTypeBet = true;
                $("#"+periodID+" .betTypeSelector .teamtotalSelectorLi .toggle_bettype").click();
            }
        });
        
        var currentPeriod = $("#"+sliderID+" .toggle-container").first().attr('id');
        if (btnPeriodSelected != null) {
            if (btnPeriodSelected.indexOf(currentPeriod.substring(0, currentPeriod.lastIndexOf('_'))) == -1) {
                btnPeriodSelected = btnPeriodSelected + "," + currentPeriod;
            }
        }
        else{
            btnPeriodSelected = currentPeriod;
        }
        
        $.each(btnPeriodSelected.split(','), function(key, value) {
            clickAutomaticoTypeBet = true;
            $("#" + value).click();
        });
        
        posRefresh++;
        /*if (posRefresh == 1) {
            $("#"+sliderID+" .toggle-container").first().click();
        }
        else{
            if (btnPeriodSelected != null && $("#" + btnPeriodSelected).size() > 0) {
                $("#" + btnPeriodSelected).click();
            }
            else{
                $("#"+sliderID+" .toggle-container").first().click();    
            }
        }*/
    }
}

function getGameInfoHtml(game){
    //var gameLive=false;
    //var myregexp = /LIVE_AVAILABLE/;
    //var match = myregexp.exec(game['Comments']);
    //gameLive=match != null;
    
    var html = "<div class='gameInfo'>"+
               "<div class='team'>" +
               "  <div class='teamDesc'><div class='RotNum'>"+game['TeamAwayRotNum']+"&nbsp;</div><div class='TeamName'>"+game['TeamAwayID']+"</div></div>"+
               "  <div style='clear:both;'></div>" +
               "  <div class='teamDesc'><div class='RotNum'>&nbsp;</div><div class='listedPitcher'>"+(game['ListedPitcherAway']!=undefined?game['ListedPitcherAway']:"")+"</div></div>"+
               "  <div style='clear:both;'></div>" +
               "</div>" +
               "<div class='team'>" +
               "  <div class='teamDesc'><div class='RotNum'>"+game['TeamHomeRotNum']+"&nbsp;</div><div class='TeamName'>"+game['TeamHomeID']+"</div></div>"+
               "  <div style='clear:both;'></div>" +
               "  <div class='teamDesc'><div class='RotNum'>&nbsp;</div><div class='listedPitcher'>"+(game['ListedPitcherHome']!=undefined?game['ListedPitcherHome']:"")+"</div></div>"+
               "  <div style='clear:both;'></div>" +
               "</div>" +
               "<div class='team' id='draw'>" +
               "  <div class='draw'>"+(game['DrawRotNum'] != undefined ? "<div class='RotNum'>" + game['DrawRotNum'] + "&nbsp;</div>" : "")+"<div class='TeamName'>Draw</div></div>"+
               "  <div style='clear:both;'></div>" +
               "</div>" +
               "</div>";
    
    return html;
}

function addGamesSpread(periodID, games, oddsStyle){
    var container=$("#"+periodID+" .table-games.spread tbody");
    var GameNumsAvailable=new Object();
    var gameLive=false;
    var myregexp = /LIVE_AVAILABLE/;
    
    for(var GameNum in games){
        var game=games[GameNum];
        
        gameLive=false;
        var match = myregexp.exec(game['Comments']);
        gameLive=match != null;
        
        var spread=game['bets']['spread'];
        if(game['enable']=='1' && spread['enable']=='1'){
            GameNumsAvailable[GameNum]=true;
            
            var home=spread['selections']['home'];
            var away=spread['selections']['away'];
            
            var totalOver=game['bets']['total']['selections']['over'];
            var totalUnder=game['bets']['total']['selections']['under'];
            
            if(container.find("."+GameNum).length==0){
                var gameOrder=getDayOrder(game['GameDateTimestamp'])+""+game['TeamAwayRotNum'];
                var html = "<tr>" +
                           "    <td id='timeCell' style='text-align: left;'>" +
                           (gameLive? "<div class='gameLiveIcon'></div> " : "")+
                           (game['Status']=='I'? "<div class='gameCircledIcon'></div>" : "")+
                           "        <div class='gameTime'>" + timeStampToDateFormat(game['GameDateTimestamp'])+" "+timeStampToTimeFormat(game['GameDateTimestamp'])+" "+
                           "        </div>"+
                           "    </td>" +
                           (_LINE_TYPES.indexOf("Spread") != -1 ? "<td><div class='gameTitle'>Spread</div></td>" : "")+
                           (_LINE_TYPES.indexOf("Total") != -1 ? "<td><div class='gameTitle'>Total</div></td>" : "")+
                           "    <td>&nbsp;</td>" +
                           "</tr>";
                container.append(html);
                html =     "<tr order='"+gameOrder+"' class='game "+GameNum+"' gamenum='"+GameNum+"'>"+
                           "    <td>"+getGameInfoHtml(game)+"</td>"+
                           (_LINE_TYPES.indexOf("Spread") != -1 ? "<td class='selectionWrap home'>"+getSelectionHtml(away, oddsStyle) + "<br/>"+ getSelectionHtml(home, oddsStyle)+"</td>" : "")+
                           (_LINE_TYPES.indexOf("Total") != -1 ? "<td class='selectionWrap away'>"+getSelectionHtml(totalOver, oddsStyle) + "<br/>"+ getSelectionHtml(totalUnder, oddsStyle)+"</td>" : "")+
                           "    <td><div class='link selectGame' GameNum='"+game['GameNum']+"'>" +
                           "        <a href='#' GameNum='"+game['GameNum']+"'>+" + countBetsGame(game['GameNum']) + "</a>" +
                           "    </div></td>" +
                           "</tr>";
                container.append(html);
                }
            else{
                updateSelection(home, container.find("."+GameNum+" .home .selection"), oddsStyle);
                updateSelection(away, container.find("."+GameNum+" .away .selection"), oddsStyle);
            }
        }
    }
    
    //removing disabled games
    var gamesHtml=container.find('.game');
    for(var i=0; i<gamesHtml.length; i++){
	var gameHtml=gamesHtml.eq(i);
	if(typeof(GameNumsAvailable[gameHtml.attr('gamenum')])=='undefined')
	    gameHtml.remove();
    }
}

function addGamesMoneyLine(periodID, games, oddsStyle){
    var container=$("#"+periodID+" .table-games.moneyline tbody");
    var GameNumsAvailable=new Object();
    var gameLive=false;
    var myregexp = /LIVE_AVAILABLE/;
    
    var hasDraw=false;
    for(var GameNum in games){
        var game=games[GameNum];
        var moneyLine=game['bets']['moneyLine'];
        if(game['enable']=='1' && moneyLine['enable']=='1'){
            GameNumsAvailable[GameNum]=true;
            
            var home=moneyLine['selections']['home'];
            var away=moneyLine['selections']['away'];
            var draw=moneyLine['selections']['draw'];
            
            var totalOver=game['bets']['total']['selections']['over'];
            var totalUnder=game['bets']['total']['selections']['under'];
            
            if(draw['enable']=='1')
            hasDraw=true;
            
            if(container.find("."+GameNum).length==0){
                var gameOrder=getDayOrder(game['GameDateTimestamp'])+""+game['TeamAwayRotNum'];
                var html = "<tr>" +
                           "    <td id='timeCell' style='text-align: left;'>" +
                           (gameLive? "<div class='gameLiveIcon'></div> " : "")+
                           (game['Status']=='I'? "<div class='gameCircledIcon'></div>" : "")+
                           "        <div class='gameTime'>" + timeStampToDateFormat(game['GameDateTimestamp'])+" "+timeStampToTimeFormat(game['GameDateTimestamp'])+" "+
                           "        </div>"+
                           "    </td>" +
                           (_LINE_TYPES.indexOf("MoneyLine") != -1 ? "<td><div class='gameTitle'>Money Line</div></td>" : "")+
                           (_LINE_TYPES.indexOf("Total") != -1 ? "<td><div class='gameTitle'>Total</div></td>" : "")+
                           "    <td>&nbsp;</td>" +
                           "</tr>";
                container.append(html);
                
                html =      "<tr order='"+gameOrder+"' class='border-bottom game "+GameNum+"' gamenum='"+GameNum+"'>"+
                            "<td>"+getGameInfoHtml(game)+"</td>"+
                            (_LINE_TYPES.indexOf("MoneyLine") != -1 ? "<td class='selectionWrap border-left home'>"+getSelectionHtml(away, oddsStyle)+"<br/>"+getSelectionHtml(home, oddsStyle)+"<br/>"+getSelectionHtml(draw, oddsStyle)+"</td>" : "")+
                            (_LINE_TYPES.indexOf("Total") != -1 ? "<td class='selectionWrap border-left away' style='vertical-align: top;'>"+getSelectionHtml(totalOver, oddsStyle) + "<br/>"+ getSelectionHtml(totalUnder, oddsStyle)+"</td>" : "")+
                            "<td><div class='link selectGame' id='linkSelectGame' GameNum='"+game['GameNum']+"'>" +
                            "   <a href='#' GameNum='"+game['GameNum']+"'>+" + countBetsGame(game['GameNum']) + "</a>" +
                            "</div></td>" +
                            "</tr>";
                container.append(html);
            }
            else{
                updateSelection(home, container.find("."+GameNum+" .home .selection"), oddsStyle);
                updateSelection(away, container.find("."+GameNum+" .away .selection"), oddsStyle);
                updateSelection(draw, container.find("."+GameNum+" .draw .selection"), oddsStyle);
            }
        }
    }
    
    if(hasDraw){
        $("#"+periodID+" .table-games.moneyline .gameInfo #draw").show();
        $("#"+periodID+" .table-games.moneyline #linkSelectGame").css("height", "144px");
    }
    else{
        $("#"+periodID+" .table-games.moneyline .gameInfo #draw").hide();
        $("#"+periodID+" .table-games.moneyline #linkSelectGame").css("height", "95px");
    }
    
    //removing disabled games
    var gamesHtml=container.find('.game');
    for(var i=0; i<gamesHtml.length; i++){
	var gameHtml=gamesHtml.eq(i);
	if(typeof(GameNumsAvailable[gameHtml.attr('gamenum')])=='undefined')
	    gameHtml.remove();
    }
}

function addGamesTeamTotal(periodID, games, oddsStyle){
    var container=$("#"+periodID+" .table-games.teamtotal tbody");
    var GameNumsAvailable=new Object();
    var gameLive=false;
    var myregexp = /LIVE_AVAILABLE/;
    
    for(var GameNum in games){
	var game=games[GameNum];
	var awayTotal=game['bets']['awayTotal'];
	var homeTotal=game['bets']['homeTotal'];
	if(game['enable']=='1' && (awayTotal['enable']=='1' || homeTotal['enable']=='1')){
	    GameNumsAvailable[GameNum]=true;
	    
	    var awayOver=awayTotal['selections']['over'];
	    var awayUnder=awayTotal['selections']['under'];
	    var homeOver=homeTotal['selections']['over'];
	    var homeUnder=homeTotal['selections']['under'];
	    
	    if(container.find("."+GameNum).length==0){
		var gameOrder=getDayOrder(game['GameDateTimestamp'])+""+game['TeamAwayRotNum'];
        
        var html = "<tr>" +
                   "    <td id='timeCell' style='text-align: left;'>" +
                   (gameLive? "<div class='gameLiveIcon'></div> " : "")+
                   (game['Status']=='I'? "<div class='gameCircledIcon'></div>" : "")+
                   "        <div class='gameTime'>" + timeStampToDateFormat(game['GameDateTimestamp'])+" "+timeStampToTimeFormat(game['GameDateTimestamp'])+" "+
                   "        </div>"+
                   "    </td>" +
                   (_LINE_TYPES.indexOf("TeamTotal") != -1 ? "<td><div class='gameTitle'>Team Total</div></td>" : "")+
                   (_LINE_TYPES.indexOf("Total") != -1 ? "<td><div class='gameTitle'>Total</div></td>" : "")+
                   "    <td>&nbsp;</td>" +
                   "</tr>";
        container.append(html);
        
		html =     "<tr order='"+gameOrder+"' class='border-bottom game "+GameNum+"' gamenum='"+GameNum+"'>"+
                   "<td>"+getGameInfoHtml(game)+"</td>"+
                   (_LINE_TYPES.indexOf("TeamTotal") != -1 ? "<td class='selectionWrap border-left homeOver'>"+getSelectionHtml(awayOver, oddsStyle) + "<br/>" +getSelectionHtml(homeOver, oddsStyle)+"</td>" : "")+
                   (_LINE_TYPES.indexOf("Total") != -1 ? "<td class='selectionWrap border-left homeUnder' style='vertical-align: top;'>"+getSelectionHtml(awayUnder, oddsStyle) + "<br/>" + getSelectionHtml(homeUnder, oddsStyle)+"</td>" : "")+
                   "    <td><div class='link selectGame' GameNum='"+game['GameNum']+"'>" +
                   "        <a href='#' GameNum='"+game['GameNum']+"'>+" + countBetsGame(game['GameNum']) + "</a>" +
                   "    </div></td>" +
                   "</tr>";
                   
        container.append(html);
        
	    }
	    else{
		updateSelection(homeOver, container.find("."+GameNum+" .homeOver .selection"), oddsStyle);
		updateSelection(homeUnder, container.find("."+GameNum+" .homeUnder .selection"), oddsStyle);
		updateSelection(awayOver, container.find("."+GameNum+" .awayOver .selection"), oddsStyle);
		updateSelection(awayUnder, container.find("."+GameNum+" .awayUnder .selection"), oddsStyle);
	    }
	}
    }
    //removing disabled games
    var gamesHtml=container.find('.game');
    for(var i=0; i<gamesHtml.length; i++){
	var gameHtml=gamesHtml.eq(i);
	if(typeof(GameNumsAvailable[gameHtml.attr('gamenum')])=='undefined')
	    gameHtml.remove();
    }
}

function ChangeMenuTypeBet(object, periodID){
    $("#"+periodID+" .betWrap").hide();
    $("#"+periodID+" .betWrap."+$(object).attr('target_class')).show();
    $(object).parents('.betTypeSelector').find('.toggle_bettype').addClass('btn-primary').removeClass("btn-success");
    $(object).removeClass("btn-primary").addClass("btn-success");

    switch($(object).html().toLowerCase()) {
        case "spread":
            if(iniHasValorArray["iniHasSpread" + "_" + periodID] && _LINE_TYPES.indexOf("Spread") != -1) {
                $("#"+periodID+" .betTypeSelector .spreadSelectorLi").css("visibility", "hidden");
                $("#"+periodID+" .betTypeSelector .spreadSelectorLi").css("display", "none");
            }
            else{
                $("#"+periodID+" .betTypeSelector .spreadSelectorLi").css("visibility", "hidden");
                $("#"+periodID+" .betTypeSelector .spreadSelectorLi").css("display", "none");
            }
    
            if(iniHasValorArray["iniHasMoneyline" + "_" + periodID] && _LINE_TYPES.indexOf("MoneyLine") != -1) {
                $("#"+periodID+" .betTypeSelector .moneylineSelectorLi").css("visibility", "visible");
                $("#"+periodID+" .betTypeSelector .moneylineSelectorLi").css("display", "block");
            }
            else{
                $("#"+periodID+" .betTypeSelector .moneylineSelectorLi").css("visibility", "hidden");
                $("#"+periodID+" .betTypeSelector .moneylineSelectorLi").css("display", "none");
            }
            
            if(iniHasValorArray["iniHasTeamTotal" + "_" + periodID] && _LINE_TYPES.indexOf("TeamTotal") != -1) {
                $("#"+periodID+" .betTypeSelector .teamtotalSelectorLi").css("visibility", "visible");
                $("#"+periodID+" .betTypeSelector .teamtotalSelectorLi").css("display", "block");
            }
            else{
                $("#"+periodID+" .betTypeSelector .teamtotalSelectorLi").css("visibility", "hidden");
                $("#"+periodID+" .betTypeSelector .teamtotalSelectorLi").css("display", "none");
            }
            break;
        case "money<br>line":
            if(iniHasValorArray["iniHasSpread" + "_" + periodID] && _LINE_TYPES.indexOf("Spread") != -1) {
                $("#"+periodID+" .betTypeSelector .spreadSelectorLi").css("visibility", "visible");
                $("#"+periodID+" .betTypeSelector .spreadSelectorLi").css("display", "block");
            }
            else{
                $("#"+periodID+" .betTypeSelector .spreadSelectorLi").css("visibility", "hidden");
                $("#"+periodID+" .betTypeSelector .spreadSelectorLi").css("display", "none");
            }
            
            if(iniHasValorArray["iniHasMoneyline" + "_" + periodID] && _LINE_TYPES.indexOf("MoneyLine") != -1) {
                $("#"+periodID+" .betTypeSelector .moneylineSelectorLi").css("visibility", "hidden");
                $("#"+periodID+" .betTypeSelector .moneylineSelectorLi").css("display", "none");
            }
            else{
                $("#"+periodID+" .betTypeSelector .moneylineSelectorLi").css("visibility", "hidden");
                $("#"+periodID+" .betTypeSelector .moneylineSelectorLi").css("display", "none");
            }
            
            if(iniHasValorArray["iniHasTeamTotal" + "_" + periodID] && _LINE_TYPES.indexOf("TeamTotal") != -1) {
                $("#"+periodID+" .betTypeSelector .teamtotalSelectorLi").css("visibility", "visible");
                $("#"+periodID+" .betTypeSelector .teamtotalSelectorLi").css("display", "block");
            }
            else{
                $("#"+periodID+" .betTypeSelector .teamtotalSelectorLi").css("visibility", "hidden");
                $("#"+periodID+" .betTypeSelector .teamtotalSelectorLi").css("display", "none");
            }
            break;
        case "team<br>total":
            if(iniHasValorArray["iniHasSpread" + "_" + periodID] && _LINE_TYPES.indexOf("Spread") != -1){
                $("#"+periodID+" .betTypeSelector .spreadSelectorLi").css("visibility", "visible");
                $("#"+periodID+" .betTypeSelector .spreadSelectorLi").css("display", "block");
            }
            else{
                $("#"+periodID+" .betTypeSelector .spreadSelectorLi").css("visibility", "hidden");
                $("#"+periodID+" .betTypeSelector .spreadSelectorLi").css("display", "none");
            }
            
            if(iniHasValorArray["iniHasMoneyline" + "_" + periodID] && _LINE_TYPES.indexOf("MoneyLine") != -1) {
                $("#"+periodID+" .betTypeSelector .moneylineSelectorLi").css("visibility", "visible");
                $("#"+periodID+" .betTypeSelector .moneylineSelectorLi").css("display", "block");
            }
            else{
                $("#"+periodID+" .betTypeSelector .moneylineSelectorLi").css("visibility", "hidden");
                $("#"+periodID+" .betTypeSelector .moneylineSelectorLi").css("display", "none");
            }
     
            if(iniHasValorArray["iniHasTeamTotal" + "_" + periodID] && _LINE_TYPES.indexOf("TeamTotal") != -1) {
                $("#"+periodID+" .betTypeSelector .teamtotalSelectorLi").css("visibility", "hidden");
                $("#"+periodID+" .betTypeSelector .teamtotalSelectorLi").css("display", "none");
            }
            else{
                $("#"+periodID+" .betTypeSelector .teamtotalSelectorLi").css("visibility", "hidden");
                $("#"+periodID+" .betTypeSelector .teamtotalSelectorLi").css("display", "none");
            }
            break;
    }
}

function addPeriodShort(groupID, period, oddsStyle){
    var games=period['games'];
    
    hasSpread=false, hasMoneyline=false, hasTotal=false, hasTeamTotal=false;
    for(var GameNum in games){
        var game=games[GameNum];
        if(game['enable']=='1'){
            if(game['bets']['spread']['enable']=='1' && _LINE_TYPES.indexOf("Spread") != -1) hasSpread=true;
            if(game['bets']['moneyLine']['enable']=='1' && _LINE_TYPES.indexOf("MoneyLine") != -1) hasMoneyline=true;
            if(game['bets']['total']['enable']=='1' && _LINE_TYPES.indexOf("Total") != -1) hasTotal=false;
            if(game['bets']['homeTotal']['enable']=='1' && _LINE_TYPES.indexOf("TeamTotal") != -1) hasTeamTotal=true;
            if(game['bets']['awayTotal']['enable']=='1' && _LINE_TYPES.indexOf("TeamTotal") != -1) hasTeamTotal=true;
        }
    }
    
    var periodID = getPeriodID(groupID, period["PeriodNumber"]);

    if(_LINE_TYPES.indexOf("Spread") != -1){
        iniHasValorArray["iniHasSpread" + "_" + periodID] = hasSpread;   
    }
    if (_LINE_TYPES.indexOf("MoneyLine") != -1) {
        iniHasValorArray["iniHasMoneyline" + "_" + periodID] = hasMoneyline;
    }
    if (_LINE_TYPES.indexOf("Total") != -1) {
        iniHasValorArray["iniHasTotal" + "_" + periodID] = hasTotal;
    }
    if (_LINE_TYPES.indexOf("TeamTotal") != -1) {
        iniHasValorArray["iniHasTeamTotal" + "_" + periodID] = hasTeamTotal;
    }
    
    if($("#"+periodID).length==0){
        var html= "<div class='margin-bottom period' id='"+periodID+"'>"+
            "<div class='betType'>" +
            "   <table id='tableHeaderButton' class=''><tbody>"+
            "       <tr class=''>"+
            "           <td id='trNameHeaderButton'><div><label>Display:</label></div></td>"+
            "           <td>"+
            "               <div class='betTypeSelector'>" +
            (_LINE_TYPES.indexOf("Spread") != -1 ? "<div class='spreadSelectorLi'><button class='btn btn-sm btn-md btn-primary-orange toggle_bettype' type='button' target_class='spreadWrap' id='" + periodID + "_btnSpreadWrap'>Spread</button></div>" : "")+
			(_LINE_TYPES.indexOf("MoneyLine") != -1 ? "<div class='moneylineSelectorLi'><button class='btn btn-sm btn-md btn-primary-orange toggle_bettype' type='button' target_class='moneylineWrap' id='" + periodID + "_btnMoneylineWrap'>Money<br/>Line</button></div>" : "")+
            //(_LINE_TYPES.indexOf("Total") != -1 ? "<div class='totalSelectorLi' style='visibility:hidden;display:none;'><button class='btn btn-sm btn-md btn-primary toggle_bettype' type='button' target_class='totalWrap' id='" + periodID + "_btnSpreadWrap'>Total</button></div>" : "")+
            (_LINE_TYPES.indexOf("TeamTotal") != -1 ? "<div class='teamtotalSelectorLi'><button class='btn btn-sm btn-md btn-primary-orange toggle_bettype' type='button' target_class='teamtotalWrap' id='" + periodID + "_btnTeamtotalWrap'>Team<br/>Total</button></div>" : "")+
            "               </div>" +
            "           </td>"+
            "           <td>&nbsp;</td>"+
            "       </tr>"+
            "   </tbody></table>"+
            "</div>" +
			"<div class='betTypeContainer'>"+
			    (_LINE_TYPES.indexOf("Spread") != -1 ? "<div class='spreadWrap betWrap'>"+"<table class='table-games spread'>"+"<tbody></tbody>"+"</table>"+"</div>" : "")+
			    
			    (_LINE_TYPES.indexOf("MoneyLine") != -1 ? "<div class='moneylineWrap betWrap'>"+"<table class='table-games moneyline'>"+"<tbody></tbody>"+"</table>"+"</div>" : "")+
			    
			    /*(_LINE_TYPES.indexOf("Total") != -1 ? "<div class='totalWrap betWrap'>"+"<table class='table-games total'>"+"<tbody></tbody>"+"</table>"+"</div>" : "")+*/
			    
			    (_LINE_TYPES.indexOf("TeamTotal") != -1 ? "<div class='teamtotalWrap betWrap'>"+"<table class='table-games teamtotal'>"+"<tbody></tbody>"+"</table>"+"</div>" : "")+
			"</div>"+
		    "</div>";
        $("#"+groupID+" .periods").append(html);	
        $("#"+periodID+" .betTypeSelector .toggle_bettype").click(function(){
            ChangeMenuTypeBet(this, periodID);
            
            if (!clickAutomaticoTypeBet) {
                var currentBtnTypeDataSelected = $(this).attr("id");
                //reemplaza el existente, si es el caso
                if (btnTypeDataSelected.indexOf(currentBtnTypeDataSelected.substring(0, currentBtnTypeDataSelected.lastIndexOf('_'))) == -1) {
                    btnTypeDataSelected = btnTypeDataSelected + "," + currentBtnTypeDataSelected;
                    if (btnTypeDataSelected.charAt(0) == ",") {
                        btnTypeDataSelected = btnTypeDataSelected.substring(1);
                    }
                } else if (btnTypeDataSelected.indexOf(currentBtnTypeDataSelected) == -1) {
                    var arraySelectedTypeData = btnTypeDataSelected.split(',');
                    btnTypeDataSelected = "";
                    $.each(arraySelectedTypeData, function(key, value) {
                        if (arraySelectedTypeData[key].indexOf(currentBtnTypeDataSelected.substring(0, currentBtnTypeDataSelected.lastIndexOf('_'))) != -1) {
                            arraySelectedTypeData[key] = currentBtnTypeDataSelected;
                        }
                        btnTypeDataSelected = btnTypeDataSelected + "," + arraySelectedTypeData[key];
                    });
                    btnTypeDataSelected = btnTypeDataSelected.substring(1);
                }
            }
            
            clickAutomaticoTypeBet = false;
        });
        
        //var periodName = periodID.substring(0, periodID.lastIndexOf('_'));
        //if (posRefresh == 0 || oldPeriod != periodName) {
            //oldPeriod = periodName;
        if (posRefresh == 0) {
            if(hasSpread && _LINE_TYPES.indexOf("Spread") != -1){
                clickAutomaticoTypeBet = true;
                $("#"+periodID+" .betTypeSelector .spreadSelectorLi .toggle_bettype").click();
            }
            else if(hasMoneyline && _LINE_TYPES.indexOf("MoneyLine") != -1){
                clickAutomaticoTypeBet = true;
                $("#"+periodID+" .betTypeSelector .moneylineSelectorLi .toggle_bettype").click();
            }
            /*else if(hasTotal && _LINE_TYPES.indexOf("Total") != -1){
                clickAutomaticoTypeBet = true;
                $("#"+periodID+" .betTypeSelector .totalSelectorLi .toggle_bettype").click();
            }*/
            else if(hasTeamTotal && _LINE_TYPES.indexOf("TeamTotal") != -1){
                clickAutomaticoTypeBet = true;
                $("#"+periodID+" .betTypeSelector .teamtotalSelectorLi .toggle_bettype").click();
            }
        }
    }
    
    if (_LINE_TYPES.indexOf("Spread") != -1) {
        addGamesSpread(periodID, games, oddsStyle);
    }
    if (_LINE_TYPES.indexOf("MoneyLine") != -1) {
        addGamesMoneyLine(periodID, games, oddsStyle);
    }
    if (_LINE_TYPES.indexOf("Total") != -1) {
        //addGamesTotal(periodID, games, oddsStyle);
    }
    if (_LINE_TYPES.indexOf("TeamTotal") != -1) {
        addGamesTeamTotal(periodID, games, oddsStyle);
    }
    
    //hidding disabled sections
    if(hasSpread && _LINE_TYPES.indexOf("Spread") != -1){
        $("#"+periodID+" .betTypeSelector .spreadSelectorLi").show();
    	$("#"+periodID+" .betTypeContainer .spread").show();
    }else{
        $("#"+periodID+" .betTypeSelector .spreadSelectorLi").hide();
    	$("#"+periodID+" .betTypeContainer .spread").hide();
    }
    
    if(hasMoneyline && _LINE_TYPES.indexOf("MoneyLine") != -1){
        $("#"+periodID+" .betTypeSelector .moneylineSelectorLi").show();
        $("#"+periodID+" .betTypeContainer .moneyline").show();
    }else{
        $("#"+periodID+" .betTypeSelector .moneylineSelectorLi").hide();
        $("#"+periodID+" .betTypeContainer .moneyline").hide();
    }
    
    /*if(hasTotal && _LINE_TYPES.indexOf("Total") != -1){
        $("#"+periodID+" .betTypeSelector .totalSelectorLi").show();
    	$("#"+periodID+" .betTypeContainer .total").show();
    }else{
    	$("#"+periodID+" .betTypeSelector .totalSelectorLi").hide();
    	$("#"+periodID+" .betTypeContainer .total").hide();
    }*/
    
    if(hasTeamTotal && _LINE_TYPES.indexOf("TeamTotal") != -1){
    	$("#"+periodID+" .betTypeSelector .teamtotalSelectorLi").show();
    	$("#"+periodID+" .betTypeContainer .teamtotal").show();
    }else{
    	$("#"+periodID+" .betTypeSelector .teamtotalSelectorLi").hide();
    	$("#"+periodID+" .betTypeContainer .teamtotal").hide();
    }
    
    if (posRefresh > 0) {
        if (btnTypeDataSelected != null){
            $.each(btnTypeDataSelected.split(","), function(key, value) {
                clickAutomaticoTypeBet = true;
                $("#" + value).click();
            });
        }
    }
    
    setMenuHeaderBetsSize(periodID);
    
    return periodID;
}

function addGroupShort(SportType, SportSubType, periods, oddsStyle){
    var groupID=sanitiazeId("groupshort_"+SportType+"_"+SportSubType);
    if($("#"+groupID).length==0){
	var html=   "<div class='group' id="+groupID+" order='"+sportsOrder[SportType]+"'>"+
			"<div class='title' data-toggle='collapse' href='#body_"+groupID+"'>"+
			    SportType+" "+SportSubType+
			    "<div class='toggle-icon'></div>"+
			"</div>"+
			"<div id='body_"+groupID+"'>"+
			    "<div class='vertical-middle sliderWrap'></div>"+
			    "<div class='periods'></div>"+
			"</div>"+
		    "</div>";
	$("#groupsWrapShort").append(html);
    }
    
    //adding periods to group
    var periodsID=new Object();
    for(var i in periods){
	var periodID=addPeriodShort(groupID, periods[i], oddsStyle);
	periodsID[periodID]=true;
    }
    
    //removing disable periods
    var periodsHtml=$("#"+groupID+" .period");
    for(var i=0; i<periodsHtml.length; i++){
	var periodHtml=periodsHtml.eq(i);
	if(typeof(periodsID[periodHtml.attr("id")])=='undefined')
	    periodHtml.remove();
    }
    
    addPeriodSelectorShort(groupID, periods);
    
    return groupID;
}

function getFuturePropsShort(groupID, contestID, groupContest, oddsStyle){
    var html = '';
    var headerContest = false;
    for(var contestantNum in groupContest['selections']){
        var contestant = groupContest['selections'][contestantNum];
        var odd =  parseInt(contestant['oddsDecimal']);
        odd = odd > 0 ? "+"+odd : odd;
        var moneyLine =  parseInt(contestant['oddsUS']);
        moneyLine = moneyLine > 0 ? "+"+moneyLine : moneyLine;
        
        if(!isNaN(moneyLine) && moneyLine != 0){
            if (!headerContest ) {
                return true;       
            }
        }
    }
    return false;
}

function addFuturePropsShort(groupID, contestID, groupContest, oddsStyle){
    var html = '';
   var headerContest = false;
   for(var contestantNum in groupContest['selections']){
    
        var contestant = groupContest['selections'][contestantNum];
        var odd =  parseInt(contestant['oddsDecimal']);
        odd = odd > 0 ? "+"+odd : odd;
        var moneyLine =  parseInt(contestant['oddsUS']);
        moneyLine = moneyLine > 0 ? "+"+moneyLine : moneyLine;
        
        if(!isNaN(moneyLine) && moneyLine != 0){
            if (!headerContest ) {
                $('#'+groupID+' .props #'+contestID+' .title .titleText').html(groupContest['description']);

                var contestantId = contestant['id'];
                var ContestNum = groupContest['ContestNum'];
                var order=1;
                html+="<li class='addToBetslip col-xs-6' id='"+contestantId+"' selectionid='"+ContestNum+'_'+contestantNum+"' order='"+order+"'>"+
                "<div class='selectionTable'>"+
                   "<div class='selectionFix'>"+
                       "<div class='selectionContent ellipsis'>"+
                           "<div class='selectionDesc' style='text-align: center;'>"+contestant['description'] +"</div>"+
                           "<div class='noWrap' style='text-align: center;'>"+
                               "<span class='selectionThreshold threshold'>"+(!isNaN(contestant['threshold']) && contestant['threshold'] != ""? formatFracionalHtml(contestant['threshold']) : "")+"</span>&nbsp;&nbsp;"+
                               "<span class='selectionThreshold threshold'>"+moneyLine+"</span>"+
                               "<span class='selectionOdds odds'>"+""+"</span>"+
                           "</div>"+
                        "</div>"+
                   "</div>"+
                "</div>"+
                "</li>";
            }
        }
        eval("$('#body_short_'+groupID+' .props #'+contestID+' ul.selectionList').html(html)");
    }
}


function updateGroupCategoriesShort(){
    $("#groupsWrapShort").html("");
    var data=getSelectedGamesGroupedByCategoryPeriods();
    var otherProps=getSelectedOtherPropsGroupedByCategory();
    
    var oddsStyle=getOddsStyle();
    //adding groups
    var groupIDs=new Object();    
    for(var SportType in data){
        var SportTypeData=data[SportType];
        for(var SportSubType in SportTypeData){
            var periods=SportTypeData[SportSubType]['periods'];
            var groupID=addGroupShort(SportType, SportSubType, periods, oddsStyle);
            groupIDs[groupID]=true;
        }
    }
    // Other props
    for(var prop in otherProps){
        var data=otherProps[prop];
        if (Object.keys(data).length !=0 ) {
            var groupID=addGroupFuturePropShort(prop, data, oddsStyle);
            groupIDs[groupID]=true;
        }
    }
    
    //removing disable groups
    var groups=$("#groupsWrapShort .group");
    for(var i=0; i<groups.length; i++){
	var group=groups.eq(i);
	if(typeof(groupIDs[group.attr("id")])=='undefined')
	    group.remove();
    }
}