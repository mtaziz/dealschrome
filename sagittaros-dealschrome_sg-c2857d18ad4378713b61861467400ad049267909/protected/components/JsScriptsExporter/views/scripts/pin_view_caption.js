
$(document).ready(function() {
    var $container = $('#dealblocks_container');

    $container.imagesLoaded( function(){
        $container.masonry({
            itemSelector : '.box_pin'
        });
    });
});

$(document).ready(function() {
 
 
    //On mouse over those thumbnail
    $('.box_pin').hover(function() {                         
        //Display the caption
        $(this).find('div.pin_caption').stop(false,true).fadeIn(100);
    },
    function() {
      
        //Hide the caption
        $(this).find('div.pin_caption').stop(false,true).fadeOut(100);
    });
 
});
