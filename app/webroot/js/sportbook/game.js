function showSelectedGame(gameNum, groupInfo, schedule,callbackFunction){
     $("#userbar").css("display", "block !important");
     if(callbackFunction === undefined && callbackFunction !== "auto") $('#loading').css('display', 'block');
     try{
        var parametros = {
             sport: groupInfo.Sport,
             league: groupInfo.League,
             periodNum: groupInfo.PeriodNum,
             gameNum: gameNum,
             selectedGameNum: selectedGameNum,
             schedule: schedule,
             priceType: getPriceType()
        };
        //_GUI_POSITION_FOR_RELOAD.position = "game_selected";
        //_GUI_POSITION_FOR_RELOAD.gamedata = parametros;
        loadSelectedGameAjax(parametros, callbackFunction);
    }catch (err) {
        console.log(err);
    } 
}

function loadSelectedGameAjax(parametros, callbackFunction){
    $("#gameWrapLong").empty();
    $.ajax({
        url: "/Sportbook/getSelectedGame",
        type: 'POST',
        data: parametros,
        cache: false
    })
    .done(function(data){
       $("#gameWrapLong").html(data);
       setEvents();
       hightLigthSelectionOnBetslip();
       markBlockedSelections();
    })
    .error(function(err){
        console.log(err);
    })
    .always(function(){
        if(callbackFunction === undefined && callbackFunction !== "auto") $('#loading').css('display', 'none');
        if(typeof(callbackFunction)=='function'){
            callbackFunction();
        }
    });
}


function loadFutureProps(sportType,callbackFunction){
    
    $("#overviewWrap, #gameWrap, #wagersReportWrap, #balanceReportWrap, #accountHistoryReportWrap, #accountSportbook").hide();
    $("#userbar").css("display", "block !important");
    if(callbackFunction === undefined && callbackFunction !== "auto") $('#loading').css('display', 'block');

     var groupDeleteFirst = sanitiazeId('propsgroupswraplong future props '+sportType);
     
     $("#"+groupDeleteFirst).remove();
     
     try{
        var parametros = {
            sport: sportType,
             priceType: getPriceType()
        };
        
        $.ajax({
            url: "/Sportbook/getLoadFutureProps",
            type: 'POST',
            data: parametros,
            cache: false
        })
        .done(function(data){
            $("#groupsWrapLong").html(function(){
                var sizeContent = $(this).children('*').length;
                var contenido = $(this).children('*');
                $("#groupsWrapLong").empty();
             
                if (sizeContent > 0){
                    $("#groupsWrapLong").html(data);
                    $("#groupsWrapLong").append(contenido);                                                      
                }else{
                    $("#groupsWrap").show();
                    $("#groupsWrapLong").empty();
                    $("#groupsWrapLong").html(data);
                }
            });
             
            setEvents();
            assignEventPeriod();
            updateBetSlip("sportbook");
            
        })
        .error(function(err){
           console.log(err);
           setTimeout(loadFutureProps, cacheUpdateInterval);
        })
        .always(function(){
            if(callbackFunction === undefined && callbackFunction !== "auto") $('#loading').css('display', 'none');
            if(typeof(callbackFunction)=='function'){
                callbackFunction();
            }
        });
    }catch (err) {
        console.log(err);
        if(callbackFunction === undefined && callbackFunction !== "auto") $('#loading').css('display', 'none');
    }   

}

