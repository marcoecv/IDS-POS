var initMessage = false;

function changeGlobalFreePlay() {
    if ($("#globalFreePlay").is(":checked")) {
        $("#betslip .fpSelectorWrap input[name='selectionFreePlay']").attr('checked', true);
    }
    else {
        $("#betslip .fpSelectorWrap input[name='selectionFreePlay']").attr('checked', false);
    }
}

function changeGenTypeBet(object) {
    $("#txtRisk").hide();
    $("#txtWin").hide();
    $("#txtBet").hide();

    $(object).parents(".table").find("button").removeClass("btn-success");
    $(object).addClass("btn-success");

    $($(object).attr("target")).show();
}

function debugCalls(error) {
    return;
    var e = new Error();
    var stack = error.stack;
    var stacks = stack.split("@");
    var functionName = stacks[0];
    var fileInfo = stacks[1].split(":");
}


function countObject(obj) {
    var count = 0;
    for (var i in obj)
        count++;
    return count;
}
function drawSelectionOpenSelectionBetslip(selectionCookieInfo) {
    var selectionContainerId = "betslip_selection_" + selectionCookieInfo['selectionId'];
    if ($("#" + selectionContainerId).length == 0) {
        var html = "<div class='secret selection openSelection margin-bottom' id='" + selectionContainerId + "' selectionId='" + selectionCookieInfo['selectionId'] + "' order='" + selectionCookieInfo['order'] + "'>" +
            "<div class='selectionTitleTable'>" +
            "<div class='ellipsisTitle'>" +
            "Open Selection" +
            "</div>" +
            "<div class='removeFromBetslipWrap'>" +
            "<span class='glyphicon glyphicon-remove removeFromBetslip' selectionid='" + selectionCookieInfo['selectionId'] + "' aria-hidden='true'></span>" +
            "</div>" +
            "</div>" +
            "</div>";

        $("#betslip .selections").append(html);

        //$('#'+selectionContainerId).show();
        $('#' + selectionContainerId).show();

        setEvents();
    }
}
//var gamenumforticket =[];
function drawSelectionBetslip(selectionInfo, selectionCookieInfo, isFuture, oddsStyle, origen) {
    var unavailableError = false;
    var changeSelectionError = false;
    var amountError = false;
    var restWagerError = false;
    var group = selectionInfo['group'];
    var bet = selectionInfo['bet'];
    var selection = selectionInfo['selection'];
    var selectedThreshold = selectionCookieInfo['threshold'];
    var game = getGame(selection['GameNum']);
    //gamenumforticket.push(selection['ChosenTeamID'],selection['threshold'],selection['GameNum']);
    ///  gamenumforticket =   gamenumforticket.unique();
    var selectionContainerId = "betslip_selection_" + selection['id'];
    if ($("#" + selectionContainerId).length == 0) {

        var pitcherWrap = "<div class='pitcherSelectorWrap'>&nbsp;</div>";

        if (!isFuture && game['SportType'] == 'Baseball' /*&& selection['betType']=='M'*/) {
            if (typeof(selection['pitcherOptions']) != 'undefined') {
                var pitcherSelector = "";
                if (countObject(selection['pitcherOptions']) > 1) {
                    pitcherSelector += "<select class='pitcherSelector form-control' style='margin-left:33px;width:100px'>";
                    for (var i in selection['pitcherOptions']) {
                        var option = selection['pitcherOptions'][i];
                        pitcherSelector += "<option value='" + option + "'>" + option + "</option>";
                    }
                    pitcherSelector += "</select>";
                } else {
                    for (var i in selection['pitcherOptions'])
                        pitcherSelector = selection['pitcherOptions'][i] + "<input type='hidden' name='pitcherSelector' class='pitcherSelector' value='" + selection['pitcherOptions'][i] + "' />";
                }
                pitcherWrap = "<div class='pitcherSelectorWrap'>" + pitcherSelector + "</div>";
            }
        }

        var globalFreePlay = false;
        if ($("#globalFreePlay").is(":checked")) {
            globalFreePlay = true;
        }

        var linePoints = "";
        linePoints += "<div class='selectionDescWrap'>";
        linePoints += "<div class='oddsWrap'>";
        linePoints += "<div class='defaultOdds'>";
        linePoints += "<span class='threshold'></span> <span class='odds'></span>";
        linePoints += "</div>";
        linePoints += "<select class='buyPoints form-control sort' id='sele_buyPoints'></select>";
        linePoints += " </div>";
        linePoints += "</div>";

        var html = "";
        var html = "<div class='selection secret' id='" + selectionContainerId + "' selectionId='" + selection['id'] + "' order='" + selectionCookieInfo['order'] + "'>";
        html += "<div class='ifLabel secret margin-bottom'>IF</div>";
        html += "<div class='panel panel-default'  >";
        html += "<div class='panel-heading pannel-heading-2'>";
        html += "<div class='selectionTitleTable'>";
        html += "<div class='ellipsisTitle'>";
        if (!isFuture) {
            html += "<div class='floatLeft'>" + selectionInfo['group']['description'] + " <br/> " + selectionInfo['bet']['description'] + " " + selection['description'] + "</div>";
            html += "<div class='floatRight' style='margin-right:15px'>" + linePoints + "</div>";
        } else {
            if (game === null) {
                html += "<div class='floatLeft'>" +selectionInfo['game']['ContestDesc '] + "</div>";
                html += "<div class='floatRight' style='margin-right:15px'>" + linePoints + "</div>";
            }
            else {
                html += "<div class='floatLeft'>" + selectionInfo['group']['description'] + " <br/> " + selectionInfo['bet']['description'] + " " + selection['description'] + "</div>";
                html += "<div class='floatRight' style='margin-right:15px'>" + linePoints + "</div>";
            }
        }
        html += "</div>";
        html += "<div class='removeFromBetslipWrap'>";
        html += "<span class='glyphicon glyphicon-remove removeFromBetslip' selectionid='" + selection['id'] + "' aria-hidden='true'></span>";
        html += "</div>";
        html += "</div>";
        html += "</div>";
        html += "<div class='panel-body' style='padding:3px'>";
        if(selection["betType"]==="C"&&selection["isFuture"]==="1"){
            html += "<span>"+selection["description"]+"</span>";
        }else if(selection["betType"]==="C"){
            html += "<span>"+bet["ContestType3"]+"</span>";
        }else{
            html += "<span>"+selectionInfo["game"]["TeamAwayID"]+" vs "+selectionInfo["game"]["TeamHomeID"]+"</span>";
        }
        html += "<div>";
        html += "<div style='clear:both;'></div>";
        html += "</div>";
        html += "<div class='margin-bottom'></div>";

        html += "<div class='amountMenu secret'>";
        html += "<div class='table'>";
        html += "<div class='cell riskWrap' onclick='setInputToWriteSpan(&quot;risk_" + selection['id'] + "&quot;)'><label style='width:21%;'>" + getTextJs['sportbook_betslip_Risk'] + ":</label><input id='risk_" + selection['id'] + "' type='number' pattern='[0-9]*' inputmode='numeric' name='risk' value='' class='amount riskAmount' style='float: right;' /></div>";
        html += "<div class='cell winWrap' onclick='setInputToWriteSpan(&quot;win_" + selection['id'] + "&quot;)'><label style='width:21%;'>" + getTextJs['sportbook_betslip_Win'] + ":</label><input  id='win_" + selection['id'] + "' type='number' pattern='[0-9]*' inputmode='numeric' name='win' value='' readonly class='amount winAmount' style='float: right;' /></div>";
        html += "<div class='cell>" + pitcherWrap + "</div>";
        html += "</div>";
        html += "</div>";
        html += "<div class='messages'>";
        html += "<div class='secret margin-top message hightLimitMessage'>";
        html += "<span class='glyphicon glyphicon-usd' aria-hidden='true'></span> ";
        html += getTextJs['sportbook_betslip_BetAmountHasToBeUnder'] + " <span class='limit'></span><br/>(Bet:<span class='betedAmount'></span>/<span class='total'></span>)";
        html += "</div>";
        html += "<div class='secret margin-top message lowLimitMessage'>";
        html += "<span class='glyphicon glyphicon-usd' aria-hidden='true'></span> ";
        html += getTextJs['sportbook_betslip_BetAmountHasToBeOver'] + " <span class='limit'></span>";
        html += "</div>";
        html += "<div class='secret margin-top message unavailbleMessage'>";
        html += "<span class='glyphicon glyphicon-ban-circle' aria-hidden='true'></span> ";
        html += getTextJs['sportbook_betslip_SelectionUnavailable'];
        html += "</div>";
        html += "<div class='secret margin-top message ' style='display:none'>";
        html += "<span class='glyphicon glyphicon-ban-circle' aria-hidden='true'></span> ";
        html += "<span id='TransactionMessage'></span>"
        html += "</div>";
        html += "<div class='secret margin-top message changeSelectionError'>";
        html += "<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span> ";
        html += getTextJs['sportbook_betslip_SelectionChanged'];
        html += "<button class='btn btn-success btn-xs acceptChangesSelection' type='button'>Accept</button>";
        html += "</div>";
        html += "</div>";
        html += "</div>";
        html += "</div>";
        html += "</div>";
        if ($("#betslip .selections >").length > 0) {
            $("#betslip .selections >").eq(0).prepend(html);
        } else {
            $("#betslip .selections").append(html);
        }

        updateFreePlayCheck();

        $('#' + selectionContainerId + ' .selectionFreePlay').checkbox({
            buttonStyle: 'btn-base',
            buttonStyleChecked: 'btn-success',
            checkedClass: 'icon-check',
            uncheckedClass: 'icon-check-empty'
        });


        //$('#'+selectionContainerId).show();
        $('#' + selectionContainerId).show();
        setEvents();
    }

    var selectionAux = $.extend({}, selection);
    var betslipType = getBetslipType();
    if (betslipType == 'teaser' && typeof(selectionCookieInfo['thresholdTeaser']) != 'undefined')
        selectionAux['threshold'] = selectionCookieInfo['thresholdTeaser'];
    updateSelection(selectionAux, $("#" + selectionContainerId + " .defaultOdds"), oddsStyle);

    //verifirying if selection change
    var finalSelection = getFinalSelection(selectionCookieInfo, selectionInfo);

    var showBuyPoints = false;
    var optionsIDs = new Object();
    if (typeof(selection['moreOdds']) != 'undefined') {
        var buyPoints = $("#" + selectionContainerId + " .buyPoints");
        var PriceType = siteCache['customer']['PriceType'];  // A- American / F -  fractional
        if (PriceType == "A") {
            for (var i in selection['moreOdds']) {
                showBuyPoints = true;
                var selectionAux = selection['moreOdds'][i];
                selectionAux['enable'] = selection['enable'];
                selectionAux['betType'] = selection['betType'];
                selectionAux['description'] = selection['description'];

                var optionID = sanitiazeId(selectionContainerId + "_" + selectionAux['threshold']);
                optionsIDs[optionID] = true;

                if ($("#" + optionID).length == 0)
                    buyPoints.append("<option id='" + optionID + "' value='" + selectionAux['threshold'] + "'></option>");
                var selectionAuxFort = formatThreshold(selectionAux);
                selectionAuxFort = (selectionAuxFort.charAt(0) == "U" || selectionAuxFort.charAt(0) == "O" ? selectionAuxFort.slice(1) : selectionAuxFort);
                $("#" + optionID).html(selectionAuxFort + " " + formatOdds(selectionAux, oddsStyle));
                $("#" + optionID).attr("order", selectionAux['threshold']);

                if (selectionAux['threshold'] == selection['threshold'])
                    $("#" + optionID).addClass('default');
                else
                    $("#" + optionID).removeClass('default');

                if (selectionAux['threshold'] == selectedThreshold)
                    $("#" + optionID).prop('selected', true);
            }
        } else {
            for (var i in selection['moreOdds']) {
                showBuyPoints = true;
                var selectionAux = selection['moreOdds'][i];
                selectionAux['enable'] = selection['enable'];
                selectionAux['betType'] = selection['betType'];
                selectionAux['description'] = selection['description'];
                var optionID = sanitiazeId(selectionContainerId + "_" + selectionAux['threshold']);
                optionsIDs[optionID] = true;

                if ($("#" + optionID).length == 0)
                    buyPoints.append("<option id='" + optionID + "' value='" + selectionAux['threshold'] + "'></option>");

                var selectionAuxFort = formatThreshold(selectionAux);
                selectionAuxFort = (selectionAuxFort.charAt(0) == "U" || selectionAuxFort.charAt(0) == "O" ? selectionAuxFort.slice(1) : selectionAuxFort);
                $("#" + optionID).html(selectionAuxFort + " " + FixedNumbers(convertOddsToDecimal(selectionAux['oddsUS'])));
                $("#" + optionID).attr("order", selectionAux['threshold']);

                if (selectionAux['threshold'] == selection['threshold'])
                    $("#" + optionID).addClass('default');
                else
                    $("#" + optionID).removeClass('default');

                if (selectionAux['threshold'] == selectedThreshold)
                    $("#" + optionID).prop('selected', true);
            }
        }
    }

    if (typeof(selectionCookieInfo['pitcher']) != 'undefined') {
        $("#" + selectionContainerId + " .pitcherSelector").val(selectionCookieInfo['pitcher']);
    }

    //removing old options
    var optionsHtml = $("#" + selectionContainerId + " .buyPoints option");
    for (var i = 0; i < optionsHtml.length; i++) {
        var optionHtml = optionsHtml.eq(i);
        if (typeof(optionsIDs[optionHtml.attr('id')]) == 'undefined')
            optionHtml.remove();
    }

    var betslipType = getBetslipType();
    if (showBuyPoints && (betslipType == 'straight' || betslipType == 'parlay')) {
        $("#" + selectionContainerId + " .defaultOdds").hide();
        $("#" + selectionContainerId + " .buyPoints").show();
        $("#" + selectionContainerId + " .oddsWrap").addClass("buyPointsOn");
    }
    else {
        $("#" + selectionContainerId + " .defaultOdds").show();
        $("#" + selectionContainerId + " .buyPoints").hide();
        $("#" + selectionContainerId + " .oddsWrap").removeClass("buyPointsOn");
    }

    $("#" + selectionContainerId + " .winAmount").val(selectionCookieInfo['winAmount']);
    $("#" + selectionContainerId + " .riskAmount").val(selectionCookieInfo['riskAmount']);

    //verifying FP check
    var freePlayCheck = $("#" + selectionContainerId + " .fpSelectorWrap input");
    if (selectionCookieInfo['fp'] == '1' && !freePlayCheck.is(':checked'))
        freePlayCheck.click();
    if (selectionCookieInfo['fp'] != '1' && freePlayCheck.is(':checked'))
        freePlayCheck.click();

    //showing messages
    if (finalSelection['threshold'] != selectionCookieInfo['threshold'] || finalSelection['oddsUS'] != selectionCookieInfo['US']) {
        changeSelectionError = true;
        $("#" + selectionContainerId + " .messages .changeSelectionError").show();
        $("#" + selectionContainerId + " .acceptChangesWrap").show();
    }
    else {
        $("#" + selectionContainerId + " .messages .changeSelectionError").hide();
        $("#" + selectionContainerId + " .acceptChangesWrap").hide();
    }

    // Max Bet
    if (betslipType == 'straight' || betslipType == 'ifbet' || betslipType == 'reverse') {
        var limitsStraight = getLimitsStraight();
        if (limitsStraight != null && limitsStraight[selectionCookieInfo['selectionId']] != undefined)
            $("#" + selectionContainerId + " .maxbet .limit").html(limitsStraight[selectionCookieInfo['selectionId']]['high']);
    }
    else if (betslipType == 'parlay' || betslipType == 'rndrobin') {
        var limitsParlay = getLimitsParlay();
        if (limitsParlay != null)
            $("#" + selectionContainerId + " .maxbet .limit").html(limitsParlay['high']);
    }
    else if (betslipType == 'teaser') {
        var limitsTeaser = getLimitsTeaser();
        if (limitsTeaser != null)
            $("#" + selectionContainerId + " .maxbet .limit").html(limitsTeaser['high']);
    }
    else {
        $("#" + selectionContainerId + " .maxbet .limit").html("")
    }

    /*if(!isFuture && game['enable']!='1' || group['enable']!='1' || bet['enable']!='1' || selection['enable']!='1'){
     $("#"+selectionContainerId+" .messages .unavailbleMessage").show();
     unavailableError=true;
     }
     else
     $("#"+selectionContainerId+" .messages .unavailbleMessage").hide();*/


         
          

    if (betslipType == 'straight' && isNaN(parseFloat(selectionCookieInfo['riskAmount']))) {
        amountError = true;
    }

    // Restriction Wager error
    if (betslipType == 'straight' && selection['isStraight'] != 1) {
        restWagerError = true;
    }

    if ((betslipType == 'parlay' || betslipType == 'rndrobin') && selection['isParlay'] != 1) {
        restWagerError = true;
    }
    if (betslipType == 'teaser' && selection['isTeaser'] != 1) {
        restWagerError = true;
    }

    var lowLimitError = false;
    var highLimitError = false;
    var betAmount = Math.min(parseFloat(selectionCookieInfo['riskAmount']), parseFloat(selectionCookieInfo['winAmount']));
    if (betslipType == 'straight' || betslipType == 'ifbet') {
        var limits = getLimitsStraight();

        if (limits != null) {
            var selectionId = selectionCookieInfo['selectionId'];
            if (typeof(limits[selectionId]) != 'undefined') {
                if (betAmount < parseFloat(limits[selectionId]['low'])) {
                    $("#" + selectionContainerId + " .messages .lowLimitMessage .limit").html(limits[selectionId]['low']);
                    if (origen == "sportbook") $("#" + selectionContainerId + " .messages .lowLimitMessage").show();
                    else $("#" + selectionContainerId + " .messages .lowLimitMessage").hide();
                    amountError = true;
                    lowLimitError = true;
                }

                if (betAmount > parseFloat(limits[selectionId]['high'])) {
                    $("#" + selectionContainerId + " .messages .hightLimitMessage .limit").html(limits[selectionId]['high']);
                    $("#" + selectionContainerId + " .messages .hightLimitMessage .betedAmount").html(limits[selectionId]['betedAmount']);
                    $("#" + selectionContainerId + " .messages .hightLimitMessage .total").html(limits[selectionId]['total']);
                    if (origen == "sportbook") $("#" + selectionContainerId + " .messages .hightLimitMessage").show();
                    else $("#" + selectionContainerId + " .messages .hightLimitMessage").hide();
                    amountError = true;
                    highLimitError = true;
                }
            }
        }
    }
    amountError = false;
    highLimitError = false;
    if (!lowLimitError)
        $("#" + selectionContainerId + " .messages .lowLimitMessage").hide();

    if (!highLimitError)
        $("#" + selectionContainerId + " .messages .hightLimitMessage").hide();

    return {
        "unavailableError": unavailableError,
        "amountError": amountError,
        "changeSelectionError": changeSelectionError,
        "restWagerError": restWagerError
    };
}

