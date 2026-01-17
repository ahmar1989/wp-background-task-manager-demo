jQuery(function ($) {
  $("#wpbtm-start").on("click", function (e) {
    e.preventDefault();

    $.post(
      WPBTM.ajax_url,
      {
        action: "wpbtm_start_task",
        nonce: WPBTM.nonce,
      },
      function () {
        location.reload();
      },
    );
  });

  $("#wpbtm-cancel").on("click", function (e) {
    e.preventDefault();

    $.post(
      WPBTM.ajax_url,
      {
        action: "wpbtm_cancel_task",
        nonce: WPBTM.nonce,
      },
      function () {
        location.reload();
      },
    );
  });
});
