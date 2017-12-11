
$(document).ready(function(){
	$('[data-toggle=offcanvas]').click(function(){
		if($('.row-offcanvas-right').hasClass('active'))
			$('.row-offcanvas-right').toggleClass('active');


		if(!$('.row-offcanvas-left').hasClass('active'))
			$('html, body').animate({
	            scrollTop: 0
	        }, 400);


	  	$('.row-offcanvas-left').toggleClass('active');
	});

	$('[data-toggle=offcanvasright]').click(function(){
		if($('.row-offcanvas-left').hasClass('active'))
			$('.row-offcanvas-left').toggleClass('active');

		if(!$('.row-offcanvas-right').hasClass('active'))
			$('html, body').animate({
	            scrollTop: 0
	        }, 400);

	  	$('.row-offcanvas-right').toggleClass('active');
	});

	$(".contentWrap").click(function(){
		if($('.row-offcanvas-right').hasClass('active'))
			$('.row-offcanvas-right').toggleClass('active');

		if($('.row-offcanvas-left').hasClass('active'))
			$('.row-offcanvas-left').toggleClass('active');
	});

	var winSize = '';
	window.onresize = function (){
	    if($(this).width() >= 1200){
	        newWinSize = 'lg';
	    }else if ($(this).width() >= 992){
	        newWinSize = 'md';
	    }else if ($(this).width() >= 768){
	        newWinSize = 'sm';
	    }else{
	        newWinSize = 'xs';
	    }

	    if(newWinSize != winSize){
	        console.log('newWinSize '+newWinSize);
	        winSize = newWinSize;
	    }
	};

});