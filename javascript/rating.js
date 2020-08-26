//Make sure that the dom is ready

$(document).ready(function () {
    resetStars();

    $('.star').mouseover(function () {
        removeHighlight();
        var index = parseInt($(this).data('index'));
        for(var i = 0; i <= index; i++){
            $('.star:eq('+i+')').addClass('highlight');
        }
    });

    $('.star').mouseleave(function () {
        removeHighlight(); // cancella tutto
        resetStars(); // rimette come da database
    });


    $('.star').on('click',function () {
        var index = parseInt($(this).data('index'));
        var rating = ++index; // star value
        alert(rating);

        var urlParams = new URLSearchParams(window.location.search);
        var item = urlParams.get('id_book');

        // bisogna fare 2 cose qui
        // se non si è mai inserito nulla dobbiamo fare una insert, in altrimenti si dovrà fare un UPDATE DELLA ROW già esistente

        var request = $.ajax({
            type: "POST",
            url: "../php/add_rate.php",
            data: {rate: rating, item: item},
            dataType: 'json'
        });

        request.done(function (response) {
            if (response.success === 1) {
                $("#add-rate-ajax-response").html("your rate:" + " " + response.rate);
            } else{
                $("#add-rate-ajax-response").html(response.error);
            }
        });

        request.fail(function (response, textStatus, error) {
            alert(response + textStatus + error);
        });
    });

});

function removeHighlight() {
    $('.star').each(function() {
        $('.star').removeClass('highlight');
    });
}

function resetStars(){
    var urlParams = new URLSearchParams(window.location.search);
    var item = urlParams.get('id_book');

    var request = $.ajax({
        type: "POST",
        url: "../php/rating.php",
        data: {reset_stars: 1, item: item},
        dataType: 'json'
    });

    request.done(function (response) {
        if (response.success === 1) {
            // deve colorare le richieste
            var index = response.rate;
            for(var i = 0; i < index; i++){
                $('.star:eq('+i+')').addClass('highlight');
            }
        } else{
            // deve apparire un errore proveniente dal backend
        }
    });

    request.fail(function (response, textStatus, error) {
        alert(response + textStatus + error);
    });
}