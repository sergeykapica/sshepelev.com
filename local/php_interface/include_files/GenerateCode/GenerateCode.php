<?
namespace GenerateCodeNamespace;

class GenerateCode
{
	public static function generateNewPassword($length)
	{
		$alphabetRange = range('a', 'z');
		$numbersRange = range(0, 9);
		$ourRange = array_merge($alphabetRange, $numbersRange);
		$result = '';

		for($i = 0; $i < $length; $i++)
		{
			$result .= $ourRange[rand(0, ( count($ourRange) - 1 ))];
		}

		return $result;
	}
}
?>