function setInputToWrite(element) {
    focusedInput = $(element).attr("id");
    $("#numericKeyboardModal").modal("toggle");
}

function setInputToWriteSpan(elementID) {
    focusedInput = $("#" + elementID).attr("id");
    $("#numericKeyboardModal").modal("toggle");
}

function convertOddsToDecimal(OddsAmerican) {
    var conversion = 0;
    var oddsamerican = parseFloat(OddsAmerican);
    if (oddsamerican > 0) {
        //Convertir +
        conversion = (OddsAmerican / 100) + 1;
    } else {
        //Convertir -
        var positivosiempre = OddsAmerican * -1;
        conversion = (100 / positivosiempre) + 1;
    }
    return conversion;
}
function computeRiskAmount(selection, winAmount) {
    var oddsStyle = getOddsStyle();
    if (oddsStyle == ODDS_STYLE_DECIMAL) {
        var hnk = parseFloat(selection['oddsDecimal']) - 1;
        return myRound(winAmount / hnk, 2);
    }
    if (oddsStyle == ODDS_STYLE_FRACTIONAL) {
        var num = parseInt(selection['oddsNumerator']);
        var den = parseInt(selection['oddsDenominator']);
        return myRound(winAmount * den / num, 2);
    }
    if (oddsStyle == ODDS_STYLE_HONGKONG) {
        var hnk = parseFloat(selection['oddsDecimal']) - 1;
        return myRound(winAmount / hnk, 2);
    }
    if (oddsStyle == ODDS_STYLE_US) {
        var oddsUs = parseFloat(selection['oddsUS']);
        return oddsUs > 0 ? myRound(100 * winAmount / oddsUs, 2) : myRound(-oddsUs * winAmount / 100, 2);
    }
    return "";
}

function computeWinAmount(selection, riskAmount) {
    var oddsStyle = getOddsStyle();
    if (oddsStyle == ODDS_STYLE_DECIMAL) {
        var hnk = parseFloat(selection['oddsDecimal']) - 1;
        return myRound(riskAmount * hnk, 2);
    }
    if (oddsStyle == ODDS_STYLE_FRACTIONAL) {
        var num = parseInt(selection['oddsNumerator']);
        var den = parseInt(selection['oddsDenominator']);
        return myRound(riskAmount * num / den, 2);
    }
    if (oddsStyle == ODDS_STYLE_HONGKONG) {
        var hnk = parseFloat(selection['oddsDecimal']) - 1;
        return myRound(riskAmount * hnk, 2);
    }
    if (oddsStyle == ODDS_STYLE_US) {
        var oddsUs = parseFloat(selection['oddsUS']);
        return oddsUs > 0 ? myRound(oddsUs * riskAmount / 100, 2) : myRound(-100 * riskAmount / oddsUs, 2);
    }
    return "";
}

function getNextOrderSelectionOnBetSlip(selectionsOnBetslip) {
    var maxOrder = 0;
    for (var selectionId in selectionsOnBetslip) {
        var selectionOnBetslip = selectionsOnBetslip[selectionId];
        var order = parseInt(selectionOnBetslip['order'])
        if (maxOrder < order)
            maxOrder = order;
    }
    return maxOrder + 1;
}

function addOpenSelectionToBetslipClick() {
    var selectionsOnBetslip = getSelectionsOnBetslip();
    var order = getNextOrderSelectionOnBetSlip(selectionsOnBetslip);
    var selectionId = "openSelection_" + order;
    selectionsOnBetslip[selectionId] = new Object();
    selectionsOnBetslip[selectionId]['isOpenSelection'] = '1';
    selectionsOnBetslip[selectionId]['order'] = order;
    selectionsOnBetslip[selectionId]['selectionId'] = selectionId;
    saveSelectionsOnBetslip(selectionsOnBetslip);
    updateBetSlip("addBetslip");
}

function addToBetslipClick() {
    createCookie('categoriesBetslip', JSON.stringify(getLeftMenuSelectedCategories()), '');
    if (getCurrentSize() == 'xs') {
        createCookie('betslitpType', 'straight', '');
    }
    var clickedElement = $(this);
    var selectionId = clickedElement.attr('selectionid');

    var selectionsOnBetslip = getSelectionsOnBetslip();
    if (typeof(selectionsOnBetslip[selectionId]) == 'undefined' && !clickedElement.hasClass('blocked')) {
        var maxOrder = getNextOrderSelectionOnBetSlip(selectionsOnBetslip);
        var selectionInfo = getSelectionInfo(selectionId, 0);
        var selection = selectionInfo['selection'];
        var bet = selectionInfo['bet'];

        var TotalPointsOU = "";
        if (selection['betType'] == 'L' || selection['betType'] == 'E') {
            TotalPointsOU = selection['description'] == 'Over' ? 'O' : "U";
        }
        if (selection['betType'] == 'C') {
            if (selection['description'] == 'Over')
                TotalPointsOU = "Over";

            if (selection['description'] == 'Under')
                TotalPointsOU = "Under";
        }

        var choseTeam = selection['betType'] === "C" ? selection['description'] : selection['ChosenTeamID'];

        var selectionOnBetslip = makeSelectionForBetslip(maxOrder,
            selectionId,
            selection['threshold'],
            selection['oddsUS'],
            selection['oddsNumerator'],
            selection['oddsDenominator'],
            selection['oddsDecimal'],
            '0',
            '0',
            selection['GameNum'],
            selection['isMainBet'],
            selection['isFuture'],
            bet['PeriodNumber'],
            selection['betType'],
            choseTeam,
            TotalPointsOU,
            bet['ContestNum'],
            selection['ContestantNum'],
            0);

        //baseball pitcher default selection
        if (typeof(selection['pitcherOptions']) != 'undefined') {
            var customer = siteCache['customer'];
            var defaultOption = "";
            if (customer['BaseballAction'].trim() == 'Listed')
                defaultOption = 'lp';
            if (customer['BaseballAction'].trim() == 'Action')
                defaultOption = 'at';

            var initialOption = null;
            for (var i in selection['pitcherOptions']) {
                var option = selection['pitcherOptions'][i];

                if (initialOption == null)
                    initialOption = option;

                if (defaultOption == option) {
                    initialOption = option;
                    break;
                }
            }
            selectionOnBetslip['pitcher'] = initialOption;
        }

        //pre storing the selection amount acording the last user selection
        /*
         var amountUser=getLastAmountUser();
         if(typeof(amountUser['amountType'])!='undefined'){
         selectionOnBetslip['selectedAmount']=amountUser['amount'];
         selectionOnBetslip['selectedAmountType']=amountUser['amountType'];
         }
         */

        selectionsOnBetslip[selectionId] = selectionOnBetslip;

        clickedElement.showBalloon({
            position: "top center",
            contents: '<center>Added to Betslip</center>',
            offsetY: -5,
            maxLifetime: 1500,
            showDuration: 0,
            showAnimation: function (d) {
                this.fadeIn(d);
            },
            hideDuration: 500,
            hideAnimation: function (d) {
                this.fadeOut(d);
            },
            css: {
                backgroundColor: '#facc2e',
                color: 'black',
                border: 'solid 1px #2E2E2E'
            }
        });
    } else
        delete selectionsOnBetslip[selectionId];

    saveSelectionsOnBetslip(selectionsOnBetslip);
    updateBetSlip("addBetslip");

}

