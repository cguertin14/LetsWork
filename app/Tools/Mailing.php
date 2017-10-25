<?php
namespace App\Tools;
use PHPMailer\PHPMailer;

class Mailing {
	public static function send() {
		$mail = new PHPMailer\PHPMailer(true);
		//From email address and name
		$mail->From = "from@yourdomain.com";
		$mail->FromName = "Full Name";

		//To address and name
		$mail->addAddress("ludovic.lachance@gmail.com"); //Recipient name is optional

		//Address to which recipient will reply
		$mail->addReplyTo("from@yourdomain.com", "Reply");

		//Send HTML or Plain Text email
		$mail->isHTML(true);

		$mail->Subject = "Subject Text";
		$mail->Body = "<i>Mail body in HTML</i>";
		$mail->AltBody = "This is the plain text version of the email content";

		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
			echo "Message has been sent successfully";
		}

	}
}