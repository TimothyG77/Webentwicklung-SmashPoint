"use strict"; // Stict Mode in Javascript um die Verwendung nicht deklarierte Variablen zu verhindern.

$(document).ready(function () {
    // product-link KLasse in index.php für Bilder
    $(document).on("click", ".product-link", function (e) {
        e.preventDefault(); 
        const productId = $(this).data("id"); // Liest die ID des geklickten Bildes
        if (productId) {
            window.location.href = `product-detail.php?id=${productId}`;
        }
    });
});
