<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
session_start();

if(CModule::IncludeModule('iblock'))
{
    $arNavParams = array(
        'bShowAll' => false,
        'nPageSize' => 20
    );
    
    $arFilter = array(
        'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
        'IBLOCK_ID' => $arParams['IBLOCK_ID'],
        'SECTION_ID' => $arParams['IBLOCK_SECTION'],
        'PROPERTY_NEWS_ID' => $arParams['NEWS_ID']
    );
    
    $arSelect = array(
        'ID',
        'IBLOCK_ID',
        'DATE_ACTIVE_FROM',
        'PROPERTY_USER_NAME',
        'PROPERTY_USER_EMAIL',
        'PROPERTY_USER_PHOTO',
        'PROPERTY_COMMENT_TEXT',
        'PROPERTY_NEWS_ID'
    );
    
    $comments = CIBlockElement::GetList(array('DATE_ACTIVE_FROM' => 'DESC'), $arFilter, false, $arNavParams, $arSelect);
    
    if($comments)
    {
        $arResult = array();
        
        while($comment = $comments->GetNext())
        {  
            if(empty($comment['PROPERTY_USER_PHOTO_VALUE']))
            {
                $comment['PROPERTY_USER_PHOTO_VALUE'] = CFile::GetPath(3);
            }
            
            $comment['DATE_ACTIVE_FROM'] = FormatDate('d F, Y г. в H:i', MakeTimeStamp($comment['DATE_ACTIVE_FROM'], 'DD.MM.YYYY HH:MI:SS'));
            
            $arResult['COMMENTS'][] = $comment;
        }
        
        $arResult['NAV_STRING'] = $comments->GetPageNavStringEx($backNav = false, 'Комментарии', 'sshepelev', false, false, $arNavParams);
        $arResult['CAPTCHA_CODE'] = $APPLICATION->CaptchaGetCode();
        
        if(isset($_SESSION['INFORMATION_UPDATE']))
        {
            $arResult['INFORMATION_UPDATE'] = $_SESSION['INFORMATION_UPDATE'];
            
            unset($_SESSION['INFORMATION_UPDATE']);
        }
        else if(isset($_SESSION['UPLOAD_ERROR']))
        {
            $arResult['UPLOAD_ERROR'] = $_SESSION['UPLOAD_ERROR'];
            
            unset($_SESSION['UPLOAD_ERROR']);
        }
        else if(isset($_SESSION['CAPTCHA_WRONG']))
        {
            $arResult['CAPTCHA_WRONG'] = $_SESSION['CAPTCHA_WRONG'];
            
            unset($_SESSION['CAPTCHA_WRONG']);
        }
    }
    
    $this->includeComponentTemplate();
}
?>