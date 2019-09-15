<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
	"PARAMETERS" => array(
        'IBLOCK_TYPE' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage('IBLOCK_TYPE_NAME'),
            'TYPE' => 'STRING'
        ),
		'IBLOCK_ID' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage('IBLOCK_ID_NAME'),
            'TYPE' => 'STRING'
        ),
        'IBLOCK_SECTION' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage('IBLOCK_SECTION_NAME'),
            'TYPE' => 'STRING'
        ),
        'NEWS_ID' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage('NEWS_ID_NAME'),
            'TYPE' => 'STRING'
        ),
        'COMMENT_IBLOCK' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage('COMMENT_IBLOCK_NAME'),
            'TYPE' => 'STRING'
        ),
        'CONTENT_ELEMENT_ID' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage('CONTENT_ELEMENT_ID_NAME'),
            'TYPE' => 'STRING'
        )
	)
);
?>