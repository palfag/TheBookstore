window.onload = showMenu;

function showMenu() {
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