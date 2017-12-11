var tipoCuenta="";
$('document').ready(function () {


    $('#bc_dateIni').datetimepicker({
        autoclose: 1,
        format: "yyyy-mm-dd",
        minView:2
    });
    
    $('#bc_dateEnd').datetimepicker({
        autoclose: 1,
        format: "yyyy-mm-dd",
        minView:2
    });
    
    $('#mc_searchTrans').click(function () {
        submit()
    });
    
    
});


function submit() {
    var dateIni = $('#bc_dateIni').val();
    var timeIni = $('#bc_initTime').val();
    var dateEnd = $('#bc_dateEnd').val();
    var timeEnd = $('#bc_endTime').val();
    var caja = $('#mc_caja').val();
    $.ajax({
        url: "/PvReports/getBalanceCajaReport",
        type: 'POST',
        data: {
            "dateIni": dateIni,
            "dateEnd": dateEnd,
            "timeIni": timeIni,
            "timeEnd":timeEnd,
            "caja":caja
        }, success: function (data) {
            var obj = JSON.parse(data);
            var tableBody = $("#bc_table tbody");
            var tableFoot = $("#bc_table tfoot");
            $("#bc_table tbody tr").remove();
            $("#bc_table tfoot tr").remove();
            var totalO = 0;
            var totalC = 0;
            var totalA = 0;
            var totalI = 0;
            var totalD = 0;
            var totalR = 0;
            var totalB = 0;
            var totalF = 0;
            var totalE = 0;
            var totalJ = 0;
            var currentType="";
            $.each(obj, function (key, val) {
                if(parseFloat(val["Amount"])!==0){
                    totalO += parseFloat((val["TranType"]==="O"?Math.round(val["Amount"] * 100) / 100:0));
                    totalC += parseFloat((val["TranType"]==="C"?Math.round(val["Amount"] * 100) / 100:0));
                    totalA += parseFloat((val["TranType"]==="A"?Math.round(val["Amount"] * 100) / 100:0));
                    totalI += parseFloat((val["TranType"]==="I"?Math.round(val["Amount"] * 100) / 100:0));
                    totalD += parseFloat((val["TranType"]==="D"?Math.round(val["Amount"] * 100) / 100:0));
                    totalR += parseFloat((val["TranType"]==="R"?Math.round(val["Amount"] * 100) / 100:0));
                    totalB += parseFloat((val["TranType"]==="B"?Math.round(val["Amount"] * 100) / 100:0));
                    totalF += parseFloat((val["TranType"]==="F"?Math.round(val["Amount"] * 100) / 100:0));
                    totalE += parseFloat((val["TranType"]==="E"?Math.round(val["Amount"] * 100) / 100:0));
                    totalJ += parseFloat((val["TranType"]==="J"?Math.round(val["Amount"] * 100) / 100:0));
                    
                    if(currentType!==val["type"]){
                        var tr = $("<tr></tr>");
                        var td =$("<td colspan='9' style='text-align:center;font-weight:bold'>"+getTransactionGroup(val["type"])+"</td>");
                        tr.append(td);
                        tableBody.append(tr);
                        currentType=val["type"];
                    }
                    var tr = $("<tr></tr>");
                    var date=val["TranDateTime"].split(" ");
                    var timeArray=date[1].split(":");
                    var td2 = $("<td class='tdFecha'>" +date[0] +" "+timeArray[0]+":"+timeArray[1] + "</td>");
                    tr.append(td2);
                    var td3 = $("<td class='tdCaja'>" + val["BoxID"] + "</td>");
                    tr.append(td3);
                    var td4 = $("<td class='tdTransaccion'>" + val["DocNum"] +"</td>");
                    tr.append(td4);
                    var td5 = $("<td class='tdUsuario'>" + val["UserName"]+"/"+ val["CustomerID"] + "</td>");
                    tr.append(td5);
                    var td6 = $("<td class='tdDescription'>"+ getTipoMovimiento(val["TranType"]) +"</td>");
                    tr.append(td6);
                    var td7 = $("<td class='tdTicket'>" + val["TicketNumber"] + "</td>");
                    tr.append(td7);
                    var td8 = $("<td class='tdCredito'>" + (parseFloat(val["Amount"])>0 ? Math.round(parseFloat(val["Amount"])*100)/100:"") + "</td>");
                    tr.append(td8);
                    var td9 = $("<td class='tdDebito'>"+ (parseFloat(val["Amount"])<0 ? Math.round(parseFloat(val["Amount"])*100)/100:"")+"</td>");
                    tr.append(td9);
                    var td1 = $("<td class='tdBalance'>" + +"</td>");
                    tr.append(td1);
                    tableBody.append(tr);
                }
                
            });
            var deb=Math.round((totalC+totalF+totalR+totalI+totalJ)*100)/100;
            var cred=Math.round((totalO+totalE+totalD+totalA)*100)/100;
            var tr = $("<tr></tr>");
            tr.append("<td class='tdFecha'>&nbsp</td>");
            tr.append("<td class='tdCaja'>&nbsp;</td>");
            tr.append("<td class='tdTransaccion'>&nbsp;</td>");
            tr.append("<td class='tdUsuario'>&nbsp;</td>");
            tr.append("<td class='tdDescription'>&nbsp;</td;</td>");
            tr.append("<td class='tdTicket'>&nbsp;</td>");
            tr.append("<td class='tdCredito'>" +cred+ "</td>");
            tr.append("<td class='tdDebito'>" +deb+ "</td>");
            tr.append("<td class='tdBalance'>" +(Math.round((cred+deb)*100)/100)+ "</td>");
            
            
            tableFoot.append(tr);
            
            $("#totalDeb").text(deb);
            $("#totalCred").text(cred);
            $("#totalBal").text(Math.round((cred+deb)*100)/100);
        }
    });
    
    
}


function getTransactionGroup(type){
    switch (type){
        case "1":
            return "Cierres / Aperturas";
        case "2":
            return "Depositos / Retiros";
        case "3":
            return "Depositos / Retiros Cuentas Existentes";
        case "4":
            return "Ingreso / Pago de Apuestas";
    }
}