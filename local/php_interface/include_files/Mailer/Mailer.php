<?
class MarchelloMailer
{
	protected $server = "smtp.rambler.ru";
	protected $login = "sergeykapica@rambler.ru";
	protected $password = "kermes1960";
	protected $charset = 'utf-8';
	
	public function initAndSendMail($from, $to, $subject, $text)
	{
		$header="Date: ".date("D, j M Y G:i:s")." +0700\r\n"; 
		$header.="From: =?" . $this->charset . "?Q?".str_replace("+","_",str_replace("%","=",urlencode($subject)))."?= <" . $from . ">\r\n"; 
		$header.="X-Mailer: The Bat! (v3.99.3) Professional\r\n"; 
		$header.="Reply-To: =?" . $this->charset . "?Q?".str_replace("+","_",str_replace("%","=",urlencode($subject)))."?= <" . $from . ">\r\n";
		$header.="X-Priority: 3 (Normal)\r\n";
		$header.="Message-ID: <172562218.".date("YmjHis")."@gmail.com>\r\n";
		$header.="To: =?" . $this->charset . "?Q?".str_replace("+","_",str_replace("%","=",urlencode($subject)))."?= <" . $to . ">\r\n";
		$header.="Subject: =?" . $this->charset . "?Q?".str_replace("+","_",str_replace("%","=",urlencode($subject)))."?=\r\n";
		$header.="MIME-Version: 1.0\r\n";
		$header.="Content-Type: text/html; charset=" . $this->charset . "\r\n";
		$header.="Content-Transfer-Encoding: 8bit\r\n";

		$smtp_conn = fsockopen($this->server, 587, $errno, $errstr, 10);

		$data = $this->get_data($smtp_conn);

		fputs($smtp_conn,"EHLO rambler.ru\r\n");
		$data = $this->get_data($smtp_conn);

		fputs($smtp_conn,"AUTH LOGIN\r\n");
		$data = $this->get_data($smtp_conn);

		fputs($smtp_conn,base64_encode($this->login)."\r\n");
		$data = $this->get_data($smtp_conn);

		fputs($smtp_conn,base64_encode($this->password)."\r\n");
		$data = $this->get_data($smtp_conn);

		fputs($smtp_conn,"MAIL FROM:" . $this->login . "\r\n");
		$data = $this->get_data($smtp_conn);

		fputs($smtp_conn,"RCPT TO:" . $to . "\r\n");
		$result = $data = $this->get_data($smtp_conn);

		fputs($smtp_conn,"DATA\r\n");
		$data = $this->get_data($smtp_conn);

		fputs($smtp_conn, $header."\r\n".$this->format($text)."\r\n.\r\n");
		$data = $this->get_data($smtp_conn);

		fputs($smtp_conn,"QUIT\r\n");
		$data = $this->get_data($smtp_conn);
		
		if(substr($result, 0, 3) == 250)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	protected function get_data($smtp_conn)
	{
		$data = "";

		while($str = fgets($smtp_conn,515)) 
		{
			$data .= $str;
			
			if(substr($str,3,1) == " ")
			{
				break;
			}
		}

		return $data;
	}
	
	protected function format($str)
	{
		preg_match('/<(.+?)\s.+?>/m', $str, $match);

		$str = htmlspecialcharsBX($str);

		$startPos = strpos($str, $match[1]);
		$endPos = strrpos($str, $match[1]);
		$html = substr($str, $startPos, ( $endPos - $startPos ));
	
		$html = '<' . $html . $match[1] . '>';

		return htmlspecialcharsBack($html);
	}
}
?>