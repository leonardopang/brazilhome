// Product Details Page JavaScript

document.addEventListener("DOMContentLoaded", function () {
  // Quantity controls run first and each init is isolated so a failure in one
  // (e.g. the Slick gallery) can't abort the rest of the callback and leave
  // the +/- buttons unwired.
  const inits = [
    initProductQuantityControls,
    initProductGallery,
    initProductTabs,
    initCEPCalculator,
    initProductActions,
    initFAQAccordion,
    initReviewsSection,
  ];

  inits.forEach((initFn) => {
    try {
      initFn();
    } catch (error) {
      console.error(`Error running ${initFn.name}:`, error);
    }
  });
});

// Product Gallery Functionality with Slick Carousel
function initProductGallery() {
  const $mainSlider = jQuery(".main-image");
  const $thumbnailSlider = jQuery(".thumbnail-gallery");

  if ($mainSlider.length === 0 || $thumbnailSlider.length === 0) {
    return;
  }

  $mainSlider.slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    fade: true,
    draggable: true,
    asNavFor: ".thumbnail-gallery",
    prevArrow:
      '<button type="button" class="slick-prev main-image-arrow arrow-prev"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 12L6 8L10 4" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>',
    nextArrow:
      '<button type="button" class="slick-next main-image-arrow arrow-next"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 4L10 8L6 12" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>',
    adaptiveHeight: false,
    responsive: [
      {
        breakpoint: 768,
        settings: {
          arrows: true,
          fade: true,
        },
      },
    ],
  });

  const isDesktop = !("ontouchstart" in window);

  if (isDesktop) {
    const mainSliderEl = document.querySelector(".main-image");

    if (mainSliderEl) {
      mainSliderEl.style.cursor = "grab";
      mainSliderEl.style.userSelect = "none";
      mainSliderEl.style.webkitUserDrag = "none";

      mainSliderEl.addEventListener("mousedown", () => {
        mainSliderEl.style.cursor = "grabbing";
      });

      window.addEventListener("mouseup", () => {
        mainSliderEl.style.cursor = "grab";
      });
    }
  }

  $thumbnailSlider.slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    asNavFor: ".main-image",
    draggable: true,
    dots: false,
    centerMode: false,
    focusOnSelect: true,
    appendArrows: ".gallery-carousel-container",
    prevArrow:
      '<button type="button" class="slick-prev carousel-arrow arrow-left"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 12L6 8L10 4" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>',
    nextArrow:
      '<button type="button" class="slick-next carousel-arrow arrow-right"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 4L10 8L6 12" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>',
    responsive: [
      {
        breakpoint: 1024,
        settings: { slidesToShow: 3 },
      },
      {
        breakpoint: 768,
        settings: { slidesToShow: 4, arrows: true },
      },
      {
        breakpoint: 480,
        settings: { slidesToShow: 3, arrows: true },
      },
    ],
  });

  const totalSlides = $mainSlider.slick("getSlick").slideCount;

  if (totalSlides > 1) {
    const imageCounter = jQuery(
      '<div class="image-counter"><span class="current-image">1</span> / <span class="total-images">' +
        totalSlides +
        "</span></div>",
    );
    $mainSlider.append(imageCounter);

    $mainSlider.on("afterChange", function (event, slick, currentSlide) {
      jQuery(".current-image").text(currentSlide + 1);
    });
  }

  initImageModal();

  function initImageModal() {
    const totalSlides = $mainSlider.slick("getSlick").slideCount;

    const modal = document.createElement("div");
    modal.id = "imageModal";
    modal.className = "image-modal";
    modal.style.display = "none";
    modal.innerHTML = `
      <div class="modal-overlay"></div>
      <div class="modal-content">
        <button class="modal-close">&times;</button>
        <button class="modal-nav modal-prev">❮</button>
        <div class="modal-image-container">
          <img id="modalImage" alt="" />
          <div class="modal-counter">
            <span class="modal-current">1</span> / <span class="modal-total">${totalSlides}</span>
          </div>
        </div>
        <button class="modal-nav modal-next">❯</button>
      </div>
    `;
    document.body.appendChild(modal);

    const modalOverlay = modal.querySelector(".modal-overlay");
    const modalClose = modal.querySelector(".modal-close");
    const modalPrev = modal.querySelector(".modal-prev");
    const modalNext = modal.querySelector(".modal-next");
    const modalImage = modal.querySelector("#modalImage");
    const modalCurrent = modal.querySelector(".modal-current");

    $mainSlider.on("click", "img", function () {
      const currentSlide = $mainSlider.slick("slickCurrentSlide");
      openModal(currentSlide);
    });

    function openModal(index) {
      updateModalImage(index);
      modal.style.display = "flex";
      document.body.style.overflow = "hidden";
      modalClose.focus();
    }

    function closeModal() {
      modal.style.display = "none";
      document.body.style.overflow = "";
    }

    function updateModalImage(index) {
      const $currentSlide = jQuery(
        $mainSlider.slick("getSlick").$slides[index],
      );
      const $img = $currentSlide.find("img");
      const imageSrc = $img.attr("src");

      modalImage.src = imageSrc;
      modalImage.alt = $img.attr("alt") || `Product image ${index + 1}`;
      modalCurrent.textContent = index + 1;
    }

    function modalPreviousImage() {
      const currentSlide = $mainSlider.slick("slickCurrentSlide");
      const newSlide = currentSlide > 0 ? currentSlide - 1 : totalSlides - 1;
      $mainSlider.slick("slickGoTo", newSlide);
      updateModalImage(newSlide);
    }

    function modalNextImage() {
      const currentSlide = $mainSlider.slick("slickCurrentSlide");
      const newSlide = currentSlide < totalSlides - 1 ? currentSlide + 1 : 0;
      $mainSlider.slick("slickGoTo", newSlide);
      updateModalImage(newSlide);
    }

    modalClose.addEventListener("click", closeModal);
    modalOverlay.addEventListener("click", closeModal);
    modalPrev.addEventListener("click", modalPreviousImage);
    modalNext.addEventListener("click", modalNextImage);

    document.addEventListener("keydown", (e) => {
      if (modal.style.display === "flex") {
        if (e.key === "Escape") closeModal();
        if (e.key === "ArrowLeft") modalPreviousImage();
        if (e.key === "ArrowRight") modalNextImage();
      }
    });

    let isDragging = false;
    let startX = 0;
    let currentX = 0;
    const dragThreshold = 60;
    const isDesktop = !("ontouchstart" in window);

    if (isDesktop) {
      modalImage.style.cursor = "grab";
      modalImage.style.userSelect = "none";
      modalImage.style.webkitUserDrag = "none";
    }

    function startDrag(e) {
      if (e.type === "mousedown" && e.button !== 0) return;
      isDragging = true;
      startX = e.type.includes("mouse") ? e.clientX : e.touches[0].clientX;
      modalImage.style.transition = "none";
      if (isDesktop) modalImage.style.cursor = "grabbing";
    }

    function moveDrag(e) {
      if (!isDragging) return;
      currentX = e.type.includes("mouse") ? e.clientX : e.touches[0].clientX;
      const delta = currentX - startX;
      modalImage.style.transform = `translateX(${delta}px)`;
    }

    function endDrag() {
      if (!isDragging) return;
      isDragging = false;
      const delta = currentX - startX;
      modalImage.style.transition = "transform 0.25s ease";

      if (delta > dragThreshold) {
        modalPreviousImage();
      } else if (delta < -dragThreshold) {
        modalNextImage();
      }

      modalImage.style.transform = "translateX(0)";
      if (isDesktop) modalImage.style.cursor = "grab";
    }

    modalImage.addEventListener("touchstart", startDrag);
    modalImage.addEventListener("touchmove", moveDrag);
    modalImage.addEventListener("touchend", endDrag);

    modalImage.addEventListener("mousedown", startDrag);
    window.addEventListener("mousemove", moveDrag);
    window.addEventListener("mouseup", endDrag);

    modalImage.addEventListener("dragstart", (e) => e.preventDefault());
  }
}

