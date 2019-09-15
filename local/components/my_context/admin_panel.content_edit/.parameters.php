<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
	"PARAMETERS" => array(
		'IBLOCK_CODE' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage('IBLOCK_CODE_NAME'),
            'TYPE' => 'STRING'
        ),
        'ELEMENT_DATA' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage('ELEMENT_DATA_NAME'),
            'TYPE' => 'STRING'
        )
	)
);
?>