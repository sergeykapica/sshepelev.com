<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$APPLICATION->SetAdditionalCss(SITE_TEMPLATE_PATH . '/css/validatorObject.css');
?>

<div class="content-edit-wrapper">
    
    <? // edit news ?>
    
    <?if($arParams['IBLOCK_CODE'] == 'news'):?>
        <div class="content-edit-headline"><?=GetMessage('IBLOCK_NEWS_NAME');?></div>
        <?if(isset($arParams['ELEMENT_DATA'])):?>
            <div class="edit-buttons-wrapper">
                <button class="edit-action-button edit-element action-button-active"><?=GetMessage('ADD_NEWS_BUTTON');?></button>
                <button class="edit-action-button edit-category"><?=GetMessage('ADD_NEWS_CATEGORY_BUTTON');?></button>
            </div>
            <div class="edit-action-wrapper">
                <div class="edit-action-container">
                    <div class="edit-action-block edit-element action-block-active">
                        <form action="/handlers/admin-panel/content-action" method="post" id="content-edit-form">
                            <section class="edit-form-section">
                                <div class="edit-form-question">
                                    <span class="form-question-text"><?=GetMessage('NEWS_NAME');?>:</span>
                                    <span class="form-question-required"></span>
                                </div>
                                <div class="edit-form-answer">
                                    <input type="text" name="NEWS_NAME" value="<?=$arParams['ELEMENT_DATA']['NAME'];?>" class="edit-form-input form-input-text form-input"/>
                                </div>
                            </section>
                            <section class="edit-form-section">
                                <div class="edit-form-question">
                                    <span class="form-question-text"><?=GetMessage('NEWS_TEXT');?>:</span>
                                    <span class="form-question-required"></span>
                                </div>
                                <div class="edit-form-answer">
                                    <?$APPLICATION->IncludeComponent(
                                        "my_context:fileman.full_editor",
                                        "sshepelev",
                                        Array(
                                            'EDITOR_HEIGHT' => 400,
                                            'EDITOR_TEXTAREA_NAME' => 'NEWS_TEXT',
                                            'EDITOR_TEXTAREA_CLASSNAME' => 'form-input textarea',
                                            'EDITOR_TEXTAREA_VALUE' => $arParams['ELEMENT_DATA']['DETAIL_TEXT']
                                        )
                                    );?>
                                </div>
                            </section>
                            <section class="edit-form-section">
                                <div class="edit-form-question">
                                    <span class="form-question-text"><?=GetMessage('NEWS_CATEGORIES');?>:</span>
                                </div>
                                <div class="edit-form-answer">
                                    <select name="NEWS_CATEGORY" class="edit-form-input form-input-text form-input">
                                        <?if(count($arResult['SECTION_LIST']) > 0):?>
                                            <?foreach($arResult['SECTION_LIST'] as $section):?>
                                                <option value="<?=$section['ID'];?>"><?=$section['NAME'];?></option>
                                            <?endforeach;?>
                                        <?else:?>
                                            <option value="NONE_ACTIVE_CATEGORIES"><?=GetMessage('NONE_ACTIVE_CATEGORIES');?></option>
                                        <?endif;?>
                                    </select>
                                </div>
                            </section>
                            <section class="edit-form-section">
                                <input type="hidden" name="ELEMENT_ID" value="<?=$arParams['ELEMENT_DATA']['ID'];?>" />
                                <input type="hidden" name="IBLOCK_ID" value="<?=$arParams['ELEMENT_DATA']['IBLOCK_ID'];?>" />
                                <input type="hidden" name="ACTION_TYPE" value="UPDATE" />
                                <div id="result-message">
                                    <?if(isset($arResult['ELEMENT_SUCCESS'])):?>
                                        <?if($arResult['ELEMENT_SUCCESS'] == 'ADD'):?>
                                            <span class="result-message-success">
                                                <span><?=GetMessage('UPDATE_NEWS_SUCCESS');?></span>
                                                <div class="message-success-icon"></div>
                                            </span>
                                        <?else:?>
                                            <span class="result-message-error">
                                                <span><?=GetMessage('UPDATE_NEWS_ERROR');?></span>
                                                <div class="message-error-icon"></div>
                                            </span>
                                        <?endif;?>
                                    <?endif;?>
                                </div>
                                <input type="submit" value="<?=GetMessage('EDIT_FORM_SUBMIT');?>" class="form-submit-button" class="animated" />
                            </section> 
                        </form>
                    </div>
                    <?if($arParams['ELEMENT_DATA']['IBLOCK_SECTION_ID'] != ''):?>
                        <div class="edit-action-block edit-category">
                            <form action="/handlers/admin-panel/content-action" method="post" id="category-edit-form">
                                <section class="edit-form-section">
                                    <div class="edit-form-question">
                                        <span class="form-question-text"><?=GetMessage('NEWS_CATEGORY_NAME');?>:</span>
                                        <span class="form-question-required"></span>
                                    </div>
                                    <div class="edit-form-answer">
                                        <input type="text" name="NEWS_CATEGORY_NAME" value="<?=$arParams['ELEMENT_DATA']['SECTION_FOR_ELEMENT'][0]['NAME'];?>" class="edit-form-input form-input-text form-input"/>
                                    </div>
                                </section>
                                <section class="edit-form-section">
                                    <div class="edit-form-question">
                                        <span class="form-question-text"><?=GetMessage('NEWS_CATEGORY_DESCRIPTION');?>:</span>
                                        <span class="form-question-required"></span>
                                    </div>
                                    <div class="edit-form-answer">
                                        <?$APPLICATION->IncludeComponent(
                                            "my_context:fileman.full_editor",
                                            "sshepelev",
                                            Array(
                                                'EDITOR_HEIGHT' => 400,
                                                'EDITOR_TEXTAREA_NAME' => 'NEWS_CATEGORY_DESCRIPTION',
                                                'EDITOR_TEXTAREA_CLASSNAME' => 'form-input textarea',
                                                'EDITOR_TEXTAREA_VALUE' => $arParams['ELEMENT_DATA']['SECTION_FOR_ELEMENT'][0]['DESCRIPTION']
                                            )
                                        );?>
                                    </div>
                                </section>
                                <section class="edit-form-section">
                                    <input type="hidden" name="IBLOCK_ID" value="<?=$arParams['ELEMENT_DATA']['IBLOCK_ID'];?>" />
                                    <input type="hidden" name="SECTION_ID" value="<?=$arParams['ELEMENT_DATA']['IBLOCK_SECTION_ID'];?>" />
                                    <input type="hidden" name="ACTION_TYPE" value="UPDATE" />
                                    <input type="hidden" name="ACTION_CATEGORY" value="1" />
                                    <div id="result-message">
                                        <?if(isset($arResult['SECTION_SUCCESS'])):?>
                                            <?if($arResult['SECTION_SUCCESS'] == 'ADD'):?>
                                                <span class="result-message-success">
                                                    <span><?=GetMessage('UPDATE_SECTION_SUCCESS');?></span>
                                                    <div class="message-success-icon"></div>
                                                </span>
                                            <?else:?>
                                                <span class="result-message-error">
                                                    <span><?=GetMessage('UPDATE_SECTION_ERROR');?></span>
                                                    <div class="message-error-icon"></div>
                                                </span>
                                            <?endif;?>
                                        <?endif;?>
                                    </div>
                                    <input type="submit" value="<?=GetMessage('EDIT_FORM_SUBMIT');?>" class="form-submit-button" class="animated" />
                                </section> 
                            </form>
                        </div>
                    <?endif;?>
                </div>
            </div>
        <?else:?>
            <div class="edit-buttons-wrapper">
                <button class="edit-action-button edit-element action-button-active"><?=GetMessage('ADD_NEWS_BUTTON');?></button>
                <button class="edit-action-button edit-category"><?=GetMessage('ADD_NEWS_CATEGORY_BUTTON');?></button>
            </div>
            <div class="edit-action-wrapper">
                <div class="edit-action-container">
                    <div class="edit-action-block edit-element action-block-active">
                        <form action="/handlers/admin-panel/content-action" method="post" id="content-edit-form">
                            <section class="edit-form-section">
                                <div class="edit-form-question">
                                    <span class="form-question-text"><?=GetMessage('NEWS_NAME');?>:</span>
                                    <span class="form-question-required"></span>
                                </div>
                                <div class="edit-form-answer">
                                    <input type="text" name="NEWS_NAME" class="edit-form-input form-input-text form-input"/>
                                </div>
                            </section>
                            <section class="edit-form-section">
                                <div class="edit-form-question">
                                    <span class="form-question-text"><?=GetMessage('NEWS_TEXT');?>:</span>
                                    <span class="form-question-required"></span>
                                </div>
                                <div class="edit-form-answer">
                                    <?$APPLICATION->IncludeComponent(
                                        "my_context:fileman.full_editor",
                                        "sshepelev",
                                        Array(
                                            'EDITOR_HEIGHT' => 400,
                                            'EDITOR_TEXTAREA_NAME' => 'NEWS_TEXT',
                                            'EDITOR_TEXTAREA_CLASSNAME' => 'form-input textarea'
                                        )
                                    );?>
                                </div>
                            </section>
                            <section class="edit-form-section">
                                <div class="edit-form-question">
                                    <span class="form-question-text"><?=GetMessage('NEWS_CATEGORIES');?>:</span>
                                </div>
                                <div class="edit-form-answer">
                                    <select name="NEWS_CATEGORY" class="edit-form-input form-input-text form-input">
                                        <?if(count($arResult['SECTION_LIST']) > 0):?>
                                            <?foreach($arResult['SECTION_LIST'] as $section):?>
                                                <option value="<?=$section['ID'];?>"><?=$section['NAME'];?></option>
                                            <?endforeach;?>
                                        <?else:?>
                                            <option value="NONE_ACTIVE_CATEGORIES"><?=GetMessage('NONE_ACTIVE_CATEGORIES');?></option>
                                        <?endif;?>
                                    </select>
                                </div>
                            </section>
                            <section class="edit-form-section">
                                <input type="hidden" name="IBLOCK_ID" value="<?=$arParams['IBLOCK_ID'];?>" />
                                <input type="hidden" name="ACTION_TYPE" value="ADD" />
                                <div id="result-message">
                                    <?if(isset($arResult['ELEMENT_SUCCESS'])):?>
                                        <?if($arResult['ELEMENT_SUCCESS'] == 'ADD'):?>
                                            <span class="result-message-success">
                                                <span><?=GetMessage('ADD_NEWS_SUCCESS');?></span>
                                                <div class="message-success-icon"></div>
                                            </span>
                                        <?else:?>
                                            <span class="result-message-error">
                                                <span><?=GetMessage('ADD_NEWS_ERROR');?></span>
                                                <div class="message-error-icon"></div>
                                            </span>
                                        <?endif;?>
                                    <?endif;?>
                                </div>
                                <input type="submit" value="<?=GetMessage('ADD_FORM_SUBMIT');?>" class="form-submit-button" class="animated" />
                            </section> 
                        </form>
                    </div>
                    <div class="edit-action-block edit-category">
                        <form action="/handlers/admin-panel/content-action" method="post" id="category-edit-form">
                            <section class="edit-form-section">
                                <div class="edit-form-question">
                                    <span class="form-question-text"><?=GetMessage('NEWS_CATEGORY_NAME');?>:</span>
                                    <span class="form-question-required"></span>
                                </div>
                                <div class="edit-form-answer">
                                    <input type="text" name="NEWS_CATEGORY_NAME" class="edit-form-input form-input-text form-input"/>
                                </div>
                            </section>
                            <section class="edit-form-section">
                                <div class="edit-form-question">
                                    <span class="form-question-text"><?=GetMessage('NEWS_CATEGORY_DESCRIPTION');?>:</span>
                                    <span class="form-question-required"></span>
                                </div>
                                <div class="edit-form-answer">
                                    <?$APPLICATION->IncludeComponent(
                                        "my_context:fileman.full_editor",
                                        "sshepelev",
                                        Array(
                                            'EDITOR_HEIGHT' => 400,
                                            'EDITOR_TEXTAREA_NAME' => 'NEWS_CATEGORY_DESCRIPTION',
                                            'EDITOR_TEXTAREA_CLASSNAME' => 'form-input textarea'
                                        )
                                    );?>
                                </div>
                            </section>
                            <section class="edit-form-section">
                                <input type="hidden" name="IBLOCK_ID" value="<?=$arParams['IBLOCK_ID'];?>" />
                                <input type="hidden" name="ACTION_TYPE" value="ADD" />
                                <input type="hidden" name="ACTION_CATEGORY" value="1" />
                                <div id="result-message">
                                    <?if(isset($arResult['SECTION_SUCCESS'])):?>
                                        <?if($arResult['SECTION_SUCCESS'] == 'ADD'):?>
                                            <span class="result-message-success">
                                                <span><?=GetMessage('ADD_SECTION_SUCCESS');?></span>
                                                <div class="message-success-icon"></div>
                                            </span>
                                        <?else:?>
                                            <span class="result-message-error">
                                                <span><?=GetMessage('ADD_SECTION_ERROR');?></span>
                                                <div class="message-error-icon"></div>
                                            </span>
                                        <?endif;?>
                                    <?endif;?>
                                </div>
                                <input type="submit" value="<?=GetMessage('ADD_FORM_SUBMIT');?>" class="form-submit-button" class="animated" />
                            </section> 
                        </form>
                    </div>
                </div>
            </div>
        <?endif;?>
    <?endif;?>
    
    <? // edit comments ?>
    
    <?if($arParams['IBLOCK_CODE'] == 'comments'):?>
        <div class="content-edit-headline"><?=GetMessage('IBLOCK_COMMENT_NAME');?></div>
        <?if(isset($arParams['ELEMENT_DATA'])):?>
            <div class="edit-buttons-wrapper">
                <button class="edit-action-button edit-element action-button-active"><?=GetMessage('ADD_COMMENT_BUTTON');?></button>
                <button class="edit-action-button edit-category"><?=GetMessage('ADD_COMMENT_CATEGORY_BUTTON');?></button>
            </div>
            <div class="edit-action-wrapper">
                <div class="edit-action-container">
                    <div class="edit-action-block edit-element action-block-active">
                        <form action="/handlers/admin-panel/content-action" method="post" enctype="multipart/form-data" id="content-edit-form">
                            <section class="edit-form-section">
                                <div class="edit-form-question">
                                    <span class="form-question-text"><?=GetMessage('COMMENT_USER_NAME');?>:</span>
                                    <span class="form-question-required"></span>
                                </div>
                                <div class="edit-form-answer">
                                    <input type="text" name="COMMENT_USER_NAME" value="<?=$arParams['ELEMENT_DATA']['PROPERTY_USER_NAME_VALUE'];?>" class="edit-form-input form-input-text form-input"/>
                                </div>
                            </section>
                            <section class="edit-form-section">
                                <div class="edit-form-question">
                                    <span class="form-question-text"><?=GetMessage('COMMENT_USER_EMAIL');?>:</span>
                                    <span class="form-question-required"></span>
                                </div>
                                <div class="edit-form-answer">
                                    <input type="text" name="COMMENT_USER_EMAIL" value="<?=$arParams['ELEMENT_DATA']['PROPERTY_USER_EMAIL_VALUE'];?>" class="edit-form-input form-input-text form-input"/>
                                </div>
                            </section>
                            <section class="edit-form-section">
                                <div class="edit-form-question">
                                    <span class="form-question-text"><?=GetMessage('COMMENT_USER_PHOTO');?>:</span>
                                </div>
                                <div class="edit-form-answer">
                                    <label class="form-file-label">
                                        <div class="form-file-wrapper">
                                            <div class="form-file-sfile"><?=GetMessage('SELECT_FILE');?>:</div>
                                            <div class="form-file-infile"></div>
                                        </div>
                                        <input type="file" name="COMMENT_USER_PHOTO" class="form-file"/>
                                    </label>
                                    
                                    <script type="text/javascript">
                                        $(window).ready(function()
                                        {
                                            var formFile = $('.form-file');
                                            
                                            formFile.on('change', function(e)
                                            {
                                                var thisFile = $(this);
                                                
                                                var fileNameInsertField = thisFile.parent().find('.form-file-infile');
                                                
                                                fileNameInsertField.text(thisFile[0].files[0].name);
                                            });
                                        });
                                    </script>
                                </div>
                            </section>
                            <section class="edit-form-section">
                                <div class="edit-form-question">
                                    <span class="form-question-text"><?=GetMessage('COMMENT_TEXT');?>:</span>
                                    <span class="form-question-required"></span>
                                </div>
                                <div class="edit-form-answer">
                                    <?$APPLICATION->IncludeComponent(
                                        "my_context:fileman.full_editor",
                                        "sshepelev",
                                        Array(
                                            'EDITOR_HEIGHT' => 400,
                                            'EDITOR_TEXTAREA_NAME' => 'COMMENT_TEXT',
                                            'EDITOR_TEXTAREA_CLASSNAME' => 'form-input textarea',
                                            'EDITOR_TEXTAREA_VALUE' => $arParams['ELEMENT_DATA']['PROPERTY_COMMENT_TEXT_VALUE']['TEXT']
                                        )
                                    );?>
                                </div>
                            </section>
                            <?if(isset($arParams['ELEMENT_DATA']['NEWS_LIST'])):?>
                                <section class="edit-form-section">
                                    <div class="edit-form-question">
                                        <span class="form-question-text"><?=GetMessage('COMMENT_NEWS_ID');?>:</span>
                                    </div>
                                    <div class="edit-form-answer">
                                        <select name="COMMENT_NEWS_ID" class="edit-form-input form-input-text form-input">
                                            <?if(count($arParams['ELEMENT_DATA']['NEWS_LIST']) > 0):?>
                                                <?foreach($arParams['ELEMENT_DATA']['NEWS_LIST'] as $news):?>
                                                    <option value="<?=$news['ID'];?>"><?=$news['NAME'];?></option>
                                                <?endforeach;?>
                                            <?else:?>
                                                <option value="NONE_ACTIVE_NEWS"><?=GetMessage('NONE_ACTIVE_NEWS');?></option>
                                            <?endif;?>
                                        </select>
                                    </div>
                                </section>
                            <?endif;?>
                            <section class="edit-form-section">
                                <div class="edit-form-question">
                                    <span class="form-question-text"><?=GetMessage('COMMENTS_CATEGORY');?>:</span>
                                </div>
                                <div class="edit-form-answer">
                                    <select name="COMMENTS_CATEGORY" class="edit-form-input form-input-text form-input">
                                        <?if(count($arResult['SECTION_LIST']) > 0):?>
                                            <?foreach($arResult['SECTION_LIST'] as $section):?>
                                                <option value="<?=$section['ID'];?>"><?=$section['NAME'];?></option>
                                            <?endforeach;?>
                                        <?else:?>
                                            <option value="NONE_ACTIVE_CATEGORIES"><?=GetMessage('NONE_ACTIVE_CATEGORIES');?></option>
                                        <?endif;?>
                                    </select>
                                </div>
                            </section> 
                            <section class="edit-form-section">
                                <input type="hidden" name="ELEMENT_ID" value="<?=$arParams['ELEMENT_DATA']['ID'];?>" />
                                <input type="hidden" name="IBLOCK_ID" value="<?=$arParams['ELEMENT_DATA']['IBLOCK_ID'];?>" />
                                <input type="hidden" name="ACTION_TYPE" value="UPDATE" />
                                <div id="result-message">
                                    <?if(isset($arResult['ELEMENT_SUCCESS'])):?>
                                        <?if($arResult['ELEMENT_SUCCESS'] == 'ADD'):?>
                                            <span class="result-message-success">
                                                <span><?=GetMessage('UPDATE_COMMENT_SUCCESS');?></span>
                                                <div class="message-success-icon"></div>
                                            </span>
                                        <?else:?>
                                            <span class="result-message-error">
                                                <span><?=GetMessage('UPDATE_COMMENT_ERROR');?></span>
                                                <div class="message-error-icon"></div>
                                            </span>
                                        <?endif;?>
                                    <?elseif(isset($arResult['UPLOAD_ERROR'])):?>
                                        <span class="result-message-error">
                                            <span><?=GetMessage('UPLOAD_IMAGE_ERROR');?></span>
                                            <div class="message-error-icon"></div>
                                        </span>
                                    <?endif;?>
                                </div>
                                <input type="submit" value="<?=GetMessage('EDIT_FORM_SUBMIT');?>" class="form-submit-button" class="animated" />
                            </section> 
                        </form>
                    </div>
                    <?if($arParams['ELEMENT_DATA']['IBLOCK_SECTION_ID'] != ''):?>
                        <div class="edit-action-block edit-category">
                            <form action="/handlers/admin-panel/content-action" method="post" id="category-edit-form">
                                <section class="edit-form-section">
                                    <div class="edit-form-question">
                                        <span class="form-question-text"><?=GetMessage('COMMENT_CATEGORY_NAME');?>:</span>
                                        <span class="form-question-required"></span>
                                    </div>
                                    <div class="edit-form-answer">
                                        <input type="text" name="COMMENT_CATEGORY_NAME" value="<?=$arParams['ELEMENT_DATA']['SECTION_FOR_ELEMENT'][0]['NAME'];?>" class="edit-form-input form-input-text form-input"/>
                                    </div>
                                </section>
                                <section class="edit-form-section">
                                    <div class="edit-form-question">
                                        <span class="form-question-text"><?=GetMessage('COMMENT_CATEGORY_DESCRIPTION');?>:</span>
                                        <span class="form-question-required"></span>
                                    </div>
                                    <div class="edit-form-answer">
                                        <?$APPLICATION->IncludeComponent(
                                            "my_context:fileman.full_editor",
                                            "sshepelev",
                                            Array(
                                                'EDITOR_HEIGHT' => 400,
                                                'EDITOR_TEXTAREA_NAME' => 'COMMENT_CATEGORY_DESCRIPTION',
                                                'EDITOR_TEXTAREA_CLASSNAME' => 'form-input textarea',
                                                'EDITOR_TEXTAREA_VALUE' => $arParams['ELEMENT_DATA']['SECTION_FOR_ELEMENT'][0]['DESCRIPTION']
                                            )
                                        );?>
                                    </div>
                                </section>
                                <section class="edit-form-section">
                                    <input type="hidden" name="IBLOCK_ID" value="<?=$arParams['ELEMENT_DATA']['IBLOCK_ID'];?>" />
                                    <input type="hidden" name="SECTION_ID" value="<?=$arParams['ELEMENT_DATA']['IBLOCK_SECTION_ID'];?>" />
                                    <input type="hidden" name="ACTION_TYPE" value="UPDATE" />
                                    <input type="hidden" name="ACTION_CATEGORY" value="1" />
                                    <div id="result-message">
                                        <?if(isset($arResult['SECTION_SUCCESS'])):?>
                                            <?if($arResult['SECTION_SUCCESS'] == 'ADD'):?>
                                                <span class="result-message-success">
                                                    <span><?=GetMessage('UPDATE_SECTION_SUCCESS');?></span>
                                                    <div class="message-success-icon"></div>
                                                </span>
                                            <?else:?>
                                                <span class="result-message-error">
                                                    <span><?=GetMessage('UPDATE_SECTION_ERROR');?></span>
                                                    <div class="message-error-icon"></div>
                                                </span>
                                            <?endif;?>
                                        <?endif;?>
                                    </div>
                                    <input type="submit" value="<?=GetMessage('EDIT_FORM_SUBMIT');?>" class="form-submit-button" class="animated" />
                                </section> 
                            </form>
                        </div>
                    <?endif;?>
                </div>
            </div>
        <?else:?>
            <div class="edit-buttons-wrapper">
                <button class="edit-action-button edit-element action-button-active"><?=GetMessage('ADD_COMMENT_BUTTON');?></button>
                <button class="edit-action-button edit-category"><?=GetMessage('ADD_COMMENT_CATEGORY_BUTTON');?></button>
            </div>
            <div class="edit-action-wrapper">
                <div class="edit-action-container">
                    <div class="edit-action-block edit-element action-block-active">
                        <form action="/handlers/admin-panel/content-action" method="post" enctype="multipart/form-data" id="content-edit-form">
                            <section class="edit-form-section">
                                <div class="edit-form-question">
                                    <span class="form-question-text"><?=GetMessage('COMMENT_USER_NAME');?>:</span>
                                    <span class="form-question-required"></span>
                                </div>
                                <div class="edit-form-answer">
                                    <input type="text" name="COMMENT_USER_NAME" value="<?=$arParams['ELEMENT_DATA']['PROPERTY_USER_NAME_VALUE'];?>" class="edit-form-input form-input-text form-input"/>
                                </div>
                            </section>
                            <section class="edit-form-section">
                                <div class="edit-form-question">
                                    <span class="form-question-text"><?=GetMessage('COMMENT_USER_EMAIL');?>:</span>
                                    <span class="form-question-required"></span>
                                </div>
                                <div class="edit-form-answer">
                                    <input type="text" name="COMMENT_USER_EMAIL" value="<?=$arParams['ELEMENT_DATA']['PROPERTY_USER_EMAIL_VALUE'];?>" class="edit-form-input form-input-text form-input"/>
                                </div>
                            </section>
                            <section class="edit-form-section">
                                <div class="edit-form-question">
                                    <span class="form-question-text"><?=GetMessage('COMMENT_USER_PHOTO');?>:</span>
                                </div>
                                <div class="edit-form-answer">
                                    <label class="form-file-label">
                                        <div class="form-file-wrapper">
                                            <div class="form-file-sfile"><?=GetMessage('SELECT_FILE');?>:</div>
                                            <div class="form-file-infile"></div>
                                        </div>
                                        <input type="file" name="COMMENT_USER_PHOTO" class="form-file"/>
                                    </label>
                                    
                                    <script type="text/javascript">
                                        $(window).ready(function()
                                        {
                                            var formFile = $('.form-file');
                                            
                                            formFile.on('change', function(e)
                                            {
                                                var thisFile = $(this);
                                                
                                                var fileNameInsertField = thisFile.parent().find('.form-file-infile');
                                                
                                                fileNameInsertField.text(thisFile[0].files[0].name);
                                            });
                                        });
                                    </script>
                                </div>
                            </section>
                            <section class="edit-form-section">
                                <div class="edit-form-question">
                                    <span class="form-question-text"><?=GetMessage('COMMENT_TEXT');?>:</span>
                                    <span class="form-question-required"></span>
                                </div>
                                <div class="edit-form-answer">
                                    <?$APPLICATION->IncludeComponent(
                                        "my_context:fileman.full_editor",
                                        "sshepelev",
                                        Array(
                                            'EDITOR_HEIGHT' => 400,
                                            'EDITOR_TEXTAREA_NAME' => 'COMMENT_TEXT',
                                            'EDITOR_TEXTAREA_CLASSNAME' => 'form-input textarea',
                                            'EDITOR_TEXTAREA_VALUE' => $arParams['ELEMENT_DATA']['PROPERTY_COMMENT_TEXT_VALUE']['TEXT']
                                        )
                                    );?>
                                </div>
                            </section>
                            <?if(isset($arParams['NEWS_LIST'])):?>
                                <section class="edit-form-section">
                                    <div class="edit-form-question">
                                        <span class="form-question-text"><?=GetMessage('COMMENT_NEWS_ID');?>:</span>
                                    </div>
                                    <div class="edit-form-answer">
                                        <select name="COMMENT_NEWS_ID" class="edit-form-input form-input-text form-input">
                                            <?if(count($arParams['NEWS_LIST']) > 0):?>
                                                <?foreach($arParams['NEWS_LIST'] as $news):?>
                                                    <option value="<?=$news['ID'];?>"><?=$news['NAME'];?></option>
                                                <?endforeach;?>
                                            <?else:?>
                                                <option value="NONE_ACTIVE_NEWS"><?=GetMessage('NONE_ACTIVE_NEWS');?></option>
                                            <?endif;?>
                                        </select>
                                    </div>
                                </section>
                            <?endif;?>
                            <section class="edit-form-section">
                                <div class="edit-form-question">
                                    <span class="form-question-text"><?=GetMessage('COMMENTS_CATEGORY');?>:</span>
                                </div>
                                <div class="edit-form-answer">
                                    <select name="COMMENTS_CATEGORY" class="edit-form-input form-input-text form-input">
                                        <?if(count($arResult['SECTION_LIST']) > 0):?>
                                            <?foreach($arResult['SECTION_LIST'] as $section):?>
                                                <option value="<?=$section['ID'];?>"><?=$section['NAME'];?></option>
                                            <?endforeach;?>
                                        <?else:?>
                                            <option value="NONE_ACTIVE_CATEGORIES"><?=GetMessage('NONE_ACTIVE_CATEGORIES');?></option>
                                        <?endif;?>
                                    </select>
                                </div>
                            </section> 
                            <section class="edit-form-section">
                                <input type="hidden" name="IBLOCK_ID" value="<?=$arParams['IBLOCK_ID'];?>" />
                                <input type="hidden" name="ACTION_TYPE" value="ADD" />
                                <div id="result-message">
                                    <?if(isset($arResult['ELEMENT_SUCCESS'])):?>
                                        <?if($arResult['ELEMENT_SUCCESS'] == 'ADD'):?>
                                            <span class="result-message-success">
                                                <span><?=GetMessage('ADD_COMMENT_SUCCESS');?></span>
                                                <div class="message-success-icon"></div>
                                            </span>
                                        <?else:?>
                                            <span class="result-message-error">
                                                <span><?=GetMessage('ADD_COMMENT_ERROR');?></span>
                                                <div class="message-error-icon"></div>
                                            </span>
                                        <?endif;?>
                                    <?endif;?>
                                </div>
                                <input type="submit" value="<?=GetMessage('ADD_FORM_SUBMIT');?>" class="form-submit-button" class="animated" />
                            </section> 
                        </form>
                    </div>
                    <div class="edit-action-block edit-category">
                        <form action="/handlers/admin-panel/content-action" method="post" id="category-edit-form">
                            <section class="edit-form-section">
                                <div class="edit-form-question">
                                    <span class="form-question-text"><?=GetMessage('COMMENT_CATEGORY_NAME');?>:</span>
                                    <span class="form-question-required"></span>
                                </div>
                                <div class="edit-form-answer">
                                    <input type="text" name="COMMENT_CATEGORY_NAME" class="edit-form-input form-input-text form-input"/>
                                </div>
                            </section>
                            <section class="edit-form-section">
                                <div class="edit-form-question">
                                    <span class="form-question-text"><?=GetMessage('COMMENT_CATEGORY_DESCRIPTION');?>:</span>
                                    <span class="form-question-required"></span>
                                </div>
                                <div class="edit-form-answer">
                                    <?$APPLICATION->IncludeComponent(
                                        "my_context:fileman.full_editor",
                                        "sshepelev",
                                        Array(
                                            'EDITOR_HEIGHT' => 400,
                                            'EDITOR_TEXTAREA_NAME' => 'COMMENT_CATEGORY_DESCRIPTION',
                                            'EDITOR_TEXTAREA_CLASSNAME' => 'form-input textarea'
                                        )
                                    );?>
                                </div>
                            </section>
                            <section class="edit-form-section">
                                <input type="hidden" name="IBLOCK_ID" value="<?=$arParams['IBLOCK_ID'];?>" />
                                <input type="hidden" name="ACTION_TYPE" value="ADD" />
                                <input type="hidden" name="ACTION_CATEGORY" value="1" />
                                <div id="result-message">
                                    <?if(isset($arResult['SECTION_SUCCESS'])):?>
                                        <?if($arResult['SECTION_SUCCESS'] == 'ADD'):?>
                                            <span class="result-message-success">
                                                <span><?=GetMessage('ADD_SECTION_SUCCESS');?></span>
                                                <div class="message-success-icon"></div>
                                            </span>
                                        <?else:?>
                                            <span class="result-message-error">
                                                <span><?=GetMessage('ADD_SECTION_ERROR');?></span>
                                                <div class="message-error-icon"></div>
                                            </span>
                                        <?endif;?>
                                    <?endif;?>
                                </div>
                                <input type="submit" value="<?=GetMessage('ADD_FORM_SUBMIT');?>" class="form-submit-button" class="animated" />
                            </section> 
                        </form>
                    </div>
                </div>
            </div>
        <?endif;?>
    <?endif;?>
    
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH;?>/js/validatorObject.js"></script>
    
    <script type="text/javascript">
        $(window).ready(function()
        {
            var iblockCode = '<?=$arParams['IBLOCK_CODE'];?>';
            var formSubmitButton = $('.form-submit-button');
            
            formSubmitButton.hover(
            function()
            {
                $(this).addClass('heartBeat');
            },
            function()
            {
                $(this).removeClass('heartBeat');
            }
            );
            
            if(iblockCode == 'news')
            {
                var validatorParams =
                {
                    'NEWS_NAME':
                    {
                        minStr: 3,
                        maxStr: 150
                    },
                    
                    'NEWS_TEXT':
                    {
                        minStr: 3,
                        maxStr: 10000
                    }
                };
                
                var validatorSectionParams =
                {
                    'NEWS_CATEGORY_NAME':
                    {
                        minStr: 3,
                        maxStr: 150
                    },
                    
                    'NEWS_CATEGORY_DESCRIPTION':
                    {
                        minStr: 3,
                        maxStr: 10000
                    }
                };
            }
            
            var validatorObject = new ValidatorObject('.edit-form-question', '.form-question-required', '.form-input', validatorParams, 'answer-error');
            var validatorSectionObject = new ValidatorObject('.edit-form-question', '.form-question-required', '.form-input', validatorSectionParams, 'answer-error');
            
            var contentEditForm = $('#content-edit-form');
            
            contentEditForm.on('submit', function()
            {
                var thisForm = $(this);
                thisForm.find('.answer-error').remove();
                
                validatorObject.checkFields();
                
                if(thisForm.find('.answer-error')[0] !== undefined)
                {
                    return false;
                }
            });
            
            var categoryEditForm = $('#category-edit-form');
            
            categoryEditForm.on('submit', function()
            {
                var thisForm = $(this);
                thisForm.find('.answer-error').remove();
                
                validatorSectionObject.checkFields();
                
                if(thisForm.find('.answer-error')[0] !== undefined)
                {
                    return false;
                }
            });
            
            // edit category
            
            var editButtonsWrapper = $('.edit-buttons-wrapper');
            var editActionBlock = $('.edit-action-block');
            var editActionContainer = $('.edit-action-container');
            
            editButtonsWrapper.on('click', function(e)
            {
                var thisContainer = $(this);
                var target = $(e.target);
                
                if(target[0].tagName == 'BUTTON')
                {
                    thisContainer.find('.action-button-active').removeClass('action-button-active');
                    target.addClass('action-button-active');
                    
                    var apropriatedBlock = editActionContainer.find('.' + target[0].classList[1]);
                    
                    if(!apropriatedBlock.hasClass('action-block-active'))
                    {
                        editActionContainer.animate(
                        {
                            left: '-=' + apropriatedBlock.width()
                        },
                        {
                            duration: 1000,
                            complete: function()
                            {
                                var firstChild = editActionContainer.find('> div:first-child');
                                
                                editActionContainer.append(firstChild);
                                editActionContainer.css('left', 0);
                                editActionContainer.find('.action-block-active').removeClass('action-block-active');
                                
                                apropriatedBlock.addClass('action-block-active');
                            }
                        });
                    }
                }
            });
        });
    </script>
</div>
