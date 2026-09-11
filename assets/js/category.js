// Category Page JavaScript

document.addEventListener('DOMContentLoaded', function() {
    initFAQAccordion();
    initProductInteractions();
    initCategoryFilters();
});

// FAQ Static Display (No accordion functionality needed)
function initFAQAccordion() {
    // FAQ items are now displayed statically as per the design
    // No accordion functionality needed
    return;
}

// Product Card Interactions
function initProductInteractions() {
    const productCards = document.querySelectorAll('.product-card');
    const buyButtons = document.querySelectorAll('.btn-buy');
    
    // Product card hover effects
    productCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0)';
        });
    });
    
    // Buy button functionality
    buyButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const productCard = button.closest('.product-card');
            const productTitle = productCard.querySelector('.product-title').textContent;
            const productPrice = productCard.querySelector('.price-current').textContent;
            
            handlePurchase(productTitle, productPrice, button);
        });
    });
}

// Handle product purchase
function handlePurchase(title, price, button) {
    // Add loading state to button
    const originalText = button.textContent;
    button.textContent = 'ADICIONANDO...';
    button.disabled = true;
    
    // Simulate adding to cart
    setTimeout(() => {
        button.textContent = 'ADICIONADO!';
        button.style.backgroundColor = '#10b981';
        
        // Update cart count
        updateCartCount();
        
        // Reset button after 2 seconds
        setTimeout(() => {
            button.textContent = originalText;
            button.style.backgroundColor = '';
            button.disabled = false;
        }, 2000);
        
        console.log(`Produto adicionado: ${title} - ${price}`);
    }, 1000);
}

// Update cart count in header
function updateCartCount() {
    const cartCount = document.querySelector('.cart-count');
    if (cartCount) {
        let currentCount = parseInt(cartCount.textContent) || 0;
        currentCount++;
        cartCount.textContent = currentCount;
        cartCount.style.display = 'flex';
        
        // Add animation
        cartCount.style.transform = 'scale(1.2)';
        setTimeout(() => {
            cartCount.style.transform = 'scale(1)';
        }, 200);
    }
}

// Category Filters (if needed for future implementation)
function initCategoryFilters() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const sortSelect = document.querySelector('.sort-select');
    
    if (filterButtons.length > 0) {
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                const filter = button.dataset.filter;
                applyFilter(filter);
                
                // Update active filter button
                filterButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
            });
        });
    }
    
    if (sortSelect) {
        sortSelect.addEventListener('change', (e) => {
            const sortOption = e.target.value;
            sortProducts(sortOption);
        });
    }
}

// Apply product filter
function applyFilter(filter) {
    const productCards = document.querySelectorAll('.product-card');
    
    productCards.forEach(card => {
        if (filter === 'all' || card.dataset.category === filter) {
            card.style.display = 'block';
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
        } else {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.display = 'none';
            }, 300);
        }
    });
}

// Sort products
function sortProducts(sortOption) {
    const productsGrid = document.querySelector('.products-grid');
    const productCards = Array.from(document.querySelectorAll('.product-card'));
    
    productCards.sort((a, b) => {
        switch (sortOption) {
            case 'price-low':
                return getPriceValue(a) - getPriceValue(b);
            case 'price-high':
                return getPriceValue(b) - getPriceValue(a);
            case 'name-az':
                return getProductName(a).localeCompare(getProductName(b));
            case 'name-za':
                return getProductName(b).localeCompare(getProductName(a));
            default:
                return 0;
        }
    });
    
    // Re-append sorted cards
    productCards.forEach(card => {
        productsGrid.appendChild(card);
    });
}

// Helper function to get price value
function getPriceValue(card) {
    const priceText = card.querySelector('.price-current').textContent;
    return parseFloat(priceText.replace('R$', '').replace(',', '.').trim());
}

// Helper function to get product name
function getProductName(card) {
    return card.querySelector('.product-title').textContent.trim();
}

// Smooth scroll to products when coming from category navigation
function scrollToProducts() {
    const productsSection = document.querySelector('.products-section');
    if (productsSection && window.location.hash === '#products') {
        setTimeout(() => {
            productsSection.scrollIntoView({ 
                behavior: 'smooth',
                block: 'start'
            });
        }, 100);
    }
}

// Initialize smooth scroll on page load
scrollToProducts();

// Product image lazy loading with intersection observer
function initProductImageLazyLoading() {
    const productImages = document.querySelectorAll('.product-image img[data-src]');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                
                // Only apply lazy loading to images with data-src attribute
                if (img.dataset.src) {
                    img.style.opacity = '0';
                    img.style.transition = 'opacity 0.3s ease';
                    
                    img.src = img.dataset.src;
                    
                    img.addEventListener('load', () => {
                        img.style.opacity = '1';
                    });
                }
                
                observer.unobserve(img);
            }
        });
    }, {
        rootMargin: '50px'
    });
    
    productImages.forEach(img => {
        imageObserver.observe(img);
    });
}

// Initialize lazy loading if supported
if ('IntersectionObserver' in window) {
    initProductImageLazyLoading();
}

// Handle pagination clicks
function initPaginationHandlers() {
    const paginationBtns = document.querySelectorAll('.pagination-btn');
    
    paginationBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Remove active class from all buttons
            paginationBtns.forEach(b => b.classList.remove('active'));
            
            // Add active class to clicked button
            btn.classList.add('active');
            
            const pageNumber = btn.textContent;
            
            // Scroll to top of products section
            const productsSection = document.querySelector('.products-section');
            if (productsSection) {
                productsSection.scrollIntoView({ 
                    behavior: 'smooth',
                    block: 'start'
                });
            }
            
            // Add loading effect
            const productsGrid = document.querySelector('.products-grid');
            if (productsGrid) {
                productsGrid.style.opacity = '0.5';
                
                // Simulate loading new products
                setTimeout(() => {
                    productsGrid.style.opacity = '1';
                    console.log(`Loaded page ${pageNumber}`);
                }, 500);
            }
        });
    });
}

// Initialize pagination
initPaginationHandlers();

// Add keyboard navigation for accessibility
document.addEventListener('keydown', (e) => {
    // Handle Escape key to close FAQ items
    if (e.key === 'Escape') {
        const activeFAQ = document.querySelector('.faq-item.active');
        if (activeFAQ) {
            activeFAQ.classList.remove('active');
        }
    }
    
    // Handle Enter/Space for FAQ questions
    if ((e.key === 'Enter' || e.key === ' ') && e.target.classList.contains('faq-question')) {
        e.preventDefault();
        e.target.click();
    }
});