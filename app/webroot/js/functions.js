function getCurrentSize(){
    var width=window.innerWidth;

    if(width>=1200)
        return 'lg';
    else if(width>=992)
        return 'md';
    else if(width>=768)
        return 'sm';
    else
    	return 'xs';
}

function goBack(){
    window.history.back();
}

function logout(){
    localStorage.clear();
    sessionStorage.clear();
}

function deactiveBox(){
    window.location.href="/Pages/deactivateBox";
}

function moveScrollTopBody(){ 
    $('body').animate({
        scrollTop: 0
    }, 400);
}

function moveScrollTop(content){
    $(content).animate({
        scrollTop: 0
    }, 400);
}

function moveScrollBottom(content){
    $(content).animate({
        scrollTop: $(content).offset().top
    }, 400);
    
}

function backToTop(){
    window.history.back();
}

function isIsset(obj){
    if (obj == undefined ||
        obj == null ||
        obj.length == 0 ||
        ($.type(obj) == 'object' && Object.keys(obj).length == 0)) {
        return false;
    }
    return true;
}

/**
 * Change Langue of aplication
 * 
 * @param   {string} lang id language
 * @param   {string} path path redirection
 */
function changeLangue(lang, path){
    if (isIsset(lang)) 
        $(location).attr('href','/' + lang + path);
}

function isEmptyO(obj) {
    return Object.keys(obj).length === 0;
}

function isEmpty(val) {
    return (val === undefined || val == null || val.length <= 0) ? true : false;
}

/**
 * parsed to format numeric
 * 
 * @param   {string} numero  
 * @param   {string} decimales
 * @param   {string} decAlign 
 * 
 * @returns {number} number parsed
 */
function formatnumeric(numero, decimales, decAlign){ 
    var numDec = numero;
    if (numero != 0 && !isNaN(parseFloat(numero))){
        var num = parseFloat(numero.toString().replace(',',''));
        var numDec = (Math.round(num * 100) / 100).toFixed(decimales).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        var dec = numDec.substring(numDec.indexOf('.') + 1);
        if(parseInt(dec) == 0 && decAlign == true){
            numDec = numDec.substring(0, numDec.indexOf('.'));
            if (decAlign == true)
                numDec += "&nbsp;&nbsp;&nbsp;&nbsp;";
        }
        return numDec;
    }
    if (decAlign == true) {
        return "0&nbsp;&nbsp;&nbsp;&nbsp;";
    }
    return "0";   
}

/*
 * Delete special Characters of string
 */
function replaceSpecialCharacters(string){
	var pattern = /[^\w\s]/gi;
        string = string.replace(/\-/g, " ");
	return string.replace(pattern, '');
}

function removeSpace(string){
    var pattern = / /g;
	return string.replace(pattern, '')
}

///////////////////////// FUNCTIONS DATE  //////////////////////////

/**
 * formated Date
 * 
 * @param   {string} date time, ex: 2016-04-24 18:00:00.0
 * @param   {string} formatDate desired format, ex: 'mm/dd/yyyy'
 * @param   {string} formatTime desired format, ex: 'hh:mm:ss'
 * @param   {bool} schedule: am/pm
 * 
 * @returns {string} date time parsed
 */
