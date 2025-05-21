"use strict";

$(function () {
    const apiPath = "../../Backend/logic/order-history-form.php";
    const detailPath = "../../Backend/logic/order-details-form.php";
    const tbody = $("#orderHistoryBody"); // Ist die ID von order-history.php

    // Alle Bestellungen laden
    $.ajax({
        type: "GET",
        url: apiPath,
        dataType: "json",
        success: function (orders) {
            if (orders.length === 0) {
                tbody.html(`<tr><td colspan="6" class="text-muted">Keine Bestellungen gefunden.</td></tr>`);
                return;
            }

            let html = "";
            // Button Rechnung bei "Meine Bestellübersicht" führt zu invoice-view.php
            orders.forEach(order => {
                html += `
                    <tr class="order-row" data-id="${order.order_id}" style="cursor:pointer">
                        <td><a href="order-details.php?order_id=${order.order_id}">#${order.order_id}</a></td>
                        <td>${order.order_date}</td>
                        <td>${parseFloat(order.total_price).toFixed(2).replace('.', ',')} €</td>
                        <td>${order.status}</td>
                        <td>${order.shipping_adress}</td>
                        <td>
                            <a href="invoice-view.php?order_id=${order.order_id}" target="_blank" class="btn btn-sm btn-outline-primary">
                                Rechnung
                            </a>
                        </td>
                    </tr>`;
            });

            tbody.html(html);
        },
        error: function (xhr) {
            console.error("Fehler beim Laden:", xhr.responseText);
            tbody.html(`<tr><td colspan="6" class="text-danger">Fehler beim Laden.</td></tr>`);
        }
    });

    // Man kann durch das auf jede Bestellung klicken
    $(document).on("click", ".order-row", function (e) {
        if ($(e.target).closest("a").is("[href*='invoice']")) return;

        // Führt zu order-details.php
        // Wichtig!!! Hier wird die orderID in die URL gegeben, was wir brauchen für order.details.js
        const orderId = $(this).data("id");
        window.location.href = "order-details.php?order_id=" + orderId;
    });
});
