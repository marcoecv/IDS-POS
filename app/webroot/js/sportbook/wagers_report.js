var wagersPerPage=1;
var currentPage = 0;
var currentPending;
var currentOpenBets;
var count=0;
var listDocAccount = new Array();
var listPosDocAccount = new Array();


function getHtmlWagerGameItem(item, wager, oddsStyle){
    var selelectionType=item['WagerType'];
    var threshold=0;
    var selectionDesc="";
    var wagerTypeDesc=selelectionType;
    var betType=wager['WagerType'];
     
    var TeaserPoints=isNaN(parseFloat(item['TeaserPoints']))? 0 : Math.abs(parseFloat(item['TeaserPoints']));
    
    if(selelectionType=='S'){
	threshold=item['AdjSpread'];
	wagerTypeDesc= getTextJs['sportbook_game_Spread'];
	selectionDesc=item['ChosenTeamID'];
    }
    if(selelectionType=='M'){
	wagerTypeDesc=getTextJs['sportbook_game_MoneyLine'];
	selectionDesc=item['ChosenTeamID'];
    }
    if(selelectionType=='L'){
	threshold=item['AdjTotalPoints'];
	wagerTypeDesc=getTextJs['sportbook_game_Total']+" - "+item['ChosenTeamID'];
	selectionDesc=item['TotalPointsOU']=="U"? " Under" : " Over";
	TeaserPoints=item['TotalPointsOU']=="U"? TeaserPoints : -TeaserPoints;
    }
    if(selelectionType=='E'){
	threshold=item['AdjTotalPoints'];
	wagerTypeDesc="Team Total - "+item['ChosenTeamID'];;
	selectionDesc=item['TotalPointsOU']=="U"? " Under" : " Over";
	TeaserPoints=item['TotalPointsOU']=="U"? TeaserPoints : -TeaserPoints;
    }
    
    threshold=parseFloat(threshold)+TeaserPoints;
    
    var selection={ "betType": selelectionType, 
		    "threshold": threshold, 
		    "oddsUS": item['FinalMoney'],
		    "oddsDecimal": item['FinalDecimal'],
		    "oddsNumerator": item['FinalNumerator'],
		    "oddsDenominator": item['FinalDenominator'],
		    "enable": 1,
		    "description": ""
		    };
    
    var odds=formatOdds(selection, oddsStyle);
    threshold=formatThreshold(selection);
    
    if(betType=='T')
	odds="";
    
    return getHtmlWagerItem(item['PeriodDescription'], wagerTypeDesc, selectionDesc, threshold, odds);
}

function getHtmlWagerContestItem(item, wager, oddsStyle){
    var betType="C";
    if(item["ThresholdType"]="P")
	    betType="T";
    if(item["ThresholdType"]="S")
	    betType="S";
    
    var selection={ "betType": betType, 
		    "threshold": item['ThresholdLine'],
		    "oddsUS": item['FinalMoney'],
		    "oddsDecimal": item['FinalDecimal'],
		    "oddsNumerator": item['FinalNumerator'],
		    "oddsDenominator": item['FinalDenominator'],
		    "enable": 1,
		    "description": ""
		    };
	
    var odds=formatOdds(selection, oddsStyle);
    var threshold=formatThreshold(selection);
    
    return getHtmlWagerItem(item['ContestType2'], item['ContestDesc'], item['ContestantName'], threshold, odds);
}

function getHtmlWagerItem(PeriodDescription, wagerTypeDesc, selectionDesc, threshold, odds){
     var html=	"<div class='item border-top'>"+
		    "<div class='visible-xs'>"+
			"<div>"+PeriodDescription+" "+wagerTypeDesc+"</div>"+
			"<div>"+selectionDesc+" "+threshold+" "+odds+"</div>"+
		    "</div>"+
		    "<div class='hidden-xs'>"+
			PeriodDescription+" "+wagerTypeDesc+": "+selectionDesc+" "+threshold+" "+odds+
		    "</div>"+
		"</div>";
    return html;
}

function getHtmlItemsWager(wager, oddsStyle){
    var html="";
    for(var i in wager["wagerGameItems"]){
	var item=wager["wagerGameItems"][i];
	html+=	getHtmlWagerGameItem(item, wager, oddsStyle);
    }
    
    for(var i in wager["wagerContestItems"]){
	var item=wager["wagerContestItems"][i];
	html+=getHtmlWagerContestItem(item, wager, oddsStyle);
    }
    return html;
}

function getFullDetails(wagers, oddsStyle){
    var html="";
    if(typeof(wagers['originalWagers'])!='undefined')
	for(var i in wagers['originalWagers'])
	    html+=getHtmlWager(wagers['originalWagers'][i], oddsStyle);
    return html;
}

function countOpenSelections(wager){
    var totalOpenSelection=parseInt(wager["TotalPicks"]);
    
    for(var i in wager["wagerGameItems"])
	totalOpenSelection--;
    
    for(var i in wager["wagerContestItems"])
	totalOpenSelection--;
    
    return totalOpenSelection;
}
var getwagervalidator=0;
var getwager=1;
function getHtmlWager(wager, oddsStyle,count){
if(getwagervalidator ==wager['TicketNumber']){getwager++;}else{getwager=1;}
getwagervalidator = wager['TicketNumber'];
if(count < 5 )currentPage++;
    var html=	   (count<5 ? "<div id='p"+count+"' class=\"pagedemo _current\" style=\"\"><div class='wager panel panel-default'  >":"<div id='p"+count+"' class=\"pagedemo \" style=\"display: none;\"><div class='wager panel panel-default'  >" )+
		    "<div class='panel-heading pannel-heading-1'>"+
			"<div class='panel-title'>"+getTextJs['sportbook_wagerReport_TicketNumber']+": "+wager['TicketNumber']+"</div>"+
		    "</div>"+
		    "<div class='panel-body detailsWrap'>"+
			"<div class='details'>"+
                       
			     "<div class='date'>"+getTextJs['sportbook_wagerReport_ACCEPTED']+" : "+formatDateTimeAndDay(wager["PostedDateTime"])+"</div>"+
                             "<div class='date'>"+getTextJs['sportbook_wagerReport_WAGETTYPE']+" : "+wager["WagerType"]+"</div>"+
			     "<div class='amount'>"+getTextJs['sportbook_wagerReport_RISKTOWIN']+" : "+FixedNumbers(wager['AmountWagered'])+" / "+FixedNumbers(wager['ToWinAmount'])+"</div>"+
                             "<div class='date'>"+getTextJs['sportbook_wagerReport_SHORTDESCRIPTION']+" : "+wager["Description"]+"</div>"+                        
//                            (wager["TeaserName"] !=='' ? "<div class='type'>Teaser: "+wager["TeaserName"]+"</div>" : "")+
//                            (wager["ParlayName"] !=='' ? "<div class='type'>Parlay: "+wager["ParlayName"]+"</div>" : "")+
			  //  "<div class='items border-bottom border-left border-right'>"+getHtmlItemsWager(wager, oddsStyle)+"</div>"  +
                              "<center> <a data-toggle=\"collapse\" id='a"+count+"' data-parent=\"#accordion\" onclick='GetWagerDetail("+wager['TicketNumber']+","+count+","+getwager+", this);' href=\"#collapse"+count+"\">More information "+wager['TicketNumber']+"</a> \n\
                              <div id=\"collapse"+count+"\" class=\"panel-collapse collapse\">"+
                              "<div class=\"panel-body\">"+
                              "<div class='date' id='id_wagerdetail"+wager['TicketNumber']+"_"+count+"_"+getwager+"' ></div></div></div>"+
                              "</div></center><div class='margin-top'>"+ 
				//(showFullDetails? "<button class='btn btn-success btn-sm showDetails' type='button'>Show Details</button>": "")+
				//(showFillOpenBets? "<button class='btn btn-success btn-sm addOpenBetToBetslip' ticketnumber='"+wager['TicketNumber']+"' type='button'>Fill Open Selections</button>": "")+
			    "</div>"+
			"</div>"+
			"<div class='fullDetails secret'>"+
			   // (showFullDetails? "<button class='btn btn-primary btn-sm hideDetails margin-bottom' type='button'>hide Details</button>": "")+
			   // (showFullDetails? getFullDetails(wager, oddsStyle): "")+
			"</div>"+
		    "</div>"+
		"</div></div>";
    return html;   
}
 

