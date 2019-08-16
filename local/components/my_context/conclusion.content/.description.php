<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("CONCLUSION_CONTENT_NAME"),
	"DESCRIPTION" => GetMessage("CONCLUSION_CONTENT_DESC"),
	"CACHE_PATH" => "Y",
	"SORT" => 71,
	"PATH" => array(
		"ID" => "utilities",
		"CHILD" => array(
			"ID" => "conclusion.content",
			"NAME" => GetMessage("CONCLUSION_CONTENT_NAME"),
			"SORT" => 31
		)
	)
);

?>