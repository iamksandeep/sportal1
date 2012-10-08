(function($) {
    // show credentials
    $('.show-university-credentials').live('click', function() {
        $(this).hide();
        $(this).parent().children('.university-credentials').show();
    });
})(jQuery);
