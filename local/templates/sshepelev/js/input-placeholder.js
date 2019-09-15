(function()
{
    function setPlaceholder(inputField, text)
    {
        inputField.css('color', 'rgba(33, 124, 138, 0.5)');
        inputField.val(text);
    }
    
    function unsetPlaceholder(inputField)
    {
        inputField.css('color', '');
        inputField.val('');
    }
    
    window.setPlaceholderToInput = function(inputField, text)
    {
        setPlaceholder(inputField, text);
       
        inputField.on('focus', function()
        {
            unsetPlaceholder($(this));
        });
        
        inputField.on('blur', function()
        {
            if($(this).val() == '')
            {
                setPlaceholder($(this), text);
            }
        });
    };
})();