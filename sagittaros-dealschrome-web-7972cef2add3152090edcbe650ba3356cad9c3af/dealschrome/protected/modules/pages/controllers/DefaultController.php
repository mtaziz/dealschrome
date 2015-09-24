<?php

class DefaultController extends Controller {

    public $layout = '//layouts/html';

    public function actionIndex() {
        $this->render('index');
    }

    public function actionFaq() {
        $this->pageTitle = "Dealschrome - Frequently Asked Question";
        $this->render('page_faq');
    }

    public function actionPrivacy() {
        $this->pageTitle = "Dealschrome - Privacy Policy";
        $this->render('page_privacy');
    }

    public function actionAboutUs() {
        $this->pageTitle = "Dealschrome - About Us";
        $this->render('page_about_us');
    }

    public function actionContactUs() {
        $this->pageTitle = "Dealschrome - Contact Us";
        
        $hasError = false;
        $emailSent = false;
        
        //If the form is submitted
        if (isset($_POST['submit'])) {
            
            //Check to make sure that the name field is not empty
            if (trim($_POST['name']) == '') {
                $hasError = true;
            } else {
                $name = trim($_POST['name']);
            }

            //Check to make sure sure that a valid email address is submitted
            $emailvalidator = new CEmailValidator();
            if (trim($_POST['email']) == '') {
                $hasError = true;
            } else if (!$emailvalidator->validateValue(trim($_POST['email']))) {
                $hasError = true;
            } else {
                $email = trim($_POST['email']);
            }

            //Check to make sure that the subject field is not empty
            if (trim($_POST['dealsite_name']) == '') {
                $hasError = true;
            } else {
                $dealsite_name = trim($_POST['dealsite_name']);
            }


            //Check to make sure that the subject field is not empty
            if (trim($_POST['dealsite_link']) == '') {
                $hasError = true;
            } else {
                $dealsite_link = trim($_POST['dealsite_link']);
            }


            //Check to make sure that the subject field is not empty
            if (trim($_POST['operating_city']) == '') {
                $hasError = true;
            } else {
                $operating_city = trim($_POST['operating_city']);
            }


            //Check to make sure comments were entered
            if (trim($_POST['message']) == '') {
                $hasError = true;
            } else {
                if (function_exists('stripslashes')) {
                    $message = stripslashes(trim($_POST['message']));
                } else {
                    $message = trim($_POST['message']);
                }
            }

            //If there is no error, send the email
            if (!$hasError) {
                $emailTo = 'support@dealschrome.com'; //Put your own email address here
                $body = "Name: $name \n\nEmail: $email \n\nDeal Site Name: $dealsite_name\n\nDeal Site Link: $dealsite_link\n\nOperating City: $operating_city \n\nMessages: $message";
                $headers = 'From: My Site <' . $emailTo . '>' . "\r\n" . 'Reply-To: ' . $email;

                $emailSent = mail($emailTo, 'DealsChrome enquiry', $body, $headers);
            }
        } 
        $this->render('page_contact_us', array(
            'hasError' => $hasError,
            'emailSent' => $emailSent,
        ));
    }

    public function actionTerms() {
        $this->pageTitle = "Dealschrome - Terms and Condition";
        $this->render('page_terms');
    }

}