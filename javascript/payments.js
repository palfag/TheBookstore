$(document).ready(function () {

    $("#type").change(function () {
            $('#card-img').attr('src','../images/cards/'+this.value+'.png');

    });


    // Listener for updating card form
    $("form").submit(function (event) {
        event.preventDefault();

        var cardHolder = $("#card-holder").val();
        var res = cardHolder.split(" ");
        var name = capitalize(res[0]);
        var surname = capitalize(res[1]);
        cardHolder = name + " " + surname;

        var cardNumber = $("#card-number").val();
        var expiryDate = $("#expiry-date").val();
        var cvc = $("#cvc").val();
        var type = $("#type").val();


        var request = $.ajax({
            type: "POST",
            url: "../php/add_card.php",
            data: {add_card: 1, card_holder: cardHolder, card_number: cardNumber, expiry_date: expiryDate, cvc: cvc, type: type},
            dataType: 'json'
        });


        request.done(function (response) {
            if(response.success === 1){
                $("#ajax-response").html(response.message);
                $("#ajax-response").addClass("success");
            }

            else{
                $("#ajax-response").html(response.error);
                $("#ajax-response").addClass("failure");
            }

        });

        request.fail(function (response, textStatus, error) {
            alert(response + textStatus + error);
        });

    });



    $("#remove-card-btn").click(function () {

        var request = $.ajax({
            type: "POST",
            url: "../php/remove_card.php",
            data: {remove_card: 1},
            dataType: 'json'
        });


        request.done(function (response) {
            if(response.success === 1){
                $("#ajax-response").html(response.message);
                $("#ajax-response").addClass("success");
                $("#card-holder").val('');
                $("#card-number").val('');
                $("#expiry-date").val('');
                $("#cvc").val('');
                $('#card-img').attr('src','../images/cards/default.png');
            }

            else{
                $("#ajax-response").html(response.error);
                $("#ajax-response").addClass("failure");
            }

        });

        request.fail(function (response, textStatus, error) {
            alert(response + textStatus + error);
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