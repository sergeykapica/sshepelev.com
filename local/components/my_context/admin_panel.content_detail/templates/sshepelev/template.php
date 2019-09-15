<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<div class="content-detail-wrapper">
    <?if(isset($arResult['ELEMENT_DATA'])):?>
        <?$APPLICATION->IncludeComponent(
            "my_context:admin_panel.content_edit",
            "sshepelev",
            Array(
                'IBLOCK_CODE' => $arParams['IBLOCK_CODE'],
                'ELEMENT_DATA' => $arResult['ELEMENT_DATA']
            )
        );?>
    <?else:?>
        <?$APPLICATION->IncludeComponent(
            "my_context:admin_panel.content_edit",
            "sshepelev",
            Array(
                'IBLOCK_CODE' => $arParams['IBLOCK_CODE']
            )
        );?>
    <?endif;?>
</div>
