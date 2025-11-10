@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">QR Code Scanner - Pintu Masuk</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('petugas.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Scanner</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card border-left-success">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="text-success mb-1" id="scan-today-count">{{ $stats['today_scans'] ?? 0 }}</h5>
                            <p class="text-muted mb-0">Scan Hari Ini</p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-success rounded-circle">
                                <i class="ri-qr-scan-line font-size-18"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-left-info">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="text-info mb-1" id="total-visitors">{{ $stats['total_visitors'] ?? 0 }}</h5>
                            <p class="text-muted mb-0">Pengunjung Hari Ini</p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-info rounded-circle">
                                <i class="ri-user-line font-size-18"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-left-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="text-warning mb-1" id="pending-tickets">{{ $stats['pending_tickets'] ?? 0 }}</h5>
                            <p class="text-muted mb-0">Tiket Belum Scan</p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-warning rounded-circle">
                                <i class="ri-time-line font-size-18"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-left-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="text-primary mb-1">{{ now()->format('H:i') }}</h5>
                            <p class="text-muted mb-0">Waktu Saat Ini</p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-primary rounded-circle">
                                <i class="ri-time-line font-size-18"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scanner Section -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="ri-qr-scan-line me-2"></i>QR Code Scanner
                        </h5>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="toggleCamera()">
                                <i class="ri-camera-line me-1"></i><span id="camera-btn-text">Stop Camera</span>
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="toggleManualInput()">
                                <i class="ri-keyboard-line me-1"></i>Input Manual
                            </button>
                            <button type="button" class="btn btn-outline-info btn-sm" onclick="toggleFullscreen()">
                                <i class="ri-fullscreen-line me-1"></i>Fullscreen
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Scanner Status -->
                    <div class="alert alert-info" id="scanner-status">
                        <i class="ri-information-line me-2"></i>
                        <span>Arahkan kamera ke QR Code tiket pengunjung...</span>
                    </div>

                    <!-- Camera Scanner -->
                    <div id="scanner-container" class="text-center">
                        <div id="reader" style="width: 100%; max-width: 600px; margin: 0 auto;"></div>
                    </div>

                    <!-- Manual Input -->
                    <div id="manual-input" style="display: none;" class="text-center">
                        <h5>Input Manual QR Code</h5>
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <textarea id="qr-data" class="form-control" rows="4" 
                                          placeholder="Masukkan data QR Code di sini atau scan barcode..."></textarea>
                                <div class="mt-3">
                                    <button type="button" class="btn btn-primary" onclick="processManualInput()">
                                        <i class="ri-check-line me-1"></i>Proses Data
                                    </button>
                                    <button type="button" class="btn btn-secondary ms-2" onclick="clearManualInput()">
                                        <i class="ri-refresh-line me-1"></i>Clear
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Scanner Instructions -->
                    <div class="mt-4" id="scanner-instructions">
                        <div class="row">
                            <div class="col-md-6">
                                <h6><i class="ri-check-circle-line text-success me-2"></i>Tiket Valid:</h6>
                                <ul class="list-unstyled">
                                    <li><i class="ri-checkbox-circle-line text-success me-1"></i>Status confirmed</li>
                                    <li><i class="ri-checkbox-circle-line text-success me-1"></i>Tanggal kunjungan hari ini</li>
                                    <li><i class="ri-checkbox-circle-line text-success me-1"></i>Belum pernah di-scan</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="ri-close-circle-line text-danger me-2"></i>Tiket Tidak Valid:</h6>
                                <ul class="list-unstyled">
                                    <li><i class="ri-close-circle-line text-danger me-1"></i>Sudah pernah digunakan</li>
                                    <li><i class="ri-close-circle-line text-danger me-1"></i>Tanggal kunjungan tidak sesuai</li>
                                    <li><i class="ri-close-circle-line text-danger me-1"></i>Status pending/rejected</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scan Results & Recent Activity -->
        <div class="col-lg-4">
            <!-- Current Scan Result -->
            <div class="card" id="scan-result-card" style="display: none;">
                <div class="card-header" id="result-header">
                    <h5 class="card-title mb-0" id="result-title"></h5>
                </div>
                <div class="card-body" id="result-body">
                    <!-- Result content will be populated by JavaScript -->
                </div>
            </div>

            <!-- Recent Scans -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri-history-line me-2"></i>Scan Terakhir
                    </h5>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    <div id="recent-scans">
                        @if(isset($recent_scans) && $recent_scans->count() > 0)
                        @foreach($recent_scans as $scan)
                        <div class="d-flex align-items-center mb-3 p-2 border rounded">
                            <div class="avatar-sm me-3">
                                <span class="avatar-title bg-success rounded-circle">
                                    <i class="ri-check-line"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $scan->booking->visitor_name }}</h6>
                                <p class="text-muted mb-0 small">
                                    {{ $scan->booking->wisataPackage->name }}<br>
                                    {{ $scan->used_at->format('H:i') }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="text-center text-muted">
                            <i class="ri-scan-line font-size-48"></i>
                            <p class="mt-2">Belum ada scan hari ini</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Scanner Controls -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri-settings-line me-2"></i>Kontrol Scanner
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-success" onclick="startContinuousScanning()">
                            <i class="ri-play-line me-2"></i>Mulai Scanning Otomatis
                        </button>
                        <button type="button" class="btn btn-warning" onclick="pauseScanning()">
                            <i class="ri-pause-line me-2"></i>Jeda Scanning
                        </button>
                        <button type="button" class="btn btn-info" onclick="clearResults()">
                            <i class="ri-refresh-line me-2"></i>Clear Results
                        </button>
                        <button type="button" class="btn btn-outline-primary" onclick="printDailyReport()">
                            <i class="ri-printer-line me-2"></i>Print Laporan Harian
                        </button>
                    </div>

                    <hr>

                    <!-- Scanner Settings -->
                    <div>
                        <h6>Pengaturan Scanner:</h6>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="auto-scan" checked>
                            <label class="form-check-label" for="auto-scan">
                                Auto-scan kontinyu
                            </label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="sound-notification" checked>
                            <label class="form-check-label" for="sound-notification">
                                Notifikasi suara
                            </label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="vibration" checked>
                            <label class="form-check-label" for="vibration">
                                Getar (mobile)
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success/Error Audio -->
<audio id="success-sound" preload="auto">
    <source src="{{ asset('assets/audio/success.mp3') }}" type="audio/mpeg">
    <source src="{{ asset('assets/audio/success.wav') }}" type="audio/wav">
</audio>
<audio id="error-sound" preload="auto">
    <source src="{{ asset('assets/audio/error.mp3') }}" type="audio/mpeg">
    <source src="{{ asset('assets/audio/error.wav') }}" type="audio/wav">
</audio>

<!-- QR Code Scanner Script -->
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
let html5QrcodeScanner;
let isScanning = false;
let isCameraActive = true;
let isManualMode = false;
let scanCount = 0;

// Initialize scanner on page load
document.addEventListener('DOMContentLoaded', function() {
    initializeScanner();
    updateTime();
    setInterval(updateTime, 1000); // Update time every second
});

function initializeScanner() {
    const config = {
        fps: 10,
        qrbox: { width: 300, height: 300 },
        aspectRatio: 1.0,
        supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]
    };

    html5QrcodeScanner = new Html5QrcodeScanner("reader", config, false);
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    isScanning = true;
    updateScannerStatus('Kamera aktif - Siap untuk scanning...', 'info');
}

