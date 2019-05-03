$(document).ready(function(){
var $carrousel = $('#carrousel');
var $img = $('#carrousel img');
var $indexImg = $img.length - 1;
var i = 0; //compteur
var $currentImg = $img.eq(i); //image courante
$img.css('display', 'none');
$currentImg.css('display', 'block');
    
//defilement automatique
function slideImg(){
    setTimeout(function() {
        if (i < $indexImg) {
            i++;
        } else {
            i = 0;
        }
    $img.css('display', 'none');
    $currentImg = $img.eq(i);
    $currentImg.css('display', 'block');
    slideImg();
    }, 4000);
 }
    slideImg();
});