function getHtmlWagers(wagers, oddsStyle){
    var html="";
    for(var i in wagers)
	html+=getHtmlWager(wagers[i], oddsStyle);
    return html;
}

function makeIndexWagers(wagers){
    var myWagers={};
    for(var i in wagers){
	var wager=wagers[i];
	var wagerId=wager['TicketNumber']+"_"+wager['WagerNumber'];
	wager['wagerId']=wagerId;
	myWagers[wagerId]=wager;
    }
    return myWagers;
}
var lastWagersLoaded=null;
function loadWagers(pending, openBets,div){
    createCookie('selectedSideCanvas', 'center', '');
    
    if (openBets == 0) {
        var url = "/Sportbook/loadWagersPendRep";
        $.ajax({
        url: url,
        dataType: "json",
        cache: true,
        data: {
                pending: pending, 
                openBets: openBets
            },
            success: function (data) {
                $("#wpr_accordion div").remove();
                var accordion=$("#wpr_accordion");
               
                $.each(data, function (key,val){
                    accordion.append(printWagers(val, pending));
                });
                $("#wagersReportWrap .overlay").fadeOut();
            }
        });
        
        var url = "/Sportbook/loadWagersPendRep";
        $.ajax({
        url: url,
        dataType: "json",
        cache: true,
        data: {
                pending: pending, 
                openBets: 1
            },
            success: function (data) {
                var accordion=$("#wpr_accordion");
               
                $.each(data, function (key,val){
                    accordion.append(printWagers(val, pending));
                });
                $("#wagersReportWrap .overlay").fadeOut();
            }
        });   
    }
    else{
        var url = "/Sportbook/loadWagersPendRep";
        $.ajax({
        url: url,
        dataType: "json",
        cache: true,
        data: {
                pending: pending, 
                openBets: openBets
            },
            success: function (data) {
                $("#wpr_accordion div").remove();
                var accordion=$("#wpr_accordion");
               
                $.each(data, function (key,val){
                    accordion.append(printWagers(val, pending));
                });
                $("#wagersReportWrap .overlay").fadeOut();
            }
        });   
    }
} 

function printWagers(wager, pending){
    
    var div="<div class='accordion-group borderedWagerDiv'>"+
                "<div  class='accordion-heading wtr_headerDiv'>"+
                    "<div class='wpr_headerWagerDiv'>"+
                    "<span>"+wager["TicketNumber"]+"_"+wager["WagerNumber"]+"</span>"+
                        "<a style='float:right' class='accordion-toggle' onclick='GetWagerDetail("+wager["TicketNumber"]+","+wager["WagerNumber"]+", this)' data-toggle='collapse' data-parent='#wpr_accordion' href='#'>"+
                            "<i id='"+wager["TicketNumber"]+"_"+wager["WagerNumber"]+"_i' class='glyphicon glyphicon-plus'></i>"+
                        "</a>"+
                    "</div>"+
                    "<div class='wpr_contentWagerDiv'>"+
                        "<div class='rightFloatDiv'>";
    //In case of parlay or RR, the descripctions are separate by 7 blank spaces
    //So we can use it as a way to split the descriptions
    var selections=wager["Description"].split("       ");
    var htmlSelections="";
    $.each(selections,function (key,val){
        if(val.trim() !== ""){
            if (pending != null && pending != undefined && pending == 0) {
                val.substring(0, val.indexOf(" ")) + parseDescriptionSign(val.substring(val.indexOf(" ")), null, null, null)
            }
            htmlSelections+="<span id='description_"+wager["TicketNumber"]+"_"+wager["WagerNumber"]+"_"+key+"'><div class='wager-description-dot btn-success'></div>"+val+"</span><br/>";
        }
    });
    div+=htmlSelections;
    var postedDate=wager["PostedDateTime"].split(" ");
    var date=postedDate[0].split("-");
    var time=postedDate[1].split(":");
    var postedDateTime=date[1]+"/"+date[2]+"/"+date[0]+" "+time[0]+":"+time[1];
    var freePlay = typeof wager["FreePlayFlag"] != "undefined" ? (wager["FreePlayFlag"] == "Y" ? "***"+getTextJs["sportbook_wagerReport_Free_Play"]+"***" : "") : "";
                    div+="</div>"+
                        "<div class='leftFloatDiv'>"+
                            "<span><b>"+getTextJs['sportbook_wagerReport_WagerType']+"</b>:&nbsp;"+(wager["WagerType"] == "I" ? "IF BET" : wager["WagerType"])+"</span><br/>"+
                            "<span><b>"+getTextJs['sportbook_wagerReport_Accepted']+"</b>:&nbsp;"+postedDateTime+"</span><br/>"+
                            "<span><b>"+getTextJs['sportbook_wagerReport_Status']+"</b>:&nbsp;"+wager["WagerStatus"]+"</span><br/>"+
                            "<span><b>"+getTextJs['sportbook_wagerReport_Risk']+"</b>:&nbsp;"+formatnumeric(wager["AmountWagered"], 2, false)+"</span>&nbsp;"+
                            "<span><b>"+getTextJs['sportbook_wagerReport_ToWin']+"</b>:&nbsp;"+formatnumeric(wager["ToWinAmount"], 2, false)+"</span><br/>"+
                            (wager["Paid"]!==""?"<span><b>"+getTextJs['sportbook_wagerReport_Paid']+"</b>:&nbsp;"+formatnumeric(wager["Paid"], 2, false)+"</span><br/>":"")+
                            "<span>"+freePlay+"</span>"+
                        "</div>"+
                    "</div>"+
                "</div>"+
                "<div id='"+wager["TicketNumber"]+"_"+wager["WagerNumber"]+"' class='accordion-body collapse in' aria-expanded='false' style='height: 0px;'>"+
            "</div>"+
        "</div>";
       
    return div;
}

