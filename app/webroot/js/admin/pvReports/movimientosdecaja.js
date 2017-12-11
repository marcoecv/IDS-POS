var tipoCuenta="";
$('document').ready(function () {


    $('#mc_initdate').datetimepicker({
        autoclose: 1,
        format: "yyyy-mm-dd",
        minView:2
    });
    
    $('#mc_enddate').datetimepicker({
        autoclose: 1,
        format: "yyyy-mm-dd",
        minView:2
    });

    $('#mc_searchTrans').click(function () {
        submit()
    });
    
    $("#mc_cuentaAnonima").click(function (){
        tipoCuenta=$("#mc_cuentaAnonima").val();
        $(".radiobutton").attr("class","btn btn-warning radiobutton");
        $("#mc_cuentaAnonima").attr("class","btn btn-danger radiobutton");
    });
    
    $("#mc_cuentaEx").click(function (){
        tipoCuenta=$("#mc_cuentaEx").val();
        $(".radiobutton").attr("class","btn btn-warning radiobutton");
        $("#mc_cuentaEx").attr("class","btn btn-danger radiobutton");
    });
    
    $("#mc_all").click(function (){
        tipoCuenta=$("#mc_all").val();
        $(".radiobutton").attr("class","btn btn-warning radiobutton");
        $("#mc_all").attr("class","btn btn-danger radiobutton");
    });

});




