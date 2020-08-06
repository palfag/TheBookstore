window.onload = showMenu;

function showMenu() {

    $(".dropbtn").hover(function () {

        var getCategories = "getCategories";

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
                alert(response + textStatus + error);
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