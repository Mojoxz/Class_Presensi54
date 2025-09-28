// Student Panel Specific JavaScript
document.addEventListener('DOMContentLoaded', function() {
    initializeStudentFeatures();
    initializePresensiFeatures();
    initializeProgressTracking();
    initializeNotificationCenter();
});

// Student Features Initialization
function initializeStudentFeatures() {
    // Initialize real-time clock
    initializeRealtimeClock();

    // Initialize attendance reminder
    initializeAttendanceReminder();

    // Initialize progress animations
    initializeProgressAnimations();

    // Initialize quick stats
    initializeQuickStats();
}

// Real-time Clock
function initializeRealtimeClock() {
    updateClock();
    setInterval(updateClock, 1000);
}

function updateClock() {
    const now = new Date();

    // Update multiple clock elements
    const clockElements = document.querySelectorAll('.real-time-clock');
    clockElements.forEach(element => {
        const format = element.dataset.format || 'full';
        element.textContent = formatTime(now, format);
    });

    // Update date elements
    const dateElements = document.querySelectorAll('.real-time-date');
    dateElements.forEach(element => {
        const format = element.dataset.format || 'long';
        element.textContent = formatDate(now, format);
    });

    // Check if it's time for attendance reminder
    checkAttendanceReminder(now);
}

function formatTime(date, format) {
    const options = {
        hour: '2-digit',
        minute: '2-digit',
        second: format === 'full' ? '2-digit' : undefined,
        hour12: false
    };

    return date.toLocaleTimeString('id-ID', options);
}

function formatDate(date, format) {
    let options = {};

    switch (format) {
        case 'short':
            options = { day: '2-digit', month: '2-digit', year: 'numeric' };
            break;
        case 'medium':
            options = { day: 'numeric', month: 'short', year: 'numeric' };
            break;
        case 'long':
        default:
            options = {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            };
            break;
    }

    return date.toLocaleDateString('id-ID', options);
}

// Presensi Features
function initializePresensiFeatures() {
    // Presensi buttons
    const presensiMasukBtn = document.getElementById('presensi-masuk-btn');
    const presensiKeluarBtn = document.getElementById('presensi-keluar-btn');

    if (presensiMasukBtn) {
        presensiMasukBtn.addEventListener('click', handlePresensiMasuk);
    }

    if (presensiKeluarBtn) {
        presensiKeluarBtn.addEventListener('click', handlePresensiKeluar);
    }

    // Auto-check attendance status
    checkAttendanceStatus();

    // Location-based attendance (if supported)
    if (navigator.geolocation) {
        initializeLocationBasedAttendance();
    }
}

function handlePresensiMasuk(e) {
    e.preventDefault();

    const button = e.target;
    const originalText = button.textContent;
    const form = button.closest('form');

    // Show loading state
    button.disabled = true;
    button.innerHTML = `
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Processing...
    `;

    // Get current location (optional)
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                // Add location data to form
                const latInput = document.createElement('input');
                latInput.type = 'hidden';
                latInput.name = 'latitude';
                latInput.value = position.coords.latitude;

                const lngInput = document.createElement('input');
                lngInput.type = 'hidden';
                lngInput.name = 'longitude';
                lngInput.value = position.coords.longitude;

                form.appendChild(latInput);
                form.appendChild(lngInput);

                submitPresensiForm(form, button, originalText);
            },
            (error) => {
                console.warn('Could not get location:', error);
                submitPresensiForm(form, button, originalText);
            }
        );
    } else {
        submitPresensiForm(form, button, originalText);
    }
}

function handlePresensiKeluar(e) {
    e.preventDefault();

    const button = e.target;
    const originalText = button.textContent;
    const form = button.closest('form');

    // Show confirmation
    if (!confirm('Apakah Anda yakin ingin melakukan presensi keluar?')) {
        return;
    }

    // Show loading state
    button.disabled = true;
    button.innerHTML = `
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Processing...
    `;

    submitPresensiForm(form, button, originalText);
}

function submitPresensiForm(form, button, originalText) {
    // Add current timestamp
    const timestampInput = document.createElement('input');
    timestampInput.type = 'hidden';
    timestampInput.name = 'timestamp';
    timestampInput.value = new Date().toISOString();
    form.appendChild(timestampInput);

    // Submit form
    form.submit();

    // Restore button after timeout (fallback)
    setTimeout(() => {
        button.disabled = false;
        button.textContent = originalText;
    }, 5000);
}

