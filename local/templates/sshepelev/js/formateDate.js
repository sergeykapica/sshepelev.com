(function()
{
    window.formateDate =
    {
        formateMonthToString: function(month)
        {
            var monthsRU = ['Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря'];
            
            return monthsRU[month];
        }
    };
})();