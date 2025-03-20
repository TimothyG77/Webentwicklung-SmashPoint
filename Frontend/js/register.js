$(document).ready(function() {
    // Passwort-Anzeige umschalten
    $("#togglePassword").click(function() {
        let passwordField = $("#password");
        passwordField.attr("type", passwordField.attr("type") === "password" ? "text" : "password");
    });

    // PLZ Validierung (4-stellig)
    $("#plz").on("input", function() {
        let plzValue = $(this).val();
        if (!/^\d{5}$/.test(plzValue)) {
            $(this).addClass("is-invalid");
        } else {
            $(this).removeClass("is-invalid");
        }
    });

    // Benutzername Live-Prüfung mit AJAX
    $("#benutzername").on("keyup", function() {
        let username = $(this).val();
        if (username.length > 3) {
            $.ajax({
                url: "check_username.php",
                method: "POST",
                data: { benutzername: username },
                success: function(response) {
                    if (response === "taken") {
                        $("#username-check").text("Benutzername bereits vergeben!");
                    } else {
                        $("#username-check").text("");
                    }
                }
            });
        }
    });

    // Formular-Validierung mit Bootstrap + jQuery
    $("#registerForm").on("submit", function(event) {
        if (!this.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        $(this).addClass("was-validated");
    });
});