@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Scanner QR Code</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('petugas.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Scanner</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Scan QR Code Tiket</h4>
                </div>
                <div class="card-body">
                    <!-- Scanner Controls -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="toggleManualInput()">
                                <i class="ti ti-keyboard me-1"></i>Input Manual
                            </button>
                            <button type="button" class="btn btn-outline-info btn-sm" onclick="toggleMirror()" id="mirrorBtn">
                                <i class="ti ti-flip-horizontal me-1"></i>Mirror: OFF
                            </button>
                            <button type="button" class="btn btn-outline-warning btn-sm" onclick="restartScanner()">
                                <i class="ti ti-refresh me-1"></i>Restart Scanner
                            </button>
                        </div>
                        <div>
                            <span class="badge bg-info" id="scanner-status">Scanner Ready</span>
                        </div>
                    </div>

                    <!-- Scanner Area -->
                    <div class="text-center mb-4">
                        <div class="bg-light rounded p-4 position-relative" style="min-height: 400px;">
                            <div id="reader" style="width: 100%;"></div>
                            <div id="manual-input" style="display: none;">
                                <h5>Input Manual QR Code</h5>
                                <textarea id="qr-data" class="form-control" rows="4" placeholder="Masukkan data QR Code di sini (JSON format)..."></textarea>
                                <button type="button" class="btn btn-primary mt-2" onclick="processManualInput()">
                                    <i class="ti ti-send me-1"></i>Proses Data
                                </button>
                            </div>
                            
                            <!-- Loading Overlay -->
                            <div id="scan-loading" class="position-absolute top-50 start-50 translate-middle" style="display: none; z-index: 1000;">
                                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                                    <span class="visually-hidden">Memproses...</span>
                                </div>
                                <p class="mt-2 text-primary fw-bold">Memproses QR Code...</p>
                            </div>
                        </div>
                    </div>

                    <!-- Result Area -->
                    <div id="scan-result" class="alert" style="display: none;"></div>
                    
                    <!-- Ticket Details -->
                    <div id="ticket-details" class="card" style="display: none;">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">Detail Tiket Valid</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Kode Tiket:</strong> <span id="ticket-code"></span></p>
                                    <p><strong>Nama Pengunjung:</strong> <span id="visitor-name"></span></p>
                                    <p><strong>Paket Wisata:</strong> <span id="package-name"></span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Tanggal Kunjungan:</strong> <span id="visit-date"></span></p>
                                    <p><strong>Waktu Scan:</strong> <span id="scan-time"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Instructions -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Petunjuk Penggunaan</h5>
                </div>
                <div class="card-body">
                    <h6 class="fw-bold">Cara Scan QR Code:</h6>
                    <ol>
                        <li>Izinkan akses kamera saat browser meminta permission</li>
                        <li>Arahkan kamera ke QR Code pada tiket pengunjung</li>
                        <li>Tunggu hingga QR Code terbaca secara otomatis (1-2 detik)</li>
                        <li>Sistem akan menampilkan status tiket (valid/tidak valid)</li>
                        <li>Jika tiket valid, pengunjung dapat masuk ke area wisata</li>
                        <li>Tiket yang sudah di-scan tidak dapat digunakan lagi</li>
                    </ol>
                    
                    <div class="alert alert-info mb-3">
                        <h6 class="fw-bold mb-2"><i class="ti ti-bulb"></i> Tips Scanner:</h6>
                        <ul class="mb-0">
                            <li>Pastikan pencahayaan cukup terang</li>
                            <li>Jaga jarak 15-20 cm dari kamera</li>
                            <li>QR Code harus dalam kotak biru scanner</li>
                            <li>Jika kamera tidak muncul, klik "Input Manual"</li>
                        </ul>
                    </div>
                    
                    <div class="alert alert-warning mb-3">
                        <h6 class="fw-bold mb-2"><i class="ti ti-alert-triangle"></i> Perhatian:</h6>
                        <ul class="mb-0">
                            <li>Tiket hanya berlaku di tanggal kunjungan yang dipilih</li>
                            <li>Setiap tiket hanya bisa di-scan 1 kali</li>
                            <li>Pastikan booking sudah di-approve admin</li>
                        </ul>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- QR Code Scanner Script -->
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
let html5QrcodeScanner = null;
let html5Qrcode = null;
let isManualInputMode = false;
let isProcessing = false;
let isMirrorEnabled = false;
let currentCameraId = null;

function onScanSuccess(decodedText, decodedResult) {
    if (isProcessing) {
        console.log('Already processing, ignoring scan...');
        return; // Prevent multiple simultaneous scans
    }
    
    isProcessing = true;
    console.log('✅ QR Code detected:', decodedText);
    
    // Update status
    updateScannerStatus('Memproses QR Code...', 'warning');
    
    // Stop scanner immediately
    if (html5Qrcode) {
        html5Qrcode.stop().then(() => {
            console.log('Scanner stopped');
        }).catch(err => {
            console.log('Error stopping scanner:', err);
        });
    }
    
    // Show loading overlay
    document.getElementById('scan-loading').style.display = 'block';
    
    // Process the scanned data
    processQRData(decodedText);
}

function onScanFailure(error) {
    // Handle scan failure - usually ignore (this fires very frequently)
    // Only log if it's a meaningful error
    if (error && !error.includes('NotFoundException')) {
        console.warn('Scan error:', error);
    }
}

function processQRData(qrData) {
    console.log('📤 Processing QR Data:', qrData);
    
    // Hide loading after a moment to show we're processing
    setTimeout(() => {
        fetch('{{ route("petugas.scan.ticket") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                qr_data: qrData
            })
        })
        .then(response => {
            console.log('📥 Response status:', response.status);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('✅ Response data:', data);
            
            // Hide loading
            document.getElementById('scan-loading').style.display = 'none';
            
            const resultDiv = document.getElementById('scan-result');
            const ticketDetails = document.getElementById('ticket-details');
            
            if (data.success) {
                // Success feedback
                resultDiv.className = 'alert alert-success alert-dismissible fade show';
                resultDiv.innerHTML = `
                    <i class="ti ti-check-circle me-2"></i>
                    <strong>Berhasil!</strong> ${data.message}
                    <button type="button" class="btn-close" onclick="this.parentElement.style.display='none'"></button>
                `;
                
                // Show ticket details
                document.getElementById('ticket-code').textContent = data.ticket.ticket_code;
                document.getElementById('visitor-name').textContent = data.ticket.visitor_name;
                document.getElementById('package-name').textContent = data.ticket.package_name;
                document.getElementById('visit-date').textContent = data.ticket.visit_date;
                document.getElementById('scan-time').textContent = data.ticket.used_at;
                
                ticketDetails.style.display = 'block';
                ticketDetails.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                
                // Update status
                updateScannerStatus('Tiket Valid!', 'success');
                
                // Play success sound
                playSound('success');
                
                // Vibrate if supported
                if (navigator.vibrate) {
                    navigator.vibrate([200, 100, 200]);
                }
                
            } else {
                // Error feedback
                resultDiv.className = 'alert alert-danger alert-dismissible fade show';
                resultDiv.innerHTML = `
                    <i class="ti ti-alert-circle me-2"></i>
                    <strong>Gagal!</strong> ${data.message}
                    <button type="button" class="btn-close" onclick="this.parentElement.style.display='none'"></button>
                `;
                ticketDetails.style.display = 'none';
                
                // Update status
                updateScannerStatus('Tiket Tidak Valid', 'danger');
                
                // Play error sound
                playSound('error');
                
                // Vibrate error pattern
                if (navigator.vibrate) {
                    navigator.vibrate([100, 50, 100, 50, 100]);
                }
            }
            
            resultDiv.style.display = 'block';
            resultDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            
            // Auto hide result after 8 seconds
            setTimeout(() => {
                resultDiv.style.display = 'none';
                if (!data.success) {
                    ticketDetails.style.display = 'none';
                }
                // Resume scanning after showing result
                if (data.success) {
                    setTimeout(() => {
                        resumeScanning();
                    }, 2000);
                } else {
                    resumeScanning();
                }
            }, 8000);
        })
        .catch(error => {
            console.error('❌ Fetch Error:', error);
            document.getElementById('scan-loading').style.display = 'none';
            
            const resultDiv = document.getElementById('scan-result');
            resultDiv.className = 'alert alert-danger alert-dismissible fade show';
            resultDiv.innerHTML = `
                <i class="ti ti-alert-triangle me-2"></i>
                <strong>Error!</strong> Terjadi kesalahan saat memproses QR Code. Silakan coba lagi.
                <button type="button" class="btn-close" onclick="this.parentElement.style.display='none'"></button>
            `;
            resultDiv.style.display = 'block';
            
            updateScannerStatus('Error', 'danger');
            
            setTimeout(() => {
                resultDiv.style.display = 'none';
                resumeScanning();
            }, 5000);
        });
    }, 500);
}

