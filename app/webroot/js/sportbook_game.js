function addMainBetsGroups(gameContainerID, game, oddsStyle){
    var groups=game['lines']['groups'];
    var groupOpen=false;
    var groupWrapIDs=new Object();
    for(var groupIndex in groups){
	var group=groups[groupIndex];
	if(group['enable']=='1'){
	    
	    var groupWrapID=gameContainerID+"_"+group['PeriodNumber'];
	    groupWrapIDs[groupWrapID]=true;

	    var spread=group['bets']['spread'];
	    var moneyLine=group['bets']['moneyLine'];
	    var total=group['bets']['total'];
	    var homeTotal=group['bets']['homeTotal'];
	    var awayTotal=group['bets']['awayTotal'];

	    if($("#"+groupWrapID).length==0){
            
            var html = "<div class='group containerForMasiveToggle' id='"+groupWrapID+"' order='"+group['PeriodNumber']+"'>";
            html += "<div class='title  "+"' data-toggle='collapse' href='#body_"+groupWrapID+"' style='height: 40px;line-height: 36px;' aria-expanded='"+(groupOpen?"true":"false")+"'>";
                html += group['description'];
                html += "<div class='toggle-icon' style='height: 40px;line-height: 36px;'></div>";
            html += "</div>";
            html += "<div id='body_"+groupWrapID+"' class='"+(groupOpen?"in":"collapse")+"'>";
                html += "<table class='table-games'>";
                html += "<thead>";
                    html += "<tr class='border-bottom'>";
                    html += "<th></th>";
                    html += (_LINE_TYPES.indexOf("Spread") != -1 ? "<th>"+getTextJs['sportbook_game_Spread']+"</th>" : "");
                    html += (_LINE_TYPES.indexOf("MoneyLine") != -1 ? "<th>"+getTextJs['sportbook_game_MoneyLine']+"</th>" : "");
                    html += (_LINE_TYPES.indexOf("Total") != -1 ? "<th>"+getTextJs['sportbook_game_Total']+"</th>" : "");
                    html += (_LINE_TYPES.indexOf("TeamTotal") != -1 ? "<th colspan='2'>"+getTextJs['sportbook_game_TeamTotal']+"</th>" : "");
                    html += "</tr>";
                html += "</thead>";
                html += "<tbody>";
                    html += "<tr class='border-bottom'>";
                    html += "<td class='teamInfo'>";
                        html += "<div class='teamSerial'>"+(game['TeamAwayRotNum']!=undefined?game['TeamAwayRotNum']:"")+".</div>";
                        html += "<div class='teamName'>"+game['TeamAwayID']+"</div>";
                        html += "<div class='listedPitcher'>"+(game['ListedPitcherAway']!=undefined?game['ListedPitcherAway']:"")+"</div>";
                    html += "</td>";
                    html += (_LINE_TYPES.indexOf("Spread") != -1 ? "<td class='selectionWrap spreadAway'>"+getSelectionHtml(spread['selections']['away'])+"</td>" : "");
                    html += (_LINE_TYPES.indexOf("MoneyLine") != -1 ? "<td class='selectionWrap moneyLineAway'>"+getSelectionHtml(moneyLine['selections']['away'])+"</td>" : "");
                    html += (_LINE_TYPES.indexOf("Total") != -1 ? "<td class='selectionWrap totalOver'>"+getSelectionHtml(total['selections']['over'])+"</td>" : "");
                    html += (_LINE_TYPES.indexOf("TeamTotal") != -1 ? "<td class='selectionWrap teamTotalAwayOver'>"+getSelectionHtml(awayTotal['selections']['over'])+"</td>" : "");
                    html += (_LINE_TYPES.indexOf("TeamTotal") != -1 ? "<td class='selectionWrap teamTotalAwayUnder'>"+getSelectionHtml(awayTotal['selections']['under'])+"</td>" : "");
                    html += "</tr>";
                    html += "<tr class='border-bottom'>";
                    html += "<td class='teamInfo'>";
                        html += "<div class='teamSerial'>"+(game['TeamHomeRotNum']!=undefined?game['TeamHomeRotNum']:"")+".</div>";
                        html += "<div class='teamName'>"+game['TeamHomeID']+"</div>";
                        html += "<div class='listedPitcher'>"+(game['ListedPitcherHome']!=undefined?game['ListedPitcherHome']:"")+"</div>";
                    html += "</td>";
                    html += (_LINE_TYPES.indexOf("Spread") != -1 ? "<td class='selectionWrap spreadHome'>"+getSelectionHtml(spread['selections']['home'])+"</td>" : "");
                    html += (_LINE_TYPES.indexOf("MoneyLine") != -1 ? "<td class='selectionWrap moneyLineHome'>"+getSelectionHtml(moneyLine['selections']['home'])+"</td>" : "");
                    html += (_LINE_TYPES.indexOf("Total") != -1 ? "<td class='selectionWrap totalUnder'>"+getSelectionHtml(total['selections']['under'])+"</td>" : "");
                    html += (_LINE_TYPES.indexOf("TeamTotal") != -1 ? "<td class='selectionWrap teamTotalHomeOver'>"+getSelectionHtml(homeTotal['selections']['over'])+"</td>" : "");
                    html += (_LINE_TYPES.indexOf("TeamTotal") != -1 ? "<td class='selectionWrap teamTotalHomeUnder'>"+getSelectionHtml(homeTotal['selections']['under'])+"</td>" : "");
                    html += "</tr>";
                    html += "<tr class='border-bottom trDraw'>";
                    html += "<td class='teamInfo'>";
                        //html += "<div class='teamSerial'>"+game['DrawRotNum']+".</div>";
                        html += "<div class='teamName'>Draw</div>";
                        html += "<div class='listedPitcher'></div>";
                    html += "</td>";
                    html += (_LINE_TYPES.indexOf("Spread") != -1 ? "<td class='selectionWrap'></td>" : "");
                    html += (_LINE_TYPES.indexOf("MoneyLine") != -1 ? "<td class='selectionWrap moneyLineDraw'>"+getSelectionHtml(moneyLine['selections']['draw'])+"</td>" : "");
                    html += (_LINE_TYPES.indexOf("Total") != -1 ? "<td class='selectionWrap'></td>" : "");
                    html += (_LINE_TYPES.indexOf("TeamTotal") != -1 ? "<td class='selectionWrap'></td>" : "");
                    html += (_LINE_TYPES.indexOf("TeamTotal") != -1 ? "<td class='selectionWrap'></td>" : "");
                    html += "</tr>";
                    if(isIsset(game["Comments"])){
                           if (game["Comments"].trim().length > 0){
                        html += "<tr class='border-bottom'>";
                            html += "<td class='gameNote' colspan='6'>"+game["Comments"]+"</td>";
                        html += "</tr>";
                           }
                    }
                html += "</tbody>";
                html += "</table>";
            html += "</div>";
           
            html += "</div>";
                                    
            $("#"+gameContainerID+" .groupsWrapLong").append(html);
	    }
        
	    if(moneyLine['selections']['draw']['enable']=='1')
		$("#"+groupWrapID+" .trDraw").show();
	    else
		$("#"+groupWrapID+" .trDraw").hide();
	    
        if (_LINE_TYPES.indexOf("Spread") != -1) {
            updateSelection(spread['selections']['away'], $("#"+groupWrapID+" .spreadAway .selection"), oddsStyle);
            updateSelection(spread['selections']['home'], $("#"+groupWrapID+" .spreadHome .selection"), oddsStyle);
        }
        if (_LINE_TYPES.indexOf("MoneyLine") != -1) {
            updateSelection(moneyLine['selections']['away'], $("#"+groupWrapID+" .moneyLineAway .selection"), oddsStyle);
            updateSelection(moneyLine['selections']['home'], $("#"+groupWrapID+" .moneyLineHome .selection"), oddsStyle);
            updateSelection(moneyLine['selections']['draw'], $("#"+groupWrapID+" .moneyLineDraw .selection"), oddsStyle);
        }
        if (_LINE_TYPES.indexOf("Total") != -1) {
            updateSelection(total['selections']['over'], $("#"+groupWrapID+" .totalOver .selection"), oddsStyle);
            updateSelection(total['selections']['under'], $("#"+groupWrapID+" .totalUnder .selection"), oddsStyle);
        }
        if (_LINE_TYPES.indexOf("TeamTotal") != -1) {
            updateSelection(awayTotal['selections']['over'], $("#"+groupWrapID+" .teamTotalAwayOver .selection"), oddsStyle);
            updateSelection(awayTotal['selections']['under'], $("#"+groupWrapID+" .teamTotalAwayUnder .selection"), oddsStyle);
            updateSelection(homeTotal['selections']['over'], $("#"+groupWrapID+" .teamTotalHomeOver .selection"), oddsStyle);
            updateSelection(homeTotal['selections']['under'], $("#"+groupWrapID+" .teamTotalHomeUnder .selection"), oddsStyle);
        }
	    
	    groupOpen=false;
	}
    }
     
    //removing old groups
    var groupsHtml=$("#"+gameContainerID+" .groupsWrapLong .group");
    for(var i=0; i<groupsHtml.length; i++){
	var groupHtml=groupsHtml.eq(i);
	if(typeof(groupWrapIDs[groupHtml.attr("id")])=='undefined')
	    groupHtml.remove();
    }
}

