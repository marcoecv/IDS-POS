function updateSelection(selection, selectionHtml, oddsStyle) {
    if (selectionHtml.parents('.selection').hasClass('contestant')) {
        if (selection['Status'] == 'O')
            selectionHtml.removeClass('secret');
        else
            selectionHtml.addClass('secret');
        var odd = parseInt(selection['MoneyLine']);
        odd = odd > 0 ? "+" + odd : odd;
        //selectionHtml.find(".threshold").html(formatThreshold(selection));
        selectionHtml.find(".odds").html(odd);
    }
    else {
        if (selection['enable'] == '1')
            selectionHtml.removeClass('secret');
        else
            selectionHtml.addClass('secret');

        var selectionFort = formatThreshold(selection);

        if (typeof selectionFort !== 'undefined') {
            selectionFort = (selectionFort.charAt(0) == "U" || selectionFort.charAt(0) == "O" ? selectionFort.slice(1) : selectionFort);
        } else {
            selectionFort = "";
        }

        selectionHtml.find(".threshold").html(selectionFort);
        var PriceType = siteCache['customer']['PriceType'];  // A- American / F -  fractional
        if (PriceType == "A") {
            selectionHtml.find(".odds").html(formatOdds(selection, oddsStyle));
        } else {
            selectionHtml.find(".odds").html(FixedNumbers(convertOddsToDecimal(selection['oddsUS'])));
        }
    }
}

function getSelectedGroups() {
    var selectedGroups = new Object();
    var checks = $("#sportsMenu input:checked");
    for (var i = 0; i < checks.length; i++) {
        var check = checks.eq(i);
        selectedGroups["group_" + check.val()] = true;
    }

    return selectedGroups;
}


/**
 * Get selected Games Grouped By Category Periods
 *
 * @returns {object} lines : selected Games Grouped By Category Periods
 */
function getSelectedGamesGroupedByCategoryPeriods() {
    if (!isIsset(siteCache['lines']) || !isIsset(siteCache['lines']['games']))
        return;

    var games = siteCache['lines']['games'];
    var selectedGroups = getSelectedGroups();
    var lines = new Object();
    for (var GameNum in games) {
        var game = games[GameNum];
        if (game['enable'] == '1' && checkTimeGame(game)) {
            var groups = game['groups'];
            if (typeof(lines[game['SportType']]) == 'undefined')
                lines[game['SportType']] = new Object();
            var linesSport = lines[game['SportType']];
            var subCategory = (game['SportType'] == 'Soccer' && isIsset(game['ScheduleText'])) ? game['ScheduleText'] : game['SportSubType'];
            var GroupID = sanitiazeId("group_" + game['SportType'] + "_" + subCategory);

            // specific event of other sport
            if (game['SportType'] == 'Other Sports') {
                subCategory = (isIsset(game['ScheduleText'])) ? game['ScheduleText'] : game['SportSubType'];
                GroupID = sanitiazeId("group_" + game['SportSubType'] + "_" + subCategory);
            }

            if (typeof(selectedGroups[GroupID]) != "undefined") {
                if (typeof(linesSport[subCategory]) == 'undefined') {
                    linesSport[subCategory] = new Object();
                    linesSport[subCategory]['periods'] = new Object();
                    linesSport[subCategory]['GroupID'] = GroupID;
                }
                var linesSubCategory = linesSport[subCategory]['periods'];

                for (var groupIndex in groups) {
                    var group = groups[groupIndex];
                    if (group['enable'] == '1') {
                        var PeriodNumber = group["PeriodNumber"];
                        if (typeof(linesSubCategory[PeriodNumber]) == 'undefined') {
                            linesSubCategory[PeriodNumber] = $.extend({}, group);
                            linesSubCategory[PeriodNumber]["games"] = new Object();
                            linesSubCategory[PeriodNumber]["PeriodID"] = linesSport[subCategory]['GroupID'] + "_" + PeriodNumber;
                            delete linesSubCategory[PeriodNumber]['bets'];
                        }
                        var linesPeriod = linesSubCategory[PeriodNumber];
                        var gamesLines = linesPeriod['games'];
                        gamesLines[GameNum] = $.extend({}, game);
                        gamesLines[GameNum]["bets"] = group['bets'];
                        delete gamesLines[GameNum]['groups'];
                    }
                }
            }
        }
    }
    return lines;
}

function getSelectedOtherPropsGroupedByCategory() {
    var selectedGroups = getSelectedGroups();
    var lines = new Object();

    if (!isIsset(siteCache['futures']) || !isIsset(siteCache['futures']['games']))
        return lines;

    var props = siteCache['futures']['games'];
    for (var propID in props) {
        var SportType = getSportTypeWithPropId(propID);
        var GroupID = sanitiazeId("group_" + SportType + "_future props");

        if (typeof(selectedGroups[GroupID]) != "undefined") {
            if (typeof(lines[propID.trim()]) == 'undefined')
                lines[propID.trim()] = new Object();

            for (var contestType2 in props[propID]['groups']) {
                var group = props[propID]['groups'][contestType2];
                if (typeof(lines[propID.trim()][contestType2]) == 'undefined')
                    lines[propID.trim()][contestType2] = new Object();

                lines[propID.trim()][contestType2]['bets'] = group['bets'];
            }
        }
    }
    return lines;
}

/**
 * get Selection Html (sctructure html for a prop)
 *
 * @param   {array} selection  info prop
 * @param   {string} oddsStyle type odd
 * @returns {string} html
 */
