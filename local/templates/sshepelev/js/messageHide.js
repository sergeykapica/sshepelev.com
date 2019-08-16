(function()
{
    function messageHide(messageElement, duration)
    {
        setTimeout(function()
        {
            messageElement.fadeOut(duration, function()
            {
                messageElement.remove();
            });
        });
    }
    
    window.messageHide = messageHide;
})();