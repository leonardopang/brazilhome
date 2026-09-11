// About Page JavaScript

document.addEventListener('DOMContentLoaded', function() {
    initSocialSharing();
    initScrollAnimations();
    initParallaxEffect();
    initRelatedArticles();
});

// Social Sharing Functionality
function initSocialSharing() {
    const socialButtons = document.querySelectorAll('.social-btn');
    
    socialButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            
            const platform = getSocialPlatform(button);
            const pageUrl = encodeURIComponent(window.location.href);
            const pageTitle = encodeURIComponent(document.title);
            const pageDescription = encodeURIComponent(getPageDescription());
            
            let shareUrl = '';
            
            switch (platform) {
                case 'facebook':
                    shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${pageUrl}`;
                    break;
                case 'linkedin':
                    shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${pageUrl}`;
                    break;
                case 'instagram':
                    // Instagram doesn't have direct URL sharing, show message
                    showInstagramMessage();
                    return;
                case 'pinterest':
                    const imageUrl = encodeURIComponent(getFirstImage());
                    shareUrl = `https://pinterest.com/pin/create/button/?url=${pageUrl}&description=${pageTitle}&media=${imageUrl}`;
                    break;
                default:
                    return;
            }
            
            if (shareUrl) {
                openShareWindow(shareUrl);
            }
        });
    });
}

// Get social platform from button classes
function getSocialPlatform(button) {
    const classes = button.className;
    if (classes.includes('facebook')) return 'facebook';
    if (classes.includes('linkedin')) return 'linkedin';
    if (classes.includes('instagram')) return 'instagram';
    if (classes.includes('pinterest')) return 'pinterest';
    return null;
}

// Get page description from meta tag or first paragraph
function getPageDescription() {
    const metaDescription = document.querySelector('meta[name="description"]');
    if (metaDescription) {
        return metaDescription.content;
    }
    
    const firstParagraph = document.querySelector('.article-text');
    if (firstParagraph) {
        return firstParagraph.textContent.substring(0, 160) + '...';
    }
    
    return 'Brazil Home Living - Produtos para sua casa e jardim';
}

// Get first image URL for Pinterest sharing
function getFirstImage() {
    const heroImage = document.querySelector('.hero-bg-image');
    if (heroImage) {
        return heroImage.src;
    }
    
    const firstArticleImage = document.querySelector('.related-article-image img');
    if (firstArticleImage) {
        return firstArticleImage.src;
    }
    
    // Fallback to logo
    const logo = document.querySelector('.main-logo');
    return logo ? logo.src : '';
}

// Open share window
function openShareWindow(url) {
    const width = 600;
    const height = 400;
    const left = (window.innerWidth - width) / 2;
    const top = (window.innerHeight - height) / 2;
    
    window.open(
        url,
        'share',
        `width=${width},height=${height},left=${left},top=${top},scrollbars=yes,resizable=yes`
    );
}

// Show Instagram sharing message
function showInstagramMessage() {
    const message = document.createElement('div');
    message.className = 'instagram-message';
    message.innerHTML = `
        <div class="message-content">
            <h3>Compartilhar no Instagram</h3>
            <p>Para compartilhar no Instagram, tire um screenshot desta página ou copie o link:</p>
            <div class="copy-link">
                <input type="text" value="${window.location.href}" readonly>
                <button class="copy-btn">Copiar</button>
            </div>
        </div>
        <button class="close-btn">&times;</button>
    `;
    
    document.body.appendChild(message);
    
    // Add event listeners
    const copyBtn = message.querySelector('.copy-btn');
    const closeBtn = message.querySelector('.close-btn');
    const linkInput = message.querySelector('input');
    
    copyBtn.addEventListener('click', () => {
        linkInput.select();
        document.execCommand('copy');
        copyBtn.textContent = 'Copiado!';
        setTimeout(() => {
            copyBtn.textContent = 'Copiar';
        }, 2000);
    });
    
    closeBtn.addEventListener('click', () => {
        message.remove();
    });
    
    // Close on outside click
    message.addEventListener('click', (e) => {
        if (e.target === message) {
            message.remove();
        }
    });
    
    // Show message
    setTimeout(() => message.classList.add('show'), 100);
}

// Scroll Animations
function initScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);
    
    // Observe elements for animation
    const animatedElements = document.querySelectorAll(
        '.article-title, .article-subtitle, .article-text, .related-article-card'
    );
    
    animatedElements.forEach(el => {
        el.classList.add('animate-element');
        observer.observe(el);
    });
}