function checkAttendanceStatus() {
    // Check if student has already done attendance today
    const now = new Date();
    const presensiInfo = document.querySelector('.presensi-info');

    if (presensiInfo) {
        const hasPresensiMasuk = presensiInfo.dataset.hasPresensiMasuk === 'true';
        const hasPresensiKeluar = presensiInfo.dataset.hasPresensiKeluar === 'true';

        // Update UI based on attendance status
        updateAttendanceUI(hasPresensiMasuk, hasPresensiKeluar);
    }
}

function updateAttendanceUI(hasPresensiMasuk, hasPresensiKeluar) {
    const presensiMasukBtn = document.getElementById('presensi-masuk-btn');
    const presensiKeluarBtn = document.getElementById('presensi-keluar-btn');

    if (presensiMasukBtn) {
        if (hasPresensiMasuk) {
            presensiMasukBtn.disabled = true;
            presensiMasukBtn.textContent = 'Sudah Presensi Masuk';
            presensiMasukBtn.classList.remove('bg-green-500', 'hover:bg-green-600');
            presensiMasukBtn.classList.add('bg-gray-400');
        }
    }

    if (presensiKeluarBtn) {
        if (!hasPresensiMasuk) {
            presensiKeluarBtn.disabled = true;
            presensiKeluarBtn.classList.add('opacity-50');
        } else if (hasPresensiKeluar) {
            presensiKeluarBtn.disabled = true;
            presensiKeluarBtn.textContent = 'Sudah Presensi Keluar';
            presensiKeluarBtn.classList.remove('bg-red-500', 'hover:bg-red-600');
            presensiKeluarBtn.classList.add('bg-gray-400');
        }
    }
}

// Attendance Reminder
function initializeAttendanceReminder() {
    // Set reminder times
    const reminderTimes = [
        { hour: 7, minute: 30, message: 'Jangan lupa presensi masuk!' },
        { hour: 14, minute: 30, message: 'Jangan lupa presensi keluar!' }
    ];

    // Store reminder times for checking
    window.attendanceReminders = reminderTimes;
}

function checkAttendanceReminder(currentTime) {
    if (!window.attendanceReminders) return;

    const hour = currentTime.getHours();
    const minute = currentTime.getMinutes();
    const currentTimeKey = `${hour}:${minute}`;

    // Check if we've already shown reminder for this time
    const shownReminders = JSON.parse(localStorage.getItem('shownReminders') || '[]');
    const todayKey = currentTime.toDateString();

    window.attendanceReminders.forEach((reminder, index) => {
        if (hour === reminder.hour && minute === reminder.minute) {
            const reminderKey = `${todayKey}-${index}`;

            if (!shownReminders.includes(reminderKey)) {
                showAttendanceReminder(reminder.message);
                shownReminders.push(reminderKey);
                localStorage.setItem('shownReminders', JSON.stringify(shownReminders));
            }
        }
    });

    // Clean old reminders (keep only today's)
    const todayReminders = shownReminders.filter(key => key.startsWith(todayKey));
    if (todayReminders.length !== shownReminders.length) {
        localStorage.setItem('shownReminders', JSON.stringify(todayReminders));
    }
}

function showAttendanceReminder(message) {
    if (typeof window.SMP54 !== 'undefined' && window.SMP54.showNotification) {
        window.SMP54.showNotification(message, 'info', 5000);
    }

    // Also show browser notification if permission is granted
    if (Notification.permission === 'granted') {
        new Notification('SMP 54 Surabaya', {
            body: message,
            icon: '/favicon.ico'
        });
    }
}

// Location-based Attendance
function initializeLocationBasedAttendance() {
    // School coordinates (example - replace with actual coordinates)
    const schoolLocation = {
        latitude: -7.2575,  // Example: Surabaya coordinates
        longitude: 112.7521
    };

    const maxDistance = 100; // meters

    window.schoolLocation = schoolLocation;
    window.maxDistance = maxDistance;
}

function checkLocationForAttendance(callback) {
    if (!navigator.geolocation) {
        callback(true, 'Geolocation not supported');
        return;
    }

    navigator.geolocation.getCurrentPosition(
        (position) => {
            const distance = calculateDistance(
                position.coords.latitude,
                position.coords.longitude,
                window.schoolLocation.latitude,
                window.schoolLocation.longitude
            );

            const isWithinRange = distance <= window.maxDistance;
            callback(isWithinRange, isWithinRange ? 'Dalam area sekolah' : `Jarak: ${Math.round(distance)}m dari sekolah`);
        },
        (error) => {
            callback(true, 'Could not get location: ' + error.message);
        }
    );
}

