 $(document).ready(function () {
    $('#findTicketId').focus();
        
    $("#cajero_reprintTransactions").click(function (){
        resetMenuButtons();
        $(this).removeClass("btn-success");
        var currentClass=$(this).attr("class");
        $(this).attr("class",currentClass+" btn-info");
        showAllTransactions();
        $("#cajero_leftBox .hideShow").attr("style","display:none");
        $("#cajero_centerBox .hideShow").attr("style","display:none");
        $("#cajeroReimprimirTransactions").attr("style","display:block");
        $("#cajero_reimprimirTrans").attr("style","display:block");
    });
    
    
    $('#rtran_searchTicket').click(function () {
        if($('#rtran_findTicketId').val()!==""){
            getTransactionInfo(trim($('#rtran_findTicketId').val()));
            $('#findTicketId').val('');
            $('#findTicketId').focus();
        }else{
            showAllTransactions();
        }
    });
});

function getTransactionInfo(ticketId) {
    $.ajax({
        url: $('#baseurl').val() + "Cashier/getTransactionInfo",
        type: 'post',
        data: {
            'docNum':ticketId,
        },
        success: function (data) {
            var obj=JSON.parse(data);
            $("#rtran_table tr").remove();
            var table=$("#rtran_table");
            $.each(obj,function (key,val){
                if(val["TranType"]!=="A")
                    table.append(setTransactionsReimprimirTR(val["TranDateTime"],val["DocNum"],val["Description"],val["Amount"],val["TranType"]));
            });
        }
    });

}
function showAllTransactions(){
    $.ajax({
        url: "printtransacion",
        success: function (data) {
            var obj=JSON.parse(data);
            $("#rtran_table tr").remove();
            var table=$("#rtran_table");
            $.each(obj,function (key,val){
                if(val["TranType"]!=="A")
                    table.append(setTransactionsReimprimirTR(val["TranDateTime"],val["DocNum"],val["Description"],val["Amount"],val["TranType"]));
            });
        }
    });
}


function setTransactionsReimprimirTR(TranDateTime,DocNum,Description,Amount,TranType){
    var credit="";
    var debit="";
    if(parseFloat(Amount)>0)
        credit=parseFloat(Amount).toFixed(2);
    else{
        debit=parseFloat(Amount).toFixed(2);
    }
    var tr=$("<tr></tr>");
    var td1=$("<td class='rtran_tdDateTime'>"+formatDate(TranDateTime)+"</td>");
    tr.append(td1);
    var td2=$("<td class='rtran_tdTransaction'>"+DocNum+"</td>");
    tr.append(td2);
    var td3=$("<td class='rtran_tdDesc'>"+Description+"</td>");
    tr.append(td3);
    var td4=$("<td class='rtran_tdCredit'>"+credit+"</td>");
    tr.append(td4);
    var td5=$("<td class='rtran_tdDebit'>"+debit+"</td>");
    tr.append(td5);
    var td6=$("<td class='rtran_tdPrint'><a><i class='glyphicon glyphicon-print' onclick='reprintTransaction("+DocNum+",&quot;"+TranType+"&quot;,"+Amount+")'></i></a></td>");
    tr.append(td6);
    return tr;
}


function reprintTransaction(docNum, type,amount){
    switch (type){
        case "E":
            printBoxDep([], amount, docNum);
            break;
        case "F":
            printBoxRet([], amount, docNum);
            break;
        case "O":
            printOpen([], amount, docNum);
            break;
        case "C":
            printCierreCaja({'DocNum':docNum},amount);
            break;
        case "R":
        case "D":
            getTransactionPlayer(docNum,amount,type)
            break;
    }
}


function getTransactionPlayer(docNum,amount,type){
    $.ajax({
        "url":"getTransactionPlayer",
        type: 'POST',
        async: false,
        data: {
            "docNum":docNum
        },success: function (data) {
            var obj=JSON.parse(data);
            var player=obj["row1"]["CustomerID"];
            switch (type){
                case "D":
                    printDeposit({"player":player,"monto":amount},amount,docNum);
                    break;
                case "R":
                    printRet({"player":player,"monto":amount},amount,docNum);
                    break;
            }
            
        }
    })
}