// Parallax Effect for Hero Background
function initParallaxEffect() {
    const heroBackground = document.querySelector('.hero-bg-image');
    
    if (!heroBackground) return;
    
    function updateParallax() {
        const scrolled = window.pageYOffset;
        const parallax = scrolled * 0.5;
        
        heroBackground.style.transform = `translateY(${parallax}px)`;
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

// Related Articles Functionality
function initRelatedArticles() {
    const relatedArticleCards = document.querySelectorAll('.related-article-card');
    
    relatedArticleCards.forEach(card => {
        const link = card.querySelector('.related-article-link');
        
        // Make entire card clickable
        card.addEventListener('click', (e) => {
            if (e.target !== link && !link.contains(e.target)) {
                link.click();
            }
        });
        
        // Add hover effects
        card.addEventListener('mouseenter', () => {
            card.style.cursor = 'pointer';
        });
        
        // Handle link clicks
        if (link) {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                
                // Add loading effect
                const originalContent = link.innerHTML;
                link.innerHTML = '<span style="font-size: 12px;">...</span>';
                
                // Simulate navigation
                setTimeout(() => {
                    console.log('Navigating to article...');
                    link.innerHTML = originalContent;
                    // Here you would typically navigate to the article
                    // window.location.href = 'article-url.html';
                }, 500);
            });
        }
    });
}

// Reading Progress Indicator
function initReadingProgress() {
    const progressBar = document.createElement('div');
    progressBar.className = 'reading-progress';
    progressBar.innerHTML = '<div class="progress-fill"></div>';
    document.body.appendChild(progressBar);
    
    const progressFill = progressBar.querySelector('.progress-fill');
    const article = document.querySelector('.about-article');
    
    if (!article) return;
    
    function updateProgress() {
        const articleTop = article.offsetTop;
        const articleHeight = article.offsetHeight;
        const windowHeight = window.innerHeight;
        const scrolled = window.pageYOffset;
        
        const articleBottom = articleTop + articleHeight;
        const progressStart = articleTop - windowHeight;
        const progressEnd = articleBottom - windowHeight;
        const progressRange = progressEnd - progressStart;
        
        if (scrolled >= progressStart && scrolled <= progressEnd) {
            const progress = ((scrolled - progressStart) / progressRange) * 100;
            progressFill.style.width = `${Math.min(100, Math.max(0, progress))}%`;
            progressBar.classList.add('visible');
        } else {
            progressBar.classList.remove('visible');
        }
    }
    
    let ticking = false;
    
    window.addEventListener('scroll', () => {
        if (!ticking) {
            requestAnimationFrame(() => {
                updateProgress();
                ticking = false;
            });
            ticking = true;
        }
    }, { passive: true });
}

// Initialize reading progress
initReadingProgress();

// Smooth scroll for internal links
function aboutInitSmoothScroll() {
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
aboutInitSmoothScroll();

// Add CSS for animations and effects
const additionalStyles = `
    .reading-progress {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: rgba(30, 58, 138, 0.1);
        z-index: 9999;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .reading-progress.visible {
        opacity: 1;
    }
    
    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #1e3a8a, #3b82f6);
        width: 0%;
        transition: width 0.1s ease;
    }
    
    .animate-element {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s ease;
    }
    
    .animate-element.animate-in {
        opacity: 1;
        transform: translateY(0);
    }
    
    .instagram-message {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10000;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .instagram-message.show {
        opacity: 1;
    }
    
    .message-content {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        max-width: 500px;
        width: 90%;
        position: relative;
    }
    
    .message-content h3 {
        margin: 0 0 1rem 0;
        color: #1e3a8a;
        font-size: 1.2rem;
    }
    
    .message-content p {
        margin: 0 0 1.5rem 0;
        color: #374151;
        line-height: 1.5;
    }
    
    .copy-link {
        display: flex;
        gap: 0.5rem;
    }
    
    .copy-link input {
        flex: 1;
        padding: 0.8rem;
        border: 2px solid #e5e7eb;
        border-radius: 6px;
        font-size: 0.9rem;
    }
    
    .copy-btn {
        background: #3b82f6;
        color: white;
        border: none;
        padding: 0.8rem 1.5rem;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s ease;
    }
    
    .copy-btn:hover {
        background: #2563eb;
    }
    
    .close-btn {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #9ca3af;
        cursor: pointer;
        transition: color 0.3s ease;
    }
    
    .close-btn:hover {
        color: #374151;
    }
    
    @media (max-width: 768px) {
        .message-content {
            padding: 1.5rem;
            margin: 1rem;
        }
        
        .copy-link {
            flex-direction: column;
        }
        
        .copy-link input {
            margin-bottom: 0.5rem;
        }
    }
`;

// Inject additional styles
const styleSheet = document.createElement('style');
styleSheet.textContent = additionalStyles;
document.head.appendChild(styleSheet);