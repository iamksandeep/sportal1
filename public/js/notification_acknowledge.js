(function($) {
    // acknowledge notification
    function ack(url, $n) {
      $.get(url, function() {
        $n.fadeOut();
      });
    }

    // meanwhile, hide this notification
    $('.dismiss-button').live('click', function() {
        $notification = $(this).closest('._view.notification');
        $(this).hide();
        $notification.css({ opacity: 0.5 });
        ack($(this).data('url'), $notification);
    });
})(jQuery);
