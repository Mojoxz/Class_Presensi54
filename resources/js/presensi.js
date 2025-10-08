// Global variables
let stream = null;
let capturedImageData = null;
let presensiType = null; // 'masuk' atau 'keluar'
let izinStream = null;
let sakitStream = null;
let izinImageData = null;
let sakitImageData = null;

// ===== DATETIME UPDATE =====
function updateDateTime() {
    const now = new Date();
    const timeOptions = {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    };
    const dateOptions = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    };

    const timeElement = document.getElementById('current-time');
    const dateElement = document.getElementById('current-date');

    if (timeElement) {
        timeElement.textContent = now.toLocaleTimeString('id-ID', timeOptions);
    }
    if (dateElement) {
        dateElement.textContent = now.toLocaleDateString('id-ID', dateOptions);
    }
}

// ===== PRESENSI MASUK/KELUAR FUNCTIONS =====
async function openCameraModal(type) {
    presensiType = type;
    const modal = document.getElementById('cameraModal');
    const video = document.getElementById('camera');
    const capturedImage = document.getElementById('capturedImage');
    const captureBtn = document.getElementById('captureBtn');
    const retakeBtn = document.getElementById('retakeBtn');
    const submitBtn = document.getElementById('submitBtn');

    modal.classList.remove('hidden');
    capturedImage.classList.add('hidden');
    video.classList.remove('hidden');
    captureBtn.classList.remove('hidden');
    retakeBtn.classList.add('hidden');
    submitBtn.classList.add('hidden');

    try {
        stream = await navigator.mediaDevices.getUserMedia({
            video: {
                facingMode: 'user',
                width: { ideal: 1280 },
                height: { ideal: 720 }
            }
        });
        video.srcObject = stream;
    } catch (err) {
        console.error('Error accessing camera:', err);
        alert('Gagal mengakses kamera. Pastikan Anda telah memberikan izin akses kamera.');
        closeCameraModal();
    }
}

function capturePhoto() {
    const video = document.getElementById('camera');
    const canvas = document.getElementById('canvas');
    const photo = document.getElementById('photo');
    const capturedImage = document.getElementById('capturedImage');
    const captureBtn = document.getElementById('captureBtn');
    const retakeBtn = document.getElementById('retakeBtn');
    const submitBtn = document.getElementById('submitBtn');

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    const context = canvas.getContext('2d');
    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    capturedImageData = canvas.toDataURL('image/jpeg', 0.8);

    photo.src = capturedImageData;
    video.classList.add('hidden');
    capturedImage.classList.remove('hidden');
    captureBtn.classList.add('hidden');
    retakeBtn.classList.remove('hidden');
    submitBtn.classList.remove('hidden');

    if (stream) {
        stream.getTracks().forEach(track => track.stop());
    }
}

function retakePhoto() {
    const video = document.getElementById('camera');
    const capturedImage = document.getElementById('capturedImage');
    const captureBtn = document.getElementById('captureBtn');
    const retakeBtn = document.getElementById('retakeBtn');
    const submitBtn = document.getElementById('submitBtn');

    capturedImageData = null;
    video.classList.remove('hidden');
    capturedImage.classList.add('hidden');
    captureBtn.classList.remove('hidden');
    retakeBtn.classList.add('hidden');
    submitBtn.classList.add('hidden');

    openCameraModal(presensiType);
}

async function submitPresensi() {
    if (!capturedImageData) {
        alert('Silakan ambil foto terlebih dahulu');
        return;
    }

    const loadingIndicator = document.getElementById('loadingIndicator');
    const submitBtn = document.getElementById('submitBtn');
    const retakeBtn = document.getElementById('retakeBtn');

    loadingIndicator.classList.remove('hidden');
    submitBtn.disabled = true;
    retakeBtn.disabled = true;

    try {
        const url = presensiType === 'masuk'
            ? window.routes.presensiMasuk
            : window.routes.presensiKeluar;

        const fieldName = presensiType === 'masuk' ? 'foto_masuk' : 'foto_keluar';

        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': window.csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                [fieldName]: capturedImageData
            })
        });

        const data = await response.json();

        if (data.success) {
            alert(data.message);
            closeCameraModal();
            location.reload();
        } else {
            alert(data.message || 'Terjadi kesalahan saat memproses presensi');
            submitBtn.disabled = false;
            retakeBtn.disabled = false;
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengirim presensi');
        submitBtn.disabled = false;
        retakeBtn.disabled = false;
    } finally {
        loadingIndicator.classList.add('hidden');
    }
}

