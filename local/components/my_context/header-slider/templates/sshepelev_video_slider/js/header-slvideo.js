jQuery(document).ready(function ($) {
  
	var slideCount = $('#header-slvideo ul li').length;
	var slideWidth = $('#header-slvideo ul li').width();
	var slideHeight = $('#header-slvideo ul li').height();
	var sliderUlWidth = slideCount * slideWidth;
	
	//$('#header-slider').css({ width: slideWidth, height: slideHeight });
	$('#header-slvideo ul').css({ width: sliderUlWidth });
    $('#header-slvideo ul li').width(slideWidth);

    function moveLeft() {
        $('#header-slvideo ul').animate({
            left: + slideWidth
        },
        {
            duration: 1000,
            start: function()
            {
                var nextSibling = $('#header-slvideo ul li:first-child').next();
                nextSibling.fadeIn(1000);
            },
            complete: function () {
                var lastChild = $('#header-slvideo ul li:last-child');

                lastChild.fadeOut(1000, function()
                {
                    lastChild.prependTo('#header-slvideo ul');
                    $('#header-slvideo ul').css('left', '');
                });
            }
        });
    };

    function moveRight() {
        $('#header-slvideo ul').animate({
            left: - slideWidth
        },
        {
            duration: 1000,
            start: function()
            {
                var nextSibling = $('#header-slvideo ul li:first-child').next();
                nextSibling.fadeIn(1000);
            },
            complete: function () {
                var firstChild = $('#header-slvideo ul li:first-child');

                firstChild.fadeOut(1000, function()
                {
                    firstChild.appendTo('#header-slvideo ul');
                    $('#header-slvideo ul').css('left', '');
                });
            }
        });
    };
});