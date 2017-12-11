/*document.body.addEventListener("ontouchstart", function(event) {
 if($(window).scrollTop() > 0) return;
 event.preventDefault();
 event.stopPropagation();
 }, false);
 */

var dataChart1 = '';
$('document').ready(function () {

    dailyFigure();
    custProfileLineEntry();

    //quickSummary1();
    $('#period .btn').bind('click', function () {
        $('#period .btn').removeClass('active');
        $(this).addClass('active');
        dailyFigure();
    });

    $('#newNombre').val();
    $('#newDireccion').val();
    $('#newClave').val();
    $('#newTelefono').val();


    $(window).resize(function () {
        $("body.lg").addClass("nav-expanded-left");
    });

    $('#closeDow .btn').bind('click', function () {
        $('#closeDow .btn').removeClass('active');
        $(this).addClass('active');
        dailyFigure();
    });

    $('#findPlayer').click(function () {

        var customerId = $("#findId").val();
        findPlayer(customerId);
        $("#findId").val('');

    });

    $('#validAdmin').click(function () {
        validateAdmin();
    });

    $('#sendAbrirCaja').click(function () {
        abrirCaja();
    });
    
    $('#filterDailyFigure').hide();

    $("#col-left").resize(function () {
        if ($("#col-left").width() <= 178) {
            $("#col-left").hide();
            $("#col-left").css("display", "none");
            $("#col-left").css("visibility", "hidden");
        }
        else {
            $("#col-left").show();
            $("#col-left").css("display", "block");
            $("#col-left").css("visibility", "visible");
        }
    });
    //
    if ($.trim($('.comments-container-info').html()) == "") {
        $('.comments-container').hide();
    }
    
    
});

function RedirectDailyFigureReport() {
    window.location = $('#baseurl').val() + "AgentReports/daily_figure";
}

function RedirectOpenWagersReport() {
    window.location = $('#baseurl').val() + "AgentReports/open_wagers";
}

function RedirectWeeklyBalanceReport() {
    window.location = $('#baseurl').val() + "AgentReports/weekly_balance";
}

function RedirectInterfaceReport() {
    window.location = $('#baseurl').val() + "OfficeReports/interface_report";
}

function dailyFigure() {
    var period = $('#period .active').val();
    var closeDow = $('#closeDow .active').val();

    var parametros = {
        lastWeeksFlag: period,
        closeDow: closeDow
    };
    $.ajax({
        url: $('#baseurl').val() + "DashboardAdmin/dailyFigure",
        type: 'post',
        async: true,
        data: parametros,
        dataType: "json",
        success: function (data) {
            $('#tWktotal').html(data['wtotal']);
            $('#tCurrBalance').html(data['currentbal']);
            $('#tPending').html(data['Pending']);
            $('#tCustomer').html(data['Customers']);
        }
    })
}
function onClick_actionDF() {
    $('#filterDailyFigure').toggle();
}
function quickSummary1() {
    var endDate = $('#period .active').val();
    var parametros = {
        endDate: endDate
    };

    $.ajax({
        url: $('#baseurl').val() + "DashboardAdmin/calculWeeklyBalance",
        type: 'post',
        async: true,
        data: parametros,
        dataType: "json",
        success: function (data) {

            if (data != null) {
                var value1 = data['pendiente'];
                var percent1 = 50;
                var value2 = data['num_players'];
                var percent2 = (parseInt(data['num_players']) * 100) / parseInt(data['num_total_players']);

                progressCircle(percent1, value1, percent2, value2);
            }
        }
    });
}

function custProfileLineEntry() {

    var parametros = {};

    $.ajax({
        url: $('#baseurl').val() + "DashboardAdmin/custProfileLineEntry",
        type: 'post',
        data: parametros,
        dataType: "json",
        success: function (data) {
            $('#custProfileLineEntry').html(data);
            if (!isIsset(data)) {
                $('.line-entry-container').hide();
            }
        }
    })
}

function findPlayer(player) {

    var customerId = player;

    $.ajax({
        url: $('#baseurl').val() + "DashboardAdmin/findPlayer",
        type: 'post',
        data: 'customerId=' + customerId,
        dataType: "json",
        success: function (data) {
            if (data != 0) {
                $('#findAccount').modal('toggle');
                $('#confirmAccount').modal('toggle');
                $('#playerId').text(data.CustomerID);
                $('#playerName').text(data.NameFirst + ' ' + data.NameLast);
                $('#playerBal').text('$' + parseFloat(data.balance).toFixed(2));
                $('#btnConfirm').attr('href', '/sportbook/index/' + data.CustomerID);

            } else {
                alert('El Usuario no Existe');
            }

        }

    })
}