function GetWagerDetail(Ticket,wager, content){
    $("#"+Ticket+"_"+wager+" div").remove();
    var accordionContainer= $(content).parent().parent().parent().find("#"+Ticket+"_"+wager);
    if(accordionContainer.attr("aria-expanded")==="false"){
        $.ajax({
            url: "/Sportbook/getWagerdetail",
            data:{
                "doc":Ticket,
                "wager":wager
            },complete: function () {
                if(accordionContainer.attr("aria-expanded")==="false"){
                    $("#"+Ticket+"_"+wager+"_i").removeClass("glyphicon glyphicon-plus");
                    $("#"+Ticket+"_"+wager+"_i").attr("class","glyphicon glyphicon-minus");
                    accordionContainer.attr("class","accordion-body collapse in");
                    accordionContainer.attr("aria-expanded","true");
                    accordionContainer.attr("style","");
                }
            },success: function (data) {
                var obj=JSON.parse(data);
                var pos = 0;
                $.each(obj["wagersdetail"],function (key,val){
                    accordionContainer.append(printWagerDetails(val, Ticket, wager, pos, accordionContainer));
                    pos++;
                });
            }
        });
    }else{
        accordionContainer.attr("class","accordion-body collapse");
        accordionContainer.attr("aria-expanded","false");
        accordionContainer.attr("style","height:0px");
        $("#"+Ticket+"_"+wager+"_i").removeClass("glyphicon glyphicon-minus");
        $("#"+Ticket+"_"+wager+"_i").attr("class","glyphicon glyphicon-plus");
    }
}

function printWagerDetails(wagerDetails, Ticket, wager, key, container){
    var gameDateTime = "";
    if (wagerDetails["GameDateTime"].indexOf('-') != -1) {
        var gameDateArray=wagerDetails["GameDateTime"].split(" ");
        var date=gameDateArray[0].split("-");
        var time=gameDateArray[1].split(":");
        gameDateTime=date[1]+"/"+date[2]+"/"+date[0]+" "+time[0]+":"+time[1];
    }
    else{
        var gameDateArray=wagerDetails["GameDateTime"].split("  ");
        var date=gameDateArray[0].split(" ");
        var time=gameDateArray[1].split(":");
        gameDateTime=date[1]+"/"+date[2]+"/"+date[0]+" "+time[0]+":"+time[1];
    }
    
    wagerDetails["Description"] = wagerDetails["Description"].split(";").join(" ");
    wagerDetails["Description"] = wagerDetails["Description"].split("  ").join(" ");
    
    var curCode = $.trim(wagerDetails["Description"].substr(0, wagerDetails["Description"].indexOf(" ")));
    
    var curTeams = $.trim(wagerDetails["Description"].substr(wagerDetails["Description"].indexOf("-") + 1));
    curTeams = $.trim(curTeams.substr(0, curTeams.indexOf(" ")));
    curTeams = curTeams.substr(curTeams.indexOf('/') + 1);
    if (curTeams.indexOf(" ") != -1) {
        curTeams = curTeams.split(" ")[1];
    }
    var headDescription = $(container).parent().parent().find("#description_" + Ticket + "_" + wager + "_" + key).html();
    
    //var description = (headDescription == undefined ? "" : headDescription);
    var description = wagerDetails["Description"];
    
    var div="<div class='accordion-inner wrt_InternalDivContent'>"+
                "<span class='separator'></span>"+
                    "<span>GameDate:&nbsp;"+gameDateTime+"</span><br/>"+
                    (description == "" ? "" : "<span>"+description+"</span><br/>");
               div+="<span>Wager Status:&nbsp;"+(wagerDetails["WinnerID"] == "" ? wagerDetails["Status"] : (wagerDetails["Outcome"] == "L" ? "Loss" : (wagerDetails["Outcome"] == "W" ? "Win" : "No Bet")))+"</span><br/>"+
                    "<span>Wager Type:&nbsp;"+(typeof wagerDetails["Type"] === "undefined" || wagerDetails["Type"] === "" ? wagerDetails["BetType"]:wagerDetails["Type"])+"</span><br/>";
            if(wagerDetails["Comments"]!==undefined)
                    div+="<span>"+getTextJs['sportbook_wagerReport_EventNotes']+":&nbsp;"+wagerDetails["Comments"]+"</span>";
                div+="</div>";
    return div;
}

var validarEntradaaccounthistoy = 0;
function printAccounHistory(data, isLast, posTicketNumber){
    var tr=$("<tr class='trReportDetail show-data'></tr>");
    var dateTime=data["TranDateTime"].split(" ");
    var date=dateTime[0].split("-");
    var time=dateTime[1].split(":");
    var transDate=date[1]+"/"+date[2]+"/"+date[0]+" "+time[0]+":"+time["1"];
    var details="";
    if(data["TranType"]==="A"||data["TranType"]==="W"||data["TranType"]==="L"||data["TranType"]==="R"){
        details="<a class='plus-sgin-wager-report' onclick='getTransactionDetails(&#39;"+data["TranType"]+"&#39;,"+data["DocumentNumber"]+"," + posTicketNumber + ")'><b><i class='glyphicon glyphicon-plus'></i></b></a>";
    }
    
    var ammount = (parseFloat(data["Credit"])>0?data["Credit"]:"-"+data["Debit"]);
    
    var td1="<td data-th='" + data["DocumentNumber"] + "' class='ahr_docNumtd one-row'>";
    td1 = td1 + "   <span class='wrap-info-title'>" + data["DocumentNumber"] + "</span>";
    td1 = td1 + "   <span class='hidden-xs hidden-sm'>" + data["DocumentNumber"] + "</span>"
    td1 = td1 + "   <div class='wrap-info wrap-info-4col'>";
    td1 = td1 + "       <a class='toggleReportDetail' href='#' is-last='" + isLast.toString() + "'>";
    td1 = td1 + "           <span class='glyphicon glyphicon-plus-sign'></span>";
    td1 = td1 + "       </a>";
    td1 = td1 + "       <span class='info-col2'>" + data["Balance"] + "</span>";
    td1 = td1 + "       <span class='info-col1'>" + ammount + "</span>";
    td1 = td1 + "   </div>";
    td1 = td1 + "</td>";
    var td2="<td class='ahr_datetd cell-data hide-data' data-th='Date'>"+transDate+"</td>";
    var td3="<td class='ahr_desctd cell-data hide-data' data-th='Description'>"+data["Description"]+"</td>";
    var td4="<td class='ahr_amounttd cell-data hide-data' data-th='Amount'>"+ammount+"</td>";
    var td5="<td class='ahr_balancetd cell-data hide-data' data-th='Balance'>"+data["Balance"]+"</td>";
    var td6="<td class='ahr_wagerDetailstd cell-data hide-data' data-th='Details'>"+details+"</td>";
    
    tr.append(td1);
    tr.append(td2);
    tr.append(td3);
    tr.append(td4);
    tr.append(td5);
    tr.append(td6);
    
    return tr;
}

function getTransactionDetails(transType,docNum){
    var posDocNumber = listPosDocAccount[docNum];
    var curPos = posDocNumber - 1;
    var tickNumberOld = getTransactionTicketNumber(listDocAccount[posDocNumber]["TranType"],listDocAccount[posDocNumber]["DocumentNumber"]);
    var posTicketNumber = 1;
    var blnEqual = true;
    while(curPos >= 0 && blnEqual){
        var TicketNumber = getTransactionTicketNumber(listDocAccount[curPos]["TranType"],listDocAccount[curPos]["DocumentNumber"]);
        if (tickNumberOld != TicketNumber) {
            blnEqual = false;
        }
        else{
            posTicketNumber++;
        }
        tickNumberOld = TicketNumber;
        curPos--;
    }
    
    
    if(transType==="W"||transType==="L"||transType==="R"){
        getTransDetails(docNum, posTicketNumber);
    }else if(transType==="A"){
        getTransWagerDetails(docNum, posTicketNumber);
    }
}

function getTransactionTicketNumber(transType, docNum){
    if(transType==="W"||transType==="L"||transType==="R"){
        return getTransTicketNumber(docNum);
    }else if(transType==="A"){
        return getTransWagerTicketNumber(docNum);
    }
}

