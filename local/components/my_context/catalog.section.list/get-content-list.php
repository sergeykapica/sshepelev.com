<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$iblockCode = htmlspecialcharsBX($_GET['IBLOCK_CODE']);

if($iblockCode == 'user_poems')
{
	$APPLICATION->SetTitle("Стихотворения");
}
else if($iblockCode == 'user_video')
{
	$APPLICATION->SetTitle("Видео");
}
else
{
	$APPLICATION->SetTitle("Аудио");
}
?>

<?$APPLICATION->IncludeComponent(
	"my_context:header-slider",
	"sshepelev_video_slider",
	Array()
);?>

<?
$APPLICATION->IncludeComponent(
	"my_context:conclusion.content",
	"sshepelev",
	Array(
		'IBLOCK_TYPE' => 'user_data',
		'IBLOCK_CODE' => $iblockCode,
		'IBLOCK_SECTION_CODE' => htmlspecialcharsBX($_GET['SECTION_CODE'])
	)
);
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>