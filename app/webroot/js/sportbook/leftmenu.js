var orderCategories = getOrderCategories();

$(window).ready(updateLeftmenu);

/**
 * getOrderCategories : list all sports in DB
 * @returns {array} list sports
 */
function getOrderCategories(){
    var res=[];
    var sports=siteCache.list_sports;

    for (var key in sports){
        if (key == 'OTHER SPORTS') {
            var otherSports=siteCache.list_sports[key];
            for (var i in otherSports){
                if (otherSports !== null){
                    res.push(otherSports[i]);
                }
            }
        }else{
            res.push(key);
        }
    }
    
    orderCategories = res.sort();

    return orderCategories;
}
/**
 * check Is Section Is Not Null (Contestants)
 * @param   {Object} bets selection bet
 * @returns {Bool} check
 */
function checkIsSectionsIsNotNull(bets){
    var check = true;
    if (!isIsset(bets)){
       return false;
    }
    for( var contestNum in bets){
        if (bets !== null){
            var selections = bets[contestNum].selections;
            var i = 0;
            for(var contestant in selections){
                if (selections !== null){
                    var odds = selections[contestant].oddsUS;
                    if (isIsset(odds) && odds.length === 0)
                        i++;
                }
            }
            if (i == Object.keys(selections).length) 
                check =  false;
        }
    }
    return check;
}
    
/**
 * Add sport panel Leftmenu
 * @param category {Array} one category sport
 * @returns {string} panelId id block sportPanel
 */  
function addSportPanelLeftmenu(category){
    var panelId=sanitiazeId("sportPanel_"+category.sportID);
    if($("#"+panelId).length===0){
        var html=   "<div class='panel panel-default sportPanel' id='"+panelId+"' sportid='"+category.sportID+"' must-be-ordered='"+category.sportMustBeOrdered+"' order='"+category.sportOrder+"'>"+
                    "<div class='panel-heading pannel-heading-1 collapsed' data-toggle='collapse' href='#"+panelId+"_content'>"+
                        "<div class='panel-title'>"+
                            "<div class='iconWrap'>"+
                                "<div class='iconSport white "+sanitiazeId(category.SportType)+"'></div>"+
                            "</div>"+
                            "<div class='sportName'>"+(isIsset(category.SportTypeTransate) ? category.SportTypeTransate.toUpperCase(): category.SportType.toUpperCase())+"</div>"+
                            "<div class='iconWrap'>"+
                                "<div class='iconPlus'></div>"+
                            "</div>"+
                        "</div>"+
                    "</div>"+
                    "<div class='arrow-left'></div>"+
                    "<div id='"+panelId+"_content' class='panel-collapse collapse panel-body in'>"+
                        "<div class='panel-group'>"+
                            "<ul class='list-group groupList categoryList'></ul>"+
                        "</div>"+
                    "</div>"+
                    "</div>";
        $("#sportsMenu .sportsPanelWrap").append(html);
        setLeftmenuEvents();
    }
    return panelId;
}

/**
 * add Category Leftmenu
 * @param category {Array} one category sport
 */
