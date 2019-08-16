<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Категории стихотворений");
?>

<?$APPLICATION->IncludeComponent(
	"my_context:catalog.section.list",
	"sshepelev",
	Array(
		"ADD_SECTIONS_CHAIN" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COUNT_ELEMENTS" => "N",
		"FILTER_NAME" => "sectionsFilter",
		"IBLOCK_ID" => "3",
		"IBLOCK_TYPE" => "user_data",
		"SECTION_CODE" => "",
		"SECTION_FIELDS" => array("ID","CODE","NAME","DESCRIPTION",""),
		"SECTION_ID" => "",
		"SECTION_URL" => "#SITE_DIR#/contents/#IBLOCK_CODE#/#CODE#",
		"SECTION_USER_FIELDS" => array("",""),
		"SHOW_PARENT_NAME" => "Y",
		"TOP_DEPTH" => "2",
		"VIEW_MODE" => "LINE"
	)
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>