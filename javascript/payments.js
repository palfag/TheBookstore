/**
 * @author Paolo Fagioli
 *
 * In questo file sono definiti i vari listener per la pagina dei pagamenti
 */

$(document).ready(function () {

    $("#type").change(function () {
            $('#card-img').attr('src','../images/cards/'+this.value+'.png');

    });


    // Listener for updating & adding card form
    $("form").submit(function (event) {
        event.preventDefault();

        var cardHolder = escapeInput($("#card-holder").val());
        var res = cardHolder.split(" ");
        var name = capitalize(res[0]);
        var surname = capitalize(res[1]);
        cardHolder = name + " " + surname;

        var cardNumber = escapeInput($("#card-number").val());
        var expiryDate = escapeInput($("#expiry-date").val());
        var cvc = escapeInput($("#cvc").val());
        var type = $("#type").val();


        var request = $.ajax({
            type: "POST",
            url: "../php/ajax/payment/add_card.php",
            data: {add_card: 1, card_holder: cardHolder, card_number: cardNumber, expiry_date: expiryDate, cvc: cvc, type: type},
            dataType: 'json'
        });


        request.done(function (response) {
            $("#ajax-response").removeClass();
            if(response.success === 1){
                if($("#submit").val() === "add card"){
                    $("#submit").val("Update card");
                }
                $("#ajax-response").addClass("success");

                if($("#remove-card-btn").length <= 0) // se vi è già il bottone (caso update card) non ne inseriamo un altro
                    var html = "<button id=\"remove-card-btn\">Remove card</button><br>" + response.message;

                else var html = response.message;

                $("#ajax-response").html(html);
            }

            else{
                $("#ajax-response").addClass("failure");
                $("#ajax-response").html(response.error);
            }

        });

        request.fail(function (response, textStatus, error) {
            $("#ajax-response").removeClass();
            $("#ajax-response").addClass("failure");
            $("#ajax-response").html("We've got a problem with our servers! Try again later.");
        });

    });


    /**
     * Listener per rimuovere la carta
     */
    $(document).on('click','#remove-card-btn',function () {
    //$("#remove-card-btn").click(function () {

        var request = $.ajax({
            type: "POST",
            url: "../php/ajax/payment/remove_card.php",
            data: {remove_card: 1},
            dataType: 'json'
        });


        request.done(function (response) {
            $("#ajax-response").removeClass();
            if(response.success === 1){

                if($("#submit").val() === "Update card"){
                    $("#submit").val("add card");
                    $("#remove-card-btn").remove();
                }

                $("#ajax-response").addClass("success");
                $("#ajax-response").html(response.message);
                $("#card-holder").val('');
                $("#card-number").val('');
                $("#expiry-date").val('');
                $("#cvc").val('');
                $('#card-img').attr('src','../images/cards/default.png');
                $("#type").val("default"); // risetta il campo select option con "Other"
            }

            else{
                $("#ajax-response").addClass("failure");
                $("#ajax-response").html(response.error);
            }

        });

        request.fail(function () {
            $("#ajax-response").removeClass();
            $("#ajax-response").addClass("failure");
            $("#ajax-response").html("We've got a problem with our servers! Try again later.");
        });
    });
});


/**
 * Ritorna una stringa con il primo carattere MAIUSC
 * @param {string}  la stringa di input
 * @return {string} Ritorna la stringa capitalizzata
 */
function capitalize(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

/**
 * Funzione di escaping per sanificare l'input
 * @param input stringa potenzialmente dannosa
 * @returns {string} ritorna la stringa sanificata
 */
function escapeInput(input) {
    return String(input)
        .replace(/&/g, '&amp;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
}