var categoryIndex=0;
function addCategoryLeftmenu(category){
    var panelId=addSportPanelLeftmenu(category);
    var scheduleText = (isIsset(category.scheduleText))?category.scheduleText.toUpperCase():"";
    var sportType = category.SportType.toUpperCase();
    var periodToLoadFirst = category.periodToLoadFirst;
    var id="eventItem_"+category.subCategoryID;
    id = id.replace("&","\\&");

    if($("#"+id).length===0){
        categoryIndex++;

        var html="<li class='list-group-item groupLink categoryItem' id='"+id+"' subCategoryID='"+category.subCategoryID+"' must-be-ordered='"+category.mustBeOrdered+"' order='"+category.order+"'>"+
                "<div class='table'>"+                
                    "<div class='cell checkboxWrap squaredCategory'>"+
                        "<input type='checkbox' class='checkbox' name='category_"+categoryIndex+"' value='"+category.subCategoryID+"' typeSubcategory= '"+ category.subCategory + "' sportType = '" + sportType + "' scheduleText ='" + scheduleText + "'  periodToLoadFirst='" + periodToLoadFirst + "'/>"+
                        "<label for='checkbox'></label>"+
                    "</div>"+
                    "<div class='cell linkWrap'>"+
                    "<div class='ellipsis'>"+
                    "<a href='#'>"+(category.subCategoryMask === "FUTURE PROPS" ? getTextJs.sportbook_left_menu_oddsToWin : category.subCategoryMask)+"</a>"+
                    "</div>"+
                    "</div><div class='favorite-gen-start-container' meta-type='league' typeSubcategory= '"+ category.subCategory + "' sportType = '" + sportType + "' ><i class='glyphicon glyphicon-star-empty'></i>"+  
                    "<i class='glyphicon glyphicon-star'></i></div>"+
                "</div>"+
                "</li>";

            $("#"+panelId+" .categoryList").append(html);
       
    
        setLeftmenuEvents();
    }
}

/**
 * set Toggle Disable Button Continue
 */
function setToggleDisableButtonContinue(){
    var checks=$("#sportsMenu input:checked");
    if(checks.length>0) $("#sportsMenu .btn-continue").removeClass("disabled");
    else $("#sportsMenu .btn-continue").addClass("disabled");
}

/**
 * save Selected Categories
 */
function saveLeftMenuSelectedCategories(){
    var selectedCateogies=new Object({});
    var checks=$("#sportsMenu input:checked");
    for(var i=0; i<checks.length; i++){
        var value=checks.eq(i).val();
        selectedCateogies[value]=value;
    }
    var categoriesBetslip = $.parseJSON(readCookie('categoriesBetslip'));
    for (var index in categoriesBetslip){
        if (selectedCateogies[index] === null) {
          selectedCateogies[index] = index;
        }
    }

    saveSelectedCategories(selectedCateogies);
}

function getLeftMenuSelectedCategories(){
    var selectedCateogies=new Object();
    var checks=$("#sportsMenu input:checked");
    for(var i=0; i<checks.length; i++){
        var value=checks.eq(i).val();
        selectedCateogies[value]=value;
    }
    return selectedCateogies;
}

function cleanLeftMenuSelectedCategories(source){
    var checks=$("#sportsMenu input");
    for(var i=0; i<checks.length; i++){
        checks.prop('checked', false);
    }
    if(source != "overview")
        $("#groupsWrapLong").empty();
    createCookie('selectedCategories', "", -1);
    
}

/**
 * Stock the events of Left Menu
 */