function updateScannerStatus(text, type) {
    const statusBadge = document.getElementById('scanner-status');
    statusBadge.textContent = text;
    statusBadge.className = 'badge bg-' + type;
}

function toggleManualInput() {
    const readerDiv = document.getElementById('reader');
    const manualDiv = document.getElementById('manual-input');
    
    if (isManualInputMode) {
        // Switch to camera mode
        readerDiv.style.display = 'block';
        manualDiv.style.display = 'none';
        startScanner();
        isManualInputMode = false;
        updateScannerStatus('Scanner Ready', 'info');
    } else {
        // Switch to manual mode
        readerDiv.style.display = 'none';
        manualDiv.style.display = 'block';
        if (html5Qrcode) {
            html5Qrcode.stop().catch(err => console.log('Error stopping scanner:', err));
        }
        isManualInputMode = true;
        updateScannerStatus('Input Manual Mode', 'secondary');
    }
}

function toggleMirror() {
    isMirrorEnabled = !isMirrorEnabled;
    const mirrorBtn = document.getElementById('mirrorBtn');
    mirrorBtn.innerHTML = `<i class="ti ti-flip-horizontal me-1"></i>Mirror: ${isMirrorEnabled ? 'ON' : 'OFF'}`;
    
    // Restart scanner with new mirror setting
    if (!isManualInputMode && html5Qrcode) {
        restartScanner();
    }
}

