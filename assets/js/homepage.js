// Homepage JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // initHeroSlider(); // Disabled - using Slick carousel instead
    initFeaturedProducts();
    initNewsletterForm();
    initBrandAnimations();
    initScrollAnimations();
    initBrandsCarousel();
    initServiceFeaturesCarousel();
    // Mobile menu is handled in main.js
});

// Hero Slider Functionality
function initHeroSlider() {
    const heroSlides = document.querySelectorAll('.hero-slide');
    const heroDots = document.querySelectorAll('.hero-dot');
    const heroButton = document.querySelector('.hero-cta-button');
    
    let currentSlide = 0;
    const totalSlides = heroSlides.length;
    
    // If there's only one slide or no slides, don't initialize slider
    if (totalSlides <= 1) return;
    
    // Handle dot clicks
    heroDots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            goToSlide(index);
        });
    });
    
    // Handle CTA button click
    if (heroButton) {
        heroButton.addEventListener('click', () => {
            // Scroll to featured products or handle CTA action
            const featuredSection = document.querySelector('.featured-products-section');
            if (featuredSection) {
                featuredSection.scrollIntoView({ 
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    }
    
    function goToSlide(slideIndex) {
        // Remove active class from current slide and dot
        heroSlides[currentSlide].classList.remove('active');
        heroDots[currentSlide]?.classList?.remove('active');
        
        // Update current slide
        currentSlide = slideIndex;
        
        // Add active class to new slide and dot
        heroSlides[currentSlide].classList.add('active');
        heroDots[currentSlide].classList.add('active');
    }
    
    // Auto-slide functionality
    function nextSlide() {
        const nextIndex = (currentSlide + 1) % totalSlides;
        goToSlide(nextIndex);
    }
    
    // Start auto-slider
    let autoSlideInterval = setInterval(nextSlide, 6000);
    
    // Pause auto-slide on hover
    const heroSection = document.querySelector('.hero-section');
    if (heroSection) {
        heroSection.addEventListener('mouseenter', () => {
            clearInterval(autoSlideInterval);
        });
        
        heroSection.addEventListener('mouseleave', () => {
            autoSlideInterval = setInterval(nextSlide, 6000);
        });
    }
    
    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
            const prevIndex = currentSlide === 0 ? totalSlides - 1 : currentSlide - 1;
            goToSlide(prevIndex);
        } else if (e.key === 'ArrowRight') {
            nextSlide();
        }
    });
}

// Featured Products Functionality
function initFeaturedProducts() {
    const productCards = document.querySelectorAll('.featured-product-card');
    const buyButtons = document.querySelectorAll('.featured-product-card .btn-buy');
    
    // Product card interactions
    productCards.forEach(card => {
        // Add click handler to navigate to product details
        card.addEventListener('click', (e) => {
            // Don't navigate if clicking on buy button, form, or already on a link
            if (e.target.classList.contains('product-btn-buy') || 
                e.target.closest('.product-btn-buy') ||
                e.target.classList.contains('product-link') ||
                e.target.closest('.product-link') ||
                e.target.closest('form')) {
                return;
            }
            
            // For WooCommerce products, use the data attribute
            const productUrl = card.getAttribute('data-product-url');
            if (productUrl) {
                window.location.href = productUrl;
            } else {
                // Fallback to product details page for static content
                window.location.href = 'pages/detalhes.html';
            }
        });
        
        // Add hover cursor
        card.addEventListener('mouseenter', () => {
            card.style.cursor = 'pointer';
        });
    });
    
    // Buy button functionality - handle both WooCommerce and static buttons
    const allBuyButtons = document.querySelectorAll('.product-btn-buy');
    allBuyButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.stopPropagation(); // Prevent card click
            
            // Check if this is a WooCommerce AJAX add to cart button
            if (button.classList.contains('ajax_add_to_cart')) {
                handleWooCommerceAddToCart(button, e);
            } else {
                // Handle static/demo products
                handleQuickPurchase(button);
            }
        });
    });
}

