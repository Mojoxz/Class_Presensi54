// Landing Page JavaScript - SMP 54 Surabaya

document.addEventListener('DOMContentLoaded', function() {
    initLandingPage();
});

function initLandingPage() {
    initNavbar();
    initMobileMenu();
    initScrollAnimations();
    initScrollToTop();
    initSmoothScroll();
    initParallax();
}

// Navbar Scroll Effect
function initNavbar() {
    const navbar = document.getElementById('navbar');
    if (!navbar) return;

    let lastScroll = 0;
    const scrollThreshold = 100;

    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;

        // Add shadow on scroll
        if (currentScroll > 20) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }

        // Hide/show navbar on scroll
        if (currentScroll > scrollThreshold) {
            if (currentScroll > lastScroll && !navbar.classList.contains('hide')) {
                // Scrolling down
                navbar.style.transform = 'translateY(-100%)';
            } else {
                // Scrolling up
                navbar.style.transform = 'translateY(0)';
            }
        }

        lastScroll = currentScroll;
    });
}

// Mobile Menu
function initMobileMenu() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileBackdrop = document.getElementById('mobile-backdrop');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');

    if (!mobileMenuButton || !mobileMenu) return;

    // Toggle menu
    mobileMenuButton.addEventListener('click', (e) => {
        e.stopPropagation();
        toggleMobileMenu();
    });

    // Close on backdrop click
    if (mobileBackdrop) {
        mobileBackdrop.addEventListener('click', () => {
            closeMobileMenu();
        });
    }

    // Close on link click
    const mobileLinks = mobileMenu.querySelectorAll('a');
    mobileLinks.forEach(link => {
        link.addEventListener('click', () => {
            closeMobileMenu();
        });
    });

    // Close on ESC key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && mobileMenu.classList.contains('active')) {
            closeMobileMenu();
        }
    });

    function toggleMobileMenu() {
        const isActive = mobileMenu.classList.contains('active');

        if (isActive) {
            closeMobileMenu();
        } else {
            openMobileMenu();
        }
    }

    function openMobileMenu() {
        mobileMenu.classList.remove('hidden');
        mobileMenu.classList.add('active');
        document.body.style.overflow = 'hidden';

        if (menuIcon && closeIcon) {
            menuIcon.classList.add('hidden');
            closeIcon.classList.remove('hidden');
        }
    }

    function closeMobileMenu() {
        mobileMenu.classList.remove('active');
        document.body.style.overflow = '';

        setTimeout(() => {
            mobileMenu.classList.add('hidden');
        }, 300);

        if (menuIcon && closeIcon) {
            menuIcon.classList.remove('hidden');
            closeIcon.classList.add('hidden');
        }
    }
}

// Scroll Animations with Intersection Observer
function initScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');

                // Optional: stop observing after animation
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe all elements with animate-on-scroll class
    document.querySelectorAll('.animate-on-scroll').forEach(element => {
        observer.observe(element);
    });

    // Stagger animation for children
    document.querySelectorAll('[data-stagger]').forEach(parent => {
        const children = parent.children;
        Array.from(children).forEach((child, index) => {
            child.style.animationDelay = `${index * 0.1}s`;
        });
    });
}

// Scroll to Top Button
function initScrollToTop() {
    const scrollButton = document.getElementById('scroll-to-top');
    if (!scrollButton) return;

    // Show/hide button based on scroll position
    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            scrollButton.classList.remove('hidden');
            scrollButton.classList.add('show');
        } else {
            scrollButton.classList.remove('show');
            setTimeout(() => {
                if (!scrollButton.classList.contains('show')) {
                    scrollButton.classList.add('hidden');
                }
            }, 300);
        }
    });

    // Scroll to top on click
    scrollButton.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

// Smooth Scroll for Anchor Links
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');

            // Skip if href is just "#"
            if (href === '#' || href === '#!') {
                e.preventDefault();
                return;
            }

            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();

                const navbarHeight = document.getElementById('navbar')?.offsetHeight || 0;
                const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - navbarHeight;

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// Parallax Effect for Hero Section
function initParallax() {
    const heroSection = document.querySelector('.hero-section');
    if (!heroSection) return;

    const shapes = heroSection.querySelectorAll('.floating-shape');

    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const rate = scrolled * 0.5;

        shapes.forEach((shape, index) => {
            const speed = (index + 1) * 0.3;
            shape.style.transform = `translateY(${rate * speed}px)`;
        });
    });
}

// Counter Animation
function animateCounter(element, target, duration = 2000) {
    let current = 0;
    const increment = target / (duration / 16);
    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            current = target;
            clearInterval(timer);
        }
        element.textContent = Math.floor(current) + '+';
    }, 16);
}

// Initialize counters when they come into view
const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting && !entry.target.classList.contains('counted')) {
            entry.target.classList.add('counted');
            const target = parseInt(entry.target.dataset.count);
            if (!isNaN(target)) {
                animateCounter(entry.target, target);
            }
        }
    });
}, { threshold: 0.5 });