function getSelectionHtml(selection, oddsStyle) {
    var threshold = formatThreshold(selection);
    var odds = formatOdds(selection, oddsStyle);
    var secret = (selection['enable'] != '1' ? "secret" : '');

    var hasThreshold = true;
    /**
     * validate  ---  price type
     */
    //var PriceType =  siteCache['customer']['PriceType'];  // A- American / F -  fractional
    var PriceType = getPriceType();
    var html = '';

    if (PriceType == "A") {
        if (selection['betType'] == "M")
            hasThreshold = false;

        if (hasThreshold) {
            html = "<button class='btn btn-primary btn-xs selection addToBetslip " + secret + "' type='button' selectionid='" + selection['id'] + "' >" +
                "<div class='row'>" +
                "<div class='threshold col-xs-12 col-lg-6'>" + threshold + "</div>" +
                "<div class='odds col-xs-12 col-lg-6'>" + odds + "</div>" +
                "</div>" +
                "</button>";
        } else {
            html = "<button class='btn btn-primary btn-xs selection addToBetslip " + secret + "' type='button' selectionid='" + selection['id'] + "' >" +
                "<div class='row'>" +
                "<div class='odds col-xs-12'>" + odds + "</div>" +
                "</div>" +
                "</button>";
        }
    }
    else {
        if (selection['betType'] == "M")
            hasThreshold = false;

        if (hasThreshold) {
            html = "<button class='btn btn-primary btn-xs selection addToBetslip " + secret + "' type='button' selectionid='" + selection['id'] + "' >" +
                "<div class='row'>" +
                "<div class='threshold col-xs-12 col-lg-6'>" + threshold + "</div>" +
                "<div class='odds col-xs-12 col-lg-6'>" + selection['oddsDecimal'] + "</div>" +
                "</div>" +
                "</button>";
        } else {
            html = "<button class='btn btn-primary btn-xs selection addToBetslip " + secret + "' type='button' selectionid='" + selection['id'] + "' >" +
                "<div class='row'>" +
                "<div class='odds col-xs-12'>" + selection['oddsDecimal'] + "</div>" +
                "</div>" +
                "</button>";
        }
    }
    return html;
}

/**
 * complete Number
 * @param {int} n
 * @returns {string} number parced
 */
function completeNumber(n) {
    return n < 10 ? "0" + n : n;
}

/**
 * Get Day Order
 * @param {string} timestamp
 * @returns {string} date parsed
 */
function getDayOrder(timestamp) {
    var gameDate = new Date(parseInt(timestamp));
    return gameDate.getYear() + "" + completeNumber(gameDate.getMonth()) + "" + completeNumber(gameDate.getDate());
}

/**
 * add Game in center panel
 *
 * @param   {string} periodID  id of period
 * @param   {array} game  : info game
 * @param   {string} oddsStyle type odd
 */
