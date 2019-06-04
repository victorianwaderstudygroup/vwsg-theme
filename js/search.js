$(function() {
    bindFilterHandlers();
});

function bindFilterHandlers() {
    $('.search_filters .btn').on('click', function() {
        var $results = $('.search_result').filter('.type-' + $(this).data('type'));
        if ($(this).hasClass('on')) {
            $(this).removeClass('on');
            $results.hide();
        } else {
            $(this).addClass('on');
            $results.show();
        }
    });
}