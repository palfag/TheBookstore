


$(document).ready(function () {
    $("form").submit(function (event) {
        event.preventDefault();

        var name = $.trim(capitalize($("#name").val()));
        var surname = $.trim(capitalize($("#surname").val()));
        var email = $.trim($("#email").val().toLowerCase());
        var password = $("#password").val();
        var submit = $("#signup_btn").val();


        var request = $.ajax({
            type: "POST",
            url: "../php/signup.php",
            data: {name: name, surname: surname, email: email, password: password, submit: submit},
            dataType: "JSON"
        });

        request.done(function () {
            alert("success");
        })

        request.fail(function () {
            alert("fail");
        })

        request.always(function () {
            alert("always");
        })
    });
});

function capitalize(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}