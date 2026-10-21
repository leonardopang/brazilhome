// Main JavaScript for Brazil Home Living Website

// Helper function to get cookie value
function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(";").shift();
  return null;
}

function updateDeliveryMessage() {
  const selector =
    "#main > section > div > form > pre > div > div > section.woocommerce-order-details > table > tfoot > tr:nth-child(2) > td";
  const element = document.querySelector(selector);

  if (!element) return; // element not found

  const originalText = element.textContent.trim();

  // Regex to match: "Entrega em até X dias úteis - Frete Grátis"
  const match = originalText.match(
    /Entrega em até (\d+) dia[s]? úteis - Frete Grátis/i,
  );

  if (match) {
    const days = parseInt(match[1], 10);

    if (!isNaN(days)) {
      const plural = days === 1 ? "dia útil" : "dias úteis";
      element.textContent = `Entrega em até ${days} ${plural} - Frete Grátis`;
    }
  }
}

document.addEventListener("DOMContentLoaded", function () {
  const labelLogin = document.querySelector(
    "#customer_login > div.u-column1.col-1 > form > p:nth-child(1) > label",
  );

  // Update the label content
  if (labelLogin) {
    labelLogin.innerHTML =
      'Endereço de e-mail&nbsp;<span class="required" aria-hidden="true">*</span><span class="screen-reader-text">Obrigatório</span>';
    labelLogin.setAttribute("for", "username");
  }

  // Initialize all components
  initBlogSlider();
  initMobileMenu();
  initMobileSearchModal();
  initCartFunctionality();
  initCartPageFunctionality();
  initCheckoutPageFunctionality();
  initPagination();
  initAnimatedTextCarousel();
  initializeSearchIntegration();
  initBrazilianFieldFormatting();
  updateDeliveryMessage();
});

// Blog Slider Functionality
function initBlogSlider() {
  const slider = document.querySelector(".blog-cards-container");
  const prevBtn = document.querySelector(".slider-prev");
  const nextBtn = document.querySelector(".slider-next");
  const dots = document.querySelectorAll(".dot");

  let currentSlide = 0;
  const totalSlides = dots.length;

  // Handle dot clicks
  dots.forEach((dot, index) => {
    dot.addEventListener("click", () => {
      goToSlide(index);
    });
  });

  // Handle previous button
  if (prevBtn) {
    prevBtn.addEventListener("click", () => {
      currentSlide = currentSlide === 0 ? totalSlides - 1 : currentSlide - 1;
      goToSlide(currentSlide);
    });
  }

  // Handle next button
  if (nextBtn) {
    nextBtn.addEventListener("click", () => {
      currentSlide = currentSlide === totalSlides - 1 ? 0 : currentSlide + 1;
      goToSlide(currentSlide);
    });
  }

  function goToSlide(slideIndex) {
    currentSlide = slideIndex;

    // Update active dot
    dots.forEach((dot) => dot.classList.remove("active"));
    if (dots[slideIndex]) {
      dots[slideIndex].classList.add("active");
    }
  }

  // Auto-slide functionality (optional)
  setInterval(() => {
    currentSlide = currentSlide === totalSlides - 1 ? 0 : currentSlide + 1;
    goToSlide(currentSlide);
  }, 5000); // Change slide every 5 seconds
}

// Mobile Menu Functionality
function initMobileMenu() {
  const mobileToggle = document.querySelector(".mobile-menu-toggle");
  const mobileMenu = document.querySelector(".main-navigation");
  const mobileOverlay = document.querySelector(".mobile-menu-overlay");
  const mobileLinks = document.querySelectorAll(".nav-link");

  if (!mobileToggle || !mobileMenu || !mobileOverlay) return;

  if (mobileToggle.dataset.mobileInit === "true") return;
  mobileToggle.dataset.mobileInit = "true";

  function openMobileMenu() {
    mobileMenu.classList.add("mobile-menu-open");
    mobileOverlay.classList.add("active");
    mobileToggle.classList.add("active");
    document.body.style.overflow = "hidden";
    mobileToggle.setAttribute("aria-expanded", "true");
  }

  function closeMobileMenu() {
    mobileMenu.classList.remove("mobile-menu-open");
    mobileOverlay.classList.remove("active");
    mobileToggle.classList.remove("active");
    document.body.style.overflow = "";
    mobileToggle.setAttribute("aria-expanded", "false");
  }

  function toggleMobileMenu(e) {
    e.preventDefault();
    const isOpen = mobileMenu.classList.contains("mobile-menu-open");
    if (isOpen) closeMobileMenu();
    else openMobileMenu();
  }

  mobileToggle.addEventListener("click", toggleMobileMenu);
  mobileOverlay.addEventListener("click", closeMobileMenu);

  mobileLinks.forEach((link) => {
    link.addEventListener("click", closeMobileMenu);
  });

  document.addEventListener("keydown", (e) => {
    if (
      e.key === "Escape" &&
      mobileMenu.classList.contains("mobile-menu-open")
    ) {
      closeMobileMenu();
    }
  });

  window.addEventListener("resize", () => {
    if (
      window.innerWidth > 768 &&
      mobileMenu.classList.contains("mobile-menu-open")
    ) {
      closeMobileMenu();
    }
  });

  mobileToggle.setAttribute("aria-expanded", "false");
  mobileToggle.setAttribute("aria-controls", "mobile-menu");
}

