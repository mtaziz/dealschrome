// this script is initiated in homepage

var controlvars = {
    'query': '*',
    'price': '*',
    'discount': '*',
    'category_raw': '*',
    'sort': 'bought desc',
    'rows': 32,
    'offset': 0,
    'layout': 'grid',
    'numFound' : 0,
    'currentShown' : 0,
    'loading' : false
};

var page = {
    'pendingKeyPress':'',
    'loadingAjax':false,
    'deals':[]
};

var ajax = {
    'loadingPage':false,
    'loadSearchPageTimer':null,
    'loadSearchPageTimerInternal':null,
    'loadDealsTimer':null,//unused
    'loadingMoreDeals':false
}

var updateViews = function(){};

(function($){
    
    $(document).ready(function(){
        
        $(".query:not(#searchpage .query)").focus();
        
        $(".query:not(#searchpage .query)").on('keypress', function(event){
            page.pendingKeyPress += String.fromCharCode(event.which).toLowerCase();
            if(ajax.loadingPage){
                return;
            }
            clearTimeout(ajax.loadSearchPageTimer);
            ajax.loadSearchPageTimer = setTimeout(function(){
                
                page.goToSearchPage(); 
                
            },0);
            
            
        });
        
        $("body").on('click',".topten_keywords",function(e){
            page.reset_controlvars();
            controlvars.query = $(this).text();
            page.goToSearchPage();
            updateViews(0);
            e.preventDefault();
            return false;
        });
        
        $("body").on('click', ".goToHome", function(e){
            e.preventDefault();
            page.goToHomePage();
            return false;
        });
        
        $("body").on('click', ".goToSearch", function(e){
            e.preventDefault();
            page.goToSearchPage();
            return false;
        });
        
        $("body").on('click', ".goToNewSearch", function(e){
            e.preventDefault();
            controlvars.query = "*";
            page.goToSearchPage();
            updateViews(0);
            return false;
        });
        
        $("body").on('click', ".homepage_search_button", function(e){
            e.preventDefault();
            page.goToSearchPage();
            return false;
        });

    });
    
    page.reset_controlvars = function(){
        controlvars = {
            'query': '*',
            'price': '*',
            'discount': '*',
            'category_raw': '*',
            'sort': 'bought desc',
            'rows': 32,
            'offset': 0,
            'layout': 'grid',
            'numFound' : 0,
            'currentShown' : 0,
            'loading' : false
        };
    }
    
    page.goToSearchPage = function(){        
        if($('#searchpage').length > 0){
            $(".pages").hide();
            $('#searchpage').show();
            $('html, body').animate({
                scrollTop: '0px'
            }, 500);
            var orig = $(".query:not(#searchpage .query)").val();
            $("#searchpage .query").val(orig);
            $("#searchpage .query").focus();
        } else {
            ajax.loadingPage = true;
            setTimeout(function(){
                $.get("/deal/search/ajaxFullBody", {}, function(data){
                    $(".pages").hide();
                    $('body').append(data);
                    $("#searchpage .query").focus();
                    ajax.loadingPage = false;
                }, 'html');
            },0);
        }
    }

    page.goToHomePage = function(){
        $(".pages").hide();
        hide_jui();
        $("#homepage").show();
        $(".query:not(#searchpage .query)").val("");
        $(".query:not(#searchpage .query)").focus();
    }
    
})(jQuery);

