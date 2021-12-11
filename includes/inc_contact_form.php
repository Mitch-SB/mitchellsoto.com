
<?php
	
function validateInput($data, $fieldName) {
	global $errorCount;
	if (empty($data)){
		echo "\"$fieldName\" is a required field.<br />\n";
		++$errorCount;
		$retval = "";
	} else { //Only clean up input if it isn't empty
		$retval = trim($data);
		$retval = stripslashes($retval);
	}
	return($retval);
}

function validateEmail($data, $fieldName) {
	global $errorCount;
	if (empty($data)){
		echo "\"$fieldName\" is a required field.<br />\n";
		++$errorCount;
		$retval = "";
	} else {
		$retval = trim($data);
		$retval = stripslashes($retval);
		$pattern = "/^[\w-]+(\.[\w-]+)*@" . "[\w-]+(\.[\w-]+)*" . "(\.[[a-z]]{2,})$/i";
		
		if (!filter_var($retval, FILTER_VALIDATE_EMAIL)) {
			echo "\"$fieldName\" is not a valid e-mail address.<br />\n"; 
			++$errorCount;
		
		}
	}
	return($retval);
}

function displayForm($sender, $email, $subject, $message) {	
?>

<form name="contact" action="" method="post">
	<fieldset>            
		<legend><h2>Contact Me</h2></legend>
		<div class="form-group">
			<p><label for="Name">Name:</label>
			<input class="form-control" type="text" placeholder="Name" name="sender" value="<?php 
	echo $sender; ?>" /></p>
		</div>
		<div class="form-group">
			<label for="email">Email:</label>
			<input class="form-control" type="text" placeholder="Email Adress" name="email" value="<?php 
	echo $email; ?>" />
		</div>
		<div class="form-group">
			<label for="subject">Subject:</label>
			<input class="form-control" type="text" placeholder="Subject" name="subject" value="<?php 
	echo $subject; ?>" />
		</div>   
		<div class="form-group">
			<label for="message">Message</label>
			<textarea class="form-control" rows="5" placeholder="Message" name="message"><?php echo $message; ?></textarea>
		</div>
		<div class="g-recaptcha" data-sitekey="Site Key"></div>
		<br/>             

		<input class="btn btn-secondary" type="reset" value="Clear" />
		<input class="btn btn-primary" type="submit" name="Submit" value="Send" />            
	</fieldset>            
</form>

<?php

}
$showForm = true;
$errorCount = 0;
$sender = "";
$emailTo = "email@domain.com";
$email = "";
$subject = "";
$message = "";

if (isset($_POST['Submit']) && $_POST['g-recaptcha-response'] != "") {
	$sender = validateInput($_POST['sender'],"Your Name");
	$email = validateEmail($_POST['email'],"Your E-mail");
	$subject = validateInput($_POST['subject'],"subject");
	$message = validateInput($_POST['message'],"message");

	$secret = 'Secret key';
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
    $responseData = json_decode($verifyResponse);
	
	if ($errorCount==0 && $responseData->success)
		$showForm = false;
	else
		$showForm = true;
}

$emailMessage = "Form details below.\n\n";

function clean_string($string){
	$invalid_characters = array("content-type", "bcc:", "to:", "cc:", "href");
	return str_replace($invalid_characters, "", $string);
}

$emailMessage .= "Name: " . clean_string($sender) . "\n";
$emailMessage .= "Email: " . clean_string($email) . "\n";
$emailMessage .= "Message: " . clean_string($message) . "\n";

if ($showForm == true) {
	if ($errorCount>0) //if there WERE errors
		echo "<p>Please re-enter your information below.</p>\n";
	displayForm($sender, $email, $subject, $message);
} else {
	$headers = 'From: ' . $email . "\r\n" . 
	'CC: ' . $email . "\r\n" .
	'Reply-To: ' . $email . "\r\n" . 
	'X-Mailer: PHP/' . phpversion();
	
	if (mail($emailTo, $subject, $emailMessage, $headers))
		echo "<p>Your message has been sent! Thank you, " . $sender . ".</p>\n";
	else
		echo "<p>There was an error sending your message, " . $sender . ". Please try again.</p>\n";
}

?>