function formatDateUs(date, formatDate, formatTime, schedule, splitCaracter){
    // format enter : 2016-04-24 18:00:00.0
    // use : formatDateUs(date, 'mm/dd/yyyy', 'hh:mm:ss', true);
    
    if (!isIsset(splitCaracter)) {
        splitCaracter = "-";
    }
    
    if (!isIsset(date))
        return;
    
    date = $.trim(date);
    if (date.lastIndexOf('.') != -1) {
        date = date.substring(0, date.lastIndexOf('.'));
    }

    var response = '';
    var resFull = date.split(' ');
    var resDate = (resFull[0] != undefined) ? resFull[0].trim().split(splitCaracter) : null;
    var resTime = (resFull[1] != undefined) ? resFull[1].trim().split(':') : null;
    var year = "", month = "", day = "", hour = "", min = "", sec = "", formatedDate = null, formatedTime = null;
    var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    
    if (formatDate != null && resDate != null) {
        switch (formatDate) {
            case "yyyy/mm/dd":
                year = resDate[0];
                month = resDate[1];
                month = month.length > 1 ? month : '0' + month;
                day = resDate[2];
                day = day.length > 1 ? day : '0' + day;
                formatedDate = year  + '/' + month  + '/' + day;
                response += formatedDate;
                break;
            case "dd/mm/yyyy":
                year = resDate[0];
                month = resDate[1];
                month = month.length > 1 ? month : '0' + month;
                day = resDate[2];
                day = day.length > 1 ? day : '0' + day;
                formatedDate = month + '/' + day + '/' + year;
                response += formatedDate;
                break;
            case "mm/dd/yyyy":
                year = resDate[0];
                month = resDate[1];
                month = month.length > 1 ? month : '0' + month;
                day = resDate[2];
                day = day.length > 1 ? day : '0' + day;
                formatedDate = month + '/' + day + '/' + year ;
                response += formatedDate;
                break;
             case "yy-mm-dd":
                year = resDate[0];
                month = resDate[1];
                month = month.length > 1 ? month : '0' + month;
                day = resDate[2];
                day = day.length > 1 ? day : '0' + day;
                formatedDate =  year.substr(2,4)  + '-' + month  + '-' + day;
                response += formatedDate;
                break;
            case "yyyy MM dd":
                year = resDate[0];
                month = monthNames[resDate[1]];
                day = resDate[2];
                day = day.length > 1 ? day : '0' + day;
                formatedDate = year  + ' ' + month  + ' ' + day;
                response += formatedDate;
                break;
            default:
               
                break;
        }
    }
    
    if (formatTime != null && resTime != null) {
        response += ' ';
        formatedTime ='';
        switch (formatTime) {
            case "hh:mm:ss":
                for(var r in resTime){
                   resTime[r] = resTime[r].replace('am', '').replace('pm', '').trim();
                }
                formatedTime ='';
                hour = (resTime[0] > 12) ? resTime[0] - 12 : (resTime[0].length > 1) ? resTime[0] : "0" + resTime[0];
                min = resTime[1].length > 1 ? resTime[1] : '0' + resTime[1];
                sec = resTime[2].length > 1 ? resTime[2] : '0' + resTime[2];
                formatedTime = hour+':'+min+':'+sec;
                response += formatedTime +" "+getScheduleTime(resTime[0], schedule);
                break;
            case "hh:mm":
                for(var r in resTime){
                    resTime[r] = resTime[r].replace('am', '').replace('pm', '').trim();
                }
                hour = (resTime[0] > 12) ? resTime[0] - 12 : (resTime[0].length > 1) ? resTime[0] : "0" + resTime[0];
                min = resTime[1].length > 1 ? resTime[1] : '0' + resTime[1];
                formatedTime = hour+':'+min;
                response += formatedTime +" "+getScheduleTime(resTime[0], schedule);
                break;
            default:
               
                break;
        }
    }
    return $.trim(response);    
}

function getScheduleTime(hour,schedule){
    var scheduleStr = "";
    if (schedule == true && hour != undefined)
        scheduleStr = hour > 12 ? "pm" : "am";
     
    return scheduleStr;
}

/**
 * Transform a date string to time stamp, ex: 2016-04-24 18:00:00.0
 * 
 * @param   {string} date string
 * @returns {date} time stamp
 */
function parseDateStringToTimeStamp(dateTimeString){
    if (!isIsset(dateTimeString))
        return null;
    
    var dateTimeArray = dateTimeString.split(' ');
    var date = dateTimeArray[0].trim();
    var time = dateTimeArray[1].trim();
    var dateArray = date.split('-');
    var timeArray = time.split(':');
    var y = dateArray[0],
    m = dateArray[1],
    d = dateArray[2],
    h = timeArray[0],
    mn = timeArray[1],
    s = parseInt(timeArray[2]);
    var timeStamp = Math.round(new Date(y+"/"+m+"/"+d+" "+h+":"+mn+":"+s).getTime()/1000);
    if (dateTimeString != 'NaN') {
        return timeStamp;
    }
    return null;
}

