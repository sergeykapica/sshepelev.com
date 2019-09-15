<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$APPLICATION->AddHeadScript('/local/components/my_context/header-slider/templates/sshepelev_photo_slider/js/header-slphoto.js');
?>

<div class="header-slphoto-wrapper">
    <div id="header-slphoto">
        <ul class="header-slphoto-ul">
        </ul>
    </div>
    <div class="navigation-wrapper">
        <div class="navigation-photo-left animated"></div>
        <div class="navigation-photo-right animated"></div>
    </div>
</div>

<script type="text/javascript">
    $(window).ready(function()
    {
        var headerSlphotoUl = $('.header-slphoto-ul');
        var photoItem = $('.photo-item');
        var contentWrapper = $('.content-wrapper');
        var headerSlphotoWrapper = $('.header-slphoto-wrapper');
        var durationSliderShow = 1000;
        
        photoItem.each(function(item)
        {
            var currentPhotoElement = photoItem.eq(item);
            
            var html =
            `
            <li class="header-slphoto-li" data-id="` + currentPhotoElement.attr('data-id') + `">
                <div class="slphoto-li-photo" style="background-image: url(` + currentPhotoElement.attr('data-src') + `);"></div>
                <div class="source-data">
                    <div class="source-name">` + currentPhotoElement.attr('title') + `</div>
                    <div class="source-date">` + currentPhotoElement.attr('data-date')  + `</div>
                </div>
                <div class="like-container">
                    <div class="source-data-description"></div>
                    <div class="like-prevcontainer-box"></div>
                </div>
                <div class="comments-container"></div>
            </li>
            `;
            
            headerSlphotoUl.append(html);
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
        };

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
        };

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
        };
        
        var currentItem;
        
        function showAndResetStructure(headerSlphotoWrapper, data)
        {
            headerSlphotoWrapper.fadeIn(durationSliderShow);

            var items = headerSlphotoWrapper.find('.header-slphoto-li');
            var itemsContainer = $('.header-slphoto-ul');
            var headerSlphoto = $('#header-slphoto');
            var currentItem;

            items.each(function(i)
            {  
                var lastChild = itemsContainer.find('li:last-child');
                lastChild.prependTo(itemsContainer);

                if(lastChild.attr('data-id') == data.dataID)
                {
                    currentItem = lastChild;

                    var dataSourceContainer = currentItem.find('.source-data');
                    var likeContainer = currentItem.find('.like-container');

                    dataSourceContainer.find('.source-name').text(data.dataPhotoName);
                    dataSourceContainer.find('.source-date').text(data.dataPhotoDate);
                    likeContainer.find('.source-data-description').text(data.dataVideoDescription);
                    currentItem.fadeIn(1000);

                    return false;
                }
            });

            items.width(headerSlphoto.width());
            var sliderUlWidth = ( headerSlphoto.width() + parseFloat(items.css('margin-right')) ) * items.length;
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
            var button = navigationWrapper.find('.navigation-photo-left');

            navigationWrapper.css(
            {
                width: headerSlphoto[0].offsetWidth + ( ( button.width() * 2 ) + ( margin * 2 ) ) + 'px',
                marginLeft: '-' + ( button.width() + margin ) + 'px'
            });
        }
            
        if(contentWrapper.find('.photo-item')[0] !== undefined)
        {
            contentWrapper.on('click', function(e)
            {
                var target = $(e.target);

                if(target.hasClass('photo-item'))
                {
                    var data =
                    {
                        dataPhotoName: target.attr('title'),
                        dataPhotoDate: target.attr('data-date'),
                        dataPhotoDescription: target.attr('data-photo-description'),
                        dataPhotoUrl: target.attr('data-src'),
                        dataIblockID: target.attr('data-iblock-id'),
                        dataID: target.attr('data-id')
                    }

                    showAndResetStructure(headerSlphotoWrapper, data);
                }
            });
        }

        headerSlphotoWrapper.on('click', function(e)
        {
            var target = $(e.target);

            if(target.hasClass(this.className))
            {
                headerSlphotoWrapper.fadeOut(durationSliderShow);
            }
        });

        var navigationPhotoLeft = $('.navigation-photo-left');
        var navigationPhotoRight = $('.navigation-photo-right');

        headerSlphotoWrapper.on('mousemove', function(e)
        {
            var target = $(e.target);

            if(target.hasClass(this.className) || target.hasClass(navigationWrapper[0].className) || target.hasClass(navigationPhotoLeft[0].className) || target.hasClass(navigationPhotoRight[0].className))
            {
                if(!navigationWrapper.hasClass('fadeInNavigation'))
                {
                    navigationWrapper.removeClass('fadeOutNavigation');
                    navigationWrapper.addClass('fadeInNavigation');
                }

                if(!navigationPhotoLeft.hasClass('fadeInLeft'))
                {
                    navigationPhotoLeft.addClass('fadeInLeft');
                }

                if(!navigationPhotoLeft.hasClass('fadeInRight'))
                {  
                    navigationPhotoRight.addClass('fadeInRight');
                }
            }
            else
            {
                if(!navigationWrapper.hasClass('fadeOutNavigation'))
                {
                    navigationWrapper.removeClass('fadeInNavigation');
                    navigationWrapper.addClass('fadeOutNavigation');
                }

                if(navigationPhotoLeft.hasClass('fadeInLeft'))
                {
                    navigationPhotoLeft.removeClass('fadeInLeft');
                }

                if(navigationPhotoRight.hasClass('fadeInRight'))
                {
                    navigationPhotoRight.removeClass('fadeInRight');
                }
            }
        });

        navigationPhotoLeft.on('click', function()
        {
            moveLeft();
        });

        navigationPhotoRight.on('click', function()
        {
            moveRight();
        });
    });
</script>