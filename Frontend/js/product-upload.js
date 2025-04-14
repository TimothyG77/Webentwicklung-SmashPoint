$(document).ready(function () {
    $("#productUploadForm").on("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        $.ajax({
            url: "../../Backend/logic/product-upload-form.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
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
