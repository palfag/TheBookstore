$(document).ready(function () {

    // Listener for comment form
    $("#comment-form").submit(function (event) {
        event.preventDefault();

        var comment = escapeInput($("#comment-text").val()); // poi sanificare l'input
        var urlParams = new URLSearchParams(window.location.search);
        var item = urlParams.get('id_book');

        if(comment.trim().length > 0){ // richiesta ajax solo se il commento non è vuoto
            var request = $.ajax({
                type: "POST",
                url: "../php/ajax/comment/add_comment.php",
                data: {add_comment: item, comment: comment},
                dataType: 'json'
            });

            request.done(function (response) {
                if (response.success === 1) {

                    // spariranno eventiali errori apparsi nella lista dei commenti
                    if($(".error")){
                        $(".error").remove();
                    }
                    // IN CASO DI SUCCESSO
                    var comment = response.comment;

                    if(comment.image === null){
                           comment.image = "../images/users/default_profile.png";
                    }

                    var html =  "<div class=comment "+comment.user+" id="+comment.id+">" +
                        "<button class='delete-comment-btn'><img src='../images/icons/bin.png'></button>"+
                        "<a href='profile.php?user="+comment.user+"'>"+
                        "<img src="+comment.image+">"+
                        "</a>"+
                        "<p class='user'>" +
                        "<a href='profile.php?user="+comment.user+"'>"+
                        "<span id='user-link'> "+comment.name+" "+comment.surname+"</span>"+
                        "</a>"+
                        "</p>"+
                        "<p>"+ comment.comment + "</p>"+
                        "<p><span id=timestamp>just now</span></p>"+
                        "</div>";

                    $(".my-comment").prepend(html);
                    $("#comment-text").val(''); // clear text area
                } else{
                    // IN CASO DI FALLIMENTO
                    var error =  "<h1 class='failure error'>"+ response.error +"</h1>";
                    $(".my-comment").prepend(error);
                }
            });

            request.fail(function (response, textStatus, error) {
                var error =  "<h1 class='failure error'>"+ "There was an error with our servers! Try again later."+"</h1>";
                $(".my-comment").prepend(error);
            });
        }
    });

});



$(document).on('click','.delete-comment-btn',function () {

    var parent = this.parentNode; // div class = "comment" && id = id del commento che si vuole eliminare
    var row = document.getElementById(parent.id);


    var request = $.ajax({
        type: "POST",
        url: "../php/ajax/comment/delete_comment.php",
        data: {delete_comment: parent.id},
        dataType: 'json'
    });

    request.done(function (response) {
        if(response.success === 1){
            // spariranno eventiali errori apparsi nella lista dei commenti
            if($(".error")){
                $(".error").remove();
            }
                row.parentNode.removeChild(row); // elimina il commento dall'html
        }

        else{
            var error =  "<h1 class='failure error'>"+ response.error +"</h1>";
            $(".my-comment").prepend(error);
        }

    });

    request.fail(function (response, textStatus, error) {
        var error =  "<h1 class='failure error'>"+ "There was an error with our servers! Try again later."+"</h1>";
        $(".my-comment").prepend(error);
    });

});

function escapeInput(input) {
    return String(input)
        .replace(/&/g, '&amp;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
}