// Product Tabs Functionality
function initProductTabs() {
  const tabButtons = document.querySelectorAll(".tab-button");
  const tabPanels = document.querySelectorAll(".tab-panel");

  tabButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const targetTab = button.dataset.tab;

      // Remove active class from all buttons and panels
      tabButtons.forEach((btn) => btn.classList.remove("active"));
      tabPanels.forEach((panel) => panel.classList.remove("active"));

      // Add active class to clicked button and corresponding panel
      button.classList.add("active");
      const targetPanel = document.getElementById(targetTab);
      if (targetPanel) {
        targetPanel.classList.add("active");
      }

      // Smooth scroll to tabs section
      const tabsSection = document.querySelector(".product-tabs-section");
      if (tabsSection) {
        tabsSection.scrollIntoView({
          behavior: "smooth",
          block: "start",
        });
      }
    });
  });
}

// Quantity Controls
function initProductQuantityControls() {
  const quantityInput = document.querySelector(".quantity-input");
  const decreaseBtn = document.querySelector(".quantity-decrease");
  const increaseBtn = document.querySelector(".quantity-increase");

  if (quantityInput && decreaseBtn && increaseBtn) {
    decreaseBtn.addEventListener("click", () => {
      let currentValue = parseInt(quantityInput.value) || 1;
      if (currentValue > 1) {
        quantityInput.value = currentValue - 1;
        updateQuantityDisplay();
        syncWooCommerceQuantity();
      }
    });

    increaseBtn.addEventListener("click", () => {
      let currentValue = parseInt(quantityInput.value) || 1;
      const maxValue = parseInt(quantityInput.max);
      // Handle unlimited quantity (maxValue = -1) or set reasonable limit
      const effectiveMax = maxValue === -1 || isNaN(maxValue) ? 999 : maxValue;
      if (currentValue < effectiveMax) {
        quantityInput.value = currentValue + 1;
        updateQuantityDisplay();
        syncWooCommerceQuantity();
      }
    });

    quantityInput.addEventListener("input", () => {
      validateQuantityInput();
      updateQuantityDisplay();
      syncWooCommerceQuantity();
    });

    quantityInput.addEventListener("blur", () => {
      validateQuantityInput();
      syncWooCommerceQuantity();
    });
  }
}

