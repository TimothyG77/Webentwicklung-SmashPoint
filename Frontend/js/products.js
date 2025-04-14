$(document).ready(function () {
    // Produkte laden nach Kategorie
    function loadProducts(category) {
        $.ajax({
            url: "../../Backend/logic/products-form.php",
            type: "GET",
            data: { category },
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
                                    <img src="../../Backend/${p.product_picture}" class="card-img-top" alt="${p.product_name}">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">${p.product_name}</h5>
                                        <p class="card-text">${p.product_description}</p>
                                        <p class="card-text"><strong>${p.price.toFixed(2)} €</strong></p>
                                        <div class="mt-auto">
                                            <button class="btn btn-success add-to-cart-btn mb-2" data-id="${p.id}">🛒 In den Warenkorb</button>
                                            ${isAdmin ? `
                                                <a href="product-edit.php?id=${p.id}" class="btn btn-sm btn-outline-primary">
                                                    ✏️ Bearbeiten
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
    

    // Produkte zum Warenkorb hinzufügen (Event Delegation)
    $(document).on("click", ".add-to-cart-btn", function () {
        const productId = Number($(this).data("id")); // Wichtig: sicherstellen, dass ID ein number ist!
        let cart = JSON.parse(localStorage.getItem("cart")) || [];

        const existing = cart.find(p => p.id === productId);
        if (existing) {
            existing.qty += 1;
        } else {
            cart.push({ id: productId, qty: 1 });
        }

        localStorage.setItem("cart", JSON.stringify(cart));
        updateCartCount();
    });

    // Warenkorb-Zähler aktualisieren
    function updateCartCount() {
        const cart = JSON.parse(localStorage.getItem("cart")) || [];
        const total = cart.reduce((sum, p) => sum + p.qty, 0);
        $("#cart-count").text(total);
    }
});
