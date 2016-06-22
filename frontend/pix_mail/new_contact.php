<?php
if($_POST)
{
	$language = "EN";

	include("config.php");
	include("messages.php");

	//-----------------------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------------
	$use_reCaptcha = false;
	if($secret != ""){
		$use_reCaptcha = true;
	}


	/* Install headers */
	header('Expires: 0');
	header('Cache-Control: no-cache, must-revalidate, post-check=0, pre-check=0');
	header('Pragma: no-cache');
	header('Content-Type: application/json; charset=utf-8');


	if($use_reCaptcha){
		// empty response
		$response = null;
		// grab recaptcha library
		require_once "recaptchalib.php";
		// check secret key
		$reCaptcha = new ReCaptcha($secret);
	}
	require_once('api_mailchimp/MCAPI.class.php');
	require_once('api_getresponse/GetResponseAPI.class.php');
	require_once('api_campaign/CMBase.php');
	require_once('api_aweber/aweber_api.php');
	require_once("api_activecampaign/ActiveCampaign.class.php");
	//


	//check if its an ajax request, exit if not
	if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
		//exit script outputting json data
		$output = json_encode(
		array(
			'type'=>'error', 
			'text' => 'Request must come from Ajax'
		));
		die($output);
	} 
	

	$values = array($_POST);
	$o_string = "";
	$o_string_html = "";
	$user_Email = $to_Email;
	$pix_extra = array();
	$has_type = false;
	$the_type = "";
	foreach ($values as  $value) {
		foreach ($value as $variable => $v) {
			if(filter_var($variable, FILTER_SANITIZE_STRING) == 'pixfort_form_type'){
				if(filter_var($variable, FILTER_SANITIZE_STRING) != ''){
					$the_type = $v;
					$has_type =true;
				}
			}elseif(filter_var($variable, FILTER_SANITIZE_STRING) == 'g-recaptcha-response'){
				if($use_reCaptcha){
					$response = $reCaptcha->verifyResponse(
						$_SERVER["REMOTE_ADDR"],
						$v
					);
					if ($response == null || (!$response->success)) {
						$output = json_encode(array('type'=>'error', $lang[$language]['captcha']));
						die($output);
					}
				}
			}else{
				$o_string .= filter_var($variable, FILTER_SANITIZE_STRING) . ': '. filter_var($v, FILTER_SANITIZE_STRING) ." -  \n";
				$o_string_html .= "<b>".filter_var($variable, FILTER_SANITIZE_STRING) . '</b>: '. filter_var($v, FILTER_SANITIZE_STRING) ." -  <br>";
				if(strtolower(filter_var($variable, FILTER_SANITIZE_STRING)) == 'email'){
					$user_Email = $v;
					if(!validMail($user_Email)) //email validation
					{
						$output = json_encode(array('type'=>'error', 'text' => $lang[$language]['check_email']));
						die($output);
					}
				}else{
					$pix_extra[filter_var($variable, FILTER_SANITIZE_STRING)] = filter_var($v, FILTER_SANITIZE_STRING);
				}
				// if($use_reCaptcha){
				//     if(filter_var($variable, FILTER_SANITIZE_STRING) == 'g-recaptcha-response'){
				//         $response = $reCaptcha->verifyResponse(
				//             $_SERVER["REMOTE_ADDR"],
				//             $v
				//         );
				//         if ($response == null || (!$response->success)) {
				//             $output = json_encode(array('type'=>'error', 'text' => 'Please check the Captcha!'));
				//             die($output);
				//         }
				//     }
				// }
			}
		}
	}

	$form_type = $mail_type;
	if($has_type){
		$form_type = $the_type;
	}

	if($form_type == 'ce'){
		pixmail($o_string, $user_Email, $to_Email, $subject, $language, $lang);
	}elseif($form_type == 'smtp'){
		pixsmtp($o_string_html, $user_Email, $to_Email, $subject, $language, $lang);
	}elseif($form_type == 'mc'){
		sendMailChimp($user_Email, $pix_extra, $language, $lang);
	}elseif($form_type == 'cm'){
		sendCampaign($user_Email, $pix_extra, $language, $lang);
	}elseif($form_type == 'gr'){
		sendGetResponse($user_Email, $pix_extra, $language, $lang);
	}elseif($form_type == 'aw'){
		sendAWeber($user_Email, $pix_extra, $language, $lang);
	}elseif($form_type == 'ac'){
		sendActiveCampaign($user_Email, $pix_extra, $language, $lang);
	}elseif($form_type == 'ml'){
		sendMailerLite($user_Email, $pix_extra, $language, $lang);
	}else{
		$output = json_encode(array('type'=>'error', 'text' => 'Error: Wrong mail_type attribute provided in config.php file!'));
		if($has_type){
			$output = json_encode(array('type'=>'error', 'text' => 'Error: Wrong pix-form-type attribute provided for the form!'));
		}
		die($output);
	}


} // End POST

	function pixmail($o_string, $user_Email, $to_Email, $subject, $language, $lang)
	{
		$final_msg = "\n"."Subscribe using flatpack form,"."\n";
		$final_msg .= $o_string;
		
			
		//proceed with PHP email.
		$headers = 'From: '.$user_Email.'' . "\r\n" .
		'Reply-To: '.$user_Email.'' . "\r\n" .
		'X-Mailer: PHP/' . phpversion().'' . "\r\n" .
		"Content-Type: text/html;charset=utf-8";
		
		// send mail
		$sentMail = @mail($to_Email, $subject, $final_msg, $headers);
		
		
		if(!$sentMail)
		{
			$output = json_encode(array('type'=>'error', 'text' => $lang[$language]['php_error']));
			die($output);
		}else{
			$output = json_encode(array('type'=>'message', 'text' => $lang[$language]['success']));
			die($output);
		}
	}

	function pixsmtp($o_string_html, $user_Email, $to_Email, $subject, $language, $lang)
	{
		require 'phpmailer/PHPMailerAutoload.php';

		$mail = new PHPMailer;

		$final_msg = "\n"."Subscribe using flatpack form,"."<br>";
		$final_msg .= $o_string_html;

		//$mail->SMTPDebug = 3;                               // Enable verbose debug output

		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = '';  // Specify main and backup SMTP servers (e.g. smtp.gmail.com)
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = '';                 // SMTP username
		$mail->Password = '';                           // SMTP password
		$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 465;                                    // TCP port to connect to

		$mail->setFrom($user_Email, getName($user_Email));
		$mail->addAddress($to_Email);     // Add a recipient
		//$mail->addAddress('');               // Name is optional
		$mail->addReplyTo($user_Email, 'RE Subscription');
		//$mail->addCC('cc@example.com');
		//$mail->addBCC('bcc@example.com');

		//$mail->addAttachment('attachments/book.png');         // Add attachments
		//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
		$mail->isHTML(true);                                  // Set email format to HTML

		$mail->Subject = $subject;
		$mail->Body    = $final_msg;
		$mail->AltBody = $final_msg;

		if(!$mail->send()) {
		    $output = json_encode(array('type'=>'error', 'text' => 'Mailer Error: ' . $mail->ErrorInfo));
			die($output);
		} else {
		    $output = json_encode(array('type'=>'message', 'text' => $lang[$language]['success']));
			die($output);
		}
	}

	function validMail($email)
	{
		if(filter_var($email, FILTER_VALIDATE_EMAIL)){
			return true;
		} else {
			return false;
		}
	}

	function sendMailChimp($mailSubscribe, $merge_vars=NULL, $language, $lang)
	{
		if(defined('MC_APIKEY') && defined('MC_LISTID')){
			$api = new MCAPI(MC_APIKEY);
			if($api->listSubscribe($_POST['mc_id'], $mailSubscribe, $merge_vars) !== true){
				if($api->errorCode == 214){
					$output = json_encode(array('type'=>'error', 'text' => $lang[$language]['email_exists']));
				} else {
					$output = json_encode(array('type'=>'error', 'text' => $api->errorMessage));
					//errorLog("MailChimp","[".$api->errorCode."] ".$api->errorMessage);
					die($output);
				}
			}else{
				$output = json_encode(array('type'=>'message', 'text' => $lang[$language]['subscription']));
				die($output);
			}
		}
	}


	function sendCampaign($mailSubscribe, $merge_vars=NULL, $language, $lang)
	{
		if(defined('CM_APIKEY') && defined('CM_LISTID')){
			
			$api_key = CM_APIKEY;
			$client_id = null;
			$campaign_id = null;
			$list_id = CM_LISTID;
			$cm = new CampaignMonitor( $api_key, $client_id, $campaign_id, $list_id );
			$result = $cm->subscriberAddWithCustomFields($mailSubscribe, getName($mailSubscribe), $merge_vars, null, false);
			if($result['Code'] == 0){
				$output = json_encode(array('type'=>'message', 'text' => $lang[$language]['subscription']));
				die($output);
			}else{
				$output = json_encode(array('type'=>'error', 'text' => 'Error : ' . $result['Message']));
				die($output);
			}
		}
	}

	function sendGetResponse($mailSubscribe, $merge_vars=NULL, $language, $lang)
	{
		if(defined('GR_APIKEY') && defined('GR_CAMPAIGN')){
			$api = new GetResponse(GR_APIKEY);
			
			$campaign = $api->getCampaignByName(GR_CAMPAIGN);

			$subscribe = $api->addContact($campaign, getName($mailSubscribe), $mailSubscribe, 'standard', 0, $merge_vars);
			//$firas = $api->getContacts($campaign);
			//$firas = json_decode($subscribe, true);
			 // $output = json_encode(array('type'=>'error', 'text' => 'err: '. serialize($subscribe) ));
			 // die($output);
			//if(array_key_exists('duplicated', $subscribe)){
			if($subscribe){
				$output = json_encode(array('type'=>'message', 'text' => $lang[$language]['subscription']));
				die($output);
			}else{
				$output = json_encode(array('type'=>'error', 'text' => $lang[$language]['email_exists']));
				die($output);
			}
		}
	}

	function sendAWeber($mailSubscribe, $merge_vars=NULL, $language, $lang)
	{
		if(defined('AW_AUTHCODE') && defined('AW_LISTNAME') && $merge_vars){
			$token = 'api_aweber/'. substr(AW_AUTHCODE, 0, 10);
			
			if(!file_exists($token)){
				try {
					$auth = AWeberAPI::getDataFromAweberID(AW_AUTHCODE);
					file_put_contents($token, json_encode($auth));
				} catch(AWeberAPIException $exc) {
					errorLog("AWeber","[".$exc->type."] ". $exc->message ." Docs: ". $exc->documentation_url);
					throw new Exception("Authorization error",5);
				}  
			}
			
			if(file_exists($token)){
				$key = file_get_contents($token);
			}
			list($consumerKey, $consumerSecret, $accessToken, $accessSecret) = json_decode($key);
			
			$aweber = new AWeberAPI($consumerKey, $consumerSecret);
			try {
				$account = $aweber->getAccount($accessToken, $accessSecret);
				$foundLists = $account->lists->find(array('name' => AW_LISTNAME));
				$lists = $foundLists[0];
				
				
				if(!isset($merge_vars['name'])){
					$pix_extra['name'] = getName($mailSubscribe);
				}
				$custom_arr = array();
				foreach ($merge_vars as $variable => $v) {
					if($variable != 'name'){
						$custom_arr[filter_var($variable, FILTER_SANITIZE_STRING)] = filter_var($v, FILTER_SANITIZE_STRING);
					}
				}

				$params = array(
					'email' => $mailSubscribe,
					'name' => $merge_vars['name'],
					'custom_fields' => $custom_arr
				);
			
				if(isset($lists)){
					$lists->subscribers->create($params);
					$output = json_encode(array('type'=>'message', 'text' => $lang[$language]['subscription']));
					die($output);
				} else{
					//errorLog("AWeber","List is not found");
					$output = json_encode(array('type'=>'error', 'text' => 'Error: List is not found'));
					die($output);
					//throw new Exception("Error found Lists",4);
				}
		
			} catch(AWeberAPIException $exc) {
				if($exc->status == 400){
					//throw new Exception("Email exist",2);
					$output = json_encode(array('type'=>'error', 'text' => $lang[$language]['email_exists']));
					die($output);
				}else{
					//errorLog("AWeber","[".$exc->type."] ". $exc->message ." Docs: ". $exc->documentation_url);
					$output = json_encode(array('type'=>'error', 'text' => 'Error: '."[".$exc->type."] ". $exc->message ." Docs: ". $exc->documentation_url));
					die($output);
				}
			}
		}else{
			$output = json_encode(array('type'=>'error', 'text' => 'Error: AWeber configuration Error, please check config.php settings!'));
			die($output);
		}
	}


	function sendActiveCampaign($mailSubscribe, $merge_vars=NULL, $language, $lang)
	{

		if(defined('ACTIVECAMPAIGN_URL') && defined('ACTIVECAMPAIGN_API_KEY') && defined('list_id') ){
			$ac = new ActiveCampaign(ACTIVECAMPAIGN_URL, ACTIVECAMPAIGN_API_KEY);
			if (!(int)$ac->credentials_test()) {
				$output = json_encode(array('type'=>'error', 'text' => 'Access denied: Invalid credentials (URL and/or API key).'));
				die($output);
			}
			$list_id = list_id;
			if(!isset($merge_vars['FIRSTNAME'])){
				$first_name = getName($mailSubscribe);
			}else{
				$first_name = $merge_vars['FIRSTNAME'];
			}
			if(!isset($merge_vars['LASTNAME'])){
				$last_name = "";
			}else{
				$last_name = $merge_vars['LASTNAME'];
			}
			// "CUSTOM1"            => "custom1111",
			//     "field[%CUSTOM1%,0]"  => "field value",
			$contact = array(
				"email"              => $mailSubscribe,
				"first_name"         => $first_name,
				"last_name"          => $last_name,
				"p[{$list_id}]"      => $list_id,
				"status[{$list_id}]" => 1, // "Active" status
			);
			foreach ($merge_vars as $k => $v) {
				if( strcasecmp($k, "email") && strcasecmp($k, "FIRSTNAME") && strcasecmp($k, "LASTNAME") ){
					$tkey = 'field[%'.$k.'%,0]';
				   $contact[$tkey] = $v;
				}
			}

			$contact_sync = $ac->api("contact/sync", $contact);

			if (!(int)$contact_sync->success) {
				// request failed
				$output = json_encode(array('type'=>'error', 'text' => "Syncing contact failed. Error returned: " . $contact_sync->error . " "));
				die($output);
			}
			// successful request              
			$output = json_encode(array('type'=>'message', 'text' => $lang['EN']['subscription'] ));
			die($output);
			
			
		}else{
			$output = json_encode(array('type'=>'error', 'text' => 'Error: ActiveCampaign configuration Error, please check config.php settings!'));
			die($output);
		}
	}


	function sendMailerLite($mailSubscribe, $merge_vars=NULL, $language, $lang)
	{
		if(defined('MailerLite_API_KEY') && defined('MailerLite_LIST_ID')){
			require_once 'api_mailerlite/Base/RestBase.php';
			require_once 'api_mailerlite/Base/Rest.php';
			require_once 'api_mailerlite/Subscribers.php';
			$ML_Subscribers = new MailerLite\Subscribers( MailerLite_API_KEY );
			$name = getName($mailSubscribe);
			if(isset($merge_vars['name'])){
				$name = $merge_vars['name'];
			}
			$custom_fields = array();
			foreach ($merge_vars as $k => $v) {
				if( strcasecmp($k, "email") && strcasecmp($k, "name") ){
					$custom_fields[] = array( 'name' => $k, 'value' => $v );
				}
			}
			$subscriber = array(
			    'email' => $mailSubscribe,
			    'name' => $name,
			    'fields' => $custom_fields
			);
			$subscriber = $ML_Subscribers->setId( $_POST['ml_id'] )->add( $subscriber );
			$res = json_decode($subscriber, true);
			if($res['email'] == $mailSubscribe){
				$output = json_encode(array('type'=>'message', 'text' => $lang['EN']['subscription'] ));
			}else{
				$output = json_encode(array('type'=>'error', 'text' => 'Error: MailerLite configuration Error: '. $subscriber));
			}
			die($output);
		}
	}

	function errorLog($name,$desc)
	{
		file_put_contents(ERROR_LOG, date("m.d.Y H:i:s")." (".$name.") ".$desc."\n", FILE_APPEND);
	}

	function getName($mail)
	{
		preg_match("/([a-zA-Z0-9._-]*)@[a-zA-Z0-9._-]*$/",$mail,$matches);
		return $matches[1];
	}

?>