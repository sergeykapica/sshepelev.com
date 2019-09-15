<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
require_once($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include_files/GenerateCode/GenerateCode.php');
?>

<?
if(CModule::IncludeModule('iblock'))
{
	$nPageSize = 2;
	$iblockID = 4;

	$arSectionNavParams = array(
		'bShowAll' => false,
		'nPageSize' => $nPageSize
	);

	$arSectionFilter = array(
		'IBLOCK_ID' => $iblockID
	);

	$arSectionSelect = array(
		'ID',
		'IBLOCK_ID',
		'CODE',
		'NAME'
	);

	$sections = CIBlockSection::GetList(array('NAME' => 'DESC'), $arSectionFilter, false, $arSectionSelect, $arSectionNavParams);
	$sectionList = array();

	while($section = $sections->GetNext())
	{
		$sectionList[$section['ID']] = $section;
	}

	foreach($sectionList as &$section)
	{
		$arNavParams = array(
			'bShowAll' => false,
			'nPageSize' => $nPageSize
		);

		$arFilter = array(
			'IBLOCK_ID' => $iblockID,
			'IBLOCK_SECTION_ID' => $section['ID']
		);
		
		$arSelect = array(
			'ID',
			'IBLOCK_ID',
			'NAME',
			'DATE_ACTIVE_FROM',
			'CODE'
		);

		$elements = CIBlockElement::GetList(array('ID' => 'DESC'), $arFilter, false, $arNavParams, $arSelect);

		if($elements)
		{
			while($element = $elements->GetNext())
			{
				$section['SECTION_ELEMENTS'][] = $element;
			}

			$section['SECTION_NAVIGATION'] = $elements->GetPageNavStringEx($backURL = false, 'Элементы', 'sshepelev', false, false, $arNavParams);
		}
	}

	print_r($sectionList);
}
?>

<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>