<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("VIDEO_PLAYER_NAME"),
	"DESCRIPTION" => GetMessage("VIDEO_PLAYER_NAME"),
	"CACHE_PATH" => "Y",
	"SORT" => 71,
	"PATH" => array(
		"ID" => "utilities",
		"CHILD" => array(
			"ID" => "video_player",
			"NAME" => GetMessage("VIDEO_PLAYER_NAME"),
			"SORT" => 31
		)
	)
);

?>