function getTransWagerTicketNumber(docNum){
    var obj = null;
    $.ajax({
        url: "/Sportbook/getTransWagerDetails",
        type: 'POST',
        async: false,
        data: {
            "transactionID":docNum
        },success: function (data) {
            obj=JSON.parse(data);
        }
    });
    return obj["data"][0]["TicketNumber"];
}

function getTransTicketNumber(docNum){
    var obj = null;
    $.ajax({
        url: "/Sportbook/loadTransactionDetails",
        type: 'POST',
        async: false,
        data: {
            "transactionID":docNum
        },success: function (data) {
            obj=JSON.parse(data);
        }
    });
    return obj["data"][0]["TicketNumber"];
}


function getTransWagerDetails(docNum, posTicketNumber){
    $.ajax({
        url: "/Sportbook/getTransWagerDetails",
        type: 'POST',
        data: {
            "transactionID":docNum
        },success: function (data) {
            var obj=JSON.parse(data);
            $("#tdm_accordion div").remove();
            var accordion=$("#tdm_accordion");
            $.each(obj["data"], function (key,val){
                //if (val["WagerNumber"] == posTicketNumber) {
                accordion.append(printTransWagerDetails(val));
                //}
            });
            
            $("#transactionDetailsModal").modal("toggle");
        }
    });
}

function printTransWagerDetails(wager){
    var div="";
    if (wager["WagerType"] == "PARLAY") {
        if($("#"+wager["TicketNumber"]+"_"+wager["WagerNumber"]+"_rightFloatDiv").size() > 0){
            
            var htmlSelections="";                    
            if (wager["Description"].toLowerCase().indexOf("casino") != -1) {
                htmlSelections = wager["Description"];
                wagerType = "Casino";
            }
            else{
                var selections=wager["Description"].split("|");
                $.each(selections,function (key,val){
                    htmlSelections+="<span>"+val+"</span><br/>";
                });
                wagerType = wager["WagerType"];
            }
            
            $("#"+wager["TicketNumber"]+"_"+wager["WagerNumber"]+"_rightFloatDiv").append(htmlSelections);
        }
        else{
            div="<div class='accordion-group borderedWagerDiv'>"+
                "<div  class='accordion-heading wtr_headerDiv'>"+
                    "<div class='wpr_headerWagerDiv'>"+
                    "<span>"+wager["TicketNumber"]+"_"+wager["WagerNumber"]+"</span>"+
                        "<a style='float:right' class='accordion-toggle' onclick='GetWagerDetail("+wager["TicketNumber"]+","+wager["WagerNumber"]+", this)' data-toggle='collapse' data-parent='#wpr_accordion' href='#'>"+
                            "<i id='"+wager["TicketNumber"]+"_"+wager["WagerNumber"]+"_i' class='glyphicon glyphicon-plus'></i>"+
                        "</a>"+
                    "</div>"+
                    "<div class='wpr_contentWagerDiv'>"+
                        "<div class='rightFloatDiv' id='"+wager["TicketNumber"]+"_"+wager["WagerNumber"]+"_rightFloatDiv'>";
                        
            var htmlSelections="";
            var wagerType = "";
            if (wager["Description"].toLowerCase().indexOf("casino") != -1) {
                htmlSelections = wager["Description"];
            }
            else{
                var selections=wager["Description"].split("|");
                $.each(selections,function (key,val){
                    htmlSelections+="<span>"+val.substring(0, val.indexOf(" ")) + parseDescriptionSign(val.substring(val.indexOf(" ")), null, null, null)+"</span><br/>";
                });
                div+=htmlSelections;
            }
            var postedDate=wager["PostedDateTime"].substring(0,wager["PostedDateTime"].length-9)+
            wager["PostedDateTime"].substring(wager["PostedDateTime"].length-2,wager["PostedDateTime"].length);
                    div+="</div>"+
                        "<div class='leftFloatDiv'>"+
                            "<span>"+getTextJs['sportbook_wagerReport_WagerType']+":&nbsp;"+wagerType+"</span><br/>"+
                            "<span>"+getTextJs['sportbook_wagerReport_Accepted']+":&nbsp;"+postedDate+"</span><br/>"+
                            "<span>"+getTextJs['sportbook_wagerReport_Status']+":&nbsp;"+wager["WagerStatus"]+"</span><br/>"+
                            "<span>"+getTextJs['sportbook_wagerReport_Risk']+":&nbsp;"+wager["AmountWagered"]+"</span>&nbsp"+
                            "<span>"+getTextJs['sportbook_wagerReport_ToWin']+":&nbsp;"+wager["ToWinAmount"]+"</span><br/>"+
                            "<span>"+getTextJs['sportbook_wagerReport_Paid']+":&nbsp;"+wager["Paid"]+"</span>"+
                        "</div>"+
                    "</div>"+
                "</div>"+
                "<div id='"+wager["TicketNumber"]+"_"+wager["WagerNumber"]+"' class='accordion-body collapse in' aria-expanded='false' style='height: 0px;'>"+
            "</div>"+
        "</div>";   
        }
    }
    else{
        div="<div class='accordion-group borderedWagerDiv'>"+
                "<div  class='accordion-heading wtr_headerDiv'>"+
                    "<div class='wpr_headerWagerDiv'>"+
                    "<span>"+wager["TicketNumber"]+"_"+wager["WagerNumber"]+"</span>"+
                        "<a style='float:right' class='accordion-toggle' onclick='GetWagerDetail("+wager["TicketNumber"]+","+wager["WagerNumber"]+", this)' data-toggle='collapse' data-parent='#wpr_accordion' href='#'>"+
                            "<i id='"+wager["TicketNumber"]+"_"+wager["WagerNumber"]+"_i' class='glyphicon glyphicon-plus'></i>"+
                        "</a>"+
                    "</div>"+
                    "<div class='wpr_contentWagerDiv'>"+
                        "<div class='rightFloatDiv' id='"+wager["TicketNumber"]+"_"+wager["WagerNumber"]+"_rightFloatDiv'>";

        var htmlSelections="";
        var wagerType = "";
        if (wager["Description"].toLowerCase().indexOf("casino") != -1) {
            htmlSelections = wager["Description"];
            wagerType = "Casino";
        }
        else{
            var selections=wager["Description"].split("|");
            $.each(selections,function (key,val){
                htmlSelections+="<span>"+val.substring(0, val.indexOf(" ")) + parseDescriptionSign(val.substring(val.indexOf(" ")), null, null, null)+"</span><br/>";
            });
            div+=htmlSelections;
            wagerType = wager["WagerType"];
        }
        
        var postedDate=wager["PostedDateTime"].substring(0,wager["PostedDateTime"].length-9)+
            wager["PostedDateTime"].substring(wager["PostedDateTime"].length-2,wager["PostedDateTime"].length);
                    div+="</div>"+
                        "<div class='leftFloatDiv'>"+
                            "<span>Wager Type:&nbsp;"+wagerType+"</span><br/>"+
                            "<span>Accepted:&nbsp;"+postedDate+"</span><br/>"+
                            "<span>Status:&nbsp;"+wager["WagerStatus"]+"</span><br/>"+
                            "<span>Risk:&nbsp;"+wager["AmountWagered"]+"</span>&nbsp"+
                            "<span>To Win:&nbsp;"+wager["ToWinAmount"]+"</span><br/>"+
                            "<span>Paid:&nbsp;"+wager["Paid"]+"</span>"+
                        "</div>"+
                    "</div>"+
                "</div>"+
                "<div id='"+wager["TicketNumber"]+"_"+wager["WagerNumber"]+"' class='accordion-body collapse in' aria-expanded='false' style='height: 0px;'>"+
            "</div>"+
        "</div>";
    }
    
    return div;
}


