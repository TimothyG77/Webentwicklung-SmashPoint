"use strict";

$(function () {
    const apiPath = "../../Backend/logic/user-overview-form.php";
    console.log("Benutzerübersicht geladen.");

    const feedback = $("#feedbackMessage");

    $(".toggle-status-btn").on("click", function () {
        const userId = $(this).data("id");
        const currentStatus = $(this).data("status"); // 'aktiv' oder 'inaktiv'
        const action = currentStatus === "aktiv" ? "deactivate" : "activate";

        $.ajax({
            type: "POST",
            url: apiPath + "?toggle",
            contentType: "application/json",
            dataType: "json",
            data: JSON.stringify({
                id: userId,
                action: action
            }),
            success: function (response) {
                if (response.success) {
                    showFeedback("Benutzer erfolgreich " + (action === "deactivate" ? "deaktiviert." : "aktiviert."), "success");
                    setTimeout(() => location.reload(), 1500); // Automatischer Reload nach 1.5 Sekunden
                } else {
                    showFeedback(response.message, "danger");
                }
            },
            error: function (xhr) {
                showFeedback("AJAX Fehler: " + xhr.responseText, "danger");
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

    $(document).on("click", ".user-row", function () {
        const userId = $(this).data("id");
        window.location.href = `order-delete.php?user_id=${userId}`;
    });
    
});
