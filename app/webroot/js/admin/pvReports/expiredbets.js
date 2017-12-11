var tipoCuenta = "";
$('document').ready(function () {

   $('#eb_dateIni').datetimepicker({
        autoclose: 1,
        format: "yyyy-mm-dd",
        minView:2
    });
    
    $('#eb_dateEnd').datetimepicker({
        autoclose: 1,
        format: "yyyy-mm-dd",
        minView:2
    });


    $('#eb_searchTrans').click(function () {
        submit();
    });

});


function submit() {
    var dateIni = $('#eb_dateIni').val();
    var timeIni = $('#eb_initTime').val();
    var dateEnd = $('#eb_dateEnd').val();
    var timeEnd = $('#eb_endTime').val();
    var caja = $('#eb_caja').val();
    var tipo = $('#eb_tipoCuenta').val();
    $.ajax({
        url: "/PvReports/betsreport",
        type: 'POST',
        data: {
            "dateIni": dateIni+" "+timeIni,
            "dateEnd": dateEnd+" "+timeEnd,
            "caja": caja,
            "opt": $('#eb_tipoCuenta').val()
        }, success: function (data) {
            var obj = JSON.parse(data);
            var tableBody = $("#eb_table tbody");
            var tableFoot = $("#eb_table tfoot");
            $("#eb_table tbody tr").remove();
            $("#eb_table tfoot tr").remove();
            var cant = 0;
            var riesgoTotal = 0;
            var pagadoTotal = 0;
            var totalPagar = 0;
            var totalPagado = 0;
            $.each(obj, function (key, val) {

                if (tipo == '1') {

                    if ((val["WagerStatus"].trim() === "Win" || val["WagerStatus"].trim() === "Cancelled")&&val["CbStatus"].trim()==="C") {
                        cant++;
                        riesgoTotal += parseFloat(val["Risk"]);
                        pagadoTotal += parseFloat((val["Won"] === "" ? "0" : val["Won"]));

                        if (val["Pay"] === "false") {
                            totalPagar += parseFloat(val["Risk"]) + parseFloat((val["Won"] === "" ? "0" : val["Won"]));
                        } else {
                            totalPagado += parseFloat(val["Risk"]) + parseFloat((val["Won"] === "" ? "0" : val["Won"]));
                        }

                        var tr = $("<tr></tr>");
                        var date = val["TranDateTime"].split(" ");
                        var timeArray = date[1].split(":");
                        var td1 = $("<td class='tdFecha'>" + date[0] + " " + timeArray[0] + ":" + timeArray[1] + "</td>");
                        tr.append(td1);
                        var td2 = $("<td class='tdTicket'>" + val["TicketNumber"] + "</td>");
                        tr.append(td2);
                        var td3 = $("<td class='tdJugador'>" + val["UserAccount"] + "</td>");
                        tr.append(td3);
                        var td4 = $("<td class='tdDescription'>" + val["Description"] + "</td>");
                        tr.append(td4);
                        var td5 = $("<td class='tdRiesgo'>" + val["Risk"] + "</td>");
                        tr.append(td5);
                        var td6 = $("<td class='tdPagado'>" + val["Won"] + "</td>");
                        tr.append(td6);
                        var td8 = $("<td class='tdTipo'>" + val["WagerType"] + "</td>");
                        tr.append(td8);
                        var td9 = $("<td class='tdEstado'>" + val["WagerStatus"] + "</td>");
                        tr.append(td9);
                        var td10 = $("<td class='tdPagar noExl'><i class='" + (val["Pay"] === "false" ? "glyphicon glyphicon-ok" : "") + "'></i></td>");
                        tr.append(td10);
                        var td11 = $("<td class='tdPagado noExl'><i class='" + (val["Pay"] === "true" ? "glyphicon glyphicon-ok" : "") + "'></i><span style='display:none'>" + (val["Pay"] === "true" ? "Si" : "No") + "</span></td>");
                        tr.append(td11);
                        var td12 = $("<td class='tdCaja'>" + val["BoxID"] + "</td>");
                        tr.append(td12);
                        tableBody.append(tr);
                    }
                } else if (tipo == '2') {
                    if ((val["WagerStatus"].trim() === "Win" || val["WagerStatus"].trim() === "Cancelled") && val["Pay"] === "true" ) {
                        cant++;
                        riesgoTotal += parseFloat(val["Risk"]);
                        pagadoTotal += parseFloat((val["Won"] === "" ? "0" : val["Won"]));

                        if (val["Pay"] === "false") {
                            totalPagar += parseFloat(val["Risk"]) + parseFloat((val["Won"] === "" ? "0" : val["Won"]));
                        } else {
                            totalPagado += parseFloat(val["Risk"]) + parseFloat((val["Won"] === "" ? "0" : val["Won"]));
                        }

                        var tr = $("<tr></tr>");
                        var date = val["TranDateTime"].split(" ");
                        var timeArray = date[1].split(":");
                        var td1 = $("<td class='tdFecha'>" + date[0] + " " + timeArray[0] + ":" + timeArray[1] + "</td>");
                        tr.append(td1);
                        var td2 = $("<td class='tdTicket'>" + val["TicketNumber"] + "</td>");
                        tr.append(td2);
                        var td3 = $("<td class='tdJugador'>" + val["UserAccount"] + "</td>");
                        tr.append(td3);
                        var td4 = $("<td class='tdDescription'>" + val["Description"] + "</td>");
                        tr.append(td4);
                        var td5 = $("<td class='tdRiesgo'>" + val["Risk"] + "</td>");
                        tr.append(td5);
                        var td6 = $("<td class='tdPagado'>" + val["Won"] + "</td>");
                        tr.append(td6);
                        var td8 = $("<td class='tdTipo'>" + val["WagerType"] + "</td>");
                        tr.append(td8);
                        var td9 = $("<td class='tdEstado'>" + val["WagerStatus"] + "</td>");
                        tr.append(td9);
                        var td10 = $("<td class='tdPagar noExl'><i class='" + (val["Pay"] === "false" ? "glyphicon glyphicon-ok" : "") + "'></i></td>");
                        tr.append(td10);
                        var td11 = $("<td class='tdPagado noExl'><i class='" + (val["Pay"] === "true" ? "glyphicon glyphicon-ok" : "") + "'></i><span style='display:none'>" + (val["Pay"] === "true" ? "Si" : "No") + "</span></td>");
                        tr.append(td11);
                        var td12 = $("<td class='tdCaja'>" + val["BoxID"] + "</td>");
                        tr.append(td12);
                        tableBody.append(tr);
                    }

                } else if (tipo == '3') {
                    if ((val["WagerStatus"].trim() === "Win" || val["WagerStatus"].trim() === "Cancelled") && val["Pay"] === "false" ) {
                        cant++;
                        riesgoTotal += parseFloat(val["Risk"]);
                        pagadoTotal += parseFloat((val["Won"] === "" ? "0" : val["Won"]));

                        if (val["Pay"] === "false") {
                            totalPagar += parseFloat(val["Risk"]) + parseFloat((val["Won"] === "" ? "0" : val["Won"]));
                        } else {
                            totalPagado += parseFloat(val["Risk"]) + parseFloat((val["Won"] === "" ? "0" : val["Won"]));
                        }

                        var tr = $("<tr></tr>");
                        var date = val["TranDateTime"].split(" ");
                        var timeArray = date[1].split(":");
                        var td1 = $("<td class='tdFecha'>" + date[0] + " " + timeArray[0] + ":" + timeArray[1] + "</td>");
                        tr.append(td1);
                        var td2 = $("<td class='tdTicket'>" + val["TicketNumber"] + "</td>");
                        tr.append(td2);
                        var td3 = $("<td class='tdJugador'>" + val["UserAccount"] + "</td>");
                        tr.append(td3);
                        var td4 = $("<td class='tdDescription'>" + val["Description"] + "</td>");
                        tr.append(td4);
                        var td5 = $("<td class='tdRiesgo'>" + val["Risk"] + "</td>");
                        tr.append(td5);
                        var td6 = $("<td class='tdPagado'>" + val["Won"] + "</td>");
                        tr.append(td6);
                        var td8 = $("<td class='tdTipo'>" + val["WagerType"] + "</td>");
                        tr.append(td8);
                        var td9 = $("<td class='tdEstado'>" + val["WagerStatus"] + "</td>");
                        tr.append(td9);
                        var td10 = $("<td class='tdPagar noExl'><i class='" + (val["Pay"] === "false" ? "glyphicon glyphicon-ok" : "") + "'></i></td>");
                        tr.append(td10);
                        var td11 = $("<td class='tdPagado noExl'><i class='" + (val["Pay"] === "true" ? "glyphicon glyphicon-ok" : "") + "'></i><span style='display:none'>" + (val["Pay"] === "true" ? "Si" : "No") + "</span></td>");
                        tr.append(td11);
                        var td12 = $("<td class='tdCaja'>" + val["BoxID"] + "</td>");
                        tr.append(td12);
                        tableBody.append(tr);
                    }

                }
            });
            var tr = $("<tr></tr>");
            tr.append("<td class='tdFecha'>&nbsp;</td>");
            tr.append("<td class='tdTicket'>Cantidad: " + cant + "</td>");
            tr.append("<td class='tdJugador'>&nbsp;</td>");
            tr.append("<td class='tdDescription'>&nbsp;</td>");
            tr.append("<td class='tdRiesgo'>" + Math.round(riesgoTotal * 100) / 100 + "</td>");
            tr.append("<td class='tdPagado'>" + Math.round(pagadoTotal * 100) / 100 + "</td>");
            tr.append("<td class='tdTipo'>&nbsp;</td>");
            tr.append("<td class='tdEstado'></td;</td>");
            tr.append("<td class='tdPagar'>" + Math.round(totalPagar * 100) / 100 + "</td>");
            tr.append("<td class='tdPagado'>" + Math.round(totalPagado * 100) / 100 + "</td>");
            tr.append("<td class='tdCaja'>&nbsp;</td>");
            tableFoot.append(tr);
        }
    });
}