function submit() {
    var dateIni = $('#mc_initdate').val();
    var dateEnd = $('#mc_enddate').val();
    var timeIni = $('#mc_initTime').val();
    var timeEnd = $('#mc_endTime').val();
    var caja = $('#mc_caja').val();
    var tipoMov = $('#mc_Movimiento').val();
    $.ajax({
        url: "/PvReports/movimientosdecajareport",
        type: 'POST',
        data: {
            "dateIni": dateIni+" "+timeIni,
            "dateEnd": dateEnd+" "+timeEnd,
            "caja":caja,
            "movimiento":tipoMov
        }, success: function (data) {
            var obj = JSON.parse(data);
            var tableBody = $("#mc_table tbody");
            var tableFoot = $("#mc_table tfoot");
            $("#mc_table tbody tr").remove();
            $("#mc_table tfoot tr").remove();
            var totalO = 0;
            var totalC = 0;
            var totalA = 0;
            var totalI = 0;
            var totalJ = 0;
            var totalD = 0;
            var totalR = 0;
            var totalB = 0;
            var totalF = 0;
            var totalE = 0;
            $.each(obj, function (key, val) {
                totalO += parseFloat((val["TranType"]==="O"?Math.round(val["Amount"] * 100) / 100:0));
                totalC += parseFloat((val["TranType"]==="C"?Math.round(val["Amount"] * 100) / 100:0));
                totalA += parseFloat((val["TranType"]==="A"?Math.round(val["Amount"] * 100) / 100:0));
                totalI += parseFloat((val["TranType"]==="I"?Math.round(val["Amount"] * 100) / 100:0));
                totalJ += parseFloat((val["TranType"]==="J"?Math.round(val["Amount"] * 100) / 100:0));
                totalD += parseFloat((val["TranType"]==="D"?Math.round(val["Amount"] * 100) / 100:0));
                totalR += parseFloat((val["TranType"]==="R"?Math.round(val["Amount"] * 100) / 100:0));
                totalB += parseFloat((val["TranType"]==="B"?Math.round(val["Amount"] * 100) / 100:0));
                totalF += parseFloat((val["TranType"]==="F"?Math.round(val["Amount"] * 100) / 100:0));
                totalE += parseFloat((val["TranType"]==="E"?Math.round(val["Amount"] * 100) / 100:0));
                
                var tr = $("<tr></tr>");
                var date=val["TranDateTime"].split(" ");
                var timeArray=date[1].split(":");
                var td1 = $("<td class='tdFecha'>" + date[0] +" "+timeArray[0]+":"+timeArray[1]+"</td>");
                tr.append(td1);
                var td3 = $("<td class='tdCaja'>" + val["BoxID"] + "</td>");
                tr.append(td3);
                var td2 = $("<td class='tdDoc'>" + val["DocNum"] + "</td>");
                tr.append(td2);
                var td4 = $("<td class='tdUsuario'>" + val["UserName"] +" / "+ val["CustomerID"] +"</td>");
                tr.append(td4);
                var td5 = $("<td class='tdDescription'>" + getTipoMovimiento(val["TranType"]) + "</td>");
                tr.append(td5);
                var td14 = $("<td class='tdTicket'>"+val["TicketNumber"]+"</td>");
                tr.append(td14);
                var td6 = $("<td class='tdMonto'>" + (val["TranType"]==="O"?Math.round(val["Amount"] * 100) / 100:"") + "</td>");
                tr.append(td6);
                var td15 = $("<td class='tdMonto'>"+(val["TranType"]==="C"?Math.round(val["Amount"] * 100) / 100:"")+"</td>");
                tr.append(td15);
                var td7 = $("<td class='tdMonto'>" + (val["TranType"]==="A"?Math.round(val["Amount"] * 100) / 100:"") + "</td>");
                tr.append(td7);
                var td8 = $("<td class='tdMonto'>" + (val["TranType"]==="I"?Math.round(val["Amount"] * 100) / 100:"") + "</td>");
                tr.append(td8);
                var td14 = $("<td class='tdMonto'>" + (val["TranType"]==="J"?Math.round(val["Amount"] * 100) / 100:"") + "</td>");
                tr.append(td14);
                var td9 = $("<td class='tdMonto'>"+(val["TranType"]==="D"?Math.round(val["Amount"] * 100) / 100:"")+"</td>");
                tr.append(td9);
                var td10 = $("<td class='tdMonto'>"+(val["TranType"]==="R"?Math.round(val["Amount"] * 100) / 100:"")+"</td>");
                tr.append(td10);
                var td12 = $("<td class='tdMonto'>"+(val["TranType"]==="F"?Math.round(val["Amount"] * 100) / 100:"")+"</td>");
                tr.append(td12);
                var td13 = $("<td class='tdMonto'>"+(val["TranType"]==="E"?Math.round(val["Amount"] * 100) / 100:"")+"</td>");
                tr.append(td13);
                
                tableBody.append(tr);
                
            });
            var tr = $("<tr></tr>");
            tr.append("<td class='tdFecha'>Totales</td>");
            tr.append("<td class='tdCaja'>&nbsp</td>");
            tr.append("<td class='tdDoc'>&nbsp;</td>");
            tr.append("<td class='tdUsuario'>&nbsp;</td>");
            tr.append("<td class='tdTipoMov'>&nbsp;</td>");
            tr.append("<td class='tdTicket'>&nbsp;</td;</td>");
            tr.append("<td class='tdMonto'>" +Math.round(totalO * 100) / 100+ "</td>");
            tr.append("<td class='tdMonto'>" +Math.round(totalC * 100) / 100+ "</td>");
            tr.append("<td class='tdMonto'>" +Math.round(totalA * 100) / 100+ "</td>");
            tr.append("<td class='tdMonto'>" +Math.round(totalI * 100) / 100+ "</td>");
            tr.append("<td class='tdMonto'>" +Math.round(totalJ * 100) / 100+ "</td>");
            tr.append("<td class='tdMonto'>" +Math.round(totalD * 100) / 100+ "</td>");
            tr.append("<td class='tdMonto'>" +Math.round(totalR * 100) / 100+ "</td>");
            tr.append("<td class='tdMonto'>" +Math.round(totalF * 100) / 100+ "</td>");
            tr.append("<td class='tdMonto'>" +Math.round(totalE * 100) / 100+ "</td>");
            
            tableFoot.append(tr);
            $("#totalD").text(Math.round(totalD * 100) / 100);
            $("#totalA").text(Math.round(totalA * 100) / 100);
            $("#totalI").text(Math.round(totalI * 100) / 100);
            $("#totalJ").text(Math.round(totalJ * 100) / 100);
            $("#totalR").text(Math.round(totalR * 100) / 100);
            $("#totalB").text(Math.round(totalB * 100) / 100);
            $("#totalF").text(Math.round(totalF * 100) / 100);
            $("#totalE").text(Math.round(totalE * 100) / 100);
            var total=totalD+totalA+totalI+totalJ+totalR+totalB+totalF+totalE;
            $("#total").text(Math.round(total * 100) / 100);
        }
    });
    
}