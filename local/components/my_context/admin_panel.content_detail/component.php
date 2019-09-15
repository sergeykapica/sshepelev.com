<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(CModule::IncludeModule('iblock'))
{
    $arResult = array();
    
    if(isset($arParams['ELEMENT_CODE']))
    {
        $arFilter = array(
            'IBLOCK_CODE' => $arParams['IBLOCK_CODE'],
            'CODE' => $arParams['ELEMENT_CODE']
        );

        if(isset($arParams['SECTION_CODE']))
        {
            $arFilter['SECTION_CODE'] = $arParams['SECTION_CODE'];
        }

        $arSelect = array(
            'ID',
            'IBLOCK_ID',
            'NAME',
            'DATE_ACTIVE_FROM',
            'IBLOCK_SECTION_ID'
        );

        if($arParams['IBLOCK_CODE'] == 'news')
        {
            array_push($arSelect, 'DETAIL_TEXT');
        }
        else if($arParams['IBLOCK_CODE'] == 'comments')
        {
            array_push($arSelect, 'PROPERTY_USER_NAME', 'PROPERTY_USER_EMAIL', 'PROPERTY_USER_PHOTO', 'PROPERTY_COMMENT_TEXT', 'PROPERTY_NEWS_ID');
        }
        else if($arParams['IBLOCK_CODE'] == 'user_poems')
        {
            array_push($arSelect, 'PROPERTY_POEM_TEXT');
        }
        else if($arParams['IBLOCK_CODE'] == 'user_video')
        {
            array_push($arSelect, 'DETAIL_TEXT', 'PROPERTY_VIDEO_URL', 'PROPERTY_VIDEO_PREVIEW', 'PROPERTY_VIDEO_DURATION');
        }
        else if($arParams['IBLOCK_CODE'] == 'user_audio')
        {
            array_push($arSelect, 'DETAIL_TEXT', 'PROPERTY_AUDIO_URL', 'PROPERTY_AUDIO_DURATION');
        }
        else if($arParams['IBLOCK_CODE'] == 'comments_for_content')
        {
            array_push($arSelect, 'DETAIL_TEXT', 'PROPERTY_USER_NAME', 'PROPERTY_USER_EMAIL', 'PROPERTY_USER_PHOTO', 'PROPERTY_COMMENT_TEXT', 'PROPERTY_COMMENT_IBLOCK', 'ELEMENT_TO_BIND');
        }
        else if($arParams['IBLOCK_CODE'] == 'user_photo')
        {
            array_push($arSelect, 'DETAIL_TEXT', 'PROPERTY_PHOTO');
        }

        $element = CIBlockElement::GetList(array('ID' => 'DESC'), $arFilter, false, false, $arSelect);

        if($element)
        {
            $element = $element->Fetch();
            $arResult['ELEMENT_DATA'] = $element;
        }
    }
}

$this->includeComponentTemplate();
?>