function calculateDistance(lat1, lon1, lat2, lon2) {
    const R = 6371e3; // Earth's radius in meters
    const φ1 = lat1 * Math.PI/180;
    const φ2 = lat2 * Math.PI/180;
    const Δφ = (lat2-lat1) * Math.PI/180;
    const Δλ = (lon2-lon1) * Math.PI/180;

    const a = Math.sin(Δφ/2) * Math.sin(Δφ/2) +
              Math.cos(φ1) * Math.cos(φ2) *
              Math.sin(Δλ/2) * Math.sin(Δλ/2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));

    return R * c; // Distance in meters
}

// Progress Tracking
function initializeProgressTracking() {
    // Animate progress bars
    document.querySelectorAll('.progress-bar').forEach(progressBar => {
        const percentage = parseFloat(progressBar.dataset.percentage || 0);
        const fill = progressBar.querySelector('.progress-fill');

        if (fill) {
            // Animate from 0 to target percentage
            setTimeout(() => {
                fill.style.width = percentage + '%';
            }, 500);
        }
    });

    // Update attendance streak
    updateAttendanceStreak();

    // Initialize goal tracking
    initializeGoalTracking();
}

function updateAttendanceStreak() {
    const streakElement = document.querySelector('.attendance-streak');
    if (!streakElement) return;

    const currentStreak = parseInt(streakElement.dataset.streak || 0);
    const targetStreak = parseInt(streakElement.dataset.target || 30);

    // Animate streak counter
    let count = 0;
    const increment = currentStreak / 50; // 50 animation frames

    const timer = setInterval(() => {
        count += increment;
        if (count >= currentStreak) {
            count = currentStreak;
            clearInterval(timer);
        }

        streakElement.querySelector('.streak-count').textContent = Math.floor(count);
    }, 20);

    // Update progress ring if exists
    const progressRing = streakElement.querySelector('.progress-ring');
    if (progressRing) {
        const percentage = (currentStreak / targetStreak) * 100;
        progressRing.style.strokeDashoffset = 283 - (283 * percentage / 100);
    }
}

function initializeGoalTracking() {
    // Monthly attendance goal
    const monthlyGoal = document.querySelector('.monthly-goal');
    if (monthlyGoal) {
        const current = parseInt(monthlyGoal.dataset.current || 0);
        const target = parseInt(monthlyGoal.dataset.target || 20);
        const percentage = Math.min((current / target) * 100, 100);

        // Update goal progress
        const progressBar = monthlyGoal.querySelector('.goal-progress');
        if (progressBar) {
            setTimeout(() => {
                progressBar.style.width = percentage + '%';
            }, 300);
        }

        // Update goal text
        const goalText = monthlyGoal.querySelector('.goal-text');
        if (goalText) {
            goalText.textContent = `${current} / ${target} hari`;
        }

        // Show achievement if goal reached
        if (current >= target) {
            setTimeout(() => {
                showAchievementNotification('Selamat! Target kehadiran bulanan tercapai! 🎉');
            }, 1000);
        }
    }
}

function showAchievementNotification(message) {
    // Create special achievement notification
    const achievement = document.createElement('div');
    achievement.className = 'achievement-notification fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-yellow-400 text-yellow-900 px-6 py-4 rounded-lg shadow-2xl z-50 text-center max-w-sm';
    achievement.innerHTML = `
        <div class="text-2xl mb-2">🏆</div>
        <div class="font-bold text-lg mb-2">Achievement Unlocked!</div>
        <div>${message}</div>
    `;

    document.body.appendChild(achievement);

    // Animate in
    achievement.style.opacity = '0';
    achievement.style.transform = 'translate(-50%, -50%) scale(0.8)';

    setTimeout(() => {
        achievement.style.transition = 'all 0.5s ease-out';
        achievement.style.opacity = '1';
        achievement.style.transform = 'translate(-50%, -50%) scale(1)';
    }, 100);

    // Remove after 5 seconds
    setTimeout(() => {
        achievement.style.transition = 'all 0.3s ease-in';
        achievement.style.opacity = '0';
        achievement.style.transform = 'translate(-50%, -50%) scale(0.8)';

        setTimeout(() => {
            if (achievement.parentNode) {
                achievement.parentNode.removeChild(achievement);
            }
        }, 300);
    }, 5000);
}

