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
            }
            $("#ajax-response").html(response.flash_message);
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

            }
            $("#ajax-response").html(response.flash_message);
        });

        request.fail(function (response, textStatus, error) {
            alert(response + textStatus + error);
        });

});