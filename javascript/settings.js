$(document).ready(function () {

    // Listener for search form
    $("#photo-form").submit(function (event) {
        event.preventDefault();

        var fd = new FormData();
        var file = $("#file")[0].files[0];
        fd.append('file', file);


        var request = $.ajax({
            type: "POST",
            url: "../php/profile_picture.php",
            data: fd,
            dataType: "json",
            contentType: false,
            processData: false
        });

        request.done(function (response) {
            if (response.success === 1) {
                $("#profile-img").attr('src', response.path);
                $("#ajax-photo-response").addClass("success");
            }
            else{
                $("#ajax-photo-response").addClass("failure");
            }
            $("#ajax-photo-response").html(response.flash_message);
        });

        request.fail(function (response, textStatus, error) {
            alert(response + textStatus + error);
        });
    });

});

$(document).on('click','#remove-photo',function () {

        var request = $.ajax({
            type: "POST",
            url: "../php/profile_picture.php",
            data: {remove_photo: 1},
            dataType: 'json'
        });


        request.done(function (response) {
            if(response.success === 1){
                $("#profile-img").attr('src', response.path);
                $("#ajax-photo-response").addClass("success");
            }
            else
                $("#ajax-photo-response").addClass("failure");

            $("#ajax-photo-response").html(response.flash_message);
        });

        request.fail(function (response, textStatus, error) {
            alert(response + textStatus + error);
        });

});


$(document).ready(function () {

    // Listener for search form
    $("#password-form").submit(function (event) {
        event.preventDefault();


        var old_password = $("#old-password").val();
        var new_password = $("#new-password").val();


        var request = $.ajax({
            type: "POST",
            url: "../php/update_password.php",
            data: {old_password: old_password, new_password: new_password},
            dataType: 'json'
        });


        request.done(function (response) {
            if(response.success === 1){
                $("#ajax-password-response").addClass("success");
            }
            else
                $("#ajax-password-response").addClass("failure");

                $("#ajax-password-response").html(response.flash_message); // inserisce nel paragrafo html di signup la risposta del server
        });

        request.fail(function (response, textStatus, error) {
            alert(response + textStatus + error);
        });

    });
});


$(document).ready(function () {

    // Listener for search form
    $("#unsubscribe-form").submit(function (event) {
        event.preventDefault();

        var unsubscribe = true;


        var request = $.ajax({
            type: "POST",
            url: "../php/unsubscribe.php",
            data: {unsubscribe: unsubscribe},
            dataType: 'json'
        });


        request.done(function (response) {
            if(response.success === 1)
                window.location.replace("../php/index.php");
            else
                $("#ajax-unsubscribe-response").html(response.flash_message);
        });

        request.fail(function (response, textStatus, error) {
            alert(response + textStatus + error);
        });

    });
});

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
