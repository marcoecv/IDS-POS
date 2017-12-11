function getGameDenyErrorsHookup(selectionsInfo){
    var errors=new Array();
    for(var i in selectionsInfo){
	var selectionInfo=selectionsInfo[i];
	
	if(selectionInfo==null)
	    continue;
	
	var selection=selectionInfo['selection'];
	var game=selectionInfo['game'];
	
	if(game['ParlayRestriction']=='D')
	    errors.push([selection['id']]);
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
	
	var selection=selectionInfo['selection'];
	var game=selectionInfo['game'];
	var gameNum=game['GameNum'];
	
	if(game['ParlayRestriction']=='S'){
	    if(typeof(groupedSelections[gameNum]))
		groupedSelections[gameNum]=new Array();
	    groupedSelections[gameNum].push(selection['id']);
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
	
	var selection=selectionInfo['selection'];
	var bet=selectionInfo['bet'];
	var game=selectionInfo['game'];
	
	if(selection['betType']=='E')
	    errors.push([selection['id']]);
	
	if(game['SportType']=='Hockey' && bet['PeriodNumber']!='0')
	    errors.push([selection['id']]);
	
	if(parseInt(bet['PeriodNumber'])>=3)
	    errors.push([selection['id']]);
	
	if(selection["betType"]=="S" || selection["betType"]=="L"){
	    var threshold=parseFloat(selection["threshold"]);
	    if(Math.abs(myRound(threshold%1, 2))==0.25 || Math.abs(myRound(threshold%1, 2))==0.75)
		errors.push([selection['id']]);
	}
	
	if(!selection["isMainBet"])
	    errors.push([selection['id']]);
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
	    
	    var game1=selectionInfo1['game'];
	    var game2=selectionInfo2['game'];
	    
	    var bet1=selectionInfo1['bet'];
	    var bet2=selectionInfo2['bet'];
	    
	    var selection1=selectionInfo1['selection'];
	    var selection2=selectionInfo2['selection'];
	    
	    var combinationID1=game1["SportType"]+"_"+selection1["betType"]+"_"+bet1["PeriodNumber"]+"_"+selection2["betType"]+"_"+bet2["PeriodNumber"];
	    var combinationID2=game2["SportType"]+"_"+selection2["betType"]+"_"+bet2["PeriodNumber"]+"_"+selection1["betType"]+"_"+bet1["PeriodNumber"];
	
	    var ids1=selection1['id']+"_"+selection2['id'];
	    var ids2=selection2['id']+"_"+selection1['id'];
	
	    if(typeof(errorTmp[ids1])=='undefined' && typeof(errorTmp[ids2])=='undefined'){
		if(game1['GameNum']==game2['GameNum'] && typeof(sameGameAllows[combinationID1])=='undefined' && typeof(sameGameAllows[combinationID2])=='undefined'){
		    errorTmp[ids1]=true;
		    errors.push([selection1['id'], selection2['id']]);
		}
	    
		if(game1['SportType']==game2['SportType'] && typeof(sameSportAllows[combinationID1])=='undefined' && typeof(sameSportAllows[combinationID2])=='undefined'){
		    errorTmp[ids1]=true;
		    errors.push([selection1['id'], selection2['id']]);
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
	    
	    var game1=selectionInfo1['game'];
	    var game2=selectionInfo2['game'];
	    
	    var bet1=selectionInfo1['bet'];
	    var bet2=selectionInfo2['bet'];
	    
	    var selection1=selectionInfo1['selection'];
	    var selection2=selectionInfo2['selection'];
	    
	    var combinationID1=game1["SportType"]+"_"+selection1["betType"]+"_"+bet1["PeriodNumber"]+"_"+selection2["betType"]+"_"+bet2["PeriodNumber"];
	    var combinationID2=game2["SportType"]+"_"+selection2["betType"]+"_"+bet2["PeriodNumber"]+"_"+selection1["betType"]+"_"+bet1["PeriodNumber"];
	
	    var ids1=selection1['id']+"_"+selection2['id'];
	    var ids2=selection2['id']+"_"+selection1['id'];
	
	    if(typeof(errorTmp[ids1])=='undefined' && typeof(errorTmp[ids2])=='undefined'){
		if(game1['SportType']==game2['SportType'] && typeof(sameSportAllows[combinationID1])=='undefined' && typeof(sameSportAllows[combinationID2])=='undefined'){
		    errorTmp[ids1]=true;
		    errors.push([selection1['id'], selection2['id']]);
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
	var selection =selectionInfo['selection'];
	var bet =selectionInfo['bet'];
	if(bet['PeriodNumber']!='0')
	    errors.push([selection['id']]);
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
    return new Object();
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
	
	var selection=selectionInfo['selection'];
	var game=selectionInfo['game'];
	
	var SportSubType=game['SportSubType'].trim();
	var SportType=game['SportType'].trim();
	var betType=selection['betType'];
	
	if(typeof(teaser['SportTypes'][SportType])=='undefined' || 
	    typeof(teaser['SportTypes'][SportType][betType])=='undefined' || 
	    typeof(teaser['SportTypes'][SportType][betType][SportSubType])=='undefined' || 
	    teaser['SportTypes'][SportType][betType][SportSubType]<=0){
	    errors.push([selection['id']]);
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
	var selection=selectionInfo['selection'];
	var game=selectionInfo['game'];
	var gameNum=game['GameNum'];
	if(typeof(gamesNums[gameNum])!='undefined')
	    errors.push(selection['id']);
	gamesNums[gameNum]=true;
    }
    return errors;
}

function getTeaserSelectionsError(selectionsInfo, teaserType){
    var errors=new Object();
    var teaser=getSelectedTeaser(teaserType);
    if(teaser!=null){
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

function getSelectionsError(selectionsInfo, betslipType, teaserType){
    if(betslipType=='straight')
	return getStraightSelectionsError(selectionsInfo);
    
    if(betslipType=='parlay')
	return getParlaySelectionsError(selectionsInfo);
    
    if(betslipType=='rndrobin')
	return getParlaySelectionsError(selectionsInfo);
    
    if(betslipType=='teaser')
	return getTeaserSelectionsError(selectionsInfo, teaserType);
    
    if(betslipType=='ifbet')
	return getParlaySelectionsError(selectionsInfo);
    
    
    if(betslipType=='reverse')
	return getParlaySelectionsError(selectionsInfo);
    
    return null;
}