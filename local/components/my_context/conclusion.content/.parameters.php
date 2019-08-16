<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
	"PARAMETERS" => array(
		'IBLOCK_TYPE' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage('IBLOCK_TYPE_NAME'),
            'TYPE' => 'STRING'
        ),
		'IBLOCK_CODE' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage('IBLOCK_CODE_NAME'),
            'TYPE' => 'STRING'
        ),
        'IBLOCK_SECTION_CODE' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage('IBLOCK_SECTION_CODE_NAME'),
            'TYPE' => 'STRING'
        )
	)
);
?>