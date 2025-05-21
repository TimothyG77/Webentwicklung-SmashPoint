"use strict";

$(function () {
    const apiPath = "../../Backend/logic/order-details-form.php";

    $.ajax({
        type: "GET",
        url: apiPath + "?order_id=" + ORDER_ID, // ORDER_ID von order-details.php
        dataType: "json",
        success: function (items) {
            if (!items.length) {
                $("#orderDetailsBody").html(`<tr><td colspan="4" class="text-muted">Keine Details gefunden.</td></tr>`);
                return;
            }
            
            // Für jedes Produkt wird eine Zeile erstellt 
            let html = "";
            items.forEach(item => {
                const total = item.quantity * item.price_each;
                html += `
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <img src="../../Backend/${item.product_picture}" alt="${item.product_name}" width="60" height="60" style="object-fit: cover; border-radius: 8px;">
                                <span>${item.product_name}</span>
                            </div>
                        </td>
                        <td>${item.quantity}</td>
                        <td>${parseFloat(item.price_each).toFixed(2).replace('.', ',')} €</td>
                        <td>${total.toFixed(2).replace('.', ',')} €</td>
                    </tr>`;
            });

            // Die generierten Zeilen von vorher, werden in die Tabelle eingefügt
            $("#orderDetailsBody").html(html);
        },
        error: function (xhr) {
            console.error("Fehler beim Laden der Details:", xhr.responseText);
            $("#orderDetailsBody").html(`<tr><td colspan="4" class="text-danger">Fehler beim Laden der Bestelldetails.</td></tr>`);
        }
    });
});
