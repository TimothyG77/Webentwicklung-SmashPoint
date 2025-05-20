"use strict";

$(document).ready(function () {
    const apiPath = "../../Backend/logic/product-detail-form.php";
    const container = $("#productDetailContainer");

    const urlParams = new URLSearchParams(window.location.search); // Liest aus de URL die ID
    const productId = urlParams.get('id');

    if (!productId) {
        container.html("<div class='alert alert-danger'>Produkt nicht gefunden.</div>");
        return;
    }

    $.ajax({
        type: "GET",
        url: apiPath + "?id=" + encodeURIComponent(productId),
        dataType: "json",
        success: function (product) {
            if (!product) {
                container.html("<div class='alert alert-danger'>Produkt nicht gefunden.</div>");
                return;
            }

            // Hier werden dann die Produktdetails ausgeprintet nach einem erfolgreichen AJAX Call.
            container.html(`
                <div class="row">
                    <div class="col-md-6">
                        <img src="../../Backend/${product.product_picture}" class="img-fluid" alt="${product.product_name}">
                    </div>
                    <div class="col-md-6">
                        <h1>${product.product_name}</h1>
                        <p class="lead">${product.product_description.replace(/\n/g, "<br>")}</p>
                        <h2>${parseFloat(product.price).toFixed(2)} €</h2>
                        <button class="btn btn-success mt-3 add-to-cart-btn" id="addToCartBtn" data-id="${product.id}">In den Warenkorb</button>
                    </div>
                </div>
            `);

            //Event sofort binden auf den frisch eingefügten Button
            $("#addToCartBtn").off("click").on("click", function () {
                const id = Number($(this).data("id"));
                console.log("Button geklickt, ID:", id); // TEST LOG
                if (id) {
                    addToCart(id); // zentrale Cart-Funktion
                }
            });
        },
        error: function () {
            container.html("<div class='alert alert-danger'>Fehler beim Laden der Produktdetails.</div>");
        }
    });
});
