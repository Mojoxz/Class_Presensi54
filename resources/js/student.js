/**
 * ============================================
 * STUDENT LAYOUT CONTROLLER - React Style
 * ============================================
 */

// State Management (React-like)
const state = {
    sidebarOpen: true,
    isMobile: false,
    currentPage: '',
    datetime: null
};

/**
 * Sidebar Controller
 */
const sidebarController = {
    elements: {
        sidebar: null,
        overlay: null,
        sidebarTexts: null,
        sidebarProfile: null
    },

    init() {
        this.elements.sidebar = document.getElementById('sidebar');
        this.elements.overlay = document.getElementById('overlay');
        this.elements.sidebarTexts = document.querySelectorAll('.nav-text');
        this.elements.sidebarProfile = document.getElementById('sidebarProfile');

        this.checkMobile();
        this.setupEventListeners();
        this.initializeSidebar();
    },

    checkMobile() {
        state.isMobile = window.innerWidth < 1024;
    },

    setupEventListeners() {
        window.addEventListener('resize', () => {
            this.checkMobile();
            this.handleResize();
        });

        // Add hover effects for navigation items
        const navItems = document.querySelectorAll('.nav-item');
        navItems.forEach(item => {
            item.addEventListener('mouseenter', () => this.handleNavHover(item, true));
            item.addEventListener('mouseleave', () => this.handleNavHover(item, false));
        });
    },

    toggle() {
        state.sidebarOpen = !state.sidebarOpen;

        if (state.isMobile) {
            this.toggleMobile();
        } else {
            this.toggleDesktop();
        }

        this.updateOverlay();
    },

    toggleMobile() {
        if (state.sidebarOpen) {
            this.elements.sidebar.classList.add('open');
            this.elements.overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        } else {
            this.elements.sidebar.classList.remove('open');
            this.elements.overlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    },

    toggleDesktop() {
        if (state.sidebarOpen) {
            this.elements.sidebar.classList.remove('collapsed');
        } else {
            this.elements.sidebar.classList.add('collapsed');
        }
    },

    updateOverlay() {
        if (state.isMobile && state.sidebarOpen) {
            this.elements.overlay.classList.remove('hidden');
            setTimeout(() => this.elements.overlay.classList.add('active'), 10);
        } else {
            this.elements.overlay.classList.remove('active');
            setTimeout(() => this.elements.overlay.classList.add('hidden'), 300);
        }
    },

    initializeSidebar() {
        if (state.isMobile) {
            state.sidebarOpen = false;
            this.elements.sidebar.classList.remove('open');
        } else {
            state.sidebarOpen = true;
            this.elements.sidebar.classList.remove('collapsed');
        }
    },

    handleResize() {
        if (state.isMobile) {
            // Mobile mode
            this.elements.sidebar.classList.remove('collapsed');
            if (!state.sidebarOpen) {
                this.elements.sidebar.classList.remove('open');
            }
        } else {
            // Desktop mode
            this.elements.sidebar.classList.remove('open');
            this.elements.overlay.classList.add('hidden');
            document.body.style.overflow = '';
            if (!state.sidebarOpen) {
                this.elements.sidebar.classList.add('collapsed');
            }
        }
    },

    handleNavHover(item, isHovering) {
        if (isHovering && !item.classList.contains('active')) {
            item.style.transform = 'translateX(4px)';
        } else if (!isHovering && !item.classList.contains('active')) {
            item.style.transform = '';
        }
    }
};

/**
 * DateTime Controller
 */
const dateTimeController = {
    element: null,
    interval: null,

    init() {
        this.element = document.getElementById('datetime');
        this.update();
        this.startInterval();
    },

    update() {
        const now = new Date();
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            timeZone: 'Asia/Jakarta'
        };

        if (this.element) {
            this.element.textContent = now.toLocaleDateString('id-ID', options);
        }
    },

    startInterval() {
        this.interval = setInterval(() => this.update(), 1000);
    },

    destroy() {
        if (this.interval) {
            clearInterval(this.interval);
        }
    }
};

/**
 * Alert Controller
 */
const alertController = {
    init() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            this.setupAutoClose(alert);
        });
    },

    setupAutoClose(alert) {
        // Auto close after 5 seconds
        setTimeout(() => {
            this.closeAlert(alert);
        }, 5000);
    },

    closeAlert(alert) {
        alert.style.animation = 'slideOutUp 0.3s ease-out';
        setTimeout(() => {
            alert.remove();
        }, 300);
    }
};

/**
 * Navigation Controller
 */
const navigationController = {
    init() {
        this.highlightCurrentPage();
        this.setupPageTransitions();
    },

    highlightCurrentPage() {
        const navItems = document.querySelectorAll('.nav-item');
        navItems.forEach(item => {
            if (item.classList.contains('active')) {
                state.currentPage = item.dataset.page || '';
            }
        });
    },

    setupPageTransitions() {
        const navItems = document.querySelectorAll('.nav-item');
        navItems.forEach(item => {
            item.addEventListener('click', (e) => {
                // Add loading state
                this.handleNavClick(item);
            });
        });
    },

    handleNavClick(item) {
        // Close mobile sidebar on navigation
        if (state.isMobile && state.sidebarOpen) {
            sidebarController.toggle();
        }
    }
};