// Mobile Search Modal Functionality
function initMobileSearchModal() {
  console.log("🔍 Initializing mobile search modal...");

  const mobileSearchButton = document.querySelector(
    ".custom-search-button-mobile",
  );
  const searchSection = document.querySelector(".search-section");
  const searchInput = document.querySelector("#custom-search-input");

  console.log("📱 Mobile search elements:", {
    button: !!mobileSearchButton,
    section: !!searchSection,
    input: !!searchInput,
  });

  if (!mobileSearchButton || !searchSection) {
    console.error("❌ Mobile search elements missing!");
    return;
  }

  // Create modal overlay for search
  let searchOverlay = document.querySelector(".mobile-search-overlay");
  if (!searchOverlay) {
    searchOverlay = document.createElement("div");
    searchOverlay.className = "mobile-search-overlay";
    document.body.appendChild(searchOverlay);
  }

  // Create close button for search modal
  let searchCloseButton = searchSection.querySelector(".mobile-search-close");
  if (!searchCloseButton) {
    searchCloseButton = document.createElement("button");
    searchCloseButton.className = "mobile-search-close";
    searchCloseButton.innerHTML = "&times;";
    searchCloseButton.setAttribute("aria-label", "Fechar busca");
    searchSection.insertBefore(searchCloseButton, searchSection.firstChild);
  }

  // Toggle mobile search modal
  function toggleMobileSearchModal() {
    const isOpen = searchSection.classList.contains("mobile-search-open");
    console.log("🔄 Toggling search modal, currently open:", isOpen);

    if (isOpen) {
      console.log("🚪 Closing search modal");
      closeMobileSearchModal();
    } else {
      console.log("🚪 Opening search modal");
      openMobileSearchModal();
    }
  }

  // Open mobile search modal
  function openMobileSearchModal() {
    searchSection.classList.add("mobile-search-open");
    searchOverlay.classList.add("active");
    document.body.style.overflow = "hidden";

    // Focus on search input
    if (searchInput) {
      setTimeout(() => {
        searchInput.focus();
      }, 300);
    }

    // Accessibility
    mobileSearchButton.setAttribute("aria-expanded", "true");
  }

  // Close mobile search modal
  function closeMobileSearchModal() {
    searchSection.classList.remove("mobile-search-open");
    searchOverlay.classList.remove("active");
    document.body.style.overflow = "";

    // Accessibility
    mobileSearchButton.setAttribute("aria-expanded", "false");
  }

  // Event listeners
  mobileSearchButton.addEventListener("click", (e) => {
    console.log("🔍 Mobile search button clicked");
    e.preventDefault();
    e.stopImmediatePropagation();
    toggleMobileSearchModal();
  });

  // Only close button closes the modal
  searchCloseButton.addEventListener("click", closeMobileSearchModal);

  // Close modal on escape key
  document.addEventListener("keydown", (e) => {
    if (
      e.key === "Escape" &&
      searchSection.classList.contains("mobile-search-open")
    ) {
      closeMobileSearchModal();
    }
  });

  // Close modal on window resize if screen gets larger
  window.addEventListener("resize", () => {
    if (
      window.innerWidth > 750 &&
      searchSection.classList.contains("mobile-search-open")
    ) {
      closeMobileSearchModal();
    }
  });

  // Initialize accessibility attributes
  mobileSearchButton.setAttribute("aria-expanded", "false");
  mobileSearchButton.setAttribute("aria-controls", "search-section");
}

// Search Functionality
function initSearchFunctionality() {
  const searchInput = document.querySelector(".search-input");
  const searchButton = document.querySelector(".search-button");

  if (searchInput && searchButton) {
    // Handle search button click
    searchButton.addEventListener("click", performSearch);

    // Handle Enter key press in search input
    searchInput.addEventListener("keypress", (e) => {
      if (e.key === "Enter") {
        performSearch();
      }
    });

    // Handle search input focus/blur for placeholder animation
    searchInput.addEventListener("focus", () => {
      searchInput.parentElement.classList.add("focused");
    });

    searchInput.addEventListener("blur", () => {
      if (!searchInput.value.trim()) {
        searchInput.parentElement.classList.remove("focused");
      }
    });
  }

  function performSearch() {
    const query = searchInput.value.trim();
    if (query) {
      console.log(`Searching for: ${query}`);
      // Add actual search logic here
      // For now, just log the search query
    }
  }
}

// Function to handle search form integration
function initializeSearchIntegration() {
  // Get elements from custom search
  const customSearchInput = document.getElementById("custom-search-input");
  const customSearchButton = document.getElementById("custom-search-button");

  // Get elements from WooCommerce search form
  const wooSearchInput = document.getElementById(
    "woocommerce-product-search-field-0",
  );
  const wooSearchForm = document.querySelector(".woocommerce-product-search");

  // Check if all elements exist
  if (
    !customSearchInput ||
    !customSearchButton ||
    !wooSearchInput ||
    !wooSearchForm
  ) {
    console.warn("Search integration: Some required elements not found");
    return;
  }

  // Function to sync search values and submit
  function performSearch() {
    const searchQuery = customSearchInput.value.trim();

    if (searchQuery === "") {
      // Optional: Show alert or focus input for empty search
      customSearchInput.focus();
      return;
    }

    // Fill the WooCommerce search input with the custom search value
    wooSearchInput.value = searchQuery;

    // Submit the WooCommerce form
    wooSearchForm.submit();
  }

  // Handle click on custom search button
  customSearchButton.addEventListener("click", function (e) {
    e.preventDefault();
    performSearch();
  });

  // Handle Enter key press in custom search input
  customSearchInput.addEventListener("keypress", function (e) {
    if (e.key === "Enter") {
      e.preventDefault();
      performSearch();
    }
  });

  // Optional: Real-time sync (uncomment if you want live synchronization)
  /*
    customSearchInput.addEventListener('input', function() {
        wooSearchInput.value = customSearchInput.value;
    });
    */
}

// Shopping Cart Functionality
function initCartFunctionality() {
  const cartIcon = document.querySelector(".shopping-cart");
  const cartCount = document.querySelector(".cart-count");

  if (cartIcon) {
    cartIcon.addEventListener("click", () => {
      // Redirect to WooCommerce cart page
      if (typeof brazil_ajax !== "undefined" && brazil_ajax.cart_url) {
        window.location.href = brazil_ajax.cart_url;
      } else {
        window.location.href = "/cart/";
      }
    });
  }

  // Function to update cart count
  window.updateCartCount = function (count) {
    if (cartCount) {
      cartCount.textContent = count || 0;
      cartCount.style.display = count && count > 0 ? "flex" : "none";
    }
  };

  // Listen for WooCommerce cart updates
  if (typeof jQuery !== "undefined") {
    // Listen for various WooCommerce events
    jQuery(document).on(
      "updated_wc_div updated_cart_totals added_to_cart",
      function () {
        // Cart was updated via AJAX, refresh fragments
        jQuery("body").trigger("wc_fragment_refresh");
      },
    );

    // Listen for fragment refresh completion
    jQuery(document).on("wc_fragments_refreshed", function () {
      // Fragments have been refreshed, update any manual counters if needed
      console.log("WooCommerce fragments refreshed");
    });

    // Also listen for direct cart changes
    jQuery("body").on("wc_cart_button_updated", function (event, fragments) {
      console.log("Cart button updated", fragments);
    });

    // Add CEP mask for billing_postcode
    jQuery(document).on(
      "input",
      "#customer_login #billing_postcode",
      function () {
        let value = jQuery(this).val().replace(/\D/g, "");
        if (value.length > 5) {
          value = value.substring(0, 5) + "-" + value.substring(5, 8);
        }
        jQuery(this).val(value);
      },
    );

    jQuery(document).on(
      "blur",
      "#customer_login #billing_postcode",
      function () {
        const zipcode = jQuery(this).val();
        if (zipcode.length == 9) {
          jQuery.get(
            "https://viacep.com.br/ws/" + zipcode + "/json/",
            function (data) {
              const address_str = data.logradouro
                ? `${data.bairro ? data.bairro + ", " : ""}${data.logradouro}`
                : "";
              jQuery("#customer_login #billing_address_1").val(address_str);
            },
          );
        }
        return false;
      },
    );
  }
}

