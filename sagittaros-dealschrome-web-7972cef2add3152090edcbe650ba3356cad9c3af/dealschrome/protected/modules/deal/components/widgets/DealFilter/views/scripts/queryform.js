var cache_pool = []; // primary cache (slower)
var cache_prefix = {}; // secondary cache (faster)
        
var prefix_keys = []; // the key of the secondary cache 
var failed_terms = []; // a list of query term that should be ignored

(function($){
    
    Array.prototype.longest=function() {
        return this.sort(
            function(a,b) {  
                if (a.length > b.length) return -1;
                if (a.length < b.length) return 1;
                return 0
            }
            )[0];
    }
    
    $(document).ready(function(){
        
        // clear search button on query form
        $(".clear_search").on("click",function(e){
            $(".query").val('').focus();
            controlvars.query = "";
            updateViews(0);
            e.preventDefault();
            hide_jui();
            return false;
        });
        
        $('#searchpage .query').keydown(function(event){
            // if the textbox is empty
            if(jQuery(this).val().length == 1 && event.which == 8){
                hide_jui();
            }
            // if user press enter
            if(event.which == 13){
                hide_jui();
            }
        });
        
        $('#searchpage .query').autocomplete({
            
            source: function(request,response){
                if(request.term == controlvars.query) return;
                                
                spontaneous_response(request.term);
                
                if(request.term.length < 3) return;
                
                for(var i=0;i<failed_terms.length;i++){
                    if(request.term.substring(0,failed_terms[i].length) == failed_terms[i]) {
                        response([]);
                        return;
                    }
                }

                var found_prefixes = prefix_keys.filter(function(w){
                    return request.term.substring(0,w.length) == w;
                });
                
                var autocomplete_result = [];
                
                if(found_prefixes.length != 0){
                    //console.log("HIT SECONDARY CACHE");
                    autocomplete_result = cache_prefix[found_prefixes.longest()].filter(function(p){
                        return p.substring(0,request.term.length) == request.term;
                    });
                } else {
                    //console.log("HIT PRIMARY CACHE");
                    autocomplete_result = cache_pool.filter(function(m){
                        return m.substring(0,request.term.length) == request.term;
                    });
                    cache_prefix[request.term] = autocomplete_result;
                    prefix_keys.push(request.term);
                }
                                
                if(autocomplete_result.length == 0) {
                    getFromRemote(request,response);
                } else {
                    show_autocomplete(request,response,autocomplete_result);
                }

            },
            
            select: function(event, ui) {
                $("#searchpage .query").val(ui.item.value);
                $("#searchpage .query").attr('value',ui.item.value);
                $(this.form).submit();
                hide_jui();
                return true;
            },
            
            
            focus: function(event, ui) {
                if(event.which <= 1) {
                    event.preventDefault();
                    return false; //we dont want mouse over
                }
                $("input[name='query']").val(ui.item.value);
                $("#searchpage .query").attr('value',ui.item.value);
                $(this.form).submit();
                return true;
            },
            
            delay:50,
            minLength: 0
        });
        
    });  
    
    function show_autocomplete(request,response,data){ 
        var terms = filterAutocompleteSet(request,data);
        response(terms.slice(0,4));
    }
    
    function spontaneous_response(term){
        controlvars['query'] = term;
        var delay = 200;
        updateViews(delay);
    }
        
    function getFromRemote(request,response){
        $.get('/deal/search/ajaxSuggestion',request,function(data){
            eval("var result = " + data);
            if(result.length == 0 && failed_terms.indexOf(request.term) == -1){
                failed_terms.push(request.term);
            } else {
                
                // format display set
                var r = result;
                for(var i=0;i<r.length;i++){
                    r[i] = normalizeTerm(r[i]);
                }

                show_autocomplete(request,response,r);
                    
                // save into cache
                for(var j=0;j<result.length;j++){
                    if(result[j] in cache_pool == false) {
                        var t = normalizeTerm(result[j]);
                        cache_pool.push(t);
                    }
                }
            }
        });
    }
    
    function filterAutocompleteSet(request,data){
        var length = request.term.split(" ").length;
        var terms = [];
        var tokens;
        var newword;
        for(var i=0;i<data.length;i++){
            if(data[i] == request.term){
                continue;
            }
            tokens = data[i].split(" ");
            if(tokens.length >= length){
                tokens = tokens.slice(0,length+1);
                newword = tokens.join(" "); 
                if(terms.indexOf(newword) == -1){
                    // if it is not in the response list
                    terms.push(newword);
                }
            }
        }
        terms = filterStopWords(terms);
        return terms;
    }
        
    function filterStopWords(results){
        var stopwords = ["only","with","for","to","go","then","if","else","amp","or","by","&amp;"];
        var filtered = results.filter(function(r){
            var tokens = r.split(" ");
            if (stopwords.indexOf(tokens[0]) == -1 && stopwords.indexOf(tokens[1]) == -1)
                if(isNaN(Number(tokens[0])) == true && isNaN(Number(tokens[1])) == true)
                    return true;
            return false;
        });

        return filtered;
    }
    
            
    function normalizeTerm(term){
        return term.replace(" amp "," & ");
    }
    
})(jQuery);


// public functions

function hide_jui(){
    $('#searchpage .query').autocomplete("forceclose");
}
