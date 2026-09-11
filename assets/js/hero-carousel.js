// Hero Carousel JavaScript

$(document).ready(function() {
    // Get autoplay speed from data attribute, default to 5000ms
    var autoplaySpeed = parseInt($('.hero-slider').data('autoplay-speed')) || 5000;

    // Initialize the hero carousel
    $('.hero-slider').slick({
        dots: true,
        infinite: true,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: autoplaySpeed,
        pauseOnDotsHover: false,
        pauseOnFocus: false,
        arrows: false, // Disable default arrows, use custom ones
        fade: true,
        cssEase: 'ease-in-out',
        adaptiveHeight: true,
        appendDots: '.hero-slider-controls',
        customPaging: function(slider, i) {
            return '<div class="hero-slider-controls-item" data-slide="' + i + '"></div>';
        }
    });

    $('.hero-prev').on('click', function() {
        $('.hero-slider').slick('slickPrev');
    });

    $('.hero-next').on('click', function() {
        $('.hero-slider').slick('slickNext');
    });

    // Update active state for custom dots
    $('.hero-slider').on('beforeChange', function(event, slick, currentSlide, nextSlide) {
        $('.hero-slider-controls-item').removeClass('active');
        $('.hero-slider-controls-item').eq(nextSlide).addClass('active');
    });

    // Initialize first slide as active
    $('.hero-slider-controls-item').first().addClass('active');

    // Handle custom dot clicks using event delegation
    $(document).on('click', '.hero-slider-controls-item', function(e) {
        e.preventDefault();
        var slideIndex = parseInt($(this).data('slide'));
        $('.hero-slider').slick('slickGoTo', slideIndex, false);
    });
});