function validateQuantityInput() {
  const quantityInput = document.querySelector(".quantity-input");
  if (!quantityInput) return;

  let value = parseInt(quantityInput.value);
  const min = parseInt(quantityInput.min) || 1;
  const maxValue = parseInt(quantityInput.max);
  // Handle unlimited quantity (maxValue = -1) or set reasonable limit
  const max = maxValue === -1 || isNaN(maxValue) ? 999 : maxValue;

  if (isNaN(value) || value < min) {
    quantityInput.value = min;
  } else if (value > max) {
    quantityInput.value = max;
  }
}

function updateQuantityDisplay() {
  const quantityInput = document.querySelector(".quantity-input");
  if (!quantityInput) return;

  const quantity = parseInt(quantityInput.value) || 1;

  // You can add price calculations here if needed
  updateTotalPrice(quantity);
}

function updateTotalPrice(quantity) {
  // This would update total price based on quantity
  // Implementation depends on your pricing structure
}

function syncWooCommerceQuantity() {
  const quantityInput = document.querySelector(".quantity-input");
  const hiddenQuantity = document.querySelector('input[name="quantity"].qty');

  if (quantityInput && hiddenQuantity) {
    hiddenQuantity.value = quantityInput.value;
  }
}

// CEP Calculator
function initCEPCalculator() {
  const cepInput = document.querySelector(".cep-input");
  const cepButton = document.querySelector(".cep-button");

  if (cepInput) {
    // Format CEP input
    cepInput.addEventListener("input", (e) => {
      let value = e.target.value.replace(/\D/g, "");

      // Apply CEP mask (00000-000)
      if (value.length <= 8) {
        value = value.replace(/(\d{5})(\d{3})/, "$1-$2");
      }

      e.target.value = value;
    });

    cepInput.addEventListener("keypress", (e) => {
      // Only allow numbers, backspace, and delete
      const allowedKeys = ["Backspace", "Delete", "Tab", "Escape", "Enter"];
      if (allowedKeys.includes(e.key) || /\d/.test(e.key)) {
        return;
      }
      e.preventDefault();
    });
  }

  if (cepButton) {
    if (!cepButton.dataset.init) {
      cepButton.dataset.init = "true";

      cepButton.addEventListener("click", () => {
        window.calculateShipping();
      });
    }
  }

  if (cepInput) {
    cepInput.addEventListener("keypress", (e) => {
      if (e.key === "Enter") {
        e.preventDefault();
        if (!window.__shippingRunning) {
          window.calculateShipping();
        }
      }
    });
  }
}

