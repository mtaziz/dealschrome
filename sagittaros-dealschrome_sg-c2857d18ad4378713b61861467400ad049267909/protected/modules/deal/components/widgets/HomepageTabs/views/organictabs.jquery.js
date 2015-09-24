(function($) {

    $.organicTabs = function(el, options) {
    
        var base = this;
        base.$el = $(el);
        base.$nav = base.$el.find(".navi-organic");
                
        base.init = function() {
        
            base.options = $.extend({},$.organicTabs.defaultOptions, options);
            
            // Accessible hiding fix
            $(".hide").css({
                "position": "relative",
                "top": 0,
                "left": 0,
                "display": "none"
            }); 
            
            base.$nav.delegate("li > a", "click", function() {
                
                var curList;
                
                if($(this).attr('href') == '#gmap'){
                    $("#gmap").css({'display':'block'});
                    $("#map_canvas").css({'width':'940px', 'height':'500px'});
                    window.rungmap();
                }
                
                if($.find(".navi-organic a.current").length == 0){
                    
                    $newList2 = $(this);
                    $newList2.addClass("current");
                    base.$el.find(".list-wrap").addClass("list-wrap-border");
                    
                    curList = base.$el.find("a.current").attr("href").substring(1);
                    $newList = $(this),               
                                     
                    // Figure out ID of new list
                    listID = $newList.attr("href").substring(1);                 
                    
                    base.$el.find("#"+listID).fadeIn("2000", function(){                                                    
                        
                        });
                        
                    $('html, body').animate({
                        scrollTop: '390px'
                    }, 500);  
                    return false; // this is to stop the windows scrolling down

                }
                
                else {
                                        
                    // Figure out current list via CSS class
                    curList = base.$el.find("a.current").attr("href").substring(1),
                
                    // List moving to
                    $newList = $(this),
                    
                    
                    // Figure out ID of new list
                    listID = $newList.attr("href").substring(1),
                
                    // Set outer wrapper height to (static) height of current inner list
                    $allListWrap = base.$el.find(".list-wrap"),
                    curListHeight = $allListWrap.height();
                    $allListWrap.height(curListHeight);
                                        
                    if ((listID != curList) && ( base.$el.find(":animated").length == 0)) {
                                            
                        // Fade out current list
                        base.$el.find("#"+curList).fadeOut(base.options.speed, function() {
                        
                            // Fade in new list on callback
                            base.$el.find("#"+listID).fadeIn(base.options.speed);
                        
                            // Adjust outer wrapper to fit new list snuggly
                            var newHeight = base.$el.find("#"+listID).height();
                            $allListWrap.animate({
                                height: newHeight
                            });
                        
                            // Remove highlighting - Add to just-clicked tab
                            base.$el.find(".navi-organic li a").removeClass("current");
                            $newList.addClass("current");
                            
                        });                                    
                    }   
                    $('html, body').animate({
                        scrollTop: '390px'
                    }, 500);
                    // Don't behave like a regular link
                    // Stop propegation and bubbling
                    return false;
                } // end of else;
            });
            
        };
        
        base.init();
        
    };
    
    
    $.organicTabs.defaultOptions = {
        "speed": 300
    };
    
    $.fn.organicTabs = function(options) {
        return this.each(function() {
            (new $.organicTabs(this, options));
        });
    };
    
    
    
})(jQuery);