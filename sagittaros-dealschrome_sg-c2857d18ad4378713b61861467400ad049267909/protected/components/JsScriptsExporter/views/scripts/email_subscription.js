$(document).ready(function() {

    if(!($.cookie('dealschrome_email_subscription') == 'subscribed')){
       
        var id = $("#popper-wrapper");
        $("#popper-wrapper").fadeIn(500);		             
        $('#overlay_background').fadeIn(600);
        //$('#hide').fadeTo("slow",0.6);           
        
        $.cookie('dealschrome_email_subscription', 'subscribed', {
            expires: 60
        })
   
    }
	 

    //if close button is clicked
    $('.deals-popup-close-button').click(function (e) {
        //Cancel the link behavior
        e.preventDefault();
        $('#overlay_background, #popper-wrapper').fadeOut(800);
    });

});
   
