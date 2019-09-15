<?
session_start();
require_once('include_files/Mailer/Mailer.php');

function custom_mail($to, $subject, $message, $additional_headers = '', $additional_parameters = '')
{
	if($adminUser = CUser::GetByLogin('sergeykapica'))
	{
		$data = $adminUser->fetch();
		
		$mailer = new MarchelloMailer;
		$send = $mailer->initAndSendMail($data['EMAIL'], $to, $subject, $message);
		
		if(!$send)
		{
			echo false;
		}
		else 
		{
			echo true;
		}
		
		return true;
	}
}

/*AddEventHandler('main', 'OnBeforeUserLogin', 'beforeAuthorizate');

function beforeAuthorizate()
{
	$captchaObject = new CMain;
	
	if(!$captchaObject->CaptchaCheckCode(htmlspecialcharsEx($_POST["captcha_word"]), htmlspecialcharsEx($_POST["captcha_sid"])))
	{
		$backUrl = htmlspecialcharsBX($_POST['backurl']);
		
		header('Location: ' . $backUrl . '?captcha_failed=1');
		die();
	}
}*/
?>