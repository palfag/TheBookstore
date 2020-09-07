$(document).ready(function () {

    // Listener for login form
    $("#login-form").submit(function (event) {
        event.preventDefault();

        var email = escapeInput($.trim($("#email-login").val().toLowerCase()));
        var password = escapeInput($("#password-login").val());
        var submit = $("#submit-login").val();


        var request = $.ajax({
            type: "POST",
            url: "php/login_ajax.php",
            data: {email: email, password: password, submit: submit},
            dataType: 'json'
        });


        request.done(function (response) {
            if(response.success === 1)
                window.location.replace("php/home.php");
            else
                $("#ajax-response").html(response.flash_message); // inserisce nel paragrafo html di signup la risposta del server
        });

        request.fail(function (response, textStatus, error) {
            $("#ajax-response").html("There was an error with our servers! Try again later.");
        });

    });

    // Listener for registration form
    $("#registration-form").submit(function (event) {
        event.preventDefault();

        var name = escapeInput($.trim(capitalize($("#name").val())));
        var surname = escapeInput($.trim(capitalize($("#surname").val())));
        var email = escapeInput($.trim($("#email").val().toLowerCase()));
        var password = escapeInput($("#password").val());
        var submit = $("#submit").val();


        var request = $.ajax({
            type: "POST",
            url: "php/signup_ajax.php",
            data: {name: name, surname: surname, email: email, password: password, submit: submit},
            dataType: 'json'
        });


        request.done(function (response) {
            if(response.success === 1)
                window.location.replace("php/home.php");
            else
                $("#ajax-response").html(response.flash_message); // inserisce nel paragrafo html di signup la risposta del server
        });

        request.fail(function (response, textStatus, error) {
            $("#ajax-response").html("There was an error with our servers! Try again later.");
        });

    });
});


window.onload = showForm;

/**
 *  Show & hide forms with JQuery
 */
function showForm() {
    $("#login").click(function () {
        $("#registration-div").addClass("invisible");
        $("#login-div").removeClass("invisible");
        $("#ajax-response").html("");
    });

    $("#signup").click(function () {
        $("#login-div").addClass("invisible");
        $("#registration-div").removeClass("invisible");
        $("#ajax-response").html("");
    });
}


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