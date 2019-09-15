<?
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");
?>

<?
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		if(CModule::IncludeModule('iblock'))
		{
			$elementsData = json_decode($_POST['ELEMENTS_DATA']);
			$errorChecker = false;
			
			/*foreach($elementsData as $element)
			{
				$elementType = htmlspecialcharsBX($element->elementType);
				$elementValue = htmlspecialcharsBX($element->elementValue);
				
				if($elementType == 'section')
				{
					$result = CIBlockSection::Delete($elementValue);
					
					if(!$result->result)
					{
						$errorChecker = true;
					}
				}
				else
				{
					if(!CIBlockElement::Delete($elementValue))
					{
						$errorChecker = true;
					}
				}
			}*/
			
			if($errorChecker === false)
			{
				echo true;
			}
			else
			{
				echo false;
			}
		}
	}
?>