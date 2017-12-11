var tipoCuenta="";
$('document').ready(function () {

    $('#lb_dateIni').datetimepicker({
        autoclose: 1,
        format: "yyyy-mm-dd",
        minView:2
    });
    
    $('#lb_dateEnd').datetimepicker({
        autoclose: 1,
        format: "yyyy-mm-dd",
        minView:2
    });
});


var app = angular.module('app', []);
app.controller('lossBetsController', function ($scope, $http) {
    $scope.getData = function () {
        var params = {
            dateIni: $('#lb_dateIni').val()+" "+$('#lb_initTime').val(),
            dateEnd: $('#lb_dateEnd').val()+" "+$('#lb_endTime').val(),
            caja:$('#lb_caja').val(),
            opt:$('#lb_tipoCuenta').val()
        };
        $http.post('/PvReports/betsreport', params)
                .then(function (response) {
                    $scope.lossBets = [];
                    $scope.cantidad=0;
                    $scope.riesgoTotal = 0;
                    $scope.perdidoTotal = 0;
                    angular.forEach(response.data, function (val) {
                        if(val.WagerStatus==="Loss"){
                            val.Risk=parseFloat(val.Risk).toFixed(2);
                            val.MontoPerdido=parseFloat(val.MontoPerdido).toFixed(2);
                            $scope.lossBets.push(val);
                            $scope.cantidad++;
                            $scope.riesgoTotal += parseFloat(val.Risk);
                            $scope.perdidoTotal += parseFloat(val.MontoPerdido);
                        }
                    });
                }, function (response) {
                    console.log(response.failure);
                });
    };
});