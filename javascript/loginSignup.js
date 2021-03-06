/**
 * @author Paolo Fagioli
 *
 * In questo file sono definiti i listener per la registrazione e il login
 */

$(document).ready(function () {

    // Listener del login form
    $("#login-form").submit(function (event) {
        event.preventDefault();

        var email = escapeInput($.trim($("#email-login").val().toLowerCase()));
        var password = escapeInput($("#password-login").val());
        var submit = $("#submit-login").val();


        var request = $.ajax({
            type: "POST",
            url: "php/ajax/authentication/login_ajax.php",
            data: {email: email, password: password, submit: submit},
            dataType: 'json'
        });


        request.done(function (response) {
            if(response.success === 1)
                window.location.replace("php/home.php");
            else
                $("#ajax-response").html(response.flash_message); // inserisce nel paragrafo html di signup la risposta del server
        });

        request.fail(function () {
            $("#ajax-response").html("We've got a problem with our servers! Try again later.");
        });

    });

    // Listener del registration form
    $("#registration-form").submit(function (event) {
        event.preventDefault();

        var name = escapeInput($.trim(capitalize($("#name").val())));
        var surname = escapeInput($.trim(capitalize($("#surname").val())));
        var email = escapeInput($.trim($("#email").val().toLowerCase()));
        var password = escapeInput($("#password").val());
        var submit = $("#submit").val();


        var request = $.ajax({
            type: "POST",
            url: "php/ajax/authentication/signup_ajax.php",
            data: {name: name, surname: surname, email: email, password: password, submit: submit},
            dataType: 'json'
        });


        request.done(function (response) {
            if(response.success === 1)
                window.location.replace("php/home.php");
            else
                $("#ajax-response").html(response.flash_message); // inserisce nel paragrafo html di signup la risposta del server
        });

        request.fail(function () {
            $("#ajax-response").html("We've got a problem with our servers! Try again later.");
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