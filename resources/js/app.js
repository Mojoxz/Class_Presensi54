import './bootstrap';
import Alpine from 'alpinejs';

// Make Alpine available globally
window.Alpine = Alpine;
Alpine.start();

// Custom JavaScript untuk SMP 54 Surabaya
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    initializeComponents();
    initializeDateTime();
    initializeNotifications();
    initializeModal();
    initializeTable();
    initializeForm();
});

// Component Initialization
function initializeComponents() {
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            if (alert && alert.parentNode) {
                alert.style.transition = 'opacity 0.5s ease-out';
                alert.style.opacity = '0';
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.parentNode.removeChild(alert);
                    }
                }, 500);
            }
        }, 5000);
    });

    // Initialize tooltips
    initializeTooltips();

    // Initialize mobile menu
    initializeMobileMenu();

    // Initialize loading states
    initializeLoadingStates();
}

// Date Time Functions
function initializeDateTime() {
    // Update all datetime elements
    updateDateTime();

    // Update every second
    setInterval(updateDateTime, 1000);
}

function updateDateTime() {
    const now = new Date();

    // Update elements with specific IDs
    const timeElements = {
        'current-time': now.toLocaleTimeString('id-ID'),
        'current-date': now.toLocaleDateString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        }),
        'current-time-home': now.toLocaleDateString('id-ID', {
            weekday: 'long',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        }),
        'datetime': now.toLocaleDateString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        })
    };

    Object.keys(timeElements).forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.textContent = timeElements[id];
        }
    });

    // Update all elements with data-datetime attribute
    document.querySelectorAll('[data-datetime]').forEach(element => {
        const format = element.getAttribute('data-datetime');
        element.textContent = formatDateTime(now, format);
    });
}

function formatDateTime(date, format) {
    const options = {};

    switch(format) {
        case 'time':
            return date.toLocaleTimeString('id-ID');
        case 'date':
            return date.toLocaleDateString('id-ID');
        case 'datetime':
            return date.toLocaleDateString('id-ID', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit'
            });
        case 'full':
            return date.toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
        default:
            return date.toLocaleDateString('id-ID');
    }
}

// Notification System
function initializeNotifications() {
    // Show notifications with animation
    const notifications = document.querySelectorAll('.notification');
    notifications.forEach((notification, index) => {
        setTimeout(() => {
            notification.classList.add('notification-enter-active');
        }, index * 100);

        // Auto-hide after 5 seconds
        setTimeout(() => {
            hideNotification(notification);
        }, 5000);
    });
}

function showNotification(message, type = 'info', duration = 5000) {
    const notification = document.createElement('div');
    notification.className = `notification alert alert-${type} fixed top-4 right-4 z-50 max-w-sm`;
    notification.innerHTML = `
        <div class="flex items-center justify-between">
            <span>${message}</span>
            <button onclick="hideNotification(this.parentElement.parentElement)" class="ml-4 text-gray-400 hover:text-gray-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    `;

    document.body.appendChild(notification);

    // Show with animation
    setTimeout(() => {
        notification.classList.add('notification-enter-active');
    }, 10);

    // Auto-hide
    if (duration > 0) {
        setTimeout(() => {
            hideNotification(notification);
        }, duration);
    }

    return notification;
}

function hideNotification(notification) {
    if (!notification) return;

    notification.classList.add('notification-exit-active');
    setTimeout(() => {
        if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
        }
    }, 300);
}

// Modal Functions
function initializeModal() {
    // Close modal when clicking outside
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-backdrop')) {
            closeModal(e.target.closest('.modal'));
        }
    });

    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const openModal = document.querySelector('.modal:not(.hidden)');
            if (openModal) {
                closeModal(openModal);
            }
        }
    });
}

function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        // Focus trap
        const focusableElements = modal.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
        if (focusableElements.length > 0) {
            focusableElements[0].focus();
        }
    }
}

function closeModal(modal) {
    if (!modal) return;

    modal.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

// Table Functions
function initializeTable() {
    // Initialize sortable tables
    document.querySelectorAll('.sortable-table').forEach(table => {
        const headers = table.querySelectorAll('th[data-sort]');
        headers.forEach(header => {
            header.style.cursor = 'pointer';
            header.addEventListener('click', () => sortTable(table, header.dataset.sort));
        });
    });

    // Initialize searchable tables
    document.querySelectorAll('.searchable-table').forEach(table => {
        const searchInput = table.previousElementSibling?.querySelector('input[data-search]');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => filterTable(table, e.target.value));
        }
    });
}