var groupdata = "";
function addGame(periodID, game, oddsStyle) {
    var rowSpan = 2;
    var bets = game['bets'];
    var spreadAway = bets['spread']['selections']['away'];
    var spreadHome = bets['spread']['selections']['home'];
    var moneyLineAway = bets['moneyLine']['selections']['away'];
    var moneyLineHome = bets['moneyLine']['selections']['home'];
    var moneyLineDraw = bets['moneyLine']['selections']['draw'];
    var totalOver = bets['total']['selections']['over'];
    var totalUnder = bets['total']['selections']['under'];
    var teamTotalAwayOver = bets['awayTotal']['selections']['over'];
    var teamTotalAwayUnder = bets['awayTotal']['selections']['under'];
    var teamTotalHomeOver = bets['homeTotal']['selections']['over'];
    var teamTotalHomeUnder = bets['homeTotal']['selections']['under'];

    var gameLive = false;
    var myregexp = /LIVE_AVAILABLE/;
    var match = myregexp.exec(game['Comments']);
    gameLive = match !== null;
    if ($("#" + periodID + " ." + game['GameNum']).length === 0) {
        var gameOrder = getDayOrder(game['GameDateTimestamp']) + "" + game['TeamAwayRotNum'];
        var gamedate = timeStampToDateyearFormat(game['GameDateTimestamp']);
        var str = gamedate.replace("/", "");
        str = str.replace("/", "");
        if (groupdata.indexOf(str + "|") != -1) {
            //No imprimir  fecha
            var hasDraw = bets['moneyLine']['selections']['draw']['enable'] == '1';
            var html = "<tbody>";
            html += "<tr class='" + game['GameNum'] + " away' gamenum='" + game['GameNum'] + "'>" +
                "<td class='border-right gameDate' rowspan='" + (hasDraw ? "3" : "2") + "'>" +
                timeStampToDateFormat(game['GameDateTimestamp']) + "<br/>" +
                timeStampToTimeFormat(game['GameDateTimestamp']) + "<br/>" +
                (gameLive ? "<div class='gameLiveIcon'></div> " : "") +
                (game['Status'] == 'I' ? "<div class='gameCircledIcon'></div>" : "") +

                    /*"<a href='#' class='link selectGame' GameNum='"+game['GameNum']+"'>"+
                     countBetsGame(game['GameNum'])+"<span class='glyphicon glyphicon-triangle-right' aria-hidden='true'></span>"+
                     "</a>"+*/
                "</td>" +
                "<td class='border-bottom teamrot'>" +
                "<div class='teamSerial'>" + game['TeamAwayRotNum'] + "</div>" +
                "</td>" +
                "<td class='border-bottom teamInfo'>" +
                "<div class='teamName'>" + game['TeamAwayID'] + "</div>" +
                "<div class='listedPitcher'>" + (game['ListedPitcherAway'] != undefined ? game['ListedPitcherAway'] : "") + "</div>" +
                "</td>" +
                (_LINE_TYPES.indexOf("Spread") != -1 ? "<td class='border-bottom selectionWrap spread'>" + getSelectionHtml(spreadAway, oddsStyle) + "</td>" : "") +
                (_LINE_TYPES.indexOf("MoneyLine") != -1 ? "<td class='border-bottom selectionWrap moneyLine'>" + getSelectionHtml(moneyLineAway, oddsStyle) + "</td>" : "") +
                (_LINE_TYPES.indexOf("Total") != -1 ? "<td class='border-bottom selectionWrap total'>" + getSelectionHtml(totalOver, oddsStyle) + "</td>" : "") +
                (_LINE_TYPES.indexOf("TeamTotal") != -1 ? "<td class='border-bottom selectionWrap teamTotalOver'>" + getSelectionHtml(teamTotalAwayOver, oddsStyle) + "</td>" : "") +
                (_LINE_TYPES.indexOf("TeamTotal") != -1 ? "<td class='border-bottom selectionWrap teamTotalUnder'>" + getSelectionHtml(teamTotalAwayUnder, oddsStyle) + "</td>" : "") +
                "<td id='linkSelectGame_" + game['GameNum'] + "' style='width: 45px;'>" +
                "<div class='link selectGame' GameNum='" + game['GameNum'] + "'>" +
                "<div class='link selectGame outer' GameNum='" + game['GameNum'] + "'>" +
                "<div class='inner'>" +
                "<div style='float:left;'>" + countBetsGame(game['GameNum']) + "</div>" +
                "<div style='float:left;' class='icon-caret'></div>" +
                "<div style='clear:both;'></div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</td>" +
                "</tr>" +
                "<tr class='" + game['GameNum'] + " home border-bottom' gamenum='" + game['GameNum'] + "' >" +
                "<td class='border-bottom teamrot'>" +
                "<div class='teamSerial'>" + game['TeamHomeRotNum'] + "</div>" +
                "</td>" +
                "<td class='teamInfo'>" +
                "<div class='teamName'>" + game['TeamHomeID'] + "</div>" +
                "<div class='listedPitcher'>" + (game['ListedPitcherHome'] != undefined ? game['ListedPitcherHome'] : "") + "</div>" +
                "</td>" +
                (_LINE_TYPES.indexOf("Spread") != -1 ? "<td class='border-bottom selectionWrap spread'>" + getSelectionHtml(spreadHome, oddsStyle) + "</td>" : "") +
                (_LINE_TYPES.indexOf("MoneyLine") != -1 ? "<td class='border-bottom selectionWrap moneyLine'>" + getSelectionHtml(moneyLineHome, oddsStyle) + "</td>" : "") +
                (_LINE_TYPES.indexOf("Total") != -1 ? "<td class='border-bottom selectionWrap total'>" + getSelectionHtml(totalUnder, oddsStyle) + "</td>" : "") +
                (_LINE_TYPES.indexOf("TeamTotal") != -1 ? "<td class='border-bottom selectionWrap teamTotalOver'>" + getSelectionHtml(teamTotalHomeOver, oddsStyle) + "</td>" : "") +
                (_LINE_TYPES.indexOf("TeamTotal") != -1 ? "<td class='border-bottom selectionWrap teamTotalUnder'>" + getSelectionHtml(teamTotalHomeUnder, oddsStyle) + "</td>" : "") +
                "</tr>";
            if (hasDraw) {
                html += "<tr class='" + game['GameNum'] + " draw border-bottom' gamenum='" + game['GameNum'] + "'  order='" + game['TeamAwayRotNum'] + "3'>" +
                    "<td class='teamInfo'>" +
                    "<div class='teamSerial'>" + (game['DrawRotNum'] != undefined ? game['DrawRotNum'] + "." : "") + "</div>" +
                    "</td>"+ 
                    "<td class='border-bottom teamInfo'>"+
                    "<div class='teamName'>Draw</div>" +
                    "</td>" +
                    (_LINE_TYPES.indexOf("Spread") != -1 ? "<td class='border-bottom selectionWrap spread'></td>" : "") +
                    (_LINE_TYPES.indexOf("MoneyLine") != -1 ? "<td class='border-bottom selectionWrap moneyLine'>" + getSelectionHtml(moneyLineDraw, oddsStyle) + "</td>" : "") +
                    (_LINE_TYPES.indexOf("Total") != -1 ? "<td class='border-bottom selectionWrap total'></td>" : "") +
                    (_LINE_TYPES.indexOf("TeamTotal") != -1 ? "<td class='border-bottom selectionWrap teamTotalOver'></td>" : "") +
                    (_LINE_TYPES.indexOf("TeamTotal") != -1 ? "<td class='border-bottom selectionWrap teamTotalUnder'></td>" : "") +
                    "</tr>";
            }
            html += "</tbody>";
        } else {
            //Imprimir fecha
            var hasDraw = bets['moneyLine']['selections']['draw']['enable'] == '1';
            var html = "<tbody>";
            // html += "<tr class='' style=\"height: 8px;\" ><td  colspan=\"8\" class='headersOverview'>" + getTextJs['sportbook_group_Date'] + ": " + timeStampToDateyearFormat(game['GameDateTimestamp']) + "</td></tr>";
            html += "<tr class='" + game['GameNum'] + " away' gamenum='" + game['GameNum'] + "'>" +
                "<td class='border-right gameDate' rowspan='" + (hasDraw ? "3" : "2") + "'>" +
                timeStampToDateFormat(game['GameDateTimestamp']) + "<br/>" +
                timeStampToTimeFormat(game['GameDateTimestamp']) + "<br/>" +

                (gameLive ? "<div class='gameLiveIcon'></div> " : "") +
                (game['Status'] == 'I' ? "<div class='gameCircledIcon'></div>" : "") +

                    /*"<a href='#' class='link selectGame' GameNum='"+game['GameNum']+"'>"+
                     countBetsGame(game['GameNum'])+"<span class='glyphicon glyphicon-triangle-right' aria-hidden='true'></span>"+
                     "</a>"+*/
                "</td>" +
                "<td class='border-bottom teamrot'>" +
                "<div class='teamSerial'>" + game['TeamAwayRotNum'] + "</div>" +
                "</td>" +

                "<td class='border-bottom teamInfo'>" +
                "<div class='teamName'>" + game['TeamAwayID'] + "</div>" +
                "<div class='listedPitcher'>" + (game['ListedPitcherAway'] != undefined ? game['ListedPitcherAway'] : "") + "</div>" +
                "</td>" +
                (_LINE_TYPES.indexOf("Spread") != -1 ? "<td class='border-bottom selectionWrap spread'>" + getSelectionHtml(spreadAway, oddsStyle) + "</td>" : "") +
                (_LINE_TYPES.indexOf("MoneyLine") != -1 ? "<td class='border-bottom selectionWrap moneyLine'>" + getSelectionHtml(moneyLineAway, oddsStyle) + "</td>" : "") +
                (_LINE_TYPES.indexOf("Total") != -1 ? "<td class='border-bottom selectionWrap total'>" + getSelectionHtml(totalOver, oddsStyle) + "</td>" : "") +
                (_LINE_TYPES.indexOf("TeamTotal") != -1 ? "<td class='border-bottom selectionWrap teamTotalOver'>" + getSelectionHtml(teamTotalAwayOver, oddsStyle) + "</td>" : "") +
                (_LINE_TYPES.indexOf("TeamTotal") != -1 ? "<td class='border-bottom selectionWrap teamTotalUnder'>" + getSelectionHtml(teamTotalAwayUnder, oddsStyle) + "</td>" : "") +
                "<td id='linkSelectGame_" + game['GameNum'] + "' style='width: 45px;'>" +
                "   <div class='link selectGame' GameNum='" + game['GameNum'] + "'>" +
                "<div class='link selectGame outer' GameNum='" + game['GameNum'] + "'>" +
                "<div class='inner'>" +
                "<div style='float:left;'>" + countBetsGame(game['GameNum']) + "</div>" +
                "<div style='float:left;' class='icon-caret'></div>" +
                "<div style='clear:both;'></div>" +
                "</div>" +
                "</div>" +
                "   </div>" +
                "</td>" +
                "</tr>" +
                "<tr class='" + game['GameNum'] + " home border-bottom' gamenum='" + game['GameNum'] + "' >" +
                "<td class='border-bottom teamrot'>" +
                "<div class='teamSerial'>" + game['TeamHomeRotNum'] + "</div>" +
                "</td>" +
                "<td class='teamInfo'>" +
                "<div class='teamName'>" + game['TeamHomeID'] + "</div>" +
                "<div class='listedPitcher'>" + (game['ListedPitcherHome'] != undefined ? game['ListedPitcherHome'] : "") + "</div>" +
                "</td>" +
                (_LINE_TYPES.indexOf("Spread") != -1 ? "<td class='border-bottom selectionWrap spread'>" + getSelectionHtml(spreadHome, oddsStyle) + "</td>" : "") +
                (_LINE_TYPES.indexOf("MoneyLine") != -1 ? "<td class='border-bottom selectionWrap moneyLine'>" + getSelectionHtml(moneyLineHome, oddsStyle) + "</td>" : "") +
                (_LINE_TYPES.indexOf("Total") != -1 ? "<td class='border-bottom selectionWrap total'>" + getSelectionHtml(totalUnder, oddsStyle) + "</td>" : "") +
                (_LINE_TYPES.indexOf("TeamTotal") != -1 ? "<td class='border-bottom selectionWrap teamTotalOver'>" + getSelectionHtml(teamTotalHomeOver, oddsStyle) + "</td>" : "") +
                (_LINE_TYPES.indexOf("TeamTotal") != -1 ? "<td class='border-bottom selectionWrap teamTotalUnder'>" + getSelectionHtml(teamTotalHomeUnder, oddsStyle) + "</td>" : "") +
                "</tr>";
            if (hasDraw) {
                html += "<tr class='" + game['GameNum'] + " draw border-bottom' gamenum='" + game['GameNum'] + "'  order='" + game['TeamAwayRotNum'] + "3'>" +
                    "<td class='teamInfo'>" +
                    "<div class='teamSerial'>" + (game['DrawRotNum'] != undefined ? game['DrawRotNum'] + "." : "") + "</div>" +
                    "</td>"+ 
                    "<td class='border-bottom teamInfo'>"+
                    "<div class='teamName'>" + getTextJs['sportbook_group_Draw'] + "</div>" +
                    "</td>" +
                    (_LINE_TYPES.indexOf("Spread") != -1 ? "<td class='border-bottom selectionWrap spread'></td>" : "") +
                    (_LINE_TYPES.indexOf("MoneyLine") != -1 ? "<td class='border-bottom selectionWrap moneyLine'>" + getSelectionHtml(moneyLineDraw, oddsStyle) + "</td>" : "") +
                    (_LINE_TYPES.indexOf("Total") != -1 ? "<td class='border-bottom selectionWrap total'></td>" : "") +
                    (_LINE_TYPES.indexOf("TeamTotal") != -1 ? "<td class='border-bottom selectionWrap teamTotalOver'></td>" : "") +
                    (_LINE_TYPES.indexOf("TeamTotal") != -1 ? "<td class='border-bottom selectionWrap teamTotalUnder'></td>" : "") +
                    "</tr>";
            }
            html += "</tbody>";
        }
        groupdata += str + "|";
        //$("#"+periodID+" tbody.mainBody").append(html);
        $("#" + periodID + " .table-games").append(html);
    }
    else {
        var period = $("#" + periodID);
        //updating values

        if (_LINE_TYPES.indexOf("Spread") != -1) {
            updateSelection(spreadAway, period.find("." + game['GameNum'] + ".away .spread .selection"), oddsStyle);
        }
        if (_LINE_TYPES.indexOf("MoneyLine") != -1) {
            updateSelection(moneyLineAway, period.find("." + game['GameNum'] + ".away .moneyLine .selection"), oddsStyle);
        }
        if (_LINE_TYPES.indexOf("Total") != -1) {
            updateSelection(totalOver, period.find("." + game['GameNum'] + ".away .total .selection"), oddsStyle);
        }
        if (_LINE_TYPES.indexOf("TeamTotal") != -1) {
            updateSelection(teamTotalAwayOver, period.find("." + game['GameNum'] + ".away .teamTotalOver .selection"), oddsStyle);
            updateSelection(teamTotalAwayUnder, period.find("." + game['GameNum'] + ".away .teamTotalUnder .selection"), oddsStyle);
        }
        if (_LINE_TYPES.indexOf("Spread") != -1) {
            updateSelection(spreadHome, period.find("." + game['GameNum'] + ".home .spread .selection"), oddsStyle);
        }
        if (_LINE_TYPES.indexOf("MoneyLine") != -1) {
            updateSelection(moneyLineHome, period.find("." + game['GameNum'] + ".home .moneyLine .selection"), oddsStyle);
        }
        if (_LINE_TYPES.indexOf("Total") != -1) {
            updateSelection(totalUnder, period.find("." + game['GameNum'] + ".home .total .selection"), oddsStyle);
        }
        if (_LINE_TYPES.indexOf("TeamTotal") != -1) {
            updateSelection(teamTotalHomeOver, period.find("." + game['GameNum'] + ".home .teamTotalOver .selection"), oddsStyle);
            updateSelection(teamTotalHomeUnder, period.find("." + game['GameNum'] + ".home .teamTotalUnder .selection"), oddsStyle);
        }
        updateSelection(moneyLineDraw, period.find("." + game['GameNum'] + ".draw .moneyLine .selection"), oddsStyle);
    }
    var period = $("#" + periodID);
    rowSpan = period.find("." + game['GameNum']).length;

    period.find("#linkSelectGame_" + game['GameNum']).attr("rowspan", rowSpan);

    if (getCurrentSize() == "lg") {
        period.find("#linkSelectGame_" + game['GameNum']).find(".selectGame").css("height", (36 * rowSpan).toString() + "px")
        period.find("#linkSelectGame_" + game['GameNum']).find(".selectGame span").css("padding", "5px");
    } else if (getCurrentSize() == "sm" || getCurrentSize() == "md") {
        period.find("#linkSelectGame_" + game['GameNum']).find(".selectGame").css("height", (48 * rowSpan).toString() + "px")
        period.find("#linkSelectGame_" + game['GameNum']).find(".selectGame span").css("padding", "5px");
    }
}

