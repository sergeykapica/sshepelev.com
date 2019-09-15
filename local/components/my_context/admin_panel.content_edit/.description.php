<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("CONTENT_EDIT_NAME"),
	"DESCRIPTION" => GetMessage("CONTENT_EDIT_NAME"),
	"CACHE_PATH" => "Y",
	"SORT" => 71,
	"PATH" => array(
		"ID" => "utilities",
		"CHILD" => array(
			"ID" => "admin_panel.content_edit",
			"NAME" => GetMessage("CONTENT_EDIT_NAME"),
			"SORT" => 31
		)
	)
);

?>