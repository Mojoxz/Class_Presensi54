// Admin Panel Specific JavaScript
document.addEventListener('DOMContentLoaded', function() {
    initializeAdminFeatures();
    initializeCharts();
    initializeDataTables();
    initializeFileUpload();
    initializeBulkActions();
});

// Admin Features Initialization
function initializeAdminFeatures() {
    // Initialize dashboard widgets
    initializeDashboardWidgets();

    // Initialize export functions
    initializeExportButtons();

    // Initialize quick actions
    initializeQuickActions();

    // Initialize advanced filters
    initializeAdvancedFilters();
}

// Dashboard Widgets
function initializeDashboardWidgets() {
    // Auto-refresh dashboard stats every 5 minutes
    setInterval(() => {
        refreshDashboardStats();
    }, 300000); // 5 minutes

    // Initialize widget toggles
    document.querySelectorAll('.widget-toggle').forEach(toggle => {
        toggle.addEventListener('click', function() {
            const widget = this.closest('.widget');
            const content = widget.querySelector('.widget-content');

            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                this.innerHTML = '−';
            } else {
                content.classList.add('hidden');
                this.innerHTML = '+';
            }
        });
    });
}

function refreshDashboardStats() {
    if (typeof window.axios !== 'undefined') {
        window.axios.get('/admin/dashboard/stats', { showLoading: false })
            .then(response => {
                updateDashboardStats(response.data);
            })
            .catch(error => {
                console.warn('Could not refresh dashboard stats:', error);
            });
    }
}

function updateDashboardStats(data) {
    // Update stat cards
    Object.keys(data).forEach(key => {
        const element = document.querySelector(`[data-stat="${key}"]`);
        if (element) {
            // Animate number change
            animateNumber(element, parseInt(element.textContent) || 0, data[key]);
        }
    });
}

function animateNumber(element, start, end, duration = 1000) {
    const range = end - start;
    const increment = range / (duration / 16);
    let current = start;

    const timer = setInterval(() => {
        current += increment;

        if ((increment > 0 && current >= end) || (increment < 0 && current <= end)) {
            current = end;
            clearInterval(timer);
        }

        element.textContent = Math.floor(current).toLocaleString('id-ID');
    }, 16);
}

// Charts Initialization
function initializeCharts() {
    // Presensi Chart
    const presensiChartCanvas = document.getElementById('presensiChart');
    if (presensiChartCanvas && typeof Chart !== 'undefined') {
        createPresensiChart(presensiChartCanvas);
    }

    // Statistics Chart
    const statsChartCanvas = document.getElementById('statsChart');
    if (statsChartCanvas && typeof Chart !== 'undefined') {
        createStatsChart(statsChartCanvas);
    }

    // Class Performance Chart
    const classChartCanvas = document.getElementById('classChart');
    if (classChartCanvas && typeof Chart !== 'undefined') {
        createClassChart(classChartCanvas);
    }
}

