<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
	"PARAMETERS" => array(
        'IBLOCKS_TYPE' => array(
            'NAME' => GetMessage('IBLOCKS_TYPE'),
            'PARENT' => 'BASE',
            'TYPE' => 'STRING'
        ),
		'IBLOCK_TO_LOAD' => array(
            'NAME' => GetMessage('IBLOCK_TO_LOAD'),
            'PARENT' => 'BASE',
            'TYPE' => 'STRING'
        ),
        'GET_CONTENT_ONLY' => array(
            'NAME' => GetMessage('GET_CONTENT_ONLY'),
            'PARENT' => 'BASE',
            'TYPE' => 'CHECKBOX'
        )
	)
);
?>