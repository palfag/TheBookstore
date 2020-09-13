/**
 * @author Paolo Fagioli
 *
 * In questo file sono definiti i listener delle impostazioni
 */

$(document).ready(function () {

    // Listener per l'aggiunta della foto profilo
    $("#photo-form").submit(function (event) {
        event.preventDefault();

        var fd = new FormData();
        var file = $("#file")[0].files[0];
        fd.append('file', file);


        var request = $.ajax({
            type: "POST",
            url: "../php/ajax/settings/profile_picture.php",
            data: fd,
            dataType: "json",
            contentType: false,
            processData: false
        });

        request.done(function (response) {
            if (response.success === 1) {
                $("#ajax-photo-response").removeClass();
                $("#profile-img").attr('src', response.path);
                $("#ajax-photo-response").addClass("success");
            }
            else{
                $("#ajax-photo-response").addClass("failure");
            }
            $("#ajax-photo-response").html(response.flash_message);
        });

        request.fail(function () {
            $("#ajax-photo-response").removeClass();
            $("#ajax-photo-response").addClass("failure");
            $("#ajax-photo-response").html("We've got a problem with our servers! Try again later.");
        });
    });

});

// Listener per la rimozione della foto profilo
$(document).on('click','#remove-photo',function () {

        var request = $.ajax({
            type: "POST",
            url: "../php/ajax/settings/profile_picture.php",
            data: {remove_photo: 1},
            dataType: 'json'
        });


        request.done(function (response) {
            $("#ajax-photo-response").removeClass();
            if(response.success === 1){
                $("#profile-img").attr('src', response.path);
                $("#ajax-photo-response").addClass("success");
            }
            else
                $("#ajax-photo-response").addClass("failure");

            $("#ajax-photo-response").html(response.flash_message);
        });

        request.fail(function () {
            $("#ajax-photo-response").removeClass();
            $("#ajax-photo-response").addClass("failure");
            $("#ajax-photo-response").html("We've got a problem with our servers! Try again later.");
        });

});


$(document).ready(function () {

    // Listener per l'aggiornamento della password
    $("#password-form").submit(function (event) {
        event.preventDefault();


        var old_password = escapeInput($("#old-password").val());
        var new_password = escapeInput($("#new-password").val());


        var request = $.ajax({
            type: "POST",
            url: "../php/ajax/settings/update_password.php",
            data: {old_password: old_password, new_password: new_password},
            dataType: 'json'
        });


        request.done(function (response) {
            $("#ajax-password-response").removeClass(); // Calling removeClass with no parameters will remove all of the item's classes.
            if(response.success === 1){
                $("#ajax-password-response").addClass("success");
            }
            else
                $("#ajax-password-response").addClass("failure");

                $("#ajax-password-response").html(response.flash_message); // inserisce nel paragrafo html di signup la risposta del server
        });

        request.fail(function () {
            $("#ajax-password-response").removeClass();
            $("#ajax-password-response").addClass("failure");
            $("#ajax-password-response").html("We've got a problem with our servers! Try again later.");
        });

    });
});


$(document).ready(function () {

    // Listener per effettuare la disiscrizione dal sito
    $("#unsubscribe-form").submit(function (event) {
        event.preventDefault();

        var unsubscribe = true;


        var request = $.ajax({
            type: "POST",
            url: "../php/ajax/settings/unsubscribe.php",
            data: {unsubscribe: unsubscribe},
            dataType: 'json'
        });


        request.done(function (response) {
            if(response.success === 1)
                window.location.replace("../index.php");
            else{
                $("#ajax-unsubscribe-response").addClass("failure");
                $("#ajax-unsubscribe-response").html(response.flash_message);
            }

        });

        request.fail(function () {
            $("#ajax-unsubscribe-response").addClass("failure");
            $("#ajax-unsubscribe-response").html("We've got a problem with our servers! Try again later.");
        });

    });
});

// vari listener per far comparire e sparire le sezioni: change picture, update password, unsubscribe

$(document).on('click','#picture',function (){
    $("#photo-form").removeClass("hidden");
    if(!$("#password-form").hasClass("hidden"))
        $("#password-form").addClass("hidden");
    if(!$("#unsubscribe-form").hasClass("hidden"))
    $("#unsubscribe-form").addClass("hidden");
});

$(document).on('click','#password',function (){
    $("#password-form").removeClass("hidden");
    if(!$("#photo-form").hasClass("hidden"))
        $("#photo-form").addClass("hidden");
    if(!$("#unsubscribe-form").hasClass("hidden"))
        $("#unsubscribe-form").addClass("hidden");
});

$(document).on('click','#unsubscribe',function (){
    $("#unsubscribe-form").removeClass("hidden");
    if(!$("#photo-form").hasClass("hidden"))
        $("#photo-form").addClass("hidden");
    if(!$("#password-form").hasClass("hidden"))
        $("#password-form").addClass("hidden");
});

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