function createPresensiChart(canvas) {
    const ctx = canvas.getContext('2d');

    // Get data from canvas data attributes or make AJAX call
    const data = JSON.parse(canvas.dataset.chartData || '[]');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.labels || [],
            datasets: [{
                label: 'Hadir',
                data: data.hadir || [],
                borderColor: 'rgb(34, 197, 94)',
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                fill: true
            }, {
                label: 'Tidak Hadir',
                data: data.tidak_hadir || [],
                borderColor: 'rgb(239, 68, 68)',
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}

function createStatsChart(canvas) {
    const ctx = canvas.getContext('2d');
    const data = JSON.parse(canvas.dataset.chartData || '{}');

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Hadir', 'Izin', 'Sakit', 'Tidak Hadir'],
            datasets: [{
                data: [
                    data.hadir || 0,
                    data.izin || 0,
                    data.sakit || 0,
                    data.tidak_hadir || 0
                ],
                backgroundColor: [
                    'rgb(34, 197, 94)',
                    'rgb(251, 191, 36)',
                    'rgb(59, 130, 246)',
                    'rgb(239, 68, 68)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}

function createClassChart(canvas) {
    const ctx = canvas.getContext('2d');
    const data = JSON.parse(canvas.dataset.chartData || '{}');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: data.labels || [],
            datasets: [{
                label: 'Tingkat Kehadiran (%)',
                data: data.percentages || [],
                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                borderColor: 'rgb(59, 130, 246)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
}

// Data Tables Enhancement
function initializeDataTables() {
    // Enhanced table search
    document.querySelectorAll('.enhanced-search').forEach(searchInput => {
        const tableId = searchInput.dataset.table;
        const table = document.getElementById(tableId);

        if (table) {
            searchInput.addEventListener('input', window.SMP54.debounce((e) => {
                enhancedTableSearch(table, e.target.value);
            }, 300));
        }
    });

    // Column filters
    document.querySelectorAll('.column-filter').forEach(filter => {
        filter.addEventListener('change', (e) => {
            const tableId = filter.dataset.table;
            const column = filter.dataset.column;
            const table = document.getElementById(tableId);

            if (table) {
                filterTableByColumn(table, column, e.target.value);
            }
        });
    });

    // Export buttons
    document.querySelectorAll('.export-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const format = btn.dataset.format;
            const url = btn.dataset.url || btn.href;
            exportData(url, format);
        });
    });
}

function enhancedTableSearch(table, searchTerm) {
    const tbody = table.querySelector('tbody');
    const rows = tbody.querySelectorAll('tr');
    const term = searchTerm.toLowerCase().trim();

    let visibleCount = 0;

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        const isVisible = term === '' || text.includes(term);

        row.style.display = isVisible ? '' : 'none';
        if (isVisible) visibleCount++;
    });

    // Update result count
    const resultCount = table.parentElement.querySelector('.search-results');
    if (resultCount) {
        if (term === '') {
            resultCount.textContent = '';
        } else {
            resultCount.textContent = `Menampilkan ${visibleCount} hasil dari pencarian "${searchTerm}"`;
        }
    }
}

function filterTableByColumn(table, columnIndex, filterValue) {
    const tbody = table.querySelector('tbody');
    const rows = tbody.querySelectorAll('tr');

    rows.forEach(row => {
        const cell = row.children[columnIndex];
        if (cell) {
            const cellText = cell.textContent.toLowerCase().trim();
            const shouldShow = filterValue === '' || cellText.includes(filterValue.toLowerCase());
            row.style.display = shouldShow ? '' : 'none';
        }
    });
}

function exportData(url, format) {
    // Show loading
    if (typeof window.SMP54 !== 'undefined' && window.SMP54.showNotification) {
        window.SMP54.showNotification('Sedang memproses export...', 'info', 0);
    }

    // Create temporary link for download
    const link = document.createElement('a');
    link.href = url + (url.includes('?') ? '&' : '?') + 'format=' + format;
    link.download = '';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);

    // Hide loading notification after 2 seconds
    setTimeout(() => {
        if (typeof window.SMP54 !== 'undefined' && window.SMP54.hideNotification) {
            const notifications = document.querySelectorAll('.notification');
            notifications.forEach(notification => {
                if (notification.textContent.includes('Sedang memproses export')) {
                    window.SMP54.hideNotification(notification);
                }
            });
        }
    }, 2000);
}

// File Upload Enhancement
function initializeFileUpload() {
    document.querySelectorAll('.file-upload').forEach(input => {
        input.addEventListener('change', handleFileUpload);
    });

    // Drag and drop
    document.querySelectorAll('.file-drop-zone').forEach(zone => {
        zone.addEventListener('dragover', (e) => {
            e.preventDefault();
            zone.classList.add('bg-blue-50', 'border-blue-300');
        });

        zone.addEventListener('dragleave', (e) => {
            e.preventDefault();
            zone.classList.remove('bg-blue-50', 'border-blue-300');
        });

        zone.addEventListener('drop', (e) => {
            e.preventDefault();
            zone.classList.remove('bg-blue-50', 'border-blue-300');

            const files = e.dataTransfer.files;
            const input = zone.querySelector('input[type="file"]');
            if (input && files.length > 0) {
                input.files = files;
                handleFileUpload({ target: input });
            }
        });
    });
}

function handleFileUpload(e) {
    const input = e.target;
    const file = input.files[0];

    if (!file) return;

    // Validate file type
    const allowedTypes = input.accept ? input.accept.split(',').map(t => t.trim()) : [];
    if (allowedTypes.length > 0 && !allowedTypes.some(type => {
        if (type.startsWith('.')) {
            return file.name.toLowerCase().endsWith(type.toLowerCase());
        } else {
            return file.type.match(type);
        }
    })) {
        alert('Tipe file tidak diizinkan');
        input.value = '';
        return;
    }

    // Validate file size (2MB default)
    const maxSize = parseInt(input.dataset.maxSize) || 2048; // KB
    if (file.size > maxSize * 1024) {
        alert(`Ukuran file terlalu besar. Maksimal ${maxSize}KB`);
        input.value = '';
        return;
    }

    // Show preview for images
    if (file.type.startsWith('image/')) {
        const preview = input.parentElement.querySelector('.file-preview');
        if (preview) {
            const reader = new FileReader();
            reader.onload = (e) => {
                preview.innerHTML = `<img src="${e.target.result}" class="max-w-32 max-h-32 object-cover rounded">`;
            };
            reader.readAsDataURL(file);
        }
    }

    // Show file info
    const fileInfo = input.parentElement.querySelector('.file-info');
    if (fileInfo) {
        fileInfo.innerHTML = `
            <div class="text-sm text-gray-600">
                <div>File: ${file.name}</div>
                <div>Ukuran: ${(file.size / 1024).toFixed(1)} KB</div>
            </div>
        `;
    }
}

// Bulk Actions
function initializeBulkActions() {
    // Select all checkbox
    document.querySelectorAll('.select-all').forEach(checkbox => {
        checkbox.addEventListener('change', (e) => {
            const tableId = checkbox.dataset.table;
            const table = document.getElementById(tableId);
            const checkboxes = table.querySelectorAll('.select-item');

            checkboxes.forEach(cb => {
                cb.checked = e.target.checked;
            });

            updateBulkActionButtons();
        });
    });

    // Individual checkboxes
    document.querySelectorAll('.select-item').forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActionButtons);
    });

}
