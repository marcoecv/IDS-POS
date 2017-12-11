$(document).ready(function() {

    $("#parentID").val('pp');

    var customer = $("#globalcustomer").val();
    var encontroAgent = $('#encontroAgent').val();
    
    if (customer.length > 1 && encontroAgent == '1') {
        loadStores();
    }
    
    $('.changed').bind('change', function(event) {
        var saveChangesBefore = trim($('#saveChangesBefore').val());
        $('#saveChangesBefore').prop('value', '1');
    });
    
    changeLabelStatusInResponsive();

    $(window).resize(function() {
        changeLabelStatusInResponsive();
    });
    
    $('#globalcustomer').val(getSessionStorageObjects('customer'));
    $('#btn_search_customer').trigger('click');
    
    $('#notes #btn-note').unbind('click');
    $('#notes #btn-note').bind('click', function(e){
        e.preventDefault();
        
         if(isIsset($('#notes #typeNote').val()) &&
            isIsset($('#notes #nameNote').val()) &&
            isIsset($('#notes #dateNote').val())){
                InsertNoteAgent();
            }else{
                alert('All fields are mandatory.');
            }
    });
    
    $('#addNote').bind('click', function(e){
        e.preventDefault();
        var date=new Date();
        var y = date.getFullYear();
        var m = ((date.getMonth() + 1) < 10) ? '0' + (date.getMonth() + 1): (date.getMonth() + 1);
        var d = ((date.getDate()) < 10) ? '0' + date.getDate(): date.getDate();
        var html =' <div class="table-row new td">';
            html +='<div data-th="Date" class="table-cell"><input type="text" disabled class="dateNote" value="'+ y + "-" + m + "-" + d +'" /></div>';
            html +='<div data-th="Type" class="table-cell"><input type="text" placeholder="type" class="typeNote" required /></div>';
            html +='<div data-th="Name" class="table-cell"><input type="text" placeholder="name" class="nameNote" required /></div>';
            html +='<div data-th="Note" class="table-cell"><textarea  placeholder="your note" rows=1 class="newNote" required></textarea></div>';
            html +='<div data-th="Note" class="table-cell"></div>';
        html +='</div>';
        $('#notes .list.table').append(html);
        eventNote();
    });
    
    
    $('#btnSaveNote').bind('click', function(e){
        e.preventDefault();
        var rowNew = $('#notes .table-row.new');
        var rowUpdate = $('#notes .table-row-edit');
        var saved = false;
        for (var i = 0; i < rowNew.length; i++) {
			if (rowNew.eq(i).hasClass('modify')) {
                insertNoteAgent(rowNew.eq(i));
                saved = true;
            }
        }
        
         for (var i = 0; i < rowUpdate.length; i++) {
			if (rowUpdate.eq(i).hasClass('modify')) {
                var idNote = rowUpdate.eq(i).attr('data-id');
                updateNoteAgent(idNote);
                saved = true;
            }
        }
        if (saved) {
           getNotesAgent();
        }
    });
});

/*
 *
 */
function changeLabelStatusInResponsive() {
    if ($('body').hasClass('xs')) {
        //code
        $('.label-status-pregame').html('Game');
        $('.label-status-live').html('Live');
        $('.label-status-casino').html('Casino');
    } else {
        $('.label-status-pregame').html('Pre-game');
        $('.label-status-live').html('Live Betting');
        $('.label-status-casino').html('Casino');
    }
}

/*
 *
 */
function loadStores(){
    
    var cuenta = $('#globalcustomer').val();
    if (cuenta != '' && cuenta != null) {
        var storeown = trim($('#storeown').val());
        
        $("#store2").find('option').remove();
        
        var url = $('#baseurl').val();
        url = url + "Personal/getStores";
        
        var parametros = {
           account: cuenta
        }
        
        $.ajax({
            url: url,
            success: function(data) {
                var obj = $.parseJSON('[' + data + ']');
                $.each(obj[0], function(key, value) {
    
                    if (trim(value['Store']) == storeown) {
                        $("#store2").append("<option selected value='" + trim(value['Store']) + "'>" + trim(value['Store']) + "</option>");
                    } else {
                        $("#store2").append("<option value='" + trim(value['Store']) + "'>" + trim(value['Store']) + "</option>");
                    }
                });
            }
        });
    }
}


function makeCall(phone) {
    var phoneNumber = $("#" + phone).val();
    $.ajax({
        url: "Personal/makecall",
        type: 'POST',
        data: {
            "phone": phoneNumber,
            "outputExt": $("#outputExt").val()
        },
        success: function(data) {
        }
    });
}

