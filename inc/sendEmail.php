<?php

// Replace this with your own email address
$siteOwnersEmail = 'emergencyfirstaidindia@gmail.com';
echo "in PHP";
// Pear Mail Library
//require_once "Mail.php";
require 'PHPMailer/PHPMailerAutoload.php';
//echo !extension_loaded('openssl')?"Not Available":"Available";



if($_POST) {

   $name = trim(stripslashes($_POST['contactName']));
   $email = trim(stripslashes($_POST['contactEmail']));
   $subject = trim(stripslashes($_POST['contactSubject']));
   $contact_message = trim(stripslashes($_POST['contactMessage']));

	$error = '';
	
   // Check Name
	if (strlen($name) < 2) {
		$error['name'] = "Please enter your name.";
	}
	// Check Email
	if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
		$error['email'] = "Please enter a valid email address.";
	}
	// Check Message
	if (strlen($contact_message) < 15) {
		$error['message'] = "Please enter your message. It should have at least 15 characters.";
	}
   // Subject
	if ($subject == '') { $subject = "Contact Form Submission"; }


   /*// Set Message
   $message .= "Email from: " . $name . "<br />";
	$message .= "Email address: " . $email . "<br />";
   $message .= "Message: <br />";
   $message .= $contact_message;
   $message .= "<br /> ----- <br /> This email was sent from your site's contact form. <br />";

   // Set From: header
   $from =  $name . " <" . $email . ">";

   // Email Headers
	$headers = "From: " . $from . "\r\n";
	$headers .= "Reply-To: ". $email . "\r\n";
 	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

	$smtp = Mail::factory('smtp', array(
        'host' => 'ssl://smtp.gmail.com',
        'port' => '465',
        'auth' => true,
        'username' => 'orient.interplast@gmail.com',
        'password' => 'welcome2017'
    ));
	*/




   if ($error == '') {

      $mail = new PHPMailer();

		$mail->IsSMTP();
		//$mail->SMTPDebug = 3;
		$mail->SMTPAuth = true;

		$mail->CharSet="UTF-8";
		$mail->SMTPSecure = 'tls';
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 587;
		$mail->Username = 'orient.interplast@gmail.com';
		$mail->Password = 'welcome2017';
		$mail->SMTPAuth = true;
		//$mail->SMTPSecure = false;
		
		/*$host = "smtp.gmail.com";
    $port = "587";
	
		$checkconn = fsockopen($host, $port, $errno, $errstr, 5);
    if(!$checkconn){
        echo "($errno) $errstr";
    } else {
        echo 'ok';
    }
	*/
		$mail->From = $email;
		$mail->FromName = $name;
		$mail->AddAddress($siteOwnersEmail);
		$mail->AddReplyTo($email, 'Information');

		$mail->IsHTML(true);
		$mail->Subject    = $subject.' : '.$name;
		$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
		$mail->Body    = $contact_message;

		if(!$mail->Send())
		{
		  echo "Mailer Error: " . $mail->ErrorInfo;
		}
		else
		{
		  echo "Message successfully send !";
		}
/*		
// Multiple recipients
$to = 'emergencyfirstaidindia@gmail.com'; // note the comma


// Message
$message = $contact_message;

// To send HTML mail, the Content-type header must be set
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=iso-8859-1';

// Additional headers
$headers[] = 'To: EFA India <emergencyfirstaidindia@gmail>';
$headers[] = 'From: '.$name.$email;
//$headers[] = 'Cc: birthdayarchive@example.com';
//$headers[] = 'Bcc: birthdaycheck@example.com';

// Mail it
mail($to, $subject, $message, implode("\r\n", $headers));*/
		
	} # end if - no validation error

	else {

		$response = (isset($error['name'])) ? $error['name'] . "<br /> \n" : null;
		$response .= (isset($error['email'])) ? $error['email'] . "<br /> \n" : null;
		$response .= (isset($error['message'])) ? $error['message'] . "<br />" : null;
		
		echo $response;

	} # end if - there was a validation error

}

?>
