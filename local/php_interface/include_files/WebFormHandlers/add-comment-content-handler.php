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
			$iblockID = htmlspecialcharsBX($_POST['COMMENT_IBLOCK']);
			$contentElementID = htmlspecialcharsBX($_POST['CONTENT_ELEMENT_ID']);
			
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
					'COMMENT_IBLOCK' => $iblockID,
					'ELEMENT_TO_BIND' => $contentElementID
				);
				
				if(isset($userPhoto))
				{
					$props['USER_PHOTO'] = $userPhoto;
				}
				
				$fields = array(
					'IBLOCK_ID' => 6,
					'ACTIVE' => 'Y',
					'NAME' => $userName,
					'CODE' => CUtil::translit($userName, "ru"),
					'DATE_ACTIVE_FROM' => date('d.m.Y H:i:s'),
					'PROPERTY_VALUES' => $props
				);
				
				if($d = $commentsIBlock->Add($fields))
				{
					echo 'add-comment-done';
				}
				else
				{
					echo 'add-comment-failed';
				}
			}
		}
		
		if(!empty($_FILES) && $_FILES['error'] <= 0)
		{
			$uploadImage = UploadImagesContext\UploadImages::upload($_FILES, 'setData', 1, false, true);
			
			if(is_array($uploadImage))
			{
				if(isset($uploadImage['loadFailed']))
				{
					echo 'image-load-error';
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
		echo 'captcha-input-error';
	}
}
?>