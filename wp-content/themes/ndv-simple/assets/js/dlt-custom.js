(function ($) {
    'use strict';

    $(document).ready(function () {
        // Add active class for selected mennu
        $('#dlt-menu-account ul li').each(function () {
        	$(this).click(function () {
				$('#dlt-menu-account ul li.active').removeClass('active');

        		$(this).addClass('active');
        	});
        });
    });

})(jQuery);
