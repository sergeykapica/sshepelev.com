<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("CONTENT_DETAIL_NAME"),
	"DESCRIPTION" => GetMessage("CONTENT_DETAIL_NAME"),
	"CACHE_PATH" => "Y",
	"SORT" => 71,
	"PATH" => array(
		"ID" => "utilities",
		"CHILD" => array(
			"ID" => "admin_panel.content_detail",
			"NAME" => GetMessage("CONTENT_DETAIL_NAME"),
			"SORT" => 31
		)
	)
);

?>