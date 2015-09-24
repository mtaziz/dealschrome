$("#searchpage .query").ready( function(){
    $("#searchpage .query").focus();
    $("#searchpage .query").val(page.pendingKeyPress);
    page.pendingKeyPress = "";
    attachDealFilterHandlers();
    update_active_menu();
    updateViews(0);
}); 
    
function updateViews(delay){
    update_active_menu();
    jQuery("#dealblocks_container").html("");
    controlvars.currentShown = 0;
    controlvars.offset = 0;
    controlvars.numFound = 0;
    getDeals(delay);
}

function getDeals(delay){
    clearTimeout(ajax.loadDealsTimer);
    ajax.loadDealsTimer = setTimeout(function(){
        getDealsInternal();
    },delay);
}

function getDealsInternal(){
    jQuery.get('/deal/search/ajaxload',controlvars,function(data){
        eval("var result = " + data);
        page.deals = result.docs;
        controlvars.numFound = result.numFound;
        if(controlvars.query == "" || controlvars.query == "*" || controlvars.query == "deal" || controlvars.query == "deals"){
            jQuery("#numFound").html("Found " + result.numFound + " deals");  
        } else {
            if(result.numFound == 1)
                jQuery("#numFound").html("Found " + result.numFound + " deal of " + controlvars.query); 
            else 
                jQuery("#numFound").html("Found " + result.numFound + " deals of " + controlvars.query);        
        }
        
        jQuery.each(page.deals,function(k,v){
            var node = build_deal_item(v,controlvars.layout);
            node = $(node);
            node.hide();
            jQuery("#dealblocks_container").append(node);
            node.fadeIn();
            controlvars.currentShown += 1;
        });
    });
}
    
function loadMoreDeals(preload_actions,postload_actions){
    console.log("loading more deals");
    if(ajax.loadingMoreDeals == false){
        if(controlvars.currentShown < controlvars.numFound){
            ajax.loadingMoreDeals = true;
            controlvars.offset = controlvars.currentShown;
            preload_actions();
            jQuery.get('/deal/search/ajaxload',controlvars,function(data){
                eval("var result = " + data);
                page.deals = page.deals.concat(result.docs);
                postload_actions();
                setTimeout(function(){
                    jQuery.each(result.docs,function(k,v){
                        var node = build_deal_item(v,controlvars.layout);
                        node = $(node);
                        node.hide();
                        jQuery("#dealblocks_container").append(node);
                        node.fadeIn(1000);
                        controlvars.currentShown += 1;
                    });
                    ajax.loadingMoreDeals = false;
                },0);
                
            });   
            
        }    
    }
}

function switchLayout(){
    jQuery("#dealblocks_container").html("");
    setTimeout(function(){
        jQuery.each(page.deals,function(k,v){
            var node = build_deal_item(v);
            jQuery("#dealblocks_container").append(node);
        });
    },0);
    update_active_menu();
}
    
function build_deal_item(doc){
    jQuery(".template .inject_url").attr("href", doc.url);
    jQuery(".template .inject_title_attr").attr("title",doc.title);
    jQuery(".template .inject_title").html(doc.title);
    jQuery(".template .inject_price").html("$"+doc.price);
    jQuery(".template .inject_worth").html("$"+doc.worth);
    jQuery(".template .inject_discount").html(doc.discount+"%");
    jQuery(".template .inject_savings").html("$"+doc.savings);
    jQuery(".template .inject_timeleft").html(doc.timeleft);
    var imgsrc = "/imagecache?width=210&url="+escape(doc.imgsrc);
    jQuery(".template .inject_imgsrc").attr("src", imgsrc);
    jQuery(".template .inject_dealsource").html(doc.dealsource);
    jQuery(".template a.inject_dealsource").attr("href","http://"+doc.dealsource);
    jQuery(".template .inject_description").html(doc.description);
    if(doc.bought > 0){
        jQuery(".template .inject_bought").html(doc.bought + " sold");    
    } else {
        jQuery(".template .inject_bought").html(""); 
    }
        
    return cloned_deal_item();
}
    
function cloned_deal_item(){
    var clone;
    switch(controlvars.layout){
        case "grid":
            clone = jQuery("#grid_item_template").children(".deals89_request_details").clone();
            break;
        case "list":
            clone = jQuery("#list_item_template").children(".deal_list_content").clone();
            break;
    }
    clone.removeClass("template");
    return clone;
}
    