/**
 * get PeriodID
 *
 * @param   {string} groupID Description
 * @param   {string} PeriodNumber Description
 * @returns {string} id period
 */
function getPeriodID(groupID, PeriodNumber) {
    return sanitiazeId("period_" + groupID + "_" + PeriodNumber);
}

/**
 * add Period
 *
 * @param   {string} groupID
 * @param   {array} period
 * @param   {string} oddsStyle
 *
 * @returns {string} id period
 */
function addPeriod(groupID, period, oddsStyle) {
    var periodID = getPeriodID(groupID, period["PeriodNumber"]);
    if ($("#" + periodID).length == 0) {
        var html = "<div class='margin-bottom period' id='" + periodID + "'>" +
            "<table class='table-games sort'>" +
            "<thead order='0'>" +
            "<tr class='border-bottom'>" +
            "<th>Date</th>" +
            "<th>Rot#</th>" +
            "<th>Team</th>" +
            (_LINE_TYPES.indexOf("Spread") != -1 ? "<th>" + getTextJs['sportbook_game_Spread'] + "</th>" : "") +
            (_LINE_TYPES.indexOf("MoneyLine") != -1 ? "<th>" + getTextJs['sportbook_game_MoneyLine'] + "</th>" : "") +
            (_LINE_TYPES.indexOf("Total") != -1 ? "<th>" + getTextJs['sportbook_game_Total'] + "</th>" : "") +
            (_LINE_TYPES.indexOf("TeamTotal") != -1 ? "<th colspan='2'>" + getTextJs['sportbook_game_TeamTotal'] + "</th>" : "") +
            "</tr>" +
            "</thead>" +
            "</table>" +
            "</div>";
        $("#" + groupID + " .periods").append(html);
    }
    var posicion = [];
    //adding games for period
    var games = period['games'];
    for (var GameNum in games) {
        if (theGameIsValid(games[GameNum])) {
            // addGame(periodID, games[GameNum], oddsStyle);
            var GameDateTime = games[GameNum]['GameDateTime'].substr(0, 10);
            posicion.push({
                Comments: games[GameNum]['Comments'],
                GameDateTime: GameDateTime,
                GameDateTimestamp: games[GameNum]['GameDateTimestamp'],
                GameNum: games[GameNum]['GameNum'],
                ParlayRestriction: games[GameNum]['ParlayRestriction'],
                ScheduleText: games[GameNum]['ScheduleText'],
                SportSubType: games[GameNum]['SportSubType'],
                SportType: games[GameNum]['SportType'],
                Status: games[GameNum]['Status'],
                TeamAwayID: games[GameNum]['TeamAwayID'],
                TeamAwayRotNum: games[GameNum]['TeamAwayRotNum'],
                TeamHomeID: games[GameNum]['TeamHomeID'],
                TeamHomeRotNum: games[GameNum]['TeamHomeRotNum'],
                bets: games[GameNum]['bets'],
                enable: games[GameNum]['enable'],
                enableBets: games[GameNum]['enableBets'],
                ListedPitcherAway: games[GameNum]['ListedPitcherAway'],
                ListedPitcherHome: games[GameNum]['ListedPitcherHome']
            });
        }
    }
    var res = alasql('SELECT *  FROM ? order by GameDateTime,TeamAwayRotNum asc', [posicion]);
    for (var i in res) {
        if (checkTimeGame(res[i]))
            addGame(periodID, res[i], oddsStyle);
    }
    //removing disabled games in period
    var gameRows = $("#" + periodID + " > tbody > tr");
    for (var i = 0; i < gameRows.length; i++) {
        var gameRow = gameRows.eq(i);
        if (typeof(games[gameRow.attr("gamenum")]) == 'undefined')
            gameRow.remove();
    }
    /**
     *Limpiamos variable global para  agrupar las lineas por fecha
     *   groupdata
     */
    groupdata = "";
    return periodID;
}

