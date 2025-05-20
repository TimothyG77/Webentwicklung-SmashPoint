"use strict";

$(document).ready(function () {
    //API Pfad als Konstante definieren
    const apiPath = "../../Backend/logic/products-form.php";

    // Produkte filtern nach Kategorie
    function loadProducts(category) {
        $.ajax({
            url: apiPath + "?category=" + encodeURIComponent(category),
            type: "GET",
            dataType: "json",
            success: function (products) {
                let output = "";
                const isAdmin = $("#productList").data("isadmin") === true || $("#productList").data("isadmin") === "true";

                if (products.length === 0) {
                    output = "<p class='text-muted'>Keine Produkte gefunden.</p>";
                } else {
                    products.forEach(p => {
                        output += `
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <a href="product-detail.php?id=${p.id}" class="text-decoration-none">
                                        <img src="../../Backend/${p.product_picture}" class="card-img-top" alt="${p.product_name}">
                                    </a>
                                    <div class="card-body d-flex flex-column text-center">
                                        <h5 class="card-title">
                                            <a href="product-detail.php?id=${p.id}" class="text-decoration-none text-dark">
                                                ${p.product_name}
                                            </a>
                                        </h5>
                                        <p class="card-text"><strong>${p.price.toFixed(2)} €</strong></p>
                                        <div class="mt-auto">
                                            <button class="btn btn-success add-to-cart-btn mb-2" data-id="${p.id}">In den Warenkorb</button>
                                            ${isAdmin ? `
                                                <a href="product-edit.php?id=${p.id}" class="btn btn-sm btn-outline-primary">
                                                    Bearbeiten
                                                </a>` : ""}
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                    });
                    
                }

                $("#productList").html(output);
            },
            error: function () {
                $("#productList").html("<div class='alert alert-danger'>Fehler beim Laden der Produkte.</div>");
            }
        });
    }

    // Kategorie-Wechsel
    $("#categorySelect").on("change", function () {
        loadProducts($(this).val());
    });

    // Initiale Produktanzeige
    loadProducts($("#categorySelect").val());

    // Einheitliche Zentrale Warenkorb-Logik
    $(document).on("click", ".add-to-cart-btn", function () {
        const productId = Number($(this).data("id"));
        addToCart(productId);
    });
});
