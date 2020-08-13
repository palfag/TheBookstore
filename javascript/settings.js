$(document).ready(function () {

    // Listener for search form
    $("#photo-form").submit(function (event) {
        event.preventDefault();

        var fd = new FormData();
        var file = $("#file")[0].files[0];
        fd.append('file', file);


        var request = $.ajax({
            type: "POST",
            url: "../php/process_settings.php",
            data: fd,
            dataType: "json",
            contentType: false,
            processData: false
        });

        request.done(function (response) {
            if (response.success === 1) {
                $("#profile-img").attr('src', response.path);
            }
            $("#ajax-response").html(response.flash_message);
        });

        request.fail(function (response, textStatus, error) {
            alert(response + textStatus + error);
        });
    });
});