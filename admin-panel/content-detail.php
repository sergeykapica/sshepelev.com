<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetAdditionalCss(SITE_TEMPLATE_PATH . '/css/admin-panel.css');
?>

<?
if(isset($_GET['IBLOCK_CODE']) && isset($_GET['SECTION_CODE']) && isset($_GET['ELEMENT_CODE']))
{
?>

	<?$APPLICATION->IncludeComponent(
		"my_context:admin_panel.content_detail",
		"sshepelev",
		Array(
			'IBLOCK_CODE' => htmlspecialcharsBX($_GET['IBLOCK_CODE']),
			'SECTION_CODE' => htmlspecialcharsBX($_GET['SECTION_CODE']),
			'ELEMENT_CODE' => htmlspecialcharsBX($_GET['ELEMENT_CODE'])
		)
	);?>

<?
}
else if(isset($_GET['IBLOCK_CODE']) && isset($_GET['ELEMENT_CODE']))
{
?>
	<?$APPLICATION->IncludeComponent(
		"my_context:admin_panel.content_detail",
		"sshepelev",
		Array(
			'IBLOCK_CODE' => htmlspecialcharsBX($_GET['IBLOCK_CODE']),
			'ELEMENT_CODE' => htmlspecialcharsBX($_GET['ELEMENT_CODE'])
		)
	);?>
<?
}
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>