var tipoCuenta = "";
$('document').ready(function () {


    $('#ac_dateIni').datetimepicker({
        autoclose: 1,
        format: "yyyy-mm-dd",
        minView: 2
    });

    $('#ac_dateEnd').datetimepicker({
        autoclose: 1,
        format: "yyyy-mm-dd",
        minView: 2
    });

    $('#ac_searchTrans').click(function () {
        submit();
    });


});


function submit() {
    var dateIni = $('#ac_dateIni').val();
    var dateEnd = $('#ac_dateEnd').val();
    var timeIni = $('#ac_initTime').val();
    var timeEnd = $('#ac_endTime').val();
    var caja = $('#ac_caja').val();
    $.ajax({
        url: "/PvReports/getCierresAperturasReport",
        type: 'POST',
        data: {
            "dateIni": dateIni,
            "dateEnd": dateEnd,
            "timeIni": timeIni,
            "timeEnd": timeEnd,
            "caja": caja
        }, success: function (data) {
            var obj = JSON.parse(data);
            var tableBody = $("#ac_table tbody");
            var tableFoot = $("#ac_table tfoot");
            $("#ac_table tbody tr").remove();
            $("#ac_table tfoot tr").remove();
            var totalO = 0;
            var totalC = 0;
            var totalBal = 0;
            $.each(obj, function (key, val) {
                if (parseFloat(val["Amount"]) !== 0) {
                    totalO += parseFloat(Math.round(val["Apertura"] * 100) / 100);
                    totalC += parseFloat(Math.round(val["Cierre"] * 100) / 100);
                    totalBal += parseFloat(Math.round(val["Balance"] * 100) / 100);
                    var tr = $("<tr></tr>");
                    var td1 = $("<td class='tdCaja'>" + val["Caja"] + "</td>");
                    tr.append(td1);

                    var dateAp = val["FechaAp"].split(" ");
                    var timeApArray = dateAp[1].split(":");
                    var td2 = $("<td class='tdFecha'>" + dateAp[0] + " " + timeApArray[0] + ":" + timeApArray[1] + "</td>");
                    tr.append(td2);
                    var td3;
                    if (val["FechaCie"] === "Pendiente") {
                        td3 = $("<td class='tdFecha'>" + val["FechaCie"] + "</td>");
                    } else {
                        var dateCie = val["FechaCie"].split(" ");
                        var timeCieArray = dateCie[1].split(":");
                        td3 = $("<td class='tdFecha'>" + dateCie[0] + " " + timeCieArray[0] + ":" + timeCieArray[1] + "</td>");
                    }
                    tr.append(td3);

                    var td4 = $("<td class='tdTransaccion'>" + val["docNum1"] + "</td>");
                    tr.append(td4);

                    var td5 = $("<td class='tdTransaccion'>" + val["docNum2"] + "</td>");
                    tr.append(td5);

                    var td6 = $("<td class='tdCredito'>" + (Math.round(parseFloat(val["Apertura"]) * 100) / 100).toFixed(2) + "</td>");
                    tr.append(td6);
                    var td7 = $("<td class='tdDebito'>" + (Math.round(parseFloat(val["Cierre"]) * 100) / 100).toFixed(2) + "</td>");
                    tr.append(td7);
                    var td8 = $("<td class='tdBalance'>" + (Math.round(parseFloat(val["Balance"]) * 100) / 100).toFixed(2) + "</td>");
                    tr.append(td8);
                    tableBody.append(tr);
                }

            });
            totalBal = (parseFloat(totalO).toFixed(2) - Math.abs(parseFloat(totalC)).toFixed(2));
            var tr = $("<tr></tr>");
            tr.append("<td class='tdCaja'>&nbsp;</td>");
            tr.append("<td class='tdFecha'>&nbsp</td>");
            tr.append("<td class='tdFecha'>&nbsp</td>");
            tr.append("<td class='tdTransaccion'>&nbsp;</td>");
            tr.append("<td class='tdTransaccion'>&nbsp;</td>");
            tr.append("<td class='tdCredito'>" + totalO.toFixed(2) + "</td>");
            tr.append("<td class='tdDebito'>" + totalC.toFixed(2) + "</td>");
            tr.append("<td class='tdBalance'>" + totalBal.toFixed(2) + "</td>");


            tableFoot.append(tr);

            $("#totalDeb").text(totalC.toFixed(2));
            $("#totalCred").text(totalO.toFixed(2));
            $("#totalBal").text(totalBal.toFixed(2));
        }
    });


}