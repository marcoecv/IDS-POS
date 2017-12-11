 $(document).ready(function () {
        $('#findTicketId').focus();
        
    $("#cajeroReprintTickets").click(function (){
        resetMenuButtons();
        $(this).removeClass("btn-success");
        var currentClass=$(this).attr("class");
        $(this).attr("class",currentClass+" btn-info");
        showTicketsToPrint();
        $("#cajero_leftBox .hideShow").attr("style","display:none");
        $("#cajero_centerBox .hideShow").attr("style","display:none");
        $("#cajeroReimprimirTickets").attr("style","display:block");
        $("#cajeroReprintPanel").attr("style","display:block");
    });
    
    
    $('#rt_searchTicket').click(function () {
        if($('#rt_findTicketId').val()!==""){
            getTicketD(trim($('#rt_findTicketId').val()));
            $('#findTicketId').val('');
            $('#findTicketId').focus();
        }else{
            showTicketsToPrint();
        }
    });
});

function getTicketD(ticketId) {
    $.ajax({
        url: $('#baseurl').val() + "Cashier/getTicket",
        type: 'post',
        data: 'ticketId=' + ticketId,
        dataType: "json",
        success: function (data) {
            $("#rt_table tr").remove();
            var table=$("#rt_table");
            table.append(createPrintTicketTR(data["CustomerID"],data["TicketNumber"],data["PostedDateTime"],data["BetType"],data["Description"],data["Risk"],data["ToWinAmount"]))
        }
    });

}
function showTicketsToPrint(){
    $.ajax({
        url: "reprintickets",
        success: function (data) {
            var obj=JSON.parse(data);
            $("#rt_table tr").remove();
            var table=$("#rt_table");
            $.each(obj,function (key,val){
                if(val["WagerStatus"].trim() === "Pending")
                    table.append(createPrintTicketTR(val["UserAccount"],val["TicketNumber"],val["TranDateTime"],val["WagerType"],val["Description"],val["Risk"],val["ToWinAmount"]));
            });
        }
    });
}


function createPrintTicketTR(UserAccount,TicketNumber,TranDateTime,WagerType,Description,Risk,ToWinAmount){
    var tr=$("<tr id='"+TicketNumber+"'></tr>");
    
    var td1=$("<td class='td_rtCuenta'>"+UserAccount+"</td>");
    tr.append(td1);
    var td2=$("<td class='td_rtTicket'>"+TicketNumber+"</td>");
    tr.append(td2);
    var td3=$("<td class='td_rtDate'>"+formatDate(TranDateTime)+"</td>");
    tr.append(td3);
    var td8=$("<td class='td_rtTipo'>"+WagerType+"</td>");
    tr.append(td8);
    var td4=$("<td class='td_rtDesc'>"+Description+"</td>");
    tr.append(td4);
    var td5=$("<td class='td_rtRisk'>"+parseFloat(Risk).toFixed(2)+"</td>");
    tr.append(td5);
    var td6=$("<td class='td_rtWin'>"+parseFloat(ToWinAmount).toFixed(2)+"</td>");
    tr.append(td6);
    var td7=$("<td class='td_rtImprimir'><a><i class='glyphicon glyphicon-print' onclick='reprintTicket("+TicketNumber+")'></i></a></td>");
    tr.append(td7);
    
    return tr;
}