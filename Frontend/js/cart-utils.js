"use strict";

function addToCart(productId) {
    // Holt den Warenkorb aus dem localStorage
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    // Sucht im Warenkorb nach einem Produkt mit genau dieser productID
    const existing = cart.find(p => p.id === productId);
    if (existing) {
        existing.qty += 1; // Erhöht die Menge um 1, wenn das Produkt schon da ist.
    } else {
        cart.push({ id: productId, qty: 1 }); // Fügt ein neues Objekt zu, wenn das Produkt neu ist.
    }

    // Speichert den aktualisierten Warenkorb wieder zurück in den Browser
    localStorage.setItem("cart", JSON.stringify(cart));
    updateCartCount(); // Aktualisiert die rote Anzeige

    console.log(`Produkt ${productId} wurde hinzugefügt.`);

    if (window.isUserLoggedIn) {
        syncCartToDatabase(); // Methode weiter unten definiert mit AJAX
    }
}

function updateCartCount() {
    // Lese den Warenkorb aus dem Browser LocalStorage-oder ein leeres Array nehmen wenn nichts im Cart ist.
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    // Die Menge zählen mit qty
    const total = cart.reduce((sum, p) => sum + (p.qty || 0), 0);
    // Die Gesamtanzahl im roten Warenkorb anzeigen im Header.
    const badge = document.getElementById("cart-count");
    if (badge) badge.textContent = total;

    toggleCheckoutButton(); //zentrale Button-Steuerung
}

function toggleCheckoutButton() {
    const btn = document.getElementById("checkoutBtn");
    // Prüft ob der Warenkorb leer ist. Wenn ja, Button wird ausgeblendet, wenn nein Button wird angezeigt.
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    if (btn) {
        btn.style.display = cart.length > 0 ? "inline-block" : "none";
    }
}

function syncCartToDatabase() {
    // Holt Warenkorb aus localStorage
    const cart = JSON.parse(localStorage.getItem("cart")) || [];

    // Wenn Warenkorb leer, dann keine AJAX Abfrage nötig
    if (cart.length === 0) return;

    // Semdet eine HTTP-POST Anfrage an sync-cart.php
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
    // Sendet eine GET-Anfrage an load-cart.php
    fetch("../../Backend/logic/load-cart.php")
        .then(res => res.json())
        .then(items => {
            // Bedingung: Ist die Antwort ein Array mit einer Liste von Produkten? Wenn nicht ann Abbruch.
            if (!Array.isArray(items)) return;

            // Wandelt jedes Element aus der Datenbank in ein neues JS-Objekt um.
            const newCart = items.map(item => ({
                id: Number(item.id),
                qty: Number(item.qty)
            }));

            // Speichert den neuen Warenkorb in den Browser.
            localStorage.setItem("cart", JSON.stringify(newCart));
            updateCartCount();           // aktualisiert die Anzahl
            console.log("Warenkorb aus Datenbank geladen.");
        })
        .catch(err => console.error("Fehler beim Laden des DB-Warenkorbs:", err));
}
