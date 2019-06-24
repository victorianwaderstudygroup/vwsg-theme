$(function () {
    bindFieldworkToggle();
});

function bindFieldworkToggle() {
    $('.fieldwork-entry header').on('click', function () {
        var $entry = $(this).parent();
        if ($entry.hasClass('open')) {
            $entry.find('.content').hide();
            $entry.removeClass('open');
        } else {
            $entry.find('.content').show();
            $entry.addClass('open');
        }
    });
}