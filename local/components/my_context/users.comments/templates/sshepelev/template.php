<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/validatorObject.js');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/messageHide.js');
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . '/css/validatorObject.css');
?>

<div class="content-comments">
    <div class="news-comments-headline">Комментарии</div>
    <? if(count($arResult) > 0): ?>
        <div class="news-comments-list">
            <?foreach($arResult['COMMENTS'] as $comment):?>
                <section class="news-comment-item">
                    <div class="news-comment-text"><?=$comment['PROPERTY_COMMENT_TEXT_VALUE']['TEXT'];?></div>
                    <div class="news-comment-information">
                        <div class="news-comment-icon" style="background-image: url(<?=$comment['PROPERTY_USER_PHOTO_VALUE'];?>)"></div>
                        <div class="news-comment-data"><?=$comment['PROPERTY_USER_NAME_VALUE'];?>, <?=$comment['DATE_ACTIVE_FROM'];?></div>
                    </div>
                </section>
            <?endforeach;?>
        </div>
        <div class="pagination"><?=$arResult['NAV_STRING'];?></div>
    <? else: ?>
        <div class="comments-list-empty">Комментарии отсутствуют</div>
    <? endif; ?>
    <div class="content-comments-add">
        <div class="comments-add-headline">Добавить комментарий</div>
        <form action="/handlers/add-comment-handler.php" method="post" class="comments-add-form" enctype="application/x-www-form-urlencoded">
            <section class="add-section-half">
                <div class="add-section-question"><span>Имя:</span><span class="require"></span></div>
                <div class="add-section-answer">
                    <input type="text" name="USER_NAME" class="add-section-input"/>
                </div>
            </section>
            <div class="add-section-separator"></div>
            <section class="add-section-half">
                <div class="add-section-question">Фото:</div>
                <div class="add-section-answer">
                    <label>
                        <div class="add-section-filewrapper">
                            <div class="add-section-filebutton">Выберите файл</div>
                            <div class="add-section-filename"></div>
                        </div>
                        <input type="file" name="USER_PHOTO" class="add-section-fileinput"/>
                    </label>
                    <script type="text/javascript">
                        $(window).ready(function()
                        {
                            var addSectionFileinput = $('.add-section-fileinput');
                            
                            addSectionFileinput.on('change', function()
                            {
                                var addSectionFilename = $('.add-section-filename');
                                var addSectionFileInput = $('.add-section-fileinput');
                                
                                addSectionFilename.text(addSectionFileInput[0].files[0].name);
                            });
                        });
                    </script>
                </div>
            </section>
            <section class="add-section-full">
                <div class="add-section-question"><span>Адрес электронной почты:</span><span class="require"></span></div>
                <div class="add-section-answer">
                    <input type="text" name="USER_EMAIL" class="add-section-input"/>
                </div>
            </section>
            <section class="add-section-full">
                <div class="add-section-question"><span>Текст сообщения:</span><span class="require"></span></div>
                <div class="add-section-answer">
                    <?$APPLICATION->IncludeComponent(
                        "my_context:bb-editor-light", 
                        "sshepelev", 
                        array()
                    );?>
                </div>
            </section>
            <section class="add-section-full">
                <div class="add-section-question"><span>Введите код:</span><span class="require"></span></div>
                <div class="add-section-answer">
                    <input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHA_CODE"]);?>" />
                    <img src="/local/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHA_CODE"]);?>&SET_BORDER_COLOR=33,124,138" class="add-section-captcha" />
                    <input type="text" name="USER_CAPTCHA" class="add-section-input textarea-input section-input-half"/>
                </div>
            </section>
            <section class="add-section-full">
                <input type="hidden" name="NEWS_ID" value="<?=$arParams['NEWS_ID'];?>" />
                <input type="submit" value="Отправить" class="add-section-sbutton animated" />
                <div class="send-status-wrapper">
                    <?if(isset($arResult['INFORMATION_UPDATE'])):?>
                        <?if($arResult['INFORMATION_UPDATE'] === true):?>
                            <div title="<?=GetMessage('COMMENT_ADD');?>" class="send-status-done"></div>
                        <?else:?>
                            <div title="<?=GetMessage('COMMENT_ADD_ERROR');?>" class="send-status-error"></div>
                        <?endif;?>
                    <?elseif(isset($arResult['UPLOAD_ERROR'])):?>
                        <div title="<?=$arResult['UPLOAD_ERROR'];?>" class="send-status-error"></div>
                    <?elseif(isset($arResult['CAPTCHA_WRONG'])):?>
                        <div title="<?=GetMessage('CAPTCHA_WRONG');?>" class="send-status-error"></div>
                    <?endif;?>
                </div>
            </section>
        </form>
        
        <script type="text/javascript">
            $(window).ready(function()
            {
                var commentsAddForm = $('.comments-add-form');
                var addSectionSbutton = $('.add-section-sbutton');

                addSectionSbutton.hover(
                    function()
                    {
                        var thisElement = $(this);
                        thisElement.addClass('heartBeat');
                    },
                    function()
                    {
                        var thisElement = $(this);
                        thisElement.removeClass('heartBeat');
                    }
                );
                
                var validator = new ValidatorObject('.add-section-question', '.require', '.add-section-input',
                {
                    'USER_NAME':
                    {
                        minStr: 3,
                        maxStr: 100
                    },
                    
                    'USER_EMAIL':
                    {
                        isEmail: true,
                        minStr: 3,
                        maxStr: 200
                    },
                    
                    'FIELD_TEXT':
                    {
                        minStr: 3,
                        maxStr: 2000
                    },
                    
                    'USER_CAPTCHA':
                    {
                        isEmpty: true
                    }
                }, 'answer-error');
                
                commentsAddForm.on('submit', function()
                {
                    var currentForm = $(this);
                    
                    if(currentForm.find('.answer-error')[0] !== undefined)
                    {
                        currentForm.find('.answer-error').remove();
                    }
                    
                    validator.checkFields();
                    
                    if(currentForm.find('.answer-error')[0] !== undefined)
                    {
                        return false;
                    }
                    
                    // to multiple text fields
                    /*var fieldText = currentForm.find('input[name=FIELD_TEXT]');
                    fieldText.attr('name', fieldText.attr('name') + '[]');*/
                });
                
                var messageStatus = $('.send-status-done')[0] || $('.send-status-error')[0];
                
                if(messageStatus !== undefined)
                {
                    messageHide($(messageStatus), 5000);
                }
            });
        </script>
    </div>
</div>