// Pagination Functionality
function initPagination() {
  const paginationBtns = document.querySelectorAll(".pagination-btn");

  paginationBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
      // Remove active class from all buttons
      paginationBtns.forEach((b) => b.classList.remove("active"));

      // Add active class to clicked button
      btn.classList.add("active");

      const pageNumber = btn.textContent;
      console.log(`Loading page ${pageNumber}`);

      // Add page loading logic here
      loadPage(pageNumber);
    });
  });

  function loadPage(pageNumber) {
    // Scroll to top of posts section
    const postsSection = document.querySelector(".latest-posts-section");
    if (postsSection) {
      postsSection.scrollIntoView({ behavior: "smooth" });
    }

    // Add loading animation or fetch new content
    console.log(`Fetching content for page ${pageNumber}`);
  }
}

// Utility Functions
function debounce(func, wait) {
  let timeout;
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}

// Smooth scroll for internal links
function initSmoothScroll() {
  const links = document.querySelectorAll('a[href^="#"]');

  links.forEach((link) => {
    link.addEventListener("click", (e) => {
      e.preventDefault();

      const targetId = link.getAttribute("href");
      const targetSection = document.querySelector(targetId);

      if (targetSection) {
        targetSection.scrollIntoView({
          behavior: "smooth",
          block: "start",
        });
      }
    });
  });
}

// ─── CEP Shipping Calculator (Cart + Checkout) ───────────────────────────────
// Format a raw digit string as 00000-000

function formatCep(raw) {
  const digits = raw.replace(/\D/g, "").substring(0, 8);
  return digits.length > 5
    ? digits.substring(0, 5) + "-" + digits.substring(5)
    : digits;
}

// Save/load CEP cookie helpers (7-day persistence)
function saveCepCookie(cep) {
  const expires = new Date(Date.now() + 7 * 864e5).toUTCString();
  document.cookie = `brazil_home_cep=${cep}; expires=${expires}; path=/`;
}

// AJAX call to WooCommerce for shipping rates
async function fetchShippingRates(cep) {
  if (typeof brazilHomeShipping === "undefined") {
    console.warn("Shipping não disponível nessa página");
    return [];
  }

  const formData = new FormData();
  formData.append("action", "calculate_cart_shipping");
  formData.append("postcode", cep);
  formData.append("country", "BR");
  formData.append("nonce", brazilHomeShipping.nonce);

  try {
    const response = await fetch(brazilHomeShipping.ajax_url, {
      method: "POST",
      body: formData,
    });

    if (!response.ok) {
      throw new Error("Erro HTTP: " + response.status);
    }

    const data = await response.json();

    if (!data.success) {
      throw new Error(data.data || "Erro ao calcular frete");
    }

    return data.data.shipping_methods || [];
  } catch (error) {
    console.error("Erro real no frete:", error);
    return [];
  }
}

// Build the result HTML from the shipping options array
function buildShippingResultHTML(options) {
  if (!options.length) {
    return "<p>Nenhuma opção de frete disponível para este CEP.</p>";
  }

  const items = options
    .map((option) => {
      const name = option.name || option.label || "Frete";
      const match = name.match(/(\d+)(\s+dias?\s+úteis?|\s+dias?)/i);
      let days = "Consulte prazo";

      if (match) {
        const n = match[1];
        days = n === "1" ? `${n} dia útil` : `${n} dias úteis`;
      }

      return `
      <div class="cart-shipping-option">
        <span class="cart-shipping-name">Entrega em até ${days} - Frete Grátis</span>
      </div>`;
    })
    .join("");

  return `<h4>Opções de entrega:</h4>${items}`;
}

// Show result or error in a results container
function setShippingResult(container, html) {
  container.innerHTML = html;
  container.style.display = "block";
}

function clearShippingResult(container) {
  container.innerHTML = "";
  container.style.display = "none";
}

// Toggle button loading state — always stores/restores original text via dataset
function setButtonLoading(button, loading) {
  if (loading) {
    // Only store original text if not already in loading state
    const current = button.textContent.trim();
    if (current && current !== "CALCULANDO...") {
      button.dataset.originalText = current;
    }
    button.textContent = "CALCULANDO...";
    button.disabled = true;
  } else {
    button.textContent = button.dataset.originalText || "CALCULAR";
    button.disabled = false;
  }
}

// Propagate a calculated CEP to all other CEP inputs on the page
function syncCepToOtherInputs(cep) {
  const formatted = formatCep(cep);
  ["cart-cep-input", "cart-cep", "checkout-cep-input"].forEach((id) => {
    const el = document.getElementById(id);
    if (el && el.value.replace(/\D/g, "") !== cep) {
      el.value = formatted;
    }
  });
}

// Last successful result, so checkout refreshes (e.g. changing the payment
// method) restore it instead of hitting the shipping API again.
let lastShippingResult = { cep: "", html: "" };