function setOutputExt() {
    $("#setOutputExt").modal("toggle");
}


function cambiozero(estado) {
    if (estado) {
        $('#zero').parent().parent().fadeOut('fast');
    }
    else {
        $('#zero').parent().parent().fadeIn('fast');
    }
}

function validafree() {

    var x = $('#freintefb').is(':checked');

    var y = $('#freephonebk').is(':checked');

    var a = $('#frehalfpfb').is(':checked');

    var b = $('#freeintetbk').is(':checked');

    var z = parseInt($('#upto5').val()) || 0;

    if ((b || a || x || y) && ((z) == 0)) {
        showMessage('FREE_HALF_PTS', '', '', '', '');
    } else {
        setdata();
    }
}

function getinfo() {
    loadStores();
    var cuenta = $('#globalcustomer').val().trim();
    var url = $('#baseurl').val();
    url = url + "Personal/getcuentas";
    var parametros = {
        player: cuenta
    };
    
    $.ajax({
        type: "POST",
        url: url,
        dataType: "json",
        data: parametros,
        success: function(data) {
            if (!isIsset(data) || data["db"]==0)
                return;

            for(var i in data["db"]){
                var row = data["db"][i];
           
                $('#parentID').prop("value", "pp");
                $('#account').html($.trim(row.CustomerId));
                $('#encontroAgent').prop('value', '1');
                $('#pass').val($.trim(row.Password));
                $('#name').val($.trim(row.NameFirst));
                $('#last').val($.trim(row.NameLast));
                $('#userName').val($.trim(row.UserName));
                $('#sitio').val($.trim(row.InetTarget));
                $('#website').val($.trim(row.InetTarget));
                $("#base").html($('#dbNumber').val());
                $('#agent').val($.trim(row.AgentID));
                $('#hiddenCustomerUrl').val($.trim(row.InetTarget));
                
                var tipoCuenta = $.trim(row.AccountType);
                switch (tipoCuenta) {
                    case 'A':
                        $('#tipo').val('Agent');
                        break;
                    case 'M':
                        $('#tipo').val('Master Agent');
                        break;
                    case 'P':
                        $('#tipo').val('Player');
                        break;
                }
                
                $('#masterAgentID').prop('value', $.trim(row.AgentID));
                $('#tipoh').val($.trim(row.AccountType));

                if ($.trim(row.CreditAcctFlag) == "Y") {
                    $('#credia').prop('checked', true);
                }
                else {
                    $('#credia').prop('checked', false);
                }

                if ($.trim(row.EnableRifFlag) == "Y") {
                    $('#roling').prop('checked', true);
                }
                else {
                    $('#roling').prop('checked', false);
                }

                if ($.trim(row.LimitRifToRiskFlag) == "Y") {
                    $('#limitroling').prop('checked', true);
                }
                else {
                    $('#limitroling').prop('checked', false);
                }

                var store1 = $.trim(row.LineType);

                if ($.trim(row.ZeroBalanceFlag) == "1") {
                    $("#runinb").prop('checked', true);
                    $('#zero').parent().parent().fadeOut('fast');
                }
                else {
                    $("#runinb").prop('checked', false);
                    selectItemByValue(document.getElementById('zero'), ($.trim(row.ZeroBalanceFlag)));
                    $('#zero').parent().parent().fadeIn('fast');
                }

                selectItemByValue(document.getElementById('store2'), (store1));

                $('#settle').prop('value', formatnumeric($.trim(row.SettleFigure), 0));

                if ($.trim(row.BaseballAction) == "Listed") {
                    $('#listedbase').prop('checked', true);
                }
                else {
                    $('#listedbase').prop('checked', false);
                }
               
                // Info register
                $('#info-register #firstName').val($.trim(row.NameFirst));
                $('#info-register #lastName').val($.trim(row.NameLast));
                $('#info-register #address').val($.trim(row.Address));
                $('#info-register #city').val($.trim(row.City));
                $('#info-register #state option:eq('+row.State+')').prop('selected', true);
                $('#info-register #country').val($.trim(row.Country));
                $('#info-register #zipCode').val($.trim(row.Zip));
                $('#info-register #mobilePhone').val($.trim(row.BusinessPhone));
                $('#info-register #homePhone').val($.trim(row.HomePhone));
                $('#info-register #email').val(row.EMail);
                
                $('#info-register #birthDate').val($.trim(row.BirthDate.replace('00:00:00.0', '')));
                $("#info-register #securityQuestion").val(row.SecurityQuestion)
                $('#info-register #securityAnswer').val(row.SecurityAnswer);
                $('#info-register #promoCode').val(row.PromoCode);
                $('#info-register #referredBy').val(row.ReferredBy);
            }
        },complete: function() {
             getstatus();
             getNotesAgent();
        },error: function() {
            
        }
    });
}

