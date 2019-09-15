<?
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");
?>

<?
if(isset($_GET['COMMENT_IBLOCK']) && isset($_GET['CONTENT_ELEMENT_ID']))
{
	$commentIBlock = htmlspecialcharsBX($_GET['COMMENT_IBLOCK']);
	$contentElementID = htmlspecialcharsBX($_GET['CONTENT_ELEMENT_ID']);
?>
	<?$APPLICATION->IncludeComponent(
		"my_context:users.comments",
		"sshepelev_content",
		Array(
			'IBLOCK_ID' => 6,
			'COMMENT_IBLOCK' => $commentIBlock,
			'CONTENT_ELEMENT_ID' => $contentElementID
		)
	);?>
<?	
}
?>