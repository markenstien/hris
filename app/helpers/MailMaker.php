<?php
	require_once LIBS.DS.'phpmailer/vendor/autoload.php';
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	class MailMaker
	{
		private static $instance = null;

		private $phpmailer = null;
		//prevent Mailmaker from direct instanciation
		private function __construct(){

			$this->phpmailer = new PHPMailer(true);
			$this->setDefaults();
		}

		public static function getInstance()
		{
			if(self::$instance == null)
			{
				self::$instance = new MailMaker();
			}
			return self::$instance;
		}

		private function setDefaults()
		{
			$this->phpmailer->isSMTP();
			$this->phpmailer->Host       =  MAILER_AUTH['host'];
			$this->phpmailer->Port       =  587;
			$this->phpmailer->SMTPAuth   =  true;
			$this->phpmailer->SMTPSecure = 'tls';
			$this->phpmailer->Username   =  MAILER_AUTH['username'];
			$this->phpmailer->Password   =  MAILER_AUTH['password'];
			$this->phpmailer->setFrom(MAILER_AUTH['username'], MAILER_AUTH['name']);
		}
		public function setSubject($subject)
		{
			$this->phpmailer->Subject = $subject;
			return $this;
		}

		public function setBody($body)
		{
			$this->phpmailer->Body = $body;
			return $this;
		}

		/*
		*@params email reciever ,
		*@params name  optional reciever name
		**/
		public function setReciever($email , $name = '')
		{
			$this->phpmailer->addAddress($email, $name);     // Add a recipient
			return $this;
		}
		
		public function addCC($email)
		{
			if(!empty($email))
			$this->phpmailer->AddCC($email);
		}

		public function addBCC($email , $name = null)
		{
			if(!empty($email))
			$this->phpmailer->addBCC($email, $name);
		}

		public function setFrom($username , $name)
		{
			$this->phpmailer->setFrom($username, $name);
		}
		public function setReplyTo($email , $name = '')
		{
			$this->replyTo = ['email' => $email , 'name' => $name];
			return $this;
			// $this->phpmailer->addReplyTo($email , $name);
		}

		public function addAttachment($path = null, $name = null, $encoding= null , $type= null)
		{
			if(is_null($encoding)) {
				$this->phpmailer->AddAttachment($path);
			}else{
				$this->phpmailer->AddAttachment($path, $name,  $encoding , $type);
			}

			return $this;
		}
		public function send()
		{
			if(isset($this->replyTo))
			{
				$this->phpmailer->addReplyTo($this->replyTo['email'], $this->replyTo['name']);
			}else
			{
				$this->phpmailer->addReplyTo(MAILER_AUTH['replyTo'],MAILER_AUTH['replyToName']);
			}

			$this->phpmailer->isHTML(true);
			try{
				$this->phpmailer->send();
			}catch(Exception $e)
			{
				pre($this->phpmailer->ErrorInfo);
			}
			$this->phpmailer->clearAddresses();
		}


		public function sendToMany($recieverList)
		{
			$this->phpmailer->SMTPKeepAlive = true;

			foreach($recieverList as $key => $receiver)
			{
				try
				{
					$reciever = trim($receiver);

					$this->phpmailer->addAddress($receiver , $receiver);

				}catch(Exception $e)
				{
					echo 'Invalid address skipped ' .htmlspecialchars($receiver['email']) . '<hr>';
					continue;
				}
				$this->phpmailer->isHTML(true);
				try {

					$this->phpmailer->send();
				} catch (Exception $e) {
					echo "An error occured " . $e->getMessage();
					// $this->phpmailer->reset();
				}

				// reset email;
				$this->phpmailer->clearAddresses();
				// $this->phpmailer->clearAttachments();
			}
		}


	}