// Core calculation runner — shared by cart and checkout
async function runCepCalculation(input, button, resultsContainer) {
  console.log(
    "Running CEP calculation for input:",
    input.id,
    "with value:",
    input.value,
  );
  if (button.disabled) return;
  const cepRaw = input.value.replace(/\D/g, "");
  const cep = cepRaw.replace(/^(\d{5})(\d{3})$/, "$1-$2");

  if (cepRaw.length !== 8) {
    setShippingResult(
      resultsContainer,
      `<div class="cart-shipping-error">Por favor, digite um CEP válido com 8 dígitos.</div>`,
    );
    return;
  }

  setButtonLoading(button, true);

  try {
    const options = await fetchShippingRates(cep);
    const resultHTML = buildShippingResultHTML(options);
    setShippingResult(resultsContainer, resultHTML);
    lastShippingResult = { cep: cepRaw, html: resultHTML };
    saveCepCookie(cep); // persist after successful calculation
    syncCepToOtherInputs(cep); // keep cart ↔ checkout in sync
  } catch (error) {
    console.error("CEP shipping calculation error:", error);

    setShippingResult(
      resultsContainer,
      `<div class="cart-shipping-error">${error.message}</div>`,
    );
  } finally {
    // Always runs — prevents button from getting stuck on "CALCULANDO..."
    setButtonLoading(button, false);
  }
}

// Generic initializer for any CEP calculator block
function initCepCalculator(inputId, buttonId, resultsId, autoCalculate) {
  const input = document.getElementById(inputId);
  const button = document.getElementById(buttonId);
  const results = document.getElementById(resultsId);

  if (!input || !button || !results) return;

  if (button.dataset.init === "true") return;
  button.dataset.init = "true";

  // Format digits as user types
  input.addEventListener("input", function () {
    input.value = formatCep(input.value);
  });

  // Submit on Enter key
  input.addEventListener("keypress", function (e) {
    if (e.key === "Enter") {
      e.preventDefault();
      runCepCalculation(input, button, results);
    }
  });

  // Submit on button click
  button.addEventListener("click", function () {
    runCepCalculation(input, button, results);
  });

  // Pre-fill: prefer WooCommerce billing field (checkout), fall back to cookie
  const wooField = document.getElementById("billing_postcode");
  const wooValue = wooField ? wooField.value.replace(/\D/g, "") : "";
  const savedCep = getCookie("brazil_home_cep") || "";
  const prefill = wooValue.length === 8 ? wooValue : savedCep;

  if (prefill.length === 8) {
    input.value = formatCep(prefill);
    if (autoCalculate) {
      if (lastShippingResult.cep === prefill) {
        setShippingResult(results, lastShippingResult.html);
      } else {
        setTimeout(() => runCepCalculation(input, button, results), 500);
      }
    }
  }
}

// Initialize cart shipping calculator
function initCartShippingCalculator() {
  // Support both possible IDs for the cart CEP input
  const cartInputId = document.getElementById("cart-cep-input")
    ? "cart-cep-input"
    : "cart-cep";
  initCepCalculator(
    cartInputId,
    "cart-calculate-cep",
    "cart-cep-results",
    true,
  );
}

// Initialize checkout shipping calculator
function initCheckoutShippingCalculator() {
  initCepCalculator(
    "checkout-cep-input",
    "checkout-calculate-cep",
    "checkout-cep-results",
    true,
  );
}

// Backwards-compatible global (called by inline onclick handlers, if any)
window.calculateCartShipping = function () {
  const input =
    document.getElementById("cart-cep-input") ||
    document.getElementById("cart-cep");
  const button = document.getElementById("cart-calculate-cep");
  const results = document.getElementById("cart-cep-results");
  if (input && button && results) runCepCalculation(input, button, results);
};
// Initialize smooth scroll
initSmoothScroll();

// Add scroll event listener for header effects
window.addEventListener(
  "scroll",
  debounce(() => {
    const header = document.querySelector(".main-header");
    if (header) {
      if (window.scrollY > 100) {
        header.classList.add("scrolled");
      } else {
        header.classList.remove("scrolled");
      }
    }
  }, 10),
);

// Image lazy loading for performance
function initLazyLoading() {
  const images = document.querySelectorAll("img[data-src]");

  const imageObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        const img = entry.target;
        img.src = img.dataset.src;
        img.classList.remove("lazy");
        imageObserver.unobserve(img);
      }
    });
  });

  images.forEach((img) => imageObserver.observe(img));
}

// Initialize lazy loading if supported
if ("IntersectionObserver" in window) {
  initLazyLoading();
}

// Animated Text Carousel
function initAnimatedTextCarousel() {
  const texts = document.querySelectorAll(".carousel-text");
  let currentIndex = 0;
  let interval = null;
  let isAnimating = false;
  const intervalTime = 3000; // 3 seconds

  function showNext() {
    if (isAnimating) return;

    isAnimating = true;

    // Current active text exits up
    const currentText = texts[currentIndex];
    currentText.classList.remove("active");
    currentText.classList.add("exit-up");

    // Move to next index
    currentIndex = (currentIndex + 1) % texts.length;

    // Next text comes in from bottom
    const nextText = texts[currentIndex];
    nextText.classList.remove("exit-up");

    setTimeout(() => {
      nextText.classList.add("active");
    }, 100);

    // Reset the previous text position after animation
    setTimeout(() => {
      currentText.classList.remove("exit-up");
      currentText.style.transform = "translateY(50px)";
      currentText.style.opacity = "0";
      isAnimating = false;
    }, 800);

    // Reset inline styles after a bit
    setTimeout(() => {
      currentText.style.transform = "";
      currentText.style.opacity = "";
    }, 1000);
  }

  function startCarousel() {
    if (interval) return;

    interval = setInterval(() => {
      showNext();
    }, intervalTime);
  }

  function pauseCarousel() {
    if (interval) {
      clearInterval(interval);
      interval = null;
    }
  }

  // Start the carousel
  startCarousel();

  // Pause on hover
  const container = document.querySelector(".animated-text-carousel");
  if (container) {
    container.addEventListener("mouseenter", pauseCarousel);
    container.addEventListener("mouseleave", startCarousel);
  }
}

// Cart Page Functionality
function initCartPageFunctionality() {
  // Check if we're on the cart page
  if (!document.querySelector(".cart-page-main")) return;

  // Initialize quantity controls
  initQuantityControls();

  // Initialize remove buttons
  initRemoveButtons();

  // Initialize coupon functionality
  initCouponFunctionality();

  // Initialize cart shipping calculator
  initCartShippingCalculator();
}

