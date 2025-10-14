// Global variables
let stream = null;
let capturedImageData = null;
let currentPresensiType = null;
let izinStream = null;
let izinCapturedImageData = null;
let sakitStream = null;
let sakitCapturedImageData = null;

// ======================
// Clock Functions
// ======================
function updateClock() {
    const now = new Date();

    const timeOptions = {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false
    };

    const dateOptions = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    };

    const timeString = now.toLocaleTimeString('id-ID', timeOptions);
    const dateString = now.toLocaleDateString('id-ID', dateOptions);

    const timeElement = document.getElementById('current-time');
    const dateElement = document.getElementById('current-date');

    if (timeElement) timeElement.textContent = timeString;
    if (dateElement) dateElement.textContent = dateString;
}

// ======================
// Camera Modal Functions
// ======================
function openCameraModal(type) {
    currentPresensiType = type;
    const modal = document.getElementById('cameraModal');
    modal.classList.remove('hidden');
    startCamera();
}

function closeCameraModal() {
    const modal = document.getElementById('cameraModal');
    modal.classList.add('hidden');
    stopCamera();
    resetCameraModal();
}

async function startCamera() {
    try {
        stream = await navigator.mediaDevices.getUserMedia({
            video: { facingMode: 'user' },
            audio: false
        });
        const video = document.getElementById('camera');
        video.srcObject = stream;
    } catch (err) {
        console.error('Error accessing camera:', err);
        window.toast.error('Error', 'Tidak dapat mengakses kamera. Pastikan izin kamera telah diberikan.');
    }
}

function stopCamera() {
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
        stream = null;
    }
}

function capturePhoto() {
    const video = document.getElementById('camera');
    const canvas = document.getElementById('canvas');
    const photo = document.getElementById('photo');
    const capturedImage = document.getElementById('capturedImage');

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    const context = canvas.getContext('2d');
    context.drawImage(video, 0, 0);

    capturedImageData = canvas.toDataURL('image/jpeg', 0.8);
    photo.src = capturedImageData;

    video.classList.add('hidden');
    capturedImage.classList.remove('hidden');

    document.getElementById('captureBtn').classList.add('hidden');
    document.getElementById('retakeBtn').classList.remove('hidden');
    document.getElementById('submitBtn').classList.remove('hidden');

    stopCamera();
}

function retakePhoto() {
    const video = document.getElementById('camera');
    const capturedImage = document.getElementById('capturedImage');

    video.classList.remove('hidden');
    capturedImage.classList.add('hidden');

    document.getElementById('captureBtn').classList.remove('hidden');
    document.getElementById('retakeBtn').classList.add('hidden');
    document.getElementById('submitBtn').classList.add('hidden');

    capturedImageData = null;
    startCamera();
}

function resetCameraModal() {
    const video = document.getElementById('camera');
    const capturedImage = document.getElementById('capturedImage');

    video.classList.remove('hidden');
    capturedImage.classList.add('hidden');

    document.getElementById('captureBtn').classList.remove('hidden');
    document.getElementById('retakeBtn').classList.add('hidden');
    document.getElementById('submitBtn').classList.add('hidden');
    document.getElementById('loadingIndicator').classList.add('hidden');

    capturedImageData = null;
    currentPresensiType = null;
}

async function submitPresensi() {
    if (!capturedImageData) {
        window.toast.error('Error', 'Silakan ambil foto terlebih dahulu');
        return;
    }

    document.getElementById('loadingIndicator').classList.remove('hidden');
    document.getElementById('submitBtn').classList.add('hidden');
    document.getElementById('retakeBtn').classList.add('hidden');

    const url = currentPresensiType === 'masuk'
        ? window.routes.presensiMasuk
        : window.routes.presensiKeluar;

    const fieldName = currentPresensiType === 'masuk' ? 'foto_masuk' : 'foto_keluar';

    try {
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
            window.toast.success('Berhasil!', data.message);
            closeCameraModal();
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            window.toast.error('Gagal', data.message);
            document.getElementById('loadingIndicator').classList.add('hidden');
            document.getElementById('retakeBtn').classList.remove('hidden');
        }
    } catch (error) {
        console.error('Error:', error);
        window.toast.error('Error', 'Terjadi kesalahan saat memproses presensi');
        document.getElementById('loadingIndicator').classList.add('hidden');
        document.getElementById('retakeBtn').classList.remove('hidden');
    }
}

// ======================
// Izin Modal Functions
// ======================
function openIzinModal() {
    document.getElementById('izinModal').classList.remove('hidden');
}

