// Blog Carousel JavaScript

$(document).ready(function() {
    $('.blog-carousel').slick({
        dots: true,
        infinite: true,
        speed: 500,
        slidesToShow: 2,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 4000,
        arrows: false, // Disable default arrows, use custom ones
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: true
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: true
                }
            }
        ]
    });

    // Custom arrow click events for featured section
    $('#blog-prev').on('click', function() {
        $('.blog-carousel').slick('slickPrev');
    });

    $('#blog-next').on('click', function() {
        $('.blog-carousel').slick('slickNext');
    });
});