(function()
{
    function BBEditor(textarea, buttons)
    {  
        this.textarea = textarea;

        this.pasteHtmlAtCaret = function(html)
        {
            var sel, range;

            if (window.getSelection)
            {
                // IE9 and non-IE
                sel = window.getSelection();

                if (sel.getRangeAt && sel.rangeCount)
                {
                    range = sel.getRangeAt(0);
                    range.deleteContents();

                    // Range.createContextualFragment() would be useful here but is
                    // non-standard and not supported in all browsers (IE9, for one)
                    var el = document.createElement("div");
                    el.innerHTML = html;
                    var frag = document.createDocumentFragment(), node, lastNode;
                    while ( (node = el.firstChild) )
                    {
                        lastNode = frag.appendChild(node);
                    }
                    range.insertNode(frag);

                    // Preserve the selection
                    if (lastNode)
                    {
                        range = range.cloneRange();
                        range.setStartAfter(lastNode);
                        range.collapse(true);
                        sel.removeAllRanges();
                        sel.addRange(range);
                    }
                }
            }
            else if (document.selection && document.selection.type != "Control")
            {
                // IE < 9
                document.selection.createRange().pasteHTML(html);
            }

            this.eachChildrens();
        };

        this.eachChildrens = function()
        {
            var curThis = this, curElement;
            var textareaChildren = this.textarea.children;

            for(var i = 0; i < textareaChildren.length; i++)
            {
                textareaChildren[i].onmouseover = function(e)
                {
                    this.setAttribute('contenteditable', true);
                };

                textareaChildren[i].onmouseout = function(e)
                {
                    this.setAttribute('contenteditable', false);
                };

                if(textareaChildren[i].children.length > 0)
                {                         
                    curElement = textareaChildren[i];

                    setTimeout(function()
                    {
                        curThis.eachChildrens(curElement.children);
                    }, 0);
                }
            }
        };

        this.setButtonHandler = function()
        {
            function hidePopup(element, wrapper)
            {
                element.fadeOut(1000, $.proxy(function()
                {
                    if(this.popupWrapper !== undefined)
                    {
                        this.popupWrapper.css('z-index', -1);
                        element.hide();
                    }
                    
                    this.element.removeClass('active-popup');
                }, 
                {
                    popupWrapper: wrapper,
                    element: element
                }));
            }
            
            function showPopup(element, wrapper)
            {
                element.fadeIn(1000, $.proxy(function()
                {
                    this.popupWrapper.css('z-index', 1);
                    this.element.addClass('active-popup');
                }, 
                {
                    popupWrapper: wrapper,
                    element: element
                }));
            }

            var buttonsLength = 0;
            
            for(var k in buttons)
            {
                if(k == 'video')
                {
                    var video = buttons.video;

                    video.videoButton.on('click', function()
                    {
                        var activePopup = $('.active-popup');
                        
                        if(typeof activePopup[0] !== 'undefined')
                        {
                            hidePopup(activePopup);
                        }
                        
                        showPopup(video.videoPopup, video.popupWrapper);
                    });

                    var aButton = video.videoPopup.find('.' + video.actionButton[0].className);
                    var vField = video.videoPopup.find('.' + video.urlField[0].className);
                    var curThis = this;

                    aButton.on('click', function()
                    {
                        var url = vField.val();
                        
                        if(url.match(/youtube.com/g) !== null)
                        {
                            url = url.match(/\?v=(.+)/);

                            if(url !== null)
                            {
                                url = url[1];

                                var videoHtml =
                                `
                                    <iframe class="insert-youtube" src="https://www.youtube.com/embed/` + url + `" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                `;

                                curThis.pasteAtCurrentPosition(videoHtml);

                                vField.val('');
                                hidePopup(video.videoPopup, video.popupWrapper);
                            }
                        }
                        else if(/vimeo.com/g)
                        {
                            url = url.match(/vimeo\.com\/(\d+)/);
                            
                            if(url !== null)
                            {
                                url = url[1];
                                    
                                var videoHtml =
                                `
                                    <iframe class="insert-vimeo" src="https://player.vimeo.com/video/` + url + `" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                `;
                                
                                curThis.pasteAtCurrentPosition(videoHtml);

                                vField.val('');
                                hidePopup(video.videoPopup, video.popupWrapper);
                            }
                        }
                        
                        return false;
                    });

                    video.closePopupButton.on('click', function()
                    {
                        hidePopup(video.videoPopup, video.popupWrapper);
                    });
                }
                else if(k == 'image')
                {
                    var image = buttons.image;

                    image.imageButton.on('click', function()
                    {
                        var activePopup = $('.active-popup');
                        
                        if(typeof activePopup[0] !== 'undefined')
                        {
                            hidePopup(activePopup);
                        }
                        
                        showPopup(image.imagePopup, image.popupWrapper);
                    });

                    var aButton = image.imagePopup.find('.' + image.actionButton[0].className);
                    var iField = image.imagePopup.find('.' + image.urlField[0].className);
                    var curThis = this;

                    aButton.on('click', function(e)
                    {  
                        var url = iField.val();

                        var img = document.createElement('img');
                        img.src = url;
                        img.className = 'bb-editor-img';
                        
                        curThis.pasteAtCurrentPosition(img.outerHTML);
                        
                        iField.val('');
                        hidePopup(image.imagePopup, image.popupWrapper);
                        
                        return false;
                    });

                    image.closePopupButton.on('click', function()
                    {
                        hidePopup(image.imagePopup, image.popupWrapper);
                    });   
                }
                else if(k == 'smiles')
                {
                    var smiles = buttons.smiles;

                    smiles.smilesButton.on('click', function()
                    {
                        var activePopup = $('.active-popup');
                        
                        if(typeof activePopup[0] !== 'undefined')
                        {
                            hidePopup(activePopup);
                        }
                        
                        showPopup(smiles.smilesPopup, smiles.popupWrapper);
                    });

                    var aButton = smiles.smilesPopup;
                    var curThis = this;

                    aButton.on('click', function(e)
                    {
                        var target = e.target;
                        
                        if(target.nodeName == 'A')
                        {
                            target = target.cloneNode();
                            target.style.float = 'none';
                            target.style.margin = '0 5px 0 5px';
                            
                            curThis.pasteAtCurrentPosition(target.outerHTML);
                            hidePopup(smiles.smilesPopup, smiles.popupWrapper);
                        }
                        
                        return false;
                    });

                    smiles.closePopupButton.on('click', function()
                    {
                        hidePopup(smiles.smilesPopup, smiles.popupWrapper);
                    });
                }
            }
        };
        
        this.setButtonHandler();
        
        this.getCurrentPosition = function(elementPosition)
        {
            var allText = this.textarea.innerHTML;
            var position = allText.indexOf(elementPosition.outerHTML);
            
            $(elementPosition).remove();
            
            if(position > 0)
            {
                this.currentPosition = position;
            }
            else
            {
                this.currentPosition = allText.length;
            }
        };
        
        this.pasteAtCurrentPosition = function(html)
        {  
            var allText = this.textarea.innerHTML;
            
            allText = allText.substr(0, this.currentPosition) + html + allText.substr(this.currentPosition);
            
            this.textarea.innerHTML = allText;
            this.textarea.focus();
        };
    }
    
    window.BBEditor = BBEditor;
})();