/**
 * formated TimeStamp to Date String
 * 
 * @param   {object} timeStamp
 * @param   {string} formatDate desired format, ex: 'mm/dd/yyyy'
 * @param   {string} formatTime desired format, ex: 'hh:mm:ss'
 * @param   {bool} schedule: am/pm
 * 
 * @returns {string} date time parsed
 */
function parseTimeStampToDateString(date, formatDate, formatTime, schedule){
    if (!isIsset(date))
        return;
    
    var response = ''; 
    var year = "", month = "", day = "", hour = "", min = "", sec = "", formatedDate = null, formatedTime = null; 
    if (formatDate != null) {
        year = date.getFullYear();
        month = date.getMonth()+1;
        day = date.getDate();
      
        switch (formatDate) {
              case "yyyy/mm/dd":
                month = month.toString().length > 1 ? month : '0' + month;
                day = day.toString().length > 1 ? day : '0' + day;
                formatedDate = year+'/'+month+'/'+day
                break;
            case "mm/dd/yyyy":
                month = month.toString().length > 1 ? month : '0' + month;
                day = day.toString().length > 1 ? day : '0' + day;
                response += month+'/'+day+'/'+year;
                
                break;
            default:
               
                break;
        }
    }
    
    if (formatTime != null) {
        response += ' ';
        hour = date.getHours();
        min = date.getMinutes();
        sec = date.getSeconds();
        switch (formatTime) {
            case "hh:mm:ss":
                hour = hour+1;
                hour = (hour > 12) ? hour - 12 : (hour < 10) ? "0" + hour : hour;
                min = min.length > 1 ? min : '0' + min;
                sec = sec.length > 1 ? sec : '0' + sec;
                formatedTime = hour+':'+min+':'+sec;
                response += formatedTime +" "+getScheduleTime(resTime[0], schedule);
                break;
            default:
               
                break;
        }
    }
    return $.trim(response); 
}

function formatDateTimeUsStr(date, format) {
    while(date.indexOf('  ') != -1) date = date.replace('  ', ' ');
    date = date.toLowerCase();
    var dateParts = date.split(' ');
    var separador = '-';
    date = dateParts[0] + separador + dateParts[1] + separador + dateParts[2] + " " + dateParts[3];

    //var d = new Date();
    var monthNumbers = new Array();
    monthNumbers["ene"] = 1;
    monthNumbers["jan"] = 1;
    monthNumbers["feb"] = 2;
    monthNumbers["mar"] = 3;
    monthNumbers["abr"] = 4;
    monthNumbers["apr"] = 4;
    monthNumbers["may"] = 5;
    monthNumbers["jun"] = 6;
    monthNumbers["jul"] = 7;
    monthNumbers["ago"] = 8;
    monthNumbers["aug"] = 8;
    monthNumbers["sept"] = 9;
    monthNumbers["sep"] = 9;
    monthNumbers["oct"] = 10;
    monthNumbers["nov"] = 11;
    monthNumbers["dic"] = 12;
    monthNumbers["dec"] = 12;
    
    date = $.trim(date);
    
    if (date.lastIndexOf('.') != -1) {
        date = date.substring(0, date.lastIndexOf('.'));
    }
    
    var resFull = date.split(' ');
    
    var res = resFull[0].split(separador);
    
    var year = "";
    var month = "";
    var day = "";
    
    switch (format) {
        case "yyyy-mm-dd":
            year = res[0];
            month = monthNumbers[res[1]];
            month = month.length > 1 ? month : '0' + month;
            day = res[2];
            day = day.length > 1 ? day : '0' + day;
            break;
        case "dd-mm-yyyy":
            year = res[2];
            month = monthNumbers[res[1]];
            month = month.length > 1 ? month : '0' + month;
            day = res[0];
            day = day.length > 1 ? day : '0' + day;
            break;
        case "mm-dd-yyyy":
            year = res[2];
            month = monthNumbers[res[0]];
            month = month.length > 1 ? month : '0' + month;
            day = res[1];
            day = day.length > 1 ? day : '0' + day;
            break;
    }
    
    var formatedDate = month + '/' + day + '/' + year;
    
    var time = "";
    if (resFull.length > 1) {
        var resTime = resFull[1].split(':');
        for(var r in resTime){
            time += resTime[r].replace('am', '').replace('pm', '');
            if (resTime.length > r+1) 
                time += ":";
        }
    }
    
    var schedule = 'am';
    if (date.indexOf('pm') != -1) {
        schedule = 'pm';
    }

    return formatedDate + " " + time + " " + schedule;
}