// Make calculateShipping globally accessible
window.calculateShipping = async function () {
  if (window.__shippingRunning) return;
  const cepInput = document.querySelector(".cep-input");
  const cepButton = document.querySelector(".cep-button");

  if (!cepInput || !cepButton) return;

  const cep = cepInput.value.replace(/\D/g, "");

  // Store original button text only if it's not already in loading state
  const originalText =
    cepButton.textContent === "Calculando..."
      ? "Calcular"
      : cepButton.textContent;

  // Validate CEP
  if (cep.length !== 8) {
    showShippingError("CEP deve ter 8 dígitos");
    return;
  }

  // Only mark the run as in-progress once we're actually about to run it —
  // an early return above (invalid CEP) must never leave this stuck at
  // true, or every future click/Enter is silently ignored.
  window.__shippingRunning = true;

  // Show loading state
  cepButton.textContent = "CALCULANDO...";
  cepButton.disabled = true;

  try {
    // Calculate shipping using WooCommerce
    const result = await simulateShippingCalculation(cep);
    showShippingResult(result);

    // Store CEP in cookie for 7 days to persist to cart
    const expiryDate = new Date();
    expiryDate.setDate(expiryDate.getDate() + 7);
    document.cookie = `brazil_home_cep=${cep}; expires=${expiryDate.toUTCString()}; path=/`;
  } catch (error) {
    console.error("Shipping calculation error:", error);
    showShippingError("Erro ao calcular frete. Tente novamente.");
  } finally {
    // Always restore button state
    cepButton.textContent = originalText;
    cepButton.disabled = false;
    window.__shippingRunning = false;
  }
};

// Calculate shipping using WooCommerce and WC Table Shipping
async function simulateShippingCalculation(cep) {
  const productId = getProductId();
  const quantity = getProductQuantity();

  if (!productId) {
    throw new Error("Product ID not found");
  }

  // garante que temos nonce válido
  if (!window.brazilHomeShipping || !brazilHomeShipping.nonce) {
    await refreshShippingNonce();
  }

  try {
    return await doShippingRequest({
      cep,
      productId,
      quantity,
      nonce: brazilHomeShipping.nonce,
    });
  } catch (err) {
    // se o nonce expirou, renova e tenta 1x
    if (
      String(err.message || "")
        .toLowerCase()
        .includes("nonce")
    ) {
      await refreshShippingNonce();

      return await doShippingRequest({
        cep,
        productId,
        quantity,
        nonce: brazilHomeShipping.nonce,
      });
    }

    throw err;
  }
}