/**
 * add Period Selector
 *
 * @param   {string} groupID
 * @param   {array} periods , props for a period
 */
function addPeriodSelector(groupID, periods) {
    var sliderID = "slider_" + groupID;

    //verify if slider has all periods or extra periods
    var targets1 = new Object();
    var targets2 = new Object();
    if ($("#" + sliderID).length > 0) {
        var toggleContainers = $("#" + sliderID + " .toggle-container");
        for (var i in periods) {
            var period = periods[i];
            var periodID = getPeriodID(groupID, period["PeriodNumber"]);
            targets1["#" + periodID] = true;
        }

        var toggleContainers = $("#" + sliderID + " .toggle-container");
        for (var j = 0; j < toggleContainers.length; j++) {
            var toggleContainer = toggleContainers.eq(j);
            targets2[toggleContainer.attr('target')] = true;
        }

        for (var target in targets1)
            if (typeof(targets2[target]) == 'undefined')
                $("#" + sliderID).remove();

        for (var target in targets2)
            if (typeof(targets1[target]) == 'undefined')
                $("#" + sliderID).remove();
    }

    //creating a new slider
    if ($("#" + sliderID).length == 0) {
        var displayPieces = 0;
        var periodButtonsHtml = "";
        for (var i in periods) {
            displayPieces++;
            var period = periods[i];
            var periodID = getPeriodID(groupID, period["PeriodNumber"]);
            periodButtonsHtml += "<div style='float:left;'>" +
                "<button class='btn btn-primary btn-sm btn-md toggle-container' type='button' target='#" + periodID + "' style='float:left; margin-right: 3px;'>" +
                "<span class='long-period-name'>" + $.trim(period['description']) + "</span><span class='short-period-name'>" + $.trim(period['description_short']) + "</span>" +
                "</button>" +
                "</div>";
        }

        var html = "<div id=" + sliderID + " class='subGroupSelector'>" +
            "<div class='buttonsWrap'>" +
            periodButtonsHtml +
            "<div style='clear:both;'></div>" +
            "</div>" +
            "</div>";

        $("#" + groupID + " .sliderWrap").html(html);
        var options = {
            //$SlideWidth: 80,
            $SlideSpacing: 3,
            $DisplayPieces: (displayPieces > 1 ? displayPieces - 1 : 1)
        };

        $("#" + sliderID + " .toggle-container").click(function () {
            $($(this).attr("target")).siblings(".period").hide();
            $($(this).attr("target")).show();
            $(this).parents('.buttonsWrap').find(".toggle-container").removeClass('btn-success').addClass('btn-primary');
            $(this).addClass('btn-success');
        }).first().click();

        ScaleSlider(false);
    }
}