function updateSelectedGame(){
    if(selectedGameNum!=null){
	var game=getGame(selectedGameNum);
    if (!isIsset(game))
        return;
    
	var gameContainerID="game_"+selectedGameNum;
	
	if($("#"+gameContainerID).length==0){
	    $("#gameWrapLong").html(	"<div id='"+gameContainerID+"'>"+
					    "<table class='gameHeader margin-bottom border'>"+
						"<tr class='border-bottom'>"+
						    "<td class='backButtonTd border-right'>"+
							"<center>"+
							    "<div class='backButtonWrap'>"+
								"<button type='button' class='btn btn-danger get-back-button'>"+(getTextJs == null || getTextJs['sportbook_game_Back'] == null ? "" : getTextJs['sportbook_game_Back'])+"</button>"+
							    "</div>"+
							"</center>"+
						    "<td>"+
							"<center>"+
							    "<table>"+
								"<tr>"+
								    "<td class='imageTd hidden-xs hidden-sm hidden-md'>&nbsp;"+
                                    //"    <img class='teamImage' src='/images/team1.gif' alt=''/>" +
                                    "</td>"+
								    "<td class='teamsTd teamHome h4'>"+game['TeamHomeID']+"</td>"+
								    "<td class='versus'>vs</td>"+
								    "<td class='teamsTd teamAway h4'>"+game['TeamAwayID']+"</td>"+
								    "<td class='imageTd hidden-xs hidden-sm hidden-md'>&nbsp;"+
                                    //"    <img class='teamImage' src='/images/team2.gif' alt=''/>"+
                                    "</td>"+
								"</tr>"+
							    "</table>"+
							"</center>"+
						    "</td>"+
						"</tr>"+
						"<tr>"+
						    "<td colspan='8' class='dateTd'>"+
							 timeStampToDateFormat(game['GameDateTimestamp'])+" "+timeStampToTimeFormat(game['GameDateTimestamp'])+
						    "</td>"+
						"</tr>"+
					    "</table>"+
					    "<div class='mainBetsWrap toggleContainersParent'>"+
						"<div class='groupTitle' style='height: 25px'>"+
                            (getTextJs == null || getTextJs['sportbook_game_MainBets'] == null ? "" : getTextJs['sportbook_game_MainBets'])+
						    "<div class='toggleContainers'>"+
							"<div class='openAll'><button type='button' class='btn btn btn-success' onclick='masiveOpenContainers(this)'>"+(getTextJs == null || getTextJs['sportbook_game_OpenAll'] == null ? "" : getTextJs['sportbook_game_OpenAll'])+"</button></div>"+
							"<div class='closeAll secret'><button type='button' class='btn btn btn-danger' onclick='masiveCloseContainers(this)'>"+(getTextJs == null || getTextJs['sportbook_game_CloseAll'] == null ? "" : getTextJs['sportbook_game_CloseAll'])+"</button></div>"+
						    "</div>"+
						"</div>"+
						"<div class='groupsWrapLong sort'></div>"+
					    "</div>"+
					    "<div id='propsGroupsWrapLong'></div>"+
					"</div>");
	}
	var oddsStyle=getOddsStyle();
	addMainBetsGroups(gameContainerID, game, oddsStyle);
    
	addPropsGroupsShort('propsGroupsWrapLong', game, oddsStyle);
    }
}