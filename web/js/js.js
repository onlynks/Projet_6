/*
$(document).ready(function(){
$('#scroll').on('click', function(event) {

    var target = $('#limit');

    if( target.length ) {
        event.preventDefault();
        $('html, body').stop().animate({
            scrollTop: target.offset().top
        }, 1000);

    }

});
});
*/

$("#scroll").click(function() {
    $('html, body').animate({
        scrollTop: $("#limit").offset().top
    }, 500);
});