function makeSelectionForBetslip(order, selectionId, threshold, US, Num, Den, Dec, fp, isOpenSelection, GameNum, isMainBet, isFuture, PeriodNumber, betType, ChosenTeamID, TotalPointsOU, ContestNum, ContestantNum, isOnTicket) {
    var selectionOnBetslip = new Object();
    selectionOnBetslip['order'] = order;
    selectionOnBetslip['selectionId'] = selectionId;
    selectionOnBetslip['threshold'] = threshold;
    selectionOnBetslip['US'] = US;
    selectionOnBetslip['Num'] = Num;
    selectionOnBetslip['Den'] = Den;
    selectionOnBetslip['Dec'] = Dec;
    selectionOnBetslip['fp'] = fp;
    selectionOnBetslip['isOpenSelection'] = isOpenSelection;
    selectionOnBetslip['GameNum'] = GameNum;
    selectionOnBetslip['isMainBet'] = isMainBet;
    selectionOnBetslip['isFuture'] = isFuture;
    selectionOnBetslip['PeriodNumber'] = PeriodNumber;
    selectionOnBetslip['betType'] = betType;
    selectionOnBetslip['ChosenTeamID'] = ChosenTeamID;
    selectionOnBetslip['TotalPointsOU'] = TotalPointsOU;
    selectionOnBetslip['ContestNum'] = ContestNum;
    selectionOnBetslip['ContestantNum'] = ContestantNum;
    selectionOnBetslip['isOnTicket'] = isOnTicket;
    return selectionOnBetslip;
}

function crearBetSlip() {
    saveSelectionsOnBetslip({});
    updateBetSlip("makeBetslip");
}

var ticket = null;
function addOpenBetToBetslip() {
    $.ajax({
            url: "/Sportbook/loadTicketLines",
            dataType: "json",
            cache: false,
            data: {"TicketNumber": $(this).attr("TicketNumber")}
        })
        .done(function (data) {
            ticket = data;
            crearBetSlip();
        })
        .error(function () {
        })
        .always(function () {
            //loadingLimits=false;
        });
}

function removeFromBetSlip(selectionId) {
    var selectionsOnBetslip = getSelectionsOnBetslip();
    delete selectionsOnBetslip[selectionId];
    saveSelectionsOnBetslip(selectionsOnBetslip);
    updateBetSlip("removeBetslip");
    if (Object.keys(selectionsOnBetslip).length == 0) {
        initMessage = false;
    }
}

function removeFromBetslipClick() {
    var selectionid = $(this).attr("selectionid");
    removeFromBetSlip(selectionid);
}

function updateBetslipSelections(origen) {
    var selectionsOnBetslip = getSelectionsOnBetslip();
    //removing selections that are not in the chache.
    var selectionRemoved = false;
    for (var selectionId in selectionsOnBetslip) {
        if (selectionsOnBetslip[selectionId]['isOpenSelection'] != '1') {
            selectionOnBetslip = selectionsOnBetslip[selectionId];
            if (getSelectionInfo(selectionId, selectionOnBetslip['isOnTicket']) == null) {
                selectionRemoved = true;
                delete selectionsOnBetslip[selectionId];
            }
        }
    }
    if (selectionRemoved)
        saveSelectionsOnBetslip(selectionsOnBetslip);
    //removing selections not in the betslip
    var selectionsHtml = $("#betslip .selection");
    for (var i = 0; i < selectionsHtml.length; i++) {
        var selectionHtml = selectionsHtml.eq(i);
        if (typeof(selectionsOnBetslip[selectionHtml.attr("selectionId")]) == 'undefined')
        //selectionHtml.hide(function(){$(this).remove()});
            selectionHtml.remove();
    }

    //drawing new selections and updating currents.
    var oddsStyle = getOddsStyle();
    var unavailableError = false;
    var amountError = false;
    var changeSelectionError = false;
    var restWagerError = false;
    for (var selectionId in selectionsOnBetslip) {
        var selectionOnBetslip = selectionsOnBetslip[selectionId];
        if (selectionOnBetslip['isOpenSelection'] != '1') {
            var selectionInfo = getSelectionInfo(selectionId, selectionOnBetslip['isOnTicket']);
            var isFuture = selectionInfo['selection']['isFuture'];
            var selectionResult = drawSelectionBetslip(selectionInfo, selectionOnBetslip, isFuture, oddsStyle, origen);

            if (selectionResult['unavailableError'])
                unavailableError = true;

            if (selectionResult['amountError'])
                amountError = true;

            if (selectionResult['changeSelectionError'])
                changeSelectionError = true;

            if (selectionResult['restWagerError'])
                restWagerError = true;
        }
        else {
            drawSelectionOpenSelectionBetslip(selectionOnBetslip);
        }
    }

    return {
        "unavailableError": unavailableError,
        "amountError": amountError,
        "changeSelectionError": changeSelectionError,
        "restWagerError": restWagerError
    };
}

function countSelectionsOnBetslip() {
    var selectionsOnBetslip = getSelectionsOnBetslip();
    var count = 0;
    for (var selectionId in selectionsOnBetslip)
        count++;
    return count;
}

function countRealSelectionsOnBetslip() {
    var selectionsOnBetslip = getSelectionsOnBetslip();
    var count = 0;
    for (var selectionId in selectionsOnBetslip)
        if (selectionsOnBetslip[selectionId]['isOpenSelection'] != '1')
            count++;
    return count;
}

function getFinalOddsSelection(selection, selectionOnBetslip) {
    var selectedThreshold = selectionOnBetslip['threshold'];
    var finalSelection = null;
    if (typeof(selection['moreOdds']) != 'undefined')
        for (var threshold in selection['moreOdds'])
            if (parseFloat(threshold) == parseFloat(selectedThreshold)) {
                finalSelection = selection['moreOdds'][threshold];
                break;
            }

    if (finalSelection == null)
        finalSelection = selection;

    return finalSelection;
}

function computeBetslipSelectionsAmounts() {
    var selectionsOnBetslip = getSelectionsOnBetslip();

    var change = false;
    for (var selectionId in selectionsOnBetslip) {
        var selectionOnBetslip = selectionsOnBetslip[selectionId];

        if (selectionOnBetslip['isOpenSelection'] == '1')
            continue;

        var selectionInfo = getSelectionInfo(selectionId, selectionOnBetslip['isOnTicket']);

        var selection = selectionInfo['selection'];

        var finalSelection = getFinalOddsSelection(selection, selectionOnBetslip);

        var selectedAmount = parseFloat(selectionOnBetslip['selectedAmount']);
        var winAmount = "";
        var riskAmount = "";

        if (!isNaN(selectedAmount)) {
            var selectedAmountType = selectionOnBetslip['selectedAmountType'];

            if (selectedAmountType == 'winAmount' || (selectedAmountType == 'betAmount' && parseFloat(finalSelection['oddsUS']) < 0)) {
                winAmount = selectionOnBetslip['selectedAmount'];
                riskAmount = computeRiskAmount(finalSelection, selectedAmount);
            }
            else {
                riskAmount = selectionOnBetslip['selectedAmount'];
                winAmount = computeWinAmount(finalSelection, selectedAmount);
            }
        }

        if (selectionOnBetslip['riskAmount'] != riskAmount || selectionOnBetslip['winAmount'] != winAmount)
            change = true;

        selectionOnBetslip['riskAmount'] = riskAmount;
        selectionOnBetslip['winAmount'] = winAmount;
    }

    if (change)
        saveSelectionsOnBetslip(selectionsOnBetslip);
}

function setAllAmountsBetslip(selectedAmountType, selectedAmount) {
    var selectionsOnBetslip = getSelectionsOnBetslip();
    for (var selectionId in selectionsOnBetslip) {
        selectionsOnBetslip[selectionId]['selectedAmount'] = selectedAmount;
        selectionsOnBetslip[selectionId]['selectedAmountType'] = selectedAmountType;
    }
    saveSelectionsOnBetslip(selectionsOnBetslip);
}

function getTotalRisk() {
    var betslipType = getBetslipType();

    var risk = 0;

    if (betslipType == 'straight') {
        var selectionsOnBetslip = getSelectionsOnBetslip();
        for (var selectionId in selectionsOnBetslip)
            risk += parseFloat(selectionsOnBetslip[selectionId]['riskAmount']);
    }
    return risk;
}

function getTotalAmounts() {
    var betslipType = getBetslipType();

    var risk = 0;
    var win = 0;
    var riskFP = 0;
    var winFP = 0;

    if (betslipType == 'straight') {
        var selectionsOnBetslip = getSelectionsOnBetslip();
        for (var selectionId in selectionsOnBetslip) {
            if (selectionsOnBetslip[selectionId]['fp'] == '1') {
                riskFP += parseFloat(selectionsOnBetslip[selectionId]['riskAmount']);
                winFP += parseFloat(selectionsOnBetslip[selectionId]['winAmount']);
            }
            else {
                risk += parseFloat(selectionsOnBetslip[selectionId]['riskAmount']);
                win += parseFloat(selectionsOnBetslip[selectionId]['winAmount']);
            }
        }
    }

    if (betslipType == 'parlay') {
        risk = getGlobalRiskAmount();
        win = computeParlayToWin();
    }

    if (betslipType == 'rndrobin') {
        risk = computeRoundRobinRisk();
        win = computeRoundRobinToWin();
    }

    if (betslipType == 'teaser') {
        risk = getTeaserRisk();
        win = getTeaserWin();
    }

    if (betslipType == 'ifbet') {
        risk = getIfBetMaxRisk();
        win = getIfBetMaxRisk();
    }

    if (betslipType == 'reverse') {
        risk = getReverseMaxRisk();
        win = getReverseMaxWin();
    }

    return {'risk': risk, 'win': win, 'riskFP': riskFP, 'winFP': winFP};
}

function compareLimitsWithBetslip(limits, selectionsOnBetslip) {
    if (limits == null)
        return false;

    var limitStraight = getLimitsStraightAux(limits);
    if (limitStraight == null)
        return false;

    for (var selectionID in selectionsOnBetslip) {
        if (typeof(limitStraight[selectionID]) == 'undefined')
            return false;
    }

    for (var selectionID in limitStraight)
        if (typeof(selectionsOnBetslip[selectionID]) == 'undefined')
            return false;

    var limitRoundRobin = getLimitsRoundRobinAux(limits);
    if (limitRoundRobin == null)
        return false;
    if (limitRoundRobin['roundRobinType'] != getRoundRobinType())
        return false

    return true;
}

function limitsUpToDate() {
    if (countSelectionsOnBetslip() == 0)
        return true;
    var selectionsOnBetslip = getSelectionsOnBetslip();
    if (compareLimitsWithBetslip(limitsCache, selectionsOnBetslip))
        return true;

    return false;
}

function getSaldo() {

    var parametros = {
        customer: $('#sp_CustomerID').val()
    }

    $.ajax({
        url: "/sportbook/getAvaliableAjax",
        type: 'post',
        data: parametros,
        dataType: "json",
        success: function (data) {


            $('#betBalance').text(data.Available.toFixed(2));
            return data.Available;

        }
    })

}

function removeOldCacheLimits() {
    var now = new Date().getTime() / 1000;
    for (var time in limitsCacheHistory)
        if (now - time > 60)
            delete limitsCacheHistory[time];
}

function seachLimitInCache() {
    removeOldCacheLimits();

    var selectionsOnBetslip = getSelectionsOnBetslip();
    for (var time in limitsCacheHistory)
        if (compareLimitsWithBetslip(limitsCacheHistory[time], selectionsOnBetslip))
            return limitsCacheHistory[time];
    return null;
}

function loadSelectionLimitsForced() {
    loadingLimits = false;
    limitsCache = null;
    loadSelectionLimits();
}

var limitsCacheHistory = new Object();
var limitsCache;
var loadingLimits = false;
function loadSelectionLimits() {
    if (!limitsUpToDate()) {
        var limitCacheHistory = seachLimitInCache();
        if (limitCacheHistory != null) {
            limitsCache = limitCacheHistory;
            updateBetSlip("loadLimits");
        }
        else {
            if (!loadingLimits) {
                loadingLimits = true;
                limitsCache = null;
                $.ajax({
                        url: "/Sportbook/getselectionslimits",
                        dataType: "json",
                        cache: false,
                        method: "POST",
                        data: {selectionsOnBetslip: JSON.stringify(_SELECTIONS_ON_BETSLIP),fullcustomerAgent: $("#sp_CustomerID").val()}
                    })
                    .done(function (data) {
                        loadingLimits = false;
                        limitsCache = data;

                        var now = new Date().getTime() / 1000;
                        limitsCacheHistory[now] = data;

                        if (limitsUpToDate())
                            updateBetSlip("loadLimits");
                        else {
                            loadSelectionLimits();
                        }
                    })
                    .error(function () {
                    })
                    .always(function () {
                        //loadingLimits=false;
                    });
            }
        }
    }
}