// Quantity Controls
function initQuantityControls() {
  const decreaseButtons = document.querySelectorAll(".cart-quantity-decrease");
  const increaseButtons = document.querySelectorAll(".cart-quantity-increase");
  const quantityInputs = document.querySelectorAll(".cart-quantity-input");

  // Handle decrease buttons
  decreaseButtons.forEach((button) => {
    button.addEventListener("click", function (e) {
      e.preventDefault();
      const input = this.parentElement.querySelector(".cart-quantity-input");
      if (input) {
        let currentValue = parseInt(input.value) || 1;
        const minValue = parseInt(input.getAttribute("min")) || 1;
        if (currentValue > minValue) {
          input.value = currentValue - 1;
          triggerQuantityUpdate(input);
        }
      }
    });
  });

  // Handle increase buttons
  increaseButtons.forEach((button) => {
    button.addEventListener("click", function (e) {
      e.preventDefault();
      const input = this.parentElement.querySelector(".cart-quantity-input");
      if (input) {
        let currentValue = parseInt(input.value) || 1;
        const rawMax = parseInt(input.getAttribute("max"));
        // WooCommerce sets max="-1" for unlimited stock.
        const maxValue = isNaN(rawMax) || rawMax === -1 ? 999 : rawMax;
        if (currentValue < maxValue) {
          input.value = currentValue + 1;
          triggerQuantityUpdate(input);
        }
      }
    });
  });

  // Handle direct input changes
  quantityInputs.forEach((input) => {
    input.addEventListener("change", function () {
      // Just validate the input value
      const value = parseInt(this.value) || 1;
      const minValue = parseInt(this.getAttribute("min")) || 1;
      const rawMax = parseInt(this.getAttribute("max"));
      // WooCommerce sets max="-1" for unlimited stock.
      const maxValue = isNaN(rawMax) || rawMax === -1 ? 999 : rawMax;

      if (value < minValue) {
        this.value = minValue;
      } else if (value > maxValue) {
        this.value = maxValue;
      }

      triggerQuantityUpdate(this);
    });
  });
}

// Trigger quantity update
function triggerQuantityUpdate(input) {
  // Prevent infinite loops
  if (input.dataset.processing === "true") {
    return;
  }

  // Set processing flag
  input.dataset.processing = "true";

  // Get cart item key and quantity
  const cartItemKey = extractCartItemKey(input.name);
  const quantity = parseInt(input.value) || 1;

  if (!cartItemKey) {
    console.error("Cart item key not found");
    input.dataset.processing = "false";
    return;
  }

  // Update quantity via AJAX
  updateCartItemQuantity(cartItemKey, quantity, input);
}

// Extract cart item key from input name
function extractCartItemKey(inputName) {
  const match = inputName.match(/cart\[(.+?)\]\[qty\]/);
  return match ? match[1] : null;
}

// Update cart item quantity via AJAX
function updateCartItemQuantity(cartItemKey, quantity, inputElement) {
  if (typeof brazil_cart_ajax === "undefined") {
    console.error("Brazil cart AJAX not available");
    return;
  }

  // Find the quantity controls container
  const quantityControls = inputElement.closest(".cart-quantity-controls");
  const decreaseBtn = quantityControls?.querySelector(
    ".cart-quantity-decrease",
  );
  const increaseBtn = quantityControls?.querySelector(
    ".cart-quantity-increase",
  );

  // Add loading state
  inputElement.style.opacity = "0.5";
  inputElement.disabled = true;
  if (decreaseBtn) decreaseBtn.disabled = true;
  if (increaseBtn) increaseBtn.disabled = true;

  const formData = new FormData();
  formData.append("action", "update_cart_quantity");
  formData.append("cart_item_key", cartItemKey);
  formData.append("quantity", quantity);
  formData.append("nonce", brazil_cart_ajax.update_cart_nonce);

  fetch(brazil_cart_ajax.ajax_url, {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      // Restore controls state
      inputElement.style.opacity = "1";
      inputElement.disabled = false;
      inputElement.dataset.processing = "false"; // Clear processing flag
      if (decreaseBtn) decreaseBtn.disabled = false;
      if (increaseBtn) increaseBtn.disabled = false;

      if (data.success) {
        // Update cart totals on page
        updateCartDisplayTotals(data.data);

        // Update item subtotal if available
        const itemRow = inputElement.closest(".cart-item-row");
        const subtotalElement = itemRow?.querySelector(".cart-item-subtotal");
        if (subtotalElement && data.data.item_subtotal) {
          subtotalElement.innerHTML = data.data.item_subtotal;
        }
      } else {
        console.error("Failed to update cart quantity:", data.data);
        // Revert input value if needed
      }
    })
    .catch((error) => {
      // Restore controls state on error
      inputElement.style.opacity = "1";
      inputElement.disabled = false;
      inputElement.dataset.processing = "false"; // Clear processing flag
      if (decreaseBtn) decreaseBtn.disabled = false;
      if (increaseBtn) increaseBtn.disabled = false;
      console.error("Error updating cart quantity:", error);
    });
}

// Update cart display totals
function updateCartDisplayTotals(data) {
  // Update total display
  const totalDisplay = document.querySelector(".cart-total-display");
  if (totalDisplay && data.cart_total) {
    totalDisplay.innerHTML = data.cart_total;
  }

  // Update cart totals section
  const subtotalValue = document.querySelector(
    ".cart-totals-section .cart-totals-value",
  );
  if (subtotalValue && data.cart_subtotal) {
    subtotalValue.innerHTML = data.cart_subtotal;
  }

  // Update final total
  const finalTotalValue = document.querySelector(
    ".cart-totals-final .cart-totals-value",
  );
  if (finalTotalValue && data.cart_total) {
    finalTotalValue.innerHTML = data.cart_total;
  }

  // Update cart count in header if available
  if (typeof updateCartCount === "function" && data.cart_count !== undefined) {
    updateCartCount(data.cart_count);
  }
}

// Remove Buttons
function initRemoveButtons() {
  const removeButtons = document.querySelectorAll(".cart-item-remove");

  removeButtons.forEach((button) => {
    button.addEventListener("click", function (e) {
      e.preventDefault();

      const cartItemKey = this.getAttribute("data-cart-item-key");

      if (!cartItemKey) {
        console.error("No cart item key found");
        return;
      }

      // Add loading state
      this.style.opacity = "0.5";
      this.style.pointerEvents = "none";

      // For now, just use the page reload method since it's more reliable
      // Find the WooCommerce cart nonce
      const cartNonce = document.querySelector(
        'input[name="woocommerce-cart-nonce"]',
      );
      if (cartNonce) {
        const removeUrl = `?remove_item=${cartItemKey}&_wpnonce=${cartNonce.value}`;
        window.location.href = window.location.pathname + removeUrl;
        return;
      }

      // Fallback to AJAX if nonce not found
      if (typeof brazil_cart_ajax === "undefined") {
        console.error("No removal method available");
        this.style.opacity = "1";
        this.style.pointerEvents = "auto";
        return;
      }

      // Remove item via AJAX
      removeCartItem(cartItemKey, this);
    });
  });
}