/**
 * add Group
 *
 * @param   {string} SportType
 * @param   {string} SportSubType
 * @param   {array} periods , props for a period
 * @param   {string} oddsStyle
 *
 * @returns {string} groupId
 */
function addGroup(SportType, SportSubType, periods, oddsStyle) {
    var groupID = sanitiazeId("group_" + SportType + "_" + SportSubType);
    if ($("#" + groupID).length == 0) {
        var html = "<div class='group' id=" + groupID + " order='" + sportsOrder[SportType] + "'>" +
            "<div class='title' data-toggle='collapse' href='#body_" + groupID + "'>" +
            SportType + " " + SportSubType +
            "<div class='toggle-icon'></div>" +
            "</div>" +
            "<div id='body_" + groupID + "' class='in margin-bottom'>" +
            "<div class='sliderWrap'></div>" +
            "<div class='periods'></div>" +
            "</div>" +
            "</div>";
        $("#groupsWrapLong").append(html);
    }

    //adding periods to group
    var periodsID = new Object();
    for (var i in periods) {
        var periodID = addPeriod(groupID, periods[i], oddsStyle);
        periodsID[periodID] = true;
    }

    //removing disabled periods in group
    var periodsHtml = $("#" + groupID + " .period");
    for (var i = 0; i < periodsHtml.length; i++) {
        var period = periodsHtml.eq(i);
        if (typeof(periodsID[period.attr("id")]) == 'undefined')
            period.remove();
    }

    addPeriodSelector(groupID, periods);

    return groupID;
}

/**
 * Add Group FutureProp
 *
 * @param   {string} futureID id prop
 * @param   {array} futureData Description
 * @param   {string} oddsStyle  Description
 *
 * @returns {string} groupID
 */
function addGroupFutureProp(futureID, futureData, oddsStyle) {
    var sportType = getSportTypeWithPropId(futureID);
    var futureIdParced = futureID.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, '');
    var groupID = sanitiazeId("group_" + sportType + "_" + futureIdParced + "_future_props");

    if ($("#" + groupID).length == 0) {

        var html = "<div class='group' id=" + groupID + " order='" + sportsOrder[sportType] + "'>" +
            "<div class='groupTitle h4 ellipsis'>" +
            "<div>" +
            "Future Props " + sportType +
            "</div>" +
            "</div>" +
            "<div id='body_" + groupID + "' class='bodyGroup margin-bottom'>" +
            "<div class='props'></div>" +
            "</div>" +
            "</div>";
        $("#groupsWrapLong").append(html);
    }

    $('#body_' + groupID + " .props").html('');
    for (var contentType2 in futureData) {
        var bets = futureData[contentType2]['bets'];
        for (var contestNum in bets) {
            var contest = bets[contestNum];
            var ContestID = addSubGroupFutureProps(groupID, contestNum, oddsStyle);
            addFutureProps(groupID, ContestID, contest, oddsStyle);
        }
    }
    return groupID;
}

/**
 * add Sub Group Future Props
 *
 * @param   {string} groupID
 * @param   {string} contestNum
 * @param   {string} oddsStyle
 *
 * @returns {string} id group contest
 */