function loadSelectedMenu(selectedMenu, schedules, callbackFunction){
    var contenido ='';
    $("#groupsWrapLong .group.favorite").remove();
    //se elimina el grupo que se va agregar si ya existe
    var groupDeleteFirst = sanitiazeId('group_'+selectedMenu.value);
    $("#"+groupDeleteFirst).remove();
    
    //se respalda el contenido
    $("#groupsWrapLong").html(function(){
        contenido = $(this).children('*');
    });
    
    $("#overviewWrap, #gameWrap, #wagersReportWrap, #balanceReportWrap, #accountHistoryReportWrap, #accountSportbook, #bonusPointsWrap").hide();
    $("#groupsWrap").show();
    $("#userbar").css("display", "block !important");
    if(callbackFunction === undefined && callbackFunction !== "auto" && selectedMenu.isOverview != true && selectedMenu.isUpcoming != true) $('#loading').css('display', 'block');
    
    //se ordenan los schedules alfabeticamente si existen
    if (schedules !== ""){     
        var schedulesAux =[];  
        for( var id in schedules){
          if (id !== null)
            schedulesAux.push(id); 
        }        
        schedulesAux.sort();        
        schedules = schedulesAux;
    }

    try{
        var parametros = {
            league:selectedMenu.league,
            sportType:selectedMenu.sportType,
            scheduleText: selectedMenu.scheduleText,
            period: selectedMenu.period,
            sizeBody:sizeBody,
            priceType: getPriceType(),
            value: selectedMenu.value,
            schedules: schedules,
            gamenums: selectedMenu.games,
            isFavorite: selectedMenu.isFavoritesLoad,
            isOverview: selectedMenu.isOverview,
            isUpcoming: selectedMenu.isUpcoming
        };

        $.ajax({
            url: "/Sportbook/getLoadLine",
            type: 'POST',
            data: parametros,
            cache: false
        })
        .done(function(data){
          
            if(selectedMenu.isOverview === true || selectedMenu.isUpcoming){
                $("#groupsWrapLong").empty();
                $("#groupsWrapLong").append(data);
            }else{
                $("#groupsWrapLong").empty();
                $("#groupsWrapLong").append(contenido);
                closeLoadedLines();               
                $("#groupsWrapLong").append(data);
            }
 
          if (schedules !== "" && selectedMenu.isFavoritesLoad != true && selectedMenu.isOverview != true && selectedMenu.isUpcoming != true){
              closeLoadedLines();
              var transformedName = sanitiazeId('group_'+selectedMenu.sportType+'_'+selectedMenu.league+'_'+schedules[schedules.length-1]);
              var idChildToOpen = transformedName.toLowerCase();
 
              openLoadedLines(idChildToOpen);
          }
  
           assignEventOdds();
           // The setEvenst() function is called into this function
           lookForFavorites();           
           assignEventPeriod();
           updateBetSlip("sportbook"); 
           
        })
        .error(function(err){
           console.log(err);
           setTimeout(loadSelectedMenu, cacheUpdateInterval);
        })
        .always(function(){
            if(callbackFunction === undefined && callbackFunction !== "auto") $('#loading').css('display', 'none');
            if(typeof(callbackFunction)=='function'){
                callbackFunction();
            }
        });
    }catch (err) {
        console.log(err);
        if(callbackFunction === undefined && callbackFunction !== "auto") $('#loading').css('display', 'none');
    }   
}

function getDataPeriodPerSport(selectorId){
     var selector =  selectorId.attr('data-period'); 
     var groupRefresh =  selector.slice("period_".length,selector.length-2);
     var sporttype = selectorId.attr('sporttype');
     var schedule = selectorId.attr('scheduletext');
     var isFavorite = typeof selectorId.attr('isfavorite') == "undefined" ? 0 : selectorId.attr('isfavorite');
     var isOverview = typeof selectorId.attr('isoverview') == "undefined" ? 0 : selectorId.attr('isoverview');
     var games = selectorId.attr('gamenums');
          
//     if (sporttype !== 'Soccer'){
//          schedule = '-'; 
//     }
    
     var parametros = {
          league:selectorId.attr('sportsubtype'),
          sportType:selectorId.attr('sporttype'),
          scheduleText: schedule,
          period: selectorId.attr('periodnumber'),
          sizeBody:sizeBody,
          priceType: getPriceType(),
          groupRefresh: groupRefresh,
          isFavorite: isFavorite,
          isOverview: isOverview,
          games: games
     };
     
     //updateObjectReloadBetslipFromPeriodLoad(parametros);
   
     doAjaxUpdatePeriod(parametros);
}

function doAjaxUpdatePeriod(parametros){
     $('.wrap_loading_'+parametros.groupRefresh).css('display', 'block');
     
    $.ajax({
         url: "/Sportbook/updatePeriod",
         type: 'POST',
         data: parametros,
         cache: true
     })
     .done(function(data){  
         $("#"+parametros.groupRefresh).empty();
         $("#"+parametros.groupRefresh).html(data);
         assignEventOdds();
         // The setEvenst() function is called into this function
         lookForFavorites(); 
         assignEventPeriod();
         updateBetSlip("sportbook");
         
     })
     .always(function(){
          $('.wrap_loading_'+parametros.groupRefresh).css('display', 'none');
     
     })
     .error(function(){
         console.log('Error actulizando period');
     });
}

function getPeriods(){    
    var periodsSelected = [];
    var elements = $('#sliderID .btn-success');     
    $.each($(elements), function(i, item){
        var id = $(item).attr('periodNumber');
        periodsSelected.push(id);
    });    
    return periodsSelected.toString();
}

