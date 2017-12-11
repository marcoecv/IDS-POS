$(document).ready(function() {
    $("#parentID").val('AP');
	
    $('#calendar2').prop('value', setMondayDate());
    $('#calendar3').prop('value', setSundayDate());

    $('#btnFiltre').click(function(e) {
        e.preventDefault();
        var formGroup = $(this).parents('.form-inline').children('.form-group');

        if ($(this).attr('class') == 'show-filtre') {
            formGroup.hide('fade');
            $(this).switchClass('show-filtre', 'hide-filtre')
        } else {
            formGroup.show('fade');
            $(this).switchClass('hide-filtre', 'show-filtre')
        }

        var glyphicon = $(this).children(".glyphicon");
        switchGlyphicon(glyphicon);
    })

    $('#btnAllInfo').click(function(e) {
        e.preventDefault();
        var showData = $('.responsive-data').find('.show-data');
        showData.switchClass('show-data', 'hide-data');

        var glyphicon = $('.responsive-data').find('.glyphicon-minus-sign');
        glyphicon.switchClass('glyphicon-minus-sign', 'glyphicon-plus-sign');
    });

    executeActionPlayer();

    /*$(selector).slimScroll({
        alwaysVisible: true,
        distance: '20px',
        wheelStep: 10,
        allowPageScroll: false,
        disableFadeOut: false
    });*/
});

function getinfo() {
    var id = $('#hiddenCustomerId').val();
    var type = trim($('#accounttype').val());
    $('#agentType').prop('value', type);
    if (type == "M" || type == "A") {
        $('#encontroAgent').prop('value', '1');
    } else {
        $('#encontroAgent').prop('value', '0');
        clean();
    }
}

function sumaTotales(className) {

    var total = 0;
    $("." + className).each(function() {
        total += +this.value;
    });
    return total;
}

