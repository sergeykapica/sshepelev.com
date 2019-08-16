<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
?>

<div class="bb-editor-wrapper">
    <div class="chat-textarea-wrapper">
        <div class="chat-textarea" contenteditable="true" tabindex="0"></div>
        <input type="hidden" name="FIELD_TEXT" class="textarea-input add-section-input" id="FIELD_TEXT" />
        <div class="chat-textarea-popups">
            <div class="insert-video-popup">
                <div class="popup-section popup-with-close">
                    <b class="popup-headline">Введите ссылку на видео:</b>
                    <div class="popup-close"></div>
                </div>
                <div class="popup-section">
                    <input type="text" class="popup-input" />
                </div>
                <div class="popup-section">
                    <button class="popup-form-submit">Вставить</button>
                </div>
            </div>
            <div class="insert-image-popup">
                <div class="popup-section popup-with-close">
                    <b class="popup-headline">Введите ссылку на изображение:</b>
                    <div class="popup-close"></div>
                </div>
                <div class="popup-section">
                    <input type="text" class="popup-input" />
                </div>
                <div class="popup-section">
                    <button class="popup-form-submit">Вставить</button>
                </div>
            </div>
            <div class="insert-smiles-popup">
                <a class="smiles smiles-glad"></a>
                <a class="smiles smiles-befuddled"></a>
                <a class="smiles smiles-smile"></a>
                <a class="smiles smiles-cry"></a>
                <a class="smiles smiles-laugh"></a>
                <a class="smiles smiles-smile2"></a>
                <a class="smiles smiles-angry-laugh"></a>
                <a class="smiles smiles-spectacled"></a>
                <a class="smiles smiles-unknown"></a>
                <a class="smiles smiles-in-love"></a>
                <a class="smiles smiles-muted"></a>
                <a class="smiles smiles-in-love2"></a>
                <a class="smiles smiles-muted2"></a>
                <a class="smiles smiles-angry"></a>
                <a class="smiles smiles-happy"></a>
                <a class="smiles smiles-cry2"></a>
                <a class="smiles smiles-laughted-cry"></a>
                <a class="smiles smiles-sweat"></a>
                <a class="smiles smiles-upset"></a>
                <a class="smiles smiles-intelligent"></a>
                <a class="smiles smiles-outraged"></a>
                <a class="smiles smiles-upset2"></a>
                <a class="smiles smiles-upset3"></a>
                <a class="smiles smiles-happy-spectacled"></a>
                <a class="smiles smiles-yelling"></a>
                <a class="smiles smiles-upset-sweat"></a>
                <a class="smiles smiles-muted3"></a>
                <a class="smiles smiles-muted4"></a>
                <a class="smiles smiles-surprised"></a>
                <a class="smiles smiles-upset-sweat2"></a>
                <a class="smiles smiles-outraged2"></a>
                <a class="smiles smiles-surprised2"></a>
                <a class="smiles smiles-dabbles"></a>
                <a class="smiles smiles-awkwardly"></a>
                <a class="smiles smiles-angry2"></a>
                <a class="smiles smiles-dabbles2"></a>
                <a class="smiles smiles-not-expected"></a>
                <a class="smiles smiles-not-expected2"></a>
                <a class="smiles smiles-upset4"></a>
                <a class="smiles smiles-glad-sweat"></a>
                <a class="smiles smiles-upset5"></a>
                <a class="smiles smiles-dabbles3"></a>
                <a class="smiles smiles-ignored"></a>
                <a class="smiles smiles-winks"></a>
                <a class="smiles smiles-smile3"></a>
                <a class="smiles smiles-glad2"></a>
                <a class="smiles smiles-max-angry"></a>
                <a class="smiles smiles-laught"></a>
                <a class="smiles smiles-in-love3"></a>
                <a class="smiles smiles-glad3"></a>
                <div class="popup-close"></div>
            </div>
        </div>
    </div>
    <nav class="chat-textarea-nav">
        <div class="nav-video-url"></div>
        <div class="nav-image-url"></div>
        <div class="nav-smiles"></div>
    </nav>
</div>

<script type="text/javascript" src="/local/components/my_context/bb-editor-light/templates/sshepelev/js/BBEditor.js"></script>

<script type="text/javascript">
    $(window).ready(function()
    {
        var chatTextarea = $('.chat-textarea');
            
        var buttons =
        {
            video:
            {
                videoButton: $('.nav-video-url'),
                videoPopup: $('.insert-video-popup'),
                actionButton: $('.popup-form-submit'),
                urlField: $('.popup-input'),
                popupWrapper: $('.chat-textarea-popups'),
                closePopupButton: $('.popup-close')
            },
            image:
            {
                imageButton: $('.nav-image-url'),
                imagePopup: $('.insert-image-popup'),
                actionButton: $('.popup-form-submit'),
                urlField: $('.popup-input'),
                popupWrapper: $('.chat-textarea-popups'),
                closePopupButton: $('.popup-close')
            },
            smiles:
            {
                smilesButton: $('.nav-smiles'),
                smilesPopup: $('.insert-smiles-popup'),
                popupWrapper: $('.chat-textarea-popups'),
                closePopupButton: $('.popup-close')
            }
        };

        var bbEditor = new BBEditor(chatTextarea[0], buttons);

        function currentPosition()
        {
            bbEditor.pasteHtmlAtCaret('<span class="current-position"></span>');
            bbEditor.getCurrentPosition($('.current-position')[0]);
        }

        chatTextarea.on('mousedown', currentPosition);
        chatTextarea.on('input', currentPosition); 
        
        var textareaInput = $('.textarea-input');
        
        function textareaChangeValues(textarea)
        {
            var textareaHidden = textarea.parent().find('.textarea-input');
            textareaHidden.val(textarea.html());
        }
        
        chatTextarea.on('input', function()
        { 
            textareaChangeValues($(this));
        });
        
        
        chatTextarea.on('focus', function()
        {
            textareaChangeValues($(this));
        });
    });
</script>