function getTransDetails(docNum, posTicketNumber){
    $.ajax({
        url: "/Sportbook/loadTransactionDetails",
        type: 'POST',
        data: {
            "transactionID":docNum
        },success: function (data) {
            var obj=JSON.parse(data);
            var accordion=$("#tdm_accordion");
            $("#tdm_accordion div").remove();
            $.each(obj["data"],function (key,val){
                //if (val["WagerNumber"] == posTicketNumber) {
                accordion.append(printTransactionDetails(val));
                //}
            });
            $("#transactionDetailsModal").modal("toggle");
        }
    });
}

function printTransactionDetails(transactionDetail, posTicketNumber){
    var div="";
    
    var desc = "";
    if (transactionDetail["Description"] != "") {
        desc = transactionDetail["Description"].split("-").join(" ");
        desc = desc.replace(/\s\s+/g, " ");
        var descWords = desc.split(" ");
        
        var curCode = descWords[0];
        var curSport = descWords[1];
        var curTeams = descWords[2];
        
        desc = transactionDetail["Description"].replace(/\s\s+/g, " ");
        descWords = desc.split(" ");
        $.each(descWords,function (key,val){
            if (val.toString().toLowerCase() == "o" || val.toString().toLowerCase() == "u") {
                descWords[key] = descWords[key - 1];
                if (val.toString().toLowerCase() == "o") {
                    descWords[key - 1] = "Over";
                }
                else{
                    descWords[key - 1] = "Under";
                }
            }
        });
        desc = descWords.join(" ");
            
        if (curTeams.indexOf("/") != -1) {
            curTeams = $.trim(curTeams.substr(curTeams.indexOf("/") + 1));
            //curTeams = $.trim(curTeams.substr(0, curTeams.indexOf(" ")));
            curTeams = curTeams.substr(curTeams.indexOf('/') + 1);
            if (curTeams.indexOf(" ") != -1) {
                curTeams = curTeams.split(" ")[1];
            }
        }
        
        desc = desc.substr(0, desc.indexOf(curTeams) + curTeams.length) + parseDescriptionSign(desc.substr(desc.indexOf(curTeams) + curTeams.length), null, null, null);
    }
    
    if (transactionDetail["WagerType"] == "PARLAY") {
        if($("#"+transactionDetail["TicketNumber"]+"_"+transactionDetail["WagerNumber"]+"_rightFloatDiv").size() > 0){
            var pos = $("#"+transactionDetail["TicketNumber"]+"_"+transactionDetail["WagerNumber"]+"_rightFloatDiv span").length;
            var htmlSelections="";
            htmlSelections+="<span id='description_"+transactionDetail["TicketNumber"]+"_"+transactionDetail["WagerNumber"]+"_"+pos+"'>"+desc+"</span><br/>";
            $("#"+transactionDetail["TicketNumber"]+"_"+transactionDetail["WagerNumber"]+"_rightFloatDiv").append(htmlSelections);
        }
        else{
            div="<div class='accordion-group borderedWagerDiv'>"+
                    "<div  class='accordion-heading wtr_headerDiv'>"+
                        "<div class='wpr_headerWagerDiv'>"+
                            "<span>"+
                                transactionDetail["TicketNumber"]+"_"+transactionDetail["WagerNumber"]+
                            "</span>"+
                            "<a style='float:right' class='accordion-toggle' onclick='GetWagerDetail("+transactionDetail["TicketNumber"]+","+transactionDetail["WagerNumber"]+", this)' data-toggle='collapse' data-parent='#wpr_accordion' href='#'>" +
                            "   <i id='"+transactionDetail["TicketNumber"]+"_"+transactionDetail["WagerNumber"]+"_i' class='glyphicon glyphicon-plus'></i>" + 
                            "</a>" +
                        "</div>"+
                        "<div class='tdm_contentWagerDiv'>"+
                            "<div class='rightFloatDiv' id='"+transactionDetail["TicketNumber"]+"_"+transactionDetail["WagerNumber"]+"_rightFloatDiv'>";
            var htmlSelections="";
            htmlSelections+="<span id='description_"+transactionDetail["TicketNumber"]+"_"+transactionDetail["WagerNumber"]+"_0'>"+desc+"</span><br/>";
            div+=htmlSelections;
            var dateTime=transactionDetail["ValueDate"].split(" ");
            var date=dateTime[0].split("-");
            var time=dateTime[1].split(":");
            var transDate=date[1]+"/"+date[2]+"/"+date[0]+" "+time[0]+":"+time["1"];
                        div+="</div>"+
                            "<div class='leftFloatDiv'>"+
                                "<span>"+getTextJs['sportbook_wagerReport_WagerType']+":&nbsp;"+transactionDetail["WagerType"]+"</span><br/>"+
                                "<span>"+getTextJs['sportbook_wagerReport_Accepted']+":&nbsp;"+transDate+"</span><br/>"+
                                "<span>"+getTextJs['sportbook_wagerReport_Status']+":&nbsp;"+transactionDetail["WagerStatus"]+"</span><br/>"+
                                "<span>"+getTextJs['sportbook_wagerReport_Risk']+":&nbsp;"+transactionDetail["AmountWagered"]+"</span><br/>"+
                                "<span>"+getTextJs['sportbook_wagerReport_ToWin']+":&nbsp;"+transactionDetail["ToWinAmount"]+"</span><br/>"+
                                "<span>"+getTextJs['sportbook_wagerReport_Paid']+":&nbsp;"+transactionDetail["Paid"]+"</span><br/>"+
                            "</div>"+
                        "</div>"+
                    "</div>"+
                    "<div id='"+transactionDetail["TicketNumber"]+"_"+transactionDetail["WagerNumber"]+"' class='accordion-body collapse in' aria-expanded='false' style='height: 0px;'>"+
                "</div>"+
            "</div>";
        }
    }
    else{
        div="<div class='accordion-group borderedWagerDiv'>"+
                    "<div  class='accordion-heading wtr_headerDiv'>"+
                        "<div class='wpr_headerWagerDiv'>"+
                            "<span>"+
                                transactionDetail["TicketNumber"]+"_"+transactionDetail["WagerNumber"]+
                            "</span>"+
                            "<a style='float:right' class='accordion-toggle' onclick='GetWagerDetail("+transactionDetail["TicketNumber"]+","+transactionDetail["WagerNumber"]+", this)' data-toggle='collapse' data-parent='#wpr_accordion' href='#'>"+
                                "<i id='"+transactionDetail["TicketNumber"]+"_"+transactionDetail["WagerNumber"]+"_i' class='glyphicon glyphicon-plus'></i>"+
                            "</a>"+
                        "</div>"+
                        "<div class='tdm_contentWagerDiv'>"+
                            "<div class='rightFloatDiv' id='"+transactionDetail["TicketNumber"]+"_"+transactionDetail["WagerNumber"]+"_rightFloatDiv'>";
        var htmlSelections="";
        htmlSelections+="<span id='description_"+transactionDetail["TicketNumber"]+"_"+transactionDetail["WagerNumber"]+"_"+curTeams+"'>"+desc+"</span><br/>";
        div+=htmlSelections;
        var dateTime=transactionDetail["ValueDate"].split(" ");
        var date=dateTime[0].split("-");
        var time=dateTime[1].split(":");
        var transDate=date[1]+"/"+date[2]+"/"+date[0]+" "+time[0]+":"+time["1"];
                    div+="</div>"+
                        "<div class='leftFloatDiv'>"+
                            "<span>"+getTextJs['sportbook_wagerReport_WagerType']+":&nbsp;"+transactionDetail["WagerType"]+"</span><br/>"+
                            "<span>"+getTextJs['sportbook_wagerReport_Accepted']+":&nbsp;"+transDate+"</span><br/>"+
                            "<span>"+getTextJs['sportbook_wagerReport_Status']+":&nbsp;"+transactionDetail["WagerStatus"]+"</span><br/>"+
                            "<span>"+getTextJs['sportbook_wagerReport_Risk']+":&nbsp;"+transactionDetail["AmountWagered"]+"</span><br/>"+
                            "<span>"+getTextJs['sportbook_wagerReport_ToWin']+":&nbsp;"+transactionDetail["ToWinAmount"]+"</span><br/>"+
                            "<span>"+getTextJs['sportbook_wagerReport_Paid']+":&nbsp;"+transactionDetail["Paid"]+"</span><br/>"+
                        "</div>"+
                    "</div>"+
                "</div>"+
                "<div id='"+transactionDetail["TicketNumber"]+"_"+transactionDetail["WagerNumber"]+"' class='accordion-body collapse in' aria-expanded='false' style='height: 0px;'>"+                
            "</div>"+
        "</div>";
    }

    return div;
}


