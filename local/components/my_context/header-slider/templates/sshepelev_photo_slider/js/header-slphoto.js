jQuery(document).ready(function ($) {
  
	var slideCount = $('#header-slphoto ul li').length;
	var slideWidth = $('#header-slphoto ul li').width();
	var slideHeight = $('#header-slphoto ul li').height();
	var sliderUlWidth = slideCount * slideWidth;
	
	//$('#header-slider').css({ width: slideWidth, height: slideHeight });
	$('#header-slphoto ul').css({ width: sliderUlWidth });
    $('#header-slphoto ul li').width(slideWidth);

    var photoItems = $('.photo-item');
    
    window.moveLeft = function() {
        $('#header-slphoto ul').animate({
            left: + slideWidth
        },
        {
            duration: 1000,
            start: function()
            {
                var lastChild = $('#header-slphoto ul li:last-child');
                lastChild.fadeIn(1000);
                
                setData(photoItems, lastChild);
            },
            complete: function () {
                var firstChild = $('#header-slphoto ul li:first-child');

                firstChild.fadeOut(1000, function()
                {
                    firstChild.appendTo('#header-slphoto ul');
                    //$('#header-slvideo ul').css('left', '');
                });
            }
        });
    };
    
    window.moveRight = function() 
    { 
        $('#header-slphoto ul').animate({
            left: - slideWidth
        },
        {
            duration: 1000,
            start: function()
            {
                var nextSibling = $('#header-slphoto ul li:first-child').next();
                nextSibling.fadeIn(1000);
                
                setData(photoItems, nextSibling);
            },
            complete: function () {
                var firstChild = $('#header-slphoto ul li:first-child');

                firstChild.fadeOut(1000, function()
                {
                    firstChild.appendTo('#header-slphoto ul');
                    //$('#header-slvideo ul').css('left', '');
                });
            }
        });
    };
    
    function setData(photoItems, element)
    {
        photoItems.each(function(item)
        {
            var photoData = photoItems.eq(item);

            if(element.attr('data-id') == photoData.attr('data-id'))
            {
                var data =
                {
                    dataPhotoUrl: photoData.attr('data-src'),
                    dataIblockID: photoData.attr('data-iblock-id'),
                    dataID: photoData.attr('data-id')
                }
                
                var likeContainer = element.find('.like-container');

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