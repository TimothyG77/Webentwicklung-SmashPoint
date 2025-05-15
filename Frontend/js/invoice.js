"use strict";

$(function () {
    const apiPath = "../../Backend/logic/invoice-form.php";

    $.ajax({
        type: "GET",
        url: `${apiPath}?order_id=${ORDER_ID}`,
        dataType: "json",
        success: function (data) {
            if (!data.success) {
                $("#invoiceContent").html(`<div class="alert alert-danger">${data.message}</div>`);
                return;
            }

            const o = data.order;
            const items = data.items;

            let html = `
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2>Rechnung</h2>
                    <img src="../res/img/SmashPointLogo.png" alt="Logo" style="height: 60px;">
                </div>
                <p><strong>Rechnungsnummer:</strong> ${o.invoice_number}</p>
                <p><strong>Datum:</strong> ${o.order_date}</p>
                <p><strong>Kunde:</strong><br>
                   ${o.firstname} ${o.lastname}<br>
                   ${o.address}<br>
                   ${o.postal_code} ${o.city}<br>
                   ${o.email}
                </p>

                <table class="table table-bordered mt-4">
                    <thead class="table-light">
                        <tr>
                            <th>Produkt</th>
                            <th>Menge</th>
                            <th>Einzelpreis</th>
                            <th>Gesamt</th>
                        </tr>
                    </thead>
                    <tbody>`;

            let subtotal = 0;
            items.forEach(item => {
                const price = parseFloat(item.price_each);
                const line = item.quantity * price;
                subtotal += line;
                html += `
                    <tr>
                        <td>${item.product_name}</td>
                        <td>${item.quantity}</td>
                        <td>${price.toFixed(2).replace(".", ",")} €</td>
                        <td>${line.toFixed(2).replace(".", ",")} €</td>
                    </tr>`;
            });

            html += `</tbody></table>`;

            if (o.voucher_percent) {
                const discount = subtotal * (parseFloat(o.voucher_percent) / 100);
                const total = subtotal - discount;

                html += `
                    <p><strong>Gutscheineinlösung:</strong> -${parseFloat(o.voucher_percent).toFixed(0)}%</p>
                    <p><strong>Reduzierter Preis:</strong> ${(total).toFixed(2).replace(".", ",")} €</p>`;
            } else {
                html += `<p><strong>Gesamtsumme:</strong> ${subtotal.toFixed(2).replace(".", ",")} €</p>`;
            }

            html += `
                <div class="signature mt-5">
                    <p>___________________________</p>
                    <p class="text-muted">Unterschrift</p>
                </div>`;

            $("#invoiceContent").html(html);
        },
        error: function () {
            $("#invoiceContent").html(`<div class="alert alert-danger">Fehler beim Laden der Rechnung.</div>`);
        }
    });
});