// Remove cart item via AJAX
function removeCartItem(cartItemKey, button) {
  // Try multiple approaches for AJAX
  let ajaxUrl = "/wp-admin/admin-ajax.php";
  let nonce = "";

  if (typeof brazil_cart_ajax !== "undefined") {
    ajaxUrl = brazil_cart_ajax.ajax_url;
    nonce = brazil_cart_ajax.remove_cart_nonce;
  } else {
    // Try to get nonce from WordPress
    const nonceElements = document.querySelectorAll(
      'input[name*="nonce"], [data-nonce]',
    );
    if (nonceElements.length > 0) {
      nonce = nonceElements[0].value || nonceElements[0].dataset.nonce;
    }
  }

  const formData = new FormData();
  formData.append("action", "remove_cart_item");
  formData.append("cart_item_key", cartItemKey);
  if (nonce) {
    formData.append("nonce", nonce);
  }

  fetch(ajaxUrl, {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text())
    .then((text) => {
      // Check if response is empty
      if (!text || text.trim() === "") {
        console.error("Empty response from server");
        button.style.opacity = "1";
        button.style.pointerEvents = "auto";
        return;
      }

      try {
        const data = JSON.parse(text);

        if (data.success) {
          // Remove the item row from DOM
          const itemRow = button.closest(".cart-item-row");
          if (itemRow) {
            itemRow.style.transition = "all 0.3s ease";
            itemRow.style.opacity = "0";
            itemRow.style.transform = "translateX(-20px)";

            setTimeout(() => {
              itemRow.remove();

              // Check if cart is now empty
              if (data.data && data.data.cart_is_empty) {
                // Reload page to show empty cart message
                window.location.reload();
              } else if (data.data) {
                // Update cart totals
                updateCartDisplayTotals(data.data);
              }
            }, 300);
          }
        } else {
          // Restore button state on error
          button.style.opacity = "1";
          button.style.pointerEvents = "auto";
          console.error("Failed to remove item from cart:", data.data || data);
        }
      } catch (e) {
        console.error("Failed to parse JSON response:", e);

        // If we get an HTML response, it might be a redirect or error page
        // Try fallback: reload the page with WooCommerce remove URL
        if (text.includes("<html") || text.includes("<!DOCTYPE")) {
          const removeUrl = `?remove_item=${cartItemKey}&_wpnonce=${nonce}`;
          window.location.href = window.location.pathname + removeUrl;
          return;
        }

        button.style.opacity = "1";
        button.style.pointerEvents = "auto";
      }
    })
    .catch((error) => {
      // Restore button state on error
      button.style.opacity = "1";
      button.style.pointerEvents = "auto";
      console.error("Network error removing item from cart:", error);
    });
}

// Update cart totals (placeholder - would need WooCommerce integration)
function updateCartTotals() {
  // Trigger WooCommerce cart update if jQuery is available
  if (typeof jQuery !== "undefined") {
    jQuery("body").trigger("updated_cart_totals");
  }
}

// Coupon Functionality
function initCouponFunctionality() {
  const couponForm = document.querySelector(".cart-coupon-section");
  const couponInput = document.querySelector(".cart-coupon-input");
  const couponButton = document.querySelector(".cart-coupon-apply-btn");

  if (couponButton && couponInput) {
    couponButton.addEventListener("click", function (e) {
      e.preventDefault();

      const couponCode = couponInput.value.trim();
      if (!couponCode) {
        return;
      }

      // Add loading state
      this.style.opacity = "0.5";
      this.style.pointerEvents = "none";

      applyCoupon(couponCode, this);
    });

    // Handle Enter key in coupon input
    couponInput.addEventListener("keypress", function (e) {
      if (e.key === "Enter") {
        e.preventDefault();
        couponButton.click();
      }
    });
  }
}

function applyCoupon(button) {
  const input = document.querySelector(".cart-coupon-input");
  if (!input || !input.value) return;

  button.disabled = true;

  const form = document.createElement("form");
  form.method = "POST";
  form.action = brazil_cart_ajax.cart_url;

  const couponField = document.createElement("input");
  couponField.type = "hidden";
  couponField.name = "coupon_code";
  couponField.value = input.value;

  const applyField = document.createElement("input");
  applyField.type = "hidden";
  applyField.name = "apply_coupon";
  applyField.value = "1";

  form.appendChild(couponField);
  form.appendChild(applyField);
  document.body.appendChild(form);

  form.submit();
}

// Checkout Page Functionality
function initCheckoutPageFunctionality() {
  // Check if we're on the checkout page (using multiple selectors)
  if (
    !document.querySelector(".checkout-section") &&
    !document.querySelector(".woocommerce-checkout") &&
    !document.querySelector(".finalizar-compra-page") &&
    !document.body.classList.contains("woocommerce-checkout")
  )
    return;

  // Initialize login toggle
  initLoginToggle();

  // Initialize form validation
  initCheckoutFormValidation();

  // Initialize checkout shipping calculator
  initCheckoutShippingCalculator();

  // Reinitialize checkout shipping calculator on AJAX updates
  jQuery(document.body).on("updated_checkout", function () {
    initCheckoutShippingCalculator();
  });
}

// Login Toggle Functionality
function initLoginToggle() {
  const loginToggle = document.querySelector(".login-toggle");
  const loginContainer = document.querySelector(".login-form-container");
  const loginArrow = document.querySelector(".login-arrow");

  if (loginToggle && loginContainer) {
    loginToggle.addEventListener("click", function () {
      const isVisible = loginContainer.style.display !== "none";

      if (isVisible) {
        loginContainer.style.display = "none";
        loginToggle.classList.remove("active");
      } else {
        loginContainer.style.display = "block";
        loginToggle.classList.add("active");
      }
    });
  }
}

// Checkout Form Validation
function initCheckoutFormValidation() {
  const checkoutForm = document.querySelector(".checkout-form");
  const submitButton = document.querySelector(".checkout-submit-btn");

  if (checkoutForm && submitButton) {
    // Add real-time validation
    const requiredFields = checkoutForm.querySelectorAll("[required]");

    requiredFields.forEach((field) => {
      field.addEventListener("blur", function () {
        validateField(this);
      });

      field.addEventListener("input", function () {
        clearFieldError(this);
      });
    });

    // Handle form submission
    submitButton.addEventListener("click", function (e) {
      e.preventDefault();

      const isValid = validateCheckoutForm();
      if (isValid) {
        submitCheckoutForm();
      }
    });
  }
}

// Validate individual field
function validateField(field) {
  const fieldGroup = field.closest(".checkout-field-group");
  if (!fieldGroup) return true;

  // Remove existing error
  clearFieldError(field);

  let isValid = true;
  let errorMessage = "";

  // Check if required field is empty
  if (field.hasAttribute("required") && !field.value.trim()) {
    isValid = false;
    errorMessage = "Este campo é obrigatório.";
  }

  // Email validation
  if (field.type === "email" && field.value.trim()) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(field.value)) {
      isValid = false;
      errorMessage = "Por favor, insira um email válido.";
    }
  }

  // Phone validation (Brazilian format)
  if (field.type === "tel" && field.value.trim()) {
    const phoneRegex = /^[\d\s\(\)\-\+]{10,}$/;
    if (!phoneRegex.test(field.value)) {
      isValid = false;
      errorMessage = "Por favor, insira um telefone válido.";
    }
  }

  // CEP validation (Brazilian postal code)
  if (field.name === "billing_postcode" && field.value.trim()) {
    const cepRegex = /^\d{5}-?\d{3}$/;
    if (!cepRegex.test(field.value)) {
      isValid = false;
      errorMessage = "Por favor, insira um CEP válido (formato: 12345-678).";
    }
  }

  if (!isValid) {
    showFieldError(field, errorMessage);
  }

  return isValid;
}

