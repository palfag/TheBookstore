$(document).ready(function () {

    $(".add-to-cart").click(function () {
        var book_id = this.id;

        var request = $.ajax({
            type: "POST",
            url: "../php/add_to_cart.php",
            data: {add_to_cart: book_id},
            dataType: 'json'
        });

        request.done(function (response) {
            if(response.success === 1){
                var badge_num = response.badge_num;
                updateBadge(badge_num);
            }

            else
                alert(response.error);
        });

        request.fail(function (response, textStatus, error) {
            alert(response + textStatus + error);
        });

    });

});

function updateBadge(num) {
    $(".badge").html(num);
}