function setLeftmenuEvents(){
    var idFutureProps = 'propsgroupswraplong';
    var idGroupGames = 'group_';
    var typeFutureProps = 'FUTURE PROPS';
    var selectedMenu = {};
    
    $("#sportsMenu .sportPanel .panel-heading").unbind("click");
    $("#sportsMenu .sportPanel .panel-heading").click(function(e){
        _SELECTED_GAME = false;
        
        if($("body").hasClass('sm') || $("body").hasClass('md')){
            e.stopPropagation();
            var sportPanel=$(this).parents('.sportPanel');
            var isOpen=sportPanel.hasClass('sm-special-open');
            
            $("#sportsMenu .sportPanel").removeClass('sm-special-open');
            $("#sportsMenu .sportPanel > .panel-body").removeClass('in');
    
            if(!isOpen) sportPanel.addClass('sm-special-open');
        }
        else{ 
            // Collapse menu
            if ($(this).hasClass( "collapsed" )){
                $(this).find('.iconArrow').removeClass('collapsed');
                $(this).removeClass('in');
            }else{
                $(this).find('.iconArrow').addClass('collapsed');
                $(this).addClass('in');
            }
        }
    });
 
    $('#sportsMenu .squaredCategory').unbind('click');
    $('#sportsMenu .squaredCategory').bind('click', function(){
        selectedGameNum=null;
        _SPORT_CATEGORIES_HAS_CHANGED = true;

        var input = $(this).children('input[type="checkbox"]');
        var typeSubcategory = input.attr('typeSubcategory');
        var sportType = input.attr('sportType');
        var scheduleText = input.attr('scheduleText');
        var value = input.attr('value');
        var period = input.attr('periodtoloadfirst');
        var id = '';
        selectedMenu = {league:typeSubcategory, sportType:sportType, scheduleText:scheduleText, period: period, value:value, groupIdParent:'', groupIdChild:''};

        if (typeSubcategory == typeFutureProps){
            id = idFutureProps + ' '+ typeSubcategory + ' ' + sportType;
        }else{
            id = idGroupGames + input.attr('value');
        }

        if (input.is(':checked')){
            input.prop('checked',false);
            id = sanitiazeId(id); 
            deleteElementLoadLines(id);
        }else{
            input.prop('checked',true);
            saveLeftMenuSelectedCategories();
            actualizeGroupsGames(selectedMenu);
        }
       
        if($("#myOffCanvas").hasClass('activeLeft') || $("#myOffCanvas").hasClass('activeRight'))
            $(".toggle-myOffCanvas").first().click();
        
        $(".sportPanel").removeClass("sm-special-open");
       
    });
    
    $(".categoryList .favorite-gen-start-container").unbind("click");
    $(".categoryList .favorite-gen-start-container").click(function(e){
        e.preventDefault();
        var typeSubcategory = $(this).siblings('.checkboxWrap').children('input').attr('typeSubcategory');
        var sportType = $(this).siblings('.checkboxWrap').children('input').attr('sportType');
        var selectedMenu = {league:typeSubcategory, sportType:sportType};
        saveFavorite("league", selectedMenu);
    });
    
    $(".categoryList .favorite-gen-start-container-delete").unbind("click");
    $(".categoryList .favorite-gen-start-container-delete").click(function(e){
        e.preventDefault();
        var typeSubcategory = $(this).siblings('.checkboxWrap').children('input').attr('typeSubcategory');
        var sportType = $(this).siblings('.checkboxWrap').children('input').attr('sportType');        
        var selectedMenu = {league:typeSubcategory, sportType:sportType};
        deleteFavorite("league", selectedMenu);
    });
    
    $(".categoryList .my-games-tab").unbind("click");
    $(".categoryList .my-games-tab").click(function(e){
        e.preventDefault();
        var gamenums = [];
        for(var idx in _FAVORITES["game"]){
            gamenums.push(_FAVORITES["game"][idx]["gamenum"]);
        }    
        $("#groupsWrapLong").empty();
        $("#sportsMenu input[type='checkbox']").prop("checked", false);
        var params = {scheduleText:"-",games:gamenums.join(","),isFavoritesLoad:true};
        loadSelectedMenu(params, function(){});
        _GUI_POSITION_FOR_RELOAD.position = "favorite_games";
        
        if($("#myOffCanvas").hasClass('activeLeft') || $("#myOffCanvas").hasClass('activeRight')){
            $(".toggle-myOffCanvas").first().click();
        }
    });
    
    
    
    $(".sportPanel .linkWrap").unbind("click");
    $(".sportPanel .linkWrap").click(function(e){        
        e.preventDefault();
        selectedGameNum=null;
        _SPORT_CATEGORIES_HAS_CHANGED = true;
        
        $(".overview-game").remove();
        
        var isChecked = $(this).siblings('.checkboxWrap').children('input').is(':checked');        
        var typeSubcategory = $(this).siblings('.checkboxWrap').children('input').attr('typeSubcategory');
        var sportType = $(this).siblings('.checkboxWrap').children('input').attr('sportType');
        var scheduleText = $(this).siblings('.checkboxWrap').children('input').attr('scheduleText');
        var value = $(this).siblings('.checkboxWrap').children('input').attr('value');
        var period = $(this).siblings('.checkboxWrap').children('input').attr('periodtoloadfirst');
        var id = '';
        var selectedMenu = {league:typeSubcategory, sportType:sportType, scheduleText:scheduleText, period: period, value:value, groupIdParent:'', groupIdChild:''};
        
        if (typeSubcategory == typeFutureProps){
           id = idFutureProps + ' ' + typeSubcategory + ' ' + sportType;
        }else{
            id = idGroupGames + $(this).siblings('.checkboxWrap').children('input').attr('value');
        }
        
        
        var schedules = availableCategories[selectedMenu.sportType][selectedMenu.value].scheduleArr;
        var schedule = "";
        for(var ind in schedules){
            schedule = sanitiazeId(ind);
            break;
        }

        var groupRefresh = "group_"+selectedMenu.sportType+"_"+selectedMenu.league;

        if(schedule != "")
            groupRefresh += "_"+schedule;
        
        selectedMenu.groupRefresh = sanitiazeId(groupRefresh.toLowerCase());
        
        
       /* if(objectContainsObjectForBetslipReload(_GUI_POSITION_FOR_RELOAD.metadata, selectedMenu)){
            
            removeObjectFromBetslipRealodObject(selectedMenu);
        }*/
        
        if (!isChecked){
            $(this).siblings('.checkboxWrap').children('input[type="checkbox"]').prop('checked',true);
            saveLeftMenuSelectedCategories();
            actualizeGroupsGames(selectedMenu);
        }else {
            $(this).siblings('.checkboxWrap').children('input[type="checkbox"]').prop('checked',false);
            id = sanitiazeId(id); 
            deleteElementLoadLines(id); 
        }
        $(".showOverview").removeClass('active');
        //carouselOptionShow();
    });
}

