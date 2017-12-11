$('document').ready(function () {
    getTransactionsCierre();
    $("#cajeroDepositcta").click(function (){
        resetMenuButtons()
        $(this).removeClass("btn-success");
        var currentClass=$(this).attr("class");
        $(this).attr("class",currentClass+" btn-info");
        
        $("#sendRet").attr("style","display:none");
        $("#sendDeposit").attr("style","display:block");
        $("#cajero_leftBox .hideShow").attr("style","display:none");
        $("#cajero_centerBox .hideShow").attr("style","display:none");
        $("#cajero_deposits").attr("style","display:block");
        $("#cajero_numericKeyboard").attr("style","display:block");
    });

    $("#cajeroPayTicket").click(function (){
        resetMenuButtons()
        $(this).removeClass("btn-success");
        var currentClass=$(this).attr("class")+" btn-info"
        $(this).attr("class",currentClass);
        
        $("#cajero_leftBox .hideShow").attr("style","display:none");
        $("#cajero_centerBox .hideShow").attr("style","display:none");
        //INCLUIR ACCION DE MOSTRAR TRANSACCIONES
        $("#cajero_payTicket").attr("style","display:block");
        $("#cajero_payTicketPanel").attr("style","display:block");
    });
    
    $("#cajeroRetirocta").click(function (){
        resetMenuButtons()
        $(this).removeClass("btn-success");
        var currentClass=$(this).attr("class")+" btn-info"
        $(this).attr("class",currentClass);
        
        $("#cajero_leftBox .hideShow").attr("style","display:none");
        $("#cajero_centerBox .hideShow").attr("style","display:none");
        $("#sendRet").attr("style","display:block");
        $("#sendDeposit").attr("style","display:none");
        $("#cajero_deposits").attr("style","display:block");
        $("#cajero_numericKeyboard").attr("style","display:block");
    });
    
    
    $("#cajeroDepositarCaja").click(function (){
        $("#depositarCaja").modal("toggle");
    });
    
    $("#cajeroRetirarCaja").click(function (){
        $("#retirarCaja").modal("toggle");
    })
    getDisponible();


    $('#sendAbrirCaja').click(function () {
        $('#sendAbrirCaja').prop('disabled', true);
        abrirCaja();
    });

    $('#senddepositCaja').click(function () {
        $('#senddepositCaja').prop('disabled', true);
        depositarCaja();
    });
    
    
    $('#sendretCaja').click(function () {
        $('#sendretCaja').prop('disabled', true);
        retirarCaja();
    });
});

function resetMenuButtons(){
    $.each($("#cajero_rightBox .rightMenuButton"),function (){
        $(this).removeClass("btn-info");
        var currentClass=$("#cajero_rightBox .rightMenuButton").attr("class");
        $(this).attr("class",currentClass+" btn-success");
    });
}

function abrirCaja() {
    var monto = parseInt($('#openAmount').val());

    if (monto > 0) {
        $.ajax({
            url: $('#baseurl').val() + "Cashier/abrirCaja",
            type: 'post',
            data: 'monto=' + monto,
            dataType: "json",
            success: function (data) {
                if (data != 0) {
                    $('#openAmount').val('')
                     $('#sendAbrirCaja').prop('disabled', false);
                    printOpen('', monto, data.DocNum);
                    location.reload();
                }
                else {
                    alert('Hubo un error al procesar la Apertura');
                }

            }
        })
    }
    else {
        alert('El monto de Apertura debe ser Mayor a 0');
    }
}

function printOpen(data, amount, doc) {
    var params = JSON.stringify(data);
    var w = window.open("/cashier/printopen?monto=" + amount + "&doc=" + doc + "&params=" + encodeURI(params), "", "width=450,height=700");
} 

function pagarTicket(ticket, monto) {
    var parametros = {
        ticket: ticket,
        monto: monto
    };
    $.ajax({
        url: $('#baseurl').val() + "Cashier/pagarTicket",
        async :false,
        type: 'post',
        data: parametros,
        dataType: "json",
        success: function (data) {
            return data;
        }
    })
}


function depositarCaja() {
    var monto = parseFloat($('#depositcAmount').val());

    if (monto > 0) {
        $.ajax({
            url: $('#baseurl').val() + "Cashier/depositarCaja",
            type: 'post',
            data: 'monto=' + monto,
            dataType: "json",
            success: function (data) {
                if (data != 0) {
        $('#senddepositCaja').prop('disabled', false);
                    printBoxDep('', monto, data.DocNum);
                    location.reload();
                }
                else {
                    alert('Hubo un error al procesar el Deposito');
                }
            }
        })
    }
    else {
        alert('El monto del deposito debe ser Mayor a 0');
    }
}


