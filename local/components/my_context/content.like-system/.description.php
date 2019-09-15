<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("CONTENT_LIKE_SYSTEM"),
	"DESCRIPTION" => GetMessage("CONTENT_LIKE_SYSTEM"),
	"CACHE_PATH" => "Y",
	"SORT" => 71,
	"PATH" => array(
		"ID" => "utilities",
		"CHILD" => array(
			"ID" => "content.like-system",
			"NAME" => GetMessage("CONTENT_LIKE_SYSTEM"),
			"SORT" => 31
		)
	)
);

?>