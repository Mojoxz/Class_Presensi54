import './bootstrap';
import Alpine from 'alpinejs';

// Make Alpine available globally
window.Alpine = Alpine;
Alpine.start();

// Modern SMP 54 Surabaya JavaScript
document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
});

// Main Initialization
function initializeApp() {
    initializeAnimations();
    initializeDateTime();
    initializeNotifications();
    initializeModal();
    initializeForms();
    initializeNavigation();
    initializeLazyLoading();
}

// Smooth Scroll & Intersection Observer Animations
function initializeAnimations() {
    // Intersection Observer for fade-in animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in-up');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe elements with animation class
    document.querySelectorAll('.animate-on-scroll').forEach(el => {
        observer.observe(el);
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href === '#') return;

            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// DateTime Functions
function initializeDateTime() {
    updateDateTime();
    setInterval(updateDateTime, 1000);
}

function updateDateTime() {
    const now = new Date();
    const options = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    };

    // Update elements with datetime IDs
    const dateTimeElements = {
        'current-time': now.toLocaleTimeString('id-ID'),
        'current-date': now.toLocaleDateString('id-ID', options),
        'datetime': now.toLocaleDateString('id-ID', options)
    };

    Object.entries(dateTimeElements).forEach(([id, value]) => {
        const element = document.getElementById(id);
        if (element) element.textContent = value;
    });

    // Update elements with data-datetime attribute
    document.querySelectorAll('[data-datetime]').forEach(element => {
        const format = element.getAttribute('data-datetime');
        element.textContent = formatDateTime(now, format);
    });
}

function formatDateTime(date, format) {
    const options = {
        time: { hour: '2-digit', minute: '2-digit' },
        date: { year: 'numeric', month: 'long', day: 'numeric' },
        datetime: { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit' },
        full: { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' }
    };

    return date.toLocaleString('id-ID', options[format] || {});
}

// Modern Notification System
function initializeNotifications() {
    // Auto-hide alerts
    document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => hideElement(alert), 5000);
    });
}

function showNotification(message, type = 'info', duration = 5000) {
    const notification = createNotification(message, type);
    document.body.appendChild(notification);

    // Trigger animation
    setTimeout(() => notification.classList.add('notification-enter-active'), 10);

    // Auto-hide
    if (duration > 0) {
        setTimeout(() => hideNotification(notification), duration);
    }

    return notification;
}

function createNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `notification fixed top-4 right-4 z-50 max-w-sm notification-enter`;

    const typeClasses = {
        success: 'bg-green-50 border-green-200 text-green-800',
        error: 'bg-red-50 border-red-200 text-red-800',
        warning: 'bg-amber-50 border-amber-200 text-amber-800',
        info: 'bg-blue-50 border-blue-200 text-blue-800'
    };

    notification.innerHTML = `
        <div class="px-4 py-3 rounded-lg border ${typeClasses[type] || typeClasses.info}">
            <div class="flex items-start justify-between">
                <span class="flex-1">${message}</span>
                <button onclick="window.SMP54.hideNotification(this.closest('.notification'))"
                        class="ml-4 text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    `;

    return notification;
}

function hideNotification(notification) {
    if (!notification) return;
    notification.classList.remove('notification-enter-active');
    notification.classList.add('notification-exit-active');
    setTimeout(() => notification.remove(), 300);
}

function hideElement(element) {
    if (!element) return;
    element.style.transition = 'opacity 0.3s ease-out';
    element.style.opacity = '0';
    setTimeout(() => element.remove(), 300);
}

// Modal Functions
function initializeModal() {
    // Close modal on backdrop click
    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('modal-overlay')) {
            closeModal(e.target.nextElementSibling);
        }
    });

    // Close modal with ESC key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            const openModal = document.querySelector('.modal:not(.hidden)');
            if (openModal) closeModal(openModal);
        }
    });
}

function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;

    modal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');

    // Focus first focusable element
    const focusable = modal.querySelector('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
    if (focusable) setTimeout(() => focusable.focus(), 100);
}

function closeModal(modal) {
    if (!modal) return;
    modal.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

// Form Functions
function initializeForms() {
    // Form submission with loading state
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', handleFormSubmit);
    });

    // Real-time validation
    document.querySelectorAll('[data-validate]').forEach(input => {
        input.addEventListener('blur', () => validateField(input));
        input.addEventListener('input', () => clearFieldError(input));
    });
}