function onScanSuccess(decodedText, decodedResult) {
    // Process the scanned QR code
    processQRCode(decodedText);
    
    // Auto-resume scanning if enabled
    if (document.getElementById('auto-scan').checked) {
        setTimeout(() => {
            // Resume scanning after 2 seconds
            if (isScanning) {
                updateScannerStatus('Siap untuk scan berikutnya...', 'info');
            }
        }, 2000);
    } else {
        // Pause scanning
        pauseScanning();
    }
}

function onScanFailure(error) {
    // Silently handle scan failures - don't show errors for every failed scan attempt
    console.debug('Scan attempt failed:', error);
}

function processQRCode(qrData) {
    // Show scanning status
    updateScannerStatus('Memproses QR Code...', 'warning');
    
    // Send to server for validation
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
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            handleSuccessfulScan(data);
            playSound('success');
            vibrate();
        } else {
            handleFailedScan(data);
            playSound('error');
            vibrate(500); // Longer vibration for error
        }
        
        // Update statistics
        updateStatistics();
    })
    .catch(error => {
        console.error('Error:', error);
        handleFailedScan({
            message: 'Terjadi kesalahan saat memproses QR Code. Silakan coba lagi.'
        });
        playSound('error');
    });
}

function handleSuccessfulScan(data) {
    scanCount++;
    
    // Update scanner status
    updateScannerStatus(`✓ Tiket valid! Total scan hari ini: ${scanCount}`, 'success');
    
    // Show result card
    showScanResult(data, 'success');
    
    // Add to recent scans
    addToRecentScans(data.ticket, 'success');
    
    // Update counters
    document.getElementById('scan-today-count').textContent = scanCount;
    const currentVisitors = parseInt(document.getElementById('total-visitors').textContent) + 1;
    document.getElementById('total-visitors').textContent = currentVisitors;
}