function closeIzinModal() {
    document.getElementById('izinModal').classList.add('hidden');
    stopIzinCamera();
    resetIzinModal();
}

async function startIzinCamera() {
    try {
        izinStream = await navigator.mediaDevices.getUserMedia({
            video: { facingMode: 'environment' },
            audio: false
        });
        const video = document.getElementById('izinCamera');
        video.srcObject = izinStream;
        video.classList.remove('hidden');

        document.getElementById('startIzinCameraBtn').classList.add('hidden');
        document.getElementById('captureIzinBtn').classList.remove('hidden');
    } catch (err) {
        console.error('Error accessing camera:', err);
        window.toast.error('Error', 'Tidak dapat mengakses kamera');
    }
}

function stopIzinCamera() {
    if (izinStream) {
        izinStream.getTracks().forEach(track => track.stop());
        izinStream = null;
    }
}

function captureIzinPhoto() {
    const video = document.getElementById('izinCamera');
    const canvas = document.getElementById('izinCanvas');
    const photo = document.getElementById('izinPhoto');
    const preview = document.getElementById('izinPreview');

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    const context = canvas.getContext('2d');
    context.drawImage(video, 0, 0);

    izinCapturedImageData = canvas.toDataURL('image/jpeg', 0.8);
    photo.src = izinCapturedImageData;

    video.classList.add('hidden');
    preview.classList.remove('hidden');

    document.getElementById('captureIzinBtn').classList.add('hidden');
    document.getElementById('retakeIzinBtn').classList.remove('hidden');

    stopIzinCamera();
}

function retakeIzinPhoto() {
    const video = document.getElementById('izinCamera');
    const preview = document.getElementById('izinPreview');

    video.classList.remove('hidden');
    preview.classList.add('hidden');

    document.getElementById('captureIzinBtn').classList.remove('hidden');
    document.getElementById('retakeIzinBtn').classList.add('hidden');

    izinCapturedImageData = null;
    startIzinCamera();
}

function resetIzinModal() {
    document.getElementById('alasanIzin').value = '';
    document.getElementById('izinCamera').classList.add('hidden');
    document.getElementById('izinPreview').classList.add('hidden');
    document.getElementById('startIzinCameraBtn').classList.remove('hidden');
    document.getElementById('captureIzinBtn').classList.add('hidden');
    document.getElementById('retakeIzinBtn').classList.add('hidden');
    document.getElementById('izinLoadingIndicator').classList.add('hidden');
    izinCapturedImageData = null;
}

async function submitIzin() {
    const alasan = document.getElementById('alasanIzin').value.trim();

    if (!alasan || alasan.length < 10) {
        window.toast.error('Error', 'Alasan izin minimal 10 karakter');
        return;
    }

    if (!izinCapturedImageData) {
        window.toast.error('Error', 'Silakan ambil foto bukti izin');
        return;
    }

    document.getElementById('izinLoadingIndicator').classList.remove('hidden');

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
                foto_bukti: izinCapturedImageData
            })
        });

        const data = await response.json();

        if (data.success) {
            window.toast.success('Berhasil!', data.message);
            closeIzinModal();
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            window.toast.error('Gagal', data.message);
            document.getElementById('izinLoadingIndicator').classList.add('hidden');
        }
    } catch (error) {
        console.error('Error:', error);
        window.toast.error('Error', 'Terjadi kesalahan saat mengirim izin');
        document.getElementById('izinLoadingIndicator').classList.add('hidden');
    }
}

// ======================
// Sakit Modal Functions
// ======================
function openSakitModal() {
    document.getElementById('sakitModal').classList.remove('hidden');
}

function closeSakitModal() {
    document.getElementById('sakitModal').classList.add('hidden');
    stopSakitCamera();
    resetSakitModal();
}

async function startSakitCamera() {
    try {
        sakitStream = await navigator.mediaDevices.getUserMedia({
            video: { facingMode: 'environment' },
            audio: false
        });
        const video = document.getElementById('sakitCamera');
        video.srcObject = sakitStream;
        video.classList.remove('hidden');

        document.getElementById('startSakitCameraBtn').classList.add('hidden');
        document.getElementById('captureSakitBtn').classList.remove('hidden');
    } catch (err) {
        console.error('Error accessing camera:', err);
        window.toast.error('Error', 'Tidak dapat mengakses kamera');
    }
}

