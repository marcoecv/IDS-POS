//store data in a cookie
function createCookie(name, value, days){

    if(days){
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        var expires = "; expires=" + date.toGMTString();
    }
    else
        var expires = "";
    document.cookie = name + "=" + value+expires + "; path=/";
}

function moveScrollTop(){ 
    $('body').animate({
        scrollTop: 0
    }, 400);
}

function setMyOffCanvas(){
    var winSize=getCurrentSize();
    if( winSize=='xs' /*|| winSize=='sm'*/)
	$(".myOffCanvas").addClass('collapsed');
    else
	$(".myOffCanvas").removeClass('collapsed');
}

function closeMenusHeader() {
    $("#navbar").removeClass('in');
    $("#userbar").removeClass('in');
    $("#myOffCanvas").removeClass('activeLeft');
}

var winSize = '';
$(document).ready(function(){
    setMyOffCanvas();
    window.onresize = function(){
        var newWinSize = getCurrentSize();
        if(newWinSize != winSize){
            setMyOffCanvas();
            winSize = newWinSize;
        }
    };

    $(".mainMenu a").click(function(){
        $("#navbar").removeClass('in');
    });
    
    $("button[data-target='#userbar']").click(function(){
        //$("#navbar").hide();
        $("#navbar").removeClass('in');
        $("#myOffCanvas").removeClass('activeLeft');
    });
    
    $("button[data-target='#navbar']").click(function(){
        $("#userbar").removeClass('in');
        $("#myOffCanvas").removeClass('activeLeft');
    });
    
    $(".toggle-myOffCanvas").click(function(){
        $("#navbar").removeClass('in');
        $("#userbar").removeClass('in');
        
        var winSize=getCurrentSize();
        var currentView = "center";
        
        
        var target=$(this).attr('target');
        var side=$(this).attr('side');
    
        $(".toggle-myOffCanvas").removeClass("btn-success");
        $(".toggle-myOffCanvas").addClass("btn-primary");
    
        if(side=='left'){
            if($(target).hasClass('activeLeft')){
                currentView = "center";
                $(target).removeClass('activeLeft');
            }
            else{
                currentView = side;
                $(this).addClass("btn-success");
                $(target).addClass('activeLeft');
                moveScrollTop();
            }
            
            $(target).removeClass('activeRight');
        }
    
        if(side=='right'){
            if($(target).hasClass('activeRight')){
                currentView = "center";
                $(target).removeClass('activeRight');
            }
            else{
                currentView = side;
                $(this).addClass("btn-success");
                $(target).addClass('activeRight');
                moveScrollTop($("body"));
            }
            $(target).removeClass('activeLeft');
        }
        
        if( winSize=='xs'){
            createCookie('selectedSideCanvas', currentView, '');
        }
        else{
            createCookie('selectedSideCanvas', '', '');
        }
    });

    $(".myOffCanvas .center").click(function (){
        $(this).parents(".myOffCanvas").removeClass('activeLeft');
        $(this).parents(".myOffCanvas").removeClass('activeRight');
    });
});

