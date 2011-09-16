$(function()
{
    $('.grid-view th').each(function()
    {
        if ($(this).html() == '&nbsp;')
        {
            $(this).html("<a href='' class='filters_link'>фильтры</a>");

            $('.filters_link').live('click', function()
            {
                $(this).parents('table:eq(0)').find('.filters').slideToggle();
                return false;
            });
        }
    });
});