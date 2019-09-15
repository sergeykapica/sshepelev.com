<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("ADMIN_PANEL_CONTROL_CONTENT"),
	"DESCRIPTION" => GetMessage("ADMIN_PANEL_CONTROL_CONTENT"),
	"CACHE_PATH" => "Y",
	"SORT" => 71,
	"PATH" => array(
		"ID" => "utilities",
		"CHILD" => array(
			"ID" => "admin_panel.control_content",
			"NAME" => GetMessage("ADMIN_PANEL_CONTROL_CONTENT"),
			"SORT" => 31
		)
	)
);

?>