async function doShippingRequest({ cep, productId, quantity, nonce }) {
  if (window.__shippingFetching) {
    throw new Error("Requisição já em andamento");
  }

  window.__shippingFetching = true;

  try {
    const formData = new FormData();
    formData.append("action", "calculate_shipping_for_product");
    formData.append("product_id", productId);
    formData.append("quantity", quantity);
    formData.append("postcode", cep);
    formData.append("country", "BR");
    formData.append("nonce", nonce);

    const resp = await fetch(brazilHomeShipping.ajax_url, {
      method: "POST",
      body: formData,
      credentials: "same-origin",
    });

    if (!resp.ok) {
      throw new Error("Erro HTTP: " + resp.status);
    }

    let data;

    try {
      data = await resp.json();
    } catch (e) {
      throw new Error("Resposta inválida do servidor");
    }

    if (!data || !data.success) {
      throw new Error(data?.data || "Erro ao calcular frete");
    }

    return {
      options: data.data.shipping_methods || [],
    };
  } finally {
    window.__shippingFetching = false;
  }
}

async function refreshShippingNonce() {
  const fd = new FormData();
  fd.append("action", "get_shipping_nonce");

  const resp = await fetch(brazilHomeShipping.ajax_url, {
    method: "POST",
    body: fd,
    credentials: "same-origin",
  });

  const data = await resp.json();

  if (!data?.success || !data?.data?.nonce) {
    throw new Error("Não foi possível renovar o nonce do frete");
  }

  brazilHomeShipping.nonce = data.data.nonce;
}

// Helper functions
function getProductId() {
  // Try to get product ID from various sources
  const productForm = document.querySelector("form.cart");
  if (productForm) {
    const productIdInput = productForm.querySelector(
      'button[name="add-to-cart"]',
    );
    if (productIdInput) {
      return productIdInput.value;
    }
  }

  // Try to get from data attribute or global variable
  if (
    typeof wc_single_product_params !== "undefined" &&
    wc_single_product_params.product_id
  ) {
    return wc_single_product_params.product_id;
  }

  // Try to get from body class
  const bodyClasses = document.body.className;
  const match = bodyClasses.match(/postid-(\d+)/);
  if (match) {
    return match[1];
  }

  return null;
}

function getProductQuantity() {
  const quantityInput = document.querySelector(
    '.quantity-input, input[name="quantity"]',
  );
  return quantityInput ? parseInt(quantityInput.value) || 1 : 1;
}

function showShippingResult(result) {
  // Remove existing results
  removeShippingMessage();

  const resultsContainer = document.getElementById("cep-results");
  if (!resultsContainer) return;

  let resultHTML = "<h4>Opções de entrega:</h4>";
  result.options.forEach((option) => {
    // Handle both old format and new WC Table Shipping format
    const name = option.name || option.label || "Frete";
    const days = option.days || "Consulte prazo";
    const price =
      option.price ||
      (option.cost
        ? `R$ ${parseFloat(option.cost).toFixed(2).replace(".", ",")}`
        : "Consulte");

    let textoCorrigido = name.replace(/(\d+)\s+dias úteis/, (match, numero) => {
      return numero === "1" ? `${numero} dia útil` : `${numero} dias úteis`;
    });

    resultHTML += `
            <div class="shipping-option">
                <span class="shipping-name">${textoCorrigido}</span>
            </div>
        `;
  });

  resultsContainer.innerHTML = resultHTML;
  resultsContainer.style.display = "block";
}

function showShippingError(message) {
  removeShippingMessage();

  const resultsContainer = document.getElementById("cep-results");
  if (!resultsContainer) return;

  resultsContainer.innerHTML = `<div class="shipping-error">${message}</div>`;
  resultsContainer.style.display = "block";
}

function removeShippingMessage() {
  const resultsContainer = document.getElementById("cep-results");
  if (resultsContainer) {
    resultsContainer.innerHTML = "";
    resultsContainer.style.display = "none";
  }
}

// Product Actions
function initProductActions() {
  // Just ensure quantity is synced initially
  syncWooCommerceQuantity();

  // Debug: Check if button exists and has correct attributes
  const addToCartBtn = document.querySelector(".btn-add-cart");
  const cartForm = document.querySelector("form.cart");

  if (addToCartBtn && cartForm) {
    // Remove any existing event listeners that might interfere
    const newBtn = addToCartBtn.cloneNode(true);
    addToCartBtn.parentNode.replaceChild(newBtn, addToCartBtn);
  }
}