function handleFormSubmit(e) {
    const form = e.target;
    const submitBtn = form.querySelector('button[type="submit"]');

    if (submitBtn && !submitBtn.disabled) {
        const originalContent = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <div class="flex items-center justify-center">
                <div class="spinner spinner-sm border-white mr-2"></div>
                <span>Processing...</span>
            </div>
        `;

        // Reset after 5 seconds (fallback)
        setTimeout(() => {
            if (submitBtn.disabled) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalContent;
            }
        }, 5000);
    }
}

function validateField(field) {
    const validationType = field.dataset.validate;
    const value = field.value.trim();
    let isValid = true;
    let message = '';

    const validators = {
        required: () => {
            isValid = value.length > 0;
            message = 'Field ini wajib diisi';
        },
        email: () => {
            isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value) || !value;
            message = 'Format email tidak valid';
        },
        phone: () => {
            isValid = /^[\d\-\+\(\)\s]+$/.test(value) || !value;
            message = 'Format nomor telepon tidak valid';
        },
        number: () => {
            isValid = !isNaN(parseFloat(value)) || !value;
            message = 'Harus berupa angka';
        }
    };

    if (validators[validationType]) {
        validators[validationType]();
    }

    isValid ? clearFieldError(field) : showFieldError(field, message);
    return isValid;
}

function showFieldError(field, message) {
    clearFieldError(field);
    field.classList.add('border-red-500', 'focus:ring-red-500');

    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error text-red-500 text-sm mt-1';
    errorDiv.textContent = message;
    field.parentNode.appendChild(errorDiv);
}

function clearFieldError(field) {
    field.classList.remove('border-red-500', 'focus:ring-red-500');
    const error = field.parentNode.querySelector('.field-error');
    if (error) error.remove();
}

// Navigation Functions
function initializeNavigation() {
    const mobileMenuBtn = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Close on outside click
        document.addEventListener('click', (e) => {
            if (!mobileMenuBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
                mobileMenu.classList.add('hidden');
            }
        });
    }

    // Active link highlighting
    highlightActiveLink();

    // Sticky header effect
    initializeStickyHeader();
}

function highlightActiveLink() {
    const currentPath = window.location.pathname;
    document.querySelectorAll('.nav-link').forEach(link => {
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('nav-link-active');
        }
    });
}

function initializeStickyHeader() {
    const header = document.querySelector('nav');
    if (!header) return;

    let lastScroll = 0;

    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;

        if (currentScroll > 100) {
            header.classList.add('shadow-md');
        } else {
            header.classList.remove('shadow-md');
        }

        lastScroll = currentScroll;
    });
}

// Lazy Loading Images
function initializeLazyLoading() {
    if ('loading' in HTMLImageElement.prototype) {
        // Native lazy loading
        document.querySelectorAll('img[data-src]').forEach(img => {
            img.src = img.dataset.src;
            img.removeAttribute('data-src');
        });
    } else {
        // Fallback to Intersection Observer
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    observer.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }
}

// Utility Functions
const debounce = (func, wait) => {
    let timeout;
    return function executedFunction(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func(...args), wait);
    };
};

const throttle = (func, limit) => {
    let inThrottle;
    return function(...args) {
        if (!inThrottle) {
            func.apply(this, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
};

function formatNumber(num, locale = 'id-ID') {
    return new Intl.NumberFormat(locale).format(num);
}

function formatCurrency(amount, currency = 'IDR', locale = 'id-ID') {
    return new Intl.NumberFormat(locale, {
        style: 'currency',
        currency: currency
    }).format(amount);
}

function getTimeAgo(date) {
    const now = new Date();
    const diffInSeconds = Math.floor((now - new Date(date)) / 1000);

    const intervals = {
        tahun: 31536000,
        bulan: 2592000,
        minggu: 604800,
        hari: 86400,
        jam: 3600,
        menit: 60
    };

    for (let [unit, seconds] of Object.entries(intervals)) {
        const interval = Math.floor(diffInSeconds / seconds);
        if (interval >= 1) {
            return `${interval} ${unit} yang lalu`;
        }
    }

    return 'Baru saja';
}

// Loading Functions
function showPageLoading() {
    const loader = document.createElement('div');
    loader.id = 'page-loader';
    loader.className = 'fixed inset-0 bg-white/90 backdrop-blur-sm flex items-center justify-center z-50';
    loader.innerHTML = `
        <div class="text-center">
            <div class="spinner spinner-lg mb-4 mx-auto"></div>
            <p class="text-gray-600 font-medium">Loading...</p>
        </div>
    `;
    document.body.appendChild(loader);
}

function hidePageLoading() {
    const loader = document.getElementById('page-loader');
    if (loader) {
        loader.style.opacity = '0';
        setTimeout(() => loader.remove(), 300);
    }
}

// Copy to Clipboard
function copyToClipboard(text) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(() => {
            showNotification('Berhasil disalin!', 'success', 2000);
        }).catch(() => {
            showNotification('Gagal menyalin', 'error', 2000);
        });
    } else {
        // Fallback
        const textarea = document.createElement('textarea');
        textarea.value = text;
        document.body.appendChild(textarea);
        textarea.select();
        try {
            document.execCommand('copy');
            showNotification('Berhasil disalin!', 'success', 2000);
        } catch (err) {
            showNotification('Gagal menyalin', 'error', 2000);
        }
        document.body.removeChild(textarea);
    }
}

// Scroll to Top Function
function scrollToTop(smooth = true) {
    window.scrollTo({
        top: 0,
        behavior: smooth ? 'smooth' : 'auto'
    });
}

// Show Scroll to Top Button
function initializeScrollToTop() {
    const scrollBtn = document.getElementById('scroll-to-top');
    if (!scrollBtn) return;

    window.addEventListener('scroll', throttle(() => {
        if (window.pageYOffset > 300) {
            scrollBtn.classList.remove('hidden');
        } else {
            scrollBtn.classList.add('hidden');
        }
    }, 200));

    scrollBtn.addEventListener('click', () => scrollToTop());
}

// Table Functions
function sortTable(table, column, direction = 'asc') {
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    const columnIndex = column;

    rows.sort((a, b) => {
        const aValue = a.children[columnIndex]?.textContent?.trim() || '';
        const bValue = b.children[columnIndex]?.textContent?.trim() || '';

        // Try numeric comparison
        const aNum = parseFloat(aValue);
        const bNum = parseFloat(bValue);

        if (!isNaN(aNum) && !isNaN(bNum)) {
            return direction === 'asc' ? aNum - bNum : bNum - aNum;
        }

        // String comparison
        return direction === 'asc'
            ? aValue.localeCompare(bValue, 'id-ID')
            : bValue.localeCompare(aValue, 'id-ID');
    });

    rows.forEach(row => tbody.appendChild(row));
}

function filterTable(table, searchTerm) {
    const tbody = table.querySelector('tbody');
    const rows = tbody.querySelectorAll('tr');
    const term = searchTerm.toLowerCase();

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(term) ? '' : 'none';
    });
}

// Tooltip System
function initializeTooltips() {
    document.querySelectorAll('[data-tooltip]').forEach(element => {
        element.addEventListener('mouseenter', showTooltip);
        element.addEventListener('mouseleave', hideTooltip);
    });
}

function showTooltip(e) {
    const element = e.target;
    const text = element.dataset.tooltip;
    if (!text) return;

    const tooltip = document.createElement('div');
    tooltip.className = 'fixed z-50 px-3 py-2 text-sm text-white bg-gray-900 rounded-lg shadow-lg pointer-events-none';
    tooltip.textContent = text;
    tooltip.id = 'tooltip-' + Date.now();

    document.body.appendChild(tooltip);

    const rect = element.getBoundingClientRect();
    const tooltipRect = tooltip.getBoundingClientRect();

    tooltip.style.top = (rect.top - tooltipRect.height - 8) + 'px';
    tooltip.style.left = (rect.left + (rect.width - tooltipRect.width) / 2) + 'px';

    element._tooltip = tooltip;
}

function hideTooltip(e) {
    const element = e.target;
    if (element._tooltip) {
        element._tooltip.remove();
        element._tooltip = null;
    }
}

// Chart Helper (if using Chart.js)
function createChart(canvasId, type, data, options = {}) {
    const canvas = document.getElementById(canvasId);
    if (!canvas || typeof Chart === 'undefined') return null;

    const defaultOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 15,
                    usePointStyle: true
                }
            }
        }
    };

    return new Chart(canvas, {
        type: type,
        data: data,
        options: { ...defaultOptions, ...options }
    });
}

// Export to CSV
function exportToCSV(data, filename = 'export.csv') {
    const csv = data.map(row => row.join(',')).join('\n');
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    a.click();
    window.URL.revokeObjectURL(url);
}

// Print Function
function printPage() {
    window.print();
}

// Confirm Dialog
function confirmDialog(message, onConfirm, onCancel) {
    const dialog = document.createElement('div');
    dialog.className = 'fixed inset-0 z-50 flex items-center justify-center';
    dialog.innerHTML = `
        <div class="modal-overlay fixed inset-0 bg-black bg-opacity-50"></div>
        <div class="modal-content relative bg-white rounded-xl p-6 max-w-md mx-4 shadow-xl">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Konfirmasi</h3>
            <p class="text-gray-600 mb-6">${message}</p>
            <div class="flex gap-3 justify-end">
                <button class="btn-secondary btn-sm" data-action="cancel">Batal</button>
                <button class="btn-primary btn-sm" data-action="confirm">Ya, Lanjutkan</button>
            </div>
        </div>
    `;

    document.body.appendChild(dialog);

    dialog.querySelector('[data-action="confirm"]').addEventListener('click', () => {
        if (onConfirm) onConfirm();
        dialog.remove();
    });

    dialog.querySelector('[data-action="cancel"]').addEventListener('click', () => {
        if (onCancel) onCancel();
        dialog.remove();
    });

    dialog.querySelector('.modal-overlay').addEventListener('click', () => {
        if (onCancel) onCancel();
        dialog.remove();
    });
}

// Local Storage Helper
function saveToStorage(key, value) {
    try {
        localStorage.setItem(key, JSON.stringify(value));
        return true;
    } catch (e) {
        console.warn('Could not save to localStorage:', e);
        return false;
    }
}

function getFromStorage(key, defaultValue = null) {
    try {
        const item = localStorage.getItem(key);
        return item ? JSON.parse(item) : defaultValue;
    } catch (e) {
        console.warn('Could not read from localStorage:', e);
        return defaultValue;
    }
}

function removeFromStorage(key) {
    try {
        localStorage.removeItem(key);
        return true;
    } catch (e) {
        console.warn('Could not remove from localStorage:', e);
        return false;
    }
}

// Login Page Functions - Add this to resources/js/app.js

// Initialize Login Page
function initializeLoginPage() {
    // Password Toggle
    initializePasswordToggle();

    // Form Validation
    initializeLoginValidation();

    // Add input animations
    initializeInputAnimations();
}

// Password Toggle Functionality
function initializePasswordToggle() {
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');
    const eyeIcon = document.getElementById('eyeIcon');
    const eyeOffIcon = document.getElementById('eyeOffIcon');

    if (passwordInput && togglePassword) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;

            // Toggle icons
            eyeIcon.classList.toggle('hidden');
            eyeOffIcon.classList.toggle('hidden');

            // Add animation
            this.style.transform = 'scale(1.2)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 150);
        });
    }
}

// Login Form Validation
function initializeLoginValidation() {
    const loginForm = document.querySelector('.login-form');
    if (!loginForm) return;

    // Email validation
    const emailInput = document.getElementById('email');
    if (emailInput) {
        emailInput.addEventListener('blur', function() {
            validateEmail(this);
        });

        emailInput.addEventListener('input', function() {
            if (this.classList.contains('form-input-error')) {
                clearInputError(this);
            }
        });
    }

    // Password validation
    const passwordInput = document.getElementById('password');
    if (passwordInput) {
        passwordInput.addEventListener('blur', function() {
            validatePassword(this);
        });

        passwordInput.addEventListener('input', function() {
            if (this.classList.contains('form-input-error')) {
                clearInputError(this);
            }
        });
    }

    // Kelas validation
    const kelasSelect = document.getElementById('kelas');
    if (kelasSelect) {
        kelasSelect.addEventListener('change', function() {
            validateSelect(this);
        });

        kelasSelect.addEventListener('blur', function() {
            validateSelect(this);
        });
    }

    // Form submit handling
    loginForm.addEventListener('submit', function(e) {
        let isValid = true;

        if (emailInput && !validateEmail(emailInput)) {
            isValid = false;
        }

        if (passwordInput && !validatePassword(passwordInput)) {
            isValid = false;
        }

        if (kelasSelect && !validateSelect(kelasSelect)) {
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            showNotification('Mohon lengkapi form dengan benar', 'error', 3000);
            return false;
        }

        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        if (submitBtn) {
            const originalContent = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <div class="flex items-center justify-center gap-2">
                    <div class="spinner spinner-sm border-white"></div>
                    <span>Memproses...</span>
                </div>
            `;

            // Reset button after 10 seconds (fallback)
            setTimeout(() => {
                if (submitBtn.disabled) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalContent;
                }
            }, 10000);
        }
    });
}