function loadAccountHistory(freeplay){
    createCookie('selectedSideCanvas', 'center', '');
    $.ajax({
	url: "/Sportbook/loadAccountHistory",
	type: 'POST',
        data: {
            "freePlay":freeplay
        },complete: function () {
            getPrevBalance();
        },success: function (data) {
            $("#ahr_Table tr").remove();
            var table=$("#ahr_Table");
            
            var obj=JSON.parse(data);
            var prevBalance=parseFloat($(".CurrentBalance").text());
            
            if (!isNaN(prevBalance) && prevBalance != 0) {
                var firstTr=$("<tr class='trReportDetail show-data'></tr>");
                var td1="<td data-th='&nbsp;' class='ahr_docNumtd one-row'>";
                td1 = td1 + "&nbsp;";
                td1 = td1 + "   <span class='hidden-xs hidden-sm'>&nbsp;</span>"
                td1 = td1 + "   <div class='wrap-info wrap-info-4col'>";
                td1 = td1 + "       <span style='width: 10%;float: right;padding-left: 10px;'>";
                td1 = td1 + "           &nbsp;";
                td1 = td1 + "       </span>";
                td1 = td1 + "       <span class='info-col2'><span id='prevBalance'></span></span>";
                td1 = td1 + "       <span class='info-col1'>&nbsp;</span>";
                td1 = td1 + "   </div>";
                td1 = td1 + "</td>";
            
                firstTr.append(td1);
                firstTr.append("<td class='ahr_datetd cell-data hide-data' data-th='"+getTextJs['sportbook_wagerReport_Date']+"'>&nbsp;</td>");
                firstTr.append("<td class='ahr_desctd cell-data hide-data' data-th='"+getTextJs['sportbook_wagerReport_Description']+"'>&nbsp;</td>");
                firstTr.append("<td class='ahr_amounttd cell-data hide-data' data-th='"+getTextJs['sportbook_wagerReport_Amount']+"'>&nbsp;</td>");
                firstTr.append("<td class='ahr_balancetd cell-data hide-data' data-th='"+getTextJs['sportbook_wagerReport_Balance']+"'><span id='prevBalance'></span></td>");
                firstTr.append("<td class='ahr_wagerDetailstd cell-data hide-data' data-th='"+getTextJs['sportbook_wagerReport_Details']+"'>&nbsp;</td>");
                table.append(firstTr);
            }
            
            var data = obj["data"];
            if (!isIsset(data)) {
                return;
            }
                data = data.reverse();
                var lastTicketNumber = "";
                var posTicketNumber = 1;
                $.each(data,function (key,val){
                    //var TicketNumber = getTransactionTicketNumber(val["TranType"],val["DocumentNumber"]);
                    listDocAccount.push({"TranType": val["TranType"], "DocumentNumber": val["DocumentNumber"]});
                    listPosDocAccount[val["DocumentNumber"]] = key;
                    
                    prevBalance+=parseFloat(val["Credit"]);
                    prevBalance-=parseFloat(val["Debit"]);
                    
                    /*if (lastTicketNumber == TicketNumber) {
                        posTicketNumber++;
                    }
                    else{
                        posTicketNumber = 1;
                    }*/
                    
                    if (key == data.length - 1) {
                        //ultimo
                        table.append(printAccounHistory(val, true, posTicketNumber));
                    }
                    else{
                        table.append(printAccounHistory(val, false, posTicketNumber));
                    }
                    
                    lastTicketNumber = 1;
                });
            
            (function() {
                    $('.toggleReportDetail').click(function(e) {
                        e.preventDefault();
                        var cellData = $(this).parents('td').parents(".trReportDetail").children(".cell-data");
                        switchClassHideData(cellData);
    
                        var glyphicon = $(this).find(".glyphicon");
                        switchGlyphicon(glyphicon);
                        
                        if ($(this).attr("is-last") == "true") {
                            var positionScroll = $(this).parents('td').parents(".trReportDetail").last().position();
                            moveScrollContentVertical($(this).parents('td').parents(".trReportDetail").parents("#ahr_tableDiv"), $(this).parents('td').parents(".trReportDetail").parents("#ahr_Table").height());
                        }
                    });
                    
                    //$('.data-agent').addClass('show-data');
    
                    
                    
                    
    
                }());
        }
    });
}

function getPrevBalance(){
    $.ajax({
        url: "/Sportbook/getAccountPrevBalance",
        success: function (data) {
            var obj=JSON.parse(data);
            var prevBalance;
            if(obj[0]===undefined)
                prevBalance=0
            else
                prevBalance=parseFloat(obj[0]["Credit"])-parseFloat(obj[0]["Debit"]);
            $("#prevBalance").text(Math.round(prevBalance * 100) / 100);
        }
    });
}

function loadweeklyBalance(){
    createCookie('selectedSideCanvas', 'center', '');
    
    var week=parseInt($("#br_dateFilter").val())-1;
    var datesArray=getPosibleDatesArray();
    var month=datesArray[week].getMonth()+1;
    var day=datesArray[week].getDate();
    var year=datesArray[week].getFullYear();
    var date=month+"/"+day+"/"+year;
    $("#br_selectedInitDate").val(date);
    $.ajax({
        url: "/Sportbook/getWeeklyBalance",
        type: 'POST',
        data: {
            "endDate":date
        },success: function (data) {
            var obj=JSON.parse(data);
            $("#br_headerTable tbody tr").remove();
            $("#br_accordion div").remove();
            if(obj["data"].length>0)
                printWeekBalance(obj["data"][0]);
            
            $("#balanceReportWrap .overlay").fadeOut(); 
        }
    });
}


