<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<html>
    <head>
        <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" />
        <link rel="stylesheet" href="/local/components/my_context/fileman.full_editor/style.css" />
    </head>
    <body>
        <div id="summernote-wrapper" style="float: left; max-width: 100%;">
            <div id="summernote"></div>
        </div>

        <script type="text/javascript" src="/local/templates/sshepelev/js/jquery-3.4.1.js"></script>
        <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>
        <script type="text/javascript" src="/local/components/my_context/fileman.full_editor/js/summernote.min.js"></script>
        <script type="text/javascript" src="/local/components/my_context/fileman.full_editor/js/lang/summernote-ru-RU.js"></script>

        <script type="text/javascript">
            $(window).ready(function()
            {
                window.parent.ourFiles = [];

                var currentTime = new Date();
                currentTime = currentTime.getTime();

                var editorElement = $('#summernote');
                var newId = editorElement.attr('id') + currentTime;
                editorElement.attr('id', newId);
                editorElement = $('#' + newId);

                var summernoteWrapper = $('#summernote-wrapper');
                var newId = summernoteWrapper.attr('id') + currentTime;
                summernoteWrapper.attr('id', newId);
                summernoteWrapper = $('#' + newId);

                var params =
                {
                    lang: 'ru-RU',
                    height: '<?=$arParams['EDITOR_HEIGHT'];?>',
                    minHeight: 100,
                    maxHeight: 300,
                    maxWidth: 300,
                    codeviewFilter: true,
                    codeviewIframeFilter: true,
                    callbacks:
                    {
                        onImageUpload: function(files)
                        {
                            for(var f in files)
                            {
                                (function()
                                {
                                    var file = files[f];
                                    var reader = new FileReader();

                                    reader.onload = function(e)
                                    {
                                        var img = document.createElement('img');
                                        img.setAttribute('data-filename', file.name);
                                        img.src = e.target.result;

                                        editorElement.summernote('insertNode', img);

                                        window.parent.ourFiles.push(file);
                                    };

                                    reader.readAsDataURL(file);
                                })();
                            }
                        }
                    }
                };

                editorElement.summernote(params);

                var noteCodable = summernoteWrapper.find('.note-codable');

                noteCodable.attr('name', '<?=$arParams["EDITOR_TEXTAREA_NAME"];?>');
                noteCodable.addClass('<?=$arParams["EDITOR_TEXTAREA_CLASSNAME"];?>');

                var textareaValue = '<?=htmlspecialcharsBack($arParams["EDITOR_TEXTAREA_VALUE"]);?>';
                noteCodable.val(textareaValue);

                var noteEditable = summernoteWrapper.find('.note-editable');
                noteEditable.html(textareaValue);
                
                noteEditable.on('input', function(e, data)
                {
                    noteCodable.val(this.innerHTML);

                    var textArea = {};
                    textArea[noteCodable.attr('name')] = noteCodable.val();
                    
                    data = data || e.data;
                    
                    if(typeof data !== 'undefined')
                    {
                        if(typeof data.loadDone !== 'undefined')
                        {
                            textArea.loadDone = true;
                        }
                    }
                    
                    window.parent.postMessage(textArea);
                });
                
                $(window).on('message', function(data)
                {
                    if(typeof data.originalEvent.data.triggerInput !== 'undefined')
                    {
                        noteEditable.trigger('input', { loadDone: true });
                    }
                });
            });
        </script>
    </body>
</html>