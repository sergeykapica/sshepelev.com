<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
	"PARAMETERS" => array(
        'LIKES_IBLOCK_ID' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage('LIKES_IBLOCK_ID'),
            'TYPE' => 'STRING'
        ),
		'IBLOCK_ID' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage('IBLOCK_ID'),
            'TYPE' => 'STRING'
        ),
        'ELEMENT_IBLOCK_ID' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage('ELEMENT_IBLOCK_ID'),
            'TYPE' => 'STRING'
        )
	)
);
?>