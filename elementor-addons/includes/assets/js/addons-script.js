(function ($) {
  "use strict";


    var post_widgetJs = function ($scope, $) {





    }

    //Elementor JS Hooks
    $(window).on('elementor/frontend/init', function () {
       elementorFrontend.hooks.addAction('frontend/element_ready/post_widget.default', post_widgetJs);
    });


})(jQuery);