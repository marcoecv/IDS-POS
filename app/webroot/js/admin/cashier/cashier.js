/*document.body.addEventListener("ontouchstart", function(event) {
 if($(window).scrollTop() > 0) return;
 event.preventDefault();
 event.stopPropagation();
 }, false);
 */

var dataChart1 = '';
$('document').ready(function () {



    $('#inicioticket').datetimepicker({
        format: "yyyy-mm-dd hh:ii",
        autoclose: true
    });
    $('#finticket').datetimepicker({
        format: "yyyy-mm-dd hh:ii",
        autoclose: true
    });


    

    $('#findTicketR').click(function () {
        getTicketD(trim($('#findTicketId').val()));
        $('#findTicketId').val('');
        $('#findTicketId').focus();
    });

    

    $('#validAdmin').click(function () {
        validateAdmin();
    });

    $('#refreshTicketsD').click(function () {
        var inicio = $('#inicioticket').datepicker({dateFormat: 'dd-mm-yy'}).val();
        var fin = $('#finticket').val();
        getTicketsRangeD(inicio, fin);


//        location.reload();
    });

    $('#refreshTickets').click(function () {
        var inicio = $('#inicioticket').datepicker({dateFormat: 'dd-mm-yy'}).val();
        var fin = $('#finticket').val();
        getTicketsRange(inicio, fin);


//        location.reload();
    });


    


    $('#searchTrans').click(function () {


        if (isEmpty($('#inicioPicker').val()) || isEmpty($('#finPicker').val())) {
            alert('Debe elegir un Rango de Fechas');
        } else {
            if (moment($('#inicioPicker').val()).isAfter($('#finPicker').val())) {

                alert('La Fecha de DESDE debe Ser menor o igual a la fecha HASTA');

            } else {
                var player = trim($('#playerId').text());
                var inicio = $('#inicioPicker').val();
                var fin = $('#finPicker').val();

                getTransRange(player, inicio, fin)

            }
        }
    });

    $("#sendDeposit").attr('disabled', true);
    $("#sendRet").attr('disabled', true);


    $('#dep').on('click', function () {
        $(this).addClass('selected');
        $('#ret').removeClass('selected');
        $('#sendRet').addClass('hidden');
        $('#sendDeposit').removeClass('hidden');
        $('#amount').val(0);

    });
    $('#ret').on('click', function () {
        $(this).addClass('selected');
        $('#dep').removeClass('selected');
        $('#sendDeposit').addClass('hidden');
        $('#sendRet').removeClass('hidden');
        $('#amount').val(0);


    });


    $('#transactions').DataTable({
        "columnDefs": [
            {className: "ticket-id", "targets": [0]},
            {className: "ticket-date", "targets": [1]},
            {className: "ticket-desc", "targets": [2]},
            {"visible": false, "targets": 2},
            {className: "ticket-stat", "targets": [3]},
            {className: "ticket-risk", "targets": [4]},
            {className: "ticket-won", "targets": [5]},
            {className: "ticket-hDesc", "targets": [7]},
            {className: "ticket-amount", "targets": [6]},
            {className: "ticket-type", "targets": [8]},
            {className: "ticket-mark", "targets": [9]}
        ],
        "paging": false,
        "pageLength": 9,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": false,
        "scrollY": "510px",
        // "scrollCollapse": true,
        "autoWidth": false,
        "scrollX": false,
        "order": [[1, 'asc']],
        "displayLength": 25,
        "drawCallback": function (settings) {
            var api = this.api();
            var rows = api.rows({page: 'current'}).nodes();
            var last = null;
            var rot = api.column(0, {page: 'current'}).data();

            api.column(2, {page: 'current'}).data().each(function (group, i) {
                if (last !== group) {
                    $(rows).eq(i).after(
                        '<tr class="group"><td class="ticket-desc" colspan="6">' + group + '</td></tr>'
                    );

                    last = group;
                }
            });

        }


    });


    $('#transt').DataTable({

        "columnDefs": [
            {"width": "10%", "targets": 0},
            {"width": "5%", "targets": 1},
            {"width": "20%", "targets": 2},
            {"width": "5%", "targets": 3},
            {"width": "5%", "targets": 4},
            {"width": "5%", "targets": 5}

        ],
        "paging": false,
        "pageLength": 7,
        "lengthChange": false,
        "scrollY": "410px",
        "searching": true,
        "ordering": true,
        "info": true,
        "dom": ' <"search"f><"top"l>rt<"bottom"ip><"clear">',
        "autoWidth": true,
        "displayLength": 25,
        "sScrollX": false
    });

    $('#ticketst').DataTable({

        "columnDefs": [
            {"width": "4%", "targets": 0},
            {"width": "4%", "targets": 1},
            {"width": "10%", "targets": 2},
            {"width": "56%", "targets": 3},
            {"width": "4%", "targets": 4},
            {"width": "4%", "targets": 5},
            {"width": "4%", "targets": 6}

        ],
        "paging": false,
        "pageLength": 10,
        "lengthChange": false,
        "scrollY": "510px",
        "searching": true,
        "ordering": true,
        "info": true,
        "dom": ' <"top"l>rt<"bottom"ip><"clear">',
        "autoWidth": false,
        "sScrollX": false
    });

    dTable = $('#ticketst').DataTable();   //pay attention to capital D, which is mandatory to retrieve "api" datatables' object, as @Lionel said
    $('#findTicketId').keyup(function () {
        dTable.search($(this).val()).draw();
    })

    $('#ticketsr').DataTable({

        "columnDefs": [
            {"width": "4%", "targets": 0},
            {"width": "4%", "targets": 1},
            {"width": "10%", "targets": 2},
            {"width": "5%", "targets": 3},
            {"width": "50%", "targets": 4},
            {"width": "4%", "targets": 5},
            {"width": "4%", "targets": 6},
            {"width": "5%", "targets": 7}

        ],
        "paging": false,
        "pageLength": 10,
        "lengthChange": false,
        "scrollY": "510px",
        "searching": true,
        "ordering": true,
        "info": true,
        "dom": ' <"top"l>rt<"bottom"ip><"clear">',
        "autoWidth": false,
        "sScrollX": false
    });

    oTable = $('#ticketsr').DataTable();   //pay attention to capital D, which is mandatory to retrieve "api" datatables' object, as @Lionel said
    $('#findTicketId').keyup(function () {
        oTable.search($(this).val()).draw();

    })


    $('#transactionsCaja').DataTable({
        "columnDefs": [
            {"width": "10%", "targets": 0},
            {"width": "10%", "targets": 1},
            {"width": "60%", "targets": 2},
            {"width": "10%", "targets": 3},
            {"width": "10%", "targets": 4}

        ],
        "margin": "20px",
        "paging": false,
        "pageLength": 9,
        "lengthChange": false,
        "scrollY": "410px",
        "searching": true,
        "ordering": true,
        "info": true,
        "dom": ' <"search"f><"top"l>rt<"bottom"ip><"clear">',
        "autoWidth": false,
        "sScrollX": false
    });

    $('.dataTables_filter input').addClass('keyboard-normal');

    $('.selectAll').click(function (event) {
        if (this.checked) {

            $(':checkbox').each(function () {
                this.checked = true;
            });
        }
        else {
            $(':checkbox').each(function () {
                this.checked = false;
            });
        }
    });


    $('#transactions').on('click', '.ticket-mark', function (event) {

        $(this).find('.selectItem').click();

    });

    


})
;




