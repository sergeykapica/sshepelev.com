<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(CModule::IncludeModule('iblock'))
{
    //Get likes or dizlikes

    $arResult = array();

    $arFilter = array(
        'IBLOCK_ID' => $arParams['LIKES_IBLOCK_ID'],
        '=PROPERTY_IBLOCK_ID' => $arParams['IBLOCK_ID'],
        '=PROPERTY_ELEMENT_IBLOCK_ID' => $arParams['ELEMENT_IBLOCK_ID']
    );

    $arSelect = array(
        'ID',
        'IBLOCK_ID',
        'PROPERTY_USER_LIKE_IP',
        'PROPERTY_LIKE_TYPE',
        'PROPERTY_IBLOCK_ID',
        'PROPERTY_ELEMENT_IBLOCK_ID'
    );

    $result = CIBlockElement::GetList(array('ID' => 'ASC'), $arFilter, false, false, $arSelect);

    if($result)
    {
        if($result->SelectedRowsCount() > 0)
        {
            $currentIP = $_SERVER['REMOTE_ADDR'];
            $likes = 0;
            $dizlikes = 0;

            while($like = $result->GetNext())
            {
                if($like['PROPERTY_LIKE_TYPE_VALUE'] == 'like')
                {
                    $likes += 1;
                }
                else
                {
                    $dizlikes += 1;
                }
                
                if($currentIP == $like['PROPERTY_USER_LIKE_IP_VALUE'])
                {
                    $arResult['LIKE_SYSTEM']['CURRENT_LIKE'] = $like['PROPERTY_LIKE_TYPE_VALUE'];
                }
            }

            $arResult['LIKE_SYSTEM']['LIKES'] = $likes;
            $arResult['LIKE_SYSTEM']['DIZLIKES'] = $dizlikes;
        }
        else
        {
            $arResult['LIKE_SYSTEM']['LIKES'] = 0;
            $arResult['LIKE_SYSTEM']['DIZLIKES'] = 0;
        }
    }
}

$this->includeComponentTemplate();
?>