function closeCameraModal() {
    const modal = document.getElementById('cameraModal');
    modal.classList.add('hidden');

    if (stream) {
        stream.getTracks().forEach(track => track.stop());
        stream = null;
    }

    capturedImageData = null;
    presensiType = null;
}

// ===== IZIN FUNCTIONS =====
function openIzinModal() {
    document.getElementById('izinModal').classList.remove('hidden');
    document.getElementById('alasanIzin').value = '';
    izinImageData = null;
    document.getElementById('izinPreview').classList.add('hidden');
}

function closeIzinModal() {
    document.getElementById('izinModal').classList.add('hidden');
    if (izinStream) {
        izinStream.getTracks().forEach(track => track.stop());
        izinStream = null;
    }
    document.getElementById('izinCamera').classList.add('hidden');
    document.getElementById('startIzinCameraBtn').classList.remove('hidden');
    document.getElementById('captureIzinBtn').classList.add('hidden');
    document.getElementById('retakeIzinBtn').classList.add('hidden');
}

async function startIzinCamera() {
    const video = document.getElementById('izinCamera');
    const startBtn = document.getElementById('startIzinCameraBtn');
    const captureBtn = document.getElementById('captureIzinBtn');

    try {
        izinStream = await navigator.mediaDevices.getUserMedia({
            video: {
                facingMode: 'environment',
                width: { ideal: 1280 },
                height: { ideal: 720 }
            }
        });
        video.srcObject = izinStream;
        video.classList.remove('hidden');
        startBtn.classList.add('hidden');
        captureBtn.classList.remove('hidden');
    } catch (err) {
        console.error('Error accessing camera:', err);
        alert('Gagal mengakses kamera. Pastikan Anda telah memberikan izin akses kamera.');
    }
}

function captureIzinPhoto() {
    const video = document.getElementById('izinCamera');
    const canvas = document.getElementById('izinCanvas');
    const photo = document.getElementById('izinPhoto');
    const preview = document.getElementById('izinPreview');
    const captureBtn = document.getElementById('captureIzinBtn');
    const retakeBtn = document.getElementById('retakeIzinBtn');

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    const context = canvas.getContext('2d');
    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    izinImageData = canvas.toDataURL('image/jpeg', 0.8);

    photo.src = izinImageData;
    preview.classList.remove('hidden');
    video.classList.add('hidden');
    captureBtn.classList.add('hidden');
    retakeBtn.classList.remove('hidden');

    if (izinStream) {
        izinStream.getTracks().forEach(track => track.stop());
        izinStream = null;
    }
}

function retakeIzinPhoto() {
    izinImageData = null;
    document.getElementById('izinPreview').classList.add('hidden');
    document.getElementById('retakeIzinBtn').classList.add('hidden');
    document.getElementById('startIzinCameraBtn').classList.remove('hidden');
}

async function submitIzin() {
    const alasan = document.getElementById('alasanIzin').value.trim();

    if (alasan.length < 10) {
        alert('Alasan izin minimal 10 karakter');
        return;
    }

    if (!izinImageData) {
        alert('Silakan ambil foto bukti izin terlebih dahulu');
        return;
    }

    const loadingIndicator = document.getElementById('izinLoadingIndicator');
    loadingIndicator.classList.remove('hidden');

    try {
        const response = await fetch(window.routes.presensiIzin, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': window.csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                alasan: alasan,
                foto_bukti: izinImageData
            })
        });

        const data = await response.json();

        if (data.success) {
            alert(data.message);
            closeIzinModal();
            location.reload();
        } else {
            alert(data.message || 'Terjadi kesalahan saat mengajukan izin');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengirim pengajuan izin');
    } finally {
        loadingIndicator.classList.add('hidden');
    }
}

// ===== SAKIT FUNCTIONS =====
function openSakitModal() {
    document.getElementById('sakitModal').classList.remove('hidden');
    document.getElementById('alasanSakit').value = '';
    sakitImageData = null;
    document.getElementById('sakitPreview').classList.add('hidden');
}

