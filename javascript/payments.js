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
                $("#ajax-response").addClass("success");
                $("#ajax-response").html(response.message);
            }

            else{
                $("#ajax-response").addClass("failure");
                $("#ajax-response").html(response.error);
            }

        });

        request.fail(function (response, textStatus, error) {
            $("#ajax-response").removeClass();
            $("#ajax-response").addClass("failure");
            $("#ajax-response").html("There was an error with our servers! Try again later.");
        });

    });



    $("#remove-card-btn").click(function () {

        var request = $.ajax({
            type: "POST",
            url: "../php/ajax/payment/remove_card.php",
            data: {remove_card: 1},
            dataType: 'json'
        });


        request.done(function (response) {
            $("#ajax-response").removeClass();
            if(response.success === 1){
                $("#ajax-response").addClass("success");
                $("#ajax-response").html(response.message);
                $("#card-holder").val('');
                $("#card-number").val('');
                $("#expiry-date").val('');
                $("#cvc").val('');
                $('#card-img').attr('src','../images/cards/default.png');
            }

            else{
                $("#ajax-response").addClass("failure");
                $("#ajax-response").html(response.error);
            }

        });

        request.fail(function (response, textStatus, error) {
            $("#ajax-response").removeClass();
            $("#ajax-response").addClass("failure");
            $("#ajax-response").html("There was an error with our servers! Try again later.");
        });
    });
});


/**
 * Returns a string with the first character capitalized
 * @param {string}  string The input string.
 * @return {string} the resulting string.
 */
function capitalize(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}


function escapeInput(input) {
    return String(input)
        .replace(/&/g, '&amp;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
}