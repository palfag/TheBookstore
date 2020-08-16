$(document).ready(function () {

    // Listener for search form
    $("form").submit(function (event) {
        event.preventDefault();

        var query = $.trim($("#search-bar").val());
        var sortCriteria = $("#sort-by").val();

        // TODO METTERE >= 1 ALLA FINE DEI GIOCHI
        if(query.length >= 0){
            $("#products").html("");

            var request = $.ajax({
                type: "POST",
                url: "../php/search_book.php",
                data: {search: 1, query: query, sort: sortCriteria},
                dataType: 'json'
            });

            request.done(function (response) {
                if (response.success === 1) {
                    var books = response.data;
                    showBooks(books);
                } else{
                    $("#products").html(response.error);
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

        products =  "<div class = " + "book>" +
                        "<div class = cover>" + "<img src = "+ obj.cover +">" + "</div>" +
                        "<h1 class = title><a href='../php/book.php?id_book="+ obj.book_id +"'>" + obj.title + "</a></h1>" +
                        "<p class = author>"+ obj.author + "</p>" +
                        "<h3 class = price>" + obj.price + "€" + "</h3>" +
                        "<button class = add-to-cart id = " + obj.book_id + ">"+ "add to cart" + "</button>" +
                    "</div>";

        $("#products").append(products);
    }

}