function attachDealFilterHandlers(){
    // query form
    jQuery("#query_form").submit(function(e){
        controlvars['query'] = jQuery("#searchpage .query").val();
        updateViews(0);
        e.preventDefault();
        return false;
    });
        
    // sorting dropdown
    jQuery("#sort").change(function(){
        controlvars['sort'] = jQuery("#sort").val();
        updateViews(0);
    });
        
    // layout filter
    jQuery("#layout_filter_grid").click(function(e){
        controlvars['layout'] = "grid";
        switchLayout();
        e.preventDefault();
        return false;
    });
    jQuery("#layout_filter_list").click(function(e){
        controlvars['layout'] = "list";
        switchLayout();
        e.preventDefault();
        return false;
    });
        
    // categories filter
    jQuery(".all_categories_filter").click(function(e){
        controlvars['category_raw'] = "*";
        updateViews(0);
        e.preventDefault();
        return false;
    });
    jQuery(".travel_filter").click(function(e){
        controlvars['category_raw'] = "Travel";
        updateViews(0);
        e.preventDefault();
        return false;
    });
    jQuery(".beauty_filter").click(function(e){
        controlvars['category_raw'] = "Beauty & Wellness";
        updateViews(0);
        e.preventDefault();
        return false;
    });
    jQuery(".eateries_filter").click(function(e){
        controlvars['category_raw'] = "Eateries";
        updateViews(0);
        e.preventDefault();
        return false;
    });
    jQuery(".fun_filter").click(function(e){
        controlvars['category_raw'] = "Fun & Activities";
        updateViews(0);
        e.preventDefault();
        return false;
    });
    jQuery(".goods_filter").click(function(e){
        controlvars['category_raw'] = "Goods";
        updateViews(0);
        e.preventDefault();
        return false;
    });
    jQuery(".services_filter").click(function(e){
        controlvars['category_raw'] = "Services & Others";
        updateViews(0);
        e.preventDefault();
        return false;
    });
        
    // discount filter
    jQuery(".all_discounts_filter").click(function(e){
        controlvars['discount'] = "*";
        updateViews(0);
        e.preventDefault();
        return false;
    });
    jQuery(".discount_filter_above_90").click(function(e){
        controlvars['discount'] = "[90 TO *]";
        updateViews(0);
        e.preventDefault();
        return false;
    });
    jQuery(".discount_filter_70_90").click(function(e){
        controlvars['discount'] = "[70 TO 90]";
        updateViews(0);
        e.preventDefault();
        return false;
    });
    jQuery(".discount_filter_50_70").click(function(e){
        controlvars['discount'] = "[50 TO 70]";
        updateViews(0);
        e.preventDefault();
        return false;
    });
    jQuery(".discount_filter_below_50").click(function(e){
        controlvars['discount'] = "[0 TO 50]";
        updateViews(0);
        e.preventDefault();
        return false;
    });
        
    // price filter
    jQuery(".all_prices_filter").click(function(e){
        controlvars['price'] = "*";
        updateViews(0);
        e.preventDefault();
        return false;
    });
    jQuery(".price_filter_below_10").click(function(e){
        controlvars['price'] = "[0 TO 10]";
        updateViews(0);
        e.preventDefault();
        return false;
    });
    jQuery(".price_filter_10_20").click(function(e){
        controlvars['price'] = "[10 TO 20]";
        updateViews(0);
        e.preventDefault();
        return false;
    });
    jQuery(".price_filter_20_50").click(function(e){
        controlvars['price'] = "[20 TO 50]";
        updateViews(0);
        e.preventDefault();
        return false;
    });
    jQuery(".price_filter_50_100").click(function(e){
        controlvars['price'] = "[50 TO 100]";
        updateViews(0);
        e.preventDefault();
        return false;
    });
    jQuery(".price_filter_above_100").click(function(e){
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
    
    jQuery(".grid_list").hide();
    
    switch(controlvars.layout){
        case "grid":
            jQuery("#layout_filter_grid_active").show();
            jQuery("#layout_filter_list").show();
            break;
        case "list":
            jQuery("#layout_filter_list_active").show();
            jQuery("#layout_filter_grid").show();
            break;
    }
    
    switch(controlvars['category_raw']){
        case "*":
            jQuery(".all_categories_filter").addClass("active_menu");
            break;
        case "Travel":
            jQuery(".travel_filter").addClass("active_menu");
            break;
        case "Eateries":
            jQuery(".eateries_filter").addClass("active_menu");
            break;
        case "Fun & Activities":
            jQuery(".fun_filter").addClass("active_menu");
            break;
        case "Beauty & Wellness":
            jQuery(".beauty_filter").addClass("active_menu");
            break;
        case "Goods":
            jQuery(".goods_filter").addClass("active_menu");
            break;
        case "Services & Others":
            jQuery(".services_filter").addClass("active_menu");
            break;
        default:
            alert("something wrong in category filter");
    }
        
    switch(controlvars['price']){
        case "*":
            jQuery(".all_prices_filter").addClass("active_menu");
            break;
        case "[0 TO 10]":
            jQuery(".price_filter_below_10").addClass("active_menu");
            break;
        case "[10 TO 20]":
            jQuery(".price_filter_10_20").addClass("active_menu");
            break;
        case "[20 TO 50]":
            jQuery(".price_filter_20_50").addClass("active_menu");
            break;
        case "[50 TO 100]":
            jQuery(".price_filter_50_100").addClass("active_menu");
            break;
        case "[100 TO *]":
            jQuery(".price_filter_above_100").addClass("active_menu");
            break;
        default:
            alert("error in price filter link");
    }
        
    switch(controlvars['discount']){
        case "*":
            jQuery(".all_discounts_filter").addClass("active_menu");
            break;
        case "[0 TO 50]":
            jQuery(".discount_filter_below_50").addClass("active_menu");
            break;
        case "[50 TO 70]":
            jQuery(".discount_filter_50_70").addClass("active_menu");
            break;
        case "[70 TO 90]":
            jQuery(".discount_filter_70_90").addClass("active_menu");
            break;
        case "[90 TO *]":
            jQuery(".discount_filter_above_90").addClass("active_menu");
            break;
        default:
            alert("error in price filter link");
    }
}    
