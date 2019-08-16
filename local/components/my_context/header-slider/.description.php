<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("HEADER_SLIDER_NAME"),
	"DESCRIPTION" => GetMessage("HEADER_SLIDER_DESC"),
	"CACHE_PATH" => "Y",
	"SORT" => 71,
	"PATH" => array(
		"ID" => "utilities",
		"CHILD" => array(
			"ID" => "header-slider",
			"NAME" => GetMessage("HEADER_SLIDER_NAME"),
			"SORT" => 31
		)
	)
);

?>