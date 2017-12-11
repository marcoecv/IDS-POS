function sorElement(parent){
    var childrens=parent.children();
    var previous=null;
    for(var i=0; i<childrens.length; i++){
	var current=childrens.eq(i);
	if(previous!=null){
	    var currentOrder=typeof(current.attr('order'))!="undefined"? parseFloat(current.attr('order')) : null;
	    var previousOrder=typeof(previous.attr('order'))!="undefined"? parseFloat(previous.attr('order')) : null;
	    
	    if(currentOrder==null)
		continue;
	    
	    if((currentOrder!=null && previousOrder==null) || currentOrder<previousOrder){
		current.insertBefore(previous);
		sorElement(parent);
		return;
	    }
	}
	previous=current;
    }
}

function sortElements(){
    $(".sort").each(function(){
	sorElement($(this));
    });
}