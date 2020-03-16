$(function () {
    bindFieldworkToggle();
    setupScrollToTop();
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

function setupScrollToTop() {
    var $scroller = $('<button />');
    $scroller.addClass('scroll-to-top');
    $scroller.append(
        $('<i />').addClass('fas fa-arrow-circle-up')
    );
    $scroller.attr('title', 'Back to top');

    $(window).resize(function() {
        setScrollerPosition($scroller);
    }).resize();

    $scroller.on('click', function () {
       $(window).scrollTop(0);
    });

    $(window).on('scroll', function () {
        var scrollOffset = ($(document).outerHeight() - ($(document).scrollTop() + $(window).height()));
        var footerHeight = 540;
        if (scrollOffset < footerHeight) {
            $scroller.css('bottom', footerHeight - scrollOffset + 'px');
        }

        if ($(this).scrollTop() > ($(window).height() * 0.2)) {
            $scroller.fadeIn(200);
        } else {
            $scroller.fadeOut(200);
        }
    }).scroll();

    $('body').append($scroller);

}

function setScrollerPosition($scroller) {
    $scroller.css('right', ($(document).outerWidth() - $('.container').outerWidth()) / 2 + 15 + 'px');

}