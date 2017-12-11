var cutomerclick = 0;
var currentCustomer = "";


/*
 * The sessionStorage Object
 * setter
 */
function setSessionStorageObjects(name, value){
    if(typeof(Storage) !== "undefined") {
        // Code for sessionlStorage/sessionStorage.
        sessionStorage.removeItem(name);
        sessionStorage.setItem(name, value);
    }
    else{
        console.log('Sorry! No Web Storage support..')
    }
}

/*
 * The sessionStorage Object
 * getter
 */
function getSessionStorageObjects(name){
    if(typeof(Storage) !== "undefined") {
        return sessionStorage.getItem(name);
    }
    else{
        console.log('Sorry! No Web Storage support..')
    }
}

/*
 * The sessionStorage Object
 * Remove session
 */
function removeSessionStorageObjects(name){
    if(typeof(Storage) !== "undefined") {
        sessionStorage.removeItem(name);
    }
    else{
        console.log('Sorry! No Web Storage support..')
    }
}

/*
 * The sessionStorage Object
 * Clear all session
 */

function deleteGlobalSessionStorageObjects(){
    if(typeof(Storage) !== "undefined") {
        sessionStorage.clear();
    }
    else{
        console.log('Sorry! No Web Storage support..')
    }
}
////////////////////////////////////


function openAccount(cuenta){
    setSessionStorageObjects('customer', cuenta);
    setTimeout(
        function() {
            validaNav($('#saveChangesBefore').val(),'Personal');
        },
        500
    );   
}

/*
 *shorten string without cutting words
 *@param string : text
 *@param int : number of characters
 *@return short string
 */
function shortText(text, nbChar) {
    
    //trim the string to the maximum length
    var shortText = text.substr(0, nbChar);
    
    //re-trim if we are in the middle of a word
    shortText = shortText.substr(0, Math.min(shortText.length, shortText.lastIndexOf(" ")))
    shortText += " ...";
    return shortText;
}
 /*
 * parse special character in description
 * @param string : text
 * @return short text parsed
 */ 

function putLineNumber(strText, strSeparator){
    var strTextResult = "";
    var position = 1;
    
    var list = strText.split(strSeparator);
    $.each(list, function(i, item) {
        strTextResult += strSeparator + "#" + position.toString() + " - " + item;
        position++;
    });
    
    return strTextResult;
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
    $.each(lstNumbersDescription, function(i, item) {
        if (exception1 != item && exception2 != item && exception3 != item) {
            var regex = new RegExp('\\b' + item + '\\b');
            var tamNumber = 0;
            
            DescriptionFinal += DescriptionSearch.substring(0, antPos - 1);
            DescriptionSearch = DescriptionSearch.substring(antPos - 1);
            
            var pos = DescriptionSearch.search(regex);
            if (pos != -1) {
                if(DescriptionSearch.charAt(pos - 1) != '.' && DescriptionSearch.charAt(pos - 1) != '-' && DescriptionSearch.charAt(pos - 1) != '+' && !(DescriptionSearch.charAt(pos - 1) == ' ' && (DescriptionSearch.charAt(pos - 2) == '-' || DescriptionSearch.charAt(pos - 2) == '+'))){
                    var previousWord = trim(DescriptionSearch.substring(0, pos));
                    previousWord = trim(previousWord.substring(previousWord.lastIndexOf(' '))).toLowerCase();
                    if (previousWord != "over" && previousWord != "under") {
                        //Description = Description.replace(regex, "+" + item);
                        if (item == "0") {
                            if (DescriptionSearch.charAt(pos + 1) == ".") {
                                DescriptionSearch = DescriptionSearch.substring(0, pos - 1) + DescriptionSearch.substring(pos).replace(regex, " +");
                            }
                            else{
                                DescriptionSearch = DescriptionSearch.substring(0, pos - 1) + DescriptionSearch.substring(pos).replace(regex, " ");
                            }
                        }
                        else{
                            DescriptionSearch = DescriptionSearch.substring(0, pos - 1) + DescriptionSearch.substring(pos).replace(regex, " +" + item);    
                        }
                    }
                    tamNumber = item.length;
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
                }
            }
            antPos = pos + tamNumber;
        }
    });
    
    DescriptionFinal += DescriptionSearch;
    
    return DescriptionFinal;
}

function parseDescriptionModalReports(text){
  text = text.replace('/½/g', "&#189;");
  text = text.replace(' L-', " Live ");
  text = text.replace('/\.L\-/', "Live ");
  text = text.replace(' .L-', "Live ");
  text = text.replace('.L-', "Live ");
 
  text = text.replace(/(\r\n|\n|\r)/g,"<br/>");
 
  return text;
}

/*
 *
 */
function uncheckCheckBoxModal2(first, second) {
    var firstck = $("#" + first).is(':checked');
    var agentType = $('#agentTypeNewAcc').val();

    if (firstck == true) {
        $("#" + second).prop('checked', false);
    } else {
        $("#" + first).prop('checked', false);
    }
}

/*
 *
 */
function uncheckCheckBoxDB(first, second) {
    var firstck = $("#" + first).is(':checked');
    if (firstck == true) {
        if (first == "ManualDB") {
            SelectedBDDiv(1);
        } else {
            SelectedBDDiv(0);
        }
        $("#" + second).prop('checked', false);
    } else {
        SelectedBDDiv(0);
        $("#" + first).prop('checked', false);
    }
}

/*
 *
 */
function SelectedBDDiv(valor) {
    if (valor == 1) {
        $("#ManualDBSelected").fadeIn('fast');
    } else {
        $("#ManualDBSelected").fadeOut('fast');
        $("#DB01").prop('checked', false);
        $("#DB02").prop('checked', false);
        $("#DB03").prop('checked', false);
        $("#DB04").prop('checked', false);
    }
}

/*
 *
 */
function uncheckCheckBoxDBSelected(db1, db2, db3, db4) {

    var firstck = $("#" + db1).is(':checked');

    if (firstck == true) {
        $("#" + db2).prop('checked', false);
        $("#" + db3).prop('checked', false);
        $("#" + db4).prop('checked', false);
    } else {
        $("#" + db1).prop('checked', false);
    }

}

/*
 *
 */
function saveNewPack(account, password) {

    var agentID = "";
    var dataBase = "NA";

    var masterck = $("#Master3").is(':checked');
    var agentck = $("#Agent3").is(':checked');

    var AutomaticDB = $("#AutomaticDB").is(':checked');
    var ManualDB = $("#ManualDB").is(':checked');

    if (masterck) {
        agentID = "M";
    }
    if (agentck) {
        agentID = "A";
    }
    if (AutomaticDB) {
        dataBase = "0";
    }
    if (ManualDB) {
        var DB01 = $("#DB01").is(':checked');
        var DB02 = $("#DB02").is(':checked');
        var DB03 = $("#DB03").is(':checked');
        var DB04 = $("#DB04").is(':checked');

        if (DB01) {
            dataBase = "1";
        }
        if (DB02) {
            dataBase = "2";
        }
        if (DB03) {
            dataBase = "3";
        }
        if (DB04) {
            dataBase = "4";
        }
    }

    $('#msjReqVals2').hide();
    $('#msjReqVals2').html("");

    if (account.length < 1 || agentID.length < 1 || password.length < 1 || dataBase == "NA") {
        var contReqFields = 0;
        var reqval = "";

        if (account.length < 1) {
            contReqFields += 1;
            reqval += " New Account , ";
        }
        if (agentID.length < 1) {
            contReqFields += 1;
            reqval += " Account Type , ";
        }
        if (password.length < 1) {
            contReqFields += 1;
            reqval += " Password , ";
        }
        if (dataBase == "NA") {
            contReqFields += 1;
            reqval += " Target Database, ";
        }

        $('#msjReqVals2').show();
        $('#msjReqVals2').html("Required fields: " + reqval);

    } else {

        var url = $('#baseurl').val();
        url = url + "App/createnew";
        var parametros = {
            NewAccount: account,
            TypeAccount: agentID,
            Password: password,
            Inherit: 0,
            Father: dataBase
        };

        $.ajax({
            type: "POST",
            url: url,
            cache: false,
            async: false,
            data: parametros,
            success: function(data) {

                activarModal(1);
                $("#createNewAccountId").prop('value', '');
                $('#msjverify').html("");
                $('#msjverify').hide();
                $('#msj').html("");
                $('#msj').hide();
                $('#createNewAccountNew').modal('hide');
                showMessage('SAVE_NEW_ACCOUNT', '', '', '');
            }
        });
    }

}


