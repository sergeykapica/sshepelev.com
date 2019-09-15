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
        
        if(count($arResult['POEMS']) <= 0)
        {
            $arResult['POEMS_EMPTY'] = true;
        }
        
        $arResult['NAV_STRING'] = $poems->GetPageNavStringEx($backNav = false, 'Стихотворения', 'sshepelev', false, false, $arNavParams);
    }
    else if($arParams['IBLOCK_TYPE'] == 'user_data' && $arParams['IBLOCK_CODE'] == 'user_video')
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
            'DETAIL_TEXT',
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
                
                $videoItem['DATE_ACTIVE_FROM'] = FormatDate('d F, Y г. в H:i', MakeTimeStamp($videoItem['DATE_ACTIVE_FROM'], 'DD.MM.YYYY HH:MI:SS'));
                
                $arResult['VIDEO'][] = $videoItem;
            }
        }
        
        if(count($arResult['VIDEO']) <= 0)
        {
            $arResult['VIDEO_EMPTY'] = true;
        }
        
        $arResult['NAV_STRING'] = $video->GetPageNavStringEx($backNav = false, 'Видео', 'sshepelev', false, false, $arNavParams);
    }
    else if($arParams['IBLOCK_TYPE'] == 'user_data' && $arParams['IBLOCK_CODE'] == 'user_photo')
    {
        $arNavParams = array(
            'bShowAll' => false,
            'nPageSize' => 2
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
            'DETAIL_TEXT',
            'PROPERTY_PHOTO',
        );

        $photo = CIBlockElement::GetList(array('DATE_ACTIVE_FROM' => 'DESC'), $arFilter, false, $arNavParams, $arSelect);

        if($photo)
        {
            while($photoItem = $photo->GetNext())
            {
                $userData = $USER->GetByID($photoItem['CREATED_BY']);
                
                if($userData)
                {
                    $userData = $userData->Fetch();
                    $userData['PERSONAL_PHOTO'] = CFile::GetPath($userData['PERSONAL_PHOTO']);
                    
                    $photoItem['USER_DATA'] = $userData;
                }
                
                $photoItem['DATE_ACTIVE_FROM'] = FormatDate('d F, Y г. в H:i', MakeTimeStamp($photoItem['DATE_ACTIVE_FROM'], 'DD.MM.YYYY HH:MI:SS'));
                $photoItem['PROPERTY_PHOTO_VALUE'] = CFile::GetPath($photoItem['PROPERTY_PHOTO_VALUE']);
                
                $arResult['PHOTO'][] = $photoItem;
            }
        }
        
        if(count($arResult['PHOTO']) <= 0)
        {
            $arResult['PHOTO_EMPTY'] = true;
        }
        
        $arResult['NAV_STRING'] = $photo->GetPageNavStringEx($backNav = false, 'Фото', 'sshepelev', false, false, $arNavParams);
    }
    else
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
            'DETAIL_TEXT',
            'PROPERTY_AUDIO_URL',
            'PROPERTY_AUDIO_DURATION'
        );

        $audio = CIBlockElement::GetList(array('DATE_ACTIVE_FROM' => 'DESC'), $arFilter, false, $arNavParams, $arSelect);

        if($audio)
        {
            while($audioItem = $audio->GetNext())
            {   
                $audioItem['DATE_ACTIVE_FROM'] = FormatDate('d F, Y г. в H:i', MakeTimeStamp($audioItem['DATE_ACTIVE_FROM'], 'DD.MM.YYYY HH:MI:SS'));
                
                $arResult['AUDIO'][] = $audioItem;
            }
        }
        
        if(count($arResult['AUDIO']) <= 0)
        {
            $arResult['AUDIO_EMPTY'] = true;
        }
        
        $arResult['NAV_STRING'] = $audio->GetPageNavStringEx($backNav = false, 'Аудио', 'sshepelev', false, false, $arNavParams);
    }
}

$this->includeComponentTemplate();
?>