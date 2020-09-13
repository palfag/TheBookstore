/**
 * @author Paolo Fagioli
 *
 * In questo file sono definiti gli event listener per la pagina cart.php
 * che si attivano al click dei vari bottoni.
 * Ogni event listener definisce cosa fare al verificarsi di un certo evento
 *
 */


/**
 * Event listener per rimuovere un articolo dal carrello
 */
$(document).on('click','.remove-button',function () {

    // <tr id="<?= $item['book_id'] ?>" class="book"> per arrivare a prendere le informazioni (book_id)
    // l'elemento che contiene tutta la riga
    var parent = this.parentNode.parentNode.parentNode;

    var request = $.ajax({
        type: "POST",
        url: "../php/ajax/cart/remove_from_cart.php",
        data: {remove_from_cart: parent.id},
        dataType: 'json'
    });

    request.done(function (response) {
        if(response.success === 1){
            parent.remove();
            if($("#ajax-error").html())
                $("#ajax-error").html('');

            updateBadge(response.badge_num);
            updateTotal(response.total);

            if(parseInt(badgeNum) === 0){
                $("#cart").addClass("hidden");
                warningCartEmpty();
            }
        }

        else
            $("#ajax-error").html(response.error);
    });

    request.fail(function (response, textStatus, error) {
       $("#ajax-error").html("We've got an error with our servers! Try again later.");
    });


});



/**
 * Event listener per svuotare il carrello
 */
$(document).on('click','.remove-all-button',function () {

    var removeAllFromCart = 0;
    var tbody = document.querySelector('tbody');

    var request = $.ajax({
        type: "POST",
        url: "../php/ajax/cart/remove_all_from_cart.php",
        data: {remove_all_from_cart: removeAllFromCart},
        dataType: 'json'
    });

    request.done(function (response) {
        if(response.success === 1){

            while (tbody.firstChild) {
                // This will remove all children within tbody which my your case are <tr> elements
                tbody.removeChild(tbody.firstChild);
            }

            if($("#ajax-error").html())
                $("#ajax-error").html('');


            updateBadge(response.badge_num);
            updateTotal(response.total);


            $("#cart").addClass("hidden"); // meglio remove ??
            warningCartEmpty();
        }

        else
            $("#ajax-error").html(response.error);
    });

    request.fail(function (response, textStatus, error) {
        $("#ajax-error").html("We've got an error with our servers! Try again later.");
    });

});


/**
 * Event listener per diminuire di 1 la quantità di un articolo nel carrello
 * Se la quantità corrente è 1 l'articolo verrà eliminato dal carrello (la nuova quantità risulterebbe 0)
 */
$(document).on('click','.minus-button',function () {

    var parent = this.parentNode; // <p>
    var children = parent.children; // array di children
    var quantityDOMElem = children[1]// puntatore al DOM elem della quantity  <span class="quantity"><?= $item['quantity']?></span>
    var quantity = quantityDOMElem.textContent; //<?= $item['quantity']?>
    var row = parent.parentNode.parentNode; // <p>.<td>.<tr> tr possiede le informazioni (id del libro)

    if(parseInt(quantity) === 1){
        var request = $.ajax({
            type: "POST",
            url: "../php/ajax/cart/remove_from_cart.php",
            data: {remove_from_cart: row.id},
            dataType: 'json'
        });

        request.done(function (response) {
            if(response.success === 1){
                row.remove();

                if($("#ajax-error").html())
                    $("#ajax-error").html('');

                updateBadge(response.badge_num);
                updateTotal(response.total);

                if(parseInt(badgeNum) === 0){
                    $("#cart").addClass("hidden");
                    warningCartEmpty();
                }
            }

            else
                $("#ajax-error").html(response.error);
        });

        request.fail(function (response, textStatus, error) {
            $("#ajax-error").html("We've got an error with our servers! Try again later.");
        });
    }

    else{ // quantity > 1

        var subtotalDOMElem = row.children[3].children[0] //<tr>. <td class="subtotal-column">.<p><?= $item['subtotal']?>


        var request = $.ajax({
            type: "POST",
            url: "../php/ajax/cart/reduce_cart_quantity.php",
            data: {reduce_cart_quantity: row.id},
            dataType: 'json'
        });

        request.done(function (response) {
            if(response.success === 1){

                if($("#ajax-error").html())
                    $("#ajax-error").html('');


                subtotalDOMElem.innerText = response.subtotal;
                quantityDOMElem.innerText = parseInt(quantity) - 1;
                updateBadge(response.badge_num);
                updateTotal(response.total);
            }

            else
                $("#ajax-error").html(response.error);
        });

        request.fail(function (response, textStatus, error) {
            $("#ajax-error").html("We've got an error with our servers! Try again later.");
        });
    }
});

