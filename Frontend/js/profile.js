$(document).ready(function () {
    // Benutzername-Prüfung
    $("input[name='username']").on("input", function () {
        const username = $(this).val().trim();
        $(this).toggleClass("is-invalid", username.length < 4);
        $(this).toggleClass("is-valid", username.length >= 4);
    });

    // PLZ-Prüfung
    $("input[name='postal_code']").on("input", function () {
        const plz = $(this).val().trim();
        const valid = /^\d{4,5}$/.test(plz);
        $(this).toggleClass("is-invalid", !valid);
        $(this).toggleClass("is-valid", valid);
    });

    // E-Mail-Prüfung
    $("input[name='email']").on("input", function () {
        const email = $(this).val().trim();
        const endings = [".at", ".de", ".com", ".org", ".net", ".info", ".co", ".ch", ".eu", ".edu"];
        const providers = ["gmail", "yahoo", "hotmail", "outlook", "gmx", "protonmail"];
        const validFormat = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        const validEnding = endings.some(ending => email.endsWith(ending));
        const validProvider = providers.some(provider => email.toLowerCase().includes(provider));
        const isValid = validFormat && validEnding && validProvider;

        $(this).toggleClass("is-invalid", !isValid);
        $(this).toggleClass("is-valid", isValid);
    });

    // PUT-Request via fetch
    $("#profileForm").on("submit", function (e) {
        e.preventDefault();

        const data = {
            salutation: $("select[name='salutation']").val(),
            firstname: $("input[name='firstname']").val(),
            lastname: $("input[name='lastname']").val(),
            address: $("input[name='address']").val(),
            postal_code: $("input[name='postal_code']").val(),
            city: $("input[name='city']").val(),
            email: $("input[name='email']").val(),
            username: $("input[name='username']").val()
        };

        fetch("../../Backend/logic/update-profile.php", {
            method: "PUT",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(response => {
            if (response.success) {
                $("#update-success").text("Profil erfolgreich aktualisiert.").removeClass("d-none");
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