function executeActionPlayer() {

    var date = new Date();
    var datestring = ("0" + (date.getMonth() + 1).toString()).substr(-2) + "/" + ("0" + date.getDate().toString()).substr(-2) + "/" + (date.getFullYear().toString());

    var subAgent = $("#subagent").val();
    var summary = $("#summary").is(':checked');
    var startDate = $('#calendar2').prop('value');
    var endDate = $('#calendar3').prop('value');

    var summaryActive = "";

    if (summary) {
        summaryActive = "1";
    } else {
        summaryActive = "0";
    }

    var url = $('#baseurl').val();
    url = url + "AgentReports/executeActionPlayer"; 

    var parametros = {
        SubAgent: subAgent,
        startDate: startDate,
        endDate: endDate,
        summaryActive: summaryActive
    };

    $.ajax({
        type: "POST",
        url: url,
        dataType: "json",
        async: true,
        data: parametros,
        beforeSend: function(){
            $("#reports .overlay").height($(window).height());
            $("#reports .overlay").width($("#reports").width());
            $("#reports .overlay").css("display", "block");
        },
        complete: function(){
            $("#reports .overlay").css("display", "none");
        },
        success: function(data) {
			
            
            
            if (isEmptyO(data)) {
				
                $('#actionplayerdetail').html("");
                $("#actionplayerdiv").hide();
                showMessage('NOROWS', '', '', '', '');
            } else {

                if (!summary) {

                    var contador = 1;
                    var contPlayers = 0;
                    var contFinal = 0;
                    var html = "";
                    var Password = "";
                    var AgentID = "";
                    var OldAgentID = "";
                    var CustomerID = "";
                    var total = 0;
                    var reverse = 0;
                    var others = 0;
                    var count = 0;
                    var adjusment = 0;
                    var horse = 0;
                    var type = "";
                    var parlay = 0;
                    var teaser = 0;
                    var casino = 0;
                    var pending = 0;
                    var straight = 0;
                    var live = 0;
                    var SubTotalstraight = 0;
                    var SubTotalparlay = 0;
                    var SubTotalteaser = 0;
                    var SubTotalreverse = 0;
                    var SubTotallive = 0;
                    var SubTotalhorse = 0;
                    var SubTotaladjusment = 0;
                    var SubTotalcasino = 0;
                    var SubTotaltotal = 0;
                    var SubTotalother = 0;
                    var SubTotalpending = 0;

                    var totalRows = 0;
					
                    $.each(data, function(i, item) {
                        CustomerID = trim(item['customerid']);
                        if (CustomerID != "zz-") {
							totalRows += 1;
                        } 

                    });

                    if (totalRows == 0) {
						$('#actionplayerdetail').html("");
                        $("#actionplayerdiv").hide();
                        showMessage('NOROWS', '', '', '', '');
                    } else {

                        $('#actionplayerdetail').html(html);
                        $("#actionplayerdiv").hide();

                        $.each(data, function(i, item) {

                            AgentID = trim(item['agentid']);
                            CustomerID = trim(item['customerid']);

                            if (CustomerID == "zz-") {

                            } else {

                                Password = item['NameLast'];
                                total = formatnumeric(parseFloat(item['total']), 2, true);
                                reverse = formatnumeric(parseFloat(item['reverse']), 2, true);
                                others = formatnumeric(parseFloat(item['others']), 2, true);
                                count = formatnumeric(item['count'], 0, true);
                                adjusment = formatnumeric(parseFloat(item['adjusment']), 2, true);
                                horse = formatnumeric(parseFloat(item['horse']), 2, true);
                                type = item['type'];
                                parlay = formatnumeric(parseFloat(item['parlay']), 2, true);
                                teaser = formatnumeric(parseFloat(item['teaser']), 2, true);
                                casino = formatnumeric(parseFloat(item['casino']), 2, true);
                                straight = formatnumeric(parseFloat(item['straight']), 2, true);
                                live = formatnumeric(parseFloat(item['live']), 2, true);
                                pending = formatnumeric(parseFloat(item['PendingWagerBalance']), 2, true);

                                if (contador == 1) {
                                    OldAgentID = AgentID;
                                }

                                if (OldAgentID != AgentID || contador == 1) {

                                    if (contador > 1) {
                                        html += "<tr class='subTotalReport'>";

                                        html += "<td data-th='SUB-TOTAL(" + contPlayers + ")' class='one-row'><span class='hidden-xs hidden-sm'>SUB-TOTAL(" + contPlayers + "):</span>";
                                        html += "<div class='wrap-info wrap-info-2col'>";
                                        html += "<span class='info-col2'>" + formatnumeric(SubTotalpending, 2, true) + "</span>";
                                        html += "<span class='info-col3'>" + formatnumeric(SubTotaltotal, 2, true) + "</span>";
                                        html += "<a class='togglePlayerdetail2' href='#'><span class='glyphicon glyphicon-plus-sign'></span></a>";
                                        html += "</div>";
                                        html += "</td>";
                                        html += "<td class='hidden-xs hidden-sm'></td>";

                                        html += "<td class='cell-data' data-th='Straight' >" + formatnumeric(SubTotalstraight, 2, true) + "</td>";
                                        html += "<td class='cell-data' data-th='Parlay' >" + formatnumeric(SubTotalparlay, 2, true) + "</td>";
                                        html += "<td class='cell-data' data-th='Teaser' >" + formatnumeric(SubTotalteaser, 2, true) + "</td>";
                                        html += "<td class='cell-data' data-th='IF/Rev.' >" + formatnumeric(SubTotalreverse, 2, true) + "</td>";
                                        html += "<td class='cell-data' data-th='Live' >" + formatnumeric(SubTotallive, 2, true) + "</td>";
                                        html += "<td class='cell-data' data-th='Horse' >" + formatnumeric(SubTotalhorse, 2, true) + "</td>";
                                        html += "<td class='cell-data' data-th='Others' >" + formatnumeric(SubTotalother, 2, true) + "</td>";
                                        html += "<td class='cell-data' data-th='Adj.' >" + formatnumeric(SubTotaladjusment, 2, true) + "</td>";
                                        html += "<td class='cell-data' data-th='Casino'>" + formatnumeric(SubTotalcasino, 2, true) + "</td>";
                                        html += "<td class='cell-data' data-th='Pending'>" + formatnumeric(SubTotalpending, 2, true) + "</td>";
                                        html += "<td class='cell-data' data-th='Total' >" + formatnumeric(SubTotaltotal, 2, true) + "</td>";
                                        html += "</tr>";

                                        html += "</tr>";


                                        html += "<tr class='customerbanner2'>"
                                        html += "<td data-th='" + AgentID + "' class='agent-id' colspan='13'><span class='hidden-xs hidden-sm'>" + AgentID + "</span>";
                                        html += "<div class='wrap-info wrap-info-2col'>";
                                        html += "<span class='title-info info-col2'>Pend.</span>";
                                        html += "<span class='title-info info-col3'>Total</span>";
                                        html += "<a class='togglePlayerdetail3' rel='" + replaceSpecialCharacters(AgentID.toLowerCase()) + "' href='#'><span class='glyphicon glyphicon-minus-sign'></span></a>";
                                        html += "</div>";
                                        html += "</td>";
                                        html += "</tr>";
                                        html += "<tr class='headerReport'>";
                                        html += "<th >Customer</th>";
                                        html += "<th >Password</th>";
                                        html += "<th >Straight</th>";
                                        html += "<th >Parlay</th>";
                                        html += "<th >Teaser</th>";
                                        html += "<th >IF/Rev.</th>";
                                        html += "<th >Live</th>";
                                        html += "<th >Horse</th>";
                                        html += "<th >Others</th>";
                                        html += "<th >Adj.</th>";
                                        html += "<th >Casino</th>";
                                        html += "<th >Pending</th>";
                                        html += "<th  >Total</th>";
                                        html += "</tr>";

                                        contPlayers = 0;
                                        
                                    } else {
                                        contPlayers = 0;

                                        html += "<tr class='customerbanner2'>";
                                        html += "<td data-th='" + AgentID + "' class='agent-id' colspan='13'><span class='hidden-xs hidden-sm'>" + AgentID + "</span>";
                                        html += "<div class='wrap-info wrap-info-2col'>";
                                        html += "<span class='title-info info-col2'>Pend.</span>";
                                        html += "<span class='title-info info-col3'>Total</span>";
                                        html += "<a class='togglePlayerdetail3' rel='" + replaceSpecialCharacters(AgentID.toLowerCase()) + "' href='#'><span class='glyphicon glyphicon-minus-sign'></span></a>";
                                        html += "</div>";
                                        html += "</td>";
                                        html += "</tr>";
                                        html += "<tr class='headerReport'>";
                                        html += "<th >Customer</th>";
                                        html += "<th >Password</th>";
                                        html += "<th >Straight</th>";
                                        html += "<th >Parlay</th>";
                                        html += "<th >Teaser</th>";
                                        html += "<th >IF/Rev.</th>";
                                        html += "<th >Live</th>";
                                        html += "<th >Horse</th>";
                                        html += "<th >Others</th>";
                                        html += "<th >Adj.</th>";
                                        html += "<th >Casino</th>";
                                        html += "<th >Pending</th>";
                                        html += "<th >Total</th>";
                                        html += "</tr>";
                                    }
                                    SubTotalstraight = 0;
                                    SubTotalparlay = 0;
                                    SubTotalteaser = 0;
                                    SubTotalreverse = 0;
                                    SubTotallive = 0;
                                    SubTotalhorse = 0;
                                    SubTotalother = 0;
                                    SubTotaladjusment = 0;
                                    SubTotalcasino = 0;
                                    SubTotalpending = 0;
                                    SubTotaltotal = 0;
                                }

                                OldAgentID = AgentID;

                                html += "<tr class='playerdetail data-agent data-agent-" + replaceSpecialCharacters(AgentID.toLowerCase()) + "'>";
                                html += "<td data-th='" + CustomerID + "' class='one-row'><span class='hidden-xs hidden-sm'>" + CustomerID + "</span>";
                                html += "<div class='wrap-info wrap-info-2col'>";
                                html += "<span class='info-col2'>" + pending + "</span>";
                                html += "<span class='info-col3'>" + total + "</span>";
                                html += "<a class='togglePlayerdetail' href='#'><span class='glyphicon glyphicon-plus-sign'></span></a>";
                                html += "</div>";
                                html += "</td>";
                                html += "<td class='cell-data' data-th='Password' >" + Password + "</td>";
                                html += "<td class='cell-data' data-th='Straight'><input id=\"straight-" + contador + "\" type=\"hidden\" value=\"" + straight + "\" class=\"Sumstraight \">" + straight + "</td>";
                                html += "<td class='cell-data' data-th='Parlay'><input id=\"parlay-" + contador + "\" type=\"hidden\" value=\"" + parlay + "\" class=\"Sumparlay \">" + parlay + "</td>";
                                html += "<td class='cell-data' data-th='Teaser'><input id=\"teaser-" + contador + "\" type=\"hidden\" value=\"" + teaser + "\" class=\"Sumteaser \">" + teaser + "</td>";
                                html += "<td class='cell-data' data-th='IF/Rev.'><input id=\"reverse-" + contador + "\" type=\"hidden\" value=\"" + reverse + "\" class=\"Sumreverse \">" + reverse + "</td>";
                                html += "<td class='cell-data' data-th='Live'><input id=\"live-" + contador + "\" type=\"hidden\" value=\"" + live + "\" class=\"Sumlive \">" + live + "</td>";
                                html += "<td class='cell-data' data-th='Horse'><input id=\"horse-" + contador + "\" type=\"hidden\" value=\"" + horse + "\" class=\"Sumhorse \">" + horse + "</td>";
                                html += "<td class='cell-data' data-th='Others'><input id=\"others-" + contador + "\" type=\"hidden\" value=\"" + others + "\" class=\"Sumothers \">" + others + "</td>";
                                html += "<td class='cell-data' data-th='Adj.'><input id=\"adjusment-" + contador + "\" type=\"hidden\" value=\"" + adjusment + "\" class=\"Sumadjusment \">" + adjusment + "</td>";
                                html += "<td class='cell-data' data-th='Casino'><input id=\"casino-" + contador + "\" type=\"hidden\" value=\"" + casino + "\" class=\"Sumcasino \">" + casino + "</td>";
                                html += "<td class='cell-data' data-th='Pending'><input id=\"pending-" + contador + "\" type=\"hidden\" value=\"" + pending + "\" class=\"Sumpending \">" + pending + "</td>";
                                html += "<td class='cell-data' data-th='Total'><input id=\"total-" + contador + "\" type=\"hidden\" value=\"" + total + "\" class=\"Sumtotal \">" + total + "</td>";
                                html += "</tr>";

                                contPlayers += 1;
                                contFinal += 1;
                                
                                contador += 1;

                                SubTotalstraight += parseFloat(straight.toString().replace(',', ''));
                                SubTotalparlay += parseFloat(parlay.toString().replace(',', ''));
                                //total
                                SubTotalteaser += parseFloat(teaser.toString().replace(',', ''));
                                SubTotalreverse += parseFloat(reverse.toString().replace(',', ''));
                                SubTotallive += parseFloat(live.toString().replace(',', ''));
                                SubTotalhorse += parseFloat(horse.toString().replace(',', ''));
                                SubTotalother += parseFloat(others.toString().replace(',', ''));
                                SubTotaladjusment += parseFloat(adjusment.toString().replace(',', ''));
                                SubTotalcasino += parseFloat(casino.toString().replace(',', ''));
                                SubTotalpending += parseFloat(pending.toString().replace(',', ''));
                                SubTotaltotal += parseFloat(total.toString().replace(',', ''));

                            }

                        });
                        if (CustomerID == "zz-" && totalRows == 0) {

                        } else {

                            html += "<tr class='subTotalReport'>";
                            html += "<td data-th='SUB-TOTAL(" + contPlayers + ")' class='one-row'><span class='hidden-xs hidden-sm'>SUB-TOTAL(" + contPlayers + "):</span>";
                            html += "<div class='wrap-info wrap-info-3col'>";
                            html += "<span class='info-col1'></span>";
                            html += "<span class='info-col2'>" + formatnumeric(SubTotalpending, 2, true) + "</span>";
                            html += "<span class='info-col3'>" + formatnumeric(SubTotaltotal, 2, true) + "</span>";
                            html += "<a class='togglePlayerdetail2' href='#'><span class='glyphicon glyphicon-plus-sign'></span></a>";
                            html += "</div>";
                            html += "</td>";
                            html += "<td class='hidden-xs hidden-sm'></td>";
                            html += "<td class='cell-data' data-th='Straight' >" + formatnumeric(SubTotalstraight, 2, true) + "</td>";
                            html += "<td class='cell-data' data-th='Parlay' >" + formatnumeric(SubTotalparlay, 2, true) + "</td>";
                            html += "<td class='cell-data' data-th='Teaser' >" + formatnumeric(SubTotalteaser, 2, true) + "</td>";
                            html += "<td class='cell-data' data-th='IF/Rev.' >" + formatnumeric(SubTotalreverse, 2, true) + "</td>";
                            html += "<td class='cell-data' data-th='Live' >" + formatnumeric(SubTotallive, 2, true) + "</td>";
                            html += "<td class='cell-data' data-th='Horse' >" + formatnumeric(SubTotalhorse, 2, true) + "</td>";
                            html += "<td class='cell-data' data-th='Others' >" + formatnumeric(SubTotalother, 2, true) + "</td>";
                            html += "<td class='cell-data' data-th='Adj.' >" + formatnumeric(SubTotaladjusment, 2, true) + "</td>";
                            html += "<td class='cell-data' data-th='Casino'>" + formatnumeric(SubTotalcasino, 2, true) + "</td>";
                            html += "<td class='cell-data' data-th='Pending'>" + formatnumeric(SubTotalpending, 2, true) + "</td>";
                            html += "<td class='cell-data' data-th='Total' >" + formatnumeric(SubTotaltotal, 2, true) + "</td>";
                            html += "</tr>";
                            
                            contPlayers = 0;
                        }

                        $('#actionplayerdetail').append(html);
                        $("#actionplayerdiv").show();

                        if (CustomerID == "zz-" && totalRows == 0) {
                        } else {

                            var totalstraight = sumaTotales("Sumstraight");
                            var totalparlay = sumaTotales("Sumparlay");
                            var totalteaser = sumaTotales("Sumteaser");
                            var totalreverse = sumaTotales("Sumreverse");
                            var totallive = sumaTotales('Sumlive');
                            var totalhorse = sumaTotales("Sumhorse");
                            var totalothers = sumaTotales("Sumothers");
                            var totaladjusment = sumaTotales("Sumadjusment");
                            var totalcasino = sumaTotales('Sumcasino');
                            var totalpending = sumaTotales('Sumpending');
                            var totaltotal = sumaTotales("Sumtotal");

                            var totalhtml = "";
                            totalhtml += "<tr class='totalReport'>";
                            totalhtml += "<td data-th='TOTAL(" + contFinal + ")' class='one-row'><span class='hidden-xs hidden-sm'>TOTAL(" + contFinal + "):</span>";
                            totalhtml += "<div class='wrap-info wrap-info-3col'>";
                            totalhtml += "<span class='info-col1'></span>";
                            totalhtml += "<span class='info-col2'>" + formatnumeric(parseFloat(totalpending), 2, true) + "</span>";
                            totalhtml += "<span class='info-col3'>" + formatnumeric(parseFloat(totaltotal), 2, true) + "</span>";
                            totalhtml += "<a class='togglePlayerdetail4' href='#'><span class='glyphicon glyphicon-plus-sign'></span></a>";
                            totalhtml += "</div>";
                            totalhtml += "</td>";
                            totalhtml += "<td class='hidden-xs hidden-sm'></td>";
                            totalhtml += "<td class='cell-data' data-th='Straight'>" + formatnumeric(parseFloat(totalstraight), 2, true) + "</td>";
                            totalhtml += "<td class='cell-data' data-th='Parlay'>" + formatnumeric(parseFloat(totalparlay), 2, true) + "</td>";
                            totalhtml += "<td class='cell-data' data-th='Teaser'>" + formatnumeric(parseFloat(totalteaser), 2, true) + "</td>";
                            totalhtml += "<td class='cell-data' data-th='IF/Rev.'>" + formatnumeric(parseFloat(totalreverse), 2, true) + "</td>";
                            totalhtml += "<td class='cell-data' data-th='Live'>" + formatnumeric(parseFloat(totallive), 2, true) + "</td>";
                            totalhtml += "<td class='cell-data' data-th='Horse'>" + formatnumeric(parseFloat(totalhorse), 2, true) + "</td>";
                            totalhtml += "<td class='cell-data' data-th='Others'>" + formatnumeric(parseFloat(totalothers), 2, true) + "</td>";
                            totalhtml += "<td class='cell-data' data-th='Adj.'>" + formatnumeric(parseFloat(totaladjusment), 2, true) + "</td>";
                            totalhtml += "<td class='cell-data' data-th='Casino'>" + formatnumeric(parseFloat(totalcasino), 2, true) + "</td>";
                            totalhtml += "<td class='cell-data' data-th='Pending'>" + formatnumeric(parseFloat(totalpending), 2, true) + "</td>";
                            totalhtml += "<td class='cell-data' data-th='Total'>" + formatnumeric(parseFloat(totaltotal), 2, true) + "</td>";
                            totalhtml += "</tr>";

                            $('#actionplayerdetail').append(totalhtml);
                        }
                    }
                } else {

                    // SUMMARY

                    var contador = 1;
                    var html = "";
                    var AgentID = "";
                    var total = 0;
                    var reverse = 0;
                    var others = 0;
                    var count = 0;
                    var adjusment = 0;
                    var horse = 0;
                    var type = "";
                    var parlay = 0;
                    var teaser = 0;
                    var casino = 0;
                    var straight = 0;
                    var live = 0;

                    $('#actionplayerdetail').html(html);
                    $("#actionplayerdiv").hide();

                    html += "<tr class='headerReport'>";
                    html += "<th >Agent</th>";
                    html += "<th >Straight</th>";
                    html += "<th >Parlay</th>";
                    html += "<th >Teaser</th>";
                    html += "<th >IF/Rev.</th>";
                    html += "<th >Live</th>";
                    html += "<th >Horse</th>";
                    html += "<th >Others</th>";
                    html += "<th >Adj.</th>";
                    html += "<th >Casino</th>";
                    html += "<th >Pending</th>";
                    html += "<th >Total</th>";
                    html += "</tr>";

                    html += "<tr class='visible-xs visible-sm'>"
                    html += "<td data-th='Summary' class='agent-id' colspan='13'>";
                    html += "<div class='wrap-info wrap-info-2col'>";
                    html += "<span class='title-info info-col2'>Pend.</span>";
                    html += "<span class='title-info info-col3'>Total</span>";
                    html += "</div>";
                    html += "</td>";
                    html += "</tr>";

                    var totalRows = 0;
                    $.each(data, function(i, item) {
                        AgentID = trim(item['AgentID']);
                        if (AgentID == "zzzzzzzzzzzz" || AgentID == "ZZZZZZZZZZZZZ") {

                        } else {
                            totalRows += 1;
                        }

                    });

                    if (totalRows == 0) {
						$('#actionplayerdetail').html("");
                        $("#actionplayerdiv").hide();
                        showMessage('NOROWS', '', '', '', '');
                    } else {

                        $.each(data, function(i, item) {

                            AgentID = trim(item['AgentID']);

                            if (AgentID == "zzzzzzzzzzzz" || AgentID == "ZZZZZZZZZZZZZ") {

                            } else {
                                total = formatnumeric(parseFloat(item['Total']), 2, true);
                                reverse = formatnumeric(parseFloat(item['Reverse']), 2, true);
                                others = formatnumeric(parseFloat(item['Others']), 2, true);
                                count = formatnumeric(item['Count'], 0, true);
                                adjusment = formatnumeric(parseFloat(item['Adjusment']), 2, true);
                                horse = formatnumeric(parseFloat(item['Horse']), 2, true);
                                type = trim(item['Type']);
                                parlay = formatnumeric(parseFloat(item['Parlay']), 2, true);
                                teaser = formatnumeric(parseFloat(item['Teaser']), 2, true);
                                casino = formatnumeric(parseFloat(item['Casino']), 2, true);
                                pending = formatnumeric(parseFloat(item['PendingWagerBalance']), 2, true);
                                straight = formatnumeric(parseFloat(item['Straight']), 2, true);
                                live = formatnumeric(parseFloat(item['Live']), 2, true);
								
                                html += "<tr class='playerdetail'>";
                                html += "<td data-th='" + AgentID + "' class='one-row'><span class='hidden-xs hidden-sm'>" + AgentID + "</span>";
                                html += "<div class='wrap-info wrap-info-2col'>";

                                html += "<span class='info-col2'>" + pending + "</span>";
                                html += "<span class='info-col3'>" + total + "</span>";
                                html += "<a class='togglePlayerdetail' href='#'><span class='glyphicon glyphicon-plus-sign'></span></a>";
                                html += "</div>";
                                html += "</td>";

                                html += "<td class='cell-data' data-th='STRAIGHT' ><input id=\"straight-" + contador + "\" type=\"hidden\" value=\"" + straight + "\" class=\"Sumstraight \">" + straight + "</td>";
                                html += "<td class='cell-data' data-th='PARLAY' ><input id=\"parlay-" + contador + "\" type=\"hidden\" value=\"" + parlay + "\" class=\"Sumparlay \">" + parlay + "</td>";
                                html += "<td class='cell-data' data-th='TEASER' ><input id=\"teaser-" + contador + "\" type=\"hidden\" value=\"" + teaser + "\" class=\"Sumteaser \">" + teaser + "</td>";
                                html += "<td class='cell-data' data-th='IF/Rev.' ><input id=\"reverse-" + contador + "\" type=\"hidden\" value=\"" + reverse + "\" class=\"Sumreverse \">" + reverse + "</td>";
                                html += "<td class='cell-data' data-th='LIVE' ><input id=\"live-" + contador + "\" type=\"hidden\" value=\"" + live + "\" class=\"Sumlive \">" + live + "</td>";
                                html += "<td class='cell-data' data-th='HORSES' ><input id=\"horse-" + contador + "\" type=\"hidden\" value=\"" + horse + "\" class=\"Sumhorse \">" + horse + "</td>";
                                html += "<td class='cell-data' data-th='OTHERS' ><input id=\"others-" + contador + "\" type=\"hidden\" value=\"" + others + "\" class=\"Sumothers \">" + others + "</td>";
                                html += "<td class='cell-data' data-th='Adj.' ><input id=\"adjusment-" + contador + "\" type=\"hidden\" value=\"" + adjusment + "\" class=\"Sumadjusment \">" + adjusment + "</td>";
                                html += "<td class='cell-data' data-th='CASINO' ><input id=\"casino-" + contador + "\" type=\"hidden\" value=\"" + casino + "\" class=\"Sumcasino \">" + casino + "</td>";
                                html += "<td class='cell-data' data-th='PENDING' ><input id=\"pending-" + contador + "\" type=\"hidden\" value=\"" + pending + "\" class=\"Sumpending \">" + pending + "</td>";
                                html += "<td class='cell-data' data-th='TOTAL' ><input id=\"total-" + contador + "\" type=\"hidden\" value=\"" + total + "\" class=\"Sumtotal \">" + total + "</td>";
                                html += "</tr>";

                                contador += 1;
                            }
                        });

                        $('#actionplayerdetail').append(html);
                        $("#actionplayerdiv").show();

                        var totalstraight = sumaTotales("Sumstraight");
                        var totalparlay = sumaTotales("Sumparlay");
                        var totalteaser = sumaTotales("Sumteaser");
                        var totalreverse = sumaTotales("Sumreverse");

                        var totallive = sumaTotales('Sumlive');
                        var totalhorse = sumaTotales("Sumhorse");
                        var totalothers = sumaTotales("Sumothers");
                        var totaladjusment = sumaTotales("Sumadjusment");
                        var totalcasino = sumaTotales('Sumcasino');
                        var totalpending = sumaTotales('Sumpending');
                        var totaltotal = sumaTotales("Sumtotal");

                        var totalhtml = "";
                        totalhtml += "<tr class='totalReport'>";

                        totalhtml += "<td data-th='TOTAL' class='one-row'><span class='hidden-xs hidden-sm'>TOTAL:</span>";
                        totalhtml += "<div class='wrap-info wrap-info-2col'>";
                        totalhtml += "<span class='info-col2'>" + formatnumeric(parseFloat(totalpending), 2, true) + "</span>";
                        totalhtml += "<span class='info-col3'>" + formatnumeric(parseFloat(totaltotal), 2, true) + "</span>";
                        totalhtml += "<a class='togglePlayerdetail4' href='#'><span class='glyphicon glyphicon-plus-sign'></span></a>";
                        totalhtml += "</div>";
                        totalhtml += "</td>";

                        totalhtml += "<td class='cell-data' data-th='STRAIGHT' >" + formatnumeric(totalstraight, 2, true) + "</td>";
                        totalhtml += "<td class='cell-data' data-th='PARLAY' >" + formatnumeric(totalparlay, 2, true) + "</td>";
                        totalhtml += "<td class='cell-data' data-th='TEASER' >" + formatnumeric(totalteaser, 2, true) + "</td>";
                        totalhtml += "<td class='cell-data' data-th='IF/Rev.' >" + formatnumeric(parseFloat(totalreverse), 2, true) + "</td>";
                        totalhtml += "<td class='cell-data' data-th='LIVE' >" + formatnumeric(totallive, 2, true) + "</td>";
                        totalhtml += "<td class='cell-data' data-th='HORSES' >" + formatnumeric(totalhorse, 2, true) + "</td>";
                        totalhtml += "<td class='cell-data' data-th='OTHERS' >" + formatnumeric(totalothers, 2, true) + "</td>";
                        totalhtml += "<td class='cell-data' data-th='Adj.' >" + formatnumeric(totaladjusment, 2, true) + "</td>";
                        totalhtml += "<td class='cell-data' data-th='CASINO' >" + formatnumeric(totalcasino, 2, true) + "</td>";
                        totalhtml += "<td class='cell-data' data-th='PENDING' >" + formatnumeric(totalpending, 2, true) + "</td>";
                        totalhtml += "<td class='cell-data' data-th='TOTAL' >" + formatnumeric(totaltotal, 2, true) + "</td>";

                        totalhtml += "</tr>";

                        $('#actionplayerdetail').append(totalhtml);

                    }
                }

            }
            (function() {
                $('.cell-data').addClass('hide-data');

                $('.togglePlayerdetail').click(function(e) {
                    e.preventDefault();
                    var cellData = $(this).parents('td').parents(".playerdetail").children(".cell-data");

                    switchClassHideData(cellData);

                    var glyphicon = $(this).find(".glyphicon");

                    switchGlyphicon(glyphicon);

                });

                $('.togglePlayerdetail2').click(function(e) {
                    e.preventDefault();
                    var cellData = $(this).parents('td').parents(".subTotalReport").children(".cell-data");

                    switchClassHideData(cellData)

                    var glyphicon = $(this).find(".glyphicon");
                    switchGlyphicon(glyphicon);

                });

                $('.data-agent').addClass('show-data');

                $('.togglePlayerdetail3').click(function(e) {
                    e.preventDefault();
                    var dataAgent = $('.data-agent-' + $(this).attr('rel'));
                    switchClassHideData(dataAgent);
                    var glyphicon = $(this).find(".glyphicon");
                    switchGlyphicon(glyphicon);
                    switchBtnOpenCloseAll();
                });

                $('.togglePlayerdetail4').click(function(e) {
                    e.preventDefault();
                    var cellData = $(this).parents('td').parents(".totalReport").children(".cell-data");

                    switchClassHideData(cellData);

                    var glyphicon = $(this).find(".glyphicon");
                    switchGlyphicon(glyphicon);
                });

                //
                $('#btnDetailsOpen').hide();

                $('#btnDetailsClose').click(function(e) {
                    e.preventDefault();
                    detailsReportsClose();
                });

                $('#btnDetailsOpen').click(function(e) {
                    e.preventDefault();
                    detailsReportsOpen('togglePlayerdetail3');
                });
            }());
        }
    });
}