function trim(str) {
    var palabra = str;
    if (palabra) {
        str = palabra.replace(/^\s*|\s*$/g, "");
    }
    return str;
}

function changeActionFrm(idAction) {
    if ($('#webside').val().trim() != '' && !$('#hiddenCustomerId').attr('disabled')) {
        var urlForm = $('#webside').val().trim().replace(' ', '').replace('http://', '').replace('https://', '');
        switch (idAction) {
            case 1:
                $('#strPageRedirect').val('');
                $('#frmLinks').prop('action', 'http://' + urlForm + '/LoginVerify.Asp');
                break;
            case 2:
                $('#strPageRedirect').val('livebetting');
                $('#frmLinks').prop('action', 'http://' + urlForm + '/LoginVerify.Asp');
                break;

            case 3:
                $('#strPageRedirect').val('racebook');
                $('#frmLinks').prop('action', 'http://' + urlForm + '/LoginVerify.Asp');
                break;

            case 4:
                $('#strPageRedirect').val('casino');
                $('#frmLinks').prop('action', 'http://' + urlForm + '/LoginVerify.Asp');
                break;
            case 5:

                var strUlArr = $('#webside').val().split('.');
                if (strUlArr[0] === 'www') {
                    var strUrl = 'mobile.' + strUlArr[1] + '.' + strUlArr[2];
                } else {
                    var strUrl = 'mobile.' + strUlArr[0] + '.' + strUlArr[1];
                }

                $('#frmLinks').prop('action', 'http://' + strUrl + '/sportbook/login?username=' + $('#hiddenCustomerId').val().trim() + '&password=' + $('#hiddenPasswordCustomer').val());
                $('#strPageRedirect').val('mobile');
                break;
            case 6:
                var strUlArr = $('#webside').val().split('.');
                if (strUlArr[0] === 'www') {
                    var strUrl = 'mobile.' + strUlArr[1] + '.' + strUlArr[2];
                } else {
                    var strUrl = 'mobile.' + strUlArr[0] + '.' + strUlArr[1];
                }
                $('#frmLinks').prop('action', 'http://' + strUrl + '/sportbook/login?username=' + $('#hiddenCustomerId').val().trim() + '&password=' + $('#hiddenPasswordCustomer').val() + '&livemobile=1&forcelive=1&domain=' + strUrl);
                $('#strPageRedirect').val('livemobile');
                break;
        }

        $('#frmLinks').submit();
    } else {

        showMessage('EXTERNAL_LINK_URL', '', '', '');
    }
}

function setSundayDate() {
    var fecha = new Date();
    var d = new Date();
    var dia = parseInt(d.getDay());
    switch (dia) {
        case 0:
            d = 0;
            break;
        case 1:
            d = 6;
            break;
        case 2:
            d = 5;
            break;
        case 3:
            d = 4;
            break;
        case 4:
            d = 3;
            break;
        case 5:
            d = 2;
            break;
        case 6:
            d = 1;
            break;
    }
    fecha.setDate(fecha.getDate() + parseInt(d));
    var anno = fecha.getFullYear();
    var mes = fecha.getMonth() + 1;
    var dia = fecha.getDate();

    mes = (mes < 10) ? ("0" + mes) : mes;
    dia = (dia < 10) ? ("0" + dia) : dia;
    var fechaFinal = mes + '/' + dia + '/' + anno;

    return (fechaFinal);

}

function setMondayDate() {

    var fecha = new Date();

    var d = new Date();
    var dia = parseInt(d.getDay());
    
    switch (dia) {
        case 0:
            d = 6;
            break;
        case 1:
            d = 0;
            break;
        case 2:
            d = 1;
            break;
        case 3:
            d = 2;
            break;
        case 4:
            d = 3;
            break;
        case 5:
            d = 4;
            break;
        case 6:
            d = 5;
            break;
    }

    fecha.setDate(fecha.getDate() - parseInt(d));
    var anno = fecha.getFullYear();
    var mes = fecha.getMonth() + 1;
    var dia = fecha.getDate();

    mes = (mes < 10) ? ("0" + mes) : mes;
    dia = (dia < 10) ? ("0" + dia) : dia;
    var fechaFinal = mes + '/' + dia + '/' + anno;

    return (fechaFinal);

}


/**
 * format Numeric without thousand separator
 * 
 * @param   {float} numero  
 * @param   {int} decimales number of decimales
 * 
 * @returns {int} number parced
 */
function formatNumericWithNoSeparation(num, dec) {
    if (num != 0) {
        if (!isNaN(parseFloat(num))) {
            var res = parseFloat(num.toString().replace(',',''));
            numDec = (Math.round(num * 100) / 100).toFixed(dec);
            return numDec;
        }
    } 
    return 0;
}


function suppressBackspace(evt) {
    evt = evt || window.event;
    var target = evt.target || evt.srcElement;
    if (evt.keyCode == 8 && !(target.nodeName.toLowerCase() === "textarea" || target.nodeName.toLowerCase() == "input")  && target.id != "globalcustomer") {
        return false;
    } else {
        if (evt.keyCode == 8 && target.id == "globalcustomer" && validasalida("Promotions", target)) {
            clean();
        }
        /*if (evt.keyCode == 8 && target.id == "globalcustomer") {
            clean();
        }*/
    }
}

function saveNewAccount(father, account, agent, password) {
    //alert('URL: ' + url + ' , User: ' + user +' , Father: ' + father + ', Account: ' + account + ' , Agent: ' + agent);
    var agentID = "";
    var inheritVal = 3;
    var masterck = $("#Master2").is(':checked');
    var agentck = $("#Agent2").is(':checked');
    var playerck = $("#Player2").is(':checked');
    var inheritYesck = $("#inheritYes").is(':checked');
    var inheritNock = $("#inheritNo").is(':checked');

    if (masterck) {
        agentID = "M";
    }
    if (agentck) {
        agentID = "A";
    }
    if (playerck) {
        agentID = "P";
    }
    if (inheritYesck) {
        inheritVal = 1;
    }
    if (inheritNock) {
        inheritVal = 0;
    }

    $('#msjReqVals').hide();
    $('#msjReqVals').html("");
    var customer = $('#globalcustomer').val()
    var encontroAgent = $('#encontroAgent').val();
    
    if (father.length < 1 || account.length < 1 || agentID.length < 1 || password.length < 1 || inheritVal == 3) {
        var contReqFields = 0;
        var reqval = "";

        if (father.length < 1) {
            contReqFields += 1;
            reqval += " Assign to , ";
        }
        if (account.length < 1) {
            contReqFields += 1;
            reqval += " New Account , ";
        }
        if (agentID.length < 1) {
            contReqFields += 1;
            reqval += " Account Type , ";
        }
        if (password.length < 1) {
            contReqFields += 1;
            reqval += " Password , ";
        }
        if (inheritVal == 3) {
            contReqFields += 1;
            reqval += " Inherit Option , ";
        }

        $('#msjReqVals').show();
        $('#msjReqVals').html("Required fields: " + reqval);

    } else {
        var url = $('#baseurl').val();
        url = url + "App/createnew";
        var parametros = {
            NewAccount: account,
            TypeAccount: agentID,
            Password: password,
            Father: father,
            Inherit: inheritVal,
        };

        $.ajax({
            type: "POST",
            url: url,
            cache: false,
            async: false,
            data: parametros,
            success: function(data) {

                activarModal(1);
                $('#createNewAccountAssign').modal('hide');
                $("#createNewAccountId").prop('value', '');
                $('#msjverify').html("");
                $('#msjverify').hide();
                $('#msj').html("");
                $('#msj').hide();
                validacuenta();

                showMessage('SAVE_NEW_ACCOUNT', '', '', '');
            }
        });
    }
}

function validexpres(id) {

    var url = $('#baseurl').val();
    url = url + "App/validaccount";
    var parametros = {
        player: id
    };
    $.ajax({
        type: "POST",
        url: url,
        dataType: "json",
        data: parametros,
        success: function(data) {
            if (data == 0) {
                $('#msj').show();
                $('#msj').html(getMessage('INVALID_ACCOUNT', trim($('#createNewAccountId').val())));
                activarModal(2);
                $('#userNewAcc').prop('value', '');
                $('#agentTypeNewAcc').prop('value', '');
                $('#createNewAccountId').prop('value', '');
                $('#createNewAccountId').focus();
                $('#msjverify').html('');
                $('#msjverify').hide();
            }
            else{
                activarModal(1);
                $('#masterAgentID').prop('value', trim($('#createNewAccountId').val()));
                $('#msjverify').show();
                $('#msjverify').html(getMessage('SUCCESSFUL_VERI', ''));
                $('#newFatherId').prop('value', id);
                $('#agentTypeNewAcc').prop('value', data["Type"]);
                $('#userNewAcc').prop('value', $('#globalcustomer').val());
                $('#msj').html("");
                $('#msj').hide();
            }
        }
    });

}

