var _MAX_WIDTH_FOR_OVERVIEW_DATA = 767;

$(window).ready(function(){
    setInterval(updateUpcomingCounters,1000);
    setInterval(loadLiveOverview,60000);
});

function loadLiveOverview(){
    if(_MAX_WIDTH_FOR_OVERVIEW_DATA > screen.width)
        return false;
    
    xhr = $.ajax({
        type: "POST",
        url: "/Sportbook/getDetailOverviewLive",
        async: true,
        success: function(data){
            $('#live_games_container').html(data);
        }
    });
}

function loadOverviewGames(){  
    if(_MAX_WIDTH_FOR_OVERVIEW_DATA > screen.width)
        return false;
    
    var params = {scheduleText:"-",isOverview:true,period:0};
    loadSelectedMenu(params, function(){});

    if($("#myOffCanvas").hasClass('activeLeft') || $("#myOffCanvas").hasClass('activeRight')){
        $(".toggle-myOffCanvas").first().click();
    }
}

function loadUpcoming(){  
    if(_MAX_WIDTH_FOR_OVERVIEW_DATA > screen.width)
        return false;
    
    var params = {scheduleText:"-",isUpcoming:true,period:0};
    loadSelectedMenu(params, function(){});

    if($("#myOffCanvas").hasClass('activeLeft') || $("#myOffCanvas").hasClass('activeRight')){
        $(".toggle-myOffCanvas").first().click();
    }
}

function updateUpcomingCounters(){
    if(screen.width >= 768){
        var counters = $("#groupPeriodDesktop .gameDate").filter(function(){
            return $.isNumeric($(this).attr("minutes"));
        });
        $.each(counters, function(index,element){
            var minutes = parseInt($(element).attr("minutes"));
            var seconds = $.isNumeric($(element).attr("seconds")) ? parseInt($(element).attr("seconds")) : 0;

            seconds--;

            if(seconds<0){
                seconds = 59;
                minutes--;
            }
            if(minutes<0){
                minutes = 0;
                seconds = 0;
            }

            $(element).find(".date-span").html("<small>"+getTextJs["sportbook_overview_starts_in"]+"</small></br>"+minutes+":"+seconds);

            $(element).attr("minutes", minutes);
            $(element).attr("seconds", seconds);
        });
    }else{
        var counters = $("#groupPeriodMobile .time-container").filter(function(){
            return $.isNumeric($(this).attr("minutes"));
        });
        $.each(counters, function(index,element){
            var minutes = parseInt($(element).attr("minutes"));
            var seconds = $.isNumeric($(element).attr("seconds")) ? parseInt($(element).attr("seconds")) : 0;

            seconds--;

            if(seconds<0){
                seconds = 59;
                minutes--;
            }
            if(minutes<0){
                minutes = 0;
                seconds = 0;
            }

            $(element).find(".gameTime").html(getTextJs["sportbook_overview_starts_in"]+" "+minutes+":"+seconds);

            $(element).attr("minutes", minutes);
            $(element).attr("seconds", seconds);
        });
    }
}