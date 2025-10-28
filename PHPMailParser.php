<?php
/**
 * MailParser is a PHP class that simplifies the process of sending emails using PHPMailer.
 * It allows for the use of HTML templates to generate email content.
 */
class MailParser{
	/** @var array<string, string> An array of sender email addresses. */
	private $Email_Sender 	 = Array("doc"=>"doc@xxxxx.com", "reg"=>"reg@xxxxx.com");
	/** @var array<string, string> An array of sender email passwords. */
	private $Email_Pwd 	 = Array("doc"=>"pwd_doc", "reg"=>"pwd_reg");
	/** @var string The SMTP host for the email server. */
	private $Email_Host 	 = "smtps.xxxxx.com";
	/** @var int The port number for the SMTP server. */
	private $Email_Port 	 = 465;
	/** @var PHPMailer|null An instance of the PHPMailer class. */
	private $Mail;

	/** @var string The key for the sender's email address and password. Default is "doc". */
	public $Sender 		 = "doc";
	/** @var string|null The recipient's email address. */
	public $EmailTo 	 = null;
	/** @var string|null The name of the email template to use. */
	public $EmailTemplate 	 = null;
	/** @var string|null The subject of the email. */
	public $EmailSubject	 = null;
	/** @var string|null The HTML body of the email. */
	public $EmailBody	 = null;

	/** @var array An array of variables to be replaced in the email template. */
	public $EmailVar	 = Array();

	/**
	 * MailParser constructor.
	 *
	 * @param string $ss The recipient's email address.
	 * @param string $sd The name of the email template to use.
	 */
	public function __construct($ss="", $sd="") {
		$this->EmailTo = $ss;
		$this->EmailTemplate = $sd;
	}

	/**
	 * MailParser destructor.
	 */
	public function __destruct() {
	}

	/**
	 * Sets the sender of the email.
	 *
	 * @param string $ss The key for the sender's email address and password. Default is "doc".
	 */
	public function SetSender($ss="doc"){
		$this->Sender = $ss;
	}

	/**
	 * Sets the recipient's email address.
	 *
	 * @param string|null $ss The recipient's email address.
	 */
	public function SetMailTo($ss=null){
		$this->EmailTo = $ss;
	}

	/**
	 * Sets the email template to use.
	 *
	 * @param string|null $ss The name of the email template.
	 */
	public function SetMailTemplate($ss=null){
		$this->EmailTemplate = $ss;
	}

	/**
	 * Sets the subject of the email.
	 *
	 * @param string|null $ss The subject of the email.
	 */
	public function SetMailSubject($ss=null){
		$this->EmailSubject = $ss;
	}

	/**
	 * Sets the HTML body of the email.
	 *
	 * @param string|null $ss The HTML body of the email.
	 */
	public function SetMailBody($ss=null){
		$this->EmailBody = $ss;
	}

	/**
	 * Sets the variables to be replaced in the email template.
	 *
	 * @param array $arr An array of variables.
	 */
	public function SetVariables($arr){
		$this->EmailVar = $arr;
	}

	/**
	 * Loads the email template and replaces the variables.
	 */
	private function UseTemplate(){
		if($this->EmailTemplate!=null){
			$object = file_get_contents("mailtemplate/".$this->EmailTemplate."_obj.html");
			$body = file_get_contents("mailtemplate/".$this->EmailTemplate."_body.html");
			if(($object!==false)and($body!==false)){
				$opt = substr($body,0,2);
				$body = substr($body,2);
				for($i=1;$i<=$opt;$i++){
					$g=$i;
					while(strlen($g)<2){$g="0".$g;}
					$body = str_replace("###".$g."###", $this->EmailVar[($i-1)], $body);
				}
				$this->EmailSubject = $object;
				$this->EmailBody = $body;
			}
		}
	}

	/**
	 * Sends the email.
	 *
	 * This method uses the PHPMailer library to send the email. It sets up the SMTP configuration,
	 * sender and recipient information, and the email content. If a template is specified, it will be used
	 * to generate the email body and subject.
	 *
	 * @return string Returns 'Message has been sent' on success, or an error message on failure.
	 */
	public function SEND(){
		$this->UseTemplate();
		$Mail = new PHPMailer(true);
		try {
			$Mail->isSMTP();
			$Mail->Host = $this->Email_Host;
			$Mail->SMTPAuth = true;
			$Mail->Username = $this->Email_Sender[$this->Sender];
			$Mail->Password = $this->Email_Pwd[$this->Sender];
			$Mail->SMTPSecure = 'ssl';
			$Mail->Port = $this->Email_Port;
			$Mail->SMTPOptions = array(
				'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
				)
			);
			$Mail->From = $this->Email_Sender[$this->Sender];
			$Mail->FromName = 'PHP Mail Parser';
			$Mail->addAddress($this->EmailTo);
			$Mail->isHTML(true);
			$Mail->Subject = $this->EmailSubject;
			$Mail->Body    = $this->EmailBody;
			$Mail->AltBody = $this->EmailBody;
			$Mail->send();
			return 'Message has been sent';
		} catch (Exception $e) {
			return 'Message could not be sent. Mailer Error: '.$Mail->ErrorInfo;
		}
	}
}
