$(function(){

    $( document ).ajaxSend(function() {
        $("body").addClass("loading");
     });   
    $( document ).ajaxComplete(function() {
        $("body").removeClass("loading");
    });   
        
    $('form').submit(function(){
        $("body").addClass("loading"); 
        return true;
    });

    // alert
    $( "#alert-dialog" ).dialog({
        autoOpen: false,
        modal: true,
        height:200,
	width: 400,
        buttons: {
            OK: function() { $( this ).dialog( "close" ); }
        },
        show: "blind",
        hide: "explode"
    });
    
    // alert and reload
    $( "#alert-dialog-reload" ).dialog({
        autoOpen: false,
        modal: true,
        height:200,
	width: 400,
        buttons: {
            OK: function() { $( this ).dialog( "close" ); location.reload(); }
        },
        show: "blind",
        hide: "explode"
    });
    
});
