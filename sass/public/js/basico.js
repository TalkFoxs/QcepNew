document.addEventListener("DOMContentLoaded", function () {
    const botonOcult = document.getElementById("botonIdioma");

    function ocultarEnseñar() {
        const listaIdioma = document.getElementById("listaIdioma");
        if (listaIdioma.classList.contains(`noneLista`)) {
            listaIdioma.classList.remove("noneLista");
        } else {
            listaIdioma.classList.add("noneLista");
        }
    }

    if (botonOcult) {
        botonOcult.addEventListener("click", ocultarEnseñar);
    }
});



/*Function para Mover los procesos */

$(function () {
    $("#procesos").sortable({
        revert: true
    });
    $("div").disableSelection();
});

/**
 * 
 * Guardar los ordenes en Servidor
 * 
 */
window.onload = function () {
    var sortable = new Sortable(document.getElementById('sortable-list'), {
        multiDrag: true,
        selectedClass: 'selected',
        fallbackTolerance: 3,
        animation: 150,
        onEnd: function (evt) {
            var orderData = sortable.toArray();
            saveSortableOrder(orderData);
        }
    });
};

/**
 * Después de modificar el orden se guardar el orden en el servidor 
 */
function saveSortableOrder(orderData) {
    $.ajax({
        url: "https://www.qceproba.com/detalles/save_order.php",
        method: "POST",
        data: { orderData: orderData },
        success: function (response) {
            console.log("Guardar orden OK");
            console.log(orderData);
        },
        error: function (xhr, status, error) {
            console.error("Guardar orden mal：" + error);
        }
    });
}
/**
 * Utlizar el orden que tenemos 
 * 
 */
/*
window.onload = function () {
    $.ajax({
        url: "https://www.qceproba.com/detalles/get_order.php",
        method: "GET",
        success: function (response) {
            var orderData = JSON.parse(response);
            applySortableOrder(orderData);
        },
        error: function (xhr, status, error) {
            console.error("Orden Mal：" + error);
        }
    });
};

function applySortableOrder(orderData) {
    var $sortableList = $("#sortable-list");
    $sortableList.empty();

    for (var i = 0; i < orderData.length; i++) {
        var itemId = orderData[i];
        var $item = $("<div>").attr("data-id", itemId).addClass("card").appendTo($sortableList);
        var $h2 = $("<h2>").appendTo($item);
        var $a = $("<a>").attr("href", "?doc/documents&proces=" + itemId).text(itemId).appendTo($h2);
    }
}



*/