// FAQ Accordion (reuse from category page)
function initFAQAccordion() {
  const faqItems = document.querySelectorAll(".faq-item");

  faqItems.forEach((item) => {
    const question = item.querySelector(".faq-question");

    question.addEventListener("click", () => {
      const isActive = item.classList.contains("active");

      // Close all other FAQ items
      faqItems.forEach((otherItem) => {
        if (otherItem !== item) {
          otherItem.classList.remove("active");
        }
      });

      // Toggle current item
      if (isActive) {
        item.classList.remove("active");
      } else {
        item.classList.add("active");
      }
    });
  });
}

// Reviews Section
function initReviewsSection() {
  const loadMoreBtn = document.querySelector(".btn-load-more");
  const writeReviewBtn = document.querySelector(".btn-write-review");

  if (loadMoreBtn) {
    loadMoreBtn.addEventListener("click", () => {
      loadMoreReviews();
    });
  }

  if (writeReviewBtn) {
    writeReviewBtn.addEventListener("click", () => {
      openReviewModal();
    });
  }

  // Add rating functionality to Compare tab
  initRatingLogic();
}

function loadMoreReviews() {
  const loadMoreBtn = document.querySelector(".btn-load-more");
  const reviewsGrid = document.querySelector(".reviews-grid");

  if (!loadMoreBtn || !reviewsGrid) return;

  // Show loading state
  loadMoreBtn.textContent = "CARREGANDO...";
  loadMoreBtn.disabled = true;

  // Simulate loading more reviews
  setTimeout(() => {
    // Add more review cards (placeholder)
    const newReviews = createMoreReviewCards();
    newReviews.forEach((review) => {
      reviewsGrid.appendChild(review);
    });

    // Reset button
    loadMoreBtn.textContent = "CARREGAR MAIS AVALIAÇÕES";
    loadMoreBtn.disabled = false;

    // Hide button if no more reviews
    loadMoreBtn.style.display = "none";
  }, 1500);
}

function createMoreReviewCards() {
  // This would typically fetch from an API
  const reviewsData = [
    {
      name: "MARIA SILVA",
      rating: 4,
      text: "Produto de excelente qualidade. Recomendo!",
      date: "15.01.2023",
    },
    {
      name: "JOÃO SANTOS",
      rating: 5,
      text: "Muito bom, chegou rápido e bem embalado.",
      date: "20.01.2023",
    },
  ];

  return reviewsData.map((review) => createReviewCard(review));
}

