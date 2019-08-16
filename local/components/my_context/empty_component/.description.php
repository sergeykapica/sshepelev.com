<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("CORRESPONDENT_USER_NAME"),
	"DESCRIPTION" => GetMessage("CORRESPONDENT_USER_DESC"),
	"CACHE_PATH" => "Y",
	"SORT" => 71,
	"PATH" => array(
		"ID" => "communication",
		"CHILD" => array(
			"ID" => "socialnetwork",
			"NAME" => GetMessage("SONET_NAME"),
			"SORT" => 31
		)
	)
);

?>