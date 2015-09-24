<?php

class DealModule extends CWebModule {

    public function init() {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        $this->setImport(array(
            'deal.models.*',
            'deal.components.*',
            'deal.components.widgets.*',
            'deal.components.widgets.DealsMap.*',
            'deal.components.widgets.HomepageTabs.*',
            'deal.components.widgets.TopSearches.*',
            'deal.components.widgets.DealFilter.*',
            'deal.components.widgets.Dealblocks.*',
            'deal.components.widgets.Mc_suite.*',
            'deal.components.DealProcessor.*',
        ));
    }

    public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        }
        else
            return false;
    }

}