function uncheckCheckBoxModal(first, second, thrird) {

    var firstck = $("#" + first).is(':checked');
    var agentType = $('#agentTypeNewAcc').val();

    if (agentType == "M" && (first == "Master2" || first == "Agent2")) {
        if (firstck == true) {
            $("#" + second).prop('checked', false);
            $("#" + thrird).prop('checked', false);
        } else {
            $("#" + first).prop('checked', false);
        }
    }

    if (agentType == "M" && first == "Player2") {
        $("#" + first).prop('checked', false);
    }

    if (agentType == "A" && (first == "Master2" || first == "Agent2")) {
        $("#" + first).prop('checked', false);
        $("#" + second).prop('checked', false);
    }
}

function uncheckCheckBoxInherit(first, second, group) {
    var firstck = $("#" + first).is(':checked');
    var secondck = $("#" + second).is(':checked');
    if (firstck == true) {
        $("#" + second).prop('checked', false);
    } else {
        $("#" + first).prop('checked', false);
    }
}

function modalMessages(mensaje1,mensaje2,buttons) {
    var result = "";
    $('#confirmationModalDisplay').html("");             
    $('#footerButtons').html("");

    result+="<table width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"table \">";         
        result+="<tbody>";
            result+="<tr>";
                    result+="<td ><p> " + mensaje1 + "</p></td>";                                                                                                                                   
            result+="</tr>";                
        result+="</tbody>";                        
    result+="</table>";
  
    $('#confirmationModalDisplay').append(result);
    $('#footerButtons').append(buttons);            
    $("#confirmationModal").modal("toggle");
    
}


function validacuenta(target) {

    var url = $('#baseurl').val();
    url = url + "App/validaccount";
    var parametros = {
        player: $('#globalcustomer').val(),
        target: target
    };

    $.ajax({
        type: "POST",
        url: url,
        dataType: "json",
        data: parametros,
        success: function(data) {                 
            if (data["existe"] == 0 || data["existe"].LoginID == "NewAccount") {
                var continuar = "N";
                var opcion = 0;               
                var buttons = "";
                var msgDesc = getTextJs['admin_general_ThisAccountDoesNotExist'];                  
                buttons+="<button id=\"confirmationModalButton\" name=\"confirmationModalButton\" onclick=\"$('#confirmationModal').modal('toggle');clean();$('#globalcustomer').focus();\" type=\"button\" class=\"btn btn-success\">";
                        buttons+="OK";
                buttons+="</button>";                    
                modalMessages(msgDesc,'',buttons);                                     
            }
            else{
                if(trim(data["AgentInJer"].AgentInJer) == "Y"){
               
                    $('#encontroAgent').prop('value', '1');
                    $("#website").prop('value', trim(data["existe"].InetTarget));
                    $("#accounttype").prop('value', trim(data["existe"].Type));
                    $("#parent").prop('value', trim(data["existe"].Parent));
                    $("#storeown").prop('value', trim(data["existe"].Store));
                    $("#dbNumber").prop('value', trim(data["existe"].DB));
                    $("#isinlive").prop('value', trim(data["existe"].Live));
                    $('#hiddenCustomerId').val(trim(data["existe"].LoginID));
                    $('#hiddenPasswordCustomer').val(data["existe"].Password);

                }else{
                    var continuar = "N";
                    var opcion = 0;
                    var buttons = "";
                    var msgDesc = getTextJs['admin_general_youDoesntHavePermissionToThisCustomer'];                    
                    buttons+="<button id=\"confirmationModalButton\" name=\"confirmationModalButton\" onclick=\"$('#confirmationModal').modal('toggle');clean();$('#globalcustomer').focus();\" type=\"button\" class=\"btn btn-success\">";
                            buttons+="OK";
                    buttons+="</button>";                    
                    modalMessages(msgDesc,'',buttons);                    
                }
            }            
        }
    });
}

function activarModal(valor) {
    if (valor == 1) {
        $("#Master2").prop('disabled', false);
        $("#Agent2").prop('disabled', false);
        $("#Player2").prop('disabled', false);
        $("#inheritYes").prop('disabled', false);
        $("#inheritNo").prop('disabled', false);
        $("#newPasswordId").prop('disabled', false);
        $("#newFatherId").prop('disabled', true);
        $("#newAccountId").prop('disabled', false);
        $('#newFatherId').prop('value', '');
        $('#newPasswordId').prop('value', '');
        $("#Master2").prop('checked', false);
        $("#Agent2").prop('checked', false);
        $("#Player2").prop('checked', false);
        $("#inheritYes").prop('checked', false);
        $("#inheritNo").prop('checked', false);
    } else {
        $("#Master2").prop('disabled', true);
        $("#Agent2").prop('disabled', true);
        $("#Player2").prop('disabled', true);
        $("#inheritYes").prop('disabled', true);
        $("#inheritNo").prop('disabled', true);
        $("#Master2").prop('checked', false);
        $("#Agent2").prop('checked', false);
        $("#Player2").prop('checked', false);
        $("#inheritYes").prop('checked', false);
        $("#inheritNo").prop('checked', false);
        $("#newPasswordId").prop('disabled', true);
        $("#newFatherId").prop('disabled', true);
        $("#newAccountId").prop('disabled', true);
        $('#newFatherId').prop('value', '');
        $('#newPasswordId').prop('value', '');
    }
}

function activarModal2(valor) {
    if (valor == 1) {
        $("#Master3").prop('disabled', false);
        $("#Agent3").prop('disabled', false);
        $("#newPasswordId2").prop('disabled', false);
        $("#newAccountId2").prop('disabled', false);
        $('#newPasswordId2').prop('value', '');
        $("#Master3").prop('checked', false);
        $("#Agent3").prop('checked', false);
        $("#AutomaticDB").prop('disabled', false);
        $("#ManualDB").prop('disabled', false);
        $("#DB01").prop('disabled', false);
        $("#DB02").prop('disabled', false);
        $("#DB03").prop('disabled', false);
        $("#DB04").prop('disabled', false);

    } else {
        $("#Master3").prop('disabled', true);
        $("#Agent3").prop('disabled', true);
        $("#Master3").prop('checked', false);
        $("#Agent3").prop('checked', false);
        $("#newPasswordId2").prop('disabled', true);
        $("#newAccountId2").prop('disabled', true);
        $('#newPasswordId2').prop('value', '');
        $("#AutomaticDB").prop('disabled', true);
        $("#ManualDB").prop('disabled', true);
        $("#DB01").prop('disabled', true);
        $("#DB02").prop('disabled', true);
        $("#DB03").prop('disabled', true);
        $("#DB04").prop('disabled', true);
    }
}

function createNewAccount(customer, opcion) {
    if (opcion == 2) {
        activarModal(2);
        $('#createNewAccountAssign').modal('show');
        $('#newAccountId').prop('value', customer);
        $("#createNewAccountId").prop('disabled', false);
        document.getElementById("createNewAccountId").focus();
    }
    if (opcion == 1) {
        activarModal2(1);
        $('#createNewAccountNew').modal('show');
        $('#newAccountId2').prop('value', customer);
    }
}

function cierra() {
    $(".teaser").hide();
    $(".parlay").hide();
    $(".detaillimits").hide();
    $(".principal").show();
    $(".buyandsell").hide();
    $(".detaillimits2").hide();
    $("#parentID").val('G');
    cierraparlay();
    cierrateaser();
    $('#pressSelectedTeaser').prop("value", "N");
}

function cierraparlay() {
    $(".parlaydetalle").hide();
    $('#tipo_parlay').html("");
    $('#parlayconfiguration').html("");
    $('#parlaydet').html("");
    $('#newParlay').html("");
}

function cierrateaser() {
    $(".teaserbuttons").hide();
    $('#teasers_cat').html("");
    $(".teaserdetail").hide();
    $('#teasearsDetail').html("");
}

