<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("USERS_COMMENTS_NAME"),
	"DESCRIPTION" => GetMessage("USERS_COMMENTS_DESC"),
	"CACHE_PATH" => "Y",
	"SORT" => 71,
	"PATH" => array(
		"ID" => "communication",
		"CHILD" => array(
			"ID" => "users.comments",
			"NAME" => GetMessage("USERS_COMMENTS_NAME"),
			"SORT" => 31
		)
	)
);

?>