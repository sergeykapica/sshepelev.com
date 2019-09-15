<?
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");

if(isset($_GET['type']) && isset($_GET['IBLOCK_ELEMENT']) && isset($_GET['ELEMENT_IBLOCK_ID']) && isset($_GET['LIKES_IBLOCK_ID']))
{
	$type = htmlspecialcharsBX($_GET['type']);
	$iblockElement = htmlspecialcharsBX($_GET['IBLOCK_ELEMENT']);
	$elementIblockID = htmlspecialcharsBX($_GET['ELEMENT_IBLOCK_ID']);
	$likesIblockID = htmlspecialcharsBX($_GET['LIKES_IBLOCK_ID']);
	$currentIP = $_SERVER['REMOTE_ADDR'];
	
	if(CModule::IncludeModule('iblock'))
	{
		class LikeSystem
		{
			public static function setLike($currentIP, $type, $checkType, $likesIblockID, $iblockElement, $elementIblockID)
			{
				// Add entry to DataBase
				
				$arFilter = array(
					array(
						'LOGIC' => 'OR',
						array(
							'=PROPERTY_LIKE_TYPE' => $type
						),
						array(
							'=PROPERTY_LIKE_TYPE' => $checkType
						)
					),
					array(
						'LOGIC' => 'AND',
						array(
							'IBLOCK_ID' => $likesIblockID,
							'=PROPERTY_USER_LIKE_IP' => $currentIP,
							'=PROPERTY_IBLOCK_ELEMENT' => $iblockElement,
							'=PROPERTY_ELEMENT_IBLOCK_ID' => $elementIblockID
						)
					)
				);
				
				$arSelect = array(
					'ID',
					'IBLOCK_ID',
					'PROPERTY_LIKE_TYPE'
				);
				
				$result = CIBlockElement::GetList(array('ID' => 'ASC'), $arFilter, false, false, $arSelect);
				
				if($result)
				{
					if($result->SelectedRowsCount() <= 0)
					{
						$likeSystem = new CIBlockElement;
						
						$properties = array(
							'USER_LIKE_IP' => $currentIP,
							'LIKE_TYPE' => $type,
							'IBLOCK_ELEMENT' => $iblockElement,
							'ELEMENT_IBLOCK_ID' => $elementIblockID
						);
						
						$fields = array(
							'IBLOCK_ID' => $likesIblockID,
							'NAME' => $type . time(),
							'ACTIVE' => 'Y',
							'DATE_ACTIVE_FROM' => date('d.m.Y H:i:s'),
							'PROPERTY_VALUES' => $properties
						);
						
						if($likeSystem->Add($fields))
						{
							return true;
						}
					}
					else
					{
						$entry = $result->Fetch();
						
						if($entry['PROPERTY_LIKE_TYPE_VALUE'] != $type)
						{
							$likeSystem = new CIBlockElement;
						
							$properties = array(
								'LIKE_TYPE' => $type
							);
							
							$likeSystem->SetPropertyValuesEx($entry['ID'], $likesIblockID, $properties);
							
							return true;
						}
					}
				}
				
				return false;
			}
		}
		
		if($type == 'like')
		{
			echo LikeSystem::setLike($currentIP, $type, 'dizlike', $likesIblockID, $iblockElement, $elementIblockID);
		}
		else
		{
			echo LikeSystem::setLike($currentIP, $type, 'like', $likesIblockID, $iblockElement, $elementIblockID);
		}
	}
}
?>