function assignEventPeriod(){    
    $("#sliderID .wrapButton button.btn").unbind("click");
    $("#sliderID .wrapButton button.btn").bind('click', function(){
        $(this).parents('#sliderID').find('.wrapButton button.btn').removeClass('btn-success');
        $(this).addClass('btn-success');
        getDataPeriodPerSport($(this));
    });
}

function assignEventOdds(){

    $("#groupPeriodMobile .toggle_bettype").unbind("click");
    $("#groupPeriodMobile .toggle_bettype").click(function(){
    
        var typeSelectedBet = ($(this).attr('target_class')).split('_');
        var selectedBet = $(this).attr('target_class');
        var idSelector = '';
        
        idSelector =  selectedBet.slice(typeSelectedBet[0].length,selectedBet.length);
        
        if (typeSelectedBet[0] === 'spreadSelectorLi'){    
             //show
             $(this).parents('.betTypeSelector').find(".moneylineSelectorLi").removeClass('disable').addClass('enable');
             $(this).parents('.betTypeSelector').find(".teamtotalSelectorLi").removeClass('disable').addClass('enable');
             $(".table-games").find(".totalSelectorLi"+idSelector).removeClass('hidden').addClass('show');
             $(".table-games").find(".spreadSelectorLi"+idSelector).removeClass('hidden').addClass('show');
             $(".table-games").find(".total"+idSelector).removeClass('hidden').addClass('show');
             $(".table-games").find(".spread"+idSelector).removeClass('hidden').addClass('show');  
             //hide
             $(this).parents('.betTypeSelector').find(".spreadSelectorLi").removeClass('enable').addClass('disable');
             $(this).parents('.betTypeSelector').find(".totalSelectorLi").removeClass('enable').addClass('disable');
             $(".table-games").find(".moneylineSelectorLi"+idSelector).removeClass('show').addClass('hidden');
             $(".table-games").find(".teamtotalSelectorLi"+idSelector).removeClass('show').addClass('hidden');
             $(".table-games").find(".moneyLine"+idSelector).removeClass('show').addClass('hidden');
             $(".table-games").find(".teamTotalOver"+idSelector).removeClass('show').addClass('hidden');
             $(".table-games").find(".teamTotalUnder"+idSelector).removeClass('show').addClass('hidden');
             $(".table-games").find(".draw"+idSelector).removeClass('show').addClass('hidden');
             
        }else if (typeSelectedBet[0] === 'moneylineSelectorLi'){
            
            if(_LINES_LAYOUT == "american"){
                //show
                $(this).parents('.betTypeSelector').find(".spreadSelectorLi").removeClass('disable').addClass('enable');
                $(this).parents('.betTypeSelector').find(".teamtotalSelectorLi").removeClass('disable').addClass('enable');
                $(".table-games").find(".totalSelectorLi"+idSelector).removeClass('hidden').addClass('show');
                $(".table-games").find(".moneylineSelectorLi"+idSelector).removeClass('hidden').addClass('show');
                $(".table-games").find(".total"+idSelector).removeClass('hidden').addClass('show');
                $(".table-games").find(".moneyLine"+idSelector).removeClass('hidden').addClass('show');
                $(".table-games").find(".draw"+idSelector).removeClass('hidden').addClass('show');

                //hide
                $(this).parents('.betTypeSelector').find(".moneylineSelectorLi").removeClass('enable').addClass('disable');
                $(this).parents('.betTypeSelector').find(".totalSelectorLi").removeClass('enable').addClass('disable');               
                $(".table-games").find(".spreadSelectorLi"+idSelector).removeClass('show').addClass('hidden');
                $(".table-games").find(".teamtotalSelectorLi"+idSelector).removeClass('show').addClass('hidden');
                $(".table-games").find(".spread"+idSelector).removeClass('show').addClass('hidden');
                $(".table-games").find(".teamTotalOver"+idSelector).removeClass('show').addClass('hidden');
                $(".table-games").find(".teamTotalUnder"+idSelector).removeClass('show').addClass('hidden');
            }else{
                //show
                $(this).parents('.betTypeSelector').find(".moneylineSelectorLi").removeClass('enable').addClass('disable');
                $(".table-games").find(".moneylineSelectorLi"+idSelector).removeClass('hidden').addClass('show');
                $(".table-games").find(".moneyLine"+idSelector).removeClass('hidden').addClass('show');

                //hide    
                $(this).parents('.betTypeSelector').find(".totalSelectorLi").removeClass('disable').addClass('enable');
                $(".table-games").find(".total"+idSelector).removeClass('show').addClass('hidden');
                $(".table-games").find(".totalSelectorLi"+idSelector).removeClass('show').addClass('hidden');
            }
             
        }else if (typeSelectedBet[0] === 'teamtotalSelectorLi'){   
            
            if(_LINES_LAYOUT == "american"){
                //show
                $(this).parents('.betTypeSelector').find(".teamtotalSelectorLi").removeClass('enabble').addClass('disable');
                $(this).parents('.betTypeSelector').find(".spreadSelectorLi").removeClass('disable').addClass('enable');
                $(".table-games").find(".teamtotalSelectorLi"+idSelector).removeClass('hidden').addClass('show');
                $(".table-games").find(".teamTotalOver"+idSelector).removeClass('hidden').addClass('show');
                $(".table-games").find(".teamTotalUnder"+idSelector).removeClass('hidden').addClass('show');

                //hide
                $(this).parents('.betTypeSelector').find(".moneylineSelectorLi").removeClass('disable').addClass('enable');
                $(this).parents('.betTypeSelector').find(".totalSelectorLi").removeClass('disable').addClass('enable');
                $(".table-games").find(".spreadSelectorLi"+idSelector).removeClass('show').addClass('hidden');
                $(".table-games").find(".moneylineSelectorLi"+idSelector).removeClass('show').addClass('hidden');
                $(".table-games").find(".totalSelectorLi"+idSelector).removeClass('show').addClass('hidden');
                $(".table-games").find(".spread"+idSelector).removeClass('show').addClass('hidden');
                $(".table-games").find(".moneyLine"+idSelector).removeClass('show').addClass('hidden');
                $(".table-games").find(".total"+idSelector).removeClass('show').addClass('hidden');
                $(".table-games").find(".draw"+idSelector).removeClass('show').addClass('hidden');
            }          
        }else if(typeSelectedBet[0] === 'totalSelectorLi'){
            if(_LINES_LAYOUT == "american"){
            }else{

                //show
                $(this).parents('.betTypeSelector').find(".totalSelectorLi").removeClass('enable').addClass('disable');
                $(".table-games").find(".total"+idSelector).removeClass('hidden').addClass('show');
                $(".table-games").find(".totalSelectorLi"+idSelector).removeClass('hidden').addClass('show');

                //hide
                $(this).parents('.betTypeSelector').find(".moneylineSelectorLi").removeClass('disable').addClass('enable');
                $(".table-games").find(".moneylineSelectorLi"+idSelector).removeClass('show').addClass('hidden');
                $(".table-games").find(".moneyLine"+idSelector).removeClass('show').addClass('hidden');
            } 
            
        }
    });
}