/**
 * Event listener per incrementare di 1 la quantità di un articolo nel carrello
 */
$(document).on('click','.plus-button',function () {

    var parent = this.parentNode; //<p>
    var children = parent.children; // array di children di p


    var quantityDOMElem = children[1] // puntatore al DOM elem della quantity
    var quantity = quantityDOMElem.textContent;
    var row = parent.parentNode.parentNode; // <p>.<td>.<tr> tr possiede le informazioni (id del libro)


    var subtotalDOMElem = row.children[3].children[0] //<tr>. <td class="subtotal-column">.<p><?= $item['subtotal']?>


    var request = $.ajax({
        type: "POST",
        url: "../php/ajax/cart/add_cart_quantity.php",
        data: {add_cart_quantity: row.id},
        dataType: 'json'
    });


    request.done(function (response) {
        if(response.success === 1){

            if($("#ajax-error").html())
                $("#ajax-error").html('');


            subtotalDOMElem.innerText = response.subtotal;
            quantityDOMElem.innerText = parseInt(quantity) + 1;
            updateBadge(response.badge_num);
            updateTotal(response.total);
        }

        else
            $("#ajax-error").html(response.error);
    });

    request.fail(function (response, textStatus, error) {
        $("#ajax-error").html("We've got an error with our servers! Try again later.");
    });

});

$(document).on('click','#checkout-button',function () { // bottone pay now

    var request = $.ajax({
        type: "POST",
        url: "../php/ajax/payment/check_card.php",
        data: {check_card: 1},
        dataType: 'json'
    });


    request.done(function (response) {
        if(response.success === 1){

            if($("#ajax-error").html())
                $("#ajax-error").html('');

            pay();
        }
        else{
            var html = "<button id='add-card-btn'><a href='../php/payment.php'>first add a card</a></button>"
            $("#ajax-response").html(html);
            $("#ajax-response").addClass("failure");
        }
    });

    request.fail(function (response, textStatus, error) {
        $("#ajax-error").html("We've got an error with our servers! Try again later.");
    });
});


/**
 * Aggiorna il badge della navbar
 */
function updateBadge(num) {
    $(".badge").html(num);
}

/**
 * Aggiorna il valore totale del carrello
 */
function updateTotal(val){
    $("#total").html(val);
}

function warningCartEmpty(){
    var html =  "<h1>Cart is empty</h1>" +
                "<h2>Looks like you have no items in your shopping cart</h2>" +
                "<a href=\"home.php\">Continue Shopping</a>";
    $("#warning").append(html);
}

function thanksForYourPurchase(){
    var html =  "<h1>Thanks for your shopping!</h1>" +
        "<h2>We are looking forward to hear from you soon</h2>" +
        "<a href=\"home.php\">Continue Shopping</a>";
    $("#warning").append(html);
}

/**
 * Funzione che invia una richiesta AJAX per processare il pagamento
 */
function pay(){
    // tutto questo viene fatto se l'account possiede una carta collegata
    var tbody = document.getElementById("books");
    var books = $(tbody).find("tr");
    var hashmap = {};

    for(var i = 0; i < books.length; i++){
        var id = books[i].id;
        // book[i]. quantity column - p - quantity - valore di quantity
        var quantity = books[i].children[2].children[0].children[1].textContent;

        hashmap[id] = quantity;
    }

    // 1. aggiungere gli acquisti nel db
    // 2. far uscire la pagina thank you for your purchase!


    var request = $.ajax({
        type: "POST",
        url: "../php/ajax/purchase/add_purchase.php",
        data: {add_purchase: hashmap},
        dataType: 'json'
    });


    request.done(function (response) {
        if(response.success === 1){

            if($("#ajax-error").html())
                $("#ajax-error").html('');

            updateBadge(response.badge_num);
            $("#cart").addClass("hidden");

            thanksForYourPurchase();
        }

        else
            $("#ajax-error").html(response.error);
    });

    request.fail(function (response, textStatus, error) {
        $("#ajax-error").html("We've got an error with our servers! Try again later.");
    });
}