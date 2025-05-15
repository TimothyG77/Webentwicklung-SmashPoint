"use strict";

$(function () {
    const apiPath = "../../Backend/logic/order-item-delete-form.php";
    const feedback = $("#feedbackMessage");

    $(document).on("click", ".delete-item-btn", function () {
        const row = $(this).closest("tr");
        const itemId = row.data("id");

        if (!confirm(`Produktposition #${itemId} wirklich löschen?`)) return;

        $.ajax({
            url: apiPath,
            method: "DELETE",
            contentType: "application/json",
            data: JSON.stringify({ item_id: itemId }),
            success: function (res) {
                if (res.success) {
                    showFeedback("Produkt erfolgreich gelöscht.", "success");
                    row.remove();
                } else {
                    showFeedback("Fehler: " + res.message, "danger");
                }
            },
            error: function () {
                showFeedback("Technischer Fehler beim Löschen.", "danger");
            }
        });
    });

    function showFeedback(message, type) {
        feedback.removeClass("d-none alert-success alert-danger")
                .addClass("alert-" + type)
                .text(message)
                .hide().fadeIn();

        setTimeout(() => {
            feedback.fadeOut(() => feedback.addClass("d-none").removeClass("alert-" + type));
        }, 3000);
    }
});
