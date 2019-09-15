<?
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");
?>

<?if(isset($_GET['IBLOCK_ID'])):?>

	<?$APPLICATION->IncludeComponent(
		"my_context:admin_panel.control_content",
		"sshepelev",
		Array(
			'IBLOCKS_TYPE' => 'user_data',
			'IBLOCK_TO_LOAD' => htmlspecialcharsBX($_GET['IBLOCK_ID']),
			'GET_ONLY_CONTENT' => 'Y'
		)
	);?>

<?endif;?>