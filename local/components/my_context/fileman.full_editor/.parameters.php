<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arComponentParameters = array(
    "PARAMETERS" => array(
        "EDITOR_HEIGHT" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("EDITOR_HEIGHT_TITLE"),
            "TYPE" => "STRING",
            "DEFAULT" => "300"
        ),
        "EDITOR_TEXTAREA_NAME" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("EDITOR_TEXTAREA_NAME_TITLE"),
            "TYPE" => "STRING"
        ),
        "EDITOR_TEXTAREA_CLASSNAME" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("EDITOR_TEXTAREA_CLASSNAME_TITLE"),
            "TYPE" => "STRING"
        ),
        "EDITOR_TEXTAREA_VALUE" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("EDITOR_TEXTAREA_VALUE_TITLE"),
            "TYPE" => "STRING",
            "DEFAULT" => ""
        )
    )
);