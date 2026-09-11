# Brazil Home Living - E-commerce Website

A modern, responsive e-commerce website for Brazil Home Living, featuring home and garden products.

## Project Structure

```
brazil-home/
├── index.html                 # Main homepage
├── styles/                    # CSS files
│   ├── main.css              # Base styles and utilities
│   ├── header.css            # Header and navigation styles
│   ├── blog.css              # Blog section styles
│   ├── products.css          # Product grid and posts styles
│   └── footer.css            # Footer styles
├── js/                       # JavaScript files
│   └── main.js               # Main functionality
├── assets/                   # Static assets
│   ├── images/               # Product and content images
│   └── icons/                # Icons and logos
└── README.md                 # Project documentation
```

## Features

- **Responsive Design**: Mobile-first approach with breakpoints for all device sizes
- **Modern UI/UX**: Clean, professional design with smooth animations
- **Blog Section**: Interactive blog cards with slider functionality
- **Product Grid**: Responsive grid layout for latest posts/products
- **Search Functionality**: Header search with autocomplete capabilities
- **Shopping Cart**: Cart icon with item counter
- **Navigation**: Sticky header with category navigation
- **Pagination**: Multi-page content navigation
- **Social Integration**: Footer social media links

## CSS Class Naming Convention

The project uses semantic, meaningful class names following BEM-like methodology:

### Header Classes
- `.main-header` - Main header container
- `.header-top` - Top promotional bar
- `.header-main` - Main header content area
- `.search-bar` - Search input container
- `.user-actions` - User account and cart area
- `.main-navigation` - Main navigation menu

### Content Classes
- `.blog-section` - Blog content area
- `.blog-card` - Individual blog post card
- `.blog-slider-controls` - Slider navigation controls
- `.latest-posts-section` - Posts grid section
- `.post-card` - Individual post card
- `.posts-grid` - Grid container for posts

### Footer Classes
- `.main-footer` - Footer container
- `.footer-contact` - Contact information
- `.payment-methods` - Payment icons
- `.social-media` - Social media links

### Utility Classes
- `.container` - Max-width content wrapper
- `.btn` - Button base styles
- `.grid` - Grid layout utility
- `.text-center` - Center align text
- Margin utilities: `.mb-1`, `.mt-2`, etc.

## Responsive Breakpoints

- **Desktop**: 1024px and above
- **Tablet**: 768px to 1023px
- **Mobile Large**: 480px to 767px
- **Mobile Small**: Below 480px

## JavaScript Features

- Blog slider with automatic rotation
- Mobile menu toggle
- Search functionality with enter key support
- Shopping cart interactions
- Pagination navigation
- Smooth scrolling for internal links
- Lazy loading for images
- Debounced scroll events

## Getting Started

1. Open `index.html` in a web browser
2. Add your product images to `assets/images/`
3. Add icons and logos to `assets/icons/`
4. Customize colors and styling in the CSS files
5. Update content in `index.html`

## Browser Support

- Chrome 60+
- Firefox 55+
- Safari 12+
- Edge 16+

## Performance Features

- Optimized CSS with minimal unused styles
- Efficient JavaScript with event delegation
- Image lazy loading
- Smooth animations with CSS transforms
- Debounced scroll events