/**
 * format Date
 * 
 * @param   {string} date string
 * 
 * @returns {string} date parsed
 */
function formatDate(fecha){ // ! function a cambiar por: formatDateUs(date, 'mm/dd/yyyy', 'hh:mm', true);
    if(fecha){
        var prefecha=fecha.split(" ");
        var year=prefecha[0].split("-");
        var hora=prefecha[1].split(":");
        if(year[0]=="1900"){
            return "";        
        }else{
            var mes = parseFloat(year[1],0) - 1;
            var curMeridiem = hora[0] > 12 ? "pm" : "am";
            var stringYear = year[0].toString();
            var strFecha = stringYear.substr(2,4)+"/"+mes+"/"+year[2]+" "+ hora[0]+":"+hora[1]+curMeridiem;
            return strFecha;
        } 
    }
    return fecha;
    
}

function toTimestamp(strDate){
    var datum = Date.parse(strDate);
    return datum/1000;
}

function switchClassHideData(object){
	if (object.hasClass('hide-data')) {
		object.removeClass('hide-data');
        object.addClass('show-data');
	}else{
        object.removeClass('show-data');
		object.addClass('hide-data');
	}
}

function switchGlyphicon(object){
	if(object.hasClass('glyphicon-plus-sign')){
		object.switchClass('glyphicon-plus-sign','glyphicon-minus-sign');
	}
	else{
		object.switchClass('glyphicon-minus-sign','glyphicon-plus-sign');
	}

}

function moveScrollVertical(positionTop){
    $('html, body').animate({
        scrollTop: positionTop
    }, 400);
}

function moveScrollContentVertical(obj, positionTop){
    $(obj).animate({
        scrollTop: positionTop
    }, 400);
}

function parseDescriptionSign(Description, exception1, exception2, exception3){
    Description = Description.replace(/(\r\n|\n|\r)/g,"<br/>");
    Description = Description.replace(/(^\s+|\s+$)/g,' ');
    var numberPattern = /\d+/g;
    //var numberPattern = /\d+(\d+)?/g;
    var DescriptionSearch = Description;
    var DescriptionFinal = "";
    var lstNumbersDescription = DescriptionSearch.match(numberPattern);
    var antPos = 0;
    
    if(lstNumbersDescription == null){
        return DescriptionFinal;
    }
    $.each(lstNumbersDescription, function(i, item) {
        if (exception1 != item && exception2 != item && exception3 != item) {
            var regex = new RegExp('\\b' + item + '\\b');
            var tamNumber = item.length;
            
            DescriptionFinal += DescriptionSearch.substring(0, antPos);
            DescriptionSearch = DescriptionSearch.substring(antPos);
            
            //var pos = DescriptionSearch.search(regex);
            var pos = DescriptionSearch.indexOf(item);
            if (pos != -1) {
                if(DescriptionSearch.charAt(pos - 1) != '.' &&
                   DescriptionSearch.charAt(pos - 1) != '-' &&
                   DescriptionSearch.charAt(pos - 1) != '+' &&
                   !(pos == 0 && (DescriptionFinal.slice(-1) == '-' || DescriptionFinal.slice(-1) == '+')) &&
                   !(DescriptionSearch.charAt(pos - 1) == ' ' && (DescriptionSearch.charAt(pos - 2) == '-' ||
                                                                  DescriptionSearch.charAt(pos - 2) == '+'))){
                    var previousWord = $.trim(DescriptionSearch.substring(0, pos));
                    previousWord = $.trim(previousWord.substring(previousWord.lastIndexOf(' '))).toLowerCase();
                    
                    var itemPlus = 0;
                    
                    var ordinalWord = DescriptionSearch.substring(pos + item.length, pos + item.length + 3);
                    if (previousWord != "over" && previousWord != "under" && ordinalWord != "st " && ordinalWord != "nd " && ordinalWord != "rd " && ordinalWord != "th ") {
                        //Description = Description.replace(regex, "+" + item);
                        if (item == "0") {
                            if (DescriptionSearch.charAt(pos + 1) == ".") {
                                DescriptionSearch = DescriptionSearch.substring(0, pos - 1) + DescriptionSearch.substring(pos).replace(item, " +");
                            }
                            else{
                                DescriptionSearch = DescriptionSearch.substring(0, pos - 1) + DescriptionSearch.substring(pos).replace(item, " ");
                            }
                        }
                        else{
                            DescriptionSearch = DescriptionSearch.substring(0, pos - 1) + DescriptionSearch.substring(pos).replace(item, " +" + item);
                            itemPlus++;
                        }
                    }
                    tamNumber = item.length + itemPlus;
                }
                else if (DescriptionSearch.charAt(pos - 1) == '.') {
                    switch (item.toString().charAt(0)) {
                        case '0':
                            DescriptionSearch = DescriptionSearch.substring(0, pos - 1) + DescriptionSearch.substring(pos).replace(regex, "");
                            break;
                        case '2':
                            DescriptionSearch = DescriptionSearch.substring(0, pos - 1) + DescriptionSearch.substring(pos).replace(regex, "&frac14");
                            break;
                        case '5':
                            DescriptionSearch = DescriptionSearch.substring(0, pos - 1) + DescriptionSearch.substring(pos).replace(regex, "&frac12");
                            break;
                        case '7':
                            DescriptionSearch = DescriptionSearch.substring(0, pos - 1) + DescriptionSearch.substring(pos).replace(regex, "&frac34");
                            break;
                    }
                    tamNumber = 8;
                }
                else if (DescriptionSearch.charAt(pos - 1) == '-' && item == "0") {
                    DescriptionSearch = DescriptionSearch.substring(0, pos) + DescriptionSearch.substring(pos).replace(regex, "");
                    tamNumber = 0;
                }
            }
            antPos = pos + tamNumber;
        }
    });
    
    DescriptionFinal += DescriptionSearch;
    
    return DescriptionFinal;
}

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

