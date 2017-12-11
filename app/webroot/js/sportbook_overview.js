/**
 * load data Overview NowInPlay Live
 */
var xhrOverviewNowInPlay = null;
var xhrOverviewUpComingLive = null;
var xhrOverviewUpComingPregame = null;
var countElementOverview = 0;

function loadOverview(){
    if (xhrOverviewNowInPlay !=null)
        xhrOverviewNowInPlay.abort();
    if (xhrOverviewUpComingLive !=null)
        xhrOverviewUpComingLive.abort();
    if (xhrOverviewUpComingPregame !=null)
        xhrOverviewUpComingPregame.abort();
        
   // ajaxLoadOverview(xhrOverviewNowInPlay, "getDetailOverviewLive",  "N");
   // ajaxLoadOverview(xhrOverviewUpComingLive, "getDetailOverviewUpCommingLive","U");
    //ajaxLoadOverview(xhrOverviewUpComingPregame, "getDetailOverviewUpCommingPregame", "P");
}

/**
 * function ajax load data Overview
 * 
 * @param   {obect} xhr    instance xhr
 * @param   {string} functionCtl metho of controller Sportbook
 * @param   {string} type letter id action
 * 
 */
function ajaxLoadOverview(xhr, functionCtl, type){
    xhr = $.ajax({
        type: "POST",
        url: "/Sportbook/"+functionCtl,
        dataType: "json",
        async: true,
        data: {},
        success: function(data){
            if (data != null){
                var sortGameForDateTime = sortGame(data, type);
                if (type == 'N') {
                    constructOverviewNowInPlay(data, sortGameForDateTime, type)
                }else if (type == 'U'){ 
                    constructOverviewUpComingLive(data, sortGameForDateTime, type)
                }else{
                    constructOverviewUpComingPregame(data, sortGameForDateTime, type)
                }
            }
            xhr.abort();
        },
        error:function(data){
//           console.log(data)
        }
    });
}

/**
 * Construct html data Live Now In Play
 * 
 * @param   {string} title
 * @param   {object} data : info games
 * @param   {string} type letter id action
 */
function constructOverviewNowInPlay(data, sortGameForDateTime,type){
    if (data.length == 0)
        return;
   
    $('#overviewWrap #overviewSectionNowInPlay').empty();
    countElementOverview++;
    var pos = (countElementOverview % 2 == 0) ? 'posRight': 'posLeft';
    var html = "<div id='overviewSectionNowInPlay' class='overviewSectionWrap "+pos+"'>";
        html += "<div class='panel panel-default'>";
            html += "<div class='panel-heading pannel-heading-1'>";
                html += "<div class='panel-title' data-toogle='listOverviewNowInPlay'>"+getTextJs['sportbook_overview_nowInPlay']+"<div class='toggle-icon'></div></div>";
            html += "</div>";
        html += "</div>";
    
        html += "<ul id ='listOverviewNowInPlay' class='listOverview sort'>";
        for(var i in data){
            var game = data[i];
            var GameId = game['Gamenum'].substring(2);
            var order = orderGame(sortGameForDateTime, GameId);
            var sportClassName = game['SportType'].toLowerCase();
            var stringDateTimeGame =  formatDate(game['GameDateTime']);
            
            html += "<li class='itemGame' order='"+order+"' gameNum='"+game['Gamenum']+"'>";
                html += "<div class='iconWrap'><i class='iconSport "+sportClassName+"'></i></div>";
                html += "<div class='time-game'>"+stringDateTimeGame+"</div>";
                html += "<div class='teams-game'>";
                    html += "<div class='ellipsis'>";
                    html += "<div>";
                        html += "<span class='name-team2'>"+game['Team2ID']+" / </span>";
                        html += "<span class='name-team1'>"+game['Team1ID']+"</span>";
                    html += "</div>";
                    html += "</div>";
                    html += "<div class='detailNowInPlay'>";
                        html += "<div class='gameTime'>"+game['Time']+"'</div>";
                        
                        html += "<div class='gameScore'>Score: "+game['ScoreHome']+"-"+game['ScoreAway']+"</div>";
                    html += "</div>";
                html += "</div>";
            html += "</li>";
        }
        html += "</ul>";
    html += "</div>";
    $('#overviewWrap').append(html);
    sortElements();
    eventsOverview();
}

