// 左则菜单
(function ($) {
    $.fn.LvshouSider = function (options) {
        var opts = $.extend({}, $.fn.LvshouSider.defaults, options);
        var base = this;
        var bNone = true;
        var Z_MenuList = $('.Z_MenuList', base);
        var Z_SubList = $('.Z_SubList', base);
        var isIE = $.browser.msie;
        var isIE6 = isIE && ($.browser.version == '6.0');
        function isNone() {
            var timer
            if ($('.Z_SubList').is(":visible") == false) {
                bNone = true;
                clearInterval(timer);
            }
            else {
                bNone = false;
            }
            timer = setTimeout(function () { isNone(); }, 10);
        }
        isNone();
        $('.Z_MenuList >ul >li').hover(function (e, index) {

            var thisLi = this;
            var timeOut = setTimeout(function () {
                showSubList(thisLi);
            }, 10);

            $(Z_SubList).hover(function () {
                clearTimeout(timeOut);
            }, function () {
                setTimeout(function () {
                    hideSubList(thisLi);
                }, 10);

            });
        }, function (e, index) {
            var thisLi = this;
            var timeOut = setTimeout(function () {
                hideSubList(thisLi);
            }, 10);

            $(Z_SubList).hover(function () {
                clearTimeout(timeOut);

            }, function () {

                setTimeout(function () {
                    hideSubList(thisLi);
                }, 10);

            });
        });

        function showSubList(thisLi) {
            $(thisLi).addClass('curr');

            var thisIndex = $(Z_MenuList).find('li').index($(thisLi));

            var subExList = $(Z_SubList).find('div');
            var subViewHeight = 0;
            subViewHeight = $(Z_SubList).find('div').eq(thisIndex).attr('rel');
            if (thisIndex > subExList.length - 1) return;

            var winHeight = $(window).height();
            var subTop = $(thisLi).offset().top - $(window).scrollTop();
            var subBottom = winHeight - subTop - subViewHeight;

            var absTop = $(thisLi).offset().top - opts.fTop + 40;
            var absLeft = 240;

            if (subBottom < 0) {
                absTop = absTop + subBottom;
            }


            $(subExList).each(function (index) {
                if (index == thisIndex) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });

            if (bNone) {
                $(Z_SubList).css({
                    'top': absTop,
                    'left': 200,
                    'opacity': 0.6
                });
                bNone = false;
            }
            $(Z_SubList).show();
            $(Z_SubList).stop().animate({
                left: absLeft,
                opacity: 1
            }, 100);
            setTimeout(function () {

                $(Z_SubList).stop().animate({

                    top: absTop

                }, 100);
            }, 300);


        };

        function hideSubList(thisLi) {
            $(Z_SubList).hide();
            $(thisLi).removeClass('curr');
        };

    };

    $.fn.LvshouSider.defaults = {
        fTop: $('.lvs_head').offset().top + $('.lvs_head').height()
        //fTop: 180 // 距离顶部距离度

    };
})(jQuery);

$(function () {
    $('#Z_TypeList').LvshouSider();

    $('#Olvs #Z_TypeList').hover(function () {
        cover = $(this).hasClass("hover");
        $(this).addClass('hover').children('.Z_MenuList').show();
    }, function () {
        if (cover) {
            $(this).children(".Z_MenuList").hide();
        } else {
            $(this).removeClass('hover').children('.Z_MenuList').hide();
        }
    });
});