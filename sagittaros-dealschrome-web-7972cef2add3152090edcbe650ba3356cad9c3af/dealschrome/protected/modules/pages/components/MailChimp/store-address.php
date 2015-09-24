<?php
function storeAddress(){
	
	// Validation
	if(!$_POST['email']){ return "No email address provided"; } 

	if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$/i", $_POST['email'])) {
		return "Email address is invalid"; 
	}

	require_once('MCAPI.class.php');
	// grab an API Key from http://admin.mailchimp.com/account/api/
	$api = new MCAPI('fa420eff49d20479854185e4432ee34f-us2');
	
	// grab your List's Unique Id by going to http://admin.mailchimp.com/lists/
	// Click the "settings" link for the list - the Unique Id is at the bottom of that page. 
	$list_id = "d95db04d2d";
	
	if($api->listSubscribe($list_id, $_POST['email'], $_POST['email'], 'html', false, false, true, true) === true) {
		// It worked!	
		return 'Success! Thanks for subscribing with us.';
	}else{
		// An error ocurred, return error message	
		return $api->errorMessage;
	}
	
}

// If being called via ajax, autorun the function
if($_POST['ajax']){ echo storeAddress(); }
?>
