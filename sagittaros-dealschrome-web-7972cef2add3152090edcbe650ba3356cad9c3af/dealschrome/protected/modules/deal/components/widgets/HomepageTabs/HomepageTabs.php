<?php

class HomepageTabs extends DealWidget {

    public function run() {
        AssetLoader::load($this->viewPath . '/organictabs.jquery.js');
        AssetLoader::loadInline('homepagetabs', $this->getWidgetJs());
        $query_options = array(
            'sort' => array('bought desc'),
            'fq' => array(
                'expiry:['.  time() .' TO *]',
            ),
        );
        $mostWanted = $this->renderDealList($query_options);
        $query_options = array(
            'sort' => array('bought desc'),
            'fq' => array(
                'category_raw:Eateries',
                'expiry:['.  time() .' TO *]',
            ),
        );
        $mostWantedFood = $this->renderDealList($query_options);
        $query_options = array(
            'sort' => array('bought desc'),
            'fq' => array(
                'category_raw:Travel',
                'expiry:['.  time() .' TO *]',
            ),
        );
        $mostWantedTravel = $this->renderDealList($query_options);
        $query_options = array(
            'sort' => array('bought desc'),
            'fq' => array(
                'category_raw:"Beauty & Wellness"',
                'expiry:['.  time() .' TO *]',
            ),
        );
        $mostWantedBeauty = $this->renderDealList($query_options);
        
        $query_options = array(
            'sort' => array('bought desc'),
            'fq' => array(
                'category_raw:"Fun & Activities"',
                'expiry:['.  time() .' TO *]',
            ),
        );
        $mostWantedFun = $this->renderDealList($query_options);
        
        $this->render('HomepageTabs', array(
            'mostWanted' => $mostWanted,
            'mostWantedFood' => $mostWantedFood,
            'mostWantedTravel' => $mostWantedTravel,
            'mostWantedBeauty' => $mostWantedBeauty,
            'mostWantedFun' => $mostWantedFun,
        ));
    }

    protected function renderDealList($query_options) {
        $solr = new DealModel;
        $query = '*:*';
        $rows = 10;
        $offset = 0;

        try {
            $solr_result = $solr->query($query, $query_options, $rows, $offset);
        } catch (Exception $e) {
            $solr_result = NULL;
            echo $e->getMessage();
        }
        $dealblocks = '';
        if ($solr_result->numFound) {
            foreach ($solr_result->docs as $doc) {
                $doc = DealProcessor::process($doc);
                $description = $doc->description;
                $dealblocks .= $this->render("TopDealBlock", array(
                    'doc' => $doc,
                    'description' => $description,
                        ), TRUE);
            }
        }
        return $dealblocks;
    }

    private function getWidgetJs() {
        $script = '
        jQuery(function() {               
            jQuery(".homepage_navi").organicTabs({
                "speed": 150
            });
    
        });
        ';
        return $script;
    }

}