/**
 * construct html Up Coming Live
 * 
 * @param   {string} title
 * @param   {object} data : info games
 * @param   {string} type letter id action
 */
function constructOverviewUpComingLive(data, sortGameForDateTime, type){
    if (data.length == 0)
        return;

    $('#overviewWrap #overviewSectionUpComingLive').empty();
    countElementOverview++;
    var pos = (countElementOverview % 2 == 0) ? 'posRight': 'posLeft';
    var html = "<div id='overviewSectionUpComingLive' class='overviewSectionWrap "+pos+"'>";
        html += "<div class='panel panel-default'>";
            html += "<div class='panel-heading pannel-heading-1'>";
                html += "<div class='panel-title' data-toogle='listUpComingLive'>"+getTextJs['sportbook_overview_upComingLive']+" <div class='toggle-icon'></div></div>";
            html += "</div>";
        html += "</div>";
        html += "<ul id='listUpComingLive' class='listOverview sort'></ul>";
    html += "</div>";
    $('#overviewWrap').append(html);
    
    for(var i in data){
        var htmlSecSport = '';
        var htmlGame = '';
        var game = data[i];
        var GameId = game['MatchID'] ;
        var order = orderGame(sortGameForDateTime, GameId);
        var sportClassName = game['SportType'].toLowerCase().replace(' ','_');
        var stringDateTimeGame =  formatDate(game['GameDateTime']);
        
        if ($('#listUpComingLive .sectionSportLive-'+sportClassName).length == 0) {
            htmlSecSport += "<li class='sectionSportLive sectionSportLive-"+sportClassName+"' >";
            htmlSecSport += "<div class='titleSport' data-toogle='listUpComingLiveSubSport-"+sportClassName+"'>"+game['SportType']+" <div class='toggle-icon'></div></div>"; 
                htmlSecSport += "<ul id='listUpComingLiveSubSport-"+sportClassName+"' class='listOverview sort'></ul>"; 
            htmlSecSport += "</li>";
            $('#listUpComingLive').append(htmlSecSport);
        }
        
        htmlGame += "<li class='itemGame' order='"+order+"' gameNum='"+game['LiveGameNum']+"'>";
            htmlGame += "<div class='iconWrap'><i class='iconSport "+sportClassName+"'></i></div>";
            htmlGame += "<div class='time-game'>"+stringDateTimeGame+"</div>";
            htmlGame += "<div class='teams-game'>";
                htmlGame += "<div class='ellipsis'>";
                htmlGame += "<div>";
                    htmlGame += "<span class='name-team2'>"+game['Team2ID']+" / </span> ";
                    htmlGame += "<span class='name-team1'>"+game['Team1ID']+"</span>";
                htmlGame += "</div>";
                htmlGame += "</div>";
            htmlGame += "</div>";
        htmlGame += "</li>";
        $('#listUpComingLive .sectionSportLive-'+sportClassName+' > ul').append(htmlGame);
    }
    sortElements();
    eventsOverview();
}

/**
 * Construct html Up Coming Pregame
 * 
 * @param   {string} title
 * @param   {object} data : info games
 * @param   {string} type letter id action
 */