function stopSakitCamera() {
    if (sakitStream) {
        sakitStream.getTracks().forEach(track => track.stop());
        sakitStream = null;
    }
}

function captureSakitPhoto() {
    const video = document.getElementById('sakitCamera');
    const canvas = document.getElementById('sakitCanvas');
    const photo = document.getElementById('sakitPhoto');
    const preview = document.getElementById('sakitPreview');

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    const context = canvas.getContext('2d');
    context.drawImage(video, 0, 0);

    sakitCapturedImageData = canvas.toDataURL('image/jpeg', 0.8);
    photo.src = sakitCapturedImageData;

    video.classList.add('hidden');
    preview.classList.remove('hidden');

    document.getElementById('captureSakitBtn').classList.add('hidden');
    document.getElementById('retakeSakitBtn').classList.remove('hidden');

    stopSakitCamera();
}

function retakeSakitPhoto() {
    const video = document.getElementById('sakitCamera');
    const preview = document.getElementById('sakitPreview');

    video.classList.remove('hidden');
    preview.classList.add('hidden');

    document.getElementById('captureSakitBtn').classList.remove('hidden');
    document.getElementById('retakeSakitBtn').classList.add('hidden');

    sakitCapturedImageData = null;
    startSakitCamera();
}

function resetSakitModal() {
    document.getElementById('alasanSakit').value = '';
    document.getElementById('sakitCamera').classList.add('hidden');
    document.getElementById('sakitPreview').classList.add('hidden');
    document.getElementById('startSakitCameraBtn').classList.remove('hidden');
    document.getElementById('captureSakitBtn').classList.add('hidden');
    document.getElementById('retakeSakitBtn').classList.add('hidden');
    document.getElementById('sakitLoadingIndicator').classList.add('hidden');
    sakitCapturedImageData = null;
}

async function submitSakit() {
    const alasan = document.getElementById('alasanSakit').value.trim();

    if (!alasan || alasan.length < 10) {
        window.toast.error('Error', 'Keterangan sakit minimal 10 karakter');
        return;
    }

    if (!sakitCapturedImageData) {
        window.toast.error('Error', 'Silakan ambil foto surat sakit');
        return;
    }

    document.getElementById('sakitLoadingIndicator').classList.remove('hidden');

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
                foto_bukti: sakitCapturedImageData
            })
        });

        const data = await response.json();

        if (data.success) {
            window.toast.success('Berhasil!', data.message);
            closeSakitModal();
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            window.toast.error('Gagal', data.message);
            document.getElementById('sakitLoadingIndicator').classList.add('hidden');
        }
    } catch (error) {
        console.error('Error:', error);
        window.toast.error('Error', 'Terjadi kesalahan saat mengirim laporan sakit');
        document.getElementById('sakitLoadingIndicator').classList.add('hidden');
    }
}

// ======================
// Image & Alasan Modal Functions
// ======================
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

    title.textContent = `Detail ${status.charAt(0).toUpperCase() + status.slice(1)}`;
    content.textContent = alasan;

    modal.classList.remove('hidden');
}

function closeAlasanModal() {
    const modal = document.getElementById('alasanModal');
    modal.classList.add('hidden');
}

// ======================
// Expose functions to window for inline onclick handlers
// ======================
window.openCameraModal = openCameraModal;
window.closeCameraModal = closeCameraModal;
window.capturePhoto = capturePhoto;
window.retakePhoto = retakePhoto;
window.submitPresensi = submitPresensi;

window.openIzinModal = openIzinModal;
window.closeIzinModal = closeIzinModal;
window.startIzinCamera = startIzinCamera;
window.captureIzinPhoto = captureIzinPhoto;
window.retakeIzinPhoto = retakeIzinPhoto;
window.submitIzin = submitIzin;

window.openSakitModal = openSakitModal;
window.closeSakitModal = closeSakitModal;
window.startSakitCamera = startSakitCamera;
window.captureSakitPhoto = captureSakitPhoto;
window.retakeSakitPhoto = retakeSakitPhoto;
window.submitSakit = submitSakit;

window.showImageModal = showImageModal;
window.closeImageModal = closeImageModal;
window.showAlasanModal = showAlasanModal;
window.closeAlasanModal = closeAlasanModal;

// ======================
// Initialize on page load
// ======================
document.addEventListener('DOMContentLoaded', function() {
    updateClock();
    setInterval(updateClock, 1000);

    // Close modals on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCameraModal();
            closeIzinModal();
            closeSakitModal();
            closeImageModal();
            closeAlasanModal();
        }
    });
});
