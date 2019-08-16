jQuery(document).ready(function ($) {

    var intervalToIteration;
    
    function slideChange()
    {
        intervalToIteration = setTimeout(function() {
            moveRight();
            slideChange();
        }, 10000);
    }
    
    slideChange();
    
    $(window).on('blur', function()
    {
        if(intervalToIteration !== undefined)
        {
            clearTimeout(intervalToIteration);
            intervalToIteration = undefined;
        }
    });
    
    $(window).on('focus', function()
    {
        if(intervalToIteration === undefined)
        {
            slideChange();
        }
    });
  
	var slideCount = $('#header-slider ul li').length;
	var slideWidth = $('#header-slider ul li').width();
	var slideHeight = $('#header-slider ul li').height();
	var sliderUlWidth = slideCount * slideWidth;
	
	//$('#header-slider').css({ width: slideWidth, height: slideHeight });
	$('#header-slider ul').css({ width: sliderUlWidth });
    $('#header-slider ul li').width(slideWidth);

    function moveLeft() {
        $('#header-slider ul').animate({
            left: + slideWidth
        },
        {
            duration: 1000,
            start: function()
            {
                var nextSibling = $('#header-slider ul li:first-child').next();
                nextSibling.fadeIn(1000);
            },
            complete: function () {
                var lastChild = $('#header-slider ul li:last-child');

                lastChild.fadeOut(1000, function()
                {
                    lastChild.prependTo('#header-slider ul');
                    $('#header-slider ul').css('left', '');
                });
            }
        });
    };

    function moveRight() {
        $('#header-slider ul').animate({
            left: - slideWidth
        },
        {
            duration: 1000,
            start: function()
            {
                var nextSibling = $('#header-slider ul li:first-child').next();
                nextSibling.fadeIn(1000);
            },
            complete: function () {
                var firstChild = $('#header-slider ul li:first-child');

                firstChild.fadeOut(1000, function()
                {
                    firstChild.appendTo('#header-slider ul');
                    $('#header-slider ul').css('left', '');
                });
            }
        });
    };
    
    var sliderStopButton = $('.slider-stop-button');
    
    $('#header-slider').hover(
        function()
        {
            sliderStopButton.removeClass('fadeOutDown');
            sliderStopButton.addClass('fadeInUp');
        },
        function()
        {
            sliderStopButton.removeClass('fadeInUp');
            sliderStopButton.addClass('fadeOutDown');
        } 
    );
    
    var sliderStatus;
    
    sliderStopButton.on('click', function()
    {
        var element = $(this);
        
        if(sliderStatus == false || sliderStatus == undefined)
        {
            clearTimeout(intervalToIteration);
            
            element.attr('title', 'Запустить слайдер');
            sliderStatus = true;
        }
        else
        {
            slideChange();
            
            element.attr('title', 'Остановить слайдер');
            sliderStatus = false;
        }
    });
});