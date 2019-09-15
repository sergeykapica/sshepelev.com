<?
namespace CheckObjectNamespace;

class CheckObject
{
	public static function checkEmail($email)
	{
		$arFilter = array(
			'=EMAIL' => $email
		);
		
		$arSelect = array(
			'SELECT' => array(
				'ID',
				'IBLOCK_ID',
				'EMAIL',
				'LOGIN',
				'CHECKWORD'
			)
		);
		
		return $usersList = \CUser::GetList($by = 'ID', $order = 'ASC', $arFilter, $arSelect);
	}
}
?>