// Validate Email
function validateEmail(input) {
    const value = input.value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!value) {
        showInputError(input, 'Email wajib diisi');
        return false;
    }

    if (!emailRegex.test(value)) {
        showInputError(input, 'Format email tidak valid');
        return false;
    }

    clearInputError(input);
    return true;
}

// Validate Password
function validatePassword(input) {
    const value = input.value;

    if (!value) {
        showInputError(input, 'Password wajib diisi');
        return false;
    }

    if (value.length < 6) {
        showInputError(input, 'Password minimal 6 karakter');
        return false;
    }

    clearInputError(input);
    return true;
}

// Validate Select
function validateSelect(select) {
    const value = select.value;

    if (!value) {
        showInputError(select, 'Kelas wajib dipilih');
        return false;
    }

    clearInputError(select);
    return true;
}

// Show Input Error
function showInputError(input, message) {
    // Clear previous error
    clearInputError(input);

    // Add error class
    input.classList.add('form-input-error');

    // Create error message
    const errorDiv = document.createElement('p');
    errorDiv.className = 'form-error';
    errorDiv.textContent = message;
    errorDiv.style.animation = 'fadeInUp 0.3s ease-out';

    // Insert after input
    input.parentNode.insertBefore(errorDiv, input.nextSibling);

    // Add shake animation
    input.style.animation = 'shake 0.4s ease-in-out';
    setTimeout(() => {
        input.style.animation = '';
    }, 400);
}