document.querySelectorAll('[data-count]').forEach(counter => {
    counterObserver.observe(counter);
});

// Lazy Load Images
function initLazyLoad() {
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;

                if (img.dataset.src) {
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                }

                if (img.dataset.srcset) {
                    img.srcset = img.dataset.srcset;
                    img.removeAttribute('data-srcset');
                }

                img.classList.add('loaded');
                observer.unobserve(img);
            }
        });
    }, {
        rootMargin: '50px 0px',
        threshold: 0.01
    });

    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
}

initLazyLoad();

// Card Tilt Effect (Optional - for extra wow factor)
function initCardTilt() {
    const cards = document.querySelectorAll('.feature-card, .news-card');

    cards.forEach(card => {
        card.addEventListener('mousemove', handleTilt);
        card.addEventListener('mouseleave', resetTilt);
    });

    function handleTilt(e) {
        const card = e.currentTarget;
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        const centerX = rect.width / 2;
        const centerY = rect.height / 2;

        const rotateX = (y - centerY) / 20;
        const rotateY = (centerX - x) / 20;

        card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-8px)`;
    }

    function resetTilt(e) {
        const card = e.currentTarget;
        card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateY(0)';
    }
}

// Optional: Initialize card tilt effect
// Uncomment if you want the 3D tilt effect on cards
// initCardTilt();

// Form Enhancement (if you have forms on landing page)
function initFormEnhancements() {
    const forms = document.querySelectorAll('form');

    forms.forEach(form => {
        const inputs = form.querySelectorAll('input, textarea, select');

        inputs.forEach(input => {
            // Floating label effect
            input.addEventListener('focus', () => {
                input.parentElement?.classList.add('focused');
            });

            input.addEventListener('blur', () => {
                if (!input.value) {
                    input.parentElement?.classList.remove('focused');
                }
            });

            // Check if input has value on load
            if (input.value) {
                input.parentElement?.classList.add('focused');
            }
        });
    });
}

initFormEnhancements();

// Progress Bar Animation
function initProgressBars() {
    const progressObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const progressBar = entry.target.querySelector('.progress-bar-fill');
                if (progressBar) {
                    const width = progressBar.dataset.width || '0%';
                    setTimeout(() => {
                        progressBar.style.width = width;
                    }, 100);
                }
                progressObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    document.querySelectorAll('.progress-bar').forEach(bar => {
        progressObserver.observe(bar);
    });
}

initProgressBars();

// Preloader (Optional)
function initPreloader() {
    const preloader = document.getElementById('preloader');
    if (!preloader) return;

    window.addEventListener('load', () => {
        preloader.style.opacity = '0';
        setTimeout(() => {
            preloader.style.display = 'none';
        }, 300);
    });
}

// Optional: Add preloader
// initPreloader();

// Mouse Trail Effect (Optional - for extra visual appeal)
function initMouseTrail() {
    let mouseX = 0;
    let mouseY = 0;
    let isMouseMoving = false;

    document.addEventListener('mousemove', (e) => {
        mouseX = e.clientX;
        mouseY = e.clientY;

        if (!isMouseMoving) {
            isMouseMoving = true;
            requestAnimationFrame(updateTrail);
        }
    });

    function updateTrail() {
        // Create trail effect
        const trail = document.createElement('div');
        trail.className = 'mouse-trail';
        trail.style.left = mouseX + 'px';
        trail.style.top = mouseY + 'px';
        document.body.appendChild(trail);

        setTimeout(() => {
            trail.remove();
        }, 500);

        isMouseMoving = false;
    }
}

// Optional: Uncomment for mouse trail effect
// initMouseTrail();

// Export functions for external use
window.LandingPage = {
    animateCounter,
    initCardTilt,
    initMouseTrail
};

// Performance: Reduce animations on low-end devices
if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    document.documentElement.style.setProperty('--animation-duration', '0.01ms');
}

// Log initialization
console.log('🎨 Landing Page initialized successfully!');

// Easter egg: Konami Code
let konamiCode = [];
const konamiSequence = [
    'ArrowUp', 'ArrowUp',
    'ArrowDown', 'ArrowDown',
    'ArrowLeft', 'ArrowRight',
    'ArrowLeft', 'ArrowRight',
    'b', 'a'
];

document.addEventListener('keydown', (e) => {
    konamiCode.push(e.key);
    konamiCode = konamiCode.slice(-10);

    if (konamiCode.join(',') === konamiSequence.join(',')) {
        document.body.style.animation = 'rainbow 2s linear infinite';
        setTimeout(() => {
            document.body.style.animation = '';
        }, 5000);

        if (window.SMP54 && window.SMP54.showNotification) {
            window.SMP54.showNotification('🎉 Konami Code activated! You found the easter egg!', 'success', 5000);
        }
    }
});

// Add rainbow animation for easter egg
const style = document.createElement('style');
style.textContent = `
    @keyframes rainbow {
        0% { filter: hue-rotate(0deg); }
        100% { filter: hue-rotate(360deg); }
    }
`;
document.head.appendChild(style);
