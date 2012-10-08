(function($) {
    $('#Document_isApplicationDocument_yes').live('click', function() {
        $('#application-selection').removeClass("hidden");
    });
    $('#Document_isApplicationDocument_no').live('click', function() {
        $('#application-selection').addClass("hidden");
    });
})(jQuery);