// Progress Animations
function initializeProgressAnimations() {
    // Intersection Observer for animating elements when they come into view
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in-up');
            }
        });
    });

    // Observe stat cards
    document.querySelectorAll('.stat-card').forEach(card => {
        observer.observe(card);
    });

    // Observe progress elements
    document.querySelectorAll('.progress-item').forEach(item => {
        observer.observe(item);
    });
}

// Quick Stats
function initializeQuickStats() {
    // Update quick stats with animation
    document.querySelectorAll('.quick-stat').forEach((stat, index) => {
        const value = parseInt(stat.dataset.value || 0);
        const duration = 1000 + (index * 200); // Stagger animations

        setTimeout(() => {
            animateStatValue(stat, 0, value, duration);
        }, index * 100);
    });
}

function animateStatValue(element, start, end, duration) {
    const range = end - start;
    const increment = range / (duration / 16);
    let current = start;

    const timer = setInterval(() => {
        current += increment;

        if ((increment > 0 && current >= end) || (increment < 0 && current <= end)) {
            current = end;
            clearInterval(timer);
        }

        const valueElement = element.querySelector('.stat-value');
        if (valueElement) {
            valueElement.textContent = Math.floor(current);
        }
    }, 16);
}

// Notification Center
function initializeNotificationCenter() {
    // Check for unread notifications
    checkUnreadNotifications();

    // Initialize notification permissions
    requestNotificationPermission();

    // Setup notification handlers
    setupNotificationHandlers();
}

function checkUnreadNotifications() {
    // This would typically fetch from server
    const unreadCount = parseInt(document.querySelector('.notification-badge')?.textContent || 0);

    if (unreadCount > 0) {
        // Update notification indicator
        updateNotificationIndicator(unreadCount);
    }
}

function updateNotificationIndicator(count) {
    const badge = document.querySelector('.notification-badge');
    if (badge) {
        if (count > 0) {
            badge.textContent = count > 99 ? '99+' : count.toString();
            badge.classList.remove('hidden');
        } else {
            badge.classList.add('hidden');
        }
    }
}

function requestNotificationPermission() {
    if ('Notification' in window && Notification.permission === 'default') {
        Notification.requestPermission();
    }
}

function setupNotificationHandlers() {
    // Mark notifications as read when viewed
    document.querySelectorAll('.notification-item').forEach(item => {
        item.addEventListener('click', function() {
            if (!this.classList.contains('read')) {
                markNotificationAsRead(this.dataset.id);
                this.classList.add('read');
                this.classList.remove('unread');
            }
        });
    });

    // Mark all as read button
    const markAllReadBtn = document.querySelector('.mark-all-read');
    if (markAllReadBtn) {
        markAllReadBtn.addEventListener('click', markAllNotificationsAsRead);
    }
}

function markNotificationAsRead(notificationId) {
    // Send AJAX request to mark as read
    if (typeof window.axios !== 'undefined') {
        window.axios.post(`/student/notifications/${notificationId}/read`)
            .catch(error => {
                console.error('Failed to mark notification as read:', error);
            });
    }
}

function markAllNotificationsAsRead() {
    // Send AJAX request to mark all as read
    if (typeof window.axios !== 'undefined') {
        window.axios.post('/student/notifications/mark-all-read')
            .then(response => {
                // Update UI
                document.querySelectorAll('.notification-item.unread').forEach(item => {
                    item.classList.add('read');
                    item.classList.remove('unread');
                });

                updateNotificationIndicator(0);

                if (typeof window.SMP54 !== 'undefined' && window.SMP54.showNotification) {
                    window.SMP54.showNotification('Semua notifikasi telah dibaca', 'success', 2000);
                }
            })
            .catch(error => {
                console.error('Failed to mark all notifications as read:', error);
            });
    }
}

