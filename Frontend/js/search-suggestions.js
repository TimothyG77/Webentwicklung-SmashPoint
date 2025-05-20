"use strict";

$(function () {
    const input = $("#productSearch");
    const resultList = $("#searchResults");

    //API-Path definieren
    const apiPath = "../../Backend/logic/search-products.php";

    input.on("keyup", function () {
        const query = input.val().trim();

        if (query.length < 1) {
            resultList.addClass("d-none").empty();
            return;
        }

        //AJAX-Request mit dynamischem URL-Query
        $.ajax({
            type: "GET",
            url: apiPath + "?term=" + encodeURIComponent(query),
            dataType: "json",
            success: function (data) {
                resultList.empty();  //Die alte Liste wird gelöscht, neue Ergebnisse kommen rein

                if (data.length === 0) {
                    resultList.append(`<li class="list-group-item text-muted">Keine Ergebnisse</li>`);
                } else {
                    data.forEach(product => { //Von der Datenbank werden die matched Produkte als Liste angezeigt.
                        resultList.append(`
                            <li class="list-group-item">
                                <a href="product-detail.php?id=${product.ID}" class="text-decoration-none text-dark">
                                    ${product.product_name} 
                                </a>
                            </li>
                        `);
                    });
                }

                resultList.removeClass("d-none");
            },
            error: function (xhr) {
                console.error("Suchfehler:", xhr.responseText);
            }
        });
    });

    // Klick außerhalb entfernt Liste unter Suchleiste
    $(document).on("click", function (e) {
        if (!$(e.target).closest("#productSearch, #searchResults").length) {
            resultList.addClass("d-none");
        }
    });
});
