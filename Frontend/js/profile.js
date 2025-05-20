"use strict";

$(document).ready(function () {
    const modal = new bootstrap.Modal(document.getElementById("passwordModal"));

    let formData = null;

    // API PFad als konstante Variable
    const apiPath = "../../Backend/logic/update-profile.php";

    // Validatoren
    $("input[name='username']").on("input", function () {
        const username = $(this).val().trim();
        $(this).toggleClass("is-invalid", username.length < 4);
        $(this).toggleClass("is-valid", username.length >= 4);
    });

    $("input[name='postal_code']").on("input", function () {
        const valid = /^\d{4,5}$/.test($(this).val());
        $(this).toggleClass("is-invalid", !valid);
        $(this).toggleClass("is-valid", valid);
    });

    $("input[name='email']").on("input", function () {
        const email = $(this).val().trim();
        const formatValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        const endings = [".at", ".de", ".com", ".org", ".net", ".info"];
        const providers = ["gmail", "gmx", "outlook", "yahoo", "hotmail"];
        const endingOk = endings.some(e => email.endsWith(e));
        const providerOk = providers.some(p => email.includes(p));
        const isValid = formatValid && endingOk && providerOk;
        $(this).toggleClass("is-invalid", !isValid);
        $(this).toggleClass("is-valid", isValid);
    });

    // Bei Absenden -> Modal wird geöffnet
    $("#profileForm").on("submit", function (e) {
        e.preventDefault();
        // Verhindert das Standardverhalten des Browsers für bestimmte Evente (Links öffnen, Formulare abschicken)

        formData = {
            salutation: $("select[name='salutation']").val(),
            firstname: $("input[name='firstname']").val(),
            lastname: $("input[name='lastname']").val(),
            address: $("input[name='address']").val(),
            postal_code: $("input[name='postal_code']").val(),
            city: $("input[name='city']").val(),
            email: $("input[name='email']").val(),
            username: $("input[name='username']").val()
        };

        $("#confirmPassword").val(""); // Das Passwortfeld leeren
        modal.show();
    });

    // Wenn im Modal bestätigt wird
    $("#confirmSave").on("click", function () {
        const password = $("#confirmPassword").val();
        if (!password) {
            alert("Bitte Passwort eingeben.");
            return;
        }

        formData.password = password;

        fetch(apiPath, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(formData)
        })
        .then(res => res.json())
        .then(response => {
            if (response.success) {
                $("#update-success").text("Profil aktualisiert.").removeClass("d-none");
                $("#update-error").addClass("d-none");
                modal.hide();
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