// Study Timer (optional feature)
function initializeStudyTimer() {
    const timerElement = document.getElementById('study-timer');
    if (!timerElement) return;

    let studyTime = 0; // in seconds
    let timerInterval;
    let isRunning = false;

    // Load saved study time
    const savedTime = localStorage.getItem('studyTime');
    if (savedTime) {
        studyTime = parseInt(savedTime);
        updateTimerDisplay(studyTime);
    }

    const startBtn = document.getElementById('start-timer');
    const pauseBtn = document.getElementById('pause-timer');
    const resetBtn = document.getElementById('reset-timer');

    if (startBtn) {
        startBtn.addEventListener('click', () => {
            if (!isRunning) {
                startTimer();
                startBtn.textContent = 'Running...';
                startBtn.disabled = true;
                pauseBtn.disabled = false;
            }
        });
    }

    if (pauseBtn) {
        pauseBtn.addEventListener('click', () => {
            if (isRunning) {
                pauseTimer();
                startBtn.textContent = 'Resume';
                startBtn.disabled = false;
                pauseBtn.disabled = true;
            }
        });
    }

    if (resetBtn) {
        resetBtn.addEventListener('click', () => {
            resetTimer();
            startBtn.textContent = 'Start';
            startBtn.disabled = false;
            pauseBtn.disabled = true;
        });
    }

    function startTimer() {
        isRunning = true;
        timerInterval = setInterval(() => {
            studyTime++;
            updateTimerDisplay(studyTime);
            localStorage.setItem('studyTime', studyTime.toString());
        }, 1000);
    }

    function pauseTimer() {
        isRunning = false;
        if (timerInterval) {
            clearInterval(timerInterval);
        }
    }

    function resetTimer() {
        isRunning = false;
        if (timerInterval) {
            clearInterval(timerInterval);
        }
        studyTime = 0;
        updateTimerDisplay(studyTime);
        localStorage.removeItem('studyTime');
    }

    function updateTimerDisplay(seconds) {
        const hours = Math.floor(seconds / 3600);
        const minutes = Math.floor((seconds % 3600) / 60);
        const secs = seconds % 60;

        const display = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
        timerElement.textContent = display;
    }
}

// Keyboard Shortcuts
function initializeKeyboardShortcuts() {
    document.addEventListener('keydown', (e) => {
        // Ctrl/Cmd + shortcuts
        if (e.ctrlKey || e.metaKey) {
            switch(e.key) {
                case 'p': // Presensi
                    e.preventDefault();
                    const presensiBtn = document.getElementById('presensi-masuk-btn');
                    if (presensiBtn && !presensiBtn.disabled) {
                        presensiBtn.click();
                    }
                    break;
                case 'h': // Home
                    e.preventDefault();
                    window.location.href = '/student/home';
                    break;
                case 'd': // Dashboard
                    e.preventDefault();
                    window.location.href = '/student/dashboard';
                    break;
            }
        }

        // Escape key to close modals
        if (e.key === 'Escape') {
            const openModal = document.querySelector('.modal:not(.hidden)');
            if (openModal && typeof window.SMP54 !== 'undefined') {
                window.SMP54.closeModal(openModal);
            }
        }
    });
}

// Offline Support
function initializeOfflineSupport() {
    // Check if service worker is supported
    if ('serviceWorker' in navigator) {
        // Register service worker
        navigator.serviceWorker.register('/sw.js')
            .then(registration => {
                console.log('Service Worker registered');
            })
            .catch(error => {
                console.log('Service Worker registration failed');
            });
    }

    // Handle online/offline status
    window.addEventListener('online', () => {
        if (typeof window.SMP54 !== 'undefined' && window.SMP54.showNotification) {
            window.SMP54.showNotification('Koneksi internet tersambung kembali', 'success', 3000);
        }

        // Sync any pending data
        syncPendingData();
    });

    window.addEventListener('offline', () => {
        if (typeof window.SMP54 !== 'undefined' && window.SMP54.showNotification) {
            window.SMP54.showNotification('Koneksi internet terputus. Beberapa fitur mungkin terbatas.', 'warning', 5000);
        }
    });
}

function syncPendingData() {
    // Sync any data that was stored offline
    const pendingData = localStorage.getItem('pendingAttendance');
    if (pendingData && typeof window.axios !== 'undefined') {
        const data = JSON.parse(pendingData);

        window.axios.post('/student/presensi/sync', data)
            .then(response => {
                localStorage.removeItem('pendingAttendance');
                if (typeof window.SMP54 !== 'undefined' && window.SMP54.showNotification) {
                    window.SMP54.showNotification('Data presensi berhasil disinkronisasi', 'success', 3000);
                }
            })
            .catch(error => {
                console.error('Failed to sync attendance data:', error);
            });
    }
}

// Initialize all features when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    initializeStudyTimer();
    initializeKeyboardShortcuts();
    initializeOfflineSupport();
});

// Global student functions
window.StudentPanel = {
    // Attendance functions
    handlePresensiMasuk,
    handlePresensiKeluar,
    checkLocationForAttendance,

    // Progress functions
    updateAttendanceStreak,
    showAchievementNotification,

    // Notification functions
    markNotificationAsRead,
    markAllNotificationsAsRead,

    // Timer functions
    initializeStudyTimer,

    // Utility functions
    formatTime,
    formatDate,
    calculateDistance
};
