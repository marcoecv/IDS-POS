var orderCategories = getOrderCategories();

$(window).ready(updateLeftmenu);

/**
 * getOrderCategories : list all sports in DB
 * @returns {array} list sports
 */
function getOrderCategories(){
    var res=new Array();
    var sports=siteCache['list_sports'];
    for (var key in sports){
        if (key == 'OTHER SPORTS') {
            var otherSports=siteCache['list_sports'][key];
            for (var i in otherSports){
                res.push(otherSports[i]);
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
        var selections = bets[contestNum]['selections'];
        var i = 0;
        for(var contestant in selections){
            var odds = selections[contestant]['oddsUS'];
            if (isIsset(odds) && odds.length == 0)
                i++;
        }
        if (i == Object.keys(selections).length)
            check =  false;
    }
    return check;
}


function addSportPanelLeftmenu(category){
    var panelId=sanitiazeId("sportPanel_"+category['sportID']);
    if($("#"+panelId).length==0){
        var html=   "<div class='panel panel-default sportPanel' id='"+panelId+"' sportid='"+category['sportID']+"' order='"+sportsOrder[category['SportType']]+"'>"+
			"<div class='panel-heading pannel-heading-1 collapsed' data-toggle='collapse' href='#"+panelId+"_content' style='height:50px;line-height:50px;padding-top:5px'>"+
			    "<div class='panel-title'>"+
                    "<div class='iconWrap'>"+
                        "<div class='iconSport "+sanitiazeId(category['SportType'])+"'></div>"+
                    "</div>"+
                    "<div class='sportName'>"+category['SportType'].toUpperCase()+"</div>"+
                    "<div class='iconWrap'>"+
                        "<div class='iconPlus'></div>"+
                    "</div>"+
			    "</div>"+
			"</div>"+
			"<div class='arrow-left'></div>"+
			"<div id='"+panelId+"_content' class='panel-collapse collapse panel-body'>"+
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
    
    var id="eventItem_"+category['subCategoryID'];
    id = id.replace("&","\\&"); 
    var selectedCategories=getSelectedCategories();
    var checked=typeof(selectedCategories[category['subCategoryID']])!='undefined';

    if($("#"+id).length==0){
	categoryIndex++;
	var html="<li class='list-group-item groupLink categoryItem' style='height:50px;padding-top:15px' id='"+id+"' subCategoryID='"+category['subCategoryID']+"'>"+
			"<div class='table'>"+
			    "<div class='cell linkWrap'>"+
                "<div class='ellipsis'>"+
				"<a href='#'>"+(category['subCategory'] === "FUTURE PROPS" ? getTextJs['sportbook_left_menu_oddsToWin'] : category['subCategory'])+"</a>"+
                "</div>"+
			    "</div>"+
			    "<div class='cell checkboxWrap' id='checkboxWrap'>"+
				"<input type='checkbox' class='checkbox style2 leftMenuCheckBox' name='category_"+categoryIndex+"' value='"+category['subCategoryID']+"'/>"+
			    "</div>"+
			"</div>"+
		    "</li>";
    //$("#"+panelId+" .categoryList")
    if($("#sportsMenu").html().indexOf(category["subCategoryID"]) == -1) $("#"+panelId+" .categoryList").append(html);
	//if(checked) $('#'+id+' input[type="checkbox"]').click();
    
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
 * Stock the events of Left Menu
 */
function setLeftmenuEvents(){

    $("#sportsMenu .sportPanel .panel-heading").unbind("click");
    $("#sportsMenu .sportPanel .panel-heading").click(function(e){
        if($("body").hasClass('sm') || $("body").hasClass('md')){
            e.stopPropagation();
            var sportPanel=$(this).parents('.sportPanel');
            var isOpen=sportPanel.hasClass('sm-special-open');

            $("#sportsMenu .sportPanel").removeClass('sm-special-open');
            $("#sportsMenu .sportPanel > .panel-body").removeClass('in');

            if(!isOpen) sportPanel.addClass('sm-special-open');
        }else{
            // Collapse menu
            var target = $(this).attr('href');
            if ($(this).hasClass( "collapsed" )){
                $(this).find('.iconArrow').removeClass('collapsed');
                $(this).removeClass('in');
            }else{
                $(this).find('.iconArrow').addClass('collapsed');
                $(this).addClass('in');
            }
        }
    });

    $('#sportsMenu input[type="checkbox"]').unbind("click");
    $('#sportsMenu input[type="checkbox"]').click(function(){
        _SPORT_CATEGORIES_HAS_CHANGED = true;
        setToggleDisableButtonContinue();
    });

    $(".sportPanel .linkWrap").unbind("click");
    $(".sportPanel .linkWrap").click(function(e){
        _SPORT_CATEGORIES_HAS_CHANGED = true;
        var isChecked = $(this).siblings('.checkboxWrap').children('input').is(':checked')
        if (isChecked && $('#groupsWrap').is(':visible'))
            return;

        $("#groupsWrapLong").empty();
        $("#groupsWrapShort").empty();

        e.preventDefault();
        var checks=$(".sportPanel .checkboxWrap .checkbox");
        for(var i=0; i<checks.length; i++){
            var check=checks.eq(i);
            if(check.is(":checked"))
            check.click();
        }
        $(this).parents("li").find(".checkboxWrap .checkbox").click();
        saveLeftMenuSelectedCategories();

        if(_SPORT_CATEGORIES_HAS_CHANGED){
            loadFullGamesData();
            _SPORT_CATEGORIES_HAS_CHANGED = false;
        }

        $("#groupsWrap").show();
        $("#gameWrap").hide();
        $("#wagersReportWrap").hide();
        $("#balanceReportWrap").hide();
        $("#accountHistoryReportWrap").hide();
        $("#overviewWrap").hide();
        updateDom();

        if($("#myOffCanvas").hasClass('activeLeft') || $("#myOffCanvas").hasClass('activeRight'))
            $(".toggle-myOffCanvas").first().click();

        $(".sportPanel").removeClass("sm-special-open");
    });
}

function updateLeftmenu(){
    orderCategories.forEach(function(SportType) {
        if(availableCategories[SportType] != undefined){
            var SportSubCategories=availableCategories[SportType];

            for(var subCategoryID in SportSubCategories){
                var subCategory=SportSubCategories[subCategoryID];
                addCategoryLeftmenu(subCategory);
            }
        }
    });

    for(var SportType in availableCategories){
        var lblnExist = false;
        var pos = 0;
        while(!lblnExist && pos < orderCategories.length){
            if (SportType.toLowerCase() == orderCategories[pos].toLowerCase()) {
                lblnExist = true;
            }
            pos++;
        }

        if (!lblnExist) {
            var SportSubCategories=availableCategories[SportType];
            for(var subCategoryID in SportSubCategories){
                var subCategory=SportSubCategories[subCategoryID];
                addCategoryLeftmenu(subCategory);
            }
        }
    }

    var sportPanels=$("#sportsMenu .sportPanel");
    for(var i=0; i<sportPanels.length; i++){
        var sportPanel=sportPanels.eq(i);
        var sportid=sportPanel.attr('sportid');
        if(typeof(availableCategories[sportid.toUpperCase()])=='undefined'){
            sportPanel.remove();
        }
        else{
            var categoryItems=sportPanel.find(".categoryItem");
            for(var j=0; j<categoryItems.length; j++){
            var categoryItem=categoryItems.eq(j);
            var subCategoryID=categoryItem.attr('subCategoryID');
            if(typeof(availableCategories[sportid.toUpperCase()][subCategoryID])=='undefined')
                categoryItem.remove();
            }
        }
    }
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


function saveLeftMenuSelectedCategories(){
    var selectedCateogies=new Object();
    var checks=$("#sportsMenu input:checked");
    for(var i=0; i<checks.length; i++){
        var value=checks.eq(i).val();
        selectedCateogies[value]=value;
    }
    
    var categoriesBetslip = $.parseJSON(readCookie('categoriesBetslip'));
    for (var index in categoriesBetslip){
        if (selectedCateogies[index] == null) {
          selectedCateogies[index] = index;
        }
    }
    
    saveSelectedCategories(selectedCateogies);
}