function actualizeGroupsGames(selectedMenu){
    $("#groupsWrap").show();
    
    var schedules = availableCategories[selectedMenu.sportType][selectedMenu.value].scheduleArr;
     
    if (selectedMenu.league === 'FUTURE PROPS'){
        loadFutureProps(selectedMenu.sportType);
    }else{
        if(_SPORT_CATEGORIES_HAS_CHANGED){    
            loadSelectedMenu(selectedMenu, schedules);
            _SPORT_CATEGORIES_HAS_CHANGED = false;
        }  
    }

    var schedule = "";
    for(var ind in schedules){ 
        selectedMenu.scheduleText = ind;
        schedule = sanitiazeId(ind);
        break;
    }
        
    var groupRefresh = "group_"+selectedMenu.sportType+"_"+selectedMenu.league;
    
    if(schedule != ""){
        groupRefresh += "_"+schedule;
        
    }
    
    selectedMenu.groupRefresh = sanitiazeId(groupRefresh.toLowerCase());
    //_GUI_POSITION_FOR_RELOAD.position = 'open_category';

    /*if(typeof _GUI_POSITION_FOR_RELOAD.metadata == 'undefined')
        _GUI_POSITION_FOR_RELOAD.metadata = [];

    if(!objectContainsObjectForBetslipReload(_GUI_POSITION_FOR_RELOAD.metadata, selectedMenu)){
        selectedMenu.sizeBody = sizeBody;
        selectedMenu.priceType = getPriceType();
        _GUI_POSITION_FOR_RELOAD.metadata.push(selectedMenu);
    }*/
    
    
    if($("#myOffCanvas").hasClass('activeLeft') || $("#myOffCanvas").hasClass('activeRight')){
        $(".toggle-myOffCanvas").first().click();
    }
}

