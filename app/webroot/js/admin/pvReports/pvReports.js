var dataChart1 = '';
$('document').ready(function () {

    $('#inicioPicker').datepicker({
        autoclose: true
    });
    $('#finPicker').datepicker({
        autoclose: true
    });

    $('#searchTrans').click(function () {
        var incio = $('#inicioPicker').val();
        var fin = $('#finPicker').val();

    });

    $('#setReprint').click(function () {
        var ticket = $('#ticketId').val();
        reprintTicket(ticket);

    });

});


function getTicket(ticketId) {


    $.ajax({
        url: $('#baseurl').val() + "PvReports/reprintTicket",
        type: 'post',
        data: 'ticketId=' + ticketId,
        dataType: "json",
        success: function (data) {
            return data
        }
    });

}

function reprintTicket(data) {
    var params = JSON.stringify(data);
    //alert(params);
    //var w = window.open("/cashier/printpay", "", "width=450,height=700");
    var w = window.open("/PvReports/reprinticket?ticketid=" + encodeURI(params), "", "width=450,height=700");
}

function getBalance(from, to) {

    var parametros = {
        inicio: from,
        fin: to
    };

    $.ajax({
        url: $('#baseurl').val() + "PvReports/reprintTicket",
        type: 'post',
        data: parametros,
        dataType: "json",
        success: function (data) {
            return data
        }
    })
}