function clean() {
    
    $('#account').prop('value',"");
    $("#weeklybalancedetail").html(""); 
    $("#weeklybalancediv").hide(); 
    $('#encontroAgent').prop('value', '0');

    $(".text").each(function() {
        $(this).prop("value", "");
    });

    $(".numeric").each(function() {
        $(this).prop("value", 0);
    });

    $(".cheked").each(function() {
        $(this).prop('checked', false);
    });

    var parentID = trim($('#parentID').val());
    
    if(parentID == 'WB'){
        var date = new Date();
        var datestring = setSundayDate();
        $('#calendar').prop('value', datestring);        
    }
    
    if(parentID == 'AP'){
        var date = new Date();
        var datestring = ("0" + (date.getMonth() + 1).toString()).substr(-2) + "/" + ("0" + date.getDate().toString()).substr(-2)  + "/" + (date.getFullYear().toString());
        $('#calendar2').prop('value',datestring);
        $('#calendar3').prop('value',datestring);
    }
    
    if(parentID == 'DF'){
        $('#store').html("");
        $('#dailyfiguredetail').html("");
        $("#dailyfigurediv").hide();
    }
    
    if (parentID == 'A') {
        var elems = document.getElementsByClassName('AccessGroup');
        var elemsLength = elems.length;
        var i = 0;
        for (i = 0; i < elemsLength; i++) {
            if (!$("#" + elems[i].id).is(':checked')) {

            } else {
                $("#" + elems[i].id).click();
            }
        }

        $('#fieldAgentGeneralHeritageDetail').html("");
        $("#detaillimits2").hide();
        $("#fieldAgentDetailLimitsHeritage").hide();
        $("#fieldAgentGeneralHeritageDetail").hide();
    
    }
    if (parentID == 'PL') {
        $("#inicio").prop("value", 1);
    }

    if (parentID == 'pp') {
        selectItemByValue(document.getElementById('zero'), '2');       
        selectItemByValue(document.getElementById('store2'), 'ALINE');
    }

    if (parentID == 'PL') {
        $("#playerlistdetail").html("");
    }

    if (parentID == 'AL') {
        $("#agentlistdetail").html("");
    }

    if (parentID == 'D' || parentID == 'T' || parentID == 'B' || parentID == 'P' || parentID == 'G') {
        cierra();
    }
    $("#store2").val("");
    $("#store3").val("");
    $("#store").combobox();
    $("#store").combobox("destroy");
    $("#store").combobox();
    $("#store").val("Select valid Customer");
    $("#account").html("");
    $("#passwordID").html("");
    $("#playerlistdetail").html("");

    bloquear();

    $("#ckLive_Betting").checkbox({
        checked: false
    });
    $("#ckPregame").checkbox({
        checked: false
    });
    $("#ckCasino").checkbox({
        checked: false
    });

    $(".limpiarcontect").html("");
    closediv('divWagersDaily');
    closediv('detalle_transaccion');

    $('#freee').html("");
    $('#normal').html("");
}

function getMessage(msgType, concatValue) {
    switch (msgType) {
        case 'NOROWS':
            var msg = getTextJs['admin_general_NOROWS'];
        break;
        case 'SAVE_LIMITS':
            var msg = getTextJs['admin_general_SAVE_LIMITS'] + concatValue + "' !!";
            break;
        case 'SAVE_TRANSACTION':
            var msg = getTextJs['admin_general_SAVE_TRANSACTION'];
            break;
        case 'SAVE_NEW_ACCOUNT':
        case 'SAVEPLAYERLIST':
        case 'SAVE':
            var msg = getTextJs['admin_general_SAVE_NEW_ACCOUNT'];
            break;
        case 'BADSAVE':
            var msg = getTextJs['admin_general_BADSAVE']; 
            break;
        case 'DELETED':
            var msg = getTextJs['admin_general_DELETED']; 
            break;
         case 'NO_DELETED':
            var msg = getTextJs['admin_general_NO_DELETED']; 
            break;
        case 'DELETED_TRANSACTION':
            var msg = getTextJs['admin_general_DELETED_TRANSACTION'] + concatValue + "' ?";
            break;
        case 'DELETED_WAGER':
            var msg = getTextJs['admin_general_DELETED_WAGER'] + concatValue + "' Wager?";
            break;
        case 'REDFIGURE':
            var msg = getTextJs['admin_general_REDFIGURE']; 
            break;
        case 'INHERITMASTER':
            var msg = getTextJs['admin_general_INHERITMASTER'];
            break;
        case 'INHERITOTHER':
            var msg = getTextJs['admin_general_INHERITOTHER']; 
            break;
        case 'EXTERNAL_LINK_URL':
            var msg = getTextJs['admin_general_EXTERNAL_LINK_URL']; 
            break;
        case 'PERMISSION_DENI':
            var msg = getTextJs['admin_general_PERMISSION_DENI']; 
            break;
        case 'VALID_CUSTOMER':
            var msg = getTextJs['admin_general_VALID_CUSTOMER']; 
            break;
        case 'CHANGE_TAB_OR_CUSTOMER':
        case 'CHANGE_TAB_OR_CUSTOMER_PER':
            var msg = getTextJs['admin_general_CHANGE_TAB_OR_CUSTOMER']; 
            break;
        case 'CREATE_ACCOUNT':
            var msg = getTextJs['admin_general_CREATE_ACCOUNT']; 
            break;
        case 'INHERIT_PACKAGE_PER':
        case 'INHERIT_PACKAGE':
            var msg = getTextJs['admin_general_INHERIT_PACKAGE_PER']; 
            break;
        case 'INHERIT_LIMITS':
            var msg = getTextJs['admin_general_INHERIT_LIMITS']; 
            break;
        case 'FREE_HALF_PTS':
            var msg = getTextJs['admin_general_FREE_HALF_PTS']; 
            break;
        case 'MISSING_TRANSACTION':
            var msg = getTextJs['admin_general_MISSING_TRANSACTION']; 
            break;
        case 'NEW_PACKAGE':
            var msg = getTextJs['admin_general_NEW_PACKAGE']; 
            break;
        case 'INVALID_ACCOUNT':
            var msg = concatValue + getTextJs['admin_general_INVALID_ACCOUNT']; 
            break;
        case 'SUCCESSFUL_VERI':
            var msg = getTextJs['admin_general_SUCCESSFUL_VERI']; 
            break;
        case 'CANCELL_BUTTON':
            var msg = getTextJs['admin_general_CANCELL_BUTTON']; 
            break;
        case 'EXPIRATION_DATE':
            var msg = getTextJs['admin_general_EXPIRATION_DATE']; 
            break;
        case 'VALID_PARLAY':
            var msg = getTextJs['admin_general_VALID_PARLAY']; 
            break;
        case 'VALIDATE_TEASER':
            var msg = getTextJs['admin_general_VALIDATE_TEASER'];
            break;
        case 'EDIT_TRANSACTION':
            var msg = getTextJs['admin_general_EDIT_TRANSACTION']; 
            break;
        case 'INVALIDTRANSACTION':
            var msg = getTextJs['admin_general_INVALIDTRANSACTION']; 
            break;
        case 'DAILYFIGUREDATEISREQUIRED':
            var msg = getTextJs['admin_general_DAILYFIGUREDATEISREQUIRED']; 
            break;
        case 'EMPTY_DATA':
            var msg = getTextJs['admin_general_EMPTY_DATA']; 
            break;
        case 'CONFIRM_DELETED_TRANSACTION':
            var msg = getTextJs['admin_general_CONFIRM_DELETED_TRANSACTION'] + concatValue + "' ?";
            break;
         case 'DELETE_NOTE':
            var msg = getTextJs['admin_general_DELETE_NOTE']; 
            break;
        default:
            var msg = getTextJs['admin_general_DEFAULT'];
    }
    return msg;
}

function closediv(id) {
    $("#" + id).hide();
}

function validate2(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46 && charCode != 44) { //&& charCode != 46
        return false;
    }
    return true;
}

function selectItemByValue(elmnt, value) {
    if (elmnt == null) {
        return;
    }
    for (var i = 0; i < elmnt.options.length; i++) {
        if ((elmnt.options[i].value) == (value)) {
            elmnt.selectedIndex = i;
            break;
        }
    }
}


/**
 * validation Navigation Link
 * 
 * @param   {string} continu if the user confirms the modification not
 * @param   {string} link 
 * 
 */
function validaNavText(continu,link){
    if (continu == "Y" && link != "#"){
        if (link.indexOf('http://') == -1) {
            var url = $('#baseurl').val() + link;
            window.location = url;  
        }
        else{
            window.location = link;  
        }
    }  
}

/**
 * validation Navigation
 * 
 * @param   {int} isChange if is save change before exiting.
 * @param   {string} dir: direction
 * 
 */
