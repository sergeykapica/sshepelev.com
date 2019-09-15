<?
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");

if(isset($_GET['VIDEO_URL']))
{
	$videoUrl = htmlspecialcharsBX($_GET['VIDEO_URL']);
?>

	<?$APPLICATION->IncludeComponent(
		"my_context:videoplayer",
		"sshepelev",
		Array(
			'VIDEO_URL' => $videoUrl
		)
	);?>

<?
}
?>