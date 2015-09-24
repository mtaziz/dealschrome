<?php

class UtilitiesController extends CController {

    public function actionMailchimp() {
        if(!isset($_POST['email']) || !$_POST['email']) {
            echo "No email provided";
            $this->redirect(array('/deal/search', 'notify'=>'no_email'));
        }
        

        if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$/i", $_POST['email'])) {
            echo "Email address is invalid";
            $this->redirect(array('/deal/search', 'notify'=>'invalid_email'));
            
        }

        Yii::import('pages.components.MailChimp.MCAPI');
        $path = Yii::getPathOfAlias('pages.components.MailChimp');
        require($path . '/MCAPI.php');
        // grab an API Key from http://admin.mailchimp.com/account/api/
        $api = new MCAPI('fa420eff49d20479854185e4432ee34f-us2');

        // grab your List's Unique Id by going to http://admin.mailchimp.com/lists/
        // Click the "settings" link for the list - the Unique Id is at the bottom of that page. 
        $list_id = "d95db04d2d";

        if ($api->listSubscribe($list_id, $_POST['email'], '', 'html', false, false, true, true) === true) {
            // It worked!	
            $this->redirect(array('/deal/search', 'notify'=>'success'));
        } else {
            // An error ocurred, return error message	
            //echo $api->errorMessage;
            $this->redirect(array('/deal/search', 'notify'=>'api_error'));
        }
        
    }

}