function validaNav(isChange, dir) {
    
    var result = false;
    var time = 0;
    if (isChange == 1) {
        var msgDesc = getTextJs['admin_general_ChangesInThisAccountHaveBeenFoundWithoutSaving'];
        var buttons = ""; 
        buttons+="<button id=\"confirmationModalButton\" name=\"confirmationModalButton\" onclick=\"$('#confirmationModal').modal('toggle');validaNavText('Y','"+dir+"');\" type=\"button\" class=\"btn btn-success\">";
        buttons+="Yes";
        buttons+="</button>";                       
        buttons+="<button id=\"confirmationModalButton2\" name=\"confirmationModalButton2\" \n\
                    onclick=\"$('#confirmationModal').modal('toggle');\" type=\"button\" class=\"btn btn-success\">";
        buttons+="NO";
        buttons+="</button>";
        modalMessages(msgDesc,'',buttons);                                                  
    }
    else{ 
        if (dir != "#")
            window.location = $('#baseurl').val() + dir;
    }
}

function validate(evt) {

    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57)) { //&& charCode != 46
        return false;
    }
    return true;
}

function validateKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57)  && charCode != 42 && charCode != 43 && charCode != 45 && charCode != 47) { //&& charCode != 46
        return false;
    }
    return true;

}

function callbloquear() {
    var pressEdit = $('#pressedEdit').val();
    if (pressEdit == "N") {
        bloquear();
    }
}