function restartScanner() {
    console.log('🔄 Restarting scanner...');
    if (html5Qrcode) {
        html5Qrcode.stop().then(() => {
            startScanner();
        }).catch(err => {
            console.log('Error stopping scanner:', err);
            startScanner();
        });
    } else {
        startScanner();
    }
}

function resumeScanning() {
    if (isProcessing) {
        isProcessing = false;
    }
    if (!isManualInputMode) {
        startScanner();
    }
}

function processManualInput() {
    const qrData = document.getElementById('qr-data').value.trim();
    if (qrData) {
        isProcessing = true;
        document.getElementById('scan-loading').style.display = 'block';
        updateScannerStatus('Memproses...', 'warning');
        processQRData(qrData);
        document.getElementById('qr-data').value = '';
    } else {
        alert('Masukkan data QR Code terlebih dahulu!');
    }
}

async function startScanner() {
    if (isManualInputMode) {
        return;
    }
    
    if (html5Qrcode) {
        try {
            await html5Qrcode.stop();
        } catch (err) {
            console.log('Error stopping previous scanner:', err);
        }
    }
    
    const readerDiv = document.getElementById('reader');
    readerDiv.innerHTML = ''; // Clear previous scanner
    
    try {
        html5Qrcode = new Html5Qrcode("reader");
        
        // Get available cameras
        Html5Qrcode.getCameras().then(cameras => {
            if (cameras && cameras.length > 0) {
                // Use front camera if available, otherwise use first camera
                const cameraId = cameras.find(cam => cam.label.toLowerCase().includes('front')) 
                    ? cameras.find(cam => cam.label.toLowerCase().includes('front')).id
                    : cameras[0].id;
                
                currentCameraId = cameraId;
                
                html5Qrcode.start(
                    cameraId,
                    {
                        fps: 10,
                        qrbox: { width: 300, height: 300 },
                        aspectRatio: 1.0,
                        videoConstraints: {
                            facingMode: "environment" // Use back camera on mobile
                        }
                    },
                    onScanSuccess,
                    onScanFailure
                ).then(() => {
                    console.log('✅ Scanner started successfully');
                    updateScannerStatus('Scanner Ready', 'info');
                    
                    // Apply mirror if enabled
                    if (isMirrorEnabled) {
                        const video = document.querySelector('#reader video');
                        if (video) {
                            video.style.transform = 'scaleX(-1)';
                        }
                    }
                }).catch(err => {
                    console.error('Error starting scanner:', err);
                    updateScannerStatus('Error Starting Scanner', 'danger');
                });
            } else {
                throw new Error('No cameras found');
            }
        }).catch(err => {
            console.error('Error getting cameras:', err);
            updateScannerStatus('Kamera Tidak Tersedia', 'warning');
            const resultDiv = document.getElementById('scan-result');
            resultDiv.className = 'alert alert-warning';
            resultDiv.innerHTML = '<i class="ti ti-camera-off me-2"></i><strong>Kamera Tidak Tersedia!</strong> Gunakan tombol "Input Manual" untuk memasukkan kode QR secara manual.';
            resultDiv.style.display = 'block';
        });
    } catch (error) {
        console.error('Error initializing scanner:', error);
        updateScannerStatus('Error', 'danger');
    }
}

