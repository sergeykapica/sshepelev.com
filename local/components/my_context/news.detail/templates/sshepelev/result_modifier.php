<?
$getUser = $USER->GetByID($arResult["FIELDS"]["CREATED_BY"]);

if($getUser)
{
    $getUser = $getUser->Fetch();
    $getUser['PERSONAL_PHOTO'] = CFile::GetPath($getUser['PERSONAL_PHOTO']);
    
    $arResult["FIELDS"]['USER_ADDED_INFO'] = $getUser;
}
?>