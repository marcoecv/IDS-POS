$('document').ready(function () {
    $("#cajeroCerrarCaja").click(function (){
        resetMenuButtons()
        $(this).removeClass("btn-success");
        var currentClass=$(this).attr("class")+" btn-info"
        $(this).attr("class",currentClass);
        
        $("#cajero_leftBox .hideShow").attr("style","display:none");
        $("#cajero_centerBox .hideShow").attr("style","display:none");
        //INCLUIR ACCION DE MOSTRAR TRANSACCIONES
        $("#cajero_cerrarCaja").attr("style","display:block");
        $("#cajero_cerrarCajaPanel").attr("style","display:block");
        
        getTransactionsCierre();
    });
});



function cerrarCaja() {
    var monto = parseFloat($('#cajaBal').text());
    $.ajax({
        url: "setCierreCaja",
        type: 'post',
        dataType: "json",
        success: function (data) {
            if (data != 0) {
                printCierreCaja(data, monto)
                window.location = "/cashier/cajero";
            }
            else {
                alert('Hubo un error al procesar el Cierre de Caja');
            }
        }
    })

}


function printCierreCaja(data, amount) {
    var params = JSON.stringify(data);
    var w = window.open("/cashier/printcierre?monto=" + amount + "&params=" + encodeURI(params), "", "width=450,height=700");
}


function getTransactionsCierre(){
    $.ajax({
        url: "cerrarcaja",
        success: function (data) {
            var obj=JSON.parse(data);
            var table=$("#cc_table");
            $("#cc_table tr").remove();
            $.each(obj,function (key,val){
                table.append(setTransactionsCierreTR(val["TranDateTime"],val["TicketNumber"],val["DocNum"],val["Description"],val["Amount"]))
            })
        }
    })
}

function setTransactionsCierreTR(TranDateTime,ticket,DocNum,Description,Amount){
    var credit="";
    var debit="";
    if(parseFloat(Amount)>0)
        credit=parseFloat(Amount).toFixed(2);
    else{
        debit=parseFloat(Amount).toFixed(2);
    }
    var tr=$("<tr></tr>");
    var td1=$("<td class='tdDateTime'>"+formatDate(TranDateTime)+"</td>");
    tr.append(td1);
    var td2=$("<td class='tdTransaction'>"+DocNum+"</td>");
    tr.append(td2);
    var td3=$("<td class='tdTicket'>"+ticket+"</td>");
    tr.append(td3);
    var td4=$("<td class='tdDesc'>"+Description+"</td>");
    tr.append(td4);
    var td5=$("<td class='tdCredit'>"+credit+"</td>");
    tr.append(td5);
    var td6=$("<td class='tdDebit'>"+debit+"</td>");
    tr.append(td6);
    return tr;
}