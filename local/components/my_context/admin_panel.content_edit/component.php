<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(CModule::IncludeModule('iblock'))
{
    function getSections($iblockID, $id = false)
    {
        $sectionsFilter = array(
            'IBLOCK_ID' => $iblockID
        );
        
        if($id != false)
        {
            $sectionsFilter['ID'] = $id;
        }

        $sectionsSelect = array(
            'ID',
            'IBLOCK_ID',
            'NAME'
        );

        $sections = CIBlockSection::GetList(array('NAME' => 'DESC'), $sectionsFilter, false);

        if($sections)
        {
            $sectionList = array();
            
            while($section = $sections->GetNext())
            {
                $sectionList[] = $section;
            }

            if(count($sectionList) <= 0)
            {
                $sectionList = array();
            }
            
            return $sectionList;
        }
    }
    
    function getNewsList()
    {
        $arFilter = array(
            'IBLOCK_ID' => 1
        );

        $arSelect = array(
            'ID',
            'IBLOCK_ID',
            'NAME'
        );

        $newsList = CIBlockElement::GetList(array('ID' => 'DESC'), $arFilter, false, false, $arSelect);

        if($newsList)
        {
            $appropriateNews = array();

            while($news = $newsList->GetNext())
            {
                $appropriateNews[] = $news;
            }

            return $appropriateNews;
        }
    }
    
    if(isset($arParams['ELEMENT_DATA']))
    {
        $arResult = array();

        $iblockID = $arParams['ELEMENT_DATA']['IBLOCK_ID'];

        $arResult['SECTION_LIST'] = getSections($iblockID);
        $arParams['ELEMENT_DATA']['SECTION_FOR_ELEMENT'] = getSections($iblockID, $arParams['ELEMENT_DATA']['IBLOCK_SECTION_ID']);
        
        if($arParams['IBLOCK_CODE'] == 'comments')
        {
            $arParams['ELEMENT_DATA']['NEWS_LIST'] = getNewsList();
        }
    }
    else
    {
        $IBlockFilter = array(
            'CODE' => $arParams['IBLOCK_CODE']
        );
        
        $cIBlock = CIBlock::GetList(array('ID' => 'DESC'), $IBlockFilter);
        
        if($cIBlock)
        {
            $arParams['IBLOCK_ID'] = $cIBlock->Fetch()['ID'];
            
            if($arParams['IBLOCK_CODE'] == 'comments')
            {
                $arParams['NEWS_LIST'] = getNewsList();
                $arResult['SECTION_LIST'] = getSections($arParams['IBLOCK_ID']);
            }
        }
    }
    
    if(isset($_SESSION['ELEMENT_ACTION_RESULT']))
    {
        $arResult['ELEMENT_SUCCESS'] = $_SESSION['ELEMENT_ACTION_RESULT'];

        unset($_SESSION['ELEMENT_ACTION_RESULT']);
    }
    
    if(isset($_SESSION['SECTION_ACTION_RESULT']))
    {
        $arResult['SECTION_SUCCESS'] = $_SESSION['SECTION_ACTION_RESULT'];

        unset($_SESSION['SECTION_ACTION_RESULT']);
    }
    
    
    if(isset($_SESSION['UPLOAD_ERROR']))
    {
        $arResult['UPLOAD_ERROR'] = $_SESSION['UPLOAD_ERROR'];

        unset($_SESSION['UPLOAD_ERROR']);
    }
}
    
$this->includeComponentTemplate();
?>