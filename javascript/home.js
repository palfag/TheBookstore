/**
 * @author Paolo Fagioli
 *
 * In questo file è definito il listener della searchbar
 * l'evento si genera quando l'utente cerca un libro nella searchbar e clicca il bottone "search"
 */

$(document).ready(function () {

    // Listener for search form
    $("form").submit(function (event) {
        event.preventDefault();

        var query = escapeInput($.trim($("#search-bar").val()));
        var sortCriteria = $("#sort-by").val();
        var genre = $("#category").val();

        if(query.length >= 1){
            $("#products").html("");

            var request = $.ajax({
                type: "POST",
                url: "../php/ajax/book/search_book.php",
                data: {search: 1, query: query, sort: sortCriteria, genre: genre},
                dataType: 'json'
            });

            request.done(function (response) {
                if (response.success === 1) {
                    showBooks(response.data);
                } else{
                    $("#products").html(response.error);
                }
            });

            request.fail(function () {
                $("#products").html("We've got a problem with our servers! Try again later.");
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
                        "<div class = cover><a href='../php/book.php?id_book="+ obj.book_id +"'>" + "<img src = "+ obj.cover +">" + "</a></div>" +
                        "<h1 class = title><a href='../php/book.php?id_book="+ obj.book_id +"'>" + obj.title + "</a></h1>" +
                        "<p class = author>"+ obj.author + "</p>" +
                        "<h3 class = price>" + obj.price + "€" + "</h3>" +
                        "<button class = add-to-cart id = " + obj.book_id + ">"+ "add to cart" + "</button>" +
                    "</div>";

        $("#products").append(products);
    }

}

/**
 * Funzione di escaping per sanificare l'input
 * @param input stringa potenzialmente dannosa
 * @returns {string} ritorna la stringa sanificata
 */
function escapeInput(input) {
    return String(input)
        .replace(/&/g, '&amp;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/%/g, ''); // To prevent errors with SQL LIKE
}