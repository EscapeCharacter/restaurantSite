<?php 
	define('TITLE', 'Franklin\'s Fine Dining');

	include('includes/header.php');
?>

	<div id="contact">
		<hr>

		<h1>Get in touch with us!</h1>

		<?php

			// Check for header injection
			function hasHeaderInjection($str) {
				return preg_match("/[\r\n]/", $str);
			}

			if(isset($_POST['contact_submit'])) {

				$name 	= trim($_POST['name']);
				$email 	= trim($_POST['email']);
				$msg 	= $_POST['message'];

				// Check to see if $name or $email have header injections
				if(hasHeaderInjection($name) || hasHeaderInjection($email)) {
					die(); // If true, kill the script
				}

				if(!$name || !$email || !$msg) {
					echo "<h4 class='error'>All fields required.</h4><a href='contact.php' class='button block'>Go back and try again</a>";
					exit;
				}

				// Add recipient email to a variable
				$to = "sagiv.lapkin@gmail.com";
				// Create a subject
				$subject = "$name sent you a message via your contact form";
				// Construct the message
				$message = "Name: $name\r\n";
				$message .= "Email: $email\r\n";
				$message .= "Message:\r\n$msg";

				// If subscribe checkbox was checked...
				if(isset($_POST['subscribe']) && $_POST['subscribe'] == 'subscribe') {
					// Add new line to the message
					$message .= "\r\n\r\nPlease add $email to the mailing list.\r\n";
				}

				$message = wordwrap($message, 72);

				// Set up mail headers into a variable

				$headers = "MIME-Version 1.0\r\n";
				$headers .= "Content-type: text/plain; charset=ios-8859-1\r\n";
				$headers .= "From: $name <$email>\r\n";
				$headers .= "X-Priority: 1\r\n";
				$headers .= "X-MSMail-Priority: High\r\n\r\n";

				// Send the email
				mail($to, $subject, $message, $headers);
			

		?>

		<!-- Show success message after email has sent-->
		<h5>Thanks for contacting Franklin's!</h5>
		<p>Please allow 24 hours for a response</p>
		<p><a href="/final" class="button block">&laquo; Go to the Home Page</a></p>


		<?php } else { ?>

		<form action="" method="post" id="contact-form">

			<label for="name">Your name</label>
			<input type="text" name="name" id="name">

			<label for="email">Your email</label>
			<input type="text" name="email" id="email">

			<label for="message">and your message</label>
			<textarea name="message" id="message"></textarea>

			<input type="checkbox" name="subscribe" id="subscribe" value="subscribe">
			<label for="subscribe">Subscribe to newsletter</label>

			<input type="submit" class="button next" name="contact_submit" value="Send Message">
			
		</form>

		<?php } ?>

		<hr>
	</div>

<?php 
	include('includes/footer.php');

?>