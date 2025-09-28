import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Setup CSRF Token
const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

// Setup Axios interceptors
window.axios.interceptors.request.use(
    config => {
        // Show loading indicator
        if (config.showLoading !== false) {
            const loader = document.getElementById('ajax-loader');
            if (loader) {
                loader.classList.remove('hidden');
            }
        }
        return config;
    },
    error => {
        return Promise.reject(error);
    }
);

window.axios.interceptors.response.use(
    response => {
        // Hide loading indicator
        const loader = document.getElementById('ajax-loader');
        if (loader) {
            loader.classList.add('hidden');
        }

        // Show success notification if exists
        if (response.data && response.data.message) {
            if (typeof window.SMP54 !== 'undefined' && window.SMP54.showNotification) {
                window.SMP54.showNotification(response.data.message, 'success');
            }
        }

        return response;
    },
    error => {
        // Hide loading indicator
        const loader = document.getElementById('ajax-loader');
        if (loader) {
            loader.classList.add('hidden');
        }

        // Handle different error types
        if (error.response) {
            // Server responded with error status
            const status = error.response.status;
            const data = error.response.data;

            let message = 'Terjadi kesalahan';

            switch (status) {
                case 400:
                    message = 'Permintaan tidak valid';
                    break;
                case 401:
                    message = 'Anda tidak memiliki akses';
                    window.location.href = '/login';
                    return;
                case 403:
                    message = 'Akses ditolak';
                    break;
                case 404:
                    message = 'Halaman tidak ditemukan';
                    break;
                case 422:
                    // Validation errors
                    if (data.errors) {
                        const firstError = Object.values(data.errors)[0];
                        message = Array.isArray(firstError) ? firstError[0] : firstError;
                    } else if (data.message) {
                        message = data.message;
                    }
                    break;
                case 429:
                    message = 'Terlalu banyak permintaan, coba lagi nanti';
                    break;
                case 500:
                    message = 'Kesalahan server internal';
                    break;
                default:
                    message = data.message || 'Terjadi kesalahan';
            }

            // Show error notification
            if (typeof window.SMP54 !== 'undefined' && window.SMP54.showNotification) {
                window.SMP54.showNotification(message, 'error');
            } else {
                console.error('Error:', message);
                alert(message);
            }
        } else if (error.request) {
            // Network error
            const message = 'Tidak dapat terhubung ke server';
            if (typeof window.SMP54 !== 'undefined' && window.SMP54.showNotification) {
                window.SMP54.showNotification(message, 'error');
            } else {
                console.error('Network Error:', error.request);
                alert(message);
            }
        } else {
            // Other error
            console.error('Error:', error.message);
        }

        return Promise.reject(error);
    }
);

// Add global AJAX loader
document.addEventListener('DOMContentLoaded', function() {
    // Create global AJAX loader if it doesn't exist
    if (!document.getElementById('ajax-loader')) {
        const loader = document.createElement('div');
        loader.id = 'ajax-loader';
        loader.className = 'hidden fixed top-4 right-4 z-50';
        loader.innerHTML = `
            <div class="bg-blue-500 text-white px-4 py-2 rounded shadow-lg flex items-center">
                <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Loading...
            </div>
        `;
        document.body.appendChild(loader);
    }
});
