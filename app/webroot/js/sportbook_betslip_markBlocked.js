function markBlockedSelections(){
    var teaserType=getTeaserType();
    var selectionsInfo=new Object();
    var selectionsOnBetslip=getSelectionsOnBetslip();
    for(var selectionId in selectionsOnBetslip){
	var selectionOnBetslip=selectionsOnBetslip[selectionId];
	if(selectionOnBetslip['isOpenSelection']!='1')
	    selectionsInfo[selectionId]=getSelectionInfo(selectionId, selectionOnBetslip['isOnTicket']);
    }
    
    var htmlSelections=$(".addToBetslip");
    var betslipType=getBetslipType();
    for(var i=0; i<htmlSelections.length; i++){
	var htmlSelection=htmlSelections.eq(i);
	var selectionId=htmlSelection.attr('selectionid');
	if(typeof(selectionsInfo[selectionId])=='undefined'){
	    
	    selectionsInfo[selectionId]=getSelectionInfo(selectionId, 0);
	    
	    var errors=getSelectionsError(selectionsInfo, betslipType, teaserType);
	    //var errors={};
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
	    
	}
	else{
	    htmlSelection.removeClass("blocked");
	}
    }
}