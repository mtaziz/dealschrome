<?php

class DefaultController extends Controller{

    public function actionIndex() {
        $this->redirect(array('/deal/search'));
    }

}

