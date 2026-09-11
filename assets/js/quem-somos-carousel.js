// Quem Somos Products Carousel JavaScript

$(document).ready(function() {
    // Wait for content to load
    setTimeout(function() {
        $('.quem-somos-products-carousel').slick({
            dots: false,
            infinite: true,
            speed: 500,
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 4000,
            arrows: false,
            adaptiveHeight: true,
            variableWidth: false,
            centerMode: false,
            swipeToSlide: true,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                    }
                },
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
                        centerMode: true,
                        centerPadding: '40px',
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        centerMode: true,
                        centerPadding: '20px',
                        slidesToScroll: 1,
                    }
                }
            ]
        });
    }, 100);

    $('#quem-somos-products-prev').on('click', function() {
        $('.quem-somos-products-carousel').slick('slickPrev');
    });

    $('#quem-somos-products-next').on('click', function() {
        $('.quem-somos-products-carousel').slick('slickNext');
    });

    // Mobile navigation events
    $('#quem-somos-products-prev-mobile').on('click', function() {
        $('.quem-somos-products-carousel').slick('slickPrev');
    });

    $('#quem-somos-products-next-mobile').on('click', function() {
        $('.quem-somos-products-carousel').slick('slickNext');
    });
});