function constructOverviewUpComingPregame(data, sortGameForDateTime, type){
    if (data.length == 0)
        return;

    $('#overviewWrap #overviewSectionUpComingPregame').empty();
    countElementOverview++;
    var pos = (countElementOverview % 2 == 0) ? 'posRight': 'posLeft';
    var html = "<div id='overviewSectionUpComingPregame' class='overviewSectionWrap "+pos+"'>";
        html += "<div class='panel panel-default'>";
            html += "<div class='panel-heading pannel-heading-1'>";
                html += "<div class='panel-title' data-toogle='listUpComingPregame'>"+getTextJs['sportbook_overview_upComingPreGame']+" <div class='toggle-icon'></div></div>";
            html += "</div>";
        html += "</div>";
        
        html += "<ul id='listUpComingPregame' class='listOverview sort'></ul>";
    html += "</div>";
    $('#overviewWrap').append(html);
    
    for(var i in data){
        var htmlSecSport = '';
        var htmlGame = '';
        var game = data[i];
        var GameId = game['GameNum'];
        var order = orderGame(sortGameForDateTime, GameId);
        var sportClassName = game['SportType'].toLowerCase().replace(' ','_');
        var stringDateTimeGame =  formatDate(game['GameDateTime']);
        
        if ($('#listUpComingPregame .sectionSportPregame-'+sportClassName).length == 0) {
            htmlSecSport += "<li class='sectionSport sectionSportPregame-"+sportClassName+"' >";
            htmlSecSport += "<div class='titleSport' data-toogle='listUpComingPregameSubSport-"+sportClassName+"'>"+game['SportType']+" <div class='toggle-icon'></div></div>"; 
                htmlSecSport += "<ul id='listUpComingPregameSubSport-"+sportClassName+"' class='listOverview sort' data-toggle='collapse'></ul>"; 
            htmlSecSport += "</li>";
            $('#listUpComingPregame').append(htmlSecSport);
        }
        
        htmlGame += "<li class='itemGame selectGame' order='"+order+"' GameNum='"+game['GameNum']+"'>";
            htmlGame += "<div class='iconWrap'><i class='iconSport "+sportClassName+"'></i></div>";
            htmlGame += "<div class='time-game'>"+stringDateTimeGame+"</div>";
            htmlGame += "<div class='teams-game'>";
                htmlGame += "<div class='ellipsis'>";
                htmlGame += "<div>";
                    htmlGame += "<span class='name-team2'>"+game['Team2ID']+" / </span> ";
                    htmlGame += "<span class='name-team1'>"+game['Team1ID']+"</span>";
                htmlGame += "</div>";
                htmlGame += "</div>";
            htmlGame += "</div>";
        htmlGame += "</li>";
        $('#listUpComingPregame .sectionSportPregame-'+sportClassName+' > ul').append(htmlGame);
    }
    sortElements();
    
    setEvents();
    eventsOverview();
}

/*
 * Games sort array based on their date start
 */
function sortGame(games, type){
    var sortGameForDateTime = new Array();

    for(var row in games){
        var game=games[row];
        var date = parseDateStringToTimeStamp(game['GameDateTime']);
    
        var GameId = (type == 'N') ? game['Gamenum'].substring(2) : ((type == 'U') ? game['MatchID'] : game['GameNum']);
        if (date != null && GameId != undefined) 
            sortGameForDateTime.push([GameId, date]);
    }

    sortGameForDateTime.sort(function (a,b) {
        if (a[1] < b[1]) return -1;
        if (a[1] > b[1]) return 1;
        return 0;
    });
    
    return sortGameForDateTime; 
}

/*
 * returns the position (date)of a game
 * @param {object} list of games order by date
 * @param {string} gameNum
 *
 * @return (int) pos
 */
function orderGame(obj, val){
    for(prop in obj){
        if(obj[prop][0] == val){
            return prop;
        }
    }
    return '';
}

/**
 * Events Overview
 * 
 */
function eventsOverview(){
    $('#listOverviewNowInPlay .itemGame, #listUpComingLive .itemGame').unbind('click');
    $('#listOverviewNowInPlay .itemGame, #listUpComingLive .itemGame').bind('click', function(e){
        var gameNum = $(this).attr('gameNum');
        $(location).attr('href', '/pages/live/'+gameNum);
    });
    
    $('#overviewWrap .panel-title, #overviewWrap .titleSport').unbind('click');
    $('#overviewWrap .panel-title, #overviewWrap .titleSport').bind('click', function(){
       
        var target = $(this).attr('data-toogle');
        var elTaget = $('#'+target);
        if (elTaget.is(':visible')){
            elTaget.slideUp();
            $(this).addClass('collapsed');
        }else{
            elTaget.slideDown();
            $(this).removeClass('collapsed');
        }
    });
    
}
