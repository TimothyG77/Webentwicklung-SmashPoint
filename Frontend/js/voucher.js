"use strict";

$(function () {
    const apiPath = "../../Backend/logic/voucher-form.php";
    const table = $("#voucherTable");
    const button = $("#generateVoucherBtn");

    function loadVouchers() {
        $.ajax({
            url: apiPath,
            method: "GET",
            dataType: "json",
            success: function (data) {
                if (!Array.isArray(data)) {
                    table.html(`<tr><td colspan="5" class="text-danger">Ungültige Antwort vom Server.</td></tr>`);
                    return;
                }

                if (data.length === 0) {
                    table.html(`<tr><td colspan="5" class="text-muted">Noch keine Gutscheine vorhanden.</td></tr>`);
                    return;
                }

                let rows = "";
                data.forEach(v => {
                    const statusBadge = v.used == 1
                        ? `<span class="badge bg-secondary">Eingelöst</span>`
                        : `<span class="badge bg-success">Aktiv</span>`;

                    rows += `
                        <tr>
                            <td>${v.code}</td>
                            <td>${parseFloat(v.value).toFixed(2)} %</td>
                            <td>${v.created_at}</td>
                            <td>${v.expires_at}</td>
                            <td>${statusBadge}</td>
                        </tr>`;
                });

                table.html(rows);
            },
            error: function () {
                table.html(`<tr><td colspan="5" class="text-danger">Fehler beim Laden der Gutscheine.</td></tr>`);
            }
        });
    }

    // Gutschein generieren
    button.on("click", function () {
        $.ajax({
            url: apiPath,
            method: "POST",
            contentType: "application/json",
            dataType: "json",
            data: JSON.stringify({ generate: true }),
            success: function (res) {
                if (res.success) {
                    loadVouchers();
                } else {
                    alert("Fehler: " + res.message);
                }
            },
            error: function () {
                alert("Technischer Fehler beim Erstellen des Gutscheins.");
            }
        });
    });

    loadVouchers();
});
