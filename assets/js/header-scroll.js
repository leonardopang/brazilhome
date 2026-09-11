jQuery(document).ready(function ($) {
  const header = $(".main-header");
  const body = $("body");
  let headerHeight = header.outerHeight();

  // Set initial header height for body padding
  updateHeaderHeight();

  // Scroll event handler
  $(window).on("scroll", function () {
    // if(window.scrollY >= 230){
    //     // Add position fixed
    //     header.addClass('fixed-header');
    //     body.addClass('header-is-fixed');
    // } else {
    //     // Remove position fixed
    //     header.removeClass('fixed-header');
    //     body.removeClass('header-is-fixed');
    // }
  });

  // Update header height on resize
  $(window).on("resize", function () {
    updateHeaderHeight();
  });

  function updateHeaderHeight() {
    headerHeight = header.outerHeight();
    // Set CSS custom property for header height
    document.documentElement.style.setProperty(
      "--header-height",
      headerHeight + "px",
    );
  }

  // Update header height when images load
  header.find("img").on("load", function () {
    setTimeout(updateHeaderHeight, 100);
  });
});

// CSS for fixed header states will be handled in CSS file
