<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Управление содержимым");
$APPLICATION->SetAdditionalCss(SITE_TEMPLATE_PATH . '/css/admin-panel.css');
?>


<?$APPLICATION->IncludeComponent(
	"my_context:admin_panel.control_content",
	"sshepelev",
	Array(
		'IBLOCKS_TYPE' => 'user_data',
		'IBLOCK_TO_LOAD' => 4
	)
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>