// Show field error
function showFieldError(field, message) {
  const fieldGroup = field.closest(".checkout-field-group");
  if (!fieldGroup) return;

  // Add error class
  field.classList.add("field-error");

  // Create error message element
  let errorElement = fieldGroup.querySelector(".field-error-message");
  if (!errorElement) {
    errorElement = document.createElement("div");
    errorElement.className = "field-error-message";
    fieldGroup.appendChild(errorElement);
  }

  errorElement.textContent = message;
}

// Clear field error
function clearFieldError(field) {
  const fieldGroup = field.closest(".checkout-field-group");
  if (!fieldGroup) return;

  field.classList.remove("field-error");

  const errorElement = fieldGroup.querySelector(".field-error-message");
  if (errorElement) {
    errorElement.remove();
  }
}

// Validate entire checkout form
function validateCheckoutForm() {
  const checkoutForm = document.querySelector(".checkout-form");
  if (!checkoutForm) return false;

  const requiredFields = checkoutForm.querySelectorAll("[required]");
  let isValid = true;

  requiredFields.forEach((field) => {
    if (!validateField(field)) {
      isValid = false;
    }
  });

  return isValid;
}

// Submit checkout form
function submitCheckoutForm() {
  const submitButton = document.querySelector(".checkout-submit-btn");
  if (!submitButton) return;

  // Add loading state
  const originalText = submitButton.textContent;
  submitButton.textContent = "PROCESSANDO...";
  submitButton.disabled = true;

  // Simulate form submission (replace with actual WooCommerce integration)
  setTimeout(() => {
    // In a real implementation, this would integrate with WooCommerce
    alert("Pedido enviado com sucesso! (Esta é uma simulação)");

    // Restore button
    submitButton.textContent = originalText;
    submitButton.disabled = false;
  }, 2000);
}

// Brazilian Field Formatting
function initBrazilianFieldFormatting() {
  // CPF/CNPJ formatting
  const cpfCnpjInput = document.getElementById("reg_cpf_cnpj");
  if (cpfCnpjInput) {
    cpfCnpjInput.addEventListener("input", function (e) {
      let value = e.target.value.replace(/\D/g, "");

      if (value.length <= 11) {
        // CPF format: 000.000.000-00
        value = value.replace(/(\d{3})(\d)/, "$1.$2");
        value = value.replace(/(\d{3})(\d)/, "$1.$2");
        value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
      } else {
        // CNPJ format: 00.000.000/0000-00
        value = value.replace(/^(\d{2})(\d)/, "$1.$2");
        value = value.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3");
        value = value.replace(/\.(\d{3})(\d)/, ".$1/$2");
        value = value.replace(/(\d{4})(\d)/, "$1-$2");
      }

      e.target.value = value;
    });
  }

  // CEP formatting
  const cepInput = document.getElementById("reg_billing_postcode");
  if (cepInput) {
    cepInput.addEventListener("input", function (e) {
      let value = e.target.value.replace(/\D/g, "");
      if (value.length > 5) {
        value = value.substring(0, 5) + "-" + value.substring(5, 8);
      }
      e.target.value = value;
    });
  }

  // Phone formatting
  const telefoneInput = document.getElementById("reg_billing_phone");
  if (telefoneInput) {
    telefoneInput.addEventListener("input", function (e) {
      let value = e.target.value.replace(/\D/g, "");

      if (value.length <= 10) {
        // Landline: (00) 0000-0000
        value = value.replace(/^(\d{2})(\d)/, "($1) $2");
        value = value.replace(/(\d{4})(\d)/, "$1-$2");
      } else {
        // Mobile: (00) 00000-0000
        value = value.replace(/^(\d{2})(\d)/, "($1) $2");
        value = value.replace(/(\d{5})(\d)/, "$1-$2");
      }

      e.target.value = value;
    });
  }

  // CEP Auto-complete (optional enhancement)
  if (cepInput) {
    cepInput.addEventListener("blur", function (e) {
      const cep = e.target.value.replace(/\D/g, "");
      if (cep.length === 8) {
        fetchAddressByCEP(cep);
      }
    });
  }
}

// Fetch address by CEP (via ViaCEP API)
function fetchAddressByCEP(cep) {
  const enderecoInput = document.getElementById("reg_billing_address_1");
  if (!enderecoInput) return;

  fetch(`https://viacep.com.br/ws/${cep}/json/`)
    .then((response) => response.json())
    .then((data) => {
      if (data && !data.erro) {
        // Auto-fill address if it's empty
        if (!enderecoInput.value) {
          enderecoInput.value = `${data.logradouro}`;
          enderecoInput.focus();
        }
      }
    })
    .catch((error) => {
      console.log("Erro ao buscar CEP:", error);
    });
}