function sortTable(table, column) {
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    const headerCell = table.querySelector(`th[data-sort="${column}"]`);
    const isAscending = !headerCell.classList.contains('sort-asc');

    // Remove all sort classes
    table.querySelectorAll('th').forEach(th => {
        th.classList.remove('sort-asc', 'sort-desc');
    });

    // Add sort class to current header
    headerCell.classList.add(isAscending ? 'sort-asc' : 'sort-desc');

    const columnIndex = Array.from(headerCell.parentNode.children).indexOf(headerCell);

    rows.sort((a, b) => {
        const aVal = a.children[columnIndex]?.textContent?.trim() || '';
        const bVal = b.children[columnIndex]?.textContent?.trim() || '';

        // Try to parse as numbers
        const aNum = parseFloat(aVal);
        const bNum = parseFloat(bVal);

        if (!isNaN(aNum) && !isNaN(bNum)) {
            return isAscending ? aNum - bNum : bNum - aNum;
        }

        // String comparison
        return isAscending
            ? aVal.localeCompare(bVal, 'id-ID')
            : bVal.localeCompare(aVal, 'id-ID');
    });

    // Reappend sorted rows
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

// Form Functions
function initializeForm() {
    // Auto-save form data to localStorage (if supported)
    document.querySelectorAll('form[data-auto-save]').forEach(form => {
        const formId = form.dataset.autoSave;
        loadFormData(form, formId);

        form.addEventListener('input', () => {
            saveFormData(form, formId);
        });
    });

    // Form validation
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', handleFormSubmit);
    });

    // Real-time validation
    document.querySelectorAll('input[data-validate], select[data-validate], textarea[data-validate]').forEach(input => {
        input.addEventListener('blur', () => validateField(input));
        input.addEventListener('input', () => clearFieldError(input));
    });
}

function saveFormData(form, formId) {
    if (!window.localStorage) return;

    const data = new FormData(form);
    const formData = {};

    for (let [key, value] of data.entries()) {
        formData[key] = value;
    }

    try {
        localStorage.setItem(`form-${formId}`, JSON.stringify(formData));
    } catch (e) {
        console.warn('Could not save form data:', e);
    }
}

function loadFormData(form, formId) {
    if (!window.localStorage) return;

    try {
        const saved = localStorage.getItem(`form-${formId}`);
        if (saved) {
            const formData = JSON.parse(saved);

            Object.keys(formData).forEach(key => {
                const field = form.querySelector(`[name="${key}"]`);
                if (field) {
                    field.value = formData[key];
                }
            });
        }
    } catch (e) {
        console.warn('Could not load form data:', e);
    }
}

function validateField(field) {
    const validationType = field.dataset.validate;
    const value = field.value.trim();
    let isValid = true;
    let message = '';

    switch (validationType) {
        case 'required':
            isValid = value.length > 0;
            message = 'Field ini wajib diisi';
            break;
        case 'email':
            isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value) || value === '';
            message = 'Format email tidak valid';
            break;
        case 'phone':
            isValid = /^[\d\-\+\(\)\s]+$/.test(value) || value === '';
            message = 'Format nomor telepon tidak valid';
            break;
        case 'number':
            isValid = !isNaN(parseFloat(value)) || value === '';
            message = 'Harus berupa angka';
            break;
        case 'min-length':
            const minLength = parseInt(field.dataset.minLength) || 0;
            isValid = value.length >= minLength || value === '';
            message = `Minimal ${minLength} karakter`;
            break;
    }

    if (!isValid) {
        showFieldError(field, message);
    } else {
        clearFieldError(field);
    }

    return isValid;
}

function showFieldError(field, message) {
    clearFieldError(field);

    field.classList.add('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');

    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error text-red-500 text-xs mt-1';
    errorDiv.textContent = message;

    field.parentNode.appendChild(errorDiv);
}

function clearFieldError(field) {
    field.classList.remove('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');

    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
}

