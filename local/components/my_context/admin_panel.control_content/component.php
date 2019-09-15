<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(CModule::IncludeModule('iblock'))
{
    $arResult = array();
    
    if(!isset($arParams['GET_ONLY_CONTENT']))
    {
        $imagesClasses = array(
            8 => 'control-content-photos',
            6 => 'content-comments-content',
            5 => 'control-content-audio',
            4 => 'control-content-video',
            3 => 'control-content-poems',
            2 => 'control-content-comments',
            1 => 'control-content-news'
        );

        $arFilter = array(
            'TYPE' => $arParams['IBLOCKS_TYPE'],
            '!ID' => 7
        );

        $cIBlocks = CIBlock::GetList(array('ID' => 'DESC'), $arFilter);

        if($cIBlocks)
        {
            while($cIBlock = $cIBlocks->GetNext())
            {
                $cIBlock['CLASS_TO_ICON'] = $imagesClasses[$cIBlock['ID']];
                $arResult['CIBLOCKS'][] = $cIBlock;
            }
        }
    }
    else
    {
        $nPageSize = 1;
        $iblockID = $arParams['IBLOCK_TO_LOAD'];
        
        $iblockCode = CIBlock::GetByID($iblockID);
        
        if($iblockCode)
        {
            $iblockCode = $iblockCode->Fetch()['CODE'];
            $arParams['IBLOCK_CODE'] = $iblockCode;
        }

        function getElements($iblockID, $nPageSize, &$sectionData = false)
        {
            if($sectionData != false)
            {
                $arNavParams = array(
                    'bShowAll' => false,
                    'nPageSize' => $nPageSize
                );

                $arFilter = array(
                    'IBLOCK_ID' => $iblockID,
                    'IBLOCK_SECTION_ID' => $sectionData['ID']
                );

                $arSelect = array(
                    'ID',
                    'IBLOCK_ID',
                    'IBLOCK_CODE',
                    'NAME',
                    'DATE_ACTIVE_FROM',
                    'CODE'
                );

                if($arParams['IBLOCK_TO_LOAD'] == 4)
                {
                    $arSelect[] = 'PROPERTY_VIDEO_DURATION';
                }
                else if($arParams['IBLOCK_TO_LOAD'] == 5)
                {
                    $arSelect[] = 'PROPERTY_AUDIO_DURATION';
                }

                $elements = CIBlockElement::GetList(array('ID' => 'DESC'), $arFilter, false, $arNavParams, $arSelect);

                if($elements)
                {
                    while($element = $elements->GetNext())
                    {
                        $sectionData['SECTION_ELEMENTS'][] = $element;
                    }

                    $sectionData['ELEMENTS_FROM_SECTION_NAV_STRING'] = $elements->GetPageNavStringEx($backURL = false, 'Элементы', 'sshepelev', false, false, $arNavParams);
                }
            }
            else
            {
                $arNavParams = array(
                    'bShowAll' => false,
                    'nPageSize' => $nPageSize
                );

                $arFilter = array(
                    'IBLOCK_ID' => $iblockID
                );

                $arSelect = array(
                    'ID',
                    'IBLOCK_ID',
                    'IBLOCK_CODE',
                    'NAME',
                    'DATE_ACTIVE_FROM',
                    'CODE'
                );

                if($arParams['IBLOCK_TO_LOAD'] == 4)
                {
                    $arSelect[] = 'PROPERTY_VIDEO_DURATION';
                }
                else if($arParams['IBLOCK_TO_LOAD'] == 5)
                {
                    $arSelect[] = 'PROPERTY_AUDIO_DURATION';
                }

                $elements = CIBlockElement::GetList(array('ID' => 'DESC'), $arFilter, false, $arNavParams, $arSelect);

                if($elements)
                {
                    $conclusionArray = array();
                    
                    while($element = $elements->GetNext())
                    {
                        $conclusionArray['IBLOCK_ELEMENTS'][] = $element;
                    }

                    $conclusionArray['IBLOCK_NAV_STRING'] = $elements->GetPageNavStringEx($backURL = false, 'Элементы', 'sshepelev', false, false, $arNavParams);
                    
                    return $conclusionArray;
                }
            }
        }
        
        if(!isset($_GET['SECTION_ID']))
        {
            $arSectionNavParams = array(
                'bShowAll' => false,
                'nPageSize' => $nPageSize,
                'BASE_LINK' => '/admin-panel/ajax/control-content.php?IBLOCK_ID=' . $arParams['IBLOCK_TO_LOAD']
            );

            $arSectionFilter = array(
                'IBLOCK_ID' => $iblockID
            );

            $arSectionSelect = array(
                'ID',
                'IBLOCK_ID',
                'CODE',
                'NAME',
                'DATE_CREATE'
            );

            $sections = CIBlockSection::GetList(array('NAME' => 'DESC'), $arSectionFilter, false, $arSectionSelect, $arSectionNavParams);
            $sectionList = array();

            if($sections)
            {
                while($section = $sections->GetNext())
                {
                    $sectionList[$section['ID']] = $section;
                }

                if(count($sectionList) > 0)
                {
                    foreach($sectionList as &$section)
                    {  
                        getElements($iblockID, $nPageSize, $section);
                    }

                    $arResult['SECTION_LIST'] = $sectionList;
                    $arResult['SECTION_NAV_STRING'] = $sections->GetPageNavStringEx($backURL = false, 'Разделы', 'sshepelev', false, false, $arSectionNavParams);
                }
                else
                {
                    $arResult = getElements($iblockID, $nPageSize);
                }
            }
        }
        else
        {
            $sectionID = htmlspecialcharsBX($_GET['SECTION_ID']);
            
            $sectionCode = CIBlockSection::GetByID($sectionID);
            
            if($sectionCode)
            {
                $arResult['SECTION_CODE'] = $sectionCode->Fetch()['CODE'];
            }
                
            $arResult['ID'] = $sectionID;
            
            getElements($iblockID, $nPageSize, $arResult);
        }
        
        /*echo '<pre>';
        print_r($arResult);
        echo '</pre>';
        die();*/
    }
    
    $this->includeComponentTemplate();
}
?>