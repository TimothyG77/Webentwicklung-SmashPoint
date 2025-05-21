"use strict";

$(function () {
    const apiPath = "../../Backend/logic/checkout-form.php";
    // Der Warenkorb wird aus localStorage gelesen
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    // Ein Array mit nur den Produkt-IDs
    const cartIds = cart.map(p => p.id);
    let products = [];
    let originalTotal = 0;
    // Brauchen wir fürs Einlösen des Gutscheins
    let appliedVoucher = null;

    // Die Gesamtsumme wird aktualisert
    function updateTotalDisplay(total) {
        $("#checkoutTotal").text(total.toFixed(2).replace(".", ",") + " €");
    }

    // Wenn der AJAX Call erfolgreich war, wird der neue Gesamtbetrag mit Gutscheineinlösung berechnet
    // callback wird aufgerufen mit dem rabattierten Wert
    function calculateTotalWithDiscount(code, callback) {
        $.ajax({
            url: apiPath + "?validateVoucher=1",
            type: "POST",
            contentType: "application/json",
            dataType: "json",
            data: JSON.stringify({ code }),
            success: function (res) {
                if (res.valid && typeof res.value === "number") { 
                    const discounted = Math.max(originalTotal - (originalTotal * (res.value / 100)), 0);
                    callback(discounted, res.value);
                } else {
                    callback(originalTotal, 0);
                }
            },
            error: function () {
                callback(originalTotal, 0);
            }
        });
    }

    function loadProducts() {
        // Überprüfen ob überaupt Produkte im Warenkorb sind
        if (cart.length === 0) {
            $("#checkoutItems").html("<div class='alert alert-info'>Keine Produkte im Warenkorb.</div>");
            return;
        }

        $.ajax({
            type: "POST",
            url: apiPath + "?products",
            contentType: "application/json",
            dataType: "json",
            data: JSON.stringify({ cart: cartIds }),
            success: function (result) {
                products = result;
                let html = "";
                originalTotal = 0;

                // Zwischensumme sowie Gesamtsumme berechnen und anzeigen
                // Die Produkte werden ausgeprintet
                products.forEach(product => {
                    const item = cart.find(p => p.id === product.id);
                    const qty = item ? item.qty : 1;
                    const subtotal = qty * parseFloat(product.price);
                    originalTotal += subtotal;

                    html += `
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <img src="../../Backend/${product.product_picture}" class="card-img-top" alt="${product.product_name}">
                                <div class="card-body">
                                    <h5 class="card-title">${product.product_name}</h5>
                                    <p class="card-text">Menge: ${qty}</p>
                                    <p class="card-text">Einzelpreis: ${parseFloat(product.price).toFixed(2)} €</p>
                                    <p class="card-text fw-bold">Zwischensumme: ${subtotal.toFixed(2)} €</p>
                                </div>
                            </div>
                        </div>`;
                });

                $("#checkoutItems").html(html);
                updateTotalDisplay(originalTotal);
            },
            error: function () {
                $("#checkoutItems").html("<div class='alert alert-danger'>Fehler beim Laden der Produkte.</div>");
            }
        });
    }

    // Der Wert vom Gutschein wird aus dem Eingabefeld gelesen
    $("#applyVoucherBtn").on("click", function () {
        const code = $("#voucherCode").val().trim(); //Liest das Eingabefeld vom Gutschein
        if (!code) return;

        calculateTotalWithDiscount(code, function (discountedTotal, percentage) {
            if (percentage > 0) { // Wenn der Code gültig ist, dann wird der Rabatt angezeigt und gespeichert
                updateTotalDisplay(discountedTotal);
                appliedVoucher = code; 
                alert("Gutschein angewendet: -" + percentage + "%");
            } else { // Wenn der Code ungültig ist, wird eine Warnung gegeben und der Preis zurückgesetzt
                alert("Ungültiger Gutschein.");
                appliedVoucher = null;
                updateTotalDisplay(originalTotal);
            }
        });
    });

    // Hier wird der gesamte Warenkorb inklusive Gutschein an das Backend geschickt
    $("#placeOrderBtn").on("click", function () {
        $.ajax({
            type: "POST",
            url: apiPath + "?placeOrder",
            contentType: "application/json",
            dataType: "json",
            data: JSON.stringify({ cart, voucher: appliedVoucher }),
            success: function (response) {
                if (response.success) {
                    alert("Bestellung erfolgreich!");
                    // Wenn erfolgreich wird der localStorage gelöscht
                    localStorage.removeItem("cart");
                    // Und der Warenkorbzähler im header wird aktualisiert
                    updateCartCount();
                    setTimeout(() => window.location.href = "index.php", 300);
                } else {
                    alert("Fehler: " + response.message);
                }
            },
            error: function () {
                alert("Technischer Fehler beim Bestellen.");
            }
        });
    });

    loadProducts();
});
