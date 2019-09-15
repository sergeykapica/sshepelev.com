<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/validatorObject.js');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/messageHide.js');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/formateDate.js');
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . '/css/validatorObject.css');
?>

<?if(!isset($_GET['ajax_mode'])):?>
    <div class="news-comments">
        <div class="news-comments-headline">Комментарии</div>
        
        <? if(isset($arResult['COMMENTS'])): ?>
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
        <div class="news-comments-add">
            <div class="comments-add-headline">Добавить комментарий</div>
            <form action="/handlers/add-comment-content-handler.php" method="post" class="comments-add-form" enctype="application/x-www-form-urlencoded">
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
                    <input type="hidden" name="COMMENT_IBLOCK" value="<?=$arParams['COMMENT_IBLOCK'];?>" />
                    <input type="hidden" name="CONTENT_ELEMENT_ID" value="<?=$arParams['CONTENT_ELEMENT_ID'];?>" />
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
                        
                        var file = $('.add-section-fileinput');
                        var captchaSid = currentForm.find('input[name=captcha_sid]');
                        var commentIblock = currentForm.find('input[name=COMMENT_IBLOCK]');
                        var contentElementID = currentForm.find('input[name=CONTENT_ELEMENT_ID]');
                        
                        var formData = buildQueryString($('.add-section-input'));
                        formData.append(file.attr('name'), file[0].files[0]);
                        formData.append(captchaSid.attr('name'), captchaSid.val());
                        formData.append(commentIblock.attr('name'), commentIblock.val());
                        formData.append(contentElementID.attr('name'), contentElementID.val());

                        $.ajax({
                            url: currentForm.attr('action'),
                            method: 'POST',
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function(res)
                            {
                                if(res == 'add-comment-done')
                                {
                                    var newsCommentsList = $('.news-comments-list');
                                    
                                    var currentDate = new Date();
                                    currentDate = currentDate.getDate() + ' ' + formateDate.formateMonthToString(currentDate.getMonth()) + ', ' + currentDate.getFullYear() + ' г. в ' + currentDate.getHours() + ':' + currentDate.getMinutes();
                                    
                                    if(eval(formData.get('USER_PHOTO')) !== undefined)
                                    {
                                        var reader = new FileReader();

                                        reader.onload = function(e) {
                                            var comment =
                                            `
                                            <section class="news-comment-item">
                                                <div class="news-comment-text">` + formData.get('FIELD_TEXT') + `</div>
                                                <div class="news-comment-information">
                                                    <div class="news-comment-icon" style="background-image: url(` + e.target.result + `)"></div>
                                                    <div class="news-comment-data">` + formData.get('USER_NAME') + `, ` + currentDate + `</div>
                                                </div>
                                            </section>
                                            `;

                                            newsCommentsList.prepend(comment);
                                        }

                                        reader.readAsDataURL(formData.get('USER_PHOTO'));
                                    }
                                    else
                                    {
                                        var comment =
                                        `
                                        <section class="news-comment-item">
                                            <div class="news-comment-text">` + formData.get('FIELD_TEXT') + `</div>
                                            <div class="news-comment-information">
                                                <div class="news-comment-icon" style="background-image: url(<?=$arResult['DEFAULT_ICON'];?>)"></div>
                                                <div class="news-comment-data">` + formData.get('USER_NAME') + `, ` + currentDate + `</div>
                                            </div>
                                        </section>
                                        `;

                                        newsCommentsList.prepend(comment);
                                    }
                                }
                                else if(res == 'captcha-input-error')
                                {
                                    generateMessage('answer-error', 'Капча введена неверно.', 'comments-add-form');
                                }
                                else if(res == 'add-comment-failed')
                                {
                                    generateMessage('answer-error', 'При добавлении комментария возникла ошибка', 'comments-add-form');
                                }
                                else if(res == 'image-load-error')
                                {
                                    generateMessage('answer-error', 'При загрузке изображения возникла ошибка', 'comments-add-form');
                                }
                                
                                function generateMessage(className, msg, containerToAdd)
                                {
                                    containerToAdd = $('.' + containerToAdd);
                                    
                                    var msgElement = document.createElement('div');
                                    msgElement.className = className;
                                    msgElement.innerText = msg;
                                    msgElement.style.top = ( containerToAdd.height() - 10 ) + 'px';

                                    containerToAdd.append(msgElement);
                                }
                            }
                        });
                        
                        return false;
                    });

                    var messageStatus = $('.send-status-done')[0] || $('.send-status-error')[0];

                    if(messageStatus !== undefined)
                    {
                        messageHide($(messageStatus), 5000);
                    }
                    
                    function buildQueryString(inputs)
                    {
                        var formData = new FormData();
                        
                        inputs.each(function(item)
                        {
                            var currentItem = inputs.eq(item);
                            
                            formData.append(currentItem.attr('name'), currentItem.val());
                        });
                        
                        return formData;
                    }
                });
            </script>
        </div>
    </div>
<?else:?>
    <?
    ob_clean();
    ob_start();
    ?>

    <?foreach($arResult['COMMENTS'] as $comment):?>
        <section class="news-comment-item">
            <div class="news-comment-text"><?=$comment['PROPERTY_COMMENT_TEXT_VALUE']['TEXT'];?></div>
            <div class="news-comment-information">
                <div class="news-comment-icon" style="background-image: url(<?=$comment['PROPERTY_USER_PHOTO_VALUE'];?>)"></div>
                <div class="news-comment-data"><?=$comment['PROPERTY_USER_NAME_VALUE'];?>, <?=$comment['DATE_ACTIVE_FROM'];?></div>
            </div>
        </section>
    <?endforeach;?>
    
    <?
    $commentsList = ob_get_contents();
    ob_clean();
     
    echo json_encode(
        array(
            'commentsList' => $commentsList,
            'pagination' => $arResult['NAV_STRING']
        )
    );
    ?>
<?endif;?>