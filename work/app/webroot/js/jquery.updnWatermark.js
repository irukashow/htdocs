/*
* jQuery Watermark Plugin
*   http://updatepanel.net/2009/04/17/jquery-watermark-plugin/
*
* Copyright (c) 2009 Ting Zwei Kuei
*
* Dual licensed under the MIT and GPL licenses.
*   http://www.opensource.org/licenses/mit-license.php
*   http://www.gnu.org/licenses/gpl.html
*/
(function ($) {
    $.fn.updnWatermark = function (options) {
        options = $.extend({}, $.fn.updnWatermark.defaults, options);
        return this.each(function () {
            // only create watermark if title attribute exists
            if (this.title) {
                var $input = $(this);
                var pos = $input.position();

                var pp = $input.parent().position();
                var bLeft = pos.left - pp.left;
                var bTop = pos.top - pp.top;
                if ($input.parent().css("position").toLowerCase() == "static") {
                    $input.parent().css({ position: "relative" });
                } else {
                    bLeft = pos.left;
                    bTop = pos.top;
                }

                var $label = $(document.createElement("label"))
                    .text(this.title)
                    .attr("for", this.id)
                    .css({
                        position: "absolute",
                        left: bLeft,
                        top: bTop
                    })
                    .addClass(options.cssClass)
                    .hide()
                    .insertBefore(this);
                $input
                    .focus(function (ev) {
                        $label.hide();
                    })
                    .blur(function (ev) {
                        if (!$(this).val()) {
                            $label.fadeIn("fast");
                        }
                    });
                // set initial state
                if (!$input.val()) {
                    $label.fadeIn("fast");
                }
            }
        });
    };
    $.fn.updnWatermark.defaults = {
        cssClass: "updnWatermark"
    };
    $.updnWatermark = {
        attachAll: function (options) {
            $("input:text[title!=''],input:password[title!=''],textarea[title!='']").updnWatermark(options);
        }
    };
})(jQuery);