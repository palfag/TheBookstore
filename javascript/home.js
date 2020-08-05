$(document).ready(function () {

    // Listener for search form
    $("form").submit(function (event) {
        event.preventDefault();

        var query = $.trim($("#search-bar").val());

        // TODO ricambiare con query.length >= 1 per evitare di vedere tutto il db
        if(query.length >= 0){
            $("#products").html("");
            $("#ajax-response").html("");

            var request = $.ajax({
                type: "POST",
                url: "../php/search_book.php",
                data: {search: 1, query: query},
                dataType: 'json'
            });

            request.done(function (response) {
                if (response.success === 1) {
                    var books = response.data;
                    showBooks(books);
                } else{
                    // TODO PERCHE NON FUNZIONAAAAAA
                    $("#ajax-response").html(response.error);
                    alert(response.error);
                }
            });

            request.fail(function (response, textStatus, error) {
                alert(response + textStatus + error);
            });

        }
    });
});

/**
 * Displays books to homepage
 * @param {Object}  "array" of books.
 */
function showBooks(books){
    var products = "";
    for (var i = 0; i < books.length; i++) {
        var obj = books[i];

        // per far si che ogni 3 libri si vada a capo
        if(i % 3 == 0){
            $("#products").append("<br>");
        }

        products =  "<div class = " + "book id = " + obj.book_id + ">" +
                        "<div class = " + "cover>" + "<img src = "+ obj.cover +">" + "</div>" +
                        "<h1 class = " + "title><a href='../php/book.php?id_book="+ obj.book_id +"'>" + obj.title + "</h1>" +
                        "<p class = " + "author>"+ obj.author + "</p>" +
                        "<h3 class = " + "price>" + obj.price + "€" + "</h3>" +
                        "<button class = " + "add-to-cart>" + "add to cart" + "</button>" +
                    "</div>";

        $("#products").append(products);
    }

}