/**
 * Get the coupon and add it to cart
 */
function active_free_order() {

    var $social = jQuery('.dln-button');

    if ($social.is('.disabled')) {
        return false;
    }

    $social.addClass('disabled');

    var form_data = $social.data();

    if (form_data["blockUI.isBlocked"] != 1) {
        $social.block({
            message   : null,
            overlayCSS: {
                background: '#fff',
                opacity   : 0.6
            }
        });
    }


    jQuery.ajax({
        type    : 'POST',
        url     : ndv_share.ajax_social_url,
        data    : {
            post_id: ndv_share.post_id,
            redirect_url: window.location.href
        },
        success : function (code) {
            var result = '';

            try {
                // Get the valid JSON only from the returned string
                if (code.indexOf('<!--WC_START-->') >= 0)
                    code = code.split('<!--WC_START-->')[1]; // Strip off before after WC_START

                if (code.indexOf('<!--WC_END-->') >= 0)
                    code = code.split('<!--WC_END-->')[0]; // Strip off anything after WC_END

                // Parse
                result = jQuery.parseJSON(code);

                if (result.status === 'success') {

                    setTimeout(function () {

                        if (result.redirect.indexOf("https://") != -1 || result.redirect.indexOf("http://") != -1) {
                            window.location = result.redirect;
                        } else {
                            window.location = decodeURI(result.redirect);
                        }

                    }, 3000);


                } else if (result.status === 'failure') {
                    throw 'Result failure';
                } else {
                    throw 'Invalid response';
                }
            }

            catch (err) {

                // Remove old errors
                jQuery('.woocommerce-error, .woocommerce-message').remove();

                // Add new errors
                if (result.messages) {
                    $social.prepend(result.messages);
                } else {
                    $social.prepend(code);
                }

                // Cancel processing
                $social.removeClass('disabled').unblock();

                // Scroll to top
                //jQuery('html, body').animate({
                //    scrollTop: ( jQuery('.ndv_share.social').offset().top - 100 )
                //}, 1000);

            }
        },
        dataType: 'html'
    });

    return false;

}

/**
 * If Facebook active
 */
if (ndv_share.facebook == 'yes') {

    window.fbAsyncInit = function () {

        FB.init({
            appId  : ndv_share.fb_app_id,
            xfbml  : true,
            version: 'v2.4'
        });

        FB.Event.subscribe("edge.create", function (href, widget) {

            active_free_order();

        });

        jQuery('body').trigger('facebook_button');
        jQuery('body').trigger('facebook_share');

    };

    function fbShare(url) {

        FB.ui({
            method : 'feed',
            link   : url,
            description: ndv_share.sharing.message,
            display: 'popup'
        }, function (response) {

            if (response && response.post_id) {

                ndv_share.post_id = response.post_id;

                active_free_order();

            }

        });
    }

    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement(s);
        js.id = id;
        js.src = '//connect.facebook.net/' + ndv_share.locale + '/sdk.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

}

/**
 * If Twitter active
 */
if (ndv_share.twitter == 'yes') {

    window.twttr = (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0],
            t = window.twttr || {};
        if (d.getElementById(id)) return t;
        js = d.createElement(s);
        js.id = id;
        js.src = 'https://platform.twitter.com/widgets.js';
        fjs.parentNode.insertBefore(js, fjs);
        t._e = [];
        t.ready = function (f) {
            t._e.push(f);
        };
        return t;
    }(document, 'script', 'twitter-wjs'));

    twttr.ready(function (twttr) {

        twttr.events.bind('tweet', function (event) {

            active_free_order();

        });

        jQuery('body').trigger('twitter_button');

    });

}

/**
 * If Google+ active
 */
if (ndv_share.google == 'yes') {

    var share_timer = null,
        counter = 0;

    window.___gcfg = {
        lang: ndv_share.locale.substring(0, 2)
    };

    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement(s);
        js.id = id;
        js.src = '//apis.google.com/js/plusone.js?onload=onGoogleLoad';
        js.async = true;
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'google-sdk'));

    function onGoogleLoad() {

        jQuery('body').trigger('google_button');
        jQuery('body').trigger('google_share');

    }

    /**
     * Callback for Google+ button
     * @param jsonParam
     */
    function gpCallback(jsonParam) {

        if (jsonParam.state == 'on') {

            active_free_order();

        }

    }

    /**
     * Callback for Google+ Share button
     * @param jsonParam
     */
    function gpShareCallback(jsonParam) {

        share_timer = setInterval(function () {
            counter++;
            if (counter == 4) {
                active_free_order();
                clearInterval(share_timer);
            }

        }, 1000);

        //console.log('share state ' + JSON.stringify(jsonParam));
        //if (jsonParam.type == 'confirm') { active_free_order(); }

    }

    function gpStopShareCallback(jsonParam) {

        //console.log('share state ' + JSON.stringify(jsonParam));

        if (share_timer != null) {
            counter = 0;
            clearInterval(share_timer);

        }


    }

}