function handleFailedScan(data) {
    // Update scanner status
    updateScannerStatus(`✗ ${data.message}`, 'danger');
    
    // Show result card
    showScanResult(data, 'error');
}

function showScanResult(data, type) {
    const resultCard = document.getElementById('scan-result-card');
    const resultHeader = document.getElementById('result-header');
    const resultTitle = document.getElementById('result-title');
    const resultBody = document.getElementById('result-body');
    
    // Set header style based on result type
    if (type === 'success') {
        resultHeader.className = 'card-header bg-success text-white';
        resultTitle.innerHTML = '<i class="ri-check-circle-line me-2"></i>Tiket Valid';
        
        resultBody.innerHTML = `
            <div class="text-center mb-3">
                <i class="ri-check-circle-line text-success" style="font-size: 48px;"></i>
            </div>
            <table class="table table-sm table-borderless">
                <tr><td><strong>Kode Tiket:</strong></td><td><code>${data.ticket.ticket_code}</code></td></tr>
                <tr><td><strong>Nama:</strong></td><td>${data.ticket.visitor_name}</td></tr>
                <tr><td><strong>Paket:</strong></td><td>${data.ticket.package_name}</td></tr>
                <tr><td><strong>Tanggal:</strong></td><td>${data.ticket.visit_date}</td></tr>
                <tr><td><strong>Waktu Scan:</strong></td><td>${data.ticket.used_at}</td></tr>
            </table>
        `;
    } else {
        resultHeader.className = 'card-header bg-danger text-white';
        resultTitle.innerHTML = '<i class="ri-close-circle-line me-2"></i>Tiket Tidak Valid';
        
        resultBody.innerHTML = `
            <div class="text-center mb-3">
                <i class="ri-close-circle-line text-danger" style="font-size: 48px;"></i>
            </div>
            <div class="alert alert-danger mb-0">
                ${data.message}
            </div>
        `;
    }
    
    resultCard.style.display = 'block';
    
    // Auto-hide result after 10 seconds
    setTimeout(() => {
        resultCard.style.display = 'none';
    }, 10000);
}

function addToRecentScans(ticketData, type) {
    const recentScansContainer = document.getElementById('recent-scans');
    
    if (type === 'success') {
        const scanItem = document.createElement('div');
        scanItem.className = 'd-flex align-items-center mb-3 p-2 border rounded';
        scanItem.innerHTML = `
            <div class="avatar-sm me-3">
                <span class="avatar-title bg-success rounded-circle">
                    <i class="ri-check-line"></i>
                </span>
            </div>
            <div class="flex-grow-1">
                <h6 class="mb-1">${ticketData.visitor_name}</h6>
                <p class="text-muted mb-0 small">
                    ${ticketData.package_name}<br>
                    ${new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })}
                </p>
            </div>
        `;
        
        // Add to top of recent scans
        recentScansContainer.insertBefore(scanItem, recentScansContainer.firstChild);
        
        // Remove oldest items if more than 10
        const items = recentScansContainer.children;
        if (items.length > 10) {
            recentScansContainer.removeChild(items[items.length - 1]);
        }
    }
}

function updateScannerStatus(message, type) {
    const statusAlert = document.getElementById('scanner-status');
    const iconMap = {
        'info': 'ri-information-line',
        'success': 'ri-check-circle-line',
        'warning': 'ri-time-line',
        'danger': 'ri-close-circle-line'
    };
    
    statusAlert.className = `alert alert-${type}`;
    statusAlert.innerHTML = `<i class="${iconMap[type]} me-2"></i><span>${message}</span>`;
}

function updateTime() {
    const timeElements = document.querySelectorAll('.col-lg-3:last-child .text-primary');
    if (timeElements.length > 0) {
        timeElements[0].textContent = new Date().toLocaleTimeString('id-ID', { 
            hour: '2-digit', 
            minute: '2-digit' 
        });
    }
}

function updateStatistics() {
    // This would typically fetch updated stats from the server
    // For now, we'll update local counters
    fetch('{{ route("petugas.dashboard") }}')
        .then(response => response.text())
        .then(html => {
            // Update stats from dashboard data if needed
        })
        .catch(error => console.error('Error updating statistics:', error));
}

