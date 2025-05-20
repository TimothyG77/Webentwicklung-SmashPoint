"use strict";

$(document).ready(function () {
    // API Pfad als konstante Variable definieren
    const apiPath = "../../Backend/logic/product-upload-form.php";

    $("#productUploadForm").on("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(this); // Sind die Daten vom Form-Tag im HTML

        $.ajax({
            url: apiPath, // apiPath verwenden
            type: "POST",
            data: formData,
            processData: false, // notwendig für FormData
            contentType: false, // notwendig für FormData
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    $("#upload-success").text("Produkt erfolgreich hochgeladen.").removeClass("d-none");
                    $("#upload-error").addClass("d-none");
                    $("#productUploadForm")[0].reset();
                } else {
                    $("#upload-error").text(response.message).removeClass("d-none");
                    $("#upload-success").addClass("d-none");
                }
            },
            error: function () {
                $("#upload-error").text("Technischer Fehler.").removeClass("d-none");
                $("#upload-success").addClass("d-none");
            }
        });
    });
});
