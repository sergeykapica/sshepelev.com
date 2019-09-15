jQuery(document).ready(function ($) {
  
	var slideCount = $('#header-slvideo ul li').length;
	var slideWidth = $('#header-slvideo ul li').width();
	var slideHeight = $('#header-slvideo ul li').height();
	var sliderUlWidth = slideCount * slideWidth;
	
	//$('#header-slider').css({ width: slideWidth, height: slideHeight });
	$('#header-slvideo ul').css({ width: sliderUlWidth });
    $('#header-slvideo ul li').width(slideWidth);

    var videoItems = $('.video-item');
    
    window.moveLeft = function() {
        $('#header-slvideo ul').animate({
            left: + slideWidth
        },
        {
            duration: 1000,
            start: function()
            {
                var lastChild = $('#header-slvideo ul li:last-child');
                lastChild.fadeIn(1000);
                
                setData(videoItems, lastChild);
            },
            complete: function () {
                var firstChild = $('#header-slvideo ul li:first-child');

                firstChild.fadeOut(1000, function()
                {
                    firstChild.appendTo('#header-slvideo ul');
                    //$('#header-slvideo ul').css('left', '');
                });
            }
        });
    };
    
    window.moveRight = function() 
    { 
        $('#header-slvideo ul').animate({
            left: - slideWidth
        },
        {
            duration: 1000,
            start: function()
            {
                var nextSibling = $('#header-slvideo ul li:first-child').next();
                nextSibling.fadeIn(1000);
                
                setData(videoItems, nextSibling);
            },
            complete: function () {
                var firstChild = $('#header-slvideo ul li:first-child');

                firstChild.fadeOut(1000, function()
                {
                    firstChild.appendTo('#header-slvideo ul');
                    //$('#header-slvideo ul').css('left', '');
                });
            }
        });
    };
    
    window.getLocalVideoPlayer = function(plugInElement, requestUrlVideo)
    {
        $.ajax({
            url: '/ajax/get-local-player.php?VIDEO_URL=' + requestUrlVideo,
            method: 'GET',
            success: function(res)
            {
                if(res != false)
                {
                    plugInElement.append(res);
                }
            }
        });
    };
    
    function setData(videoItems, element)
    {
        videoItems.each(function(item)
        {
            var videoData = videoItems.eq(item).find('.video-data');

            if(element.attr('data-id') == videoData.attr('data-id'))
            {
                var data =
                {
                    dataVideoName: videoData.text(),
                    dataVideoDate: videoData.attr('data-video-date'),
                    dataVideoDescription: videoData.attr('data-video-description'),
                    dataVideoUrl: videoData.attr('data-video-url'),
                    dataIblockID: videoData.attr('data-iblock-id'),
                    dataID: videoData.attr('data-id')
                }

                var localPlayer = element.find('.local-player');

                if(localPlayer[0] !== undefined && localPlayer.html() == '')
                {
                    getLocalVideoPlayer(localPlayer, localPlayer.attr('data-src'));
                }

                var dataSourceContainer = element.find('.source-data');
                var likeContainer = element.find('.like-container');

                dataSourceContainer.find('.source-name').text(data.dataVideoName);
                dataSourceContainer.find('.source-date').text(data.dataVideoDate);
                likeContainer.find('.source-data-description').text(data.dataVideoDescription);
                element.fadeIn(1000);

                if(element.find('.comments-container').html() == '')
                {
                    getComments(data.dataIblockID, data.dataID, element.find('.comments-container'));
                }

                if(element.find('.like-prevcontainer-box').html() == '')
                {
                    getLikes(data.dataIblockID, data.dataID, element.find('.like-prevcontainer-box'));
                }

                return false;
            }

        });
    }
});