function handleFormSubmit(e) {
    const form = e.target;
    const submitButton = form.querySelector('button[type="submit"]');

    // Show loading state
    if (submitButton) {
        const originalText = submitButton.textContent;
        submitButton.disabled = true;
        submitButton.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Processing...
        `;

        // Reset button after 5 seconds (fallback)
        setTimeout(() => {
            if (submitButton.disabled) {
                submitButton.disabled = false;
                submitButton.textContent = originalText;
            }
        }, 5000);
    }
}

// Tooltip Functions
function initializeTooltips() {
    document.querySelectorAll('[data-tooltip]').forEach(element => {
        element.addEventListener('mouseenter', showTooltip);
        element.addEventListener('mouseleave', hideTooltip);
        element.addEventListener('focus', showTooltip);
        element.addEventListener('blur', hideTooltip);
    });
}

function showTooltip(e) {
    const element = e.target;
    const text = element.dataset.tooltip;
    const position = element.dataset.tooltipPosition || 'top';

    if (!text) return;

    const tooltip = document.createElement('div');
    tooltip.className = `tooltip absolute z-50 px-2 py-1 text-sm text-white bg-gray-900 rounded shadow-lg pointer-events-none`;
    tooltip.textContent = text;
    tooltip.id = 'tooltip-' + Date.now();

    document.body.appendChild(tooltip);

    const rect = element.getBoundingClientRect();
    const tooltipRect = tooltip.getBoundingClientRect();

    let top, left;

    switch (position) {
        case 'top':
            top = rect.top - tooltipRect.height - 8;
            left = rect.left + (rect.width - tooltipRect.width) / 2;
            break;
        case 'bottom':
            top = rect.bottom + 8;
            left = rect.left + (rect.width - tooltipRect.width) / 2;
            break;
        case 'left':
            top = rect.top + (rect.height - tooltipRect.height) / 2;
            left = rect.left - tooltipRect.width - 8;
            break;
        case 'right':
            top = rect.top + (rect.height - tooltipRect.height) / 2;
            left = rect.right + 8;
            break;
        default:
            top = rect.top - tooltipRect.height - 8;
            left = rect.left + (rect.width - tooltipRect.width) / 2;
    }

    // Keep tooltip within viewport
    if (left < 8) left = 8;
    if (left + tooltipRect.width > window.innerWidth - 8) {
        left = window.innerWidth - tooltipRect.width - 8;
    }
    if (top < 8) top = rect.bottom + 8;

    tooltip.style.top = top + window.scrollY + 'px';
    tooltip.style.left = left + 'px';

    element._tooltip = tooltip;
}

function hideTooltip(e) {
    const element = e.target;
    if (element._tooltip) {
        element._tooltip.remove();
        element._tooltip = null;
    }
}

// Mobile Menu
function initializeMobileMenu() {
    const mobileMenuButton = document.querySelector('[data-mobile-menu-button]');
    const mobileMenu = document.querySelector('[data-mobile-menu]');

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', () => {
            const isOpen = !mobileMenu.classList.contains('hidden');

            if (isOpen) {
                mobileMenu.classList.add('hidden');
                mobileMenuButton.setAttribute('aria-expanded', 'false');
            } else {
                mobileMenu.classList.remove('hidden');
                mobileMenuButton.setAttribute('aria-expanded', 'true');
            }
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!mobileMenuButton.contains(e.target) && !mobileMenu.contains(e.target)) {
                mobileMenu.classList.add('hidden');
                mobileMenuButton.setAttribute('aria-expanded', 'false');
            }
        });
    }
}

// Loading States
function initializeLoadingStates() {
    // Add loading state to links with data-loading attribute
    document.querySelectorAll('a[data-loading]').forEach(link => {
        link.addEventListener('click', (e) => {
            if (!e.target.href || e.target.href === '#') return;

            showPageLoading();
        });
    });
}

function showPageLoading() {
    const loader = document.createElement('div');
    loader.id = 'page-loader';
    loader.className = 'fixed inset-0 bg-white bg-opacity-90 flex items-center justify-center z-50';
    loader.innerHTML = `
        <div class="text-center">
            <div class="loading-spinner mx-auto mb-4"></div>
            <p class="text-gray-600">Loading...</p>
        </div>
    `;

    document.body.appendChild(loader);
}

function hidePageLoading() {
    const loader = document.getElementById('page-loader');
    if (loader) {
        loader.remove();
    }
}

// Utility Functions
function debounce(func, wait, immediate) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            timeout = null;
            if (!immediate) func(...args);
        };
        const callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func(...args);
    };
}

function throttle(func, limit) {
    let inThrottle;
    return function(...args) {
        if (!inThrottle) {
            func.apply(this, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

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

// Chart Helper (if using Chart.js)
function createChart(canvasId, type, data, options = {}) {
    const ctx = document.getElementById(canvasId);
    if (!ctx || typeof Chart === 'undefined') return null;

    const defaultOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    };

    return new Chart(ctx, {
        type: type,
        data: data,
        options: { ...defaultOptions, ...options }
    });
}

// Export functions for global use
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

    // Loading functions
    showPageLoading,
    hidePageLoading,

    // Chart function
    createChart
};

// Service Worker Registration (optional)
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js')
            .then((registration) => {
                console.log('SW registered: ', registration);
            })
            .catch((registrationError) => {
                console.log('SW registration failed: ', registrationError);
            });
    });
}
