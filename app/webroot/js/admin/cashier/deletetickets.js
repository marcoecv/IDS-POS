$(document).ready(function () {
    $('#findTicketId').focus();
        
        
    $("#cajero_deleteTickets").click(function (){
        resetMenuButtons();
        $(this).removeClass("btn-success");
        var currentClass=$(this).attr("class");
        $(this).attr("class",currentClass+" btn-info");
        showTicketsToDelete();
        $("#cajero_leftBox .hideShow").attr("style","display:none");
        $("#cajero_centerBox .hideShow").attr("style","display:none");
        $("#cajeroDeleteTickets").attr("style","display:block");
        $("#cajeroDeletePanel").attr("style","display:block");
    });
    
    $('#searchTicket').click(function () {
        if($("#dt_findTicketId").val()===""){
            showTicketsToDelete();
        }else{
            var ticket=$("#dt_findTicketId").val();
            $.each($("#dt_table tr"),function (){
               if($(this).attr("id")!==ticket){
                   $(this).remove();
               } 
            });
        }
        
    });
    
    $("#dt_findTicketId").keyup(function(e){ 
        var code = e.which; 
        if(code==13){
            $("#findTicket").trigger("click");
        }
    });
});


function showTicketsToDelete(){
    $.ajax({
        url: "deletetickets",
        success: function (data) {
            var obj=JSON.parse(data);
            $("#dt_table tr").remove();
            var table=$("#dt_table");
            $.each(obj,function (key,val){
                if(val["WagerStatus"].trim() === "Pending")
                    table.append(createTicketTR(val["UserAccount"],val["TicketNumber"],val["TranDateTime"],val["Description"],val["Risk"],val["ToWinAmount"]));
            });
        }
    });
}

function createTicketTR(UserAccount,TicketNumber,TranDateTime,Description,Risk,ToWinAmount){
    var tr=$("<tr id='"+TicketNumber+"'></tr>");
    
    var td1=$("<td class='td_dtCuenta'>"+UserAccount+"</td>");
    tr.append(td1);
    var td2=$("<td class='td_dtTicket'>"+TicketNumber+"</td>");
    tr.append(td2);
    var td3=$("<td class='td_dtDate'>"+formatDate(TranDateTime)+"</td>");
    tr.append(td3);
    var td4=$("<td class='td_dtDesc'>"+Description+"</td>");
    tr.append(td4);
    var td5=$("<td class='td_dtRisk'>"+parseFloat(Risk).toFixed(2)+"</td>");
    tr.append(td5);
    var td6=$("<td class='td_dtWin'>"+parseFloat(ToWinAmount).toFixed(2)+"</td>");
    tr.append(td6);
    var td7=$("<td class='td_dtDelete'><a><i class='glyphicon glyphicon-trash' onclick='deleteTicket("+TicketNumber+")'></i></a></td>");
    tr.append(td7);
    
    return tr;
}