function getHerencia(type, cuenta, padre) {

    var type2 = "";
    var url = $('#baseurl').val();
    url = url + "Personal/getherencia";
    if (type == "P") {
        type2 = "A";
    }
    if (type == "A") {
        type2 = "M";
    }

    if (type == "M") {
        type2 = "M";
    }

    var parametros = {
        player: cuenta,
        type: type2
    };

    $.ajax({
        type: "POST",
        url: url,
        dataType: "json",
        data: parametros,
        beforeSend: function(xhr) {
            $('.btn-save').hide();
        },
        success: function(data) {

            $('#store').html("");
            $.each(data, function(i, item) {


                if (trim(padre) == trim(data[i].AgentID)) {
                    $('#store').append('<option selected value="' + trim(data[i].AgentID) + '">' + trim(data[i].AgentID) + '</option> ');
                } else {
                    $('#store').append('<option  value="' + trim(data[i].AgentID) + '">' + trim(data[i].AgentID) + '</option> ');
                }
            })

            $("#store").combobox();
            $("#store").combobox("destroy");
            $("#store").combobox();

            $('.btn-save').show();
            $("#store").combobox({
                select: function(event, ui) {
                    var agentOrig = $('#masterAgentID').prop('value');
                    var agentNew = $('#store3').prop('value');
                    var continuar = "N";
                    var opcion = "";
                    $("<div><p>Should this customer inherit the selected Agent's package?</p></div>").dialog({
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
                                setInheritAgent(herenciaLive);
                            }
                        }
                    });
                }
            });
        }
    });
    if (type == "A" || type == "M") {
        $('.playershow').hide();
        $('.agentshow').show();
    } else {
        $('.playershow').show();
        $('.agentshow').hide();
    }
    getstatus();
}



function cargaherencia() {
    $("#pressedEdit").val("Y");
    if ($("#pressedEdit").val() == "Y") {
        getHerencia($("#accounttype").prop('value'), $("#hiddenCustomerId").prop('value'), $("#parent").prop('value'));
    }
}

/**
 * get info Status
 * 
 */
function getstatus() {
    var cuenta = $('#globalcustomer').val();
    if (cuenta != '' && cuenta != null) {
        var url = $('#baseurl').val();
        url = url + "Personal/getstatus";
    
        var parametros = {
            player: cuenta
        };
    
        $.ajax({
            type: "POST",
            url: url,
            dataType: "json",
            data: parametros,
            success: function(data) {
    
                if (data['Active'] == "N") {
                    $('#ckPregame').checkbox({
                        checked: false
                    });
                } else {
                    $('#ckPregame').checkbox({
                        checked: true
                    });
                }
    
                if (data['CasinoActive'] == "N") {
                    $('#ckCasino').checkbox({
                        checked: false
                    });
                } else {
                    $('#ckCasino').checkbox({
                        checked: true
                    });
                }
    
    
                if (data['HorseActive'] == "N") {
                    $('#ckHorses').checkbox({
                        checked: false
                    });
                } else {
                    $('#ckHorses').checkbox({
                        checked: true
                    });
                }
    
    
                if (data['MobileActive'] == "N") {
                    $('#ckMobile').checkbox({
                        checked: false
                    });
                } else {
                    $('#ckMobile').checkbox({
                        checked: true
                    });
                }
            }
        });
    
        if ($("#isinlive").prop("value") == "false") {
            
            $(".live").each(function() {
                if ($(this).hasClass("restric")) {
                    if (!$(this).is(':disabled')) 
                        $(this).prop("disabled", true);
                }else{
                    $(this).addClass("restric");
                    if (!$(this).is(':disabled')) 
                        $(this).prop("disabled", true);
                }
            });
    
        }
        else {
            $(".live").removeClass("restric");
            $(".live").prop("disabled", false);
            $(".live").each(function() {
                if ($(this).hasClass("restric")) {
                    if ($(this).is(':disabled')) {
                        $(this).prop("disabled", false);
                    } else {
                        $(this).prop("disabled", true);
                    }
                }
                else {
                    if ($(this).is(':disabled')) {
                        $(this).prop("disabled", false);
                    } else {
                        $(this).prop("disabled", true);
                    }
                }
            });
        }
    }
}


    
    
    
    