function addSubGroupFutureProps(groupID, contestNum, oddsStyle) {
    if ($("#group_contest_" + contestNum).length == 0) {
        var html = '<div id="group_contest_' + contestNum + '" class="table-games futureProps" contestId="' + contestNum + '">';
        html += "<div class='title header' data-toggle='collapse' href='#list_group_" + contestNum + "'>";
        html += "<div class='ellipsis'>";
        html += "<div class='titleText'></div>";
        html += "</div>";
        html += "<div class='toggle-icon'></div>";
        html += "</div>";
        html += "<ul id ='list_group_" + contestNum + "' class='selectionList row sort'></ul>";
        html += '</div>';

        $('#body_' + groupID + " .props").append(html);
        eventCollapse($('#groupsWrapLong #group_contest_' + contestNum + ' .title'));
    }
    return 'group_contest_' + contestNum;
}

function addDisableGroup(data) {
    for (var i in data) {
        if (isIsset(data[i])) {
            var row = data[i];
            var title = '';
            if (row['Type'] == 'Game') {
                title = data[i]['SportType'] + " " + data[i]['SportSubType'];
            } else {
                title = data[i]['description'];
            }

            var html = "<div class='group'>" +
                "<div class='title'>" +
                title +
                "</div>" +
                "<div class='in margin-bottom'>" +
                "<div class='message'><div>No Games Available at the moment</div></div>" +
                "</div>" +
                "</div>";
            $("#groupsWrapLong").append(html);
        }
    }
}

/**
 * add list Future Props for a group contest
 *
 * @param   {string} groupID     group ID
 * @param   {string} contestID    contest ID
 * @param   {array} groupContest data
 * @param   {string} oddsStyle    Description
 *
 */
function addFutureProps(groupID, contestID, groupContest, oddsStyle) {
    var html = '';
    var headerContest = false;
    var countRows = Object.keys(groupContest['selections']).length;

    for (var contestantNum in groupContest['selections']) {
        var contestant = groupContest['selections'][contestantNum];
        var odd = parseInt(contestant['oddsDecimal']);
        odd = odd > 0 ? "+" + odd : odd;
        var moneyLine = parseInt(contestant['oddsUS']);
        moneyLine = moneyLine > 0 ? "+" + moneyLine : moneyLine;

        if (!isNaN(moneyLine) && moneyLine != 0) {
            if (!headerContest) {
                $('#' + groupID + ' .props #' + contestID + ' .title .titleText').html(groupContest['description']);
                headerContest = true;
            }

            var contestantId = contestant['id'];
            var ContestNum = groupContest['ContestNum'];
            var order = 1;
            var colClass = 'col-xs-12';
            if (countRows > 1) {
                colClass = (countRows == 2) ? 'col-xs-6' : 'col-xs-4';
            }
            html += "<li class='addToBetslip " + colClass + "' id='" + contestantId + "' selectionid='" + ContestNum + '_' + contestantNum + "' order='" + order + "'>" +
                "<div class='selectionTable' " + (countRows >= 3 ? "style='height: 40px;'" : "") + ">" +
                "<div class='selectionFix'>" +
                "<div class='selectionContent ellipsis'>" +
                "<div class='selectionDesc' style='text-align: center;'>" + contestant['description'] + "</div>" +
                "<div class='noWrap' style='text-align: center;'>" +
                "<span class='selectionThreshold threshold'>" + (!isNaN(contestant['threshold']) && contestant['threshold'] != "" ? formatFracionalHtml(contestant['threshold']) : "") + "</span>&nbsp;&nbsp;" +
                "<span class='selectionThreshold threshold'>" + moneyLine + "</span>" +
                "<span class='selectionOdds odds'>" + "" + "</span>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</li>";
        }
    }

    if (html != '') {
        eval("$('#body_'+groupID+' .props #'+contestID+' ul.selectionList').html(html)");
    }
    else {
        // Remove elements
        $('#body_' + groupID + ' .props #' + contestID).remove();
        if ($('#body_' + groupID + ' .props .futureProps').length == 0) {
            $('#body_' + groupID).remove();
        }
        if ($('#' + groupID + ' .bodyGroup').length == 0) {
            $('#' + groupID).remove();
        }
    }
}

/**
 * Add Odd Color To Games
 */
function addOddColorToGames() {
    //adding odd color
    $(".period .table-games").each(function () {
        var trs = $(this).find('tbody tr');
        var odd = true;
        var lastGameNum = null;
        for (var i = 0; i < trs.length; i++) {
            var tr = trs.eq(i);

            if (lastGameNum == null)
                lastGameNum = tr.attr('gamenum');

            if (lastGameNum != tr.attr('gamenum'))
                odd = !odd;

            if (odd)
                tr.addClass("odd");
            else
                tr.removeClass("odd");

            lastGameNum = tr.attr('gamenum');
        }
    });
}

/**
 * Set Width Slider
 * @param {int} finalWidth
 */
function setWidthSlider(finalWidth) {
    var currentWidth = $(".subGroupSelector").width();
    if (currentWidth != finalWidth) {
        $(".subGroupSelector").width(finalWidth);
        $(".subGroupSelector > div").width(finalWidth);
        $(".buttonsWrap").width(finalWidth);
    }
}
/**
 * Scale Slider Aux
 */
function ScaleSliderAux() {
    var adjust = 0;
    var groupWidth = $("#groupsWrap").width() - adjust;
    var bodyWidth = document.body.clientWidth - adjust;
    var finalWidth = Math.min(groupWidth, bodyWidth);//, 495)//*0.95;

    setWidthSlider(finalWidth);
}
/**
 * Scale Slider
 */
var lastWidthScaleSlider = 0;
function ScaleSlider(force) {
    var width = window.innerWidth;
    if (lastWidthScaleSlider != width || force) {
        lastWidthScaleSlider = width;
        setWidthSlider(20);
        setTimeout(ScaleSliderAux, 100);
    }
}

function multiColumnforFuturePropGroup(idGroup) {
    var group = $('#' + idGroup);
    var groupContest = group.find('.futureProps');

    for (var i in groupContest) {
    }
}

