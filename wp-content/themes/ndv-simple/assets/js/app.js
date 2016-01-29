/*!
 * OneUI - v1.2.0 - Auto-compiled on 2015-09-01 - Copyright 2015 
 * @author pixelcave
 */
var App = function () {
    var a, b, c, d, e, f, g, h, i, j, k = function () {
        a = jQuery("html"), b = jQuery("body"), c = jQuery("#page-container"), d = jQuery("#sidebar"), e = jQuery("#sidebar-scroll"), f = jQuery("#side-overlay"), g = jQuery("#side-overlay-scroll"), h = jQuery("#header-navbar"), i = jQuery("#main-container"), j = jQuery("#page-footer"), jQuery('[data-toggle="tooltip"], .js-tooltip').tooltip({
            container: "body",
            animation: !1
        }), jQuery('[data-toggle="popover"], .js-popover').popover({
            container: "body",
            animation: !0,
            trigger: "hover"
        }), jQuery('[data-toggle="tabs"] a, .js-tabs a').click(function (a) {
            a.preventDefault(), jQuery(this).tab("show")
        })//, jQuery(".form-control").placeholder()
    }, l = function () {
        var b;
        i.length && (m(), jQuery(window).on("resize orientationchange", function () {
            clearTimeout(b), b = setTimeout(function () {
                m()
            }, 150)
        })), n("init"), c.hasClass("header-navbar-fixed") && c.hasClass("header-navbar-transparent") && jQuery(window).on("scroll", function () {
            jQuery(this).scrollTop() > 20 ? c.addClass("header-navbar-scroll") : c.removeClass("header-navbar-scroll")
        }), jQuery('[data-toggle="layout"]').on("click", function () {
            var b = jQuery(this);
            o(b.data("action")), a.hasClass("no-focus") && b.blur()
        })
    }, m = function () {
        var a = jQuery(window).height(), b = h.outerHeight(), d = j.outerHeight();
        c.hasClass("header-navbar-fixed") ? i.css("min-height", a - d) : i.css("min-height", a - (b + d))
    }, n = function (a) {
        var b = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
        if ("init" === a) {
            n();
            var h;
            jQuery(window).on("resize orientationchange", function () {
                clearTimeout(h), h = setTimeout(function () {
                    n()
                }, 150)
            })
        } else b > 991 && c.hasClass("side-scroll") ? (jQuery(d).scrollLock("off"), jQuery(f).scrollLock("off"), e.length && !e.parent(".slimScrollDiv").length ? e.slimScroll({
            height: d.outerHeight(),
            color: "#fff",
            size: "5px",
            opacity: .35,
            wheelStep: 15,
            distance: "2px",
            railVisible: !1,
            railOpacity: 1
        }) : e.add(e.parent()).css("height", d.outerHeight()), g.length && !g.parent(".slimScrollDiv").length ? g.slimScroll({
            height: f.outerHeight(),
            color: "#000",
            size: "5px",
            opacity: .35,
            wheelStep: 15,
            distance: "2px",
            railVisible: !1,
            railOpacity: 1
        }) : g.add(g.parent()).css("height", f.outerHeight())) : (jQuery(d).scrollLock(), jQuery(f).scrollLock(), e.length && e.parent(".slimScrollDiv").length && (e.slimScroll({destroy: !0}), e.attr("style", "")), g.length && g.parent(".slimScrollDiv").length && (g.slimScroll({destroy: !0}), g.attr("style", "")))
    }, o = function (a) {
        var b = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
        switch (a) {
            case"sidebar_pos_toggle":
                c.toggleClass("sidebar-l sidebar-r");
                break;
            case"sidebar_pos_left":
                c.removeClass("sidebar-r").addClass("sidebar-l");
                break;
            case"sidebar_pos_right":
                c.removeClass("sidebar-l").addClass("sidebar-r");
                break;
            case"sidebar_toggle":
                b > 991 ? c.toggleClass("sidebar-o") : c.toggleClass("sidebar-o-xs");
                break;
            case"sidebar_open":
                b > 991 ? c.addClass("sidebar-o") : c.addClass("sidebar-o-xs");
                break;
            case"sidebar_close":
                b > 991 ? c.removeClass("sidebar-o") : c.removeClass("sidebar-o-xs");
                break;
            case"sidebar_mini_toggle":
                b > 991 && c.toggleClass("sidebar-mini");
                b > 991 && c.toggleClass("dln-full-container");
                break;
            case"sidebar_mini_on":
                b > 991 && c.addClass("sidebar-mini");
                break;
            case"sidebar_mini_off":
                b > 991 && c.removeClass("sidebar-mini");
                break;
            case"side_overlay_toggle":
                c.toggleClass("side-overlay-o");
                break;
            case"side_overlay_open":
                c.addClass("side-overlay-o");
                break;
            case"side_overlay_close":
                c.removeClass("side-overlay-o");
                break;
            case"side_overlay_hoverable_toggle":
                c.toggleClass("side-overlay-hover");
                break;
            case"side_overlay_hoverable_on":
                c.addClass("side-overlay-hover");
                break;
            case"side_overlay_hoverable_off":
                c.removeClass("side-overlay-hover");
                break;
            case"header_fixed_toggle":
                c.toggleClass("header-navbar-fixed");
                break;
            case"header_fixed_on":
                c.addClass("header-navbar-fixed");
                break;
            case"header_fixed_off":
                c.removeClass("header-navbar-fixed");
                break;
            case"side_scroll_toggle":
                c.toggleClass("side-scroll"), n();
                break;
            case"side_scroll_on":
                c.addClass("side-scroll"), n();
                break;
            case"side_scroll_off":
                c.removeClass("side-scroll"), n();
                break;
            default:
                return !1
        }
    }, p = function () {
        jQuery('[data-toggle="nav-submenu"]').on("click", function (b) {
            var c = jQuery(this), d = c.parent("li");
            return d.hasClass("open") ? d.removeClass("open") : (c.closest("ul").find("> li").removeClass("open"), d.addClass("open")), a.hasClass("no-focus") && c.blur(), !1
        })
    }, q = function () {
        r(!1, "init"), jQuery('[data-toggle="block-option"]').on("click", function () {
            r(jQuery(this).parents(".block"), jQuery(this).data("action"))
        })
    }, r = function (a, b) {
        var c = "si si-size-fullscreen", d = "si si-size-actual", e = "si si-arrow-up", f = "si si-arrow-down";
        if ("init" === b)jQuery('[data-toggle="block-option"][data-action="fullscreen_toggle"]').each(function () {
            var a = jQuery(this);
            a.html('<i class="' + (jQuery(this).closest(".block").hasClass("block-opt-fullscreen") ? d : c) + '"></i>')
        }), jQuery('[data-toggle="block-option"][data-action="content_toggle"]').each(function () {
            var a = jQuery(this);
            a.html('<i class="' + (a.closest(".block").hasClass("block-opt-hidden") ? f : e) + '"></i>')
        }); else {
            var g = a instanceof jQuery ? a : jQuery(a);
            if (g.length) {
                var h = jQuery('[data-toggle="block-option"][data-action="fullscreen_toggle"]', g), i = jQuery('[data-toggle="block-option"][data-action="content_toggle"]', g);
                switch (b) {
                    case"fullscreen_toggle":
                        g.toggleClass("block-opt-fullscreen"), g.hasClass("block-opt-fullscreen") ? jQuery(g).scrollLock() : jQuery(g).scrollLock("off"), h.length && (g.hasClass("block-opt-fullscreen") ? jQuery("i", h).removeClass(c).addClass(d) : jQuery("i", h).removeClass(d).addClass(c));
                        break;
                    case"fullscreen_on":
                        g.addClass("block-opt-fullscreen"), jQuery(g).scrollLock(), h.length && jQuery("i", h).removeClass(c).addClass(d);
                        break;
                    case"fullscreen_off":
                        g.removeClass("block-opt-fullscreen"), jQuery(g).scrollLock("off"), h.length && jQuery("i", h).removeClass(d).addClass(c);
                        break;
                    case"content_toggle":
                        g.toggleClass("block-opt-hidden"), i.length && (g.hasClass("block-opt-hidden") ? jQuery("i", i).removeClass(e).addClass(f) : jQuery("i", i).removeClass(f).addClass(e));
                        break;
                    case"content_hide":
                        g.addClass("block-opt-hidden"), i.length && jQuery("i", i).removeClass(e).addClass(f);
                        break;
                    case"content_show":
                        g.removeClass("block-opt-hidden"), i.length && jQuery("i", i).removeClass(f).addClass(e);
                        break;
                    case"refresh_toggle":
                        g.toggleClass("block-opt-refresh"), jQuery('[data-toggle="block-option"][data-action="refresh_toggle"][data-action-mode="demo"]', g).length && setTimeout(function () {
                            g.removeClass("block-opt-refresh")
                        }, 2e3);
                        break;
                    case"state_loading":
                        g.addClass("block-opt-refresh");
                        break;
                    case"state_normal":
                        g.removeClass("block-opt-refresh");
                        break;
                    case"close":
                        g.hide();
                        break;
                    case"open":
                        g.show();
                        break;
                    default:
                        return !1
                }
            }
        }
    }, s = function () {
        jQuery(".form-material.floating > .form-control").each(function () {
            var a = jQuery(this), b = a.parent(".form-material");
            a.val() && b.addClass("open"), a.on("change", function () {
                a.val() ? b.addClass("open") : b.removeClass("open")
            })
        })
    }, t = function () {
        var a = jQuery("#css-theme"), b = c.hasClass("enable-cookies") ? !0 : !1;
        if (b) {
            var d = Cookies.get("colorTheme") ? Cookies.get("colorTheme") : !1;
            d && ("default" === d ? a.length && a.remove() : a.length ? a.attr("href", d) : jQuery("#css-main").after('<link rel="stylesheet" id="css-theme" href="' + d + '">')), a = jQuery("#css-theme")
        }
        jQuery('[data-toggle="theme"][data-theme="' + (a.length ? a.attr("href") : "default") + '"]').parent("li").addClass("active"), jQuery('[data-toggle="theme"]').on("click", function () {
            var c = jQuery(this), d = c.data("theme");
            jQuery('[data-toggle="theme"]').parent("li").removeClass("active"), jQuery('[data-toggle="theme"][data-theme="' + d + '"]').parent("li").addClass("active"), "default" === d ? a.length && a.remove() : a.length ? a.attr("href", d) : jQuery("#css-main").after('<link rel="stylesheet" id="css-theme" href="' + d + '">'), a = jQuery("#css-theme"), b && Cookies.set("colorTheme", d, {expires: 7})
        })
    }, u = function () {
        jQuery('[data-toggle="scroll-to"]').on("click", function () {
            var a = jQuery(this), b = a.data("target"), c = a.data("speed") ? a.data("speed") : 1e3;
            jQuery("html, body").animate({scrollTop: jQuery(b).offset().top}, c)
        })
    }, v = function () {
        jQuery('[data-toggle="class-toggle"]').on("click", function () {
            var b = jQuery(this);
            jQuery(b.data("target").toString()).toggleClass(b.data("class").toString()), a.hasClass("no-focus") && b.blur()
        })
    }, w = function () {
        var a = new Date, b = jQuery(".js-year-copy");
        2015 === a.getFullYear() ? b.html("2015") : b.html("2015-" + a.getFullYear().toString().substr(2, 2))
    }, x = function () {
        var a = c.prop("class");
        c.prop("class", ""), window.print(), c.prop("class", a)
    }, y = function () {
        var a = jQuery(".js-table-sections"), b = jQuery(".js-table-sections-header > tr", a);
        b.click(function (b) {
            var c = jQuery(this), d = c.parent("tbody");
            d.hasClass("open") || jQuery("tbody", a).removeClass("open"), d.toggleClass("open")
        })
    }, z = function () {
        var a = jQuery(".js-table-checkable");
        jQuery("thead input:checkbox", a).click(function () {
            var b = jQuery(this).prop("checked");
            jQuery("tbody input:checkbox", a).each(function () {
                var a = jQuery(this);
                a.prop("checked", b), A(a, b)
            })
        }), jQuery("tbody input:checkbox", a).click(function () {
            var a = jQuery(this);
            A(a, a.prop("checked"))
        }), jQuery("tbody > tr", a).click(function (a) {
            if ("checkbox" !== a.target.type && "button" !== a.target.type && "a" !== a.target.tagName.toLowerCase() && !jQuery(a.target).parent("label").length) {
                var b = jQuery("input:checkbox", this), c = b.prop("checked");
                b.prop("checked", !c), A(b, !c)
            }
        })
    }, A = function (a, b) {
        b ? a.closest("tr").addClass("active") : a.closest("tr").removeClass("active")
    }, B = function () {
        jQuery('[data-toggle="appear"]').each(function () {
            var b = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth, c = jQuery(this), d = c.data("class") ? c.data("class") : "animated fadeIn", e = c.data("offset") ? c.data("offset") : 0, f = a.hasClass("ie9") || 992 > b ? 0 : c.data("timeout") ? c.data("timeout") : 0;
            c.appear(function () {
                setTimeout(function () {
                    c.removeClass("visibility-hidden").addClass(d)
                }, f)
            }, {accY: e})
        })
    }, C = function () {
        jQuery('[data-toggle="countTo"]').each(function () {
            var a = jQuery(this), b = a.data("after"), c = a.data("speed") ? a.data("speed") : 1500, d = a.data("interval") ? a.data("interval") : 15;
            a.appear(function () {
                a.countTo({
                    speed: c, refreshInterval: d, onComplete: function () {
                        b && a.html(a.html() + b)
                    }
                })
            })
        })
    }, D = function () {
        jQuery('[data-toggle="slimscroll"]').each(function () {
            var a = jQuery(this), b = a.data("height") ? a.data("height") : "200px", c = a.data("size") ? a.data("size") : "5px", d = a.data("position") ? a.data("position") : "right", e = a.data("color") ? a.data("color") : "#000", f = a.data("always-visible") ? !0 : !1, g = a.data("rail-visible") ? !0 : !1, h = a.data("rail-color") ? a.data("rail-color") : "#999", i = a.data("rail-opacity") ? a.data("rail-opacity") : .3;
            a.slimScroll({
                height: b,
                size: c,
                position: d,
                color: e,
                alwaysVisible: f,
                railVisible: g,
                railColor: h,
                railOpacity: i
            })
        })
    }, E = function () {
        jQuery(".js-gallery").each(function () {
            jQuery(this).magnificPopup({delegate: "a.img-link", type: "image", gallery: {enabled: !0}})
        }), jQuery(".js-gallery-advanced").each(function () {
            jQuery(this).magnificPopup({delegate: "a.img-lightbox", type: "image", gallery: {enabled: !0}})
        })
    }, F = function () {
        CKEDITOR.disableAutoInline = !0, jQuery("#js-ckeditor-inline").length && CKEDITOR.inline("js-ckeditor-inline"), jQuery("#js-ckeditor").length && CKEDITOR.replace("js-ckeditor")
    }, G = function () {
        jQuery(".js-summernote-air").summernote({airMode: !0}), jQuery(".js-summernote").summernote({
            height: 350,
            minHeight: null,
            maxHeight: null
        })
    }, H = function () {
        jQuery(".js-slider").each(function () {
            var a = jQuery(this), b = a.data("slider-arrows") ? a.data("slider-arrows") : !1, c = a.data("slider-dots") ? a.data("slider-dots") : !1, d = a.data("slider-num") ? a.data("slider-num") : 1, e = a.data("slider-autoplay") ? a.data("slider-autoplay") : !1, f = a.data("slider-autoplay-speed") ? a.data("slider-autoplay-speed") : 3e3;
            a.slick({arrows: b, dots: c, slidesToShow: d, autoplay: e, autoplaySpeed: f})
        })
    }, I = function () {
        jQuery(".js-datepicker").add(".input-daterange").datepicker({weekStart: 1, autoclose: !0, todayHighlight: !0})
    }, J = function () {
        jQuery(".js-colorpicker").each(function () {
            var a = jQuery(this), b = a.data("colorpicker-mode") ? a.data("colorpicker-mode") : "hex", c = a.data("colorpicker-inline") ? !0 : !1;
            a.colorpicker({format: b, inline: c})
        })
    }, K = function () {
        jQuery(".js-masked-date").mask("99/99/9999"), jQuery(".js-masked-date-dash").mask("99-99-9999"), jQuery(".js-masked-phone").mask("(999) 999-9999"), jQuery(".js-masked-phone-ext").mask("(999) 999-9999? x99999"), jQuery(".js-masked-taxid").mask("99-9999999"), jQuery(".js-masked-ssn").mask("999-99-9999"), jQuery(".js-masked-pkey").mask("a*-999-a999")
    }, L = function () {
        jQuery(".js-tags-input").tagsInput({
            height: "36px",
            width: "100%",
            defaultText: "Add tag",
            removeWithBackspace: !0,
            delimiter: [","]
        })
    }, M = function () {
        jQuery(".js-select2").select2({
            width: '100%'
        });
    }, N = function () {
        hljs.initHighlightingOnLoad()
    }, O = function () {
        jQuery(".js-notify").on("click", function () {
            var a = jQuery(this), b = a.data("notify-message"), c = a.data("notify-type") ? a.data("notify-type") : "info", d = a.data("notify-from") ? a.data("notify-from") : "top", e = a.data("notify-align") ? a.data("notify-align") : "right", f = a.data("notify-icon") ? a.data("notify-icon") : "", g = a.data("notify-url") ? a.data("notify-url") : "";
            jQuery.notify({icon: f, message: b, url: g}, {
                element: "body",
                type: c,
                allow_dismiss: !0,
                newest_on_top: !0,
                showProgressbar: !1,
                placement: {from: d, align: e},
                offset: 20,
                spacing: 10,
                z_index: 1031,
                delay: 5e3,
                timer: 1e3,
                animate: {enter: "animated fadeIn", exit: "animated fadeOutDown"}
            })
        })
    }, P = function () {
        jQuery(".js-draggable-items > .draggable-column").sortable({
            connectWith: ".draggable-column",
            items: ".draggable-item",
            dropOnEmpty: !0,
            opacity: .75,
            handle: ".draggable-handler",
            placeholder: "draggable-placeholder",
            tolerance: "pointer",
            start: function (a, b) {
                b.placeholder.css({height: b.item.outerHeight(), "margin-bottom": b.item.css("margin-bottom")})
            }
        })
    }, Q = function () {
        jQuery(".js-pie-chart").easyPieChart({
            barColor: jQuery(this).data("bar-color") ? jQuery(this).data("bar-color") : "#777777",
            trackColor: jQuery(this).data("track-color") ? jQuery(this).data("track-color") : "#eeeeee",
            lineWidth: jQuery(this).data("line-width") ? jQuery(this).data("line-width") : 3,
            size: jQuery(this).data("size") ? jQuery(this).data("size") : "80",
            animate: 750,
            scaleColor: jQuery(this).data("scale-color") ? jQuery(this).data("scale-color") : !1
        })
    }, R = function () {
        jQuery(".js-maxlength").each(function () {
            var a = jQuery(this);
            a.maxlength({
                alwaysShow: a.data("always-show") ? !0 : !1,
                threshold: a.data("threshold") ? a.data("threshold") : 10,
                warningClass: a.data("warning-class") ? a.data("warning-class") : "label label-warning",
                limitReachedClass: a.data("limit-reached-class") ? a.data("limit-reached-class") : "label label-danger",
                placement: a.data("placement") ? a.data("placement") : "bottom",
                preText: a.data("pre-text") ? a.data("pre-text") : "",
                separator: a.data("separator") ? a.data("separator") : "/",
                postText: a.data("post-text") ? a.data("post-text") : ""
            })
        })
    }, S = function () {
        jQuery(".js-datetimepicker").each(function () {
            var a = jQuery(this);
            a.datetimepicker({
                format: a.data("format") ? a.data("format") : !1,
                useCurrent: a.data("use-current") ? a.data("use-current") : !1,
                locale: moment.locale("" + (a.data("locale") ? a.data("locale") : "")),
                showTodayButton: a.data("show-today-button") ? a.data("show-today-button") : !1,
                showClear: a.data("show-clear") ? a.data("show-clear") : !1,
                showClose: a.data("show-close") ? a.data("show-close") : !1,
                sideBySide: a.data("side-by-side") ? a.data("side-by-side") : !1,
                inline: a.data("inline") ? a.data("inline") : !1,
                icons: {
                    time: "si si-clock",
                    date: "si si-calendar",
                    up: "si si-arrow-up",
                    down: "si si-arrow-down",
                    previous: "si si-arrow-left",
                    next: "si si-arrow-right",
                    today: "si si-size-actual",
                    clear: "si si-trash",
                    close: "si si-close"
                }
            })
        })
    }, T = function () {
        jQuery(".js-rangeslider").each(function () {
            var a = jQuery(this);
            a.ionRangeSlider()
        })
    };
    return {
        init: function (a) {
            switch (a) {
                case"uiInit":
                    k();
                    break;
                case"uiLayout":
                    l();
                    break;
                case"uiNav":
                    p();
                    break;
                case"uiBlocks":
                    q();
                    break;
                case"uiForms":
                    s();
                    break;
                case"uiHandleTheme":
                    t();
                    break;
                case"uiToggleClass":
                    v();
                    break;
                case"uiScrollTo":
                    u();
                    break;
                case"uiYearCopy":
                    w();
                    break;
                default:
                    k(), l(), p(), q(), s(), t(), v(), u(), w()
            }
        }, layout: function (a) {
            o(a)
        }, blocks: function (a, b) {
            r(a, b)
        }, initHelper: function (a) {
            switch (a) {
                case"print-page":
                    x();
                    break;
                case"table-tools":
                    y(), z();
                    break;
                case"appear":
                    B();
                    break;
                case"appear-countTo":
                    C();
                    break;
                case"slimscroll":
                    D();
                    break;
                case"magnific-popup":
                    E();
                    break;
                case"ckeditor":
                    F();
                    break;
                case"summernote":
                    G();
                    break;
                case"slick":
                    H();
                    break;
                case"datepicker":
                    I();
                    break;
                case"colorpicker":
                    J();
                    break;
                case"tags-inputs":
                    L();
                    break;
                case"masked-inputs":
                    K();
                    break;
                case"select2":
                    M();
                    break;
                case"highlightjs":
                    N();
                    break;
                case"notify":
                    O();
                    break;
                case"draggable-items":
                    P();
                    break;
                case"easy-pie-chart":
                    Q();
                    break;
                case"maxlength":
                    R();
                    break;
                case"datetimepicker":
                    S();
                    break;
                case"rangeslider":
                    T();
                    break;
                default:
                    return !1
            }
        }, initHelpers: function (a) {
            if (a instanceof Array)for (var b in a)App.initHelper(a[b]); else App.initHelper(a)
        }
    }
}(), OneUI = App;
jQuery(function () {
    "undefined" == typeof angular && App.init()
});

jQuery(document).ready(function () {

    // Init for property add page.
    var initArr = ['appear', 'select2', 'notify'];

    if (typeof(App) !== undefined) {
        App.initHelpers(initArr);
    }
});
