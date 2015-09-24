<?php

class Mc_suite extends DealWidget {

    public $view;

    public function run() {
        parent::run();
        switch ($this->view) {
            case 'popper':
                $this->render('popper');
                break;
            case 'infobar':
                if (isset($_REQUEST['notify']) && $_REQUEST['notify'] == 'success') {
                    $this->render('infobar');
                }
                break;
        }
    }

}

