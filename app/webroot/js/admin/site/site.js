$(document).ready(function() {
    //disableControls();
    $("#globalcustomer").attr("placeholder", "Agent");
    $("#globalcustomer").val(_CUSTOMER);
    $("#globalcustomer").prop("readonly", true);
    
    getAgentTemplateDesing($("#globalcustomer").val(), $("#globalcustomer").val(), $("#cbxSite").val());
    
    $("#cbxSite").change(function() {
        getAgentTemplateDesing($("#globalcustomer").val(), $("#globalcustomer").val(), $("#cbxSite").val());
    });
    
    $("#btn_search_customer").click(function() {
        getAgentTemplateDesing($("#globalcustomer").val(), $("#globalcustomer").val(), $("#cbxSite").val());
    });
    
    $("#globalcustomer").keydown(function(event) {
        if (event.which == 13) {
            getAgentTemplateDesing($("#globalcustomer").val(), $("#globalcustomer").val(), $("#cbxSite").val());
        }
    });
    
    $("#btn_editar").click(function() {
        //enableControls();
    });
    
    $("#btn_cancel").click(function() {
        //disableControls();
    });
    
    $("#btn_save").unbind();
    $("#btn_save").click(function() {
        var betTypes = "";
    
        if($('#chkStraight').prop('checked')) betTypes = betTypes + ",Straight";
        if($('#chkParlay').prop('checked')) betTypes = betTypes + ",Parlay";
        if($('#chkRndRobin').prop('checked')) betTypes = betTypes + ",RndRobin";
        if($('#chkTeaser').prop('checked')) betTypes = betTypes + ",Teaser";
        if($('#chkIfBet').prop('checked')) betTypes = betTypes + ",IfBet";
        if($('#chkReverse').prop('checked')) betTypes = betTypes + ",Reverse";
        
        if (betTypes.length > 0) {
            betTypes = betTypes.substring(1);
        }
        
        var betMenuOptions = "";
        $("input[group^='MenuOptions']").each(function(index) {
            if ($(this).prop( "checked" )) {
                betMenuOptions += "," + $(this).val();
            }
        });
        if (betMenuOptions.length > 0) {
            betMenuOptions = betMenuOptions.substring(1);
        }
        
        var betInfoGeneral = "";
        $("input[group^='InfoGeneral']").each(function(index) {
            if ($(this).prop( "checked" )) {
                betInfoGeneral += "," + $(this).val();
            }
        });
        if (betInfoGeneral.length > 0) {
            betInfoGeneral = betInfoGeneral.substring(1);
        }
        
        saveAgentTemplateDesing($("#globalcustomer").val(), $("#globalcustomer").val(), $("#cbxSite").val(), $("#cbxTemplate").val(), $("#cbxLineTypeFormat").val(), $("#cbxLanguage").val(), betTypes, betInfoGeneral, betMenuOptions);
    });
});

function getAgentTemplateDesing(customer, agent, site){
    var url = $('#baseurl').val() + "Site/getAgentTemplateDesing";
    var parameters = {"CustomerID": customer, "AgentID": agent, "Site": site};
    
    $.ajax({
        type: "POST",
        url: url,
        dataType: "json",
        cache: false,
        async: true,
        data: parameters,
        success: function(data) {
            if (data != null) {
                $("#cbxTemplate").val($.trim((data["TemplateID"] == undefined ? "0" : data["TemplateID"])));
                $("#cbxLineTypeFormat").val($.trim((data["LineTypeFormat"] == undefined ? "0" : data["LineTypeFormat"])));
                $("#cbxLanguage").val($.trim((data["Language"] == undefined ? "0" : data["Language"])));
                
                $('#chkStraight').prop('checked', false);
                $('#chkParlay').prop('checked', false);
                $('#chkRndRobin').prop('checked', false);
                $('#chkTeaser').prop('checked', false);
                $('#chkIfBet').prop('checked', false);
                $('#chkReverse').prop('checked', false);
                var strBetTypes = (data["BetTypes"] == undefined ? "" : data["BetTypes"]);
                if (strBetTypes != null && strBetTypes.length > 0) {
                    var lstBetTypes = strBetTypes.split(",");
   
                    $.each(lstBetTypes, function(index, value) {
                        $('#chk' + value).prop('checked', true);
                    });
                }
                
                var strMenuOptions = (data["MenuOptions"] == undefined ? "" : data["MenuOptions"]);
                if (strMenuOptions != null && strMenuOptions.length > 0) {
                    var lstMenuOptions = strMenuOptions.split(",");
   
                    $.each(lstMenuOptions, function(index, value) {
                        $('#chk' + value).prop('checked', true);
                    });
                }
                
                var strInfoGeneral = (data["InfoGeneral"] == undefined ? "" : data["InfoGeneral"]);
                if (strInfoGeneral != null && strInfoGeneral.length > 0) {
                    var lstInfoGeneral = strInfoGeneral.split(",");
   
                    $.each(lstInfoGeneral, function(index, value) {
                        $('#chk' + value).prop('checked', true);
                    });
                }
            }
            else{
                alert("Data not found for the agent!");
            }
        }, error: function(event, request, settings) {
            console.log(request);
        }
    });  
}

