{{-- resources/views/components/toast-notification.blade.php --}}
<div id="toastContainer" class="fixed top-4 right-4 z-[9999] space-y-3 pointer-events-none">
    <!-- Toast items akan ditambahkan di sini via JavaScript -->
</div>

<style>
@keyframes slideInRight {
    from {
        transform: translateX(400px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOutRight {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(400px);
        opacity: 0;
    }
}

@keyframes checkmark {
    0% {
        stroke-dashoffset: 100;
    }
    100% {
        stroke-dashoffset: 0;
    }
}

@keyframes cross {
    0% {
        stroke-dashoffset: 100;
    }
    100% {
        stroke-dashoffset: 0;
    }
}

@keyframes scaleIn {
    0% {
        transform: scale(0);
    }
    50% {
        transform: scale(1.2);
    }
    100% {
        transform: scale(1);
    }
}

.toast-item {
    animation: slideInRight 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.toast-item.removing {
    animation: slideOutRight 0.3s ease-in forwards;
}

.toast-icon-success {
    animation: scaleIn 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55) 0.2s backwards;
}

.toast-icon-error {
    animation: scaleIn 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55) 0.2s backwards;
}

.checkmark-path {
    stroke-dasharray: 100;
    stroke-dashoffset: 100;
    animation: checkmark 0.6s ease-in-out 0.4s forwards;
}

.cross-path {
    stroke-dasharray: 100;
    stroke-dashoffset: 100;
    animation: cross 0.6s ease-in-out 0.4s forwards;
}

.progress-bar {
    animation: progressBar 5s linear forwards;
}

@keyframes progressBar {
    from {
        width: 100%;
    }
    to {
        width: 0%;
    }
}
</style>

<script>
class ToastNotification {
    constructor() {
        this.container = document.getElementById('toastContainer');
        this.toasts = [];
    }

    show(options = {}) {
        const {
            type = 'success',
            title = '',
            message = '',
            duration = 5000,
            showProgress = true
        } = options;

        const toastId = 'toast-' + Date.now() + Math.random();
        const toast = this.createToast(toastId, type, title, message, showProgress);

        this.container.appendChild(toast);
        this.toasts.push({ id: toastId, element: toast });

        // Auto dismiss
        if (duration > 0) {
            setTimeout(() => {
                this.dismiss(toastId);
            }, duration);
        }

        return toastId;
    }

    createToast(id, type, title, message, showProgress) {
        const toast = document.createElement('div');
        toast.id = id;
        toast.className = `toast-item pointer-events-auto w-96 bg-white rounded-xl shadow-2xl overflow-hidden border-l-4 ${
            type === 'success' ? 'border-green-500' : 'border-red-500'
        }`;

        const icon = type === 'success'
            ? this.getSuccessIcon()
            : this.getErrorIcon();

        const progressBar = showProgress
            ? `<div class="absolute bottom-0 left-0 h-1 bg-${type === 'success' ? 'green' : 'red'}-500 progress-bar"></div>`
            : '';

        toast.innerHTML = `
            <div class="relative p-4">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 toast-icon-${type}">
                        ${icon}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-lg font-bold text-gray-900 mb-1">${title}</h4>
                        <p class="text-sm text-gray-600">${message}</p>
                    </div>
                    <button onclick="window.toast.dismiss('${id}')" class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                ${progressBar}
            </div>
        `;

        return toast;
    }

    getSuccessIcon() {
        return `
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <circle cx="12" cy="12" r="10" stroke="#10b981" stroke-width="2" fill="none" />
                    <path class="checkmark-path" d="M8 12l3 3 5-5" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none" />
                </svg>
            </div>
        `;
    }

    getErrorIcon() {
        return `
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <circle cx="12" cy="12" r="10" stroke="#ef4444" stroke-width="2" fill="none" />
                    <path class="cross-path" d="M8 8l8 8M16 8l-8 8" stroke="#ef4444" stroke-width="2" stroke-linecap="round" fill="none" />
                </svg>
            </div>
        `;
    }

    success(title, message, duration = 5000) {
        return this.show({
            type: 'success',
            title: title,
            message: message,
            duration: duration
        });
    }

    error(title, message, duration = 5000) {
        return this.show({
            type: 'error',
            title: title,
            message: message,
            duration: duration
        });
    }

    dismiss(toastId) {
        const toastIndex = this.toasts.findIndex(t => t.id === toastId);
        if (toastIndex === -1) return;

        const toast = this.toasts[toastIndex].element;
        toast.classList.add('removing');

        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
            this.toasts.splice(toastIndex, 1);
        }, 300);
    }

    dismissAll() {
        this.toasts.forEach(({ id }) => this.dismiss(id));
    }
}

// Initialize global toast instance
window.toast = new ToastNotification();
</script>
