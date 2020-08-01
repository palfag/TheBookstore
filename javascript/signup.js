
$(document).ready(function () {
    $("form").submit(function (event) {
        event.preventDefault();

        var name = $.trim(capitalize($("#name").val()));
        var surname = $.trim(capitalize($("#surname").val()));
        var email = $.trim($("#email").val().toLowerCase());
        var password = $("#password").val();
        var submit = $("#submit").val();


        var request = $.ajax({
            type: "POST",
            url: "../php/signup_ajax.php",
            data: {name: name, surname: surname, email: email, password: password, submit: submit},
            dataType: 'json'
        });


        request.done(function (response) {
            if(response.success === 1)
                window.location.replace("../php/home.php");
            else
                $("#ajax-response").html(response.flash_message); // inserisce nel paragrafo html di signup la risposta del server
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