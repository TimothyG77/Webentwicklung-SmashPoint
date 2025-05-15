"use strict";

function updateCartCount() {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const total = cart.reduce((sum, item) => sum + (item.qty || 0), 0);
    const badge = document.getElementById("cart-count");
    if (badge) badge.textContent = total;

    toggleCheckoutButton(); 
}

function syncCartToDatabaseIfLoggedIn() {
    if (window.isUserLoggedIn) {
        const cart = JSON.parse(localStorage.getItem("cart")) || [];

        fetch("../../Backend/logic/sync-cart.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ cart: cart })
        })
        .then(res => res.json())
        .then(data => {
            if (!data.success) {
                console.warn("Sync-Fehler:", data.message);
            }
        })
        .catch(err => console.error("Netzwerkfehler beim Sync:", err));
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById("cartItems");
    const totalElement = document.getElementById("cartTotal");

    if (!container || !totalElement) {
        console.warn("Warenkorb-Elemente nicht gefunden – cart.js wird auf dieser Seite nicht gebraucht.");
        updateCartCount();
        return;
    }

    const apiPath = "../../Backend/logic/cart-form.php";
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    function renderCart(products) {
        let total = 0;
        container.innerHTML = "";

        products.forEach(product => {
            const cartItem = cart.find(c => c.id === product.id);
            const qty = cartItem && Number(cartItem.qty) > 0 ? Number(cartItem.qty) : 1;
            const subtotal = qty * parseFloat(product.price || 0);
            total += subtotal;

            container.innerHTML += `
                <div class="col-md-4 mb-4" data-id="${product.id}">
                    <div class="card">
                        <a href="product-detail.php?id=${product.id}" class="text-decoration-none">
                            <img src="../../Backend/${product.product_picture}" class="card-img-top" alt="${product.product_name}">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">${product.product_name}</h5>
                            <div class="d-flex align-items-center mb-2">
                                <button class="btn btn-outline-secondary btn-sm quantity-decrease" data-id="${product.id}">−</button>
                                <span class="fw-bold mx-2 quantity-value">${qty}</span>
                                <button class="btn btn-outline-secondary btn-sm quantity-increase" data-id="${product.id}">+</button>
                            </div>
                            <p class="card-text fw-bold subtotal">${subtotal.toFixed(2)} €</p>
                            <button class="btn btn-sm btn-outline-danger remove-from-cart" data-id="${product.id}">Entfernen</button>
                        </div>
                    </div>
                </div>`;
        });

        totalElement.textContent = total.toFixed(2).replace(".", ",") + " €";
        updateCartCount(); // zentral
    }

    function loadCartDisplay() {
        cart = JSON.parse(localStorage.getItem("cart")) || [];

        if (cart.length === 0) {
            container.innerHTML = '<div class="alert alert-info">Keine Produkte gefunden.</div>';
            totalElement.textContent = "0,00 €";
            updateCartCount();
            return;
        }

        fetch(apiPath, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ cart: cart })
        })
        .then(res => res.json())
        .then(products => {
            const existingIds = products.map(p => p.id);
            const originalLength = cart.length;

            cart = cart.filter(item => existingIds.includes(item.id));
            if (cart.length !== originalLength) {
                localStorage.setItem("cart", JSON.stringify(cart));
                updateCartCount();
            }

            renderCart(products);
        })
        .catch(() => {
            container.innerHTML = '<div class="alert alert-danger">Fehler beim Laden des Warenkorbs.</div>';
        });
    }

    loadCartDisplay();

    container.addEventListener("click", function (e) {
        const id = parseInt(e.target.dataset.id);
        if (!id) return;

        let item = cart.find(p => p.id === id);

        if (e.target.classList.contains("quantity-increase")) {
            if (item) item.qty += 1;
        }

        if (e.target.classList.contains("quantity-decrease")) {
            if (item && item.qty > 1) item.qty -= 1;
        }

        if (e.target.classList.contains("remove-from-cart")) {
            cart = cart.filter(p => p.id !== id);
        }

        localStorage.setItem("cart", JSON.stringify(cart));
        loadCartDisplay();
        syncCartToDatabaseIfLoggedIn();
    });
});