function getTransactions(inicio, fin) {

    var player = $('#playerId').text();


    if (!isEmpty(player)) {


        var parametros = {
            inicio: inicio,
            fin: fin,
            player: player
        };

        $.ajax({
            url: $('#baseurl').val() + "Cashier/abrirCaja",
            type: 'post',
            data: 'monto=' + monto,
            dataType: "json",
            success: function (data) {
                if (data == 1) {
                    alert('Apertura Realizada Correctamente');
                    $('#openAmount').val('')
                }
                else {
                    alert('Hubo un error al procesar la Apertura');
                }

            }
        })
    } else {
        alert('Debe Seleccionar un Player');
    }

}






function getTransRange(player, inicio, fin) {

    var player = player;
    var inicio = inicio;
    var fin = fin;

    var parametros = {
        inicio: inicio,
        fin: fin,
        player: player
    };

    $.ajax({
        url: $('#baseurl').val() + "Cashier/getTransactionsRange",
        type: 'post',
        data: parametros,
        dataType: "json",
        success: function (data) {
            if (data != 0) {

                transTable('transt', data);

            } else {
                alert('No Existen Transacciones en el Periodo Seleccionado');
            }

        }

    })

}

function getTicketsRange(inicio, fin) {
    var inicio = inicio;
    var fin = fin;

    var parametros = {
        inicio: inicio,
        fin: fin
    };

    $.ajax({
        url: $('#baseurl').val() + "Cashier/insertedbetsbyboxreportajax",
        type: 'post',
        data: parametros,
        dataType: "json",
        success: function (data) {
            if (data != 0) {

                ticketsTable('ticketsr', data);

            } else {
                alert('No Existen Transacciones en el Periodo Seleccionado');
            }

        }

    })

}

function getTicketsRangeD(inicio, fin) {


    var inicio = inicio;
    var fin = fin;

    var parametros = {
        inicio: inicio,
        fin: fin
    };

    $.ajax({
        url: $('#baseurl').val() + "Cashier/insertedbetsbyboxreportajax",
        type: 'post',
        data: parametros,
        dataType: "json",
        success: function (data) {
            if (data != 0) {

                ticketsTableD('ticketst', data);

            } else {
                alert('No Existen Transacciones en el Periodo Seleccionado');
            }

        }

    })

}
function ticketsTableD(idTable, data) {
    var i = 1;
    var t = $('#' + idTable).DataTable();
    var print = '';
    var id = 0;

    t.clear().draw();

    for (var trans in data) {
        id = data['row' + i].TicketNumber;
        print = '<i class="ticket-print fa fa-trash" onclick="deleteTicket(' + id + ')" style="cursor: pointer"></i>';
        pagado = data['row' + i].Won > 0 ? parseFloat(data['row' + i].Won).toFixed(2) : '';
        t.row.add([
            data['row' + i].UserAccount,
            data['row' + i].TicketNumber,
            data['row' + i].TranDateTime.substr(0, 19),
            data['row' + i].Description,
            parseFloat(data['row' + i].Risk).toFixed(2),
            pagado,
            print
        ]).draw(false);
        i++;
    }

    t.columns.adjust().draw();


}

function ticketsTable(idTable, data) {
    var i = 1;
    var t = $('#' + idTable).DataTable();
    var print = '';
    var id = 0;

    t.clear().draw();
    t.search('');

    for (var trans in data) {
        id = data['row' + i].TicketNumber;
        print = '<i class="ticket-print fa fa-print" onclick="reprintTicket(' + id + ')" style="cursor: pointer"></i>';
        pagado = data['row' + i].Won > 0 ? parseFloat(data['row' + i].Won).toFixed(2) : '';
        t.row.add([
            data['row' + i].UserAccount,
            data['row' + i].TicketNumber,
            data['row' + i].TranDateTime.substr(0, 19),
            data['row' + i].Description,
            parseFloat(data['row' + i].Risk).toFixed(2),
            print
        ]).draw(false);
        i++;
    }

    t.columns.adjust().draw();


}




























