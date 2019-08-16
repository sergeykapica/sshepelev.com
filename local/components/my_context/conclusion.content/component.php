<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(CModule::IncludeModule('iblock'))
{
    $arResult = array();
    
    if($arParams['IBLOCK_TYPE'] == 'user_data' && $arParams['IBLOCK_CODE'] == 'user_poems')
    {
        $arNavParams = array(
            'bShowAll' => false,
            'nPageSize' => 20
        );

        $arFilter = array(
            'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
            'IBLOCK_CODE' => $arParams['IBLOCK_CODE'],
            'SECTION_CODE' => $arParams['IBLOCK_SECTION_CODE']
        );

        $arSelect = array(
            'ID',
            'IBLOCK_ID',
            'DATE_ACTIVE_FROM',
            'NAME',
            'CREATED_BY',
            'PROPERTY_POEM_TEXT'
        );

        $poems = CIBlockElement::GetList(array('DATE_ACTIVE_FROM' => 'DESC'), $arFilter, false, $arNavParams, $arSelect);

        if($poems)
        {
            while($poem = $poems->GetNext())
            {
                $userData = $USER->GetByID($poem['CREATED_BY']);
                
                if($userData)
                {
                    $userData = $userData->Fetch();
                    $userData['PERSONAL_PHOTO'] = CFile::GetPath($userData['PERSONAL_PHOTO']);
                    
                    $poem['USER_DATA'] = $userData;
                }
                
                $poem['DATE_ACTIVE_FROM'] = FormatDate('d F, Y г.', MakeTimeStamp($poem['DATE_ACTIVE_FROM'], 'DD.MM.YYYY HH:MI:SS'));
                
                $arResult['POEMS'][] = $poem;
            }
        }
        
        $arResult['NAV_STRING'] = $poems->GetPageNavStringEx($backNav = false, 'Стихотворения', 'sshepelev', false, false, $arNavParams);
    }
    else if($arParams['IBLOCK_TYPE'] == 'user_data' && $arParams['IBLOCK_CODE'] == 'user_video')
    {
        $arNavParams = array(
            'bShowAll' => false,
            'nPageSize' => 1
        );

        $arFilter = array(
            'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
            'IBLOCK_CODE' => $arParams['IBLOCK_CODE'],
            'SECTION_CODE' => $arParams['IBLOCK_SECTION_CODE']
        );

        $arSelect = array(
            'ID',
            'IBLOCK_ID',
            'DATE_ACTIVE_FROM',
            'NAME',
            'CREATED_BY',
            'PROPERTY_VIDEO_URL',
            'PROPERTY_VIDEO_PREVIEW',
            'PROPERTY_VIDEO_DURATION'
        );

        $video = CIBlockElement::GetList(array('DATE_ACTIVE_FROM' => 'DESC'), $arFilter, false, $arNavParams, $arSelect);

        if($video)
        {
            while($videoItem = $video->GetNext())
            {
                $userData = $USER->GetByID($videoItem['CREATED_BY']);
                
                if($userData)
                {
                    $userData = $userData->Fetch();
                    $userData['PERSONAL_PHOTO'] = CFile::GetPath($userData['PERSONAL_PHOTO']);
                    
                    $videoItem['USER_DATA'] = $userData;
                }
                
                $videoItem['DATE_ACTIVE_FROM'] = FormatDate('d F, Y г.', MakeTimeStamp($videoItem['DATE_ACTIVE_FROM'], 'DD.MM.YYYY HH:MI:SS'));
                
                $arResult['VIDEO'][] = $videoItem;
            }
        }
        
        $arResult['NAV_STRING'] = $video->GetPageNavStringEx($backNav = false, 'Видео', 'sshepelev', false, false, $arNavParams);
    }
}

$this->includeComponentTemplate();
?>