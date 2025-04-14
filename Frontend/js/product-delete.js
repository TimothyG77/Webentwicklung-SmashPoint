$(document).ready(function () {
    $(".delete-product").click(function () {
        const card = $(this).closest("[data-id]");
        const productId = card.data("id");

        if (confirm("Willst du dieses Produkt wirklich löschen?")) {
            $.ajax({
                url: "../../Backend/logic/product-delete-form.php",
                method: "DELETE",
                contentType: "application/json",
                data: JSON.stringify({ id: productId }),
                success: function (response) {
                    if (response.success) {
                        card.remove();
                    } else {
                        alert("Fehler: " + response.message);
                    }
                },
                error: function () {
                    alert("Technischer Fehler beim Löschen.");
                }
            });
        }
    });
});
