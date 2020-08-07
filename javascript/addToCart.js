/**
 In jQuery, Click() event binds the element only if the particular element exists in the Html code(after page loads).
 It won't consider the future elements which are created dynamically(Future element). Dynamic elements are created with
 the help of javascript or jquery(not in Html).
 So the normal click event won't fire on the dynamic element.
 Solution :
 To overcome this we should use on() function.
 delegate(),live() and on() functions have the advantages over the DOM elements.
 delegate() and live() are deprecated (Don't use these).
 on can only trigger both the existing and future elements.
 on can consider all the elements which are present on the whole page.
 You should use on function to trigger the event on dynamically(future) created elements.
 Remove the code from $(document).ready:
 *
 */

$(document).on('click','.add-to-cart',function () {

        var book_id = this.id;

        var request = $.ajax({
            type: "POST",
            url: "../php/add_to_cart.php",
            data: {add_to_cart: book_id},
            dataType: 'json'
        });

        request.done(function (response) {
            if(response.success === 1){
                var badgeNum = response.badge_num;
                updateBadge(badgeNum);
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