/**
 * Theme Controller (for future dark mode)
 */
const themeController = {
    currentTheme: 'light',

    init() {
        this.loadTheme();
    },

    loadTheme() {
        const savedTheme = localStorage.getItem('student-theme');
        if (savedTheme) {
            this.currentTheme = savedTheme;
            this.applyTheme();
        }
    },

    applyTheme() {
        document.documentElement.setAttribute('data-theme', this.currentTheme);
    },

    toggle() {
        this.currentTheme = this.currentTheme === 'light' ? 'dark' : 'light';
        this.applyTheme();
        localStorage.setItem('student-theme', this.currentTheme);
    }
};

/**
 * Performance Monitor
 */
const performanceMonitor = {
    init() {
        this.logPerformance();
    },

    logPerformance() {
        if (window.performance && window.performance.timing) {
            window.addEventListener('load', () => {
                const perfData = window.performance.timing;
                const pageLoadTime = perfData.loadEventEnd - perfData.navigationStart;
                console.log(`Page Load Time: ${pageLoadTime}ms`);
            });
        }
    }
};

/**
 * Utility Functions
 */
const utils = {
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    },

    throttle(func, limit) {
        let inThrottle;
        return function(...args) {
            if (!inThrottle) {
                func.apply(this, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    },

    animate(element, animation, duration = 300) {
        return new Promise((resolve) => {
            element.style.animation = `${animation} ${duration}ms ease-out`;
            setTimeout(() => {
                element.style.animation = '';
                resolve();
            }, duration);
        });
    }
};

/**
 * Form Handler (for logout and other forms)
 */
const formHandler = {
    init() {
        this.setupLogoutForm();
    },

    setupLogoutForm() {
        const logoutForm = document.getElementById('logoutForm');
        if (logoutForm) {
            logoutForm.addEventListener('submit', (e) => {
                this.handleLogout(e, logoutForm);
            });
        }
    },

    handleLogout(e, form) {
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
        }
    }
};

/**
 * Keyboard Shortcuts
 */
const keyboardShortcuts = {
    init() {
        document.addEventListener('keydown', (e) => {
            // Ctrl/Cmd + B to toggle sidebar
            if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
                e.preventDefault();
                sidebarController.toggle();
            }

            // Escape to close mobile sidebar
            if (e.key === 'Escape' && state.isMobile && state.sidebarOpen) {
                sidebarController.toggle();
            }
        });
    }
};

/**
 * Scroll Handler
 */
const scrollHandler = {
    init() {
        const mainContent = document.querySelector('.main-content');
        if (mainContent) {
            mainContent.addEventListener('scroll', utils.throttle(() => {
                this.handleScroll(mainContent);
            }, 100));
        }
    },

    handleScroll(element) {
        const header = document.querySelector('.main-header');
        if (element.scrollTop > 20) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    }
};

/**
 * Application Initialization
 */
class StudentApp {
    constructor() {
        this.controllers = [
            sidebarController,
            dateTimeController,
            alertController,
            navigationController,
            themeController,
            performanceMonitor,
            formHandler,
            keyboardShortcuts,
            scrollHandler
        ];
    }

    init() {
        // Wait for DOM to be fully loaded
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.start());
        } else {
            this.start();
        }
    }

    start() {
        console.log('🚀 Student App Initializing...');

        // Initialize all controllers
        this.controllers.forEach(controller => {
            if (controller && typeof controller.init === 'function') {
                try {
                    controller.init();
                } catch (error) {
                    console.error(`Error initializing controller:`, error);
                }
            }
        });

        console.log('✅ Student App Ready');

        // Add loaded class to body for animations
        document.body.classList.add('app-loaded');
    }

    destroy() {
        // Cleanup
        dateTimeController.destroy();
        console.log('Student App Destroyed');
    }
}

// Initialize the application
const app = new StudentApp();
app.init();

// Expose to window for external access
window.studentApp = app;
window.sidebarController = sidebarController;

// Handle page visibility changes
document.addEventListener('visibilitychange', () => {
    if (document.hidden) {
        // Page is hidden, pause non-essential operations
        dateTimeController.destroy();
    } else {
        // Page is visible again, resume operations
        dateTimeController.init();
    }
});

// Add additional CSS animations via JavaScript
const style = document.createElement('style');
style.textContent = `
    @keyframes slideOutUp {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(-20px);
        }
    }

    .main-header.scrolled {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .app-loaded .content-wrapper {
        animation: fadeInUp 0.4s ease-out;
    }
`;
document.head.appendChild(style);
