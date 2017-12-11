$(document).ready(function () {
    $('#findTicketId').focus();

     $('#findTicket').click(function () {

        getTicket(trim($('#findTicketId').val()));
        $('#findTicketId').val('');
        $('#findTicketId').focus();


    });
    
    $("#findTicketId").keyup(function(e){ 
        var code = e.which; 
        if(code==13){
            $("#findTicket").trigger("click");
        }
});

    $('#findTicketR').click(function () {
        getTicketD(trim($('#findTicketId').val()));
        $('#findTicketId').val('');
        $('#findTicketId').focus();
    });

    $('#pagarTickets').click(function () {
        paySelectedTickets();
    });
});



function paySelectedTickets(){
    var saldo = parseFloat($('#cajaBal').text());
    var monto = parseFloat($('#pay-total').text()).toFixed(2);
    var pay = 0;
    if (monto > 0) {
        if (saldo > monto) {
            var tickets = [];
            $('#pt_resumenTable tr').each(function () {
                var tr = $(this).attr('id').split("_");
                var id = tr[1];
                var subMonto=$(this).find("#tdSubTotal_"+id).text();;
                tickets.push(id);
                pay = pagarTicket(id, subMonto);
                if (pay != "1"){
                }
            });
            $('#saldoCaja').text(accounting.formatNumber(getSaldo(), 2, ','));
            printPayTicket(tickets);
            window.location ="/cashier/cajero";
        } else {
            alert('Faltan: $' + (saldo - monto) + ' para Pagar estos Tickets');
        }
    } else {
        alert('No hay apuestas a Pagar');
    }
}

function getTicket(ticketId) {
    var t = $('#pt_table');
    var pos = trim($('#anonimAccount').val()).toUpperCase();
    $.ajax({
        url: $('#baseurl').val() + "Cashier/getTicket",
        type: 'post',
        data: 'ticketId=' + ticketId,
        dataType: "json",
        success: function (data) {
            if (data != 0) {
                if (data.CustomerID == pos) {

                    var check = '';
                    var pagar = 0.00;
                    var ret=(parseFloat(data.retention)/100)*(parseFloat(data.Won)-parseFloat(data.Risk))
                     if (data.WagerStatus === 'W') {
                        pagar = parseFloat(data.Won).toFixed(2);
                    } else if (data.WagerStatus === 'X') {
                        pagar = parseFloat(data.Risk).toFixed(2);
                    } else if (parseFloat(data.AmountRefunded) > 0.0 && data.WagerStatus === "L") {
                        pagar = parseFloat(data.AmountRefunded).toFixed(2);
                    } else {
                        pagar = 0.00;
                    }
                    
                    if ((data.WagerStatus === 'W' || data.WagerStatus === 'X' || (parseFloat(data.AmountRefunded) > 0.0 && data.WagerStatus === "L")) && data.Pay == "false") {
                        var clase = "info";
                        if (data.WagerStatus === 'X')
                            clase = "warning";
                        check = '<button type="button" onclick="addToPay(' + data.TicketNumber + ',' + pagar + ','+ret+')" class="btn btn-' + clase + '"><i class="glyphicon glyphicon-ok-sign"></i></button>';
                    } else if (data.WagerStatus === 'L') {
                        check = 'Perdida';
                    } else if (data.WagerStatus === 'P') {
                        check = 'Pendiente';
                    } else {
                        check = 'Pagada';
                    }
                    if ($("#tr_"+data.TicketNumber).length===0) {
                        var tr=$("<tr id='tr_"+data.TicketNumber+"'></tr>");
                        var td1=$('<td class="tdTicket"><span  id="tdTicket_'+data.TicketNumber+'">'+data.TicketNumber+'</span></td>');
                        tr.append(td1);
                        var td2=$('<td class="tdFecha"><span id="tdFecha_'+data.TicketNumber+'">'+data.PostedDateTime.substr(0, 19)+'</span></td>');
                        tr.append(td2);
                        var td3=$('<td class="tdSeleccion"><span id="tdSeleccion_'+data.TicketNumber+'">'+data.Description+'</span></td>');
                        tr.append(td3);
                        var td4=$('<td class="tdRiesgo"><span id="tdRiesgo_'+data.TicketNumber+'">'+data.Risk+'</span></td>');
                        tr.append(td4);
                        var td5=$('<td class="tdGanar"><span id="tdGanar_'+data.TicketNumber+'">'+data.Won+'</span></td>');
                        tr.append(td5);
                        var td6=$('<td class="tdPagar"><span id="tdPagar_'+data.TicketNumber+'">'+pagar+'</span></td>');
                        tr.append(td6);
                        var td7=$('<td class="tdTipo"><span id="tdTipo_'+data.TicketNumber+'">'+data.BetType+'</span></td>');
                        tr.append(td7);
                        var td8=$('<td class="tdButton" id="tdButton_'+data.TicketNumber+'">'+check+'</td>');
                        tr.append(td8);
                        
                        t.append(tr);
                    } else {
                        alert('el Ticket ya esta fue Agregado a la Lista');
                    }
                } else {
                    alert('Este Ticket pertenece a la cuenta: ' + data.customerID);
                }
            }
            else {
                alert('El ticket no Existe');
            }
        }
    });
}

function addToPay(ticket, pagar,ret) {
    var pagoTotal=(parseFloat(pagar)-ret);
    var disp = parseFloat($("#saldoCaja").text());
    var DispTotal=disp-pagoTotal;
    var total = parseFloat($("#pay-total").text());
    var finalTot=total+pagoTotal;

    $("#saldoCaja").text(DispTotal.toFixed(2));
    $("#pay-total").text(finalTot.toFixed(2));
    $("#tdButton_" + ticket).find("button").prop("disabled", true);
    
    var table = $("#pt_resumenTable");
    var tr = $("<tr id='pt_" + ticket + "'></tr>");
    var td1 = $("<td class='tdBorrar'><button type='button' class='btn btn-danger' onclick='removeFromPay(" + ticket + ")'><i class='glyphicon glyphicon-remove'></i></button></td>");
    tr.append(td1);
    var td2 = $("<td class='tdTiquete'>" + ticket + "</td>");
    tr.append(td2);
    var td3 = $("<td class='tdGanado'>" + pagar + "</td>");
    tr.append(td3);
    var td4 = $("<td class='tdRetention'>" + ret + "</td>");
    tr.append(td4);
    var td5 = $("<td class='tdSubTotal'><span id='tdSubTotal_" + ticket + "'>" + pagoTotal.toFixed(2) + "</span></td>");
    tr.append(td5);
    table.append(tr);
    $("#findTicketId").focus();

}

function removeFromPay(ticket) {
    var pagar = $("#tdSubTotal_" + ticket).text();
    var disp = parseFloat($("#saldoCaja").text());
    $("#saldoCaja").text((disp + parseFloat(pagar)).toFixed(2));
    var total = parseFloat($("#pay-total").text());
    $("#pay-total").text((total - parseFloat(pagar)).toFixed(2));
    $("#pt_" + ticket).remove();
    $("#tdButton_" + ticket).find("button").prop("disabled", false);
    $("#findTicketId").focus();
}