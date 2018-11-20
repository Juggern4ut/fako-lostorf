<?php
/**
	* coreMailer - Weble-CMS mailer class
*/

	/**
		* Is used to easily send mails
		*
		* With the coreMailer the CMS can easily send emails using the provided functions
		* @author Lukas Meier
		* @copyright Lukas Meier
	*/
	class coreMailer{

		/**
		* The mailer-Object
		* @var PHPMailer 
		*/
		public $mail;

		/**
		* Sets all the values needed by the PHPMailer
		* @return void
		*/
		function __construct(){
			$this->mail = new PHPMailer();
			$this->mail->IsSMTP();

			include 'core/PHPMailer/mailserver.connection.php';

			$this->mail->Host = $MailServerData["host"];
			$this->mail->SMTPSecure = $MailServerData["smtpsecure"];
			$this->mail->Port = $MailServerData["port"];
			$this->mail->SMTPAuth = true;
			$this->mail->Username = $MailServerData["username"];
			$this->mail->Password = $MailServerData["password"];
			$this->mail->CharSet = $MailServerData["charset"];
			$this->mail->Sender=$MailServerData["sender"];
			$this->mail->IsHTML(true);
		}

		/**
		* Sends an Mail using the set server-connection
		*
		* @param string $to Email of the recipient
		* @param string $subject Subject of the email
		* @param string $body The html-formatted body of the email
		* @param string $from Email of the sender
		* @param string $fromname Name of the sender
		* @param array $attachments Array containing absolute paths of files that are attached to the email
		* @param array $cc Array containing all addresses recieving a carbon copy
		* @param array $bcc Array containing all addresses recieving a blind carbon copy
		* @return boolean true if the mail was sent successful, false otherwise.
		*/
		function send($to, $subject, $body, $from, $fromname = "No-Reply", $attachments = array(), $cc = array(), $bcc = array()){
			if(is_array($to)){
				foreach ($to as $t) {
					if($t != ""){
						$this->mail->AddAddress($t);
					}
				}
			}else{
				if($to != ""){
					$this->mail->AddAddress($to);
				}
			}


			if(is_array($attachments) && count($attachments) > 0){
				foreach ($attachments as $attachment) {
					$this->mail->AddAttachment($attachment);
				}
			}

			if(is_array($cc)){
				foreach ($cc as $c) {
					if($c != ""){
						$this->mail->AddCC($c);
					}
				}
			}else{
				if($cc != ""){
					$this->mail->AddCC($cc);
				}
			}
			if(is_array($bcc)){
				foreach ($bcc as $b) {
					if($b != ""){
						$this->mail->AddBCC($b);
					}
				}
			}else{
				if($bcc != ""){
					$this->mail->AddBCC($bcc);
				}
			}

			$this->mail->From = $from;
			$this->mail->FromName = $fromname;
			$this->mail->Subject = $subject;
			$this->mail->Body = $body;
			if($this->mail->send()){				
				return true;	
			} else {
				return false;
			}
		}

	}
?>