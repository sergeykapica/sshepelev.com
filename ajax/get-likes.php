<?
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");
?>

<?
if(isset($_GET['IBLOCK_ID']) && isset($_GET['ELEMENT_IBLOCK_ID']))
{
	$IblockID = htmlspecialcharsBX($_GET['IBLOCK_ID']);
	$elementIblockID = htmlspecialcharsBX($_GET['ELEMENT_IBLOCK_ID']);
?>
	<?$APPLICATION->IncludeComponent(
		"my_context:content.like-system",
		"sshepelev",
		Array(
			'LIKES_IBLOCK_ID' => 7,
			'IBLOCK_ID' => $IblockID,
			'ELEMENT_IBLOCK_ID' => $elementIblockID
		)
	);?>
<?	
}
?>