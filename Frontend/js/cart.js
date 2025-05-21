"use strict";

function updateCartCount() {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const total = cart.reduce((sum, item) => sum + (item.qty || 0), 0);
    const badge = document.getElementById("cart-count"); // Die id wird geholt vom header.php
    if (badge) badge.textContent = total;

    toggleCheckoutButton(); // Prüft ob Warenkorb leer ist, damit Button versteckt wird
}

function syncCartToDatabaseIfLoggedIn() { // Unterschied zu syncCartToDatabase in cart.js ist, dass es hier eine zusätzliche Login Prüfung gibt.
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
        updateCartCount(); // FAlls cart.js auf einer anderen Seite geladen wird, bricht der Code hier ab.
        return;
    }

    const apiPath = "../../Backend/logic/cart-form.php";
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    function renderCart(products) { // Zeigt alle Artikel im Warenkorb visuelle im HTML an
        let total = 0; //Variable products kommt von cart-from.php
        container.innerHTML = "";

        products.forEach(product => {
            const cartItem = cart.find(c => c.id === product.id);
            //Wenn quantity > 0, dann verwende qty aus Datenbank, wenn false weil leer oder ungültig, verwende 1 als Fallback
            const qty = cartItem && Number(cartItem.qty) > 0 ? Number(cartItem.qty) : 1;
            // Zwischensumme berechnen
            const subtotal = qty * parseFloat(product.price || 0);
            total += subtotal; //Gesamtpreis wird hier berechnet

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

        // Zeigt den Gesamtpreis
        totalElement.textContent = total.toFixed(2).replace(".", ",") + " €";
        updateCartCount(); // Zähler aktualisieren
    }

    function loadCartDisplay() {
        cart = JSON.parse(localStorage.getItem("cart")) || [];

        // Nach Bestellung wird der Warenkorbzähler auf 0 gesetzt und diese Bedingung trifft zu
        if (cart.length === 0) {
            container.innerHTML = '<div class="alert alert-info">Keine Produkte gefunden.</div>';
            totalElement.textContent = "0,00 €";
            updateCartCount();
            return;
        }

        fetch(apiPath, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ cart: cart }) // Sendet den aktuellen Warenkorb mit id und qty als JSON an das Backend
        })
        .then(res => res.json())
        .then(products => { //Hier werden veraltete Produkte aus dem localStorage entfernt, beispielsweise
        //wenn ein Produkt aus der DB gelöscht wurde, aber im localStorage es immernoch gespeichert ist, muss es entfernt werden
            const existingIds = products.map(p => p.id); // DB
            const originalLength = cart.length; // LocalStorage

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

    // Im Warenkorb die Menge (qty) erhöhen
    // Wenn irgendein Element im cartItems Container geklickt wird, wird der Code darunter ausgelöst
    container.addEventListener("click", function (e) {
        const id = parseInt(e.target.dataset.id); // ID lesen vom geklickten Element
        if (!id) return; // Wenn keine gültige ID, dann abbrechen

        let item = cart.find(p => p.id === id); // Passende Artikel im localStorage finden

        if (e.target.classList.contains("quantity-increase")) {
            if (item) item.qty += 1; //Buttons oben im innerHTML
        }

        if (e.target.classList.contains("quantity-decrease")) {
            if (item && item.qty > 1) item.qty -= 1;
        }

        if (e.target.classList.contains("remove-from-cart")) {
            cart = cart.filter(p => p.id !== id);
        }

        localStorage.setItem("cart", JSON.stringify(cart)); // Speichert den aktualisierten Warenkorb im LocalStorage (Browser)
        loadCartDisplay();
        syncCartToDatabaseIfLoggedIn();
    });
});