function updateLeftmenu(){
    var future_props = 'FUTURE PROPS';    
    var countSubSports = 0;
        
    for(var SportType in availableCategories){

        if (SportType !== null){
            
            var subCategoryProps = null;
            
            var SportSubCategories=availableCategories[SportType];
 
            var subCategoryArr = [];
            
            //se obtienen los subdeportes para ordenarlos alfabeticamente
            countSubSports = SportSubCategories.count;
            
            for(var subCategoryID in SportSubCategories){
                if (subCategoryID !== null && subCategoryID != "order" && subCategoryID != "mustBeOrdered"){
                    var object=SportSubCategories[subCategoryID];
                    if (object.noShowSport!='1'){
                        subCategoryArr.push(subCategoryID);
                    }
                } 
            }
   
            //se ordenan los subdeportes por orden alfabetico
            subCategoryArr.sort();
            
            //se agregan las opciones al menu
            for(var i = 0; i< subCategoryArr.length; i++){
            
                var subCategory=SportSubCategories[subCategoryArr[i]];
                subCategory.sportOrder = availableCategories[SportType].order;
                subCategory.sportMustBeOrdered = availableCategories[SportType].mustBeOrdered;
                if(isFavorite(subCategory)){
                    addFavoriteCategoryLeftmenu(subCategory);
                }else{
                    if (future_props == subCategory.subCategory)
                        subCategoryProps = subCategory;
                    else    
                        addCategoryLeftmenu(subCategory);
                }  
            }
            
            if (subCategoryProps !== null){
                addCategoryLeftmenu(subCategoryProps);
            }

        }
    }

    // Let's check if there's any game as favorite
    if(typeof _FAVORITES != "undefined"){
        if(typeof _FAVORITES["game"] != "undefined"){
            if(_FAVORITES["game"].length > 0){
                addMyGamesFavoriteLeftMenu();
            }
        }
    }
    
    orderMenuToSiteOrder();
}

function saveFavorite(type, data){
    $.ajax({
        url: "/Sportbook/saveFavorite",
        dataType: "json",
        method: "POST",
        data: {type:type, dataString:JSON.stringify(data)}
    }).done(function(data){
        if(data.result == "success"){
            _FAVORITES = data.favorites;            
            $("#sportsMenu .sportsPanelWrap").html("");
            updateLeftmenu();
            if(type == "game"){
                lookForFavorites();
            }
        }
    });
}
        
function deleteFavorite(type, data){
    $.ajax({
        url: "/Sportbook/deleteFavorite",
        dataType: "json",
        method: "POST",
        data: {type:type, dataString:JSON.stringify(data)}
    }).done(function(data){
        if(data.result == "success"){
            _FAVORITES = data.favorites; 
            //$("#sportsMenu .categoryItem.my-games-tab").click();
            $("#sportsMenu .sportsPanelWrap").html("");
            
            updateLeftmenu();  
            
        }
    });
}        

function addFavoritePanelLeftmenu(){
    if($("#favorites_panel").length == 0){
        var html=   "<div class='panel panel-default sportPanel' id='favorites_panel' sportid='favorites' must-be-ordered='1' order='0'>"+
                    "<div class='panel-heading pannel-heading-1 collapsed' data-toggle='collapse' href='#favorites_panel_content'>"+
                        "<div class='panel-title'>"+
                            "<div class='iconWrap'>"+
                                "<img class='iconSport white favorites' src='/images/star.svg'></img>"+
                            "</div>"+
                            "<div class='sportName'>"+getTextJs["sportbook_favorites"]+"</div>"+
                            "<div class='iconWrap'>"+
                                "<div class='iconPlus'></div>"+
                            "</div>"+
                        "</div>"+
                    "</div>"+
                    "<div class='arrow-left'></div>"+
                    "<div id='favorites_panel_content' class='panel-collapse collapse panel-body in'>"+
                        "<div class='panel-group'>"+
                            "<ul class='list-group groupList categoryList'></ul>"+
                        "</div>"+
                    "</div>"+
                    "</div>";
        $("#sportsMenu .sportsPanelWrap").prepend(html);
        setLeftmenuEvents(); 
    }
}

