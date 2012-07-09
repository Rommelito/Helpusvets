<?php 

//loading wordpress functions
get_template_part( '../../../wp-load.php' );
 

define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
			
			//Check to make sure that the name field is not empty
			
			if(trim($_POST['contactname']) == '' || trim($_POST['contactname']) == "Name (required)") {
				$hasError = true;			
				$contactnameError= "Name must be filled";
				$_SESSION['contactnameError'] = true;
			} else {
				$name = trim($_POST['contactname']);
			}

					
			//Check to make sure sure that a valid email address is submitted
			if(trim($_POST['email']) == '')  {
				$hasError = true;
				$emailError= "Email must be filled";
				$_SESSION['emailError'] = $emailError;
			} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['email']))) {
				$hasError = true;
				$emailError= "Email is not valid";
			} else {
				$email = trim($_POST['email']);
			}
		
			//Check to make sure comments were entered
			if(trim($_POST['message']) == '') {
				$hasError = true;
				$messageError= "Message must be filled";
				$_SESSION['messageError'] = $messageError;
			} else {
					$comments = trim($_POST['message']);
			}
			
			if(isset($hasError)){
				$_SESSION['hasError'] = $hasError;
			}
			//If there is no error, send the email
			
			if(!isset($hasError)) {
				$subject = get_option(THEME_NAME.'_email_subject');
				$emailTo = get_option('admin_email'); //Put your own email address here
				$body = "Name: $name \n\nEmail: $email \n\n \n\nSubject: $subject \n\nComments:\n $comments";
				$headers = 'From: '.$subject.' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;
		
				mail($emailTo, $subject, $body, $headers);
				$emailSent = true;
				$messageTrue = "Your message is sent successfully";
			}
			
			
			


?>