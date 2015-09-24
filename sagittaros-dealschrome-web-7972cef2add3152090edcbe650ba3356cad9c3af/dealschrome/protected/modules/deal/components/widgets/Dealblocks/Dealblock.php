<?php

class Dealblocks extends DealWidget {

    public $solr_result;
    public $register_script;
    public $layout;
    public $termSuggestion; // used in empty_deal view when no deals can be found
    public $highlighting;

    public function run() {

        if ($this->register_script) {
            $this->script_init();
        }

        if (!$this->solr_result) {
            echo "Deal block has not been initialized";
            return;
        }

        $dealblocks = '';
        if ($this->solr_result->numFound) {
            foreach ($this->solr_result->docs as $doc) {
                $doc = DealProcessor::process($doc);
                $vars = array(
                    'doc' => $doc,
                    'has_highlighting' => ($this->highlighting) ? TRUE : FALSE,
                    'highlighting' => ($this->highlighting) ? $this->highlighting->{$doc->id} : NULL,
                );
                $dealblocks .= $this->render("{$this->layout}_item", $vars, TRUE);
            }
        } else {
            $dealblocks = $this->render('empty_deal', array('suggestion' => $this->termSuggestion), TRUE);
        }

        echo $dealblocks;
    }

    protected function script_init() {
        // http://jscompress.com/
        AssetLoader::load($this->viewPath . '/scripts/depagify.js');
        AssetLoader::load($this->viewPath . '/scripts/gobacktop_button.js');
        
    }

}

