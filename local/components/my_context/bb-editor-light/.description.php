<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("BB_EDITOR_LIGHT_NAME"),
	"DESCRIPTION" => GetMessage("BB_EDITOR_LIGHT_DESC"),
	"CACHE_PATH" => "Y",
	"SORT" => 71,
	"PATH" => array(
		"ID" => "utilities",
		"CHILD" => array(
			"ID" => "bb-editor-light",
			"NAME" => GetMessage("BB_EDITOR_LIGHT_NAME"),
			"SORT" => 31
		)
	)
);

?>