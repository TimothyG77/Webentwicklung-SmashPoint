"use strict";

$(document).ready(function () {
    // API Pfad als konstante Variable definieren
    const apiPath = "../../Backend/logic/product-delete-form.php";

    $(".delete-product").click(function () {
        const card = $(this).closest("[data-id]");
        const productId = card.data("id");

        // Nach dem Klick auf dem Button kommt ein Bestätigungsfenster mit confirm
        if (confirm("Willst du dieses Produkt wirklich löschen?")) {
            $.ajax({
                url: apiPath, // apiPath verwenden
                method: "DELETE",
                contentType: "application/json",
                dataType: "json", 
                data: JSON.stringify({ id: productId }),
                success: function (response) {
                    if (response.success) {
                        card.remove();
                    } else {
                        alert("Fehler: " + response.message);
                    }
                },
                error: function () {
                    alert("Technischer Fehler beim Löschen.");
                }
            });
        }
    });
});
