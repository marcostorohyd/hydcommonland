$.fn.serializeObject = function () {
    var o = {};
    var elements = [];
    $(this).find(':input').each(function (index, item) {
        elements[$(item).attr('name')] = $(item).attr('multiple') || '';
    });

    var a = this.serializeArray();
    $.each(a, function () {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else if (elements[this.name]) {
            o[this.name] = new Array(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

$.fn.removeAttributes = function () {
    return this.each(function () {
        var attributes = $.map(this.attributes, function (item) {
            return item.name;
        });
        var img = $(this);
        $.each(attributes, function (i, item) {
            img.removeAttr(item);
        });
    });
}

function NotifyTable(id_table, type, text) {
    $('#notify-sms-table').fadeOut();
    var cs = $('.count_search').html() - 0;
    cs -= 1;
    $('.count_search').html(cs);
    var ct = $('.count_total').html() - 0;
    ct -= 1;
    $('.count_total').html(ct);

    var sms = '<div id="notify-sms-table" class="row mb-4"><div class="col-12"><div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">';
    sms += text;
    sms += '</div></div></div>';

    $(id_table).prepend(sms);
}

/**
 * Show loading effect
 * @param  {bool} selector
 * @return {void}
 */
function loading(selector) {
    selector = selector || false;

    if (selector) {
        if (display === false) {
            $(selector + ' #loading').hide();
            $(selector + ' #loading').remove();
        } else {
            var loading = $('#loading').html();
            $(selector).css('position', 'relative');
            $(selector).append('<div id="loading" style="position: absolute;">' + loading + '</div>');
            $(selector + ' #loading').show();
        }
    } else {
        $('body').toggleClass('loading', !$('body').hasClass('loading'));
    }
}

function getUrlParameter(sParam, url) {
    var sPageURL = url.substring(url.indexOf('?') + 1) || window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
}

/**
 * Effect on submit type image
 */
function submitImageHover() {
    $('[type="image"]').hover(function (e) {
        $(this).attr('type', 'submit');
    }, function (e) {
        $(this).attr('type', 'image');
    });
}

function sidebarSize() {
    var availableHeight = $('main').innerHeight() - 80 - $(window).scrollTop();
    $('body.backend #sidebar').css('max-height', availableHeight);
}

function filterMargin() {
    if (!$('body.frontend.index').length) {
        return;
    }

    $('h1, .title').toggleClass('pagination-margin', 1 == $('.pagination').length);
    $('h1, .title').toggleClass('subsection-margin', 1 == $('.subsection').length);
}

$(function () {
    filterMargin();

    $(document).ajaxComplete(function () {
        filterMargin();
    });

    $('label:has(+ select), .label:has(+ select), .label[data-toggle="collapse"]').addClass('select');

    $('[data-condition]').conditionize({
        updateOn: ['change', 'keyup'],
        ifTrue: function($s) {
            $s.show();
        },
        ifFalse: ['hide', 'clearFields'],
    });

    setInterval(function () {
        $('label.select, .label.select').each(function (index, elem) {
            $(elem).toggleClass('show', 0 !== $(elem).parent().find('.select2-container--open').length);
        })
    }, 500);

    $(window).resize(function () {
        sidebarSize();

        // $('.select2').select2().on('select2:unselect', function (e) {
        //   if (!e.params.originalEvent) {
        //     return;
        //   }

        //   e.params.originalEvent.stopPropagation();
        // });

        if (1200 <= $(window).width()) {
            $('.overflow').each(function (index, element) {
                var height = 0;
                $(element).find('> *').each(function (index, elem) {
                    height += $(elem).outerHeight();
                });
                var max = $(element).data('overflow-max') ? $($(element).data('overflow-max')).outerHeight() : 636;
                $(element).css('max-height', max).toggleClass('more', height > max);
                $(element).next().find('img').css('max-height', max - 120 - 78 - 40);
            })
        } else {
            $('.overflow').css('max-height', 'initial').removeClass('more');
        }

        // $('#navbar-main').css('top', $('body > .navbar:first-child').outerHeight(true));
    }).trigger('resize');

    $(window).scroll(function () {
        sidebarSize();

        if ($(window).scrollTop() > 44) {
            // var scrollTop = $(window).scrollTop();
            $('body').addClass('scroll');
            // if (45 < scrollTop && 55 > scrollTop) {
            //   $(window).scrollTop(100);
            // }
        } else if (0 == $(window).scrollTop()) {
            $('body').removeClass('scroll');
        }
    }).trigger('scroll');

    // Menu
    $('#navbarMenu').on('hide.bs.collapse', function () {
        $('body').removeClass('menu-toggle');
    });
    $('#navbarMenu').on('show.bs.collapse', function () {
        $('body').addClass('menu-toggle');
    });

    $('.toggle-password').on('click', function () {
        const $input = $(this).prev('input');

        if ('password' === $input.attr('type')) {
            $input.attr('type', 'text');
        } else {
            $input.attr('type', 'password');
        }
    });

    $('.select-all').on('click', function (e) {
        $(this).closest('.input-group').find('option').prop('selected', true).trigger('change');
    });

    // Submit type image
    submitImageHover();

    // /**
    //  * Replace all SVG images with inline SVG
    //  */
    // $('img.svg').each(function() {
    //   var $img = $(this);
    //   var imgID = $img.attr('id');
    //   var imgClass = $img.attr('class');
    //   var imgURL = $img.attr('src');

    //   $.get(imgURL, function(data) {
    //     // Get the SVG tag, ignore the rest
    //     var $svg = $(data).find('svg');

    //     // Add replaced image's ID to the new SVG
    //     if (typeof imgID !== 'undefined') {
    //       $svg = $svg.attr('id', imgID);
    //     }
    //     // Add replaced image's classes to the new SVG
    //     if (typeof imgClass !== 'undefined') {
    //       $svg = $svg.attr('class', imgClass + ' replaced-svg');
    //     }

    //     // Remove any invalid XML tags as per http://validator.w3.org
    //     $svg = $svg.removeAttr('xmlns:a');

    //     // Check if the viewport is set, if the viewport is not set the SVG wont't scale.
    //     if (! $svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
    //       $svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
    //     }

    //     // Replace image with new SVG
    //     $img.replaceWith($svg);
    //   }, 'xml');
    // });
});