function printWeekBalance(data){
    var startDay=$("#br_startDaySelector").is(":checked")?1:0;
    var tr=$("<tr class='trReportDetail show-data'></tr>");
    var total=parseFloat(data["Day0"])+
            parseFloat(data["Day1"])+
            parseFloat(data["Day2"])+
            parseFloat(data["Day3"])+
            parseFloat(data["Day4"])+
            parseFloat(data["Day5"])+
            parseFloat(data["Day6"]);
    
    var Day0,Day1,Day2,Day3,Day4,Day5,Day6;
        Day0="Monday";
        Day1="Tuesday";
        Day2="Wednesday";
        Day3="Thursday";
        Day4="Friday";
        Day5="Saturday";
        Day6="Sunday"
        
    var td="";
    if(startDay===0){
        td="<td data-th='"+Day0+"' class='cell-data show-data'>"+getBalanceTD(data["Day0"],6)+"</td>";
        td+="<td data-th='"+Day1+"' class='cell-data show-data'>"+getBalanceTD(data["Day1"],5)+"</td>";
        td+="<td data-th='"+Day2+"' class='cell-data show-data'>"+getBalanceTD(data["Day2"],4)+"</td>";
        td+="<td data-th='"+Day3+"' class='cell-data show-data'>"+getBalanceTD(data["Day3"],3)+"</td>";
        td+="<td data-th='"+Day4+"' class='cell-data show-data'>"+getBalanceTD(data["Day4"],2)+"</td>";
        td+="<td data-th='"+Day5+"' class='cell-data show-data'>"+getBalanceTD(data["Day5"],1)+"</td>";
        td+="<td data-th='"+Day6+"' class='cell-data show-data'>"+getBalanceTD(data["Day6"],0)+"</td>";
    }
    else
    {
        td="<td data-th='"+Day1+"' class='cell-data show-data'>"+getBalanceTD(data["Day0"],6)+"</td>";
        td+="<td data-th='"+Day2+"' class='cell-data show-data'>"+getBalanceTD(data["Day1"],5)+"</td>";
        td+="<td data-th='"+Day3+"' class='cell-data show-data'>"+getBalanceTD(data["Day2"],4)+"</td>";
        td+="<td data-th='"+Day4+"' class='cell-data show-data'>"+getBalanceTD(data["Day3"],3)+"</td>";
        td+="<td data-th='"+Day5+"' class='cell-data show-data'>"+getBalanceTD(data["Day4"],2)+"</td>";
        td+="<td data-th='"+Day6+"' class='cell-data show-data'>"+getBalanceTD(data["Day5"],1)+"</td>";
        td+="<td data-th='"+Day0+"' class='cell-data show-data'>"+getBalanceTD(data["Day6"],0)+"</td>";
    }
    td+="<td data-th='Total' class='cell-data show-data'>"+Math.round(total * 100) / 100+"</td>";   
    
    tr.append(td);
    
    $("#br_headerTable tbody").append(tr);
}

function getBalanceTD(dayValue,day){
    if(parseFloat(dayValue)===0.0){
        return dayValue;
    }else{
        return "<a onclick='getWagerByDay("+day+")'>"+dayValue+"</a>";
    }
}

function getWagerByDay(day){
    var date=new Date($("#br_selectedInitDate").val());
    date.setDate(date.getDate() - day);
    var month=date.getMonth()+1;
    var day = date.getDate();
    var year=date.getFullYear();
    var stringDate=year+"-"+(month<10?"0"+month:month)+"-"+day;
    $.ajax({
        url:"/Sportbook/getDailyTransactions",
        type: 'POST',
        data: {
            "date":stringDate
        },success: function (data) {
            $("#br_accordion div").remove();
            var accordion=$("#br_accordion");
            var obj=JSON.parse(data);
            $.each(obj, function (key,val){
                accordion.append(printDailyTransDet(val));
            });
        }
    });
}


function printDailyTransDet(wager){
    //GetWagerDetail1("+wager["TicketNumber"]+","+wager["WagerNumber"]+")
    var div="<div class='accordion-group borderedWagerDiv'>"+
                "<div  class='accordion-heading wtr_headerDiv'>"+
                    "<div class='wpr_headerWagerDiv'>"+
                    "<span>"+wager["TicketNumber"]+"_"+wager["WagerNumber"]+"</span>"+
                        "<a style='float:right' class='accordion-toggle' onclick='GetWagerDetail("+wager["TicketNumber"]+","+wager["WagerNumber"]+", this)' data-toggle='collapse' data-parent='#wpr_accordion' href='#"+wager["TicketNumber"]+"_"+wager["WagerNumber"]+"'>"+
                            "<i id='"+wager["TicketNumber"]+"_"+wager["WagerNumber"]+"_i' class='glyphicon glyphicon-plus'></i>"+
                        "</a>"+
                    "</div>"+
                    "<div class='wpr_contentWagerDiv' id='wpr_contentWagerDiv_"+wager["TicketNumber"]+"_"+wager["WagerNumber"]+"'>"+
                        "<div class='rightFloatDiv'>";
    
    var htmlSelections="";
    var wagerType = "";
    if (wager["Description"].toLowerCase().indexOf("casino") != -1) {
        htmlSelections = wager["Description"];
        wagerType = "Casino";
    }
    else{
        var selections=wager["Description"].split("|");
        $.each(selections,function (key,val){
            val = $.trim(val);
            htmlSelections+="<div class='wager-description-dot btn-success'></div><span>"+(val.indexOf(" ") != -1 ? val.substring(0, val.indexOf(" ")) + parseDescriptionSign(val.substring(val.indexOf(" ")), null, null, null) : val)+"</span><br/>";
        });
        wagerType = wager["Type"];
    }
    div+=htmlSelections;
                    div+="</div>"+
                        "<div class='leftFloatDiv'>"+
                            "<span>"+getTextJs['sportbook_wagerReport_WagerType']+":&nbsp;"+wagerType+"</span><br/>"+
                            "<span>"+getTextJs['sportbook_wagerReport_WonLost']+":&nbsp;"+wager["Won_Lost"]+"</span>"+
                        "</div>"+
                    "</div>"+
                "</div>"+
                "<div id='"+wager["TicketNumber"]+"_"+wager["WagerNumber"]+"' class='accordion-body collapse in' aria-expanded='false' style='height: 0px;'>"+
            "</div>"+
        "</div>";
    return div;
}


function printHeaderBalanceTable(startDay){
    var Day0=getTextJs["sportbook_wagerReport_Monday"],
        Day1=getTextJs["sportbook_wagerReport_Tuesday"],
        Day2=getTextJs["sportbook_wagerReport_Wednesday"],
        Day3=getTextJs["sportbook_wagerReport_Thursday"],
        Day4=getTextJs["sportbook_wagerReport_Friday"],
        Day5=getTextJs["sportbook_wagerReport_Saturday"],
        Day6=getTextJs["sportbook_wagerReport_Sunday"];
    var tr=$("<tr class='trReportDetail show-data'></tr>");
    var td="";
    if(startDay===0){
        td="<th class='cell-data hidden-xs hidden-sm show-data'>"+Day0+"</th>";
        td+="<th class='cell-data hidden-xs hidden-sm show-data'>"+Day1+"</th>";
        td+="<th class='cell-data hidden-xs hidden-sm show-data'>"+Day2+"</th>";
        td+="<th class='cell-data hidden-xs hidden-sm show-data'>"+Day3+"</th>";
        td+="<th class='cell-data hidden-xs hidden-sm show-data'>"+Day4+"</th>";
        td+="<th class='cell-data hidden-xs hidden-sm show-data'>"+Day5+"</th>";
        td+="<th class='cell-data hidden-xs hidden-sm show-data'>"+Day6+"</th>";
    }else{
        td="<th class='cell-data hidden-xs hidden-sm show-data'>"+Day1+"</th>";
        td+="<th class='cell-data hidden-xs hidden-sm show-data'>"+Day2+"</th>";
        td+="<th class='cell-data hidden-xs hidden-sm show-data'>"+Day3+"</th>";
        td+="<th class='cell-data hidden-xs hidden-sm show-data'>"+Day4+"</th>";
        td+="<th class='cell-data hidden-xs hidden-sm show-data'>"+Day5+"</th>";
        td+="<th class='cell-data hidden-xs hidden-sm show-data'>"+Day6+"</th>";
        td+="<th class='cell-data hidden-xs hidden-sm show-data'>"+Day0+"</th>";
    }   
    td+="<th class='cell-data hidden-xs hidden-sm show-data'>Total</th>";
    tr.append(td);
    
    $("#br_headerTable thead tr").remove();
    $("#br_headerTable thead").append(tr);
}