document.addEventListener("DOMContentLoaded", () => {
  // Abre o form
  document.querySelectorAll(".btn-avise-me").forEach((btn) => {
    btn.addEventListener("click", () => {
      const target = document.getElementById(btn.dataset.target);
      if (target) target.style.display = "flex";
    });
  });

  // Fecha o form (botão fechar)
  document.querySelectorAll(".btn-close-avise-me").forEach((btn) => {
    btn.addEventListener("click", () => {
      const wrapper = btn.closest(".avise-me-form-wrapper");
      if (wrapper) wrapper.style.display = "none";
    });
  });

  // Fecha ao clicar fora do conteúdo
  document.querySelectorAll(".avise-me-form-wrapper").forEach((wrapper) => {
    wrapper.addEventListener("click", (e) => {
      // se o clique for exatamente no fundo (e não dentro do conteúdo)
      if (e.target === wrapper) {
        wrapper.style.display = "none";
      }
    });
  });
});

/* REVIEW */

/*************************************************
 * REVIEW MODAL - MERCADO LIVRE STYLE (FINAL PROTEGIDO)
 * Funciona apenas se a estrutura existir na página.
 *************************************************/

document.addEventListener("DOMContentLoaded", () => {
  /* ----------------------------------------------
   * 1. VERIFICA SE O MODAL EXISTE NA PÁGINA
   * ---------------------------------------------- */
  const modal = document.getElementById("reviewModal");
  if (!modal) {
    console.warn("Review modal não encontrado. Script não executado.");
    return;
  }

  /* Fail-safe para garantir abertura */
  const style = document.createElement("style");
  style.innerHTML = `.review-modal.open { display: flex !important; }`;
  document.head.appendChild(style);

  /* ----------------------------------------------
   * 2. ELEMENTOS DO MODAL (ARMAZENAMENTO)
   * ---------------------------------------------- */
  const modalImg = document.getElementById("reviewModalImage");
  const modalAuthor = document.getElementById("reviewModalAuthor");
  const modalRating = document.getElementById("reviewModalRating");
  const modalText = document.getElementById("reviewModalText");
  const modalDate = document.getElementById("reviewModalDate");
  const modalTitle = document.getElementById("reviewModalTitle");
  const modalThumbs = document.getElementById("reviewModalThumbs");
  const modalCounter = document.getElementById("reviewModalCounter");

  const prevBig = document.querySelector(".review-modal-prev");
  const nextBig = document.querySelector(".review-modal-next");
  const thumbsPrev = document.querySelector(".thumbs-prev");
  const thumbsNext = document.querySelector(".thumbs-next");
  const closeBtn = document.querySelector(".review-modal-close");

  /* ----------------------------------------------
   * 3. FUNÇÃO PRINCIPAL DE ABRIR MODAL
   * ---------------------------------------------- */
  function openReviewModal(data, startIndex = 0) {
    if (!data || !data.gallery || data.gallery.length === 0) return;

    const gallery = data.gallery;
    let current = startIndex;

    /* PASSA OS DADOS */
    modalAuthor.textContent = data.author;
    modalText.textContent = data.content;
    modalDate.textContent = data.date;
    modalTitle.textContent = data.title ?? "";

    modalRating.innerHTML = "";

    // força rating como número
    const rating = Number(data.rating) || 0;
    for (let i = 1; i <= 5; i++) {
      modalRating.innerHTML += `<span class="star ${
        i <= data.rating ? "filled" : ""
      }">★</span>`;
    }

    /* MINIATURAS */
    modalThumbs.innerHTML = gallery
      .map(
        (url, i) =>
          `<img src="${url}" class="${
            i === current ? "active" : ""
          }" data-index="${i}">`,
      )
      .join("");

    /* FUNÇÃO DE TROCAR A IMAGEM */
    function loadImage(i) {
      current = i;
      modalImg.src = gallery[i];
      modalCounter.textContent = `${i + 1} / ${gallery.length}`;

      [...modalThumbs.children].forEach((el, idx) => {
        el.classList.toggle("active", idx === i);
      });
    }

    /* CLICK NAS MINIATURAS INTERNAS */
    modalThumbs.onclick = (ev) => {
      if (ev.target.dataset.index) {
        loadImage(parseInt(ev.target.dataset.index));
      }
    };

    /* ===== SETAS GRANDES (IMAGEM PRINCIPAL) ===== */
    const prevBig = document.querySelector(".review-modal-prev");
    const nextBig = document.querySelector(".review-modal-next");

    prevBig.onclick = () => {
      if (current > 0) {
        loadImage(current - 1);
      }
    };

    nextBig.onclick = () => {
      if (current < gallery.length - 1) {
        loadImage(current + 1);
      }
    };

    /* FECHAR MODAL NO BOTÃO */
    closeBtn.onclick = () => modal.classList.remove("open");

    /* FECHAR CLICANDO FORA */
    modal.onclick = (ev) => {
      if (ev.target === modal) modal.classList.remove("open");
    };

    /* MOSTRA A PRIMEIRA IMAGEM */
    loadImage(current);

    /* ABRE */
    modal.classList.add("open");
  }

  /* ----------------------------------------------
   * 4. EVENTO GLOBAL DE CLIQUE (CARD + MINIATURA)
   * ---------------------------------------------- */
  document.addEventListener("click", function (e) {
    /* ==== CLICK NO CARD INTEIRO ==== */
    const card = e.target.closest(".review-card");

    if (card) {
      const hasGallery = card.dataset.hasGallery === "1";
      if (!hasGallery) return;

      let data;
      try {
        data = JSON.parse(card.dataset.review);
      } catch (err) {
        console.error("Erro JSON no CARD:", err);
        return;
      }

      openReviewModal(data, 0);
      return;
    }

    /* ==== CLICK NA MINIATURA ==== */
    const thumb = e.target.closest(".review-thumb");

    if (thumb) {
      let data;
      try {
        data = JSON.parse(thumb.dataset.review);
      } catch (err) {
        console.error("Erro JSON na THUMB:", err);
        return;
      }

      const index = parseInt(thumb.dataset.index);
      openReviewModal(data, index);
      return;
    }
  });
});
