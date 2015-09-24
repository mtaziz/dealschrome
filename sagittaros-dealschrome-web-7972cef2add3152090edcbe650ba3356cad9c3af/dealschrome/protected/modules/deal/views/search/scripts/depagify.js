(function($){
    
    $(document).ready(function() {
                
        var scroll_bottom_trigger = false;
        
        var reload_timer;
            
        $(window).scroll(function(){
            clearTimeout(reload_timer);
            reload_timer = setTimeout(function(){
                loadMoreDeals(preload_actions,postload_actions);
            },1000);
        });

    });
    
    function preload_actions() {
        $('#deal_list_loading').show();
    }
        
    function postload_actions() {
        $('#deal_list_loading').hide();
    }
    
    
})(jQuery);