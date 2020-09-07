window.onload = showMenu;

function showMenu() {

    $(".dropbtn").hover(function () {

        var getCategories = "getCategories";

        var content = $('.dropdown-content').html();

        if (content === "There was an error <br> with our servers! <br> Try again later.")
            $('.dropdown-content').html('');

        if (isEmpty($('.dropdown-content'))){
            var request = $.ajax({
                type: "POST",
                url: "../php/show_categories.php",
                data: {categories: getCategories},
                dataType: 'json'
            });

            request.done(function (response) {
                if (response.success === 1) {
                    var categories = response.data;
                    showCategories(categories);
                } else{
                    $(".dropdown-content").html(response.error);
                }
            });

            request.fail(function (response, textStatus, error) {
                $(".dropdown-content").html("There was an error <br> with our servers! <br> Try again later.");
            });
        }
    });


    $(".burger-menu").click(function () {
        var navOptions= $(".nav-options");
        if(navOptions.hasClass("nav-active")){
            navOptions.removeClass("nav-active");
        }
        else{
            navOptions.addClass("nav-active");
        }
    });
}



/**
 * Displays books to homepage
 * @param {Object}  "array" of books.
 */
function showCategories(categories){
    var html = "";
    for (var i = 0; i < categories.length; i++) {
        var obj = categories[i];

         html = "<a href='../php/category.php?category="+ obj.genre +"'>" + obj.genre + "</a>";

        $(".dropdown-content").append(html);
    }
}

function isEmpty(el){
    return !$.trim(el.html())
}