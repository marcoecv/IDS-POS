$('document').ready(function () {

    $('#dw_dateIni').datetimepicker({
        autoclose: 1,
        format: "yyyy-mm-dd",
        minView:2
    });
    
    $('#dw_dateEnd').datetimepicker({
        autoclose: 1,
        format: "yyyy-mm-dd",
        minView:2
    });
});


var app = angular.module('app', []);
app.controller('deletedBetsController', function ($scope, $http) {
    $scope.getData = function () {
        var dateIni=$("#dw_dateIni").val();
        var dateFin=$("#dw_dateEnd").val();
        var timeIni=$("#dw_initTime").val();
        var timeEnd=$("#dw_endTime").val();
        var cuenta=$("#dw_cuenta").val();
        var borradoPor=$("#dw_deletedBy").val();
        var option;
        if(borradoPor!==""){
            option=2;
        }else if(cuenta!==""){
            option=3;
        }else{
            option=1;
        }
        var params = {
            "dateIni":dateIni,
            "timeIni":timeIni,
            "dateEnd":dateFin,
            "timeEnd":timeEnd,
            "cuenta":cuenta,
            "deletedBy":borradoPor,
            "option":option
        };
        $http.post('/PvReports/getdeletedwagerreport', params)
                .then(function (response) {
                    $scope.deletedBets = [];
                    angular.forEach(response.data, function (val) {
                        val.AmountWagered=parseFloat(val.AmountWagered).toFixed(2);
                        val.ToWinAmount=parseFloat(val.ToWinAmount).toFixed(2);
                        switch (val.WagerStatus){
                            case 'P':
                                val.WagerStatus="Pendiente";
                                break;
                            case 'W':
                                val.WagerStatus="Ganada";
                                break;
                            case 'L':
                                val.WagerStatus="Perdida";
                                break;
                            case 'X':
                                val.WagerStatus="Cancel";
                                break;
                                
                        }
                        $scope.deletedBets.push(val);
                    });
                }, function (response) {
                    console.log(response.failure);
                });
    };
});


//function submit(){
//    var dateIni=$("#dw_dateIni").val();
//    var dateFin=$("#dw_dateEnd").val();
//    var timeIni=$("#dw_initTime").val();
//    var timeEnd=$("#dw_endTime").val();
//    var cuenta=$("#dw_cuenta").val();
//    var borradoPor=$("#dw_deletedBy").val();
//    var option;
//    if(borradoPor!==""){
//        option=2;
//    }else if(cuenta!==""){
//        option=3;
//    }else{
//        option=1;
//    }
//    $.ajax({
//        url: "/PvReports/getdeletedwagerreport",
//        type: 'POST',
//        data: {
//            "dateIni":dateIni,
//            "timeIni":timeIni,
//            "dateEnd":dateFin,
//            "timeEnd":timeEnd,
//            "cuenta":cuenta,
//            "deletedBy":borradoPor,
//            "option":option
//        },success: function (data) {
//            var obj = JSON.parse(data);
//            $("#dw_table tboby tr").remove();
//            var table=$("#dw_table tbody");
//            $.each(obj,function (key,val){
//                table.append(createNewTD(val["DeletedBy"],val["AmountWagered"],val["Description"],val["TicketNumber"],val["ToWinAmount"],val["WagerType"],val["WagerStatus"],val["CustomerID"],val["PostedDateTime"],val["DeleteDate"]))
//            });
//        }
//    });
//}
//
//
//function createNewTD(DeletedBy,AmountWagered,Description,TicketNumber,ToWinAmount,WagerType,WagerStatus,CustomerID,PostedDateTime,DeleteDate){
//    var tr=$("<tr></tr>");
//    
//    var td1=$("<td class='tdTicket'>"+TicketNumber+"</td>");
//    tr.append(td1);
//    var td2=$("<td class='tdCuenta'>"+CustomerID+"</td>");
//    tr.append(td2);
//    var td10=$("<td class='tdDeletedBy'>"+DeletedBy+"</td>");
//    tr.append(td10);
//    var td3=$("<td class='tdDescription'>"+Description+"</td>");
//    tr.append(td3);
//    var td4=$("<td class='tdRiesgo'>"+AmountWagered+"</td>");
//    tr.append(td4);
//    var td5=$("<td class='tdGanar'>"+ToWinAmount+"</td>");
//    tr.append(td5);
//    var td6=$("<td class='tdTipo'>"+WagerType+"</td>");
//    tr.append(td6);
//    var td7=$("<td class='tdEstado'>"+WagerStatus+"</td>");
//    tr.append(td7);
//    var td8=$("<td class='tdfechaCreacion'>"+PostedDateTime+"</td>");
//    tr.append(td8);
//    var td9=$("<td class='tdFechaBorrado'>"+DeleteDate+"</td>");
//    tr.append(td9);
//    
//    return tr;
//}
//
