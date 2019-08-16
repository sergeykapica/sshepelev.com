<?
session_start();

require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");
require_once($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include_files/UploadImages/UploadImages.php');

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if($APPLICATION->CaptchaCheckCode(htmlspecialcharsBX($_POST["USER_CAPTCHA"]), htmlspecialcharsBX($_POST["captcha_sid"])))
	{
		function setData($file = false)
		{
			$userName = htmlspecialcharsBX($_POST['USER_NAME']);
			$userEmail = htmlspecialcharsBX($_POST['USER_EMAIL']);
			$commentText = htmlspecialcharsBX($_POST['FIELD_TEXT']);
			$newsID = htmlspecialcharsBX($_POST['NEWS_ID']);
			
			if($file != false)
			{
				$userPhoto = $file;
			}
			
			if(CModule::IncludeModule('iblock'))
			{
				$commentsIBlock = new CIBlockElement;
				
				$props = array(
					'USER_NAME' => $userName,
					'USER_EMAIL' => $userEmail,
					'COMMENT_TEXT' => array(
						'VALUE' => array(
							'TEXT' => $commentText
						)
					),
					'NEWS_ID' => $newsID
				);
				
				if(isset($userPhoto))
				{
					$props['USER_PHOTO'] = $userPhoto;
				}
				
				$fields = array(
					'IBLOCK_ID' => 2,
					'IBLOCK_SECTION' => 1,
					'ACTIVE' => 'Y',
					'NAME' => $userName,
					'CODE' => CUtil::translit($userName, "ru"),
					'DATE_ACTIVE_FROM' => date('d.m.Y H:i:s'),
					'PROPERTY_VALUES' => $props
				);
				
				if($d = $commentsIBlock->Add($fields))
				{
					$_SESSION['INFORMATION_UPDATE'] = true;
				}
				else
				{
					$_SESSION['INFORMATION_UPDATE'] = false;
				}
				
				header('Location: ' . $_SERVER['HTTP_REFERER']);
				die();
			}
		}
		
		if(!empty($_FILES) && $_FILES['error'] <= 0)
		{
			$uploadImage = UploadImagesContext\UploadImages::upload($_FILES, 'setData', 1, false, true);
			
			if(is_array($uploadImage))
			{
				if(isset($uploadImage['loadFailed']))
				{
					$_SESSION['UPLOAD_ERROR'] = $uploadImage['loadFailed'];
					
					header('Location: ' . $_SERVER['HTTP_REFERER']);
					die();
				}
			}
		}
		else
		{
			setData();
		}
	}
	else
	{
		$_SESSION['CAPTCHA_WRONG'] = false;
		
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		die();
	}
}
?>