// Clear Input Error
function clearInputError(input) {
    input.classList.remove('form-input-error');

    // Remove error message
    const formGroup = input.closest('.form-group') || input.parentNode;
    const existingError = formGroup.querySelector('.form-error');
    if (existingError) {
        existingError.style.animation = 'fadeOut 0.2s ease-out';
        setTimeout(() => existingError.remove(), 200);
    }
}

// Input Animations
function initializeInputAnimations() {
    const inputs = document.querySelectorAll('.form-input, .form-select');

    inputs.forEach(input => {
        // Add focus effect
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.01)';
            this.parentElement.style.transition = 'transform 0.2s ease';
        });

        // Remove focus effect
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });

        // Add ripple effect on click
        input.addEventListener('click', function(e) {
            createRipple(e, this);
        });
    });
}

// Create Ripple Effect
function createRipple(event, element) {
    const ripple = document.createElement('span');
    const rect = element.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    const x = event.clientX - rect.left - size / 2;
    const y = event.clientY - rect.top - size / 2;

    ripple.style.cssText = `
        position: absolute;
        width: ${size}px;
        height: ${size}px;
        border-radius: 50%;
        background: rgba(147, 51, 234, 0.1);
        left: ${x}px;
        top: ${y}px;
        pointer-events: none;
        animation: ripple 0.6s ease-out;
    `;

    // Ensure parent is positioned
    if (element.parentElement.style.position !== 'relative') {
        element.parentElement.style.position = 'relative';
    }

    element.parentElement.appendChild(ripple);

    setTimeout(() => ripple.remove(), 600);
}

