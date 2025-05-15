"use strict";

$(function () {
    const apiPath = "../../Backend/logic/checkout-form.php";
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const cartIds = cart.map(p => p.id);
    let products = [];
    let originalTotal = 0;
    let appliedVoucher = null;

    function updateTotalDisplay(total) {
        $("#checkoutTotal").text(total.toFixed(2).replace(".", ",") + " €");
    }

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

    $("#applyVoucherBtn").on("click", function () {
        const code = $("#voucherCode").val().trim();
        if (!code) return;

        calculateTotalWithDiscount(code, function (discountedTotal, percentage) {
            if (percentage > 0) {
                updateTotalDisplay(discountedTotal);
                appliedVoucher = code;
                alert("Gutschein angewendet: -" + percentage + "%");
            } else {
                alert("Ungültiger Gutschein.");
                appliedVoucher = null;
                updateTotalDisplay(originalTotal);
            }
        });
    });

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
                    localStorage.removeItem("cart");
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
