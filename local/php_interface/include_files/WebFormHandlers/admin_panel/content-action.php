<?
session_start();

require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");
require_once($_SERVER['DOCUMENT_ROOT']."/local/php_interface/include_files/TextHandler/textHandler.php");
require_once($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include_files/UploadImages/UploadImages.php');

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if(CModule::IncludeModule('iblock'))
	{
		$iblockID = htmlspecialcharsBX($_POST['IBLOCK_ID']);
		
		function addSectionToIBlock($iblockID, $textHandler, $sectionName, $sectionDescription, $actionType, $sectionID = false)
		{
			$sectionName = $textHandler->textToSafeState($sectionName);
			$sectionDescription = $textHandler->textToSafeState($sectionDescription);
			$actionType = $textHandler->textToSafeState($actionType);
			
			$categoryIBlock = new CIBlockSection;
			
			$arFields = array(
				'IBLOCK_ID' => $iblockID,
				'NAME' => $sectionName,
				'DESCRIPTION' => $sectionDescription
			);
			
			if($actionType == 'UPDATE')
			{
				$sectionID = $textHandler->textToSafeState($sectionID);
				
				if($categoryIBlock->Update($sectionID, $arFields))
				{
					$_SESSION['SECTION_ACTION_RESULT'] = 'ADD';
				}
				else
				{
					$_SESSION['SECTION_ACTION_RESULT'] = 'NOT_ADD';
				}
			}
			else
			{
				$additionalFields = array(
					'DATE_CREATE' => date('d.m.Y H:i:s'),
					'ACTIVE' => 'Y',
					'CODE' => CUtil::translit($arFields['NAME'], 'ru')
				);
				
				foreach($additionalFields as $aKey => $aValue)
				{
					$arFields[$aKey] = $aValue;
				}
				
				if($categoryIBlock->Add($arFields))
				{
					$_SESSION['SECTION_ACTION_RESULT'] = 'ADD';
				}
				else
				{
					$_SESSION['SECTION_ACTION_RESULT'] = 'NOT_ADD';
				}
			}
		}
		
		if($iblockID == 1)
		{	
			$textHandler = new TextHandlerContext\TextHandler;
			
			if(!isset($_POST['ACTION_CATEGORY']))
			{
				$newsID = $textHandler->textToSafeState($_POST['ELEMENT_ID']);
				$newsName = $textHandler->textToSafeState($_POST['NEWS_NAME']);
				$newsText = $textHandler->textToSafeState($_POST['NEWS_TEXT']);
				$newsCategory = $textHandler->textToSafeState($_POST['NEWS_CATEGORY']);
				$actionType = $textHandler->textToSafeState($_POST['ACTION_TYPE']);

				$categoryIBlock = new CIBlockElement;
				
				$arFields = array(
					'IBLOCK_ID' => $iblockID,
					'NAME' => $newsName,
					'DETAIL_TEXT' => $newsText
				);
				
				if($newsCategory != 'NONE_ACTIVE_CATEGORIES')
				{
					$arFields['IBLOCK_SECTION_ID'] = $newsCategory;
				}
				
				if($actionType == 'UPDATE')
				{
					if($categoryIBlock->Update($newsID, $arFields))
					{
						$_SESSION['ELEMENT_ACTION_RESULT'] = 'ADD';
					}
					else
					{
						$_SESSION['ELEMENT_ACTION_RESULT'] = 'NOT_ADD';
					}
				}
				else
				{
					$additionalFields = array(
						'DATE_ACTIVE_FROM' => date('d.m.Y H:i:s'),
						'ACTIVE' => 'Y',
						'CODE' => CUtil::translit($arFields['NAME'], 'ru')
					);
					
					foreach($additionalFields as $aKey => $aValue)
					{
						$arFields[$aKey] = $aValue;
					}
					
					if($categoryIBlock->Add($arFields))
					{
						$_SESSION['ELEMENT_ACTION_RESULT'] = 'ADD';
					}
					else
					{
						$_SESSION['ELEMENT_ACTION_RESULT'] = 'NOT_ADD';
					}
				}
			}
			else
			{	
				if(isset($_POST['SECTION_ID']))
				{
					addSectionToIBlock($iblockID, $textHandler, $_POST['NEWS_CATEGORY_NAME'], $_POST['NEWS_CATEGORY_DESCRIPTION'], $_POST['ACTION_TYPE'], $_POST['SECTION_ID']);
				}
				else
				{
					addSectionToIBlock($iblockID, $textHandler, $_POST['NEWS_CATEGORY_NAME'], $_POST['NEWS_CATEGORY_DESCRIPTION'], $_POST['ACTION_TYPE']);
				}
			}
			
			LocalRedirect($_SERVER['HTTP_REFERER'], false);
		}
		else if($iblockID == 2)
		{
			$textHandler = new TextHandlerContext\TextHandler;
			
			if(!isset($_POST['ACTION_CATEGORY']))
			{
				$GLOBALS['iblockID'] = $iblockID;
				
				function setData($file = false)
				{
					$textHandler = new TextHandlerContext\TextHandler;
					
					$commentID = $textHandler->textToSafeState($_POST['ELEMENT_ID']);
					$commentUserName = $textHandler->textToSafeState($_POST['COMMENT_USER_NAME']);
					$commentUserEmail = $textHandler->textToSafeState($_POST['COMMENT_USER_EMAIL']);
					$commentText = $textHandler->textToSafeState($_POST['COMMENT_TEXT']);
					$commentNewsID = $textHandler->textToSafeState($_POST['COMMENT_NEWS_ID']);
					$commentCategory = $textHandler->textToSafeState($_POST['COMMENTS_CATEGORY']);
					$actionType = $textHandler->textToSafeState($_POST['ACTION_TYPE']);
					
					$categoryIBlock = new CIBlockElement;
				
					$arFields = array(
						'IBLOCK_ID' => $GLOBALS['iblockID'],
						'NAME' => $commentUserName . date('d-m-Y-H-i-s')
					);
					
					if($commentCategory != 'NONE_ACTIVE_CATEGORIES')
					{
						$arFields['IBLOCK_SECTION_ID'] = $commentCategory;
					}
					
					$properties = array(
						'USER_NAME' => $commentUserName,
						'USER_EMAIL' => $commentUserEmail,
						'COMMENT_TEXT' => array(
							'VALUE' => array(
								'TEXT' => $commentText
							)
						),
						'NEWS_ID' => $commentNewsID
					);
					
					if($file != false)
					{
						$properties['USER_PHOTO'] = $file;
					}
					
					if($actionType == 'UPDATE')
					{	
						if($categoryIBlock->Update($commentID, $arFields))
						{
							$categoryIBlock->SetPropertyValuesEx($commentID, $GLOBALS['iblockID'], $properties);
							
							$_SESSION['ELEMENT_ACTION_RESULT'] = 'ADD';
						}
						else
						{
							$_SESSION['ELEMENT_ACTION_RESULT'] = 'NOT_ADD';
						}
					}
					else
					{
						$additionalFields = array(
							'DATE_ACTIVE_FROM' => date('d.m.Y H:i:s'),
							'ACTIVE' => 'Y',
							'CODE' => CUtil::translit($arFields['NAME'], 'ru')
						);
						
						foreach($additionalFields as $aKey => $aValue)
						{
							$arFields[$aKey] = $aValue;
						}
						
						if($categoryIBlock->Add($arFields))
						{
							$_SESSION['ELEMENT_ACTION_RESULT'] = 'ADD';
						}
						else
						{
							$_SESSION['ELEMENT_ACTION_RESULT'] = 'NOT_ADD';
						}
					}
					
					LocalRedirect($_SERVER['HTTP_REFERER'], false);
				}
				
				if(!empty($_FILES) && $_FILES['error'] <= 0)
				{	
					$uploadImage = UploadImagesContext\UploadImages::upload($_FILES, 'setData', 1, false, true);
					
					if(is_array($uploadImage))
					{
						if(isset($uploadImage['loadFailed']))
						{
							$_SESSION['UPLOAD_ERROR'] = $uploadImage['loadFailed'];
							
							LocalRedirect($_SERVER['HTTP_REFERER'], false);
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
				if(isset($_POST['SECTION_ID']))
				{
					addSectionToIBlock($iblockID, $textHandler, $_POST['NEWS_CATEGORY_NAME'], $_POST['NEWS_CATEGORY_DESCRIPTION'], $_POST['ACTION_TYPE'], $_POST['SECTION_ID']);
				}
				else
				{
					addSectionToIBlock($iblockID, $textHandler, $_POST['COMMENT_CATEGORY_NAME'], $_POST['COMMENT_CATEGORY_DESCRIPTION'], $_POST['ACTION_TYPE']);
				}
			}
		}
	}
}
?>