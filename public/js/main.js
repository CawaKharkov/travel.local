/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 * @author Cawa
 */
$(document).ready(function() {
    $('#mainCarousel').carousel({
        // easing: 'easeInOutExpo', 
        adjustHeight: true // default
    });
    $('#mainCarousel').bind('slid', function() {
        // $(".carousel-caption").animate(
        // {"left": "+=400px"},
        //  "slow");
    });

    var $carousel = $('#mainCarousel');
    var $carouselCaptions = $carousel.find('.item .carousel-caption');
    var $carouselImages = $carousel.find('.item img');
    var carouselTimeout;

    $carousel.on('slid', function() {
        var $item = $carousel.find('.item.active');
        carouselTimeout = setTimeout(function() { // start the delay
            carouselTimeout = false;
            $item.find('.carousel-caption').animate({'opacity': 1}, 1000);
            $item.find('img').animate({'opacity': 0.5}, 500);
        }, 500);
    }).on('slide', function() {
        if (carouselTimeout) { // Carousel is sliding, stop pending animation if any
            clearTimeout(carouselTimeout);
            carouselTimeout = false;
        }
        // Reset styles
        $carouselCaptions.animate({'opacity': 0}, 500);
        $carouselImages.animate({'opacity': 1}, 500);
    });
    ;

    $carousel.carousel({
        interval: 6000,
        cycle: true,
    }).trigger('slid'); // Make the carousel believe that it has just been slid so that the first item gets the animation
});