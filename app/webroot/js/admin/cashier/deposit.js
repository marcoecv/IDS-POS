$('document').ready(function () {
    
    $('#inicioPicker').datepicker({
        autoclose: true
    });
    
    $('#finPicker').datepicker({
        autoclose: true
    });

    $('#sendDeposit').on('click', function () {
        setDep();
    });
    $('#sendRet').on('click', function () {
        setRet();
    });
    
    $('#findPlayer').click(function () {
        var customerId = $("#findId").val();
        getDisponible();
        findPlayer(customerId);
        $('#amount').val(0);
    });

    $("#dep_keyboardTable .numeric").click(function (){
        $("#dep_keyboardValue").val($("#dep_keyboardValue").val()+$(this).val())
    });
    
    $("#dep_keyboardDelete").click(function (){
        var len=$("#dep_keyboardValue").val().length;
        $("#dep_keyboardValue").val($("#dep_keyboardValue").val().substring(0, len-1));
    });
    
    $("#dep_keyboardEnter").click(function (){
        $("#"+focusedInput).val($("#dep_keyboardValue").val());
        $("#"+focusedInput).trigger( "keyup" );
        $("#dep_keyboardValue").val("");
    });
});


function setDep() {
    if (parseFloat($('#dep_keyboardValue').val()) > 0) {
        $('#depositname').text($('#propietariocta').val());
        $('#depMonto').text(parseFloat($('#dep_keyboardValue').val()));
        $('#confirmDeposit').modal('toggle');
    } else {
        alert('El monto de Deposito debe ser Mayor a 0');
    }

}


function setRet() {
    if (parseFloat($('#dep_keyboardValue').val()) > 0) {
        $('#retName').text($('#propietariocta').val());
        $('#retAmount').text(parseFloat($('#dep_keyboardValue').val()));
        $('#newWithdraw').modal('toggle');
    } else {
        alert('El monto de Retiro debe ser Mayor a 0');
    }


}

function depositarCuenta() {
    var monto = parseFloat($('#depMonto').text());
    var player = $('#findId').val();

    var parametros = {
        player: player,
        monto: monto
    };

    if (monto > 0) {
        $.ajax({
            url: "setDepositoCuenta",
            type: 'post',
            data: parametros,
            dataType: "json",
            success: function (data) {
                if (data != 0) {
                    $('#dep_keyboardValue').val('');
                    printDeposit(parametros, monto, data.DocNum);
                    $("#findPlayer").trigger("click");
                }
                else {
                    alert('Hubo un error al procesar el Deposito');
                }
            }
        });

        $('#confirmDeposit').modal('toggle');
        findPlayer(player);

    }
    else {
        alert('El monto del deposito debe ser Mayor a 0');
    }
}

function retirarCuenta() {
    var monto = parseFloat($('#retAmount').text());
    var player = $('#findId').val();
    var caja = parseFloat($('#cajaBal').text());
    var saldo = parseFloat($('#disponiblecta').val());


    var parametros = {
        player: player,
        monto: monto
    };

    if (monto > 0) {

        if (caja >= monto) {
            if (saldo >= monto) {
                $.ajax({
                    url: "setRetiroCuenta",
                    type: 'post',
                    data: parametros,
                    dataType: "json",
                    success: function (data) {
                        if (data != 0) {
                            printRet(parametros, monto, data.DocNum);
                            $('#dep_keyboardValue').val('')
                            $("#findPlayer").trigger("click");
                        }
                        else {
                            alert('Hubo un error al procesar el Retiro');
                        }
                    }
                });
                $('#newWithdraw').modal('toggle');
                findPlayer(player);
            } else {
                alert('El monto del Retiro no Puede Ser mayor al Saldo de la Cuenta');
            }
        } else {
            alert('No hay Suficiente saldo en Caja para Realizar esta Transaccion');
        }
    }
    else {
        alert('El monto del Retiro debe ser Mayor a 0');
    }
}


function findPlayer(player) {
    var customerId = player;
    $.ajax({
        url: $('#baseurl').val() + "Cashier/findPlayer",
        type: 'post',
        data: {
            'customerId':customerId
        },
        success: function (data) {
            var obj=JSON.parse(data)
            if (data != 0) {
                $('#playerId').text(obj["player"]["CustomerID"]);
                $('#propietariocta').val(obj["player"]["NameFirst"] + ' ' + obj["player"]["NameLast"]);
                $('#disponiblecta').val('' + accounting.formatNumber(parseFloat(obj["player"]["balance"]), 2, ''));
                getDisponible();
                $("#transactionTable tr").remove()
                var table=$("#transactionTable");
                $.each(obj["transactions"],function (key,val){
                    table.append(createTransactionsCtaTR(val["TranDateTime"],val["DocumentNumber"],val["Description"],val["Credit"],val["Debit"],val["Balance"]));
                });
                
                $("#sendDeposit").attr('disabled', false);
                $("#sendRet").attr('disabled', false);

            } else {
                alert('El Usuario no Existe');
            }

        }

    });
}

function createTransactionsCtaTR(TranDateTime,DocumentNumber,Description,Credit,Debit,Balance){
    var tr=$("<tr></tr>");
    
    var td1=$("<td  class='tdDepDate'>"+formatDate(TranDateTime)+"</td>");
    tr.append(td1);
    var td2=$("<td  class='tdDedTrans'>"+DocumentNumber+"</td>");
    tr.append(td2);
    var td3=$("<td  class='tdDepDesc'>"+Description+"</td>");
    tr.append(td3);
    var td4=$("<td  class='tdDepDebits'>"+Credit+"</td>");
    tr.append(td4);
    var td5=$("<td  class='tdDepCredits'>"+Debit+"</td>");
    tr.append(td5);
    var td6=$("<td  class='tdDepBalance'>"+Balance+"</td>");
    tr.append(td6);
    
    return tr;
}