function showMessage(msgType, herencia, user, arr1, arr2) {
    switch (msgType) {
        case 'NOROWS':
            var msgDesc = getMessage(msgType, '');
            var buttons = "";  
            buttons+="<button id=\"confirmationModalButton\" name=\"confirmationModalButton\" onclick=\"$('#confirmationModal').modal('toggle');\" type=\"button\" class=\"btn btn-success\">";
                    buttons+="OK";
            buttons+="</button>";             
            modalMessages(msgDesc,'',buttons);
            break;
        case 'INVALIDTRANSACTION':

            var msgDesc = getMessage(msgType, '');
            var buttons = "";  
            buttons+="<button id=\"confirmationModalButton\" name=\"confirmationModalButton\" onclick=\"$('#confirmationModal').modal('toggle');\" type=\"button\" class=\"btn btn-success\">";
                    buttons+="OK";
            buttons+="</button>";                       
            modalMessages(msgDesc,'',buttons);
            
            break;
        case 'DAILYFIGUREDATEISREQUIRED':
            var msgDesc = getMessage(msgType, '');
            var buttons = "";  
            buttons+="<button id=\"confirmationModalButton\" name=\"confirmationModalButton\" onclick=\"$('#confirmationModal').modal('toggle');\" type=\"button\" class=\"btn btn-success\">";
                    buttons+="OK";
            buttons+="</button>";                       
            modalMessages(msgDesc,'',buttons);
            break;
        case 'EDIT_TRANSACTION':
            var msgDesc = getMessage(msgType, '');
            var buttons = "";  
            buttons+="<button id=\"confirmationModalButton\" name=\"confirmationModalButton\" onclick=\"$('#confirmationModal').modal('toggle');\" type=\"button\" class=\"btn btn-success\">";
                    buttons+="OK";
            buttons+="</button>";                       
            modalMessages(msgDesc,'',buttons);
            
            break;
        case 'VALIDATE_TEASER':
            var msgDesc = getMessage(msgType, arr1);
            var buttons = "";  
            buttons+="<button id=\"confirmationModalButton\" name=\"confirmationModalButton\" onclick=\"$('#confirmationModal').modal('toggle');$('#globalcustomer').focus();\" type=\"button\" class=\"btn btn-success\">";
                    buttons+="OK";
            buttons+="</button>";                       
            modalMessages(msgDesc,'',buttons);
           
            break;
        case 'SAVE_LIMITS':
            
            var msgDesc = getMessage(msgType, arr1);
            
            $("<div><p>" + msgDesc + "</p></div>").dialog({
                position: {
                    my: 'top',
                    at: 'top+300'
                },
                title: "Done!!",
                resizable: false,
                height: 200,
                width: 300,
                modal: true,
                draggable: false,
                buttons: {
                    "Ok": function() {
                        $(this).dialog("close");                        
                        cargaParlayList($('#cuenta').val(), url);                        
                    }
                }
            });
            break;
        case 'VALID_PARLAY':
            var msgDesc = getMessage(msgType, '');
            var buttons = "";  
            buttons+="<button id=\"confirmationModalButton\" name=\"confirmationModalButton\" onclick=\"$('#confirmationModal').modal('toggle');\" type=\"button\" class=\"btn btn-success\">";
                    buttons+="OK";
            buttons+="</button>";                       
            modalMessages(msgDesc,'',buttons);
           
            break;
        case 'EXPIRATION_DATE':
            var msgDesc = getMessage(msgType, '');
            var buttons = "";  
            buttons+="<button id=\"confirmationModalButton\" name=\"confirmationModalButton\" onclick=\"$('#confirmationModal').modal('toggle');\" type=\"button\" class=\"btn btn-success\">";
                    buttons+="OK";
            buttons+="</button>";                       
            modalMessages(msgDesc,'',buttons);
            
            break;
        case 'CANCELL_BUTTON':
            var msgDesc = getMessage(msgType, '');
            var continuar = "N";

            $("<div><p>" + msgDesc + "</p></div>").dialog({
                position: {
                    my: 'top',
                    at: 'top+150'
                },
                title: "Confirmation!!",
                resizable: false,
                height: 230,
                width: 300,
                modal: true,
                draggable: false,

                buttons: {
                    "Yes": function() {
                        continuar = "Y";
                        $(this).dialog("close");
                    },

                    Cancel: function() {
                        continuar = "N";
                        $(this).dialog("close");
                    }
                },
                close: function() {
                    if (continuar == "Y") {
                        getinfo();
                    }
                }
            });
            break;
        case 'NEW_PACKAGE':
            var msgDesc = getMessage(msgType, '');
            var continuar = "N";
            var opcion = 0;

            $("<div><p>" + msgDesc + "</p></div>").dialog({
                position: {
                    my: 'top',
                    at: 'top+150'
                },
                title: "Confirmation!!",
                resizable: false,
                height: 170,
                width: 340,
                modal: true,
                draggable: false,

                buttons: {
                    "New Pack": function() {
                        continuar = "Y";
                        opcion = 1;
                        $(this).dialog("close");
                    },

                    "Assign Pack": function() {
                        continuar = "Y";
                        opcion = 2;
                        $(this).dialog("close");
                    },

                    Cancel: function() {
                        continuar = "N";
                        $(this).dialog("close");
                    }
                },
                close: function() {
                    if (continuar == "Y") {
                        createNewAccount(arr1, url, opcion);
                    }
                }
            });


            break;
        case 'MISSING_TRANSACTION':
            var msgDesc = getMessage(msgType, '');
            var buttons = "";  
            buttons+="<button id=\"confirmationModalButton\" name=\"confirmationModalButton\" onclick=\"$('#confirmationModal').modal('toggle');\" type=\"button\" class=\"btn btn-success\">";
                    buttons+="OK";
            buttons+="</button>";                       
            modalMessages(msgDesc,'',buttons);
            
            break;
        case 'FREE_HALF_PTS':
            var msgDesc = getMessage(msgType, '');
            var buttons = "";  
            buttons+="<button id=\"confirmationModalButton\" name=\"confirmationModalButton\" onclick=\"$('#confirmationModal').modal('toggle');$('#upto5').focus();\" type=\"button\" class=\"btn btn-success\">";
                    buttons+="SET AMOUNT";
            buttons+="</button>";                       
            buttons+="<button id=\"confirmationModalButton2\" name=\"confirmationModalButton2\" onclick=\"$('#confirmationModal').modal('toggle');$('#freeintetbk').prop('checked', false);$('#frehalfpfb').prop('checked', false);$('#freephonebk').prop('checked', false);$('#freintefb').prop('checked', false);\" type=\"button\" class=\"btn btn-success\">";
                    buttons+="WITHOUT FREE HALVES";
            buttons+="</button>";                       
            
            modalMessages(msgDesc,'',buttons);           

            break;
        case 'INHERIT_LIMITS':
            var continuar = "N";
            var msgDesc = getMessage(msgType, '');
            var buttons = "";  
            buttons+="<button id=\"confirmationModalButton\" name=\"confirmationModalButton\" onclick=\"$('#confirmationModal').modal('toggle');executeHerenciaLimitesType("+url+","+user+","+arr1+","+herencia+");\" type=\"button\" class=\"btn btn-success\">";
                    buttons+="Yes";
            buttons+="</button>";                       
            buttons+="<button id=\"confirmationModalButton2\" name=\"confirmationModalButton2\" onclick=\"$('#confirmationModal').modal('toggle');\" type=\"button\" class=\"btn btn-success\">";
                    buttons+="Cancel";
            buttons+="</button>"; 
            modalMessages(msgDesc,'',buttons);

            break;
        case 'INHERIT_PACKAGE':
            var continuar = "N";
            var opcion = "";
            var msgDesc = getMessage(msgType, '');

            $("<div><p>" + msgDesc + "</p></div>").dialog({
                position: {
                    my: 'top',
                    at: 'top+150'
                },
                title: "Confirmation!!",
                resizable: false,
                height: 230,
                width: 300,
                modal: true,
                draggable: false,

                buttons: {
                    "Yes": function() {
                        continuar = "Y";
                        opcion = "Y";
                        $(this).dialog("close");
                    },
                    "NO": function() {
                        continuar = "N";
                        opcion = "N";
                        $(this).dialog("close");
                    },

                },
                close: function() {
                    if (continuar == "Y") {
                        var herenciaLive = sendLiveHierarchy(4);
                    }
                }
            });

            break;
        case 'INHERIT_PACKAGE_PER':
            var continuar = "N";
            var opcion = "";
            var msgDesc = getMessage(msgType, '');

            $("<div><p>" + msgDesc + "</p></div>").dialog({
                position: {
                    my: 'top',
                    at: 'top+150'
                },
                title: "Confirmation!!",
                resizable: false,
                height: 230,
                width: 300,
                modal: true,
                draggable: false,
                buttons: {
                    "No": function() {
                        $(this).dialog("close");
                    },
                    "Yes": function() {
                        var parametros = {
                            user: $('#account').html(),
                            padre: $('#agent_drop').prop('value')
                        };

                        $.ajax({
                            type: "POST",
                            url: "action/herenciacambio.php",
                            cache: false,
                            async: false,
                            data: parametros,
                            success: function(data) {

                                call_vefic_limpiar();

                            }
                        });
                        $(this).dialog("close");
                    }
                }
            });

            break;
        case 'CREATE_ACCOUNT':
            var continuar = "N";
            var msgDesc = getMessage(msgType, '');

            $("<div><p>" + msgDesc + "</p></div>").dialog({
                position: {
                    my: 'top',
                    at: 'top+150'
                },
                title: "Confirmation!!",
                resizable: false,
                height: 220,
                width: 300,
                modal: true,
                draggable: false,

                buttons: {
                    "Yes": function() {
                        continuar = "Y";
                        $(this).dialog("close");
                    },

                    Cancel: function() {
                        continuar = "N";
                        $(this).dialog("close");
                    }
                },
                close: function() {
                    if (continuar == "Y") {
                        verificaPaqueteNuevo(url, arr1);
                    }
                }
            });


            break;
        case 'CHANGE_TAB_OR_CUSTOMER':
            var continuar = "N";
            var msgDesc = getMessage(msgType, '');            
            var buttons = ""; 
            buttons+="<button id=\"confirmationModalButton\" name=\"confirmationModalButton\" onclick=\"$('#confirmationModal').modal('toggle');\" type=\"button\" class=\"btn btn-success\">";
                    buttons+="Yes";
            buttons+="</button>";                       
             buttons+="<button id=\"confirmationModalButton2\" name=\"confirmationModalButton2\" \n\
                        onclick=\"$('#confirmationModal').modal('toggle');$('#" + arr2.id + "').val('" + arr2.value + "');\" type=\"button\" class=\"btn btn-success\">";
                    buttons+="NO";
            buttons+="</button>";
            modalMessages(msgDesc,'',buttons);           

            break;

        case 'BADSAVE':
        case 'SAVE':
            
            var msgDesc = getMessage(msgType, '');
            
            if (arr1 != "") {
                msgDesc += "<br/>" + arr1;
            }
            
            var result = "";
            
            var buttons = "";                              
            buttons+="<button id=\"confirmationModalButton\" name=\"confirmationModalButton\" onclick=\"$('#confirmationModal').modal('toggle');\" type=\"button\" class=\"btn btn-success\">";
                    buttons+="OK";
            buttons+="</button>";                    
            modalMessages(msgDesc,'',buttons);
                                                     
            break;
         case 'SAVEPLAYERLIST':
            
            var msgDesc = getMessage(msgType, '');
            var result = "";
            var buttons = "";                                                
            modalMessages(msgDesc,'',buttons);
                                                     
            break;
        case 'SAVE_NEW_ACCOUNT':
            var msgDesc = getMessage(msgType, '');
            
            var buttons = "";                              
            buttons+="<button id=\"confirmationModalButton\" name=\"confirmationModalButton\" onclick=\"$('#confirmationModal').modal('toggle');\" type=\"button\" class=\"btn btn-success\">";
                    buttons+="OK";
            buttons+="</button>";                    
            modalMessages(msgDesc,'',buttons);
            
            break;
        case 'SAVE_TRANSACTION':
            var msgDesc = getMessage(msgType, '');
            var buttons = "";                              
            buttons+="<button id=\"confirmationModalButton\" name=\"confirmationModalButton\" onclick=\"$('#confirmationModal').modal('toggle');\" type=\"button\" class=\"btn btn-success\">";
                    buttons+="OK";
            buttons+="</button>";             
            modalMessages(msgDesc,'',buttons);
            
            break;
        case 'DELETED':
            var msgDesc = getMessage(msgType, '');
            var buttons = "";                              
            buttons+="<button id=\"confirmationModalButton\" name=\"confirmationModalButton\" onclick=\"$('#confirmationModal').modal('toggle');\" type=\"button\" class=\"btn btn-success\">";
                    buttons+="OK";
            buttons+="</button>";             
            modalMessages(msgDesc,'',buttons);
            break;
        
        case 'NO_DELETED':
            var msgDesc = getMessage(msgType, '');
            var buttons = "";                              
            buttons+="<button id=\"confirmationModalButton\" name=\"confirmationModalButton\" onclick=\"$('#confirmationModal').modal('toggle');\" type=\"button\" class=\"btn btn-success\">";
                    buttons+="OK";
            buttons+="</button>";             
            modalMessages(msgDesc,'',buttons);
            break;
        
        case 'CONFIRM_DELETED_TRANSACTION':
            var msgDesc = getMessage(msgType, arr1);
            var continuar = "N";
            
            var buttons = "";  
            buttons+="<button id=\"confirmationModalButton\" name=\"confirmationModalButton\" onclick=\"$('#confirmationModal').modal('toggle');delete_transaction("+ arr1 +");\" type=\"button\" class=\"btn btn-success\">";
                    buttons+="Yes";
            buttons+="</button>";
            buttons+="<button id=\"confirmationModalButton2\" name=\"confirmationModalButton\" onclick=\"$('#confirmationModal').modal('toggle');\" type=\"button\" class=\"btn btn-success\">";
                    buttons+="Cancel";
            buttons+="</button>";             
            modalMessages(msgDesc,'',buttons);
            
            break;
        case 'DELETED_TRANSACTION':
            var msgDesc = getMessage(msgType, arr1);
            var buttons = "";  
            buttons+="<button id=\"confirmationModalButton\" name=\"confirmationModalButton\" onclick=\"$('#confirmationModal').modal('toggle');delete_transaction("+ arr1 +");\" type=\"button\" class=\"btn btn-success\">";
                    buttons+="Yes";
            buttons+="</button>";
            buttons+="<button id=\"confirmationModalButton2\" name=\"confirmationModalButton\" onclick=\"$('#confirmationModal').modal('toggle');\" type=\"button\" class=\"btn btn-success\">";
                    buttons+="No";
            buttons+="</button>";             
            modalMessages(msgDesc,'',buttons);
            break;
        case 'DELETED_WAGER':

            var msgDesc = getMessage(msgType, user);
            var CustomerID = herencia;
            var ticketNumber = user;
            var wagerNumber = arr1;

            $("<div><p>" + msgDesc + "</p></div>").dialog({
                position: {
                    my: 'top',
                    at: 'top+150'
                },
                title: "Confirmation!!",
                resizable: false,
                height: 200,
                width: 300,
                modal: true,
                draggable: false,

                buttons: {
                    "Yes": function() {
                        continuar = "Y";
                        $(this).dialog("close");
                    },
                    "No": function() {
                        continuar = "N";
                        $(this).dialog("close");                           
                    }
                },
                close: function() {
                    if (continuar == "Y") {
                        var url = $('#baseurl').val() + "Wagers/deleteWager";
                        var parametros = {
                            txtTicketNumber: ticketNumber,
                            txtWagerNumber: wagerNumber,
                            txtIdCustomer: CustomerID
                        };
                        $.ajax({
                            type: "POST",
                            url: url,
                            dataType: "json",
                            data: parametros,
                            success: function(data) {
                                if (isIsset(data)) {
                                    showMessage('DELETED','','','');
                                }
                                else{
                                    showMessage('NO_DELETED','','','');
                                }
                            }
                        });

                        $('#trWagersTicket_' + ticketNumber + '_' + wagerNumber).remove();
                        $('#divWagers').hide();
                        closediv('detalle_transaccion');
                        show_wagersPerformance(ticketNumber);
                    }
                }
            });
            break;
        case 'REDFIGURE':
            var msgDesc = getMessage(msgType, '');
            var buttons = "";                              
            buttons+="<button id=\"confirmationModalButton\" name=\"confirmationModalButton\" onclick=\"$('#confirmationModal').modal('toggle');$('#AgentComission').focus();\" type=\"button\" class=\"btn btn-success\">";
                    buttons+="OK";
            buttons+="</button>";                    
            modalMessages(msgDesc,'',buttons);
            
            break;
        case 'INHERITMASTER':
            var msgDesc = getMessage(msgType, '');
            var continuar = "N";
            var tipoHerencia = 0;

            $("<div><p>" + msgDesc + "</p></div>").dialog({
                position: {
                    my: 'top',
                    at: 'top+150'
                },
                title: "Confirmation!!",
                resizable: false,
                height: 200,
                width: 380,
                modal: true,
                draggable: false,

                buttons: {
                    "All": function() {
                        tipoHerencia = 1;
                        continuar = "Y";
                        $(this).dialog("close");
                    },
                    "Players": function() {
                        tipoHerencia = 2;
                        continuar = "Y";
                        $(this).dialog("close");
                    },
                    "Agents": function() {
                        tipoHerencia = 3;
                        continuar = "Y";
                        $(this).dialog("close");
                    },
                    Cancel: function() {
                        continuar = "N";
                        $(this).dialog("close");
                    }
                },
                close: function() {
                    if (continuar == "Y") {
                        if (herencia == 1) {
                            var herenciaLive = sendLiveHierarchy(tipoHerencia);
                            sendGeneralHierarchy(tipoHerencia, user, arr1, herenciaLive);
                        }
                        if (herencia == 2) {
                            setDetaillimitInheritance(tipoHerencia, user, arr1);
                        }
                    }
                }
            });

            break;
        case 'INHERITOTHER':
            var msgDesc = getMessage(msgType, '');
            var buttons = "";                              
            buttons+="<button id=\"confirmationModalButton\" name=\"confirmationModalButton\" onclick=\"$('#confirmationModal').modal('toggle');InheritOther('Y',2,"+ herencia +","+ user + "," + arr1 + ");\" type=\"button\" class=\"btn btn-success\">";
                    buttons+="Players";
            buttons+="</button>";                    
            buttons+="<button id=\"confirmationModalButton\" name=\"confirmationModalButton\" onclick=\"$('#confirmationModal').modal('toggle');\" type=\"button\" class=\"btn btn-success\">";
                    buttons+="Cancel";
            buttons+="</button>";
            modalMessages(msgDesc,'',buttons);  
            break;
        case 'EXTERNAL_LINK_URL':
            var msgDesc = getMessage(msgType, '');
            var buttons = "";                              
            buttons+="<button id=\"confirmationModalButton\" name=\"confirmationModalButton\" onclick=\"$('#confirmationModal').modal('toggle');\" type=\"button\" class=\"btn btn-success\">";
                    buttons+="OK";
            buttons+="</button>";                    
            modalMessages(msgDesc,'',buttons);
            
            break;
        case 'PERMISSION_DENI':
            var msgDesc = getMessage(msgType, '');
            var buttons = "";                              
            buttons+="<button id=\"confirmationModalButton\" name=\"confirmationModalButton\" onclick=\"$('#confirmationModal').modal('toggle');$('#fieldAgentGeneralHeritageDetail').fadeOut('fast');\" type=\"button\" class=\"btn btn-success\">";
                    buttons+="OK";
            buttons+="</button>";                    
            modalMessages(msgDesc,'',buttons);
            
            break;
        case 'VALID_CUSTOMER':
            var msgDesc = getMessage(msgType, '');
            var buttons = "";                              
            buttons+="<button id=\"confirmationModalButton\" name=\"confirmationModalButton\" onclick=\"$('#confirmationModal').modal('toggle');$('#globalcustomer').focus();\" type=\"button\" class=\"btn btn-success\">";
                    buttons+="OK";
            buttons+="</button>";                    
            modalMessages(msgDesc,'',buttons);            
            break;
        case 'EMPTY_DATA':

            var msgDesc = getMessage(msgType, '');
            var buttons = "";                              
            buttons+="<button id=\"confirmationModalButton\" name=\"confirmationModalButton\" onclick=\"$('#confirmationModal').modal('toggle');\" type=\"button\" class=\"btn btn-success\">";
            buttons+="OK";
            buttons+="</button>";                    
            modalMessages(msgDesc,'',buttons);            
            break;
        
        case 'DELETE_NOTE':
            var msgDesc = getMessage(msgType, '');
            var continuar = false;
            var tipoHerencia = 0;

            $("<div><p>" + msgDesc + "</p></div>").dialog({
                position: {
                    my: 'top',
                    at: 'top+150'
                },
                title: "Confirmation!",
                resizable: false,
                height: 200,
                width: 380,
                modal: true,
                draggable: false,

                buttons: {
                    "Ok": function() {
                        tipoHerencia = 1;
                        continuar = true;
                        $(this).dialog("close");
                    },
                    Cancel: function() {
                        continuar = "N";
                        $(this).dialog("close");
                    }
                },
                close: function() {
                    if (continuar == true) {
                        deleteNote(arr1);
                    }
                }
            });

            break;
    }
}