// Add shake animation keyframes
const style = document.createElement('style');
style.textContent = `
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }

    @keyframes fadeOut {
        from { opacity: 1; transform: translateY(0); }
        to { opacity: 0; transform: translateY(-10px); }
    }

    @keyframes ripple {
        from {
            transform: scale(0);
            opacity: 0.4;
        }
        to {
            transform: scale(2);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

// Auto-dismiss alerts after 5 seconds
function autoDismissAlerts() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.animation = 'fadeOut 0.5s ease-out';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Check if we're on login page
    if (document.querySelector('.login-page')) {
        initializeLoginPage();
    }

    // Auto-dismiss alerts
    autoDismissAlerts();
});

// Add to SMP54 namespace
if (window.SMP54) {
    window.SMP54 = {
        ...window.SMP54,
        // Login specific functions
        validateEmail,
        validatePassword,
        validateSelect,
        showInputError,
        clearInputError
    };
}

console.log('Login Page Functions Loaded ✓');

// Export all functions as SMP54 namespace
window.SMP54 = {
    // Notification functions
    showNotification,
    hideNotification,

    // Modal functions
    openModal,
    closeModal,

    // Form functions
    validateField,
    showFieldError,
    clearFieldError,

    // Utility functions
    debounce,
    throttle,
    formatNumber,
    formatCurrency,
    getTimeAgo,
    copyToClipboard,
    scrollToTop,

    // Loading functions
    showPageLoading,
    hidePageLoading,

    // Table functions
    sortTable,
    filterTable,

    // Chart function
    createChart,

    // Export functions
    exportToCSV,
    printPage,

    // Dialog functions
    confirmDialog,

    // Storage functions
    saveToStorage,
    getFromStorage,
    removeFromStorage
};

// Initialize scroll to top button
initializeScrollToTop();

// Initialize tooltips
initializeTooltips();

console.log('SMP 54 Surabaya - System Initialized ✓');
