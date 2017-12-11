$('document').ready(function () {
    $('#rr_dateIni').datetimepicker({
        autoclose: 1,
        format: "yyyy-mm-dd",
        minView: 2
    });

    $('#rr_dateEnd').datetimepicker({
        autoclose: 1,
        format: "yyyy-mm-dd",
        minView: 2
    });

    $("#rr_tipo").change(function () {
        if ($(this).val() === "1") {
            $("#rr_cuenta").prop("readonly", true);
        } else {
            $("#rr_cuenta").prop("readonly", false);
        }
    })

});

var app = angular.module('app', []);
app.controller('retentionController', function ($scope, $http) {
    $scope.getData = function () {
        var params = {
            "dateIni": $("#rr_dateIni").val(),
            "dateEnd": $("#rr_dateEnd").val(),
            "cuenta": $("#rr_cuenta").val()
        }
        $http.post('/PvReports/executeRetentionReport', params)
                .then(function (response) {
                    $scope.retentions = [];
                    $scope.totalWon = 0;
                    $scope.totalRet = 0;
                    angular.forEach(response.data, function (val) {
                        $scope.retentions.push(val);
                        $scope.totalWon += parseFloat(val.AmountWon);
                        $scope.totalRet += parseFloat(val.AmountTax);
                    });
                }, function (response) {
                    console.log(response.failure);
                });
    };
});