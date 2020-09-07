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

        var urlParams = new URLSearchParams(window.location.search);
        var item = urlParams.get('id_book');


        var request = $.ajax({
            type: "POST",
            url: "../php/ajax/rating/add_rate.php",
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
            $("#add-rate-ajax-response").html("There was an error with our servers! Try again later.");
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
        url: "../php/ajax/rating/rating.php",
        data: {reset_stars: 1, item: item},
        dataType: 'json'
    });

    request.done(function (response) {
        if (response.success === 1) {
            $("#add-rate-ajax-response").html('');
            // deve colorare le richieste
            var index = response.rate;
            for(var i = 0; i < index; i++){
                $('.star:eq('+i+')').addClass('highlight');
            }
        } else{
            $("#add-rate-ajax-response").html(response.error);
        }
    });

    request.fail(function (response, textStatus, error) {
        $("#add-rate-ajax-response").html("There was an error with our servers! Try again later.");
    });
}