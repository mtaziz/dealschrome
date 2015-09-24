jQuery(document).ready(function(){
    attachDealFilterHandlers();
});

function updateViews(delay){
    update_active_menu();
    reloadmap(delay);
}

function attachDealFilterHandlers(){
    // query form
    jQuery("#query_form").submit(function(e){
        controlvars['query'] = jQuery(".query").val();
        updateViews(0);
        e.preventDefault();
        return false;
    });
        
    // categories filter
    jQuery(".all_categories_filter a").click(function(e){
        controlvars['category_raw'] = "*";
        updateViews(0);
        e.preventDefault();
        return false;
    });
    jQuery(".travel_filter a").click(function(e){
        controlvars['category_raw'] = "Travel";
        updateViews(0);
        e.preventDefault();
        return false;
    });
    jQuery(".beauty_filter a").click(function(e){
        controlvars['category_raw'] = "Beauty & Wellness";
        updateViews(0);
        e.preventDefault();
        return false;
    });
    jQuery(".eateries_filter a").click(function(e){
        controlvars['category_raw'] = "Eateries";
        updateViews(0);
        e.preventDefault();
        return false;
    });
    jQuery(".fun_filter a").click(function(e){
        controlvars['category_raw'] = "Fun & Activities";
        updateViews(0);
        e.preventDefault();
        return false;
    });
    jQuery(".goods_filter a").click(function(e){
        controlvars['category_raw'] = "Goods";
        updateViews(0);
        e.preventDefault();
        return false;
    });
    jQuery(".services_filter a").click(function(e){
        controlvars['category_raw'] = "Services & Others";
        updateViews(0);
        e.preventDefault();
        return false;
    });
        
    // discount filter
    jQuery(".all_discounts_filter a").click(function(e){
        controlvars['discount'] = "*";
        updateViews(0);
        e.preventDefault();
        return false;
    });
    jQuery(".discount_filter_above_90 a").click(function(e){
        controlvars['discount'] = "[90 TO *]";
        updateViews(0);
        e.preventDefault();
        return false;
    });
    jQuery(".discount_filter_70_90 a").click(function(e){
        controlvars['discount'] = "[70 TO 90]";
        updateViews(0);
        e.preventDefault();
        return false;
    });
    jQuery(".discount_filter_50_70 a").click(function(e){
        controlvars['discount'] = "[50 TO 70]";
        updateViews(0);
        e.preventDefault();
        return false;
    });
    jQuery(".discount_filter_below_50 a").click(function(e){
        controlvars['discount'] = "[0 TO 50]";
        updateViews(0);
        e.preventDefault();
        return false;
    });
        
    // price filter
    jQuery(".all_prices_filter a").click(function(e){
        controlvars['price'] = "*";
        updateViews(0);
        e.preventDefault();
        return false;
    });
    jQuery(".price_filter_below_10 a").click(function(e){
        controlvars['price'] = "[0 TO 10]";
        updateViews(0);
        e.preventDefault();
        return false;
    });
    jQuery(".price_filter_10_20 a").click(function(e){
        controlvars['price'] = "[10 TO 20]";
        updateViews(0);
        e.preventDefault();
        return false;
    });
    jQuery(".price_filter_20_50 a").click(function(e){
        controlvars['price'] = "[20 TO 50]";
        updateViews(0);
        e.preventDefault();
        return false;
    });
    jQuery(".price_filter_50_100 a").click(function(e){
        controlvars['price'] = "[50 TO 100]";
        updateViews(0);
        e.preventDefault();
        return false;
    });
    jQuery(".price_filter_above_100 a").click(function(e){
        controlvars['price'] = "[100 TO *]";
        updateViews(0);
        e.preventDefault();
        return false;
    });
        
    // reset button
    jQuery(".reset_filters").click(function(e){
        controlvars['price'] = '*';
        controlvars['category_raw'] = '*';
        controlvars['discount'] = '*';
        updateViews(0);
        e.preventDefault();
        return false;
    });
        
}
    
function update_active_menu(){
    jQuery(".filterlinks a").removeClass("active_menu");
    
    switch(controlvars['category_raw']){
        case "*":
            jQuery(".all_categories_filter a").addClass("active_menu");
            break;
        case "Travel":
            jQuery(".travel_filter a").addClass("active_menu");
            break;
        case "Eateries":
            jQuery(".eateries_filter a").addClass("active_menu");
            break;
        case "Fun & Activities":
            jQuery(".fun_filter a").addClass("active_menu");
            break;
        case "Beauty & Wellness":
            jQuery(".beauty_filter a").addClass("active_menu");
            break;
        case "Goods":
            jQuery(".goods_filter a").addClass("active_menu");
            break;
        case "Services & Others":
            jQuery(".services_filter a").addClass("active_menu");
            break;
        default:
            alert("something wrong in category filter");
    }
        
    switch(controlvars['price']){
        case "*":
            jQuery(".all_prices_filter a").addClass("active_menu");
            jQuery(".all_prices_filter :radio").attr('checked',true);
            break;
        case "[0 TO 10]":
            jQuery(".price_filter_below_10 a").addClass("active_menu");
            jQuery(".price_filter_below_10 :radio").attr('checked',true);
            break;
        case "[10 TO 20]":
            jQuery(".price_filter_10_20 a").addClass("active_menu");
            jQuery(".price_filter_10_20 :radio").attr('checked',true);
            break;
        case "[20 TO 50]":
            jQuery(".price_filter_20_50 a").addClass("active_menu");
            jQuery(".price_filter_20_50 :radio").attr('checked',true);
            break;
        case "[50 TO 100]":
            jQuery(".price_filter_50_100 a").addClass("active_menu");
            jQuery(".price_filter_50_100 :radio").attr('checked',true);
            break;
        case "[100 TO *]":
            jQuery(".price_filter_above_100 a").addClass("active_menu");
            jQuery(".price_filter_above_100 :radio").attr('checked',true);
            break;
        default:
            alert("error in price filter link");
    }
        
    switch(controlvars['discount']){
        case "*":
            jQuery(".all_discounts_filter a").addClass("active_menu");
            jQuery(".all_discounts_filter :radio").attr('checked',true);
            break;
        case "[0 TO 50]":
            jQuery(".discount_filter_below_50 a").addClass("active_menu");
            jQuery(".discount_filter_below_50 :radio").attr('checked',true);
            break;
        case "[50 TO 70]":
            jQuery(".discount_filter_50_70 a").addClass("active_menu");
            jQuery(".discount_filter_50_70 :radio").attr('checked',true);
            break;
        case "[70 TO 90]":
            jQuery(".discount_filter_70_90 a").addClass("active_menu");
            jQuery(".discount_filter_70_90 :radio").attr('checked',true);
            break;
        case "[90 TO *]":
            jQuery(".discount_filter_above_90 a").addClass("active_menu");
            jQuery(".discount_filter_above_90 :radio").attr('checked',true);
            break;
        default:
            alert("error in price filter link");
    }
}