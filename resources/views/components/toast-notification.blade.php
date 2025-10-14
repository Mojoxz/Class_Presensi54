{{-- resources/views/components/toast-notification.blade.php --}}
<div id="toastContainer" class="fixed top-8 left-1/2 -translate-x-1/2 z-[9999] space-y-3 pointer-events-none">
    <!-- Toast items akan ditambahkan di sini via JavaScript -->
</div>

<style>
@keyframes slideInDown {
    from {
        transform: translate(-50%, -100px);
        opacity: 0;
    }
    to {
        transform: translate(-50%, 0);
        opacity: 1;
    }
}

@keyframes slideOutUp {
    from {
        transform: translate(-50%, 0);
        opacity: 1;
    }
    to {
        transform: translate(-50%, -100px);
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
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
    }
}

.toast-item {
    animation: slideInDown 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    position: relative;
    left: 50%;
    transform: translateX(-50%);
}

.toast-item.removing {
    animation: slideOutUp 0.3s ease-in forwards;
}

.toast-icon {
    animation: scaleIn 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55) 0.1s backwards;
}

.checkmark-path {
    stroke-dasharray: 100;
    stroke-dashoffset: 100;
    animation: checkmark 0.5s ease-in-out 0.3s forwards;
}

.cross-path {
    stroke-dasharray: 100;
    stroke-dashoffset: 100;
    animation: cross 0.5s ease-in-out 0.3s forwards;
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
            duration = 5000
        } = options;

        const toastId = 'toast-' + Date.now() + Math.random();
        const toast = this.createToast(toastId, type, title, message);

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

    createToast(id, type, title, message) {
        const toast = document.createElement('div');
        toast.id = id;
        toast.className = 'toast-item pointer-events-auto bg-white rounded-3xl shadow-2xl overflow-hidden';
        toast.style.minWidth = '400px';

        const icon = type === 'success' ? this.getSuccessIcon() : this.getErrorIcon();

        toast.innerHTML = `
            <div class="flex flex-col items-center text-center px-12 py-8">
                <div class="toast-icon mb-5">
                    ${icon}
                </div>
                <div class="space-y-2">
                    <h4 class="text-2xl font-bold text-gray-700">${title}</h4>
                    <p class="text-base text-gray-500">${message}</p>
                </div>
            </div>
        `;

        return toast;
    }

    getSuccessIcon() {
        return `
            <div class="relative w-24 h-24 flex items-center justify-center">
                <div class="absolute inset-0 bg-green-100 rounded-full opacity-30"></div>
                <div class="absolute inset-2 bg-green-200 rounded-full opacity-40"></div>
                <svg class="w-24 h-24 relative z-10" viewBox="0 0 100 100" fill="none">
                    <circle cx="50" cy="50" r="45" stroke="#86efac" stroke-width="3" fill="none" opacity="0.5" />
                    <circle cx="50" cy="50" r="40" stroke="#4ade80" stroke-width="2" fill="none" />
                    <path class="checkmark-path" d="M30 50 L42 62 L70 34" stroke="#22c55e" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" fill="none" />
                </svg>
            </div>
        `;
    }

    getErrorIcon() {
        return `
            <div class="relative w-24 h-24 flex items-center justify-center">
                <div class="absolute inset-0 bg-red-100 rounded-full opacity-30"></div>
                <div class="absolute inset-2 bg-red-200 rounded-full opacity-40"></div>
                <svg class="w-24 h-24 relative z-10" viewBox="0 0 100 100" fill="none">
                    <circle cx="50" cy="50" r="45" stroke="#fca5a5" stroke-width="3" fill="none" opacity="0.5" />
                    <circle cx="50" cy="50" r="40" stroke="#f87171" stroke-width="2" fill="none" />
                    <path class="cross-path" d="M35 35 L65 65 M65 35 L35 65" stroke="#ef4444" stroke-width="5" stroke-linecap="round" fill="none" />
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
