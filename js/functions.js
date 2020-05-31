$(function () {
    bindFieldworkToggle();
    setupScrollToTop();
    initSearchExpand();
    initToggleSubmenu();
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
    var $body = $('body');
    if (!$body.hasClass('home')) {
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

        $body.append($scroller);
    }
}

function setScrollerPosition($scroller) {
    $scroller.css('right', ($(document).outerWidth() - $('.container').outerWidth()) / 2 + 25 + 'px');

}

function isBreakpoint(name) {
    return $('.device-' + name).is(':visible');
}

function initSearchExpand() {
    var $searchForm = $('.search-form');
    $('.search-submit').on('click', function(e) {
        if (isBreakpoint('sm') && !$searchForm.hasClass('expand')) {
            $searchForm.addClass('expand');
            $('.search-field').focus();
            e.preventDefault();
        }
    });

    $('.search-collapse').on('click', function (e) {
        e.preventDefault();
        $searchForm.removeClass('expand');
    });
}


function initToggleSubmenu() {
    var $submenu = $('.sidebar .menu');
    var $toggleWrapper = $('.toggle-submenu');

    $toggleWrapper.on('click', '.btn', function() {
        if ($toggleWrapper.hasClass('hide-menu')) {
            $submenu.removeClass('show');
            $toggleWrapper.removeClass('hide-menu');
        } else {
            $submenu.addClass('show');
            $toggleWrapper.addClass('hide-menu');
        }
    })
}