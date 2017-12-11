var tipoCuenta="";
$('document').ready(function () {

    $('#pb_initdate').datetimepicker({
        format: "yyyy-mm-dd hh:ii"
    });

    $('#pb_enddate').datetimepicker({
        format: "yyyy-mm-dd hh:ii"
    });
});

var app = angular.module('app', []);
app.controller('pendingBetsController', function ($scope, $http) {
    $scope.getData = function () {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();

        var incio = "1900-01-01 00:00";
        var fin = yyyy+"-"+mm+"-"+dd+" 23:59";
        var params = {
            "dateIni": incio,
            "dateEnd": fin,
            "caja":$('#pb_caja').val(),
            "opt":$('#pb_tipoCuenta').val()
        }
        $http.post('/PvReports/betsreport', params)
                .then(function (response) {
                    $scope.pendingBets = [];
                    $scope.cantidad=0
                    $scope.riesgoTotal = 0;
                    $scope.totalToWin = 0;
                    angular.forEach(response.data, function (val) {
                        if(val.WagerStatus==="Pending"){
                            val.Risk=parseFloat(val.Risk).toFixed(2);
                            val.ToWinAmount=parseFloat(val.ToWinAmount).toFixed(2);
                            $scope.pendingBets.push(val);
                            $scope.cantidad++;
                            $scope.riesgoTotal += parseFloat(val.Risk);
                            $scope.totalToWin += parseFloat(val.ToWinAmount);
                        }
                    });
                }, function (response) {
                    console.log(response.failure);
                });
    };
});