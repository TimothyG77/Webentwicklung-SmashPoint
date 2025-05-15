"use strict";

$(document).ready(function () {
    //API Pfad als konstante Variable definieren
    const apiPath = "../../Backend/logic/update-product.php";

    $("#editProductForm").on("submit", function (e) {
        e.preventDefault();

        const form = document.getElementById("editProductForm");
        const formData = new FormData(form);

        fetch(apiPath, { 
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(response => {
            if (response.success) {
                $("#update-success").text("Produkt erfolgreich aktualisiert.").removeClass("d-none");
                $("#update-error").addClass("d-none");
            } else {
                $("#update-error").text(response.message).removeClass("d-none");
                $("#update-success").addClass("d-none");
            }
        })
        .catch(() => {
            $("#update-error").text("Technischer Fehler.").removeClass("d-none");
            $("#update-success").addClass("d-none");
        });
    });
});