function createReviewCard(reviewData) {
  const card = document.createElement("div");
  card.className = "review-card";

  const stars =
    "★".repeat(reviewData.rating) + "☆".repeat(5 - reviewData.rating);

  card.innerHTML = `
        <div class="review-header">
            <h3 class="reviewer-name">${reviewData.name}</h3>
            <div class="rating">
                ${stars
                  .split("")
                  .map(
                    (star) =>
                      `<span class="star ${
                        star === "★" ? "filled" : ""
                      }">${star}</span>`,
                  )
                  .join("")}
            </div>
        </div>
        <p class="review-text">${reviewData.text}</p>
        <span class="review-date">${reviewData.date}</span>
    `;

  return card;
}

function initRatingLogic() {
  // Handle Compare tab click to show rating option
  const compareTab = document.querySelector('[data-tab="reviews"]');

  if (compareTab) {
    compareTab.addEventListener("click", () => {
      setTimeout(() => {
        // Check if reviews are enabled and show rating prompt
        const reviewForm = document.getElementById("respond");
        const reviewsPanel = document.getElementById("reviews");

        if (reviewsPanel && reviewsPanel.classList.contains("active")) {
          // Add a subtle rating prompt at the top of reviews section
          addRatingPrompt(reviewsPanel, reviewForm);
        }
      }, 300); // Wait for tab transition
    });
  }
}

function addRatingPrompt(reviewsPanel, reviewForm) {
  // Check if prompt already exists
  if (reviewsPanel.querySelector(".rating-prompt")) return;

  // Create rating prompt element
  const ratingPrompt = document.createElement("div");
  ratingPrompt.className = "rating-prompt";
  ratingPrompt.innerHTML = `
        <button class="btn-rate-product" onclick="scrollToReviewForm()">
            ⭐ AVALIAR PRODUTO
        </button>
    `;

  // Insert at the beginning of reviews content
  const reviewsContent = reviewsPanel.querySelector(".reviews-content");
  if (reviewsContent) {
    reviewsContent.insertBefore(ratingPrompt, reviewsContent.firstChild);
  }
}

// Global function to scroll to review form
window.scrollToReviewForm = function () {
  const reviewForm = document.getElementById("respond");
  if (reviewForm) {
    reviewForm.scrollIntoView({ behavior: "smooth", block: "start" });

    // Focus on comment textarea if available
    setTimeout(() => {
      const textarea = reviewForm.querySelector("#comment");
      if (textarea) {
        textarea.focus();
      }
    }, 500);
  } else {
    // If no review form, show info
    alert(
      "Para avaliar este produto, você precisa estar logado e ter comprado o produto.",
    );
  }
};

function openReviewModal() {
  // Scroll to review form instead of showing alert
  window.scrollToReviewForm();
}

// Add styles for notifications, shipping results, and gallery slider
const productDetailsStyles = `
    .cart-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background: #10b981;
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        transform: translateX(100%);
        transition: transform 0.3s ease;
        z-index: 10000;
    }

    .cart-notification.show {
        transform: translateX(0);
    }

    .notification-content {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .notification-icon {
        font-size: 1.2rem;
        font-weight: bold;
    }

    .shipping-result {
        margin-top: 1rem;
        padding: 1rem;
        background: #f0f9ff;
        border: 1px solid #0ea5e9;
        border-radius: 8px;
    }

    .shipping-result h4 {
        margin: 0 0 0.8rem 0;
        color: #0c4a6e;
        font-size: 0.9rem;
    }

    .shipping-option {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        border-bottom: 1px solid #bae6fd;
    }

    .shipping-option:last-child {
        border-bottom: none;
    }

    .shipping-name {
        font-weight: 600;
        color: #0c4a6e;
    }

    .shipping-days {
        color: #64748b;
        font-size: 0.9rem;
    }

    .shipping-price {
        font-weight: bold;
        color: #059669;
    }

    .shipping-error {
        margin-top: 0.5rem;
        padding: 0.8rem;
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
        border-radius: 6px;
        font-size: 0.9rem;
    }

    /* Main Image Slider Styles */
    .main-image {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
    }

    .slider-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: #0264C0;
        border: none;
        color: #fff;
        font-size: 1.5rem;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
        z-index: 10;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .slider-nav:hover {
        background: #1C4067;
    }

    .slider-prev {
        left: 15px;
    }

    .slider-next {
        right: 15px;
    }

    .image-counter {
        position: absolute;
        bottom: 15px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* Thumbnail Carousel Styles */
    .thumbnail-carousel-container {
        position: relative;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .thumbnail-carousel-track {
        display: flex;
        gap: 10px;
        transition: transform 0.3s ease;
        flex: 1;
        overflow: hidden;
        padding-top:10px;
    }

    .thumbnail-nav {
        background-color: #0264C0;
        border: 1px solid rgba(0, 0, 0, 0.2);
        color: #fff;
        font-size: 1.2rem;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        z-index:1;
    }

    .thumbnail-nav:hover:not(:disabled) {
        background: #1C4067;
    }

    .thumbnail-nav:disabled {
        opacity: 0.3;
        cursor: not-allowed;
    }

    .thumbnail-carousel-track .thumbnail {
        flex-shrink: 0;
        min-width: 80px;
        /* Width will be set dynamically by JavaScript */
    }

    /* Enhanced Thumbnail Styles */
    .thumbnail {
        position: relative;
        border: 2px solid transparent;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .thumbnail:hover {
        border-color: #ddd;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .thumbnail.active {
        border-color: #0264C0;
        box-shadow: 0 0 0 1px #0264C0;
    }

    .thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .thumbnail:hover img {
        transform: scale(1.05);
    }

    /* Tablet Responsive */
    @media (max-width: 1024px) {
       

        .thumbnail-carousel-container {
            gap: 8px;
        }
    }

    /* Mobile Responsive - No Carousel */
    @media (max-width: 768px) {
        .slider-nav {
            width: 35px;
            height: 35px;
            font-size: 1.2rem;
        }

        .slider-prev {
            left: 10px;
        }

        .slider-next {
            right: 10px;
        }

        .image-counter {
            bottom: 10px;
            font-size: 0.8rem;
            padding: 4px 10px;
        }

        /* Mobile thumbnail gallery - simple grid without carousel */
        .thumbnail-gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }

        .thumbnail-gallery .thumbnail {
           flex: none;
            max-width: 60px;
            width: auto;
        
        }

        /* Hide carousel components on mobile */
        .thumbnail-carousel-container {
            display: none;
        }
    }

    /* Small Mobile Responsive */
    @media (max-width: 480px) {
        .slider-nav {
            width: 30px;
            height: 30px;
            font-size: 1rem;
        }

        .slider-prev {
            left: 8px;
        }

        .slider-next {
            right: 8px;
        }

        /* Smaller gap and thumbnails on very small screens */
        .thumbnail-gallery {
        }

        .thumbnail-gallery .thumbnail {
            flex: none;
            max-width: 60px;
            width: auto;
        }
    }

        .modal-nav {
            width: 30px;
            height: 30px;
            font-size: 1rem;
        }

        .modal-close {
            top: 10px;
            right: 10px;
            width: 30px;
            height: 30px;
            font-size: 1.5rem;
        }

        .modal-counter {
            bottom: 10px;
            font-size: 0.8rem;
            padding: 4px 10px;
        }
    }

    /* Image Modal Styles */
    .image-modal {
        display: none;
        position: fixed;
        top: 0px;
        left: 0px;
        width: 100%;
        height: 100vh;
        z-index: 10000;
        align-items: center;
        justify-content: center;
    }

    .modal-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        cursor: pointer;
    }

    .modal-content {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 90%;
        height: 90%;
        max-width: 1200px;
        max-height: 800px;
    }

    .modal-image-container {
        position: relative;
        flex: 1;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-image-container img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    }

    .modal-close {
        position: absolute;
        top: 20px;
        right: 20px;
        background: rgba(255, 255, 255, 0.9);
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        font-size: 2rem;
        font-weight: bold;
        cursor: pointer;
        z-index: 10001;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #333;
    }

    .modal-close:hover {
        background: rgba(255, 255, 255, 1);
        transform: scale(1.1);
    }

    .modal-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.9);
        border: none;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        font-size: 1.5rem;
        font-weight: bold;
        cursor: pointer;
        z-index: 10001;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #333;
    }

    .modal-nav:hover {
        background: rgba(255, 255, 255, 1);
        transform: translateY(-50%) scale(1.1);
    }

    .modal-prev {
        left: 20px;
    }

    .modal-next {
        right: 20px;
    }

    .modal-counter {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(255, 255, 255, 0.9);
        color: #333;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 1rem;
        font-weight: 600;
        backdrop-filter: blur(10px);
    }

    /* Main image cursor pointer - Desktop only */
    @media (min-width: 769px) {
        #mainProductImage {
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        #mainProductImage:hover {
            transform: scale(1.02);
        }
    }

    /* Mobile - no hover effects or pointer cursor */
    @media (max-width: 768px) {
        #mainProductImage {
            cursor: default;
            transition: none;
        }
    }
`;

// Inject additional styles (only if not already injected)
if (!document.getElementById("product-details-styles")) {
  const styleSheet = document.createElement("style");
  styleSheet.id = "product-details-styles";
  styleSheet.textContent = productDetailsStyles;
  document.head.appendChild(styleSheet);
}
