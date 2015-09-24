<?php

class JsVarsExporter extends CWidget{
    
    public $varsMap;
    public $varsScript;
    
    /**
     * Usage:
     *  run this widget at html view file 
     */
    
    public function run() {
        $this->buildVars();
        $this->buildScript();
        AssetLoader::loadInline('phpvar', $this->varsScript);
    }
    
    protected function buildVars() {
        $this->varsMap = array(
            '' => '',
        );
    }
    
    protected function buildScript() {
        $this->varsScript = "";
        foreach($this->varsMap as $k=>$v) {
            $this->varsScript .= "var {$k} = '{$v}';";
        }
    }
    
    
}