function updateFreePlayCheck() {
    var customer = siteCache['customer'];
    var FreePlayBalance = parseFloat(customer['FreePlayBalance']);

    var betslipType = getBetslipType();

    if (FreePlayBalance <= 0 || betslipType != "straight") {
        $("#betslip .maxAmounts .maxRiskWrap").css("width", "100%");
        $("#betslip .maxAmounts .maxToWinWrap").css("width", "100%");
        $("#betslip .teaserAmounts .maxRiskWrap").css("width", "50%");
        $("#betslip .teaserAmounts .maxToWinWrap").css("width", "50%");

        $("#betslip .globalFreePlayWrap").hide();
        $("#betslip .fpSelectorWrap").hide();
        $("#betslip .amountMenu .amount").css("width", "74%");
        $("#betslip .selection .selectionDescWrap .oddsWrap").css("width", "30.5%");
    }
    else {
        $("#betslip .maxAmounts .maxRiskWrap").css("width", "100%");
        $("#betslip .maxAmounts .maxToWinWrap").css("width", "100%");
        $("#betslip .teaserAmounts .maxRiskWrap").css("width", "43.5%");
        $("#betslip .teaserAmounts .maxToWinWrap").css("width", "43.5%");

        $("#betslip .globalFreePlayWrap").show();
        if ($("#betslip .fpSelectorWrap").css("visibility") != "hidden") {
            $("#betslip .fpSelectorWrap").show();
            $("#betslip .amountMenu .amount").css("width", "60%");
            $("#betslip .selection .selectionDescWrap .oddsWrap").css("width", "45%");
        }
        else {
            $("#betslip .fpSelectorWrap").hide();
            $("#betslip .amountMenu .amount").css("width", "74%");
            $("#betslip .selection .selectionDescWrap .oddsWrap").css("width", "30%");
        }
    }

    if (FreePlayBalance <= 0) {
        if (getFreePlayChecked() == '1')
            saveFreePlayChecked('0');

        var save = false;
        var selectionsOnBetslip = getSelectionsOnBetslip();
        for (var selectionId in selectionsOnBetslip) {
            if (selectionsOnBetslip[selectionId]['fp'] == '1') {
                selectionsOnBetslip[selectionId]['fp'] = 0;
                save = true;
            }
        }
        if (save)
            saveSelectionsOnBetslip(selectionsOnBetslip);
    }

    var freePlayCheck = $("#betslip .globalFreePlayWrap input");
    if (getFreePlayChecked() == '1' && !freePlayCheck.is(':checked'))
        freePlayCheck.click();
    else if (getFreePlayChecked() != '1' && freePlayCheck.is(':checked'))
        freePlayCheck.click();
}
function printTicket(data, tickettype) {
    var params = JSON.stringify(data);
    var params = params.replace(/\+/g, "%2B");
    var left = (screen.width / 2) - (450 / 2);
    var top = (screen.height / 2) - (700 / 2);
    var w = window.open("/Printview/index?params=" + encodeURI(params) + "&type=" + tickettype, "", "width=450,height=700, top=" + top + ", left=" + left);

}

function showTicketModal(ticket) {
    if (getCurrentSize() == 'xs') {
        createCookie('betslitpType', 'straight', '');
    }
    $("#betslipModal .modal-title").html("Ticket Number: " + ticket['ticketNumber']);

    var selectionsHTML = "";

    for (var sel in ticket['items']) {
        ticket['items'][sel]['index'] = parseInt(sel) + 1;
        selectionsHTML += getSelectionHTML(ticket['items'][sel], ticket['type']);
    }

    var eachParlayAmount = "";

    if (typeof ticket['eachParlayAmount'] !== 'undefined') {
        eachParlayAmount = '<span class="selectionDesc"> Amount Per Parlay: ' + ticket['eachParlayAmount'] + '</span><br>';
    }

    //Create global risk and win label
    var riskWinGlobalHTML = '<center class="winRiskCenter border-bottom"><b>' +
        eachParlayAmount +
        '<span class="selectionDesc"> Total Risk ' + ticket['globalRisk'] + '  To   Win  ' + ticket['globalWin'] + '</span>' +
        '</b></center>';
    riskWinGlobalHTML = ticket['globalRisk'] == "" || ticket['globalWin'] == "" ? "" : riskWinGlobalHTML;

    //Create main modal body
    var mainHTML = '<div class="ticket border-left border-right">' +
        '<div class="wager border-bottom">' +
        '<div class="betType">' +
        '<center>' + ticket['title'] + '</center>' +
        '</div>' +
        '</div>' +
        '<div class="selections-container">' +
        selectionsHTML +
        '</div>' +
        riskWinGlobalHTML +
        '</div>';
    $('#betslipModal .modal-body').html(mainHTML);
    $('#betslipModal').modal();
}

function getSelectionHTML(selection, betType) {

    if (selection['isOpenSelection'] == "0") {
        selection['baseballPitchers'] = selection['baseballPitchers'] != "" ? selection['baseballPitchers'] + "<br>" : "";
        var winRiskLabel = betType === "parlay" ? '' : 'Risk ' + selection['risk'] + ' to Win ' + selection['win'] + '<br>';
        winRiskLabel = betType === "roundrobin" ? '' : winRiskLabel;
        winRiskLabel = betType === "teaser" ? '' : winRiskLabel;
        winRiskLabel = betType === "reverse" ? '' : winRiskLabel;
        var freePlayDesc = selection.freePlay == '1' ? "*** FREE PLAY ***<br>" : "";
        selection['sportDescription'] = selection['sportDescription'].trim() !== "" ? selection['sportDescription'] + "<br>" : "";
        selection['chosenTeam'] = selection['chosenTeam'].trim() !== "" ? selection['chosenTeam'] + "<br>" : "";

        var pointsLabel = selection.points == "" ? "" : selection.points + "<br>";
        var matchUp = selection.matchUp == "" ? "" : selection.matchUp + "<br>";

        return '<div class="item border-bottom center">' +
            '<div class="gameDesc"><b>Selection #' + selection['index'] + '</b></div>' +
            '<div class="betDesc">' +
            selection['sportDescription'] +
            matchUp +
            selection['chosenTeam'] +
            selection['line'] + '<br>' +
            pointsLabel +
            selection['baseballPitchers'] +
            winRiskLabel +
            'Game Date: ' + selection['gameDate'] + ' (EST)<br>' +
            freePlayDesc +
            '</div>' +
            '</div>';
    } else {
        return '<div class="item border-bottom center">' +
            '<div class="gameDesc"><b>Selection #' + selection['index'] + '</b></div>' +
            '<div class="betDesc">' +
            'Open Selection' +
            '</div>' +
            '</div>';
    }
}

function getDelay(callback) {
    $.ajax({
            url: "/Sportbook/getdelay",
            dataType: "json",
            cache: false
        })
        .done(function (data) {
            callback(data["delay"]);
        })
        .error(function () {

        })
        .always(function () {
        });
}

function animateProgressBarBetslipAux(start, end) {
    var now = new Date().getTime();
    if (now < end) {
        var width = Math.round(100 * (now - start) / (end - start));
        $("#betslip #placeBetWrap #placebetBar .progress-bar").width(width + "%");
        $("#betslip #placeBetWrapFull #placebetBarFull .progress-bar").width(width + "%");
        setTimeout(function () {
            animateProgressBarBetslipAux(start, end);
        }, 100);
    }
    else {
        $("#betslip #placeBetWrap #placebetBar .progress-bar").width("100%");
        $("#betslip #placeBetWrapFull #placebetBarFull .progress-bar").width("100%");
    }
}