function closeSakitModal() {
    document.getElementById('sakitModal').classList.add('hidden');
    if (sakitStream) {
        sakitStream.getTracks().forEach(track => track.stop());
        sakitStream = null;
    }
    document.getElementById('sakitCamera').classList.add('hidden');
    document.getElementById('startSakitCameraBtn').classList.remove('hidden');
    document.getElementById('captureSakitBtn').classList.add('hidden');
    document.getElementById('retakeSakitBtn').classList.add('hidden');
}

async function startSakitCamera() {
    const video = document.getElementById('sakitCamera');
    const startBtn = document.getElementById('startSakitCameraBtn');
    const captureBtn = document.getElementById('captureSakitBtn');

    try {
        sakitStream = await navigator.mediaDevices.getUserMedia({
            video: {
                facingMode: 'environment',
                width: { ideal: 1280 },
                height: { ideal: 720 }
            }
        });
        video.srcObject = sakitStream;
        video.classList.remove('hidden');
        startBtn.classList.add('hidden');
        captureBtn.classList.remove('hidden');
    } catch (err) {
        console.error('Error accessing camera:', err);
        alert('Gagal mengakses kamera. Pastikan Anda telah memberikan izin akses kamera.');
    }
}

function captureSakitPhoto() {
    const video = document.getElementById('sakitCamera');
    const canvas = document.getElementById('sakitCanvas');
    const photo = document.getElementById('sakitPhoto');
    const preview = document.getElementById('sakitPreview');
    const captureBtn = document.getElementById('captureSakitBtn');
    const retakeBtn = document.getElementById('retakeSakitBtn');

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    const context = canvas.getContext('2d');
    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    sakitImageData = canvas.toDataURL('image/jpeg', 0.8);

    photo.src = sakitImageData;
    preview.classList.remove('hidden');
    video.classList.add('hidden');
    captureBtn.classList.add('hidden');
    retakeBtn.classList.remove('hidden');

    if (sakitStream) {
        sakitStream.getTracks().forEach(track => track.stop());
        sakitStream = null;
    }
}

function retakeSakitPhoto() {
    sakitImageData = null;
    document.getElementById('sakitPreview').classList.add('hidden');
    document.getElementById('retakeSakitBtn').classList.add('hidden');
    document.getElementById('startSakitCameraBtn').classList.remove('hidden');
}

async function submitSakit() {
    const alasan = document.getElementById('alasanSakit').value.trim();

    if (alasan.length < 10) {
        alert('Keterangan sakit minimal 10 karakter');
        return;
    }

    if (!sakitImageData) {
        alert('Silakan ambil foto surat sakit terlebih dahulu');
        return;
    }

    const loadingIndicator = document.getElementById('sakitLoadingIndicator');
    loadingIndicator.classList.remove('hidden');

    try {
        const response = await fetch(window.routes.presensiSakit, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': window.csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                alasan: alasan,
                foto_bukti: sakitImageData
            })
        });

        const data = await response.json();

        if (data.success) {
            alert(data.message);
            closeSakitModal();
            location.reload();
        } else {
            alert(data.message || 'Terjadi kesalahan saat mengirim laporan sakit');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengirim laporan sakit');
    } finally {
        loadingIndicator.classList.add('hidden');
    }
}

// ===== IMAGE MODAL FUNCTIONS =====
function showImageModal(imageSrc) {
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    modalImage.src = imageSrc;
    modal.classList.remove('hidden');
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
}

function showAlasanModal(status, alasan) {
    const modal = document.getElementById('alasanModal');
    const title = document.getElementById('alasanTitle');
    const content = document.getElementById('alasanContent');

    title.textContent = 'Detail Alasan ' + (status.charAt(0).toUpperCase() + status.slice(1));
    content.textContent = alasan;
    modal.classList.remove('hidden');
}

function closeAlasanModal() {
    document.getElementById('alasanModal').classList.add('hidden');
}

// ===== EVENT LISTENERS =====
function initializeEventListeners() {
    // Close image modal on click outside
    const imageModal = document.getElementById('imageModal');
    if (imageModal) {
        imageModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });
    }
}

// ===== INITIALIZATION =====
document.addEventListener('DOMContentLoaded', function() {
    // Start datetime update
    setInterval(updateDateTime, 1000);
    updateDateTime();

    // Initialize event listeners
    initializeEventListeners();
});
