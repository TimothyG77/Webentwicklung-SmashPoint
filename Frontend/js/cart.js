document.addEventListener("DOMContentLoaded", function () {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const cartIds = cart.map(p => p.id);
    const container = document.getElementById("cartItems");
    const totalElement = document.getElementById("cartTotal");

    if (cart.length === 0) {
        container.innerHTML = `<div class="alert alert-info">Keine Produkte gefunden.</div>`;
        totalElement.textContent = "0,00 €";
        return;
    }

    fetch("../../Backend/logic/cart-form.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ cart: cartIds })
    })
        .then(res => res.json())
        .then(products => {
            if (!products.length) {
                container.innerHTML = `<div class="alert alert-info">Keine Produkte gefunden.</div>`;
                totalElement.textContent = "0,00 €";
                return;
            }

            let total = 0;
            container.innerHTML = "";

            products.forEach(product => {
                const item = cart.find(c => c.id === product.id);
                const qty = item ? item.qty : 1;
                const subtotal = qty * parseFloat(product.price);
                total += subtotal;

                container.innerHTML += `
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="../../Backend/${product.product_picture}" class="card-img-top" alt="${product.product_name}">
                            <div class="card-body">
                                <h5 class="card-title">${product.product_name}</h5>
                                <p class="card-text">${product.product_description}</p>
                                <p class="card-text">Anzahl: ${qty}</p>
                                <p class="card-text fw-bold">${subtotal.toFixed(2)} €</p>
                                <button class="btn btn-sm btn-outline-danger remove-from-cart" data-id="${product.id}">🗑️ Entfernen</button>
                            </div>
                        </div>
                    </div>`;
            });

            totalElement.textContent = total.toFixed(2).replace(".", ",") + " €";
            updateCartCount();
        })
        .catch(err => {
            console.error("Warenkorb-Fehler:", err);
            container.innerHTML = `<div class="alert alert-danger">Fehler beim Laden des Warenkorbs.</div>`;
        });

    // Produkt entfernen
    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("remove-from-cart")) {
            const productId = parseInt(e.target.dataset.id);
            let cart = JSON.parse(localStorage.getItem("cart")) || [];
            cart = cart.filter(p => p.id !== productId);
            localStorage.setItem("cart", JSON.stringify(cart));
            location.reload(); // Seite neu laden
        }
    });

    function updateCartCount() {
        const cart = JSON.parse(localStorage.getItem("cart")) || [];
        const total = cart.reduce((sum, item) => sum + item.qty, 0);
        const badge = document.getElementById("cart-count");
        if (badge) badge.textContent = total;
    }
});