function handleWooCommerceAddToCart(button, e) {
    e.preventDefault();
    
    const productId = button.getAttribute('data-product_id');
    const productCard = button.closest('.featured-product-card');
    const productTitle = productCard.querySelector('.product-title')?.textContent || 'Produto';
    
    // Add loading state
    const originalText = button.textContent;
    button.textContent = 'ADICIONANDO...';
    button.disabled = true;
    button.style.backgroundColor = '#6b7280';
    
    // Use WooCommerce's built-in AJAX add to cart
    const formData = new FormData();
    formData.append('add-to-cart', productId);
    formData.append('quantity', 1);
    formData.append('product_id', productId);
    
    fetch(window.location.href, {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        // Success state
        button.textContent = 'ADICIONADO!';
        button.style.backgroundColor = '#10b981';
        
        // Update cart count - trigger WooCommerce fragments refresh
        if (typeof jQuery !== 'undefined') {
            jQuery('body').trigger('wc_fragment_refresh');
            jQuery('body').trigger('added_to_cart');
            
            // Also manually update count if needed
            setTimeout(() => {
                const cartCountEl = document.querySelector('.cart-count');
                if (cartCountEl) {
                    let currentCount = parseInt(cartCountEl.textContent) || 0;
                    cartCountEl.textContent = currentCount + 1;
                    cartCountEl.style.display = 'flex';
                }
            }, 500);
        }
        
        // Show success notification
        showQuickAddNotification(productTitle);
        
        // Redirect to cart after 2 seconds
        setTimeout(() => {
            if (typeof brazil_ajax !== 'undefined' && brazil_ajax.cart_url) {
                window.location.href = brazil_ajax.cart_url;
            } else {
                window.location.href = '/carrinho/';
            }
        }, 1500);
    })
    .catch(error => {
        console.error('Error adding to cart:', error);
        
        // Reset button on error
        button.textContent = originalText;
        button.disabled = false;
        button.style.backgroundColor = '';
        
        // Show error notification
        showQuickAddNotification('Erro ao adicionar produto', 'error');
    });
}

function handleQuickPurchase(button) {
    const productCard = button.closest('.featured-product-card');
    const productTitle = productCard.querySelector('.product-title').textContent;
    const productPrice = productCard.querySelector('.price-current').textContent;
    
    // Add loading state
    const originalText = button.textContent;
    button.textContent = 'ADICIONANDO...';
    button.disabled = true;
    
    // Simulate adding to cart
    setTimeout(() => {
        button.textContent = 'ADICIONADO!';
        button.style.backgroundColor = '#10b981';
        
        // Update cart count
        updateCartCount();
        
        // Show success notification
        showQuickAddNotification(productTitle);
        
        // Reset button after 3 seconds
        setTimeout(() => {
            button.textContent = originalText;
            button.style.backgroundColor = '';
            button.disabled = false;
        }, 3000);
        
    }, 1000);
}

function updateCartCount() {
    const cartCount = document.querySelector('.cart-count');
    if (cartCount) {
        let currentCount = parseInt(cartCount.textContent) || 0;
        currentCount++;
        cartCount.textContent = currentCount;
        cartCount.style.display = 'flex';
        
        // Add animation
        cartCount.style.transform = 'scale(1.3)';
        setTimeout(() => {
            cartCount.style.transform = 'scale(1)';
        }, 300);
    }
}

