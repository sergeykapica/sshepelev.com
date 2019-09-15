<?
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");

if(isset($_GET['AUDIO_URL']))
{
	$audioUrl = htmlspecialcharsBX($_GET['AUDIO_URL']);
?>

	<?$APPLICATION->IncludeComponent(
        "my_context:videoplayer",
        "sshepelev_audio",
        Array(
            'AUDIO_URL' => $audioUrl
        )
    );?>

<?
}
?>