function validAgentTemplateDesing(customer, agent, site, idTemplate, lineTypeFormat, language, betTypes){
    var resp = true;
    
    if (customer == undefined || customer == null || $.trim(customer) == "") {
        alert("Must select a valid agent");
        resp = false;
    }
    
    if (resp && (site == undefined || site == null || $.trim(site) == "" || $.trim(site) == "0")) {
        alert("Must select a valid site");
        resp = false;
    }
    
    if (resp && (idTemplate == undefined || idTemplate == null || $.trim(idTemplate) == "" || $.trim(idTemplate) == "0")) {
        alert("Must select a valid template");
        resp = false;
    }
    
    if (resp && (lineTypeFormat == undefined || lineTypeFormat == null || $.trim(lineTypeFormat) == "" || $.trim(lineTypeFormat) == "0")) {
        alert("Must select a valid line format");
        resp = false;
    }
    
    if (resp && (language == undefined || language == null || $.trim(language) == "" || $.trim(language) == "0")) {
        alert("Must select a valid language");
        resp = false;
    }
    
    if (resp && (betTypes == undefined || betTypes == null || $.trim(betTypes) == "" || $.trim(betTypes) == "0")) {
        alert("Must select at least a bet type");
        resp = false;
    }
    
    return resp;
}

function saveAgentTemplateDesing(customer, agent, site, idTemplate, lineTypeFormat, language, betTypes, menuOptions, infoGeneral){
    if (validAgentTemplateDesing(customer, agent, site, idTemplate, lineTypeFormat, language, betTypes)) {
        var url = $('#baseurl').val() + "Site/putAgentTemplateDesing";
        var parameters = {"CustomerID": customer, "AgentID": agent, "Site": site, "TemplateID": idTemplate, "LineTypeFormat": lineTypeFormat, "Language": language, "BetTypes": betTypes, "MenuOptions": menuOptions, "InfoGeneral": infoGeneral };
        
        $.ajax({
            type: "POST",
            url: url,
            dataType: "text",
            cache: false,
            async: true,
            data: parameters,
            success: function(data) {
                if (data != null && parseInt(data) == 1) {
                    //globalMasterSave();
                    alert("Success Saved");
                }
            }, error: function(event, request, settings) {
                console.log(request);
            }
        });
    }
}

function disableControls(){
    $("#cbxSite").prop("disabled", true);
    $("#cbxTemplate").prop("disabled", true);
    $("#cbxLineTypeFormat").prop("disabled", true);
    $("#cbxLanguage").prop("disabled", true);
    
    $("#chkStraight").prop("disabled", true);
    $("#chkParlay").prop("disabled", true);
    $("#chkRndRobin").prop("disabled", true);
    $("#chkTeaser").prop("disabled", true);
    $("#chkIfBet").prop("disabled", true);
    $("#chkReverse").prop("disabled", true);
}

function enableControls(){
    $("#cbxSite").prop("disabled", false);
    $("#cbxTemplate").prop("disabled", false);
    $("#cbxLineTypeFormat").prop("disabled", false);
    $("#cbxLanguage").prop("disabled", false);
    
    $("#chkStraight").prop("disabled", false);
    $("#chkParlay").prop("disabled", false);
    $("#chkRndRobin").prop("disabled", false);
    $("#chkTeaser").prop("disabled", false);
    $("#chkIfBet").prop("disabled", false);
    $("#chkReverse").prop("disabled", false);
}