function playSound(type) {
    try {
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const oscillator = audioContext.createOscillator();
        const gainNode = audioContext.createGain();
        
        oscillator.connect(gainNode);
        gainNode.connect(audioContext.destination);
        
        if (type === 'success') {
            // Success sound: two beeps
            oscillator.frequency.value = 800;
            oscillator.type = 'sine';
            gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.2);
            oscillator.start(audioContext.currentTime);
            oscillator.stop(audioContext.currentTime + 0.2);
            
            setTimeout(() => {
                const osc2 = audioContext.createOscillator();
                const gain2 = audioContext.createGain();
                osc2.connect(gain2);
                gain2.connect(audioContext.destination);
                osc2.frequency.value = 1000;
                osc2.type = 'sine';
                gain2.gain.setValueAtTime(0.3, audioContext.currentTime);
                gain2.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.2);
                osc2.start(audioContext.currentTime);
                osc2.stop(audioContext.currentTime + 0.2);
            }, 150);
        } else {
            // Error sound: low beep
            oscillator.frequency.value = 400;
            oscillator.type = 'sine';
            gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.3);
            oscillator.start(audioContext.currentTime);
            oscillator.stop(audioContext.currentTime + 0.3);
        }
    } catch (error) {
        console.log('Audio not supported:', error);
    }
}

// Start scanner on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('📱 Page loaded, initializing scanner...');
    updateScannerStatus('Initializing...', 'secondary');
    setTimeout(startScanner, 500);
});

// Cleanup on page unload
window.addEventListener('beforeunload', function() {
    if (html5Qrcode) {
        html5Qrcode.stop().catch(err => console.log('Error clearing scanner on unload:', err));
    }
});

// Apply mirror to video element when it's created
const observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
        mutation.addedNodes.forEach(function(node) {
            if (node.nodeName === 'VIDEO' && isMirrorEnabled) {
                node.style.transform = 'scaleX(-1)';
            }
        });
    });
});

observer.observe(document.getElementById('reader'), {
    childList: true,
    subtree: true
});
</script>
@endsection