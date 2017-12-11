
function addMainBetsGroupsShort(containerID, game, oddsStyle){
    var groups=$.extend(true, {}, game['lines']['groups']);
    var myBets=new Object();
    var myBetIndex=0;
    for(var groupIndex in groups){
	var group=groups[groupIndex];
	var bets=group["bets"];
	
	for(var betIndex in bets)
	    bets[betIndex]['description']=group['description']+" "+bets[betIndex]['description'];
	
	var groupOrder=parseInt(group['PeriodNumber'])*100;
	
	myBets[(groupOrder+myBetIndex++)]=bets['spread'];
	myBets[(groupOrder+myBetIndex++)]=bets['moneyLine'];
	myBets[(groupOrder+myBetIndex++)]=bets['total'];
	myBets[(groupOrder+myBetIndex++)]=bets['homeTotal'];
	myBets[(groupOrder+myBetIndex++)]=bets['awayTotal'];
    }
    addGroupGameShort(containerID, containerID+"_mainBet", "Main Bets", myBets, oddsStyle);
}

function addPropsGroupsShort(containerID, game, oddsStyle){
    var groups=game['props']['groups'];
    var groupContainerIds=new Object();
    for(var groupIndex in groups){
	var group=groups[groupIndex];
	if(group['enable']=='1'){
	    var groupContainerId=sanitiazeId(containerID+"_"+groupIndex);
	    groupContainerIds[groupContainerId]=true;
	    addGroupGameShort(containerID, groupContainerId, group['description'], group['bets'], oddsStyle);
	}
    }
    
    //removing old groups
    var groupsHtml=$("#"+containerID+" .group");
    for(var i=0; i<groupsHtml.length; i++){
	var groupHtml=groupsHtml.eq(i);
	if(typeof(groupContainerIds[groupHtml.attr("id")])=='undefined')
	    groupHtml.remove();
    }
}

function addSelectionGameShort(betContainerId, selectionContainerId, selection, oddsStyle, countRows){
    var order='';
    if(selection['betType']=='L' || selection['betType']=='E'){
	if(selection['description']=='Over')
	    order='1';
	if(selection['description']=='Under')
	    order='2';
    }
    if(selection['betType']=='M' || selection['betType']=='S'){
	var game=getGame(selection['GameNum']);
	if(selection['description']==game['TeamHomeID'])
	    order='1';
	if(selection['description']=="Draw")
	    order='2';
	if(selection['description']==game['TeamAwayID'])
	    order='3';
    }
    
    if($("#"+selectionContainerId).length==0){
    var seleccionFormat = (formatThreshold(selection) != undefined ? formatThreshold(selection) : "");
        
	var html=   "<li class='addToBetslip' id='"+selectionContainerId+"' selectionid='"+selection['id']+"' order='"+order+"'>"+
			"<div class='selectionTable' "+ (countRows == 3 ? "style='height:'" : "") +">"+
			    "<div class='selectionFix'>"+
				"   <div class='selectionDesc' style='text-align: center;'>"+((seleccionFormat.charAt(0) == "U" && $.trim(selection['description']).toLowerCase() == "under") || (seleccionFormat.charAt(0) == "O" && $.trim(selection['description']).toLowerCase() == "over") ? "" : selection['description']) +"</div>"+
				"   <div class='noWrap' style='text-align: center;'>"+
				"       <span class='selectionThreshold threshold'>"+seleccionFormat+"</span>"+
				"       <span class='selectionOdds odds'>"+formatOdds(selection, oddsStyle)+"</span>"+
				"   </div>"+
			    "</div>"+
			"</div>"+
		    "</li>";
	$("#"+betContainerId+" .selectionList").append(html);
    }
    
    updateSelection(selection, $("#"+selectionContainerId), oddsStyle);
}

