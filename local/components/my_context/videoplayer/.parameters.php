<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
	"PARAMETERS" => array(
		'VIDEO_URL' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage('VIDEO_URL_NAME'),
            'TYPE' => 'STRING'
        ),
		'AUDIO_URL' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage('AUDIO_URL_NAME'),
            'TYPE' => 'STRING'
        )
	)
);
?>