// Control Functions
function toggleCamera() {
    const btn = document.getElementById('camera-btn-text');
    
    if (isCameraActive) {
        html5QrcodeScanner.pause(true);
        isCameraActive = false;
        isScanning = false;
        btn.textContent = 'Start Camera';
        updateScannerStatus('Kamera dimatikan', 'warning');
    } else {
        html5QrcodeScanner.resume();
        isCameraActive = true;
        isScanning = true;
        btn.textContent = 'Stop Camera';
        updateScannerStatus('Kamera aktif - Siap untuk scanning...', 'info');
    }
}

function toggleManualInput() {
    const scanner = document.getElementById('scanner-container');
    const manual = document.getElementById('manual-input');
    const instructions = document.getElementById('scanner-instructions');
    
    if (isManualMode) {
        // Switch back to camera
        scanner.style.display = 'block';
        manual.style.display = 'none';
        instructions.style.display = 'block';
        isManualMode = false;
        
        if (!isCameraActive) toggleCamera();
    } else {
        // Switch to manual input
        scanner.style.display = 'none';
        manual.style.display = 'block';
        instructions.style.display = 'none';
        isManualMode = true;
        
        if (isCameraActive) toggleCamera();
    }
}

function processManualInput() {
    const qrData = document.getElementById('qr-data').value.trim();
    
    if (!qrData) {
        alert('Silakan masukkan data QR Code terlebih dahulu.');
        return;
    }
    
    processQRCode(qrData);
}

function clearManualInput() {
    document.getElementById('qr-data').value = '';
}

function startContinuousScanning() {
    document.getElementById('auto-scan').checked = true;
    if (!isScanning && isCameraActive) {
        html5QrcodeScanner.resume();
        isScanning = true;
    }
    updateScannerStatus('Mode scanning otomatis aktif', 'info');
}

function pauseScanning() {
    if (isScanning) {
        html5QrcodeScanner.pause(true);
        isScanning = false;
    }
    updateScannerStatus('Scanning dijeda', 'warning');
}

function clearResults() {
    document.getElementById('scan-result-card').style.display = 'none';
    updateScannerStatus('Siap untuk scanning...', 'info');
}

function toggleFullscreen() {
    if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen();
    } else {
        document.exitFullscreen();
    }
}

function printDailyReport() {
    window.open('{{ route("petugas.daily-report") }}', '_blank');
}

// Audio and Vibration Functions
function playSound(type) {
    if (!document.getElementById('sound-notification').checked) return;
    
    const audio = document.getElementById(type + '-sound');
    if (audio) {
        audio.currentTime = 0;
        audio.play().catch(error => console.debug('Audio play failed:', error));
    }
}

function vibrate(duration = 200) {
    if (!document.getElementById('vibration').checked) return;
    
    if ('vibrate' in navigator) {
        navigator.vibrate(duration);
    }
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (e.ctrlKey) {
        switch(e.key) {
            case 'm': // Ctrl+M for manual input
                e.preventDefault();
                toggleManualInput();
                break;
            case 'c': // Ctrl+C for camera toggle
                e.preventDefault();
                toggleCamera();
                break;
            case 'r': // Ctrl+R for clear results
                e.preventDefault();
                clearResults();
                break;
            case 'f': // Ctrl+F for fullscreen
                e.preventDefault();
                toggleFullscreen();
                break;
        }
    }
});

// Cleanup on page unload
window.addEventListener('beforeunload', function() {
    if (html5QrcodeScanner) {
        html5QrcodeScanner.clear();
    }
});
</script>

<style>
.border-left-success { border-left: 4px solid #28a745 !important; }
.border-left-info { border-left: 4px solid #17a2b8 !important; }
.border-left-warning { border-left: 4px solid #ffc107 !important; }
.border-left-primary { border-left: 4px solid #007bff !important; }

#reader {
    border: 2px dashed #ddd;
    border-radius: 8px;
    min-height: 300px;
}

#reader video {
    border-radius: 8px;
}

#reader canvas {
    border-radius: 8px;
}

/* Fullscreen styles */
:fullscreen {
    background: white;
}

:fullscreen #reader {
    max-width: none !important;
    width: 80vw !important;
    height: 60vh !important;
}

/* Mobile optimizations */
@media (max-width: 768px) {
    .card-body {
        padding: 1rem 0.5rem;
    }
    
    #reader {
        min-height: 250px;
    }
    
    .btn {
        font-size: 0.875rem;
    }
}

/* Animation for scan success */
.scan-success {
    animation: pulse 0.5s ease-in-out;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}
</style>
@endsection