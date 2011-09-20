$(function()
{  
    initFiltersLink();

    if ($('.grid-view table').attr('sortable'))
    {
        makeSortable();
    }
});


function initFiltersLink()
{
    $('.filters input').each(function()
    {
        if ($(this).val())
        {
            $(this).parents('table:eq(0)').find('.filters').slideToggle();
        }
    });

    $('.grid-view th').each(function()
    {
        if ($(this).html() == '&nbsp;')
        {
            $(this).html("<a href='' class='filters_link'>фильтры</a>");

            $('.filters_link').click(function()
            {
                $(this).parents('table:eq(0)').find('.filters').slideToggle();
                return false;
            });
        }
    });
}


function makeSortable()
{
    var fixHelper = function(e, ui)
    {
        ui.children().each(function() {
            $(this).width($(this).width());
        });
        return ui;
    };

    $(".grid-view tbody").sortable({helper: fixHelper}).disableSelection();
}