var tmp;
function getPosibleDatesArray(){
    var startDay=$("#br_startDaySelector").is(":checked")?1:0;
    printHeaderBalanceTable(startDay);
    var date=new Date();
    var dateArray=[];
    dateArray.push(getNextInitDay(startDay,date));
    var date2=new Date();
    getLast3InitDay(startDay,date2,dateArray);
    return dateArray;
}

function getNextInitDay(startDay,date){
    if(date.getDay()===startDay){
        return date;
    }else{
        var myNewDate = date;
        myNewDate.setDate(myNewDate.getDate() + 1);
        return getNextInitDay(startDay,new Date(myNewDate));
    }
}

function getLast3InitDay(startDay,date,acumArray){
    if(acumArray.length===4){
        return;
    }else{
        if(date.getDay()===startDay){
            acumArray.push(new Date(date));
            date.setDate(date.getDate() - 1);
            return getLast3InitDay(startDay,new Date(date),acumArray);
        }else{
            date.setDate(date.getDate() - 1);
            return getLast3InitDay(startDay,new Date(date),acumArray);
        }
    }
}

  var  flag= false;
  var superdiferencia;
$(document).ready(function(){
    $("#br_dateFilter").change(function (){
        loadweeklyBalance();
    });
    
    $("#br_startDaySelector").change(function (){
        loadweeklyBalance();
    });
    
    $("#ahr_all").click(function(){
	loadAccountHistory(0);
	$(this).siblings().removeClass("btn-success").addClass("btn-primary");
	$(this).removeClass("btn-primary").addClass("btn-success");
    });
    $("#ahr_freePlays").click(function(){
	loadAccountHistory(1);
	$(this).siblings().removeClass("btn-success").addClass("btn-primary");
	$(this).removeClass("btn-primary").addClass("btn-success");
    });
    
    $("#loadPendings").click(function(){
	loadWagers(1, 0);
	$(this).siblings().removeClass("btn-success").addClass("btn-primary");
	$(this).removeClass("btn-primary").addClass("btn-success");
    });
   
    $("#loadGraded").click(function(){
	loadWagers(0, 0);
	$(this).siblings().removeClass("btn-success").addClass("btn-primary");
	$(this).removeClass("btn-primary").addClass("btn-success");
    });
    
    $("#loadOpenBets").click(function(){
	loadWagers(1, 1);
	$(this).siblings().removeClass("btn-success").addClass("btn-primary");
	$(this).removeClass("btn-primary").addClass("btn-success");
    });
  
    $("#wagersReport .next").click(function(){
	//loadWagers(null, null, currentPending, currentPage+1, currentOpenBets);
      //  currentPage  Start    with 5
       if(currentPage>count){
       }else{
          var s = currentPage + 5;
           if(s>count){
               flag = true;
            $("#p"+(currentPage)+"").hide(1);          
        $("#p"+(currentPage-1)+"").hide(1);
        $("#p"+(currentPage-2)+"").hide(1);
        $("#p"+(currentPage-3)+"").hide(1);
        $("#p"+(currentPage-4)+"").hide(1);
         $("#p"+(currentPage-5)+"").hide(1);
        var  valorsobrante = count - currentPage;
       superdiferencia =valorsobrante;
           for(f=1;f<=valorsobrante;f++) {
                      $("#p"+(currentPage)+"").show(50);
                       $("#p"+(currentPage+f)+"").show(50);        
       }
         wagersPerPage = wagersPerPage+1;
           $("#wagersReport .page").html(wagersPerPage);
           $("#wagersReport .next").addClass("disabled"); 
           }  
        else{ 
                       flag = false;
        $("#p"+(count-1)+"").hide(1);
        $("#p"+(currentPage)+"").hide(1);
        $("#p"+(currentPage-1)+"").hide(1);
        $("#p"+(currentPage-2)+"").hide(1);
        $("#p"+(currentPage-3)+"").hide(1);
        $("#p"+(currentPage-4)+"").hide(1);
        $("#p"+(currentPage-5)+"").hide(1);

       $("#p"+(currentPage)+"").show(50);
       $("#p"+(currentPage+1)+"").show(50);
       $("#p"+(currentPage+2)+"").show(50);
       $("#p"+(currentPage+3)+"").show(50);
       $("#p"+(currentPage+4)+"").show(50);
     
        wagersPerPage = wagersPerPage+1;
        $("#wagersReport .page").html(wagersPerPage);
         currentPage = currentPage +5;
        if(currentPage>5)
	$("#wagersReport .previous").removeClass("disabled");
        else
	$("#wagersReport .previous").addClass("disabled");  
            }
       }     
    });
    $("#wagersReport .previous").click(function(){
         if(flag == true){
              $("#wagersReport .next").removeClass("disabled"); 
              for(f=0;f<=superdiferencia;f++) {
           
                    $("#p"+(currentPage+f)+"").hide(50);
       }
             superdiferencia = 0;
             if(wagersPerPage >1){
        $("#p"+(currentPage-1)+"").show(50);
        $("#p"+(currentPage-2)+"").show(50);
        $("#p"+(currentPage-3)+"").show(50);
        $("#p"+(currentPage-4)+"").show(50);
        $("#p"+(currentPage-5)+"").show(50);
              wagersPerPage = wagersPerPage-1;
           $("#wagersReport .page").html(wagersPerPage);
        }else{
           $("#wagersReport .previous").addClass("disabled");    
        }
           flag =  false ; 
         }else{
            if(wagersPerPage >1){
                 currentPage = currentPage -5;  
        $("#p"+(currentPage)+"").hide(1);
        $("#p"+(currentPage+1)+"").hide(1);
        $("#p"+(currentPage+2)+"").hide(1);
         $("#p"+(currentPage+3)+"").hide(1);
         $("#p"+(currentPage+4)+"").hide(1);
         $("#p"+(currentPage+5)+"").hide(1);
      
      $("#p"+(currentPage-1)+"").show(50);
       $("#p"+(currentPage-2)+"").show(50);
        $("#p"+(currentPage-3)+"").show(50);
         $("#p"+(currentPage-4)+"").show(50);
          $("#p"+(currentPage-5)+"").show(50);
              wagersPerPage = wagersPerPage-1;
           $("#wagersReport .page").html(wagersPerPage);
        }else{
           $("#wagersReport .previous").addClass("disabled");
            
        } 
         }
    });
});