function isFavorite(category){
    //Check if sport and league is or not in favorites 
    if(typeof _FAVORITES["league"] == "undefined") 
        return false;
    
    for(var id in _FAVORITES["league"]){
        if(_FAVORITES["league"][id]["sportType"] == category.SportType && _FAVORITES["league"][id]["league"] == category.subCategory)
            return true;
    }
    
    return false;
}

function addFavoriteCategoryLeftmenu(category){
    addFavoritePanelLeftmenu();
    var scheduleText = (isIsset(category.scheduleText))?category.scheduleText.toUpperCase():"";
    var sportType = category.SportType.toUpperCase();
    var periodToLoadFirst = category.periodToLoadFirst;
    var id="eventItem_"+category.subCategoryID;
    id = id.replace("&","\\&");

    if($("#"+id).length===0){
        categoryIndex++;
    
        var html="<li class='list-group-item groupLink categoryItem' id='"+id+"' subCategoryID='"+category.subCategoryID+"'>"+
                "<div class='table'>"+                
                    "<div class='cell checkboxWrap squaredCategory'>"+
                   
                        "<div class='iconSport "+sanitiazeId(category.SportType)+"' style='position:absolute'></div>"+
                    
                        "<input type='checkbox' class='checkbox' name='category_"+categoryIndex+"' value='"+category.subCategoryID+"' typeSubcategory= '"+ category.subCategory + "' sportType = '" + sportType + "' scheduleText ='" + scheduleText + "'  periodToLoadFirst='" + periodToLoadFirst + "'/>"+
                       
                    "</div>"+
                    "<div class='cell linkWrap'>"+
                    "<div class='ellipsis'>"+
                    "<a href='#'>"+(category.subCategoryMask === "FUTURE PROPS" ? getTextJs.sportbook_left_menu_oddsToWin : category.subCategoryMask)+"</a>"+
                    
                    "</div>"+
                    
                    "</div><div class='favorite-gen-start-container-delete' meta-type='league' typeSubcategory= '"+ category.subCategory + "' sportType = '" + sportType + "'><i class='glyphicon glyphicon-star'></i>"+  
                    "<i class='glyphicon glyphicon-star-empty'></i></div>"+
                "</div>"+
                "</li>";

            $("#favorites_panel .categoryList").append(html);
       
    
        setLeftmenuEvents();
    }
}

function addMyGamesFavoriteLeftMenu(){
    addFavoritePanelLeftmenu();
     var html="<li class='list-group-item groupLink categoryItem my-games-tab'>"+
                "<div class='table'>"+                
                    "<div class='cell checkboxWrap squaredCategory'>"+
                    "</div>"+
                    "<div class='cell '>"+
                    "<div class='ellipsis'>"+
                    "<a href='#'>"+getTextJs["sportbook_my_games"]+"</a>"+
                    
                    "</div>"+
                    
                    "</div>"+
                "</div>"+
                "</li>";

            $("#favorites_panel .categoryList").prepend(html);
    setLeftmenuEvents();
}


function orderMenuToSiteOrder(){
    var toOrderContainers = $(".sportsPanelWrap .sportPanel[must-be-ordered='1']");
    
    $(".sportsPanelWrap .sportPanel[must-be-ordered='1']").remove();
       
    toOrderContainers.sort(function(a,b){
        var ea = parseFloat($(a).attr("order"));
        var eb = parseFloat($(b).attr("order"));
        return ea-eb;
    });
        
    $(".sportsPanelWrap").prepend(toOrderContainers);
    
    $.each(toOrderContainers,function(index,element){
        var categories = $(element).find(".categoryItem[must-be-ordered='1']");
        $(element).find(".categoryItem[must-be-ordered='1']").remove();
        categories.sort(function(a,b){
            var ea = parseFloat($(a).attr("order"));
            var eb = parseFloat($(b).attr("order"));
            return ea-eb;
        });
        $(element).find(".categoryList").prepend(categories);        
    }); 
        
    setLeftmenuEvents();
}
