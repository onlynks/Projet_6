$("#scroll").click(function() {
    $('html, body').animate({
        scrollTop: $("#limit").offset().top
    }, 500);
});


var fond = document.querySelector('#image_header');
var longueur=window.innerHeight +'px';

fond.style.height = longueur;

