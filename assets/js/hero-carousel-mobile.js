// Hero Carousel Mobile Responsive Script
// Applies flex display to carousel slides on mobile devices (768px and below)

document.addEventListener("DOMContentLoaded", function () {
  initHeroCarouselMobile();
});

function initHeroCarouselMobile() {
  // Check if we're on mobile viewport
  function isMobileViewport() {
    return window.innerWidth <= 768;
  }

  // Apply mobile styles to hero carousel slides
  function applyMobileCarouselStyles() {
    if (isMobileViewport()) {
      // Create and inject mobile-specific styles
      addMobileCarouselCSS();
    } else {
      // Remove mobile styles on larger screens
      removeMobileCarouselCSS();
    }
  }

  // Add CSS styles for mobile carousel
  function addMobileCarouselCSS() {
    // Check if mobile styles are already added
    if (document.getElementById("hero-carousel-mobile-styles")) {
      return;
    }

    const style = document.createElement("style");
    style.id = "hero-carousel-mobile-styles";
    style.textContent = `
            .hero-slider .slick-initialized .slick-slide,
            #slick-slide00 {
                display: flex !important;
            }
        `;
    document.head.appendChild(style);
  }

  // Remove mobile CSS styles
  function removeMobileCarouselCSS() {
    const mobileStyles = document.getElementById("hero-carousel-mobile-styles");
    if (mobileStyles) {
      mobileStyles.remove();
    }
  }

  // Wait for hero carousel to be initialized
  function waitForCarouselLoad() {
    const heroSlider = document.querySelector(".hero-slider");

    if (!heroSlider) {
      console.log("Hero slider not found");
      return;
    }

    // Check if Slick is initialized
    function checkSlickInitialized() {
      const slickInitialized =
        heroSlider.classList.contains("slick-initialized") ||
        heroSlider.querySelector(".slick-initialized");

      if (slickInitialized) {
        applyMobileCarouselStyles();
        return true;
      }
      return false;
    }

    // Try immediate check
    if (checkSlickInitialized()) {
      return;
    }

    // Watch for carousel initialization with MutationObserver
    const observer = new MutationObserver(function (mutations) {
      mutations.forEach(function (mutation) {
        if (
          mutation.type === "attributes" &&
          (mutation.attributeName === "class" ||
            mutation.attributeName === "style")
        ) {
          if (checkSlickInitialized()) {
            observer.disconnect();
          }
        }

        // Check for added nodes (slick elements)
        if (mutation.type === "childList") {
          mutation.addedNodes.forEach(function (node) {
            if (node.nodeType === 1) {
              // Element node
              if (
                node.classList &&
                (node.classList.contains("slick-track") ||
                  node.classList.contains("slick-slide") ||
                  node.classList.contains("slick-dots"))
              ) {
                if (checkSlickInitialized()) {
                  observer.disconnect();
                }
              }
            }
          });
        }
      });
    });

    // Start observing
    observer.observe(heroSlider, {
      childList: true,
      subtree: true,
      attributes: true,
      attributeFilter: ["class", "style"],
    });

    // Fallback timeout in case carousel takes too long
    setTimeout(function () {
      if (checkSlickInitialized()) {
        observer.disconnect();
      } else {
        applyMobileCarouselStyles();
        observer.disconnect();
      }
    }, 5000); // 5 second timeout
  }

  // Handle window resize
  function handleResize() {
    // Debounce resize events
    clearTimeout(handleResize.timeout);
    handleResize.timeout = setTimeout(function () {
      applyMobileCarouselStyles();
    }, 250);
  }

  // Initialize on page load
  waitForCarouselLoad();

  // Handle window resize
  window.addEventListener("resize", handleResize);

  // Also listen for orientation change on mobile devices
  window.addEventListener("orientationchange", function () {
    setTimeout(function () {
      applyMobileCarouselStyles();
    }, 500); // Small delay after orientation change
  });
}

// Export for potential external use
window.heroCarouselMobile = {
  init: initHeroCarouselMobile,
};
