<?
namespace UploadImagesContext;

class UploadImages
{
	public static function upload($files, $callback, $collectionId, $multiple = false, $backPage = false)
	{
		$resultCall = array();
		
		if(\count($files) > 0)
		{
			foreach($files as $kFile => $file)
			{
				if(!empty($file['name']))
				{
					
					$fileName = $file['name'];
					
					if($file['error'] == 0)
					{	
						if(\CModule::IncludeModule("fileman"))
						{
							\CMedialib::Init();
							
							$fileMimeType = $file['type'];
							$fileMimeType = \explode('/', $fileMimeType);
							$fileMimeType = \end($fileMimeType);
							
							$imageTypes = \CMedialib::GetTypes();
							$imageTypes = \explode(',', $imageTypes[0]['ext']);
							
							$fileExt = \explode('.', $fileName);
							$fileExt = \end($fileExt);
							
							$fileSize = $file['size'];
							$maxSize = \CMedialib::getMaximumFileUploadSize();
							
							if(\in_array($fileExt, $imageTypes))
							{
								if(\in_array($fileMimeType, $imageTypes))
								{
									if($fileSize <= $maxSize)
									{
										$arFields = array(
											"file" => $file,
											"path" => false,
											"arFields" => 
												Array(
													"ID" => 0,
													"NAME" => $fileName
												),
											"arCollections" => Array($collectionId)
										);

										$arItem = \CMedialibItem::Edit($arFields);
										$arItem = \CFile::MakeFileArray($arItem['PATH']);
										
										if($arItem)
										{	
											if($multiple)
											{
												$arItem['originalName'] = $file['name'];
												$resultCall[] = $callback($arItem);
											}
											else
											{
												$resultCall = $callback($arItem);
											}
											
											$aKeys = array_keys($files);
											
											if($kFile == $aKeys[count($aKeys) - 1])
											{	
												if(!$multiple)
												{
													if($backPage === false)
													{
														echo \json_encode(
															array(
																'loadDone' => \str_replace('\n', '', \trim(\htmlspecialcharsBack($resultCall)))
															)
														);
													}
													else
													{
														return array(
															'loadDone' => true
														);
													}
												}
												else
												{
													echo \json_encode(
														array(
															'loadDone' => $resultCall
														)
													);
												}
											}
										}
										else
										{
											$resultCall = 'При загрузке файла: ' . $fileName . ' возникла ошибка.';
											
											if($backPage === false)
											{
												echo \json_encode(
													array(
														'loadFailed' => $resultCall
													)
												);
												
												die();
											}
											else
											{
												return array(
													'loadFailed' => $resultCall
												);
											}
										}
									}
									else
									{
										$naturalSize = $maxSize / 1000;
										
										$resultCall = 'Файл <b>' . $fileName . '</b> превышает максимальный размер: '
										. $naturalSize . ' КБ.';
										
										if($backPage === false)
										{
											echo \json_encode(
												array(
													'loadFailed' => $resultCall
												)
											);
											
											die();
										}
										else
										{
											return array(
												'loadFailed' => $resultCall
											);
										}
									}
								}
								else
								{
									$resultCall = 'Файл содержит запрещённое расширение: ' . $fileMimeType  . '.';
								
									if($backPage === false)
									{
										echo \json_encode(
											array(
												'loadFailed' => $resultCall
											)
										);
										
										die();
									}
									else
									{
										return array(
											'loadFailed' => $resultCall
										);
									}
								}
							}
							else
							{
								$resultCall = 'Файл содержит запрещённое расширение: ' . $fileExt . '.';
								
								if($backPage === false)
								{
									echo \json_encode(
										array(
											'loadFailed' => $resultCall
										)
									);
									
									die();
								}
								else
								{
									return array(
										'loadFailed' => $resultCall
									);
								}
							}
						}
						else
						{
							$resultCall = 'При загрузке файла: ' . $fileName . ' возникла ошибка.';
							
							if($backPage === false)
							{
								echo \json_encode(
									array(
										'loadFailed' => $resultCall
									)
								);
								
								die();
							}
							else
							{
								return array(
									'loadFailed' => $resultCall
								);
							}
						}
					}
				}
				else
				{
					$resultCall = $callback();
					
					if($backPage === false)
					{
						echo \json_encode(
							array(
								'loadDone' => $resultCall
							)
						);
					}
					else
					{
						return array(
							'loadDone' => $resultCall
						);
					}
				}
			}
		}
	}
}
?>