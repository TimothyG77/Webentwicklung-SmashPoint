"use strict";

$(document).ready(function () {
    $(document).on("click", ".product-link", function (e) {
        e.preventDefault(); // Standard verhindern
        const productId = $(this).data("id");
        if (productId) {
            window.location.href = `product-detail.php?id=${productId}`;
        }
    });
});