function validateAdmin() {

    var adminPass = $('#adminPass').val();
    var adminUser = $('#adminUser').val();

    var parametros = {
        adminPass: adminPass,
        adminUser: adminUser
    };

    $.ajax({
        url: $('#baseurl').val() + "DashboardAdmin/validateAdmin",
        type: 'post',
        data: parametros,
        dataType: "json",
        success: function (data) {

            switch (data) {
                case 0:
                {
                    alert('El usuario no tiene permisos de Supervisor');
                    break;
                }
                case 1:
                {
                    window.location.href = "/Cashier";
                    break;
                }
                default:
                {
                    alert("Usuario o clave Invalidos");
                    break;
                }


            }


        }

    })
}

function SignupFormSubmit() {

    var strName = $("#newNombre").val();
    var strFirstName = strName.substring(0, strName.indexOf(" "));
    var strLastName = strName.substring(strName.indexOf(" "));

    var parametros = {
        userName: "",
        nameFirst: strFirstName,
        nameLast: strLastName,
        address1: $("#newDireccion").val(),
        address2: "",
        BirthMonth: "01",
        BirthDay: "01",
        BirthYear: "1900",
        city: "",
        state: "",
        zip: "",
        country: "",
        countryCode: "",
        email: $("#newEmail").val(),
        confirmEmail: $("#newEmail").val(),
        securityQuestion: "",
        securityAnswer: "",
        promoCode: "",
        homePhone: $("#newTelefono").val(),
        businessPhone: $("#newTelefono").val(),
        fax: "",
        referredBy: "",
        source: "",
        password: $("#newClave").val(),
        confirmPassword: $("#newClave").val()
    };

    if (isEmpty(strName) || isEmpty($("#newDireccion").val()) || isEmpty($("#newTelefono").val()) || isEmpty($("#newClave").val())) {

        alert('Debe llenar los campos Obligatorios');

    } else {


        //Register
        $.ajax({
            type: "POST",
            url: "/Pages/Register",
            dataType: "json",
            async: true,
            data: parametros,
            success: function (data) {
//                if (data["Result"] !== -1) {
                    $("#newDireccion").val('');
                    $("#newEmail").val('');
                    $("#newTelefono").val('');
                    $("#newClave").val('');
                    $("#newNombre").val('');
                    $('#newAccount').toggle();
                    printAccount(parametros, data.user);
                    return data;

//                }else {
//                    alert('error');
//                    return data;
//                }
            },
        });
    }
    $('#newNombre').val();
    $('#newDireccion').val();
    $('#newClave').val();
    $('#newTelefono').val();

}


function progressCircle(percent1, value1, percent2, value2) {
    $("#divProgress").empty();
    $("#divProgress2").empty();

    $("#divProgress").circularloader({
        backgroundColor: "#ffffff",//background colour of inner circle
        fontColor: "#000000",//font color of progress text
        fontSize: "25px",//font size of progress text
        radius: 50,//radius of circle
        progressBarBackground: "#25313c",//background colour of circular progress Bar
        progressBarColor: "#1462FC",//colour of circular progress bar
        progressBarWidth: 15,//progress bar width
        progressPercent: percent1,//progress percentage out of 100
        progressValue: value1,//diplay this value instead of percentage
        showText: true,//show progress text or not
    });

    $("#divProgress2").circularloader({
        backgroundColor: "#ffffff",//background colour of inner circle
        fontColor: "#000000",//font color of progress text
        fontSize: "25px",//font size of progress text
        radius: 50,//radius of circle
        progressBarBackground: "#25313c",//background colour of circular progress Bar
        progressBarColor: "#1462FC",//colour of circular progress bar
        progressBarWidth: 15,//progress bar width
        progressPercent: percent2,//progress percentage out of 100
        progressValue: value2,//diplay this value instead of percentage
        showText: true,//show progress text or not
    });
    $('#divProgress .clProg').val(value1);
    $('#divProgress2 .clProg').val(value2);
}


function goToCommentsPage() {
    var url = window.location.href
    var arr = url.split("/");
    var result = arr[0] + "//" + arr[2]
    window.location = result + '/Comments';
}

function printAccount(data, user) {
    var params = JSON.stringify(data);
    var w = window.open("/DashboardAdmin/printaccount?cuenta=" + user + "&params=" + encodeURI(params), "", "width=450,height=700");

}