function addBetGameShort(groupId, betContainerId, bet, order, betOpen, oddsStyle){
    if($("#"+betContainerId).length==0){
	var html=   "<div class='table-games bet containerForMasiveToggle' id='"+betContainerId+"' order='"+order+"'>"+
			"<div data-toggle='collapse' href='#data_"+betContainerId+"' class='title "+(betOpen?"":"collapsed")+"' aria-expanded='"+(betOpen?"true":"false")+"' style='heigth:45px'>"+
			    "<div class='label'>" + bet['description']+ "</div>" +
			    "<div class='toggle-icon'></div>"+
			"</div>"+
			"<div id='data_"+betContainerId+"' class='"+(betOpen?"in":"collapse")+"'>"+
			    "<ul class='selectionList row sort'></ul>"+ (bet['Comments'] == undefined ? "" : bet['Comments']) +
			"</div>"+
		    "</div>";
	$("#"+groupId+" .betsWrap").append(html);
    }
    var selections=bet['selections'];
    
    var avalableSelections=0;
    var selectionContainerIds=new Object();
    for(var selectionindex in selections){
        var selection=selections[selectionindex];
        if(selection['enable']=='1'){
            avalableSelections++;
            var selectionContainerId=betContainerId+"_"+selection['id'];
            selectionContainerIds[selectionContainerId]=true;
            addSelectionGameShort(betContainerId, selectionContainerId, selection, oddsStyle, Object.keys(selections).length);
        }
    }
    
    var columnClass="col-xs-6";
    if(avalableSelections==3) columnClass="col-xs-4";
    if(avalableSelections>3) columnClass="col-xs-4 col-sm-3";
    
    $("#"+betContainerId+" .selectionList li")
    .removeClass("col-xs-6")
    .removeClass("col-xs-4")
    .removeClass("col-sm-3")
    .addClass(columnClass);
    
    //removing old selections
    var selectionsHtml=$("#"+betContainerId+" .selectionList li");
    for(var i=0; i<selectionsHtml.length; i++){
	var selectionHtml=selectionsHtml.eq(i);
	if(typeof(selectionContainerIds[selectionHtml.attr("id")])=='undefined')
	    selectionHtml.remove();
    }
}

function addGroupGameShort(containerId, groupContainerId, groupDesc, bets, oddsStyle){
    if($("#"+groupContainerId).length==0){
	var html=   "<div id='"+groupContainerId+"' class='group toggleContainersParent'>"+
			"<div class='groupTitle h4' style='height: 25px'>"+
			    groupDesc+
			    "<div class='toggleContainers'>"+
				"<div class='openAll'><button type='button' class='btn btn btn-success' onclick='masiveOpenContainers(this)'>Open All</button></div>"+
				"<div class='closeAll secret'><button type='button' class='btn btn btn-danger' onclick='masiveCloseContainers(this)'>Close All</button></div>"+
			    "</div>"+
			"</div>"+
			"<div class='betsWrap sort'></div>"+
		    "</div>";
	$("#"+containerId).append(html);
    }

    var betContainerIds=new Object();
    var betOpen=true;
    for(var betIndex in bets){
	var bet=bets[betIndex];
	if(bet['enable']=='1'){
	    var betContainerId=groupContainerId+"_"+betIndex;
	    betContainerIds[betContainerId]=true;
	    addBetGameShort(groupContainerId, betContainerId, bet, betIndex, betOpen, oddsStyle);
	    betOpen=false;
	}
    }

    //removing old bets
    var betsHtml=$("#"+groupContainerId+" .betsWrap .bet");
    for(var i=0; i<betsHtml.length; i++){
	var betHtml=betsHtml.eq(i);
	if(typeof(betContainerIds[betHtml.attr("id")])=='undefined')
	    betHtml.remove();
    }
}

function updateSelectedGameShort(){
    if(selectedGameNum!=null){
	var game=getGame(selectedGameNum);
    if (!isIsset(game))
        return;
    
	var gameContainerID="gameShort_"+selectedGameNum;
	
	if($("#"+gameContainerID).length==0){
	    $("#gameWrapShort").html(	"<div id='"+gameContainerID+"'>"+
					    "<table class='gameHeader margin-bottom border'>"+
						"<tr class='border-bottom'>"+
						    "<td class='backButtonTd border-right'>"+
							"<center>"+
							    "<div class='backButtonWrap'>"+
								"<button type='button' class='btn btn-danger showLines'>Back</button>"+
							    "</div>"+
							"</center>"+
						    "<td>"+
							"<center>"+
							    "<table>"+
								"<tr>"+
								    "<td class='imageTd hidden-xs hidden-sm hidden-md'>&nbsp;"+
                                    //"    <img class='teamImage' src='/images/team1.gif' alt=''/>"+
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
					    "<div id='mainBetsGroupsWrap' class='sort'></div>"+
					    "<div id='propsGroupsWrapShort' class='sort'></div>"+
					"</div>");
	}
	
	var oddsStyle=getOddsStyle();
	addMainBetsGroupsShort('mainBetsGroupsWrap', game, oddsStyle);
	addPropsGroupsShort('propsGroupsWrapShort', game, oddsStyle);
    }
}
