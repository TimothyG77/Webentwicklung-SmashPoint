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
        if (!/^\d{4}$/.test(plzValue)) {
            $(this).addClass("is-invalid");
        } else {
            $(this).removeClass("is-invalid");
        }
    });

    // Benutzername Live-Prüfung
$("#benutzername").on("keyup", function () {
    const username = $(this).val();
    if (username.length > 3) {
        $.ajax({
            url: "../../Backend/logic/check-username.php",
            method: "POST",
            data: { benutzername: username },
            success: function (response) {
                if (response === "taken") {
                    $("#username-check").text("Benutzername ist bereits vergeben.")
                        .removeClass("text-success")
                        .addClass("text-danger");
                    $("#benutzername").addClass("is-invalid").removeClass("is-valid");
                } else {
                    $("#username-check").text("Benutzername ist verfügbar.")
                        .removeClass("text-danger")
                        .addClass("text-success");
                    $("#benutzername").removeClass("is-invalid").addClass("is-valid");
                }
                
            }
        });
    } else {
        $("#username-check").text("");
        $("#benutzername").removeClass("is-valid is-invalid");
    }
});

// E-Mail Live-Prüfung
$("#email").on("keyup", function () {
    const email = $(this).val();
    const endings = [".at", ".de", ".com"];
    const validEnding = endings.some(ending => email.endsWith(ending));

    if (email.length > 5 && email.includes("@") && validEnding) {
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
    }
});

    
});
