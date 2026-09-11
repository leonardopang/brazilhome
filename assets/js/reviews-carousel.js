// Reviews Carousel JavaScript

$(document).ready(function () {
  // Initialize the reviews carousel
  $(".reviews-carousel").slick({
    dots: false,
    infinite: true,
    speed: 500,
    slidesToShow: 3,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 5000,
    arrows: false, // Disable default arrows, use custom ones
    adaptiveHeight: true,
    variableWidth: false,
    centerMode: false,
    customPaging: 16,
    responsive: [
      {
        breakpoint: 1200,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
        },
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          centerMode: true,
          centerPadding: "40px",
        },
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          centerMode: true,
          centerPadding: "30px",
        },
      },
    ],
  });

  // Custom arrow click events for reviews carousel
  $("#reviews-prev, .reviews-nav-prev").on("click", function () {
    $(".reviews-carousel").slick("slickPrev");
  });

  $("#reviews-next, .reviews-nav-next").on("click", function () {
    $(".reviews-carousel").slick("slickNext");
  });

  // Pause autoplay on hover
  $(".reviews-carousel")
    .on("mouseenter", function () {
      $(this).slick("slickPause");
    })
    .on("mouseleave", function () {
      $(this).slick("slickPlay");
    });
});
