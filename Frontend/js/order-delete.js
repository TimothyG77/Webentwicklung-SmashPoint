"use strict";

$(function () {
    const apiPath = "../../Backend/logic/order-delete-form.php";
    const feedback = $("#feedbackMessage");

    // Klick auf Löschen
    $(document).on("click", ".delete-order-btn", function () {
        const row = $(this).closest("tr");
        const orderId = row.data("id");

        if (!confirm(`Möchtest du Bestellung #${orderId} wirklich löschen?`)) return;

        $.ajax({
            url: apiPath,
            method: "DELETE",
            contentType: "application/json",
            dataType: "json",
            data: JSON.stringify({ order_id: orderId }),
            success: function (res) {
                if (res.success) {
                    showFeedback("Bestellung erfolgreich gelöscht.", "success");
                    row.remove();
                } else {
                    showFeedback("Fehler: " + res.message, "danger");
                }
            },
            error: function (xhr) {
                showFeedback("Technischer Fehler: " + xhr.responseText, "danger");
            }
        });
    });

    function showFeedback(message, type) {
        feedback
            .removeClass("d-none alert-success alert-danger alert-info")
            .addClass("alert-" + type)
            .text(message)
            .hide()
            .fadeIn();

        setTimeout(() => {
            feedback.fadeOut(() => feedback.addClass("d-none").removeClass("alert-" + type));
        }, 4000);
    }
});