function bloquear() {
    $(".bloquear").each(function() {
        if (!$(this).is(':disabled')) {
             $(this).prop("disabled", false);
        }
    });
    $("#pressedEdit").val("N");
}

function activador() {
    $(".bloquear").each(function() {
        if (!$(this).hasClass("restric")) {
             $(this).prop("disabled", false);
        }
    });
    $("#pressedEdit").val("Y");
}

function validasalida(origin, obj) {
    if ($('#saveChangesBefore').val() == "0" || $('#saveChangesBefore').val() == "") {
        return true;
    }
    else{
        if ($("#pressedEdit").val() == "Y") {
            showMessage('CHANGE_TAB_OR_CUSTOMER', '', '', origin, obj);
            return false;
        } else {
            return true;
        }   
    }
}

function cancel() {
    showMessage('CANCELL_BUTTON', '', '', '');
}

/*
 * Cerrar todos los info de un reporte en responsive
 *
 */
function detailsReportsClose(){
    $.ajax({
        type: "POST",
        async: true,
        beforeSend: function(){
            $("#reports .overlay").height($(window).height());
            $("#reports .overlay").width($("#reports").width());
            $("#reports .overlay").css("display", "block");
        },
        complete: function(){
            $("#reports .overlay").css("display", "none");
        },
        success: function() {            
            var showData = $('.responsive-data .show-data');
            
            //showData.switchClass('show-data', 'hide-data');
            showData.removeClass('show-data').addClass('hide-data');
            var glyphicon = $(".responsive-data a .glyphicon");
            
            if(glyphicon.hasClass('glyphicon-minus-sign')){
                glyphicon.switchClass('glyphicon-minus-sign','glyphicon-plus-sign');
            }
            $('#btnDetailsClose').hide();
            $('#btnDetailsOpen').show();
        }
    });
}

/*
 * Abrir todos los info de un reporte en responsive
 *
 */
function detailsReportsOpen(nameElement){
    $.ajax({
        type: "POST",
        async: true,
        beforeSend: function(){
            $("#reports .overlay").height($(window).height());
            $("#reports .overlay").width($("#reports").width());
            $("#reports .overlay").css("display", "block");
        },
        complete: function(){
            $("#reports .overlay").css("display", "none");
        },
        success: function() {            
            var lnk = $('.'+nameElement);
            lnk.trigger("click");

            $('#btnDetailsOpen').hide(); $('#btnDetailsClose').show();     
        }
    });
}

/*
 * switch class hideData in Reports
 */