function deleteAllCookies() {
    var cookies = document.cookie.split(";");

    for (var i = 0; i < cookies.length; i++) {
    	var cookie = cookies[i];
    	var eqPos = cookie.indexOf("=");
    	var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
    	document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
    }
}

/**
 * Count Unread Messages (webmail)
 */
function countUnreadMessages(){
    // Count message unread
    $.ajax({
      url : "/AgentMail/countUnreadMessagesInBox",
      type : 'post',
      async : true,
      dataType : "html",
      success : function(data) {
        if (data > 0)
            $('.badge-mail').html(data)
        else
            $('.badge-mail').empty();
      }});
}

function modalMessages(mensaje1,mensaje2,buttons) {
    var result = "";
    $('#confirmationModalDisplay').html("");             
    $('#footerButtons').html("");

    result+="<div class=\"table\" style='background-color: #FFFFFF;text-align: center;width: 100%;'>";
    result+="    <div>";
    result+="        <div>";
    result+="           <div>";
    result+="               <p style='color:#000000;'> " + mensaje1 + "</p>";
    result+="           </div>";
    result+="        </div>";
    result+="    </div>";
    result+="</div>";
  
    $('#confirmationModalDisplay').append(result);
    $('#footerButtons').append(buttons);            
    $("#confirmationModal").modal("toggle");   
}

function showMessage(msgType, msgDesc, urlRedirect) {
    switch (msgType) {
        case 'PASSWORD':
            var buttons = "";  
            buttons+="<button id=\"confirmationModalButton\" name=\"confirmationModalButton\" onclick=\"$('#confirmationModal').modal('toggle');" + ((urlRedirect != undefined && urlRedirect != null) ? "window.location.href = '" + urlRedirect + "';": "") + "\" type=\"button\" class=\"btn btn-success\">";
                    buttons+="OK";
            buttons+="</button>";
            modalMessages(msgDesc,'',buttons);
            break;
        case 'NOROWS':
            var buttons = "";  
            buttons+="<button id=\"confirmationModalButton\" name=\"confirmationModalButton\" onclick=\"$('#confirmationModal').modal('toggle');" + ((urlRedirect != undefined && urlRedirect != null) ? "window.location.href = '" + urlRedirect + "';": "") + "\" type=\"button\" class=\"btn btn-success\">";
                    buttons+="OK";
            buttons+="</button>";
            modalMessages(msgDesc,'',buttons);
            break;
        case 'BADSAVE':
        case 'SAVE':
            var result = "";
            
            var buttons = "";
            
            buttons+="<button id=\"confirmationModalButton\" name=\"confirmationModalButton\" onclick=\"$('#confirmationModal').modal('toggle');" + ((urlRedirect != undefined && urlRedirect != null) ? "window.location.href = '" + urlRedirect + "';": "") + "\" type=\"button\" class=\"btn btn-success\">";
                    buttons+="OK";
            buttons+="</button>";                    
            modalMessages(msgDesc,'',buttons);
                                                     
            break;
    }
}

