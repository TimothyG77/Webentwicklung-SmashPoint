$(document).ready(function () {
    //Passwort anzeigen/ausblenden
    $("#togglePassword").click(function () {
        const passwordField = $("#password");
        const type = passwordField.attr("type") === "password" ? "text" : "password";
        passwordField.attr("type", type);
        $(this).text(type === "password" ? "👁" : "🔒");
    });
});