/**
 * get GroupID Games Enable
 *
 * @param   {object} gamesEnable
 *
 * @returns {object} groupIDGamesEnable: groupId enable
 */
function getGroupIDGamesEnable(gamesEnable) {
    //1 arranges the groupID of GamesEnable
    var groupIDGamesEnable = new Object();
    for (var gameEnable in gamesEnable) {
        var groups = gamesEnable[gameEnable];
        for (var group in groups) {
            if (typeof(groupIDGamesEnable[groups[group]['GroupID']]) == "undefined")
                groupIDGamesEnable[groups[group]['GroupID']] = true;
        }
    }
    return groupIDGamesEnable;
}

/**
 * get Disable Group Other Props
 *
 * @param   {object} propsEnable : selected Props
 * @returns {object} disableGroup: selected Group Games without data
 */
function getDisableGroupOtherProps(propsEnable) {
    var selectedGroups = getSelectedGroups();
    var groupIDPropsEnable = getGroupIDGamesEnable(propsEnable);
    var disableGroup = new Object();

    //2 extracts the GroupId not in object groupIDGamesEnable 
    for (var select in selectedGroups) {
        if (typeof(groupIDPropsEnable[select]) == "undefined") {
            disableGroup[select] = new Object();
        }
    }

    if (isIsset(siteCache['futures']) && isIsset(siteCache['futures']['games'])) {
        var props = siteCache['futures']['games'];
        for (var propID in props) {
            var SportType = getSportTypeWithPropId(propID);
            var GroupID = sanitiazeId("group_" + SportType + "_future props");
            if (typeof(disableGroup[GroupID]) != "undefined" &&
                typeof(disableGroup[GroupID]['SportType']) == "undefined") {
                disableGroup[GroupID]['Type'] = 'Prop';
                disableGroup[GroupID]['SportType'] = getSportTypeWithPropId(propID);
                disableGroup[GroupID]['ContestType'] = (props[propID]['ContestType'] != undefined) ? props[propID]['ContestType'] : null;
                disableGroup[GroupID]['description '] = (props[propID]['description'] != undefined) ? props[propID]['description'] : null;
            }
        }
    }
    return disableGroup;
}
/**
 * get Disable Group Game
 *
 * @param   {object} gamesEnable : selected Games Grouped By Category Periods
 * @returns {object} disableGroup: selected Group Games without data
 */
function getDisableGroupGame(gamesEnable) {
    var selectedGroups = getSelectedGroups();
    var groupIDGamesEnable = getGroupIDGamesEnable(gamesEnable);
    var disableGroup = new Object()

    //2 extracts the GroupId not in object groupIDGamesEnable 
    for (var select in selectedGroups) {
        if (typeof(groupIDGamesEnable[select]) == "undefined") {
            disableGroup[select] = new Object;
        }
    }

    //3
    if (isIsset(disableGroup) && isIsset(siteCache['lines']) && isIsset(siteCache['lines']['games'])) {
        var games = siteCache['lines']['games'];

        for (var GameNum in games) {
            var game = games[GameNum];
            var subCategory = (game['SportType'] == 'Soccer' && isIsset(game['ScheduleText'])) ? game['ScheduleText'] : game['SportSubType'];
            var GroupID = sanitiazeId("group_" + game['SportType'] + "_" + subCategory);

            // specific event of other sport
            if (game['SportType'] == 'Other Sports') {
                subCategory = (isIsset(game['ScheduleText'])) ? game['ScheduleText'] : game['SportSubType'];
                GroupID = sanitiazeId("group_" + game['SportSubType'] + "_" + subCategory);
            }

            if (typeof(disableGroup[GroupID]) != "undefined" &&
                typeof(disableGroup[GroupID]['SportType']) == "undefined") {
                disableGroup[GroupID]['Type'] = 'Game';
                disableGroup[GroupID]['SportType'] = game['SportType'];
                disableGroup[GroupID]['SportSubType'] = (typeof(game['SportSubType']) != undefined) ? game['SportSubType'] : null;
                disableGroup[GroupID]['ScheduleText'] = (typeof(game['ScheduleText']) != undefined) ? game['ScheduleText'] : null;
            }
        }
    }
    return disableGroup;
}

/**
 * update Group Categories
 */
function updateGroupCategories() {
    var games = getSelectedGamesGroupedByCategoryPeriods();
    var otherProps = getSelectedOtherPropsGroupedByCategory();

    var oddsStyle = getOddsStyle();
    //adding groups
    var groupIDs = new Object();
    for (var SportType in games) {
        var SportTypeData = games[SportType];
        for (var SportSubType in SportTypeData) {
            var periods = SportTypeData[SportSubType]['periods'];
            var groupID = addGroup(SportType, SportSubType, periods, oddsStyle);
            groupIDs[groupID] = true;
        }
    }

    // Other props
    for (var prop in otherProps) {
        var data = otherProps[prop];
        if (Object.keys(data).length != 0) {
            var groupID = addGroupFutureProp(prop, data, oddsStyle);
            groupIDs[groupID] = true;
        }
    }

    //removing disable groups
    var groups = $("#groupsWrapLong .group");
    for (var i = 0; i < groups.length; i++) {
        var group = groups.eq(i);
        if (typeof(groupIDs[group.attr("id")]) == 'undefined')
            group.remove();
    }

    // Disable Group
    //addDisableGroup(getDisableGroupGame(games));
    //addDisableGroup(getDisableGroupOtherProps(otherProps));
}

// verifier si groupe vide

// inserte header y message

$(document).ready(function () {
    $(window).bind("load", function () {
        ScaleSlider(false);
    });
    $(window).bind("resize", function () {
        ScaleSlider(false);
    });
    $(window).bind("orientationchange", function () {
        ScaleSlider(false);
    });
    setTimeout(function () {
        ScaleSlider(false);
    }, 2000);
});
