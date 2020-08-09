$(document).on('click','.remove-button',function () {

    var parent = this.parentNode.parentNode.parentNode;
    var row = document.getElementById(parent.id);
    row.parentNode.removeChild(row);

    var request = $.ajax({
        type: "POST",
        url: "../php/remove_to_cart.php",
        data: {remove_to_cart: parent.id},
        dataType: 'json'
    });

    request.done(function (response) {
        if(response.success === 1){
            var badgeNum = response.badge_num;
            var total = response.total;
            updateBadge(badgeNum);
            updateTotal(total);
        }

        else
            alert(response.error);
    });

    request.fail(function (response, textStatus, error) {
        alert(response + textStatus + error);
    });


});

function updateBadge(num) {
    $(".badge").html(num);
}

function updateTotal(val){
    $("#total").html(val);
}