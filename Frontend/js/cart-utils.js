"use strict";

function addToCart(productId) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    const existing = cart.find(p => p.id === productId);
    if (existing) {
        existing.qty += 1;
    } else {
        cart.push({ id: productId, qty: 1 });
    }

    localStorage.setItem("cart", JSON.stringify(cart));
    updateCartCount();

    console.log(`Produkt ${productId} wurde hinzugefügt.`);

    if (window.isUserLoggedIn) {
        syncCartToDatabase();
    }
}

function updateCartCount() {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const total = cart.reduce((sum, p) => sum + (p.qty || 0), 0);
    const badge = document.getElementById("cart-count");
    if (badge) badge.textContent = total;

    toggleCheckoutButton(); //zentrale Button-Steuerung
}

function toggleCheckoutButton() {
    const btn = document.getElementById("checkoutBtn");
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    if (btn) {
        btn.style.display = cart.length > 0 ? "inline-block" : "none";
    }
}

function syncCartToDatabase() {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];

    if (cart.length === 0) return;

    fetch("../../Backend/logic/sync-cart.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ cart: cart })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            console.log("Warenkorb mit DB synchronisiert.");
        } else {
            console.warn("Sync-Fehler:", data.message);
        }
    })
    .catch(err => console.error("Netzwerkfehler beim Sync:", err));
}

function loadCartFromDatabase() {
    fetch("../../Backend/logic/load-cart.php")
        .then(res => res.json())
        .then(items => {
            if (!Array.isArray(items)) return;

            const newCart = items.map(item => ({
                id: Number(item.id),
                qty: Number(item.qty)
            }));

            localStorage.setItem("cart", JSON.stringify(newCart));
            updateCartCount();           // aktualisiert Count + Button
            console.log("Warenkorb aus Datenbank geladen.");
        })
        .catch(err => console.error("Fehler beim Laden des DB-Warenkorbs:", err));
}
