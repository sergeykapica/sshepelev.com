<?
namespace TextHandlerContext;

class TextHandler
{
	public function textToSafeState($text)
	{
		return \htmlspecialcharsBack(\strip_tags(\trim(\htmlspecialcharsBX($text))));
	}
}
?>