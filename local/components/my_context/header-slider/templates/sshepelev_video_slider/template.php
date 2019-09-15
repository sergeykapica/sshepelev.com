<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$APPLICATION->AddHeadScript('/local/components/my_context/header-slider/templates/sshepelev_video_slider/js/header-slvideo.js');
?>

<div class="header-slvideo-wrapper">
    <div id="header-slvideo">
        <ul class="header-slvideo-ul">
        </ul>
    </div>
    <div class="navigation-wrapper">
        <div class="navigation-video-left animated"></div>
        <div class="navigation-video-right animated"></div>
    </div>
</div>

<script type="text/javascript">
    $(window).ready(function()
    {
        function getDesiredSourcePlayer(source, dataID, videoItem)
        {
            if(source.match(/youtube/) != null)
            {
                var url = source.match(/\?v=(.+)/);
                
                if(url != null)
                {
                    var container =
                    `
                    <li class="header-slvideo-li" data-id="` + dataID + `">
                        <iframe class="youtube-player" src="http://www.youtube.com/embed/` + url[1] + `?autoplay=0
                        frameborder="0"></iframe>
                        <div class="source-data">
                            <div class="source-name"></div>
                            <div class="source-date"></div>
                        </div>
                        <div class="like-container">
                            <div class="source-data-description"></div>
                            <div class="like-prevcontainer-box"></div>
                        </div>
                        <div class="comments-container"></div>
                    </li>
                    `;
                    
                    return container;
                }
            }
            else
            {
                var container =
                `
                <li class="header-slvideo-li" data-id="` + dataID + `">
                    <div class="local-player" data-src="` + source + `"></div>
                    <div class="source-data">
                        <div class="source-name"></div>
                        <div class="source-date"></div>
                    </div>
                    <div class="like-container">
                        <div class="source-data-description"></div>
                        <div class="like-prevcontainer-box"></div>
                    </div>
                    <div class="comments-container"></div>
                </li>
                `;

                return container;
            }
        }
        
        var headerSlvideoUl = $('.header-slvideo-ul');
        var videoItem = $('.video-item');
        var navigationWrapper;
        
        videoItem.each(function(item)
        {
            var currentVideoElement = videoItem.eq(item).find('.video-data');
            var html = getDesiredSourcePlayer(currentVideoElement.attr('data-video-url'), currentVideoElement.attr('data-id'), currentVideoElement);
            
            headerSlvideoUl.append(html);
        });
        
        var navigationWrapper = $('.navigation-wrapper');
            
        window.setPaginationHandler = function(pagination, containerToAppend)
        {
            pagination.on('click', function(e)
            {
                var target = $(e.target);

                if(target[0].nodeName == 'A')
                {
                    $.ajax({
                        url: target.attr('href') + '&ajax_mode=1',
                        method: 'GET',
                        dataType: 'json',
                        success: function(res)
                        {
                            if(res != false)
                            {
                                containerToAppend.find('.news-comments-list').html(res.commentsList);
                                pagination.html(res.pagination);
                            }
                        }
                    });
                }

                return false;
            });
        }

        window.getComments = function(commentIblock, contentElementID, containerToAppend)
        {
            $.ajax({
                url: '/ajax/get-comments-list-content.php?COMMENT_IBLOCK=' + commentIblock + '&CONTENT_ELEMENT_ID=' + contentElementID,
                method: 'GET',
                success: function(res)
                {
                    if(res != false)
                    {
                        containerToAppend.append(res);

                        var pagination = containerToAppend.find('.pagination');

                        setPaginationHandler(pagination, containerToAppend);
                    }
                }
            });
        }

        window.getLikes = function(IblockID, elementIblockID, containerToAppend)
        {
            $.ajax({
                url: '/ajax/get-likes.php?IBLOCK_ID=' + IblockID + '&ELEMENT_IBLOCK_ID=' + elementIblockID,
                method: 'GET',
                success: function(res)
                {
                    if(res != false)
                    {
                        containerToAppend.append(res);
                    }
                }
            });
        }

        function showAndResetStructure(headerSlvideoWrapper, data)
        {
            headerSlvideoWrapper.fadeIn(durationSliderShow);

            var items = headerSlvideoWrapper.find('.header-slvideo-li');
            var itemsContainer = $('.header-slvideo-ul');
            var headerSlvideo = $('#header-slvideo');
            var currentItem;

            items.each(function(i)
            {  
                var lastChild = itemsContainer.find('li:last-child');
                lastChild.prependTo(itemsContainer);

                if(lastChild.attr('data-id') == data.dataID)
                {
                    var localPlayer = lastChild.find('.local-player');

                    if(localPlayer[0] !== undefined)
                    {
                        getLocalVideoPlayer(localPlayer, localPlayer.attr('data-src'));
                    }

                    currentItem = lastChild;

                    var dataSourceContainer = currentItem.find('.source-data');
                    var likeContainer = currentItem.find('.like-container');

                    dataSourceContainer.find('.source-name').text(data.dataVideoName);
                    dataSourceContainer.find('.source-date').text(data.dataVideoDate);
                    likeContainer.find('.source-data-description').text(data.dataVideoDescription);
                    currentItem.fadeIn(1000);

                    return false;
                }
            });

            items.width(headerSlvideo.width());
            var sliderUlWidth = ( headerSlvideo.width() + parseFloat(items.css('margin-right')) ) * items.length;
            itemsContainer.width(sliderUlWidth);


            if(currentItem.find('.comments-container').html() == '')
            {
                getComments(data.dataIblockID, data.dataID, currentItem.find('.comments-container'));
            }

            if(currentItem.find('.like-prevcontainer-box').html() == '')
            {
                getLikes(data.dataIblockID, data.dataID, currentItem.find('.like-prevcontainer-box'));
            }

            var margin = 20;
            var button = navigationWrapper.find('.navigation-video-left');

            navigationWrapper.css(
            {
                width: headerSlvideo[0].offsetWidth + ( ( button.width() * 2 ) + ( margin * 2 ) ) + 'px',
                marginLeft: '-' + ( button.width() + margin ) + 'px'
            });
        }

        var contentWrapper = $('.content-wrapper');
        var headerSlvideoWrapper = $('.header-slvideo-wrapper');
        var durationSliderShow = 1000;

        if(contentWrapper.find('.video-item')[0] !== undefined)
        {
            contentWrapper.on('click', function(e)
            {
                var target = $(e.target);

                if(target.hasClass('video-data'))
                {
                    var data =
                    {
                        dataVideoName: target.text(),
                        dataVideoDate: target.attr('data-video-date'),
                        dataVideoDescription: target.attr('data-video-description'),
                        dataVideoUrl: target.attr('data-video-url'),
                        dataIblockID: target.attr('data-iblock-id'),
                        dataID: target.attr('data-id')
                    }

                    showAndResetStructure(headerSlvideoWrapper, data);
                }
            });
        }

        headerSlvideoWrapper.on('click', function(e)
        {
            var target = $(e.target);

            if(target.hasClass(this.className))
            {
                headerSlvideoWrapper.fadeOut(durationSliderShow, function()
                {
                    $('.local-player').html('');
                });
            }
        });

        var navigationVideoLeft = $('.navigation-video-left');
        var navigationVideoRight = $('.navigation-video-right');

        headerSlvideoWrapper.on('mousemove', function(e)
        {
            var target = $(e.target);

            if(target.hasClass(this.className) || target.hasClass(navigationWrapper[0].className) || target.hasClass(navigationVideoLeft[0].className) || target.hasClass(navigationVideoRight[0].className))
            {
                if(!navigationWrapper.hasClass('fadeInNavigation'))
                {
                    navigationWrapper.removeClass('fadeOutNavigation');
                    navigationWrapper.addClass('fadeInNavigation');
                }

                if(!navigationVideoLeft.hasClass('fadeInLeft'))
                {
                    navigationVideoLeft.addClass('fadeInLeft');
                }

                if(!navigationVideoLeft.hasClass('fadeInRight'))
                {  
                    navigationVideoRight.addClass('fadeInRight');
                }
            }
            else
            {
                if(!navigationWrapper.hasClass('fadeOutNavigation'))
                {
                    navigationWrapper.removeClass('fadeInNavigation');
                    navigationWrapper.addClass('fadeOutNavigation');
                }

                if(navigationVideoLeft.hasClass('fadeInLeft'))
                {
                    navigationVideoLeft.removeClass('fadeInLeft');
                }

                if(navigationVideoRight.hasClass('fadeInRight'))
                {
                    navigationVideoRight.removeClass('fadeInRight');
                }
            }
        });

        navigationVideoLeft.on('click', function()
        {
            moveLeft();
        });

        navigationVideoRight.on('click', function()
        {
            moveRight();
        });
    });
</script>