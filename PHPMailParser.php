<?php
class MailParser{
	private $Email_Sender 	 = Array("doc"=>"doc@xxxxx.com", "reg"=>"reg@xxxxx.com");
	private $Email_Pwd 	 	 = Array("doc"=>"pwd_doc", "reg"=>"pwd_reg");
	private $Email_Host 	 = "smtps.xxxxx.com";
	private $Email_Port 	 = 465;
	private $Mail;
	
	public $Sender 		 	 = "doc";
	public $EmailTo 		 = null;
	public $EmailTemplate 	 = null;
	public $EmailSubject	 = null;
	public $EmailBody		 = null;
	
	public $EmailVar		 = Array();
	
	public function __construct($ss="", $sd="") {
		$this->EmailTo = $ss;
		$this->EmailTemplate = $sd;
	}
	
	public function __destruct() {
	}
	
	public function SetSender($ss="doc"){
		$this->Sender = $ss;
	}
	public function SetMailTo($ss=null){
		$this->EmailTo = $ss;
	}
	public function SetMailTemplate($ss=null){
		$this->EmailTemplate = $ss;
	}
	public function SetMailSubject($ss=null){
		$this->EmailSubject = $ss;
	}
	public function SetMailBody($ss=null){
		$this->EmailBody = $ss;
	}
	public function SetVariables($arr){
		$this->EmailVar = $arr;
	}
	
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