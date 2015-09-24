<?php

class DealFilter extends DealWidget {

    public $view;

    public function run() {
        switch ($this->view) {
            case "sidebar":
                $this->render('filterlinks');
                break;
            case "dropdown":
                $this->render('dropdown');
                break;
            case "layout_picker":
                $this->render("layout_picker");
                break;
            case "query_form":
                $this->render("query_form");
                break;
        }
        
        AssetLoader::load($this->viewPath.'/dealcontroller.js');
        AssetLoader::load($this->viewPath.'/scripts/queryform.js');
    }

}