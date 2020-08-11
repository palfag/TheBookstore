$(document).on('click','.like-button',function () {

    var id_book = $(".add-to-cart").attr('id');

    // se non è in wishlist --> insert DB
    if($(".like-button").hasClass("not-liked")){

        var request = $.ajax({
            type: "POST",
            url: "../php/insert_remove_wishlist.php",
            data: {insert_wishlist: id_book},
            dataType: 'json'
        });


        request.done(function (response) {
            if(response.success === 1){
                $(".like-button").addClass("liked");
                $(".like-button").removeClass("not-liked");
                $(".like-img").attr('src', "../images/icons/like.png");
            }

            else
                alert(response.error);
        });

        request.fail(function (response, textStatus, error) {
            alert(response + textStatus + error);
        });
    }




    // se è in wishlist --> delete DB
    else{

        var request = $.ajax({
            type: "POST",
            url: "../php/insert_remove_wishlist.php",
            data: {remove_wishlist: id_book},
            dataType: 'json'
        });


        request.done(function (response) {
            if(response.success === 1){
                $(".like-button").addClass("not-liked");
                $(".like-button").removeClass("liked");
                $(".like-img").attr('src', "../images/icons/no_like.png");
            }

            else
                alert(response.error);
        });

        request.fail(function (response, textStatus, error) {
            alert(response + textStatus + error);
        });
    }
});