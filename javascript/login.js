$(document).ready(function () {
    $("form").submit(function (event) {
        event.preventDefault();

        var email = $.trim($("#email").val().toLowerCase());
        var password = $("#password").val();
        var submit = $("#submit").val();


        var request = $.ajax({
            type: "POST",
            url: "../php/login_ajax.php",
            data: {email: email, password: password, submit: submit},
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