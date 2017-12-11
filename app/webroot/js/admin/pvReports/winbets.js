var tipoCuenta = "";
$('document').ready(function () {

   $('#wb_dateIni').datetimepicker({
        autoclose: 1,
        format: "yyyy-mm-dd",
        minView:2
    });
    
    $('#wb_dateEnd').datetimepicker({
        autoclose: 1,
        format: "yyyy-mm-dd",
        minView:2
    });
});

var app = angular.module('app', []);
app.controller('wonBetsController', function ($scope, $http) {
    $scope.getData = function () {
        var params = {
            dateIni: $('#wb_dateIni').val()+" "+$('#wb_initTime').val(),
            dateEnd: $('#wb_dateEnd').val()+" "+$('#wb_endTime').val(),
            caja:$('#wb_caja').val(),
            opt:$('#wb_tipoCuenta').val()
        }
        $http.post('/PvReports/betsreport', params)
                .then(function (response) {
                    $scope.wonBets = [];
                    $scope.cantidad=0;
                    $scope.riesgoTotal = 0;
                    $scope.ganadoTotal = 0;
                    $scope.totalPagado = 0;
                    $scope.totalPorPagar = 0;
                    angular.forEach(response.data, function (val) {
                        if(val.WagerStatus==="Win"){
                            if(val.Pay==="true"){
                                val.paidIcon='glyphicon glyphicon-ok';
                                val.toPayIcon='';
                            }else{
                                val.paidIcon='';
                                val.toPayIcon='glyphicon glyphicon-ok';
                            }
                            val.Risk=parseFloat(val.Risk).toFixed(2);
                            val.Won=parseFloat(val.Won).toFixed(2);
                            $scope.wonBets.push(val);
                            $scope.cantidad++;
                            $scope.riesgoTotal += parseFloat(val.Risk);
                            $scope.ganadoTotal += parseFloat(val.Won);
                            if(val.pay)
                                $scope.totalPagado += (parseFloat(val.Won)+parseFloat(val.Risk));
                            else
                                $scope.totalPorPagar += (parseFloat(val.Won)+parseFloat(val.Risk));
                        }
                    });
                }, function (response) {
                    console.log(response.failure);
                });
    };
});