function showQuickAddNotification(productName) {
    const notification = document.createElement('div');
    notification.className = 'quick-add-notification';
    notification.innerHTML = `
        <div class="notification-content">
            <span class="notification-icon">✓</span>
            <span class="notification-text">${productName} adicionado ao carrinho!</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Show notification
    setTimeout(() => notification.classList.add('show'), 100);
    
    // Hide and remove notification
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 4000);
}

// Newsletter Form Functionality
function initNewsletterForm() {
    const newsletterForm = document.querySelector('.newsletter-form');
    const newsletterInput = document.querySelector('.newsletter-input');
    const newsletterButton = document.querySelector('.newsletter-button');
    
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', handleNewsletterSubmission);
    }
    
    if (newsletterInput) {
        // Real-time email validation
        newsletterInput.addEventListener('input', () => {
            validateNewsletterEmail();
        });
        
        newsletterInput.addEventListener('blur', () => {
            validateNewsletterEmail();
        });
    }
}

async function handleNewsletterSubmission(e) {
    e.preventDefault();
    
    const form = e.target;
    const email = form.querySelector('.newsletter-input').value.trim();
    const button = form.querySelector('.newsletter-button');
    
    // Validate email
    if (!isValidEmail(email)) {
        showNewsletterMessage('Por favor, insira um email válido.', 'error');
        return;
    }
    
    // Show loading state
    const originalText = button.textContent;
    button.textContent = 'INSCREVENDO...';
    button.disabled = true;
    
    try {
        // Simulate API call
        await simulateNewsletterSignup(email);
        
        // Show success message
        showNewsletterMessage('Obrigado! Você foi inscrito em nossa newsletter.', 'success');
        
        // Clear form
        form.reset();
        
    } catch (error) {
        showNewsletterMessage('Erro ao inscrever. Tente novamente.', 'error');
    } finally {
        // Reset button
        button.textContent = originalText;
        button.disabled = false;
    }
}

function validateNewsletterEmail() {
    const input = document.querySelector('.newsletter-input');
    const email = input.value.trim();
    
    // Remove existing validation classes
    input.classList.remove('valid', 'invalid');
    
    if (email && !isValidEmail(email)) {
        input.classList.add('invalid');
    } else if (email && isValidEmail(email)) {
        input.classList.add('valid');
    }
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

async function simulateNewsletterSignup(email) {
    return new Promise((resolve, reject) => {
        // Find the Contact Form 7 form
        const cf7Form = document.querySelector('#wpcf7-f477-o1 .wpcf7-form');
        const emailInput = cf7Form ? cf7Form.querySelector('input[name="your-email"]') : null;
        const submitButton = cf7Form ? cf7Form.querySelector('input[type="submit"]') : null;
        
        if (!cf7Form || !emailInput || !submitButton) {
            console.error('Newsletter CF7 form not found');
            reject({ success: false, error: 'Form not found' });
            return;
        }
        
        // Fill the email field
        emailInput.value = email;
        emailInput.dispatchEvent(new Event('input', { bubbles: true }));
        
        // Set up event listeners for form response
        const responseOutput = cf7Form.querySelector('.wpcf7-response-output');
        
        // Create a MutationObserver to watch for form response changes
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.type === 'attributes' && mutation.attributeName === 'aria-hidden') {
                    const isHidden = responseOutput.getAttribute('aria-hidden') === 'true';
                    if (!isHidden && responseOutput.textContent.trim()) {
                        // Form has responded
                        const isSuccess = cf7Form.classList.contains('sent') || 
                                        responseOutput.textContent.includes('sucesso') || 
                                        responseOutput.textContent.includes('obrigad');
                        
                        observer.disconnect();
                        
                        if (isSuccess) {
                            resolve({ success: true });
                        } else {
                            reject({ success: false, error: responseOutput.textContent });
                        }
                    }
                }
            });
        });
        
        // Start observing
        observer.observe(responseOutput, { 
            attributes: true, 
            attributeFilter: ['aria-hidden'],
            childList: true,
            subtree: true 
        });
        
        // Set a timeout fallback
        setTimeout(() => {
            observer.disconnect();
            console.log(`Newsletter signup attempted: ${email}`);
            resolve({ success: true });
        }, 8000);
        
        // Submit the form
        setTimeout(() => {
            submitButton.click();
        }, 100);
    });
}

function showNewsletterMessage(message, type) {
    // Remove existing message
    const existingMessage = document.querySelector('.newsletter-message');
    if (existingMessage) {
        existingMessage.remove();
    }
    
    // Create new message
    const messageElement = document.createElement('div');
    messageElement.className = `newsletter-message ${type}`;
    messageElement.textContent = message;
    
    // Insert message after form
    const form = document.querySelector('.newsletter-form');
    form.insertAdjacentElement('afterend', messageElement);
    
    // Auto-remove message after 5 seconds
    setTimeout(() => {
        if (messageElement.parentNode) {
            messageElement.remove();
        }
    }, 5000);
}

// Brands Carousel for Mobile
function initBrandsCarousel() {
    if (typeof jQuery === 'undefined' || typeof jQuery.fn.slick === 'undefined') {
        console.warn('Slick carousel not loaded');
        return;
    }

    const brandsGrid = jQuery('.brands-grid');
    let isCarouselActive = false;

    function checkWindowSize() {
        if (window.innerWidth <= 650) {
            if (!isCarouselActive) {
                // Initialize Slick carousel
                brandsGrid.slick({
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    infinite: true,
                    arrows: false,
                    dots: true,
                    autoplay: true,
                    autoplaySpeed: 3000,
                    cssEase: 'ease-in-out',
                    centerMode: false,
                    variableWidth: false
                });
                isCarouselActive = true;
            }
        } else {
            if (isCarouselActive) {
                // Destroy Slick carousel
                brandsGrid.slick('unslick');
                isCarouselActive = false;
            }
        }
    }

    // Initial check
    checkWindowSize();

    // Check on window resize
    window.addEventListener('resize', checkWindowSize);
}

// Service Features Carousel for Mobile
function initServiceFeaturesCarousel() {
    if (typeof jQuery === 'undefined' || typeof jQuery.fn.slick === 'undefined') {
        console.warn('Slick carousel not loaded');
        return;
    }

    const serviceFeaturesGrid = jQuery('.service-features-grid');
    let isCarouselActive = false;

    function checkWindowSize() {
        if (window.innerWidth <= 750) {
            if (!isCarouselActive) {
                // Initialize Slick carousel
                serviceFeaturesGrid.slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    infinite: true,
                    arrows: false,
                    dots: true,
                    autoplay: true,
                    autoplaySpeed: 3000,
                    cssEase: 'ease-in-out',
                    centerMode: true,
                    centerPadding: '20px',
                    adaptiveHeight: true
                });
                isCarouselActive = true;
            }
        } else {
            if (isCarouselActive) {
                // Destroy Slick carousel
                serviceFeaturesGrid.slick('unslick');
                isCarouselActive = false;
            }
        }
    }

    // Initial check
    checkWindowSize();

    // Check on window resize
    window.addEventListener('resize', checkWindowSize);
}

// Brand Animations
function initBrandAnimations() {
    const brandItems = document.querySelectorAll('.brand-item');

    // Add staggered animation on scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add('animate-in');
                }, index * 100);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });

    brandItems.forEach(item => {
        item.classList.add('animate-element');
        observer.observe(item);
    });
}

// Scroll Animations
function initScrollAnimations() {
    const animatedElements = document.querySelectorAll(
        '.feature-item, .info-item, .featured-product-card'
    );
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });
    
    animatedElements.forEach(el => {
        el.classList.add('animate-element');
        observer.observe(el);
    });
}

// Smooth scroll for internal links
function homepageInitSmoothScroll() {
    const links = document.querySelectorAll('a[href^="#"]');
    
    links.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            
            const targetId = link.getAttribute('href');
            const targetSection = document.querySelector(targetId);
            
            if (targetSection) {
                targetSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// Initialize smooth scroll
homepageInitSmoothScroll();

// Parallax effect for hero background
function initParallaxEffect() {
    const heroBackgrounds = document.querySelectorAll('.hero-bg-image');
    
    if (heroBackgrounds.length === 0) return;
    
    function updateParallax() {
        const scrolled = window.pageYOffset;
        const parallax = scrolled * 0.5;
        
        heroBackgrounds.forEach(bg => {
            if (bg.closest('.hero-slide.active')) {
                bg.style.transform = `translateY(${parallax}px) scale(1.1)`;
            }
        });
    }
    
    // Throttle scroll events for better performance
    let ticking = false;
    
    function onScroll() {
        if (!ticking) {
            requestAnimationFrame(() => {
                updateParallax();
                ticking = false;
            });
            ticking = true;
        }
    }
    
    window.addEventListener('scroll', onScroll, { passive: true });
}

// Initialize parallax effect
initParallaxEffect();

// Mobile menu functionality moved to main.js to prevent conflicts

// Add CSS for animations and effects
const additionalStyles = `
    .animate-element {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s ease;
    }
    
    .animate-element.animate-in {
        opacity: 1;
        transform: translateY(0);
    }
    
    .quick-add-notification {
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
        max-width: 300px;
    }
    
    .quick-add-notification.show {
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
    
    .newsletter-input.valid {
        border-color: #10b981 !important;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }
    
    .newsletter-input.invalid {
        border-color: #ef4444 !important;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }
    
    .newsletter-message {
        margin-top: 1rem;
        padding: 1rem;
        border-radius: 8px;
        text-align: center;
        font-weight: 500;
    }
    
    .newsletter-message.success {
        background-color: #d1fae5;
        color: #065f46;
        border: 1px solid #10b981;
    }
    
    .newsletter-message.error {
        background-color: #fee2e2;
        color: #991b1b;
        border: 1px solid #ef4444;
    }
    
    @media (max-width: 768px) {
        .quick-add-notification {
            top: 10px;
            right: 10px;
            left: 10px;
            max-width: none;
            transform: translateY(-100%);
        }
        
        .quick-add-notification.show {
            transform: translateY(0);
        }
    }
`;

// Inject additional styles
const styleSheet = document.createElement('style');
styleSheet.textContent = additionalStyles;
document.head.appendChild(styleSheet);