function animateProgressBarBetslip(delay) {
    var start = new Date().getTime();
    var end = start + delay * 1000;
    animateProgressBarBetslipAux(start, end);

}
function formatDateTimeAndDay(fecha) {

    var dateString = fecha.split(".");
    var week = {0: 'Mon', 1: 'Tue', 2: 'Wed', 3: 'Thu', 4: 'Fri', 5: 'Sat', 6: 'Sun'};
    var reggie = /(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/;
    var dateArray = reggie.exec(dateString[0]);
    if (isDataIsset(dateArray)) {
        var date = new Date(
            (+dateArray[1]),
            (+dateArray[2] - 1),
            (+dateArray[3]),
            (+dateArray[4]),
            (+dateArray[5]),
            (+dateArray[6])
        );
        var h = date.getHours() > 12 ? date.getHours() - 12 : date.getHours();
        h = h < 10 ? '0' + h : h;
        var m = date.getMinutes() < 10 ? '0' + date.getMinutes() : date.getMinutes();
        var ap = date.getHours() >= 12 ? 'pm' : 'am';
        return (date.getMonth() + 1) + '/' + date.getDate() + '/' + date.getFullYear() + ' ' + h + ':' + m + '' + ap + ' ' + week[(date.getDay() - 1)];
    }
    return fecha;
}
function formatDateAndDay(fecha) {

    var dateString = fecha.split(".");
    var week = {0: 'Mon', 1: 'Tue', 2: 'Wed', 3: 'Thu', 4: 'Fri', 5: 'Sat', 6: 'Sun'};
    var reggie = /(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/;
    var dateArray = reggie.exec(dateString[0]);
    if (isDataIsset(dateArray)) {
        var date = new Date(
            (+dateArray[1]),
            (+dateArray[2] - 1),
            (+dateArray[3]),
            (+dateArray[4]),
            (+dateArray[5]),
            (+dateArray[6])
        );
        var h = date.getHours() > 12 ? date.getHours() - 12 : date.getHours();
        h = h < 10 ? '0' + h : h;
        var m = date.getMinutes() < 10 ? '0' + date.getMinutes() : date.getMinutes();
        var ap = date.getHours() >= 12 ? 'pm' : 'am';
        return (date.getMonth() + 1) + '/' + date.getDate() + '/' + date.getFullYear();
    }
    return fecha;
}
function isDataIsset(data) {
    data = $.trim(data);
    if (data == '' || data == undefined || data == 'undefined' || data == null || data == 'null') {
        return false;
    }
    return true;
}
function getMaxBetAmount(){
    var maxBet=0;
    $.each(_SELECTIONS_ON_BETSLIP,function (key,val){
        maxBet+=parseFloat(val["riskAmount"]);
    });
    return maxBet;
}

//var betting=false;
function placebet(points) {
    var balance=parseFloat($("#betBalance").text());
    if(balance<getMaxBetAmount()){
        alert("Disponible Insuficiente")
    }else{
        //if(!betting){
        getDelay(function (delay) {
            animateProgressBarBetslip(delay);

            //betting=true;

            updateBetSlip("placeBet");

            var blnShowMessages = false;
            $('#betslip .message').each(function () {
                if ($(this).attr("style") == "display: block;") {
                    blnShowMessages = true;
                }
            });
            if (blnShowMessages) {
                $("#betslip .globalMessages").show();
            }
            else {
                $("#betslip .globalMessages").hide();
            }

            var blnShowGlobalMessages = false;
            $(".globalMessages .message").each(function () {
                if ($(this).attr("style") == "display: block;") {
                    blnShowGlobalMessages = true;
                }
            });


            if (!blnShowGlobalMessages && !blnShowMessages) {
                $("#placeBet").button('loading');

                var isFreePlay = getFreePlayChecked();
                createCookie('isFreePlay', (getFreePlayChecked() == "1" ? "Y" : "N"), "");

                //getFreePlayChecked()

                $.ajax({
                        url: "/Sportbook/placebet",
                        dataType: "json",
                        cache: false,
                        method: "POST",
                        data: {
                            selectionsOnBetslip: JSON.stringify(_SELECTIONS_ON_BETSLIP),
                            fullcustomerAgent: $("#sp_CustomerID").val()
                        }
                    })
                    .done(function (data) {
                        $("input[name='win']").val("");
                        $("input[name='risk']").val("");
                        $("#txtBet").val("");
                        $("#txtRisk").val("");
                        $("#txtWin").val("");
                        $("#betslip .maxToWin").html("");
                        $("#betslip .place").html("");
                        createCookie('globalRiskAmount', '', '');
                        createCookie('teaserType', '', '');
                        createCookie('teaserAmount', '', '');
                        createCookie('reverseAmount', '', '');
                        createCookie('freePlayChecked', '0', '');
                        saveContinueOnPushFlag("N");

                        limitsCacheHistory = new Object();//clear limts cache after placebet
                        $("#betslip .serverMessages .messages .message").hide().remove();
                        var sels = data['sels'];
                        var arr = [];
                        $.each(data, function (key, val) {
                            if (val['status'] === '1') {
                                saveSelectionsOnBetslip(new Object());
                                updateBetSlip("placeBet");
                                $("#txtBet").val("");
                                arr.push(val["ticket"]);
    //                            showTicketModal(data['ticket']);
                            }else{
                                var hasServerMessages = false;

                                for (var i in val['messages']) {
                                    hasServerMessages = true;
                                    var message = val['messages'][i];
                                    var bettype;
                                    if(val["1"]==="S"){
                                        bettype="Spread";
                                    }else if(val["1"]==="L"){
                                        bettype="Total";
                                    }else if (val["1"==="E"]){
                                        bettype="Team Total";
                                    }else{
                                        bettype="MoneyLine";
                                    }
                                    $("#betslip .serverMessages .messages").append("<div class='margin-top message serverMessage'>" +
                                        "<span aria-hidden='true'></span> " + message +" "+val["0"]+" "+bettype+
                                        "</div>");
                                }
                                if (hasServerMessages) {
                                    $("#betslip .serverMessages").show();
                                    setTimeout(function () {
                                        $("#betslip .serverMessages").hide();
                                    }, 150000);
                                }
                                else
                                    $("#betslip .serverMessages").hide();


                                //removing current limits to force reload.
                                var selectionsOnBetslip = getSelectionsOnBetslip();
                                for (var selectionId in selectionsOnBetslip) {
                                    delete selectionsOnBetslip[selectionId]['lowLimit'];
                                    delete selectionsOnBetslip[selectionId]['hightLimit'];
                                }
                                saveSelectionsOnBetslip(selectionsOnBetslip);

                                //loadSelectionLimitsForced();
                                loadFullGamesData(function () {
                                    updateDom();
                                });
                            }
                        });
                        if (arr.length > 0) {
                            var ticketType;
                            if ($("#sp_CustomerID").val().toUpperCase() === $("#sp_AuthCustomerID").val().toUpperCase())
                                ticketType = 1;
                            else
                                ticketType = 2;

                            printTicket(arr, ticketType);
                        }
                        getSaldo();
                        deleteSiteCacheLines();
                        $("#groupsWrapLong > div").remove();
                        $("#gameWrapLong > div").remove();
                    })
                    .error(function () {
                        loadFullGamesData(function () {
                            updateDom();
                        });
                    })
                    .always(function () {
                        limitsCache = null;
                        limitsCacheHistory = new Object();//clear limts cache after placebet
                        //betting=false;
                        setTimeout(function () {
                            //$("#betslip #placeBetWrap #placeBet").show();
                            //$("#betslip #placeBetWrap #placebetBar").hide();

                            //$("#betslip #placeBetWrapFull #placeBetFull").show();
                            //$("#betslip #placeBetWrapFull #placebetBarFull").hide();

                            $("#placeBet").button('reset');
                        }, 500);
                    });
            }
        });
    }
}

function closemessagesdiv(){
    $("#betslip .serverMessages").hide()
}

function getFinalSelection(selectionOnBetslip, selectionInfo) {
    var finalSelection = $.extend(true, {}, selectionInfo['selection']);
    if (typeof(finalSelection['moreOdds']) != 'undefined') {
        var selectedThreshold = selectionOnBetslip['threshold'];
        for (var i in finalSelection['moreOdds']) {
            var selectionAux = finalSelection['moreOdds'][i];
            if (selectionAux['threshold'] == selectedThreshold) {
                finalSelection['oddsDecimal'] = selectionAux['oddsDecimal'];
                finalSelection['oddsDenominator'] = selectionAux['oddsDenominator'];
                finalSelection['oddsNumerator'] = selectionAux['oddsNumerator'];
                finalSelection['oddsUS'] = selectionAux['oddsUS'];
                finalSelection['threshold'] = selectionAux['threshold'];
                break;
            }
        }
    }
    return finalSelection;
}

function acceptChangesSelection(selectionId) {
    var selectionsOnBetslip = getSelectionsOnBetslip();
    var selectionOnBetslip = selectionsOnBetslip[selectionId];
    var selectionInfo = getSelectionInfo(selectionId, selectionOnBetslip['isOnTicket']);
    var finalSelection = getFinalSelection(selectionOnBetslip, selectionInfo);

    selectionOnBetslip['US'] = finalSelection['oddsUS'];
    selectionOnBetslip['Dec'] = finalSelection['oddsDecimal'];
    selectionOnBetslip['Num'] = finalSelection['oddsNumerator'];
    selectionOnBetslip['Den'] = finalSelection['oddsDenominator'];
    selectionOnBetslip['threshold'] = finalSelection['threshold'];

    saveSelectionsOnBetslip(selectionsOnBetslip);
}

function acceptChanges() {
    var selectionsOnBetslip = getSelectionsOnBetslip();
    for (var selectionId in selectionsOnBetslip)
        acceptChangesSelection(selectionId);
}

function isExact(game, selection) {
    if (game['SportType'] == 'Football' || game['SportType'] == 'Basketball')
        if (selection['betType'] == 'S' || selection['betType'] == 'L' || selection['betType'] == 'E')
            return true;
    return false;
}

function searchParlayDetail(GamesPicked, parlayDetails) {
    for (var i in parlayDetails)
        if (parlayDetails[i]['GamesPicked'] == GamesPicked)
            return parlayDetails[i];
    return null;
}

function computeParlayToWinAux(SelectionsID, selectionsOnBetslip) {
    var oddsStyle = getOddsStyle();
    var decimalExact = 1;
    var decimalNonExact = 1;
    var decimalFlat = 1;
    var totalNonExactSelections = 0;
    var totalSelections = 0;
    var customer = siteCache['customer'];

    for (var index = 0; index < SelectionsID.length; index++) {
        var SelectionID = SelectionsID[index];
        if (typeof(selectionsOnBetslip[SelectionID]) == 'undefined')
            return null;

        var selection = selectionsOnBetslip[SelectionID];

        if (selection['isOpenSelection'] == '1')
            continue;

        totalSelections++;

        var Decimal = 0;
        switch (oddsStyle) {
            case ODDS_STYLE_DECIMAL:
            case ODDS_STYLE_HONGKONG:
                Decimal = parseFloat(selection['Dec']);
                break;
            case ODDS_STYLE_FRACTIONAL:
                Decimal = parseFloat(selection['Num']) / parseFloat(selection['Den']) + 1;
                break;
            case ODDS_STYLE_US:
                var odds = parseFloat(selection['US']);
                Decimal = odds >= 0 ? odds / 100 + 1 : -100 / odds + 1;
                break;
        }

        var selectionInfo = getSelectionInfo(selection['selectionId'], selection['isOnTicket']);
        var selection = selectionInfo['selection'];
        var game = selectionInfo['game'];

        if (isExact(game, selection)) {
            totalNonExactSelections++;
            decimalNonExact = decimalNonExact * Decimal;
            decimalFlat = decimalFlat * (100 / 110 + 1);
        }
        else {
            decimalExact = decimalExact * Decimal;
        }
    }

    var chartMaxPayout = 0;
    var x = 1, y = 1;
    var x2 = 1, y2 = 1;
    var finalDecimalNonExact = decimalNonExact;
    var parlayDetails = customer['parlayInfo']['parlayDetails'];
    var globalRisk = getGlobalRiskAmount();
    var parlayRisk = parseFloat(globalRisk);

    if (totalNonExactSelections > 1) {
        var parlayDetail = searchParlayDetail(totalNonExactSelections, parlayDetails);
        if (parlayDetail == null)
            return null;

        x = 0, y = 1;
        var myregexp = /(.+)\s*to\s*(.+)/;
        var match = myregexp.exec(parlayDetail['Pays_X_to_Y']);
        if (match != null) {
            x = parseFloat(match[1]);
            y = parseFloat(match[2]);
        }
        finalDecimalNonExact = (x / y) * ((decimalNonExact - 1) / (decimalFlat - 1)) + 1;
    }

    if (totalSelections > 1) {
        var parlayDetail = searchParlayDetail(totalSelections, parlayDetails);
        if (parlayDetail != null) {
            x2 = 0;
            y2 = 1;
            var myregexp = /(.+)\s*to\s*(.+)/;
            var match = myregexp.exec(parlayDetail['Max_Payout_X_to_Y']);
            if (match != null) {
                x2 = parseFloat(match[1]);
                y2 = parseFloat(match[2]);
            }
            chartMaxPayout = x2 * globalRisk / y2;
        }
    }


    var decimalAverage = finalDecimalNonExact * decimalExact;
    var parlayToWin = parlayRisk * (decimalAverage - 1);

    if (chartMaxPayout > 0 && parlayToWin > chartMaxPayout)
        parlayToWin = chartMaxPayout;

    var ParlayMaxPayout = parseFloat(customer['ParlayMaxPayout']) / 100;
    if (ParlayMaxPayout > 0 && parlayToWin > ParlayMaxPayout)
        parlayToWin = ParlayMaxPayout;
    return parlayToWin;
}

function computeStraightRisk() {
    var selectionsOnBetslip = getSelectionsOnBetslip();
    var risk = 0;
    for (var SelectionID in selectionsOnBetslip)
        risk += parseFloat(selectionsOnBetslip[SelectionID]['riskAmount']);
    return risk;
}

function computeStraightToWin() {
    var selectionsOnBetslip = getSelectionsOnBetslip();
    var toWin = 0;
    for (var SelectionID in selectionsOnBetslip)
        toWin += parseFloat(selectionsOnBetslip[SelectionID]['winAmount']);
    return toWin;
}

function computeParlayToWin() {
    var selectionsOnBetslip = getSelectionsOnBetslip();
    var SelectionsID = new Array();
    for (var SelectionID in selectionsOnBetslip)
        SelectionsID.push(SelectionID);
    return computeParlayToWinAux(SelectionsID, selectionsOnBetslip);
}

function computeRoundRobinRisk() {
    var combinations = combineSelectionsOnBetslip();
    //var risk=getGlobalRiskAmount();
    var betslipType = getBetslipType();
    var risk = getCookie('risk' + betslipType);

    return risk * combinations.length;
}

function computeTeaserRisk() {
    return getGlobalRiskAmount();
}

function computeRoundRobinToWin() {
    var combinations = combineSelectionsOnBetslip();
    var selectionsOnBetslip = getSelectionsOnBetslip();
    var maxWin = 0;
    for (var i = 0; i < combinations.length; i++) {
        maxWin += computeParlayToWinAux(combinations[i], selectionsOnBetslip);
    }
    return maxWin;
}

function computeTeaserToWin() {
    return getTeaserWin();
}

function factorial(n) {
    return n > 0 ? n * factorial(n - 1) : 1;
}
function totalPermutations(n, k) {
    return factorial(n) / factorial(n - k);
}
function totalComninations(n, k) {
    return factorial(n) / (factorial(k) * factorial(n - k));
}

function permuteAux(arr) {
    if (arr.length == 0)
        return [];
    if (arr.length == 1)
        return [[arr[0]]];

    var perms = new Array();
    for (var i = 0; i < arr.length; i++) {
        var temp = new Array();
        for (var j = 0; j < arr.length; j++)
            if (i != j)
                temp.push(arr[j]);

        var tempPerms = permuteAux(temp);
        for (var j = 0; j < tempPerms.length; j++) {
            var tempPerm = tempPerms[j];
            tempPerm.push(arr[i]);
            perms.push(tempPerm);
        }
    }
    return perms;
}

function permute(arr, min, max) {
    var perms = new Array();
    var combs = combineArray(arr, min, max);

    for (var i = 0; i < combs.length; i++) {
        var comb = combs[i];
        if (min <= comb.length && comb.length <= max) {
            var permsTemp = permuteAux(comb);
            for (var j = 0; j < permsTemp.length; j++)
                perms.push(permsTemp[j]);
        }
    }
    return perms;
}

function combineArray(arr, min, max) {
    var combs = new Array();
    for (var i = 0; i < arr.length; i++) {
        var length = combs.length;
        for (var j = 0; j < length; j++) {
            var comb = (combs[j]).slice();
            comb.push(arr[i]);
            combs.push(comb);
        }
        combs.push([arr[i]]);
    }

    var res = new Array();
    for (var i = 0; i < combs.length; i++) {
        var comb = combs[i];
        if (min <= comb.length && comb.length <= max)
            res.push(comb);
    }
    return res;
}


function combineSelectionsOnBetslip() {
    var selectionsOnBetslip = getSelectionsOnBetslip();

    var ids = new Array();
    for (var selectionId in selectionsOnBetslip)
        ids.push(selectionId);

    var min = 2;
    //var max=getMaxSelectionsAllowedParlay();
    var max = getRoundRobinType();
    return combineArray(ids, min, max);
}

function getMaxSelectionsAllowedParlay() {
    var GamesPickedMax = 0;
    if (typeof(siteCache['customer']) != 'undefined') {
        var parlayDetails = siteCache['customer']['parlayInfo']['parlayDetails'];
        for (var i in parlayDetails) {
            var GamesPicked = parseInt(parlayDetails[i]['GamesPicked']);
            if (GamesPickedMax < GamesPicked)
                GamesPickedMax = GamesPicked;
        }
    }
    return GamesPickedMax;
}

function getMaxSelectionsAllowedTeaser() {
    var teaserType = getTeaserType();
    teaserType = teaserType.split('+').join(' ');

    var teasers = siteCache['customer']['teasers'];

    if (typeof(teasers[teaserType]) != 'undefined')
        return teasers[teaserType]['MaxPicks'];
    return 0;
}

function getMaxSelectionsAllowedBetslip() {
    var betslipType = getBetslipType();

    if (betslipType == 'straight')
        return 15;

    if (betslipType == 'parlay')
        return getMaxSelectionsAllowedParlay();

    if (betslipType == 'rndrobin')
        return getMaxSelectionsAllowedParlay();

    if (betslipType == 'teaser')
        return getMaxSelectionsAllowedTeaser();

    if (betslipType == 'ifbet')
        return 15;

    if (betslipType == 'reverse')
        return 15;

    return 0;
}

function getMinSelectionsAllowedBetslip() {
    var betslipType = getBetslipType();

    if (betslipType == 'parlay')
        return 2;

    if (betslipType == 'rndrobin')
        return 2;

    if (betslipType == 'teaser') {
        var teaserType = getTeaserType();
        var teaser = getSelectedTeaser(teaserType.split('+').join(' '));
        if (teaser == null)
            return 0;
        return parseInt(teaser['MinPicks']);
    }

    if (betslipType == 'ifbet')
        return 2;

    if (betslipType == 'reverse')
        return 2;

    return 1;
}

function getErrorsSelectionsBetslip() {
    var selectionsInfo = new Object();
    var selectionsOnBetslip = getSelectionsOnBetslip();
    for (var selectionId in selectionsOnBetslip) {
        var selectionOnBetslip = selectionsOnBetslip[selectionId];
        if (selectionOnBetslip['isOpenSelection'] != '1')
            selectionsInfo[selectionId] = getSelectionInfo(selectionId, selectionOnBetslip['isOnTicket']);
    }

    var betslipType = getBetslipType();
    var teaserType = getTeaserType();
    return getSelectionsError(selectionsInfo, betslipType, teaserType);
}

function markSelectionsErrorBetslip() {
    var selectionsInfo = new Object();
    var selectionsOnBetslip = getSelectionsOnBetslip();
    for (var selectionId in selectionsOnBetslip) {
        var selectionOnBetslip = selectionsOnBetslip[selectionId];
        if (selectionOnBetslip['isOpenSelection'] != '1')
            selectionsInfo[selectionId] = getSelectionInfo(selectionId, selectionOnBetslip['isOnTicket']);
    }

    var teaserType = getTeaserType();
    var betslipType = getBetslipType();
    var errors = getSelectionsError(selectionsInfo, betslipType, teaserType);

    var errorsIDs = new Object();
    for (var type in errors) {
        var errorsType = errors[type];
        for (var i = 0; i < errorsType.length; i++)
            for (var j = 0; j < errorsType[i].length; j++)
                errorsIDs[errors[type][i][j]] = true;
    }

    for (var selectionId in selectionsOnBetslip) {
        var betslipSelectionId = "betslip_selection_" + selectionId;
        if (typeof(errorsIDs[selectionId]) != 'undefined') {
            $("#" + betslipSelectionId).addClass("error");
        }
        else
            $("#" + betslipSelectionId).removeClass("error");
    }
}

function checkOpenBetDenyError() {
    var selectionsOnBetslip = getSelectionsOnBetslip();
    var betslipType = getBetslipType();

    if (betslipType == 'parlay') {
        return false;
    }

    if (betslipType == 'teaser') {
        return false;
    }

    for (var selectionId in selectionsOnBetslip)
        if (selectionsOnBetslip[selectionId]['isOpenSelection'] == '1')
            return true;

    return false;
}

function computeMaxRiskAmount() {
    var betslipType = getBetslipType();

    if (betslipType == 'straight') {
        return computeStraightRisk();
    }

    if (betslipType == 'parlay') {
        return getCookie('risk' + betslipType);
        //return getGlobalRiskAmount();
        //return 0;
    }
    if (betslipType == 'rndrobin') {
        return computeRoundRobinRisk();
    }

    if (betslipType == 'teaser') {
        return getTeaserRisk();
    }

    if (betslipType == 'ifbet') {
        return getIfBetMaxRisk();
    }

    if (betslipType == 'reverse') {
        return getReverseMaxRisk();
    }
}

function computeMaxWinAmount() {
    var betslipType = getBetslipType();
    if (betslipType == 'straight') {
        return computeStraightToWin();
    }

    if (betslipType == 'parlay') {
        return computeParlayToWin();
    }

    if (betslipType == 'rndrobin') {
        return computeRoundRobinToWin();
    }

    if (betslipType == 'teaser') {
        return getTeaserWin();
    }

    if (betslipType == 'ifbet') {
        return getIfBetMaxWin();
    }

    if (betslipType == 'reverse') {
        return getReverseMaxWin();
    }

    return 0;
}

function removeNullSelections() {
    var selectionsOnBetslip = getSelectionsOnBetslip();
    var save = false;
    for (var selectionId in selectionsOnBetslip) {
        var selectionOnBetslip = selectionsOnBetslip[selectionId];

        if (selectionOnBetslip['isOpenSelection'] == '1')
            continue;

        var selectionsInfo = getSelectionInfo(selectionId, selectionOnBetslip['isOnTicket']);
        if (selectionsInfo == null) {
            delete selectionsOnBetslip[selectionId];
            save = true;
        }
    }

    if (save)
        saveSelectionsOnBetslip(selectionsOnBetslip);

}

function getSelectedTeaser(teaserType) {
    if (typeof(siteCache['customer']['teasers'][teaserType]) == 'undefined')
        return null;

    return siteCache['customer']['teasers'][teaserType];
}

function computeThresholdTeaser() {
    var betslipType = getBetslipType();

    if (betslipType != 'teaser')
        return;

    var selectionsOnBetslip = getSelectionsOnBetslip();
    var save = false;
    for (var selectionId in selectionsOnBetslip) {
        var selectionOnBetslip = selectionsOnBetslip[selectionId];

        if (selectionOnBetslip['isOpenSelection'] == '1')
            continue;

        var selectionInfo = getSelectionInfo(selectionId, selectionOnBetslip['isOnTicket']);
        var game = selectionInfo['game'];
        var selection = selectionInfo['selection'];

        var SportSubType = game['SportSubType'].trim();
        var SportType = game['SportType'].trim();
        var betType = selection['betType'];

        var teaserType = getTeaserType();
        var teaser = getSelectedTeaser(teaserType.split('+').join(' '));

        if (teaser == null ||
            typeof(teaser) == 'undefined' ||
            typeof(teaser['SportTypes'][SportType]) == 'undefined' ||
            typeof(teaser['SportTypes'][SportType][betType]) == 'undefined' ||
            typeof(teaser['SportTypes'][SportType][betType][SportSubType]) == 'undefined')
            continue;

        var points = parseFloat(teaser['SportTypes'][SportType][betType][SportSubType]);
        var threshold = parseFloat(selection['threshold']);
        var thresholdTeaser = threshold;

        if (betType == 'S')
            thresholdTeaser = threshold + points;
        //thresholdTeaser=threshold>0? threshold-points : threshold+points;


        if (betType == 'L')
            thresholdTeaser = selection['description'] == 'Over' ? threshold - points : threshold + points;

        if (thresholdTeaser != selectionOnBetslip['thresholdTeaser']) {
            selectionOnBetslip['thresholdTeaser'] = thresholdTeaser;
            save = true;
        }
    }

    if (save) {
        saveSelectionsOnBetslip(selectionsOnBetslip);
    }
}

function getCurrentPayCard() {
    var teaserType = getTeaserType();
    var teaser = getSelectedTeaser(teaserType.split('+').join(' '));
    if (teaser != null) {
        var picked = countSelectionsOnBetslip();
        for (var i in teaser['PayCard']) {
            var PayCard = teaser['PayCard'][i];
            if (PayCard['GamesWon'] == picked && PayCard['GamesPicked'] == picked)
                return PayCard;
        }
    }
    return null;
}

function getTeaserWin() {
    var amount = getTeaserAmount();

    if (getTeaserAmountType() == 'win')
        return amount;

    if (isNaN(parseFloat(amount)))
        return "";

    amount = parseFloat(amount);
    var PayCard = getCurrentPayCard();
    return PayCard != null ? amount * parseFloat(PayCard['MoneyLine']) / parseFloat(PayCard['ToBase']) : 0;
}

function getTeaserRisk() {
    var amount = getTeaserAmount();

    if (getTeaserAmountType() == 'risk')
        return amount;

    if (isNaN(parseFloat(amount)))
        return "";

    amount = parseFloat(amount);
    var PayCard = getCurrentPayCard();
    return PayCard != null ? amount * parseFloat(PayCard['ToBase']) / parseFloat(PayCard['MoneyLine']) : 0;
}


function getIfBetMaxRiskAux(selectionsArray) {
    var ContinueOnPushFlag = getContinueOnPushFlag();
    var balance = 0;
    var maxRisk = 0;
    for (var i = 0; i < selectionsArray.length; i++) {
        var selection = selectionsArray[i];
        var riskAmount = parseFloat(selection['riskAmount']);
        var winAmount = parseFloat(selection['winAmount']);

        if (balance < riskAmount) {
            maxRisk += riskAmount - balance;
            balance = riskAmount;
        }
        balance += ContinueOnPushFlag == 'Y' ? 0 : winAmount;
    }
    return maxRisk;
}

function getSelectionsOnBetslipArraySortedOrder() {
    var selectionsOnBetslip = getSelectionsOnBetslip();
    var selections = new Array();
    var idsInArray = new Object();

    do {
        var selectionIdToAdd = null;
        var minOrder = null;
        for (var selectionID in selectionsOnBetslip) {
            var selectionOnBetslip = selectionsOnBetslip[selectionID];
            var order = parseInt(selectionOnBetslip['order']);

            if (typeof(idsInArray[selectionID]) == 'undefined')
                if (minOrder == null || minOrder >= order) {
                    minOrder = order;
                    selectionIdToAdd = selectionID;
                }
        }
        if (selectionIdToAdd != null) {
            selections.push(selectionsOnBetslip[selectionIdToAdd]);
            idsInArray[selectionIdToAdd] = true;
        }
    } while (selectionIdToAdd != null);

    return selections;
}

function getIfBetMaxRisk() {
    var selectionsArray = getSelectionsOnBetslipArraySortedOrder();
    return getIfBetMaxRiskAux(selectionsArray);
}

function getIfBetMaxWin() {
    var selectionsOnBetslip = getSelectionsOnBetslip();
    var maxWin = 0;
    for (var selectionId in selectionsOnBetslip) {
        var selectionOnBetslip = selectionsOnBetslip[selectionId];
        var winAmount = parseFloat(selectionOnBetslip['winAmount']);
        maxWin += winAmount;
    }
    return maxWin;
}

function getReverseCombinations() {
    var selectionsOnBetslip = getSelectionsOnBetslip();
    var combs = new Array();
    for (var selectionID1 in selectionsOnBetslip)
        for (var selectionID2 in selectionsOnBetslip)
            if (selectionID1 != selectionID2)
                combs.push([selectionsOnBetslip[selectionID1], selectionsOnBetslip[selectionID2]]);
    return combs;
}

function getSelectionPosibilities(selectionIds) {
    var posibilities = [{}];

    for (var id in selectionIds) {
        var posibilities2 = [];
        for (var i = 0; i < posibilities.length; i++) {
            var posibility = posibilities[i];

            var posibilityWin = $.extend({}, posibility);
            var posibilityLose = $.extend({}, posibility);
            var posibilityTie = $.extend({}, posibility);

            posibilityWin[id] = 'W';
            posibilities2.push(posibilityWin);

            posibilityLose[id] = 'L';
            posibilities2.push(posibilityLose);

            posibilityTie[id] = 'X';
            posibilities2.push(posibilityTie);
        }

        posibilities = posibilities2;
    }
    return posibilities;
}

function getReverseOdds() {
    var ContinueOnPushFlag = getContinueOnPushFlag();
    var combs = getReverseCombinations();

    var selectionIds = new Object();
    for (var i = 0; i < combs.length; i++) {
        var comb = combs[i];
        for (var j = 0; j < comb.length; j++)
            selectionIds[comb[j]['selectionId']] = true;
    }

    var posibilities = getSelectionPosibilities(selectionIds);

    var minOdds = null;
    var maxOdds = null;
    for (var k = 0; k < posibilities.length; k++) {
        var posibility = posibilities[k];
        var Odds = 0;
        for (var i = 0; i < combs.length; i++) {
            var comb = combs[i];

            for (var j = 0; j < comb.length; j++) {
                var sel = comb[j];
                var selOdds = parseInt(sel['US']);
                var id = sel['selectionId'];

                if (posibility[id] == 'W') {
                    Odds += selOdds > 0 ? selOdds : 100;
                }
                if (posibility[id] == 'L') {
                    Odds += selOdds > 0 ? -100 : selOdds;
                    break;
                }
                if (posibility[id] == 'X') {
                    if (ContinueOnPushFlag != 'Y')
                        break;
                }
            }
        }
        if (minOdds == null || minOdds > Odds)
            minOdds = Odds;
        if (maxOdds == null || maxOdds < Odds)
            maxOdds = Odds;
    }

    return {"minOdds": minOdds, "maxOdds": maxOdds};
}

function countRerverseCombinations() {
    var total = 0;
    var combs = getReverseCombinations();
    for (var i = 0; i < combs.length; i++)
        for (var j = 0; j < combs[i].length; j++)
            total++;
    return total;
}

function getReverseMaxRisk() {
    var odds = getReverseOdds();

    if (odds['minOdds'] == null || odds['minOdds'] == 0)
        return 0;

    return odds['minOdds'] > 0 ? getReverseAmount() * 100 / odds['minOdds'] : -getReverseAmount() * odds['minOdds'] / 100;
}

function getReverseMaxWin() {
    var odds = getReverseOdds();

    if (odds['maxOdds'] == null || odds['maxOdds'] == 0)
        return 0;

    return odds['maxOdds'] > 0 ? getReverseAmount() * odds['maxOdds'] / 100 : -getReverseAmount() * 100 / odds['maxOdds'];
}

function getLimitsStraight() {
    return getLimitsStraightAux(limitsCache);
}

function getLimitsStraightAux(limits) {
    if (typeof(limits) != "undefined" && limits != null && typeof(limits['straight']) != "undefined")
        return limits['straight'];
    return null;
}

function getLimitsParlay() {
    if (typeof(limitsCache) != "undefined" && limitsCache != null && typeof(limitsCache['parlay']) != "undefined")
        return limitsCache['parlay'];
    return null;
}

function getLimitsRoundRobin() {
    return getLimitsRoundRobinAux(limitsCache);
}
function getLimitsRoundRobinAux(limits) {
    if (typeof(limits) != "undefined" && limits != null && typeof(limits['roundRobin']) != "undefined")
        return limits['roundRobin'];
    return null;
}


function getLimitsTeaser() {
    if (typeof(limitsCache) != "undefined" && limitsCache != null && typeof(limitsCache['teaser']) != "undefined")
        return limitsCache['teaser'];
    return null;
}

function getLimitsReverse() {
    if (typeof(limitsCache) != "undefined" && limitsCache != null && typeof(limitsCache['reverse']) != "undefined")
        return limitsCache['reverse'];
    return null;
}

function checkLimitsHookup(limit, risk, toWin) {
    var totalSelecions = countSelectionsOnBetslip()
    var error = false;
    if (totalSelecions > 0 && limit != null) {
        var bet = risk;
        if (toWin != null && bet > toWin)
            bet = toWin;
        //var bet=risk>toWin? toWin: risk;

        if (parseFloat(limit['low']) > bet) {
            error = true;
            $("#betslip .lowLimitError .amount").html(limit['low']);
            $("#betslip .lowLimitError").show();
        } else
            $("#betslip .lowLimitError").hide();

        if (parseFloat(limit['high']) < bet) {
            error = true;
            $("#betslip .highLimitError .amount").html(limit['high']);
            $("#betslip .highLimitError .betedAmount").html(limit['betedAmount']);
            $("#betslip .highLimitError .total").html(limit['total']);
            $("#betslip .highLimitError").show();
        } else
            $("#betslip .highLimitError").hide();
    } else {
        $("#betslip .lowLimitError").hide();
        $("#betslip .highLimitError").hide();
    }
    return error;
}

function txtRiskChange(objectTxt) {
    var betslipType = getBetslipType();
    createCookie('risk' + betslipType, $(objectTxt).val(), '');
}

function updateBetSlip(origen) {
    if (getCookie('selectedSideCanvas') != '') {
        if (getCookie('selectedSideCanvas') == "center") {
            $("#myOffCanvas").removeClass('activeLeft');
            $("#myOffCanvas").removeClass('activeRight');
        }
        else {
            $("#myOffCanvas").addClass('active' + getCookie('selectedSideCanvas').charAt(0).toUpperCase() + getCookie('selectedSideCanvas').slice(1));
        }
    }
    //$(".toggle-myOffCanvas").click();
    var betslipType = getBetslipType();
    removeNullSelections();
    computeThresholdTeaser();
    var error = false;
    var showGlobalMessages = false;
    computeBetslipSelectionsAmounts();
    updateFreePlayCheck();
    var updateSelectionsResult = updateBetslipSelections(origen);
    hightLigthSelectionOnBetslip();
    var totalSelectionsOnbetslip = countSelectionsOnBetslip();
    var totalRealSelectionsOnbetslip = countRealSelectionsOnBetslip();
    var maxSelectionsAllowed = getMaxSelectionsAllowedBetslip();
    var minSelectionsAllowed = getMinSelectionsAllowedBetslip();
    var maxToWin = computeMaxWinAmount();
    if (maxToWin != null)
        maxToWin = myRound(maxToWin, 2);

    var maxRisk = myRound(computeMaxRiskAmount(), 2);

    $("#betslip .betslipTypeSelector .option").removeClass('selected');
    $("#betslip .betslipTypeSelector .option." + betslipType).addClass('selected');
    $("#cbmBetType").val(betslipType);
    if (betslipType == 'straight') {
        $("#betslip").removeClass("hideOdds");
        $("#betslip .selection .amountMenu").show();
        $("#betslip .globalAmount").hide();

        if (totalSelectionsOnbetslip > 1) {
            $("#betslip .maxAmounts").show();
        }
        else {
            $("#betslip .maxAmounts").hide();
        }

        $("#betslip .ifLabel").hide();
        $("#betslip #addOpenBetWrap").hide();
        $("#betslip #roundRobinSelectorWrap").hide();
        $("#betslip #teaserSelectorWrap").hide();
        $("#betslip .teaserAmounts").hide();
        $("#betslip #ContinueOnPushFlagWrapIfBet").hide();
        $("#betslip #ContinueOnPushFlagWrapReverse").hide();
        $("#betslip .reverseAmountWrap").hide();
        $("#betslip .lowLimitError").hide();
        $("#betslip .highLimitError").hide();

        if (totalSelectionsOnbetslip > 1)
            $("#betslip .allAmountMenu").show();
        else
            $("#betslip .allAmountMenu").hide();

        saveGlobalRiskAmount(computeMaxRiskAmount());
    }

    $("#shopping-cart").html(countSelectionsOnBetslip());

    var betslipType = getBetslipType();
    if (betslipType == "rndrobin") {
        var middlePointRobin = countSelectionsOnBetslip();

        for (var x = 0; x < $('#betslip #roundRobinType option').size() + 1; x++) {
            if ((x + 1) > middlePointRobin && (x + 1) > 2) {
                $("#betslip #roundRobinType option[value=" + (x + 1) + "]").hide();
            }
            else {
                $("#betslip #roundRobinType option[value=" + (x + 1) + "]").show();
            }
        }

        if ($('#betslip #roundRobinType').val() > middlePointRobin) {
            $("#betslip #roundRobinType").val(middlePointRobin);
            $("#betslip #roundRobinType option[value=" + middlePointRobin + "]").attr('selected', 'selected');
        }
    }
    if (betslipType == 'parlay') {
        $("#betslip").removeClass("hideOdds");
        $("#betslip .selection .amountMenu").hide();
        $("#betslip .allAmountMenu").hide();

        if (totalSelectionsOnbetslip > 1) {
            $("#betslip .maxAmounts").show();
        }
        else {
            $("#betslip .maxAmounts").hide();
        }
        $("#betslip .ifLabel").hide();
        $("#betslip #roundRobinSelectorWrap").hide();
        $("#betslip #teaserSelectorWrap").hide();
        $("#betslip .teaserAmounts").hide();
        $("#betslip #ContinueOnPushFlagWrapIfBet").hide();
        $("#betslip #ContinueOnPushFlagWrapReverse").hide();
        $("#betslip .reverseAmountWrap").hide();

        if (totalSelectionsOnbetslip > 0)
            $("#betslip .globalAmount").show();
        else
            $("#betslip .globalAmount").hide();

        if (maxSelectionsAllowed > totalSelectionsOnbetslip && totalRealSelectionsOnbetslip >= 1)
            $("#betslip #addOpenBetWrap").hide();
        else
            $("#betslip #addOpenBetWrap").hide();

        if (checkLimitsHookup(getLimitsParlay(), maxRisk, maxToWin)) {
            showGlobalMessages = true;
            error = true;
        }

        saveGlobalRiskAmount(computeMaxRiskAmount());
    }

    if (betslipType == 'rndrobin') {
        $("#betslip").removeClass("hideOdds");
        $("#betslip .selection .amountMenu").hide();
        $("#betslip .allAmountMenu").hide();
        $("#betslip #addOpenBetWrap").hide();

        if (totalSelectionsOnbetslip > 1) {
            $("#betslip .maxAmounts").show();
        }
        else {
            $("#betslip .maxAmounts").hide();
        }

        $("#betslip .ifLabel").hide();
        $("#betslip #roundRobinSelectorWrap").show();
        $("#betslip #teaserSelectorWrap").hide();
        $("#betslip .teaserAmounts").hide();
        $("#betslip #ContinueOnPushFlagWrapIfBet").hide();
        $("#betslip #ContinueOnPushFlagWrapReverse").hide();
        $("#betslip .reverseAmountWrap").hide();

        if (totalSelectionsOnbetslip > 0)
            $("#betslip .globalAmount").show();
        else
            $("#betslip .globalAmount").hide();

        if (checkLimitsHookup(getLimitsRoundRobin(), maxRisk, maxToWin)) {
            showGlobalMessages = true;
            error = true;
        }

    }

    if (betslipType == 'teaser') {
        $("#betslip").addClass("hideOdds");
        $("#betslip .selection .amountMenu").hide();
        $("#betslip .allAmountMenu").hide();
        $("#betslip .globalAmount").hide();

        if (totalSelectionsOnbetslip > 1) {
            $("#betslip .maxAmounts").show();
        }
        else {
            $("#betslip .maxAmounts").hide();
        }

        $("#betslip .ifLabel").hide();
        $("#betslip #roundRobinSelectorWrap").hide();
        $("#betslip #teaserSelectorWrap").show();
        $("#betslip #ContinueOnPushFlagWrapIfBet").hide();
        $("#betslip #ContinueOnPushFlagWrapReverse").hide();
        $("#betslip .reverseAmountWrap").hide();

        if (maxSelectionsAllowed > totalSelectionsOnbetslip && totalRealSelectionsOnbetslip >= 1)
            $("#betslip #addOpenBetWrap").hide();
        else
            $("#betslip #addOpenBetWrap").hide();

        var teaserRisk = myRound(getTeaserRisk(), 2);
        var teaserWin = myRound(getTeaserWin(), 2);
        var currentInputTeaserRisk = myRound($("#betslip .teaserRiskAmount").val(), 2);
        var currentInputTeaserWin = myRound($("#betslip .teaserWinAmount").val(), 2);
        var teaserAmountType = getTeaserAmountType();
        if (teaserAmountType == 'win' || currentInputTeaserRisk != teaserRisk)
            $("#betslip .teaserRiskAmount").val(teaserRisk);
        if (teaserAmountType == 'risk' || currentInputTeaserWin != teaserWin)
            $("#betslip .teaserWinAmount").val(teaserWin);

        var currentGlobalRisk = getGlobalRiskAmount();
        if (currentGlobalRisk != teaserRisk)
            saveGlobalRiskAmount(teaserRisk);

        var currentGlobalWin = getGlobalToWinAmount();
        if (currentGlobalWin != teaserWin) {
            saveGlobalToWinAmount(teaserWin);
        }
        var teaserType = getTeaserType();
        var teaser = getSelectedTeaser(teaserType.split('+').join(' '));
        if (teaser != null) {
            $("#betslip .teaserAmounts").show();
            $("#currentTeaserType").html(teaser['TeaserName'].split('+').join(' '));
            $("#currentTeaserType").removeClass("nonSelected");
        }
        else {
            $("#betslip .teaserAmounts").hide();
            $("#currentTeaserType").html("Please select a teaser");
            $("#currentTeaserType").addClass("nonSelected");
        }

        if (checkLimitsHookup(getLimitsTeaser(), teaserRisk, teaserWin)) {
            showGlobalMessages = true;
            error = true;
        }
    }

    if (betslipType == 'ifbet') {
        $("#betslip").removeClass("hideOdds");
        $("#betslip .selection .amountMenu").show();
        $("#betslip .globalAmount").hide();

        if (totalSelectionsOnbetslip > 1) {
            $("#betslip .maxAmounts").show();
        }
        else {
            $("#betslip .maxAmounts").hide();
        }

        $("#betslip #addOpenBetWrap").hide();
        $("#betslip #roundRobinSelectorWrap").hide();
        $("#betslip #teaserSelectorWrap").hide();
        $("#betslip .teaserAmounts").hide();
        $("#betslip .selection").first().find(".ifLabel").hide();
        $("#betslip .selection").first().siblings().find(".ifLabel").show();
        $("#betslip .reverseAmountWrap").hide();
        $("#betslip #ContinueOnPushFlagWrapIfBet").show();
        $("#betslip #ContinueOnPushFlagWrapReverse").hide();
        $("#betslip .ContinueOnPushFlag").val(getContinueOnPushFlag());
        $("#betslip .lowLimitError").hide();
        $("#betslip .highLimitError").hide();

        if (totalSelectionsOnbetslip > 1)
            $("#betslip .allAmountMenu").show();
        else
            $("#betslip .allAmountMenu").hide();

        saveGlobalRiskAmount(computeMaxRiskAmount());
    }

    if (betslipType == 'reverse') {
        var reverseAmount = getReverseAmount();
        $("#betslip").removeClass("hideOdds");
        $("#betslip .selection .amountMenu").hide();

        if (totalSelectionsOnbetslip > 1) {
            $("#betslip .maxAmounts").show();
        }
        else {
            $("#betslip .maxAmounts").hide();
        }

        $("#betslip #addOpenBetWrap").hide();
        $("#betslip #roundRobinSelectorWrap").hide();
        $("#betslip #teaserSelectorWrap").hide();
        $("#betslip .teaserAmounts").hide();
        $("#betslip #ContinueOnPushFlagWrap").show();
        $("#betslip .selection .ifLabel").hide();
        $("#betslip .allAmountMenu").hide();
        $("#betslip .globalAmount").hide();
        $("#betslip #ContinueOnPushFlagWrapIfBet").hide();
        $("#betslip #ContinueOnPushFlagWrapReverse").show();
        $("#betslip .ContinueOnPushFlag").val(getContinueOnPushFlag());
        $("#betslip .reverseAmountWrap").show();
        $("#betslip .reverseAmount").val(reverseAmount);

        if (checkLimitsHookup(getLimitsReverse(), reverseAmount, reverseAmount)) {
            showGlobalMessages = true;
            error = true;
        }

        saveGlobalRiskAmount(computeMaxRiskAmount());
    }

    var customer = siteCache['customer'];
    var AvailableBalance = parseFloat(customer['AvailableBalance']);
    var FreePlayBalance = parseFloat(customer['FreePlayBalance']);
    var totalAmounts = getTotalAmounts();

    if (totalAmounts['risk'] > AvailableBalance) {
//        showGlobalMessages=true;
//        error=true;
//        if(origen == "placeBet") $(".globalMessages .lowBalanceError").show();
//        else $(".globalMessages .lowBalanceError").hide();
//    }else{
//        $(".globalMessages .lowBalanceError").hide();
    }

    //VALIDACION
    showGlobalMessages = false;
    error = false;
    if (totalAmounts['riskFP'] > FreePlayBalance) {
        showGlobalMessages = true;
        error = true;
        if (origen == "placeBet") $(".globalMessages .lowFreePlayError").show();
        else $(".globalMessages .lowFreePlayError").hide();
    } else {
        $(".globalMessages .lowFreePlayError").hide();
    }

    if (updateSelectionsResult['amountError']) {
        showGlobalMessages = true;
        error = true;
        if (origen == "placeBet") $(".globalMessages .amountError").show();
        else $(".globalMessages .amountError").hide();
    } else {
        $(".globalMessages .amountError").hide();
    }

    if (updateSelectionsResult['unavailableError']) {
        showGlobalMessages = true;
        error = true;
        if (origen == "placeBet") $(".globalMessages .unavailableError").show();
        else $(".globalMessages .unavailableError").hide();
    } else {
        $(".globalMessages .unavailableError").hide();
    }

    if (updateSelectionsResult['changeSelectionError']) {
        showGlobalMessages = true;
        error = true;
        $(".globalMessages .changeSelectionError").show();
        $("#betslip #acceptChangesWrap").show();
    } else {
        $(".globalMessages .changeSelectionError").hide();
        $("#betslip #acceptChangesWrap").hide();
    }

    if (updateSelectionsResult['restWagerError']) {
        showGlobalMessages = true;
        error = true;
        if (origen == "placeBet") $(".globalMessages .restWagerError").show();
        else $(".globalMessages .restWagerError").hide();
    } else {
        $(".globalMessages .restWagerError").hide();
    }

    if (betslipType == 'teaser') {
        var teaser = getSelectedTeaser(teaserType.split('+').join(' '));
        if (teaser != null) {
            if (maxSelectionsAllowed < totalSelectionsOnbetslip) {
                showGlobalMessages = true;
                error = true;
                $(".globalMessages .maxSelectionAllowedError .maxSelectionsAllowed").html(maxSelectionsAllowed);
                if (origen == "placeBet") $(".globalMessages .maxSelectionAllowedError").show();
                else $(".globalMessages .maxSelectionAllowedError").hide();
            } else {
                $(".globalMessages .maxSelectionAllowedError").hide();
            }
        }
    }
    else {
        if (maxSelectionsAllowed < totalSelectionsOnbetslip) {
            showGlobalMessages = true;
            error = true;
            $(".globalMessages .maxSelectionAllowedError .maxSelectionsAllowed").html(maxSelectionsAllowed);
            if (origen == "placeBet") $(".globalMessages .maxSelectionAllowedError").show();
            else $(".globalMessages .maxSelectionAllowedError").hide();
        } else {
            $(".globalMessages .maxSelectionAllowedError").hide();
        }
    }

    if (betslipType == 'teaser') {
        var teaser = getSelectedTeaser(teaserType.split('+').join(' '));
        if (teaser != null) {
            if (totalSelectionsOnbetslip > 0 && minSelectionsAllowed > totalSelectionsOnbetslip) {
                showGlobalMessages = true;
                error = true;
                $(".globalMessages .minSelectionAllowedError .minSelectionsAllowed").html(minSelectionsAllowed);
                if (origen == "placeBet") $(".globalMessages .minSelectionAllowedError").show();
                else $(".globalMessages .minSelectionAllowedError").hide();

            } else {
                $(".globalMessages .minSelectionAllowedError").hide();
            }
        }
    }
    else {
        if (totalSelectionsOnbetslip > 0 && minSelectionsAllowed > totalSelectionsOnbetslip) {
            showGlobalMessages = true;
            error = true;
            $(".globalMessages .minSelectionAllowedError .minSelectionsAllowed").html(minSelectionsAllowed);
            if (origen == "placeBet") $(".globalMessages .minSelectionAllowedError").show();
            else $(".globalMessages .minSelectionAllowedError").hide();
        } else {
            $(".globalMessages .minSelectionAllowedError").hide();
        }
    }

    /*if($("#betslip #roundRobinType").val() < countSelectionsOnBetslip()){
     showGlobalMessages=true;
     error=true;
     initMessage = true;
     $("#betslip .globalMessages .maxSelectionAllowedError .maxSelectionsAllowed").html($("#betslip #roundRobinType").val());
     $("#betslip .globalMessages .maxSelectionAllowedError").show();
     }else{
     $("#betslip .globalMessages .maxSelectionAllowedError").hide();
     }*/

    var errorsSelections = getErrorsSelectionsBetslip();


    for (var i in errorsSelections) {
        showGlobalMessages = true;
        error = true;
    }

    if (typeof(errorsSelections['illegalHookupSelectionErrors']) != 'undefined'
        || typeof(errorsSelections['gameDenyErrors']) != 'undefined'
        || typeof(errorsSelections['illegalSportsErrors']) != 'undefined') {
        showGlobalMessages = true;
        error = true;
        if (origen == "placeBet") $(".globalMessages .illegalSelectionBetTypeError").show();
        else $(".globalMessages .illegalSelectionBetTypeError").hide();
    } else {
        $(".globalMessages .illegalSelectionBetTypeError").hide();
    }

    if (typeof(errorsSelections['illegalHookupCombinationErrors']) != 'undefined' ||
        typeof(errorsSelections['sameGameDenyErrors']) != 'undefined' ||
        typeof(errorsSelections['illegalHookupCombinationErrors']) != 'undefined') {
        showGlobalMessages = true;
        error = true;
        if (origen == "placeBet") $(".globalMessages .illegalHookupCombinationErrors").show();
        else $(".globalMessages .illegalHookupCombinationErrors").hide();
    } else {
        $(".globalMessages .illegalHookupCombinationErrors").hide();
    }

    if (checkOpenBetDenyError()) {
        showGlobalMessages = true;
        error = true;
        if (origen == "placeBet") $(".globalMessages .openBetDenyError").show();
        else $(".globalMessages .openBetDenyError").hide();
    } else {
        $(".globalMessages .openBetDenyError").hide();
    }

    if (!initMessage) {
        showGlobalMessages = false;
        error = false;
        $(".globalMessages .minSelectionAllowedError").hide();
        $(".globalMessages .amountError").hide();
        $("#betslip .lowLimitError").hide();
    }

    if (showGlobalMessages && origen == "placeBet")
        $("#betslip .globalMessages").show();
    else
        $("#betslip .globalMessages").hide();

    if (error || totalSelectionsOnbetslip == 0) {
        //$("#betslip #placeBetWrap").hide();
    }
    else {
        //$("#betslip #placeBetWrap").show();
    }

    if (totalSelectionsOnbetslip == 0)
        $("#betslip .emptyBetslip").hide();
    else
        $("#betslip .emptyBetslip").hide();

    if (isNaN(maxToWin) || maxToWin == "") {
        maxToWin = 0;
    }

    $("#betslip .globalAmount .riskAmount").val(getGlobalRiskAmount());

    //if(betslipType != "rndrobin" && origen != "addBetslip"){
    $("#betslip .maxToWin").html(maxToWin);
    $("#betslip .maxRisk").html(maxRisk);
    //}

    if (betslipType == "rndrobin" && ($.trim($("#riskAmount").val()) == "" || $.trim($("#riskAmount").val()) == "0")) {
        $("#betslip .maxToWin").html("");
        $("#betslip .maxRisk").html("");
    }

    if (($('#betslip #roundRobinType').val() > getRoundRobinType())) {
        $("#betslip #roundRobinType").val(getRoundRobinType());
        $("#betslip #roundRobinType option[value=" + getRoundRobinType() + "]").attr('selected', 'selected');
    }

    if (betslipType == "rndrobin") {
        if (countSelectionsOnBetslip() < 3) {
            $("#betslip #placeBetWrap").hide();
        }
        else $("#betslip #placeBetWrap").show();
    }

    loadSelectionLimits();
    sortElements();
    markBlockedSelections();
    markSelectionsErrorBetslip();

    var currentMaxToWin = getGlobalToWinAmount();
    if (!isNaN(maxToWin) && currentMaxToWin != maxToWin) {
        saveGlobalToWinAmount(maxToWin);
    }

    if ($("body.xs #betslip .fpSelectorWrap").attr("style") == "display: none;") {
        $("body.xs #betslip .selection .amount").css("width", "75%");
    }
    else {
        $("body.xs #betslip .selection .amount").css("width", "70%");
    }

    //$('body.xs #betslip .message').css("display","none");
    $('body.xs #betslip .message').each(function () {
        if ($(this).attr("style") == "display: block;") {
            $(this).parent().css("display", "block");
        }
    });

    //Valida si ya hay algo en el betslip
    if (totalSelectionsOnbetslip == 0) {
        $("#placeBet").hide();
        $("#placeBet").html('Your betslip is empty');
        $("#placeBet").css("border", "1px solid #dddddd");
        $("#placeBet").css("background", "linear-gradient(to bottom, #dddddd 0%, #dddddd 100%)");
        $("#placeBet").css("color", "#000000");
        $("#betslip .emptyBetslip").hide();
    }
    else {
        $("#placeBet").show();
        $("#placeBet").html("CREAR TIQUETE");
        $("#placeBet").css("border", "1px solid #BDBDBD");
        $("#placeBet").css("background", "linear-gradient(to bottom, #FFDF1B 0%, #FFDF1B 100%)");
        $("#placeBet").css("color", "#000000");
        $("#betslip .emptyBetslip").hide();
    }
}

// ********** Select betSlip ***********
function DropDown(el) {
    this.cbmBetType = el;
    this.initEvents();
}
DropDown.prototype = {
    initEvents: function () {
        var obj = this;
        obj.cbmBetType.on('click', function (event) {
            $(this).toggleClass('active');
            event.stopPropagation();
        });
    }
}

$(function () {
    var cbmBetType = new DropDown($('#cbmBetType'));
    $(document).click(function () {
        // all dropdowns
        $('.wrapper-dropdown-5').removeClass('active');
    });

});
$(document).click(function () {
    var betslitpTypeCookie = getCookie('betslitpType')
    $('#opSelectedetType').html('straight');
    if (betslitpTypeCookie != null && betslitpTypeCookie != "") {
        $('#opSelectedetType').html(betslitpTypeCookie);
    }
    $("#cbmBetType ul li a").unbind('click');
    $("#cbmBetType ul li a").bind('click', function (e) {
        e.preventDefault();
        var sel = $(this).attr('data-val');
        $('#opSelectedetType').html(sel);
        createCookie('betslitpType', sel, '');
        updateBetSlip("betType");
    });
});
//*************
