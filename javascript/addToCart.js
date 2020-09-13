/**
 * @author Paolo Fagioli
 *
 * In questo file è definito l'event listener che si attiva
 * al click del bottone per aggiungere un articolo nel carrello
 *
 * la richiesta viene fatta alla pagina add_to_cart.php
 *
 * Funzione di
 * @callback: updateBadge
 */

$(document).on('click','.add-to-cart',function () {

        var book_id = this.id;

        var request = $.ajax({
            type: "POST",
            url: "../php/ajax/cart/add_to_cart.php",
            data: {add_to_cart: book_id},
            dataType: 'json'
        });

        request.done(function (response) {
            if(response.success === 1){
                var badgeNum = response.badge_num;
                updateBadge(badgeNum);
            }

            else
                alert(response.error);
        });

        request.fail(function () {
            alert("We've got a problem with our servers! Try again later.");
        });

});


/**
 * Aggiorna il badge della navbar
 */
function updateBadge(num) {
    $(".badge").html(num);
}