function showMessageLogin(msgType, msgDesc, user, Pass, redirectUrl) {
    switch (msgType) {
        case 'NOROWS':
            var buttons = "";  
            buttons+="<button id=\"confirmationModalButton\" name=\"confirmationModalButton\" onclick=\"doLogin('" + user + "', '" + Pass + "', '" + redirectUrl + "');\" type=\"button\" class=\"btn btn-success\">";
                    buttons+="OK";
            buttons+="</button>";
            modalMessages(msgDesc,'',buttons);
            break;
        case 'BADSAVE':
        case 'SAVE':
            var result = "";
            
            var buttons = "";
            
            buttons+="<button id=\"confirmationModalButton\" name=\"confirmationModalButton\" onclick=\"doLogin('" + user + "', '" + Pass + "', '" + redirectUrl + "');\" type=\"button\" class=\"btn btn-success\">";
                    buttons+="Click OK to Enter the Site";
            buttons+="</button>";                    
            modalMessages(msgDesc,'',buttons);
                                                     
            break;
    }
}




function getInfoCustomer(){
    //Register
    $.ajax({
        type: "POST",
        url: "/Pages/getInfoCustomer",
        dataType: "json",
        async: true,
        success: function(data){
            if (siteCache['customer'] !== undefined) {
                siteCache['customer']['AvailableBalance'] = data["Available"];
                siteCache['customer']['PendingWager'] = parseFloat(data["PendingWagerBalance"]);
                siteCache['customer']['FreePlayBalance'] = parseFloat(data["FreePlayBalance"]);
                siteCache['customer']['CasinoBalance'] = parseFloat(data["CasinoBalance"]);
                siteCache['customer']['CurrentBalance'] = parseFloat(data["Current"]);
                siteCache['customer']['PriceType'] = data["PriceType"];
                updateCustomer();
            }
        },
        error: function (request, status, error) {
            //alert(request.responseText);
        }
    });
}

function updateCustomer(){
    var customer=siteCache['customer'];
    $(".FreePlayBalance").html(formatnumeric(myRound(customer['FreePlayBalance'], 2), 2, false));
    $(".CurrentBalance").html(formatnumeric(myRound(customer['CurrentBalance'], 2), 2, false));
    $(".AvailableBalance").html(formatnumeric(myRound(customer['AvailableBalance'], 2), 2, false));
    $("#CurrentBalance, .CurrentBalance").html(formatnumeric(myRound(customer['CurrentBalance'], 2), 2, false));
    $("#AvailableBalance").html(formatnumeric(myRound(customer['AvailableBalance'], 2), 2, false));
    $("#PendingWager").html(formatnumeric(myRound(customer['PendingWager'], 2), 2, false));
    $(".PendingWagerBalance").html(formatnumeric(myRound(customer['PendingWager'], 2), 2, false));
    $("#AvailablePending").html(formatnumeric(myRound(customer['PendingWager'], 2), 2, false));
    
    $(".CasinoBalance").html(formatnumeric(myRound(customer['CasinoBalance'], 2), 2, false)*-1);
    $(".CustomerID").html(customer['CustomerID']);
    
    $("#shopping-cart").html(countSelectionsOnBetslip());
    $("#select-priceType option[value='"+siteCache['customer']['PriceType']+"']" ).prop('selected', true);
    $("#select-priceType").selectmenu().selectmenu('refresh', true); 
}