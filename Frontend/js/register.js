$(document).ready(function () {
    // Passwort anzeigen/ausblenden – für erstes Feld
    $("#togglePassword").click(function () {
        const passwordField = $("#password");
        const type = passwordField.attr("type") === "password" ? "text" : "password";
        passwordField.attr("type", type);
        $(this).text(type === "password" ? "👁" : "🔒");
    });

    // Passwort anzeigen/ausblenden – für Bestätigungsfeld
    $("#toggleConfirmPassword").click(function () {
        const confirmField = $("#confirm_password");
        const type = confirmField.attr("type") === "password" ? "text" : "password";
        confirmField.attr("type", type);
        $(this).text(type === "password" ? "👁" : "🔒");
    });

    // PLZ Validierung (4-stellig)
    $("#plz").on("input", function () {
        const plzValue = $(this).val();
        if (!/^\d{4,5}$/.test(plzValue)) {
            $(this).addClass("is-invalid");
        } else {
            $(this).removeClass("is-invalid");
        }
    });

// Benutzername Live-Prüfung + Mindestlänge
$("#benutzername").on("input", function () {
    const username = $(this).val().trim();

    if (username.length < 4) {
        $("#username-check").text("Mindestens 4 Zeichen erforderlich.")
            .removeClass("text-success").addClass("text-danger");
        $("#benutzername").addClass("is-invalid").removeClass("is-valid");
        return;
    }

    $.ajax({
        url: "../../Backend/logic/check-username.php",
        method: "POST",
        data: { benutzername: username },
        success: function (response) {
            if (response === "taken") {
                $("#username-check").text("Benutzername ist bereits vergeben.")
                    .removeClass("text-success").addClass("text-danger");
                $("#benutzername").addClass("is-invalid").removeClass("is-valid");
            } else {
                $("#username-check").text("Benutzername ist verfügbar.")
                    .removeClass("text-danger").addClass("text-success");
                $("#benutzername").removeClass("is-invalid").addClass("is-valid");
            }
        }
    });
});


// E-Mail Live-Prüfung & Validierung
$("#email").on("input", function () {
    const email = $(this).val().trim();
    const endings = [".at", ".de", ".com", ".org", ".net", ".info", ".co", ".ch", ".eu", ".edu"];
    const providers = ["gmail", "yahoo", "hotmail", "outlook", "gmx", "protonmail"];

    const hasValidFormat = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    const hasValidEnding = endings.some(ending => email.endsWith(ending));
    const hasValidProvider = providers.some(provider => email.toLowerCase().includes(provider));

    if (email.length === 0) {
        $("#email").removeClass("is-valid is-invalid");
        $("#email-feedback").text("");
        return;
    }

    if (hasValidFormat && hasValidEnding && hasValidProvider) {
        $.ajax({
            url: "../../Backend/logic/check-email.php",
            method: "POST",
            data: { email: email },
            success: function (response) {
                if (response === "taken") {
                    $("#email").addClass("is-invalid").removeClass("is-valid");
                    $("#email-feedback").text("E-Mail-Adresse wird bereits verwendet.");
                } else {
                    $("#email").removeClass("is-invalid").addClass("is-valid");
                    $("#email-feedback").text("");
                }
            }
        });
    } else {
        $("#email").removeClass("is-valid").addClass("is-invalid");
        $("#email-feedback").text("Bitte verwenden Sie eine gültige E-Mail-Adresse mit einem bekannten Anbieter.");
    }
});

// Passwort-Validierung (mind. 7 Zeichen, 1 Zahl, 1 Sonderzeichen)
$("#password").on("input", function () {
    const password = $(this).val();
    const regex = /^(?=.*\d)(?=.*[\W_]).{7,}$/;

    if (regex.test(password)) {
        $(this).removeClass("is-invalid").addClass("is-valid");
        $("#password-feedback").hide();
    } else {
        $(this).removeClass("is-valid").addClass("is-invalid");
        $("#password-feedback").show();
    }
});


// Logik Teil mit AJAX einsteigen

$("#registerForm").on("submit", function (e) {
    e.preventDefault();

    const userData = {
        anrede: $("#anrede").val(),
        vorname: $("#vorname").val(),
        nachname: $("#nachname").val(),
        adresse: $("#adresse").val(),
        plz: $("#plz").val(),
        ort: $("#ort").val(),
        email: $("#email").val(),
        benutzername: $("#benutzername").val(),
        password: $("#password").val(),
        confirm_password: $("#confirm_password").val()
    };

    $.ajax({
        url: "../../Backend/logic/register-form.php",
        type: "POST",
        contentType: "application/json",
        dataType: "json",
        data: JSON.stringify(userData),
        success: function (response) {
            if (response.success) {
                //Optional: Erfolgsmeldung kurz anzeigen
                $("#register-success").text("Registrierung erfolgreich!").removeClass("d-none");
                $("#register-error").addClass("d-none");
            
                //1 Sekunde warten, dann weiterleiten zur Startseite
                setTimeout(() => {
                    window.location.href = "index.php";
                }, 1000);
            } else {
                $("#register-error").text(response.message).removeClass("d-none");
                $("#register-success").addClass("d-none");
            }
        },
        error: function () {
            $("#register-error").text("Ein technischer Fehler ist aufgetreten.").removeClass("d-none");
            $("#register-success").addClass("d-none");
        }
    });
});



    
});
