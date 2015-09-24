<?php

class PowerAdminController extends Controller {

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow', // allow authenticated users to access all actions
                'users' => array('sagittaros', 'yugene', 'yiseng'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

}