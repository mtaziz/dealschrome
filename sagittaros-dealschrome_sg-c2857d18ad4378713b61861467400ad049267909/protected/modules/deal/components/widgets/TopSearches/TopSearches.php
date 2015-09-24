<?php

class TopSearches extends DealWidget {
    
    public function run() {
        
        $topsearches = TopSearch::getTopTerms(10);
        
        $output = 
        '<div class="homepage_content">
                <div class="homepage_content_title">Top Ten Searches</div>
                <ul>';
        
        $num = 1;
        foreach ($topsearches as $search) {
            $output .= "<li>{$num}. <a class=\"topten_keywords\" href=\"#\">{$search}</a></li>";
            $num ++;
        }
        
        $output .=
        '       </ul>
        </div>
        <!-- end of homepage_content -->';
        
        echo $output;

    }

}