function deleteElementLoadLines(id){
    $("#"+id).html(function(){                
        $("#"+id).remove();
    });
}

function closeLoadedLines(){

     var target = $("#groupsWrapLong .group .title");   
     $(target).addClass("collapsed");
     $(target).attr('aria-expanded','false');
     
     var target1 = $("#groupsWrapLong .group .in");
     $(target1).addClass("collapse");
     $(target1).removeClass("in");
     $(target1).attr('aria-expanded','false');

}

function openLoadedLines(id){
     var target = $("#"+id+" .title");
     $(target).removeClass("collapsed");
     $(target).attr('aria-expanded','true');
     
     var target1 = $("#"+id+" .collapse");
     $(target1).removeClass("collapse");
     $(target1).addClass("in");
     $(target1).attr('aria-expanded','true');
}

function lookForFavorites(){
    if(typeof _FAVORITES == "undefined")
        return false;
    
    if(typeof _FAVORITES["game"] == "undefined")
        return false;
    
    for(var index in _FAVORITES["game"]){
        if($("tr [gamenum='"+_FAVORITES["game"][index]["gamenum"]+"']").length > 0){
            var container = $("tr [gamenum='"+_FAVORITES["game"][index]["gamenum"]+"'].favorite-gen-start-container");
            $(container).removeClass("favorite-gen-start-container");
            $(container).addClass("favorite-gen-start-container-delete");
            $(container).html("<i class='glyphicon glyphicon-star'></i><i class='glyphicon glyphicon-star-empty'></i>");

        }
    }
    setEvents();
}