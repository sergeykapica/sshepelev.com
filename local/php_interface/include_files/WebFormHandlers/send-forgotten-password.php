<?
session_start();
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");
require_once($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include_files/CheckObject/CheckObject.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include_files/GenerateCode/GenerateCode.php');

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$backUrl = htmlspecialcharsBX($_POST['backurl']);
	$userEmail = htmlspecialcharsBX($_POST['USER_EMAIL']);
	$emailField = CheckObjectNamespace\CheckObject::checkEmail($userEmail);
	
	if($emailField->SelectedRowsCount() <= 0)
	{
		header('Location: ' . $backUrl . '?undefined_email=1');
		die();
	}
	else
	{
		if($userData = $emailField->Fetch())
		{
			$newPassword = GenerateCodeNamespace\GenerateCode::generateNewPassword(8);
			$newPassword[0] = strtoupper($newPassword[0]);
			
			if(!preg_match('/\d+/', $newPassword))
			{
				$newPassword .= 7;
			}
			
			$updateUserToDB = new CUser;
			
			$updateFields = array(
				'PASSWORD' => $newPassword,
				'CONFIRM_PASSWORD' => $newPassword
			);
			
			$res = $updateUserToDB->Update($userData['ID'], $updateFields);
			
			if($res)
			{
				$_SESSION['BACK_URL'] = $backUrl;
				
				$arFields = array(
					'USER_NAME' => $userData['NAME'],
					'NEW_PASSWORD' => $newPassword,
					'EMAIL_TO' => $userEmail
				);
					
				$send = CEvent::Send("FORGOTTEN_PASSWORD", SITE_ID, $arFields, 'N', '');
				CEvent::CheckEvents();
				
				if($send)
				{
					header('Location: ' . $backUrl . '?send_email=1');
					die();
				}
				else
				{
					header('Location: ' . $backUrl . '?send_email=0');
					die();
				}
			}
			else
			{
				header('Location: ' . $backUrl . '?update_password=0');
				die();
			}
		}
	}
}
?>