function retirarCaja() {
    var monto = parseFloat($('#retcAmount').val());

    if (monto > 0) {
        $.ajax({
            url: $('#baseurl').val() + "Cashier/setRetiroCaja",
            type: 'post',
            data: 'monto=' + monto,
            dataType: "json",
            success: function (data) {
                if (data != 0) {
                    $('#depositcAmount').val('');
                       $('#sendretCaja').prop('disabled', false);
                    printBoxRet('', monto, data.DocNum);
                    location.reload();
                }
                else {
                    alert('Hubo un error al procesar el Retiro');
                }
            }
        })
    }
    else {
        alert('El monto del Retiro debe ser Mayor a 0');
    }
}




function getDisponible() {

    $.ajax({
        url: $('#baseurl').val() + "Cashier/getSaldoAjax",
        type: 'post',
        //data: parametros,
        dataType: "json",
        success: function (data) {
            $('#cajaBal').text(parseFloat(data.monto).toFixed(2));
        }
    })

}

function printBoxDep(data, amount, doc) {
    var params = JSON.stringify(data);
    var w = window.open("/cashier/printboxdep?monto=" + amount + "&doc=" + doc + "&params=" + encodeURI(params), "", "width=450,height=700");

}

function printBoxRet(data, amount, doc) {
    var params = JSON.stringify(data);
    var w = window.open("/cashier/printboxret?monto=" + amount + "&doc=" + doc + "&params=" + encodeURI(params), "", "width=450,height=700");

}

function printPayTicket(tickets) {
    var params = JSON.stringify(tickets);
    var w = window.open("/Printview/printpayindex?params=" + encodeURI(params), "", "width=450,height=700");
}

function printDeposit(data, amount, doc) {
    var params = JSON.stringify(data);
    var w = window.open("/cashier/printdep?monto=" + amount + "&doc=" + doc + "&params=" + encodeURI(params), "", "width=450,height=700");

}

function printOpen(data, amount, doc) {
    var params = JSON.stringify(data);
    var w = window.open("/cashier/printopen?monto=" + amount + "&doc=" + doc + "&params=" + encodeURI(params), "", "width=450,height=700");

}

function printRet(data, amount, doc) {
    var params = JSON.stringify(data);
    var w = window.open("/cashier/printret?monto=" + amount + "&doc=" + doc + "&params=" + encodeURI(params), "", "width=450,height=700");

}

function getSaldo() {

    $.ajax({
        url: $('#baseurl').val() + "Cashier/getSaldoAjax",
        type: 'post',
        //data: parametros,
        dataType: "json",
        success: function (data) {

            return data.monto;

        }
    })

}

function getTransactionsBox() {

    $.ajax({
        url: $('#baseurl').val() + "Cashier/getTransactionsBoxAjax",
        type: 'post',
        //data: parametros,
        dataType: "json",
        success: function (data) {
            return data;


        }
    })

}

function reprintTicket(data) {
    var params = JSON.stringify(data);
    //alert(params);
    //var w = window.open("/cashier/printpay", "", "width=450,height=700");
    var w = window.open("/Printview/reprintticket?params=" + encodeURI(params), "", "width=450,height=700");
}


function deleteTicket(ticket) {
    if(confirm("Desea Borrar el ticket #"+ticket+"?")){
        var parametros = {
            ticket: ticket
        };

        $.ajax({
            url: $('#baseurl').val() + "Cashier/deleteTicket",
            type: 'post',
            data: parametros,
            dataType: "json",
            success: function (data) {
                alert('Ticket Eliminado Correctamente');
                location.reload();
            }

        })
    }
}
function openDesbCajaModal(){
    $("#dbm_caja option").remove();
    $.ajax({
        url: "/Pages/boxVerificationMaintenance",
        type: 'POST',
        data: {
            "active":1,
            "option":5
        },success: function (data) {
            var obj=JSON.parse(data);
            var select=$("#dbm_caja");
            $.each(obj,function (key,val){
                select.append("<option value='"+val["CashierID"]+"'>"+val["CashierID"]+"</option>")
            });
            $("#desbloquearCaja").modal("toggle");
        }
    });
}

function desbloquearCaja(){
    $.ajax({
        url: "/Pages/boxVerificationMaintenance",
        type: 'POST',
        data: {
            "boxId":$("#dbm_caja").val(),
            "active":0,
            "option":3
        },success: function (data) {
            $("#desbloquearCaja").modal("toggle");
        }
    });
}


function formatDate(date){
    var dateArray=date.trim().split(" ");
    var date=dateArray[0].split("-");
    var time=dateArray[1].split(":");
    
    return date[2]+"-"+date[1]+"-"+date[0]+" "+time[0]+":"+time[1];
}