function switchClassHideData(object){
	if (object.hasClass('hide-data')) {
		object.removeClass('hide-data');
        object.addClass('show-data');
	}else{
        object.removeClass('show-data');
		object.addClass('hide-data');
	}
}
/*
 * Switch el boton que permite cerrar/abrir los info de los reportes en responsive
 */
function switchBtnOpenCloseAll(){
    var showData = $('tr.show-data');
    if( showData[0] == undefined){
        $('#btnDetailsOpen').show();
        $('#btnDetailsClose').hide();
    }else{
         $('#btnDetailsOpen').hide();
        $('#btnDetailsClose').show();
    }
}

/*
 *  switch icon glyphicon in Reports
 */
function switchGlyphicon(object){
	if(object.hasClass('glyphicon-plus-sign')){
		object.switchClass('glyphicon-plus-sign','glyphicon-minus-sign');
	}
	else{
		object.switchClass('glyphicon-minus-sign','glyphicon-plus-sign');
	}

}
///////////////////////////////

/**
 * Open Modal New Account
 * 
 */
function openNewAccountModal() {
    // open modal
    $("#chooseTypeNewAccountModal").modal("toggle");
}

/**
 * validation New Account
 * 
 * @param   {Array} data new account
 * @param   {string} type new account
 * 
 * @returns {Type} Description
 */
function validationNewAccount(data, type){
    if (type=='P') {
        //Player
        if (isIsset(data['password']) &&
            isIsset(data['creditLimit']) &&
            isIsset(data['betQuickLimit']) &&
            isIsset(data['agent'])) {
            if ($.isNumeric(data['creditLimit']) &&
                $.isNumeric(data['betQuickLimit'])) {
                return true;
            }
        }
        return false;
    }else{
        //Agent
        if (isIsset(data['subagent']) &&
            isIsset(data['password']) &&
            isIsset(data['commission'])) {
            if ($.isNumeric(data['commission'])){
                 return true;
            }
        }
        return false;
    }
}
/**
 * send Request New Account
 * 
 * @param   {string} dataRequest 
 * @param   {string} type     
 * 
 */
function sendRequestNewAccount(dataRequest, type){
     $.ajax({
        url: $('#baseurl').val()+"Personal/sendMailRequestNewAccount",
        type: 'POST',
        dataType: "json",
        data: {
            'type': type,
            'dataReq': JSON.stringify(dataRequest)
        },
        success: function(data) {
            if (data == 0) {
                var message = 'Request sent with success';
                $("#newAccountPlayerModal").modal("hide");
                $("#newAccountAgentModal").modal("hide");
                //showMessage('SAVE_NEW_ACCOUNT', '', '', '');
                alert(message);
            }
            else{
                var message = 'Request unsent';
                //showMessage('BAD_SAVE', '', '', '');
                alert(message);
            }
        },
        error : function(result, statut, error){
           console.log(error)
        }
    });
}

/*************************************************************************************/
$(document).ready(function() {
    
    var optsSpinner = {
      color: '#000' // #rgb or #rrggbb or array of colors
      , zIndex: 2e9 // The z-index (defaults to 2000000000)
      , className: 'spinner' // The CSS class to assign to the spinner
      , top: '50%' // Top position relative to parent
      , left: '50%' // Left position relative to parent
      , shadow: true // Whether to render a shadow
      , hwaccel: true // Whether to use hardware acceleration
      , position: 'fixed' // Element positioning
      }
    
    var spinner = new Spinner(optsSpinner).spin();
    $('#loading-games').append(spinner.el);
    
    var serverurl;
    var path = window.location.pathname;
    path = path.replace("index.php", "");

    serverurl = location.protocol + '//' + document.domain + (location.port ? ':' + location.port : '') + $('#baseurl').val();
    
    document.onkeydown = suppressBackspace;
    document.onkeypress = suppressBackspace;
    var testTextBox = $('#globalcustomer');
    var code = null;
    
    
    //Validation Navigation
    $('.validationNav').unbind('click');
    $('.validationNav').bind('click', function(e){
        e.preventDefault();
        var link = $(this).attr('href');
        if ($('#saveChangesBefore').val() == 1) {
            var msgDesc = "Changes in this account have been found without saving. Do you want to continue?";
            var buttons = ""; 
            buttons+="<button id=\"confirmationModalButton\" name=\"confirmationModalButton\" onclick=\"$('#confirmationModal').modal('toggle');validaNavText('Y','"+link+"');\" type=\"button\" class=\"btn btn-success\">";
            buttons+="Yes";
            buttons+="</button>";                       
            buttons+="<button id=\"confirmationModalButton2\" name=\"confirmationModalButton2\" \n\
                        onclick=\"$('#confirmationModal').modal('toggle');\" type=\"button\" class=\"btn btn-success\">";
            buttons+="NO";
            buttons+="</button>";
            modalMessages(msgDesc,'',buttons);    
        }
        else{
            $(location).attr('href',link);
        }
        
    });
    

    $("#createNewAccountAssign").modal("hide");
    $("#createNewAccountNew").modal("hide");

    $(".datepiker").datepicker();

    $('input[type="checkbox"].style3').checkbox({
        buttonStyle: 'btn-success',
        buttonStyleChecked: 'btn-danger',
        checkedClass: 'icon-check',
        uncheckedClass: 'icon-check-empty',
        defaultState: false
    });

    $('input[type="checkbox"].style4').checkbox({
        buttonStyle: 'btn-info',
        buttonStyleChecked: 'btn-primary',
        checkedClass: 'icon-check',
        uncheckedClass: 'icon-check-empty',
        defaultState: false
    });

    (function($) {
        $.widget("custom.combobox", {
            _create: function() {
                this.wrapper = $("<span>")
                    .addClass("custom-combobox")
                    .insertAfter(this.element);

                this.element.hide();
                this._createAutocomplete();
                this._createShowAllButton();
            },

            _createAutocomplete: function() {
                var selected = this.element.children(":selected"),
                    value = selected.val() ? selected.text() : "";

                this.input = $('<input id="store3">')
                    .appendTo(this.wrapper)
                    .val(value)
                    .attr("title", "")
                    .addClass("custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left")
                    .autocomplete({
                        delay: 0,
                        minLength: 0,
                        source: $.proxy(this, "_source")
                    })
                    .tooltip({
                        tooltipClass: "ui-state-highlight"
                    });

                this._on(this.input, {
                    autocompleteselect: function(event, ui) {
                        ui.item.option.selected = true;
                        this._trigger("select", event, {
                            item: ui.item.option
                        });
                    },

                    autocompletechange: "_removeIfInvalid"
                });
            },

            _createShowAllButton: function() {
                var input = this.input,
                    wasOpen = false;

                $("<a>")
                    .attr("tabIndex", -1)
                    .attr("title", "Show All Items")
                    .tooltip()
                    .appendTo(this.wrapper)
                    .button({
                        icons: {
                            primary: "ui-icon-triangle-1-s"
                        },
                        text: false
                    })
                    .removeClass("ui-corner-all")
                    .addClass("custom-combobox-toggle ui-corner-right")
                    .mousedown(function() {
                        wasOpen = input.autocomplete("widget").is(":visible");
                    })
                    .click(function() {
                        input.focus();

                        // Close if already visible
                        if (wasOpen) {
                            return;
                        }

                        // Pass empty string as value to search for, displaying all results
                        input.autocomplete("search", "");
                    });
            },

            _source: function(request, response) {
                var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
                response(this.element.children("option").map(function() {
                    var text = $(this).text();
                    if (this.value && (!request.term || matcher.test(text)))
                        return {
                            label: text,
                            value: text,
                            option: this
                        };
                }));
            },

            _removeIfInvalid: function(event, ui) {

                // Selected an item, nothing to do
                if (ui.item) {
                    return;
                }

                // Search for a match (case-insensitive)
                var value = this.input.val(),
                    valueLowerCase = value.toLowerCase(),
                    valid = false;
                this.element.children("option").each(function() {
                    if ($(this).text().toLowerCase() === valueLowerCase) {
                        this.selected = valid = true;
                        return false;
                    }
                });

                // Found a match, nothing to do
                if (valid) {
                    return;
                }

                // Remove invalid value
                this.input
                    .val("")
                    //.attr( "title", value + " didn't match any item" )
                    .tooltip("open");
                this.element.val("");
                this._delay(function() {
                    this.input.tooltip("close").attr("title", "");
                }, 2500);
                this.input.data("ui-autocomplete").term = "";
            },

            _destroy: function() {
                this.wrapper.remove();
                this.element.show();
            }
        });
    })(jQuery);

    bloquear();
    //getinfo();
});


