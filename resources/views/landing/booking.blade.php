<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Tiket - {{ $package->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #0ea5e9;
            --accent-color: #dbeafe;
            --dark-color: #0f172a;
            --light-color: #eff6ff;
            --text-dark: #0f172a;
            --text-light: #475569;
            --success-color: #22c55e;
            --danger-color: #ef4444;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
            background: radial-gradient(circle at top, rgba(37, 99, 235, 0.12), transparent 55%), linear-gradient(180deg, #f8fafc 0%, #e0e7ff 100%);
            min-height: 100vh;
        }
        
        main {
            padding: 4rem 0 3rem;
        }

        .container {
            max-width: 900px;
        }
        
        /* Back Button */
        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: white;
            color: var(--text-dark);
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .back-button:hover {
            background: var(--light-color);
            border-color: var(--primary-color);
            color: var(--primary-color);
            transform: translateX(-5px);
        }
        
        /* Progress Steps */
        .progress-wrapper {
            background: white;
            padding: 2rem;
            border-radius: 24px;
            box-shadow: 0 25px 55px rgba(15, 23, 42, 0.08);
            margin-bottom: 2rem;
        }
        
        .progress-steps {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin-bottom: 0;
        }
        
        .progress-steps::before {
            content: '';
            position: absolute;
            top: 25px;
            left: 0;
            right: 0;
            height: 4px;
            background: #e0e0e0;
            z-index: 0;
        }
        
        .progress-line {
            position: absolute;
            top: 25px;
            left: 0;
            height: 4px;
            background: linear-gradient(to right, var(--primary-color), var(--accent-color));
            z-index: 1;
            transition: width 0.5s ease;
        }
        
        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
            flex: 1;
        }
        
        .step-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: white;
            border: 4px solid #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: var(--text-light);
            margin-bottom: 0.8rem;
            transition: all 0.3s ease;
        }
        
        .step.active .step-circle {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            transform: scale(1.1);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.25);
        }
        
        .step.completed .step-circle {
            background: var(--success-color);
            border-color: var(--success-color);
            color: white;
        }
        
        .step-label {
            font-size: 0.9rem;
            color: var(--text-light);
            text-align: center;
            font-weight: 500;
        }
        
        .step.active .step-label {
            color: var(--primary-color);
            font-weight: 700;
        }
        
        .step.completed .step-label {
            color: var(--success-color);
            font-weight: 600;
        }
        
        /* Package Summary Card */
        .package-summary {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 25px 55px rgba(15, 23, 42, 0.12);
            border-left: 5px solid rgba(37, 99, 235, 0.35);
        }
        
        .package-summary h5 {
            color: var(--text-dark);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .package-summary .price {
            color: var(--primary-color);
            font-size: 1.5rem;
            font-weight: 700;
        }
        
        /* Form Card */
        .form-card {
            background: white;
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 30px 65px rgba(15, 23, 42, 0.12);
            margin-bottom: 2rem;
        }
        
        .step-content {
            display: none;
        }
        
        .step-content.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .step-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.7rem;
        }
        
        .step-title i {
            color: var(--primary-color);
        }
        
        .step-description {
            color: var(--text-light);
            margin-bottom: 2rem;
            font-size: 1rem;
        }
        
        /* Form Elements */
        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }
        
        .form-label .required {
            color: var(--danger-color);
            margin-left: 2px;
        }
        
        .form-control, .form-select {
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 0.9rem 1.2rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 180, 216, 0.15);
        }
        
        .form-text {
            color: var(--text-light);
            font-size: 0.85rem;
            margin-top: 0.4rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }
        
        /* Total Display */
        .total-display-card {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.08), #fff);
            border: 2px solid rgba(37, 99, 235, 0.2);
            border-radius: 18px;
            padding: 1.5rem;
            text-align: center;
        }
        
        .total-label {
            font-size: 0.9rem;
            color: var(--text-light);
            margin-bottom: 0.5rem;
        }
        
        .total-amount {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--primary-color);
        }
        
        /* Payment Info */
        .payment-info {
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.1), rgba(219, 234, 254, 0.6));
            border-left: 4px solid var(--primary-color);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .payment-info h6 {
            color: var(--text-dark);
            font-weight: 700;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .bank-details {
            background: white;
            padding: 1.2rem;
            border-radius: 14px;
            margin-top: 1rem;
            border: 1px solid rgba(148, 163, 184, 0.3);
        }
        
        .bank-details p {
            margin-bottom: 0.3rem;
            color: var(--text-dark);
        }
        
        .bank-details strong {
            color: var(--primary-color);
        }
        
        /* File Upload */
        .file-upload-wrapper {
            position: relative;
        }
        
        .file-upload-label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.8rem;
            padding: 2.5rem;
            border: 2px dashed rgba(37, 99, 235, 0.6);
            border-radius: 18px;
            background: rgba(219, 234, 254, 0.6);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .file-upload-label:hover {
            background: rgba(37, 99, 235, 0.1);
            border-color: var(--primary-color);
            transform: scale(1.02);
        }
        
        .file-upload-label i {
            font-size: 2.5rem;
            color: var(--primary-color);
        }
        
        .file-upload-text strong {
            display: block;
            color: var(--text-dark);
            margin-bottom: 0.3rem;
            font-size: 1.1rem;
        }
        
        input[type="file"] {
            display: none;
        }
        
        /* Navigation Buttons */
        .form-navigation {
            display: flex;
            gap: 1rem;
            margin-top: 2.5rem;
        }
        
        .btn-nav {
            flex: 1;
            padding: 1rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 12px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .btn-next, .btn-submit {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            box-shadow: 0 5px 20px rgba(0, 180, 216, 0.3);
        }
        
        .btn-next:hover, .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 180, 216, 0.4);
        }
        
        .btn-prev {
            background: white;
            color: var(--text-dark);
            border: 2px solid #e0e0e0;
        }
        
        .btn-prev:hover {
            background: #f8f9fa;
            border-color: var(--primary-color);
            color: var(--primary-color);
        }
        
        .btn-nav:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        /* Error Alert */
        .alert-danger {
            background: #fff5f5;
            border-left: 4px solid var(--danger-color);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
        
        /* Responsive */
        @media (max-width: 991.98px) {
            .container {
                max-width: 100%;
                padding: 0 1rem;
            }
        }
        
        @media (max-width: 767.98px) {
            .step-label {
                font-size: 0.75rem;
            }
            
            .step-circle {
                width: 40px;
                height: 40px;
                font-size: 0.875rem;
            }
            
            .step-title {
                font-size: clamp(1.25rem, 4vw, 1.5rem);
            }
            
            .form-card {
                padding: 1.5rem;
            }
            
            .progress-wrapper {
                padding: 1.5rem;
            }
            
            .form-navigation {
                flex-direction: column-reverse;
            }
            
            .btn-nav {
                width: 100%;
            }
            
            .total-amount {
                font-size: 1.75rem;
            }
            
            .package-summary {
                padding: 1.25rem;
            }
        }
        
        @media (max-width: 575.98px) {
            .step-label {
                font-size: 0.6875rem;
            }
            
            .step-circle {
                width: 36px;
                height: 36px;
                font-size: 0.8125rem;
            }
            
            .step-title {
                font-size: 1.25rem;
            }
            
            .form-card {
                padding: 1.25rem;
            }
            
            .progress-wrapper {
                padding: 1.25rem;
            }
            
            .file-upload-label {
                padding: 2rem 1.5rem;
            }
            
            .file-upload-label i {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <main>
    <div class="container">
        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('landing.index') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali ke Beranda</span>
            </a>
        </div>

        <!-- Package Summary -->
        <div class="package-summary">
            <h5>{{ $package->name }}</h5>
            <span class="price">{{ $package->formatted_price }}</span>
            <span class="text-muted"> / orang</span>
        </div>

        <!-- Progress Indicator -->
        <div class="progress-wrapper">
            <div class="progress-steps">
                <div class="progress-line" id="progressLine" style="width: 0%"></div>
                
                <div class="step active" data-step="1">
                    <div class="step-circle">1</div>
                    <div class="step-label">Informasi<br>Pengunjung</div>
                </div>
                <div class="step" data-step="2">
                    <div class="step-circle">2</div>
                    <div class="step-label">Detail<br>Kunjungan</div>
                </div>
                <div class="step" data-step="3">
                    <div class="step-circle">3</div>
                    <div class="step-label">Pembayaran</div>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="form-card">
            @if($errors->any())
            <div class="alert-danger">
                <strong><i class="fas fa-exclamation-triangle me-2"></i>Terdapat kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('landing.booking.store') }}" method="POST" enctype="multipart/form-data" id="bookingForm">
                @csrf
                <input type="hidden" name="wisata_package_id" value="{{ $package->id }}">

                <!-- Step 1: Informasi Pengunjung -->
                <div class="step-content active" data-step="1">
                    <h2 class="step-title">
                        <i class="fas fa-user-circle"></i>
                        Informasi Pengunjung
                    </h2>
                    <p class="step-description">Masukkan data diri Anda dengan lengkap dan benar</p>

                    <div class="mb-4">
                        <label for="visitor_name" class="form-label">
                            Nama Lengkap<span class="required">*</span>
                        </label>
                        <input type="text" class="form-control" id="visitor_name" name="visitor_name" 
                               value="{{ old('visitor_name') }}" placeholder="Contoh: John Doe" required>
                        <small class="form-text">
                            <i class="fas fa-info-circle"></i>
                            Sesuai dengan identitas resmi (KTP/Paspor)
                        </small>
                    </div>

                    <div class="mb-4">
                        <label for="visitor_email" class="form-label">
                            Alamat Email<span class="required">*</span>
                        </label>
                        <input type="email" class="form-control" id="visitor_email" name="visitor_email" 
                               value="{{ old('visitor_email') }}" placeholder="email@example.com" required>
                        <small class="form-text">
                            <i class="fas fa-envelope"></i>
                            E-Tiket akan dikirim ke email ini
                        </small>
                    </div>

                    <div class="mb-4">
                        <label for="visitor_phone" class="form-label">
                            No. Telepon / WhatsApp<span class="required">*</span>
                        </label>
                        <input type="tel" class="form-control" id="visitor_phone" name="visitor_phone" 
                               value="{{ old('visitor_phone') }}" placeholder="08xxxxxxxxxx" required>
                        <small class="form-text">
                            <i class="fas fa-phone"></i>
                            Untuk konfirmasi dan informasi penting
                        </small>
                    </div>
                </div>

                <!-- Step 2: Detail Kunjungan -->
                <div class="step-content" data-step="2">
                    <h2 class="step-title">
                        <i class="fas fa-calendar-check"></i>
                        Detail Kunjungan
                    </h2>
                    <p class="step-description">Tentukan tanggal dan jumlah tiket yang Anda inginkan</p>

                    <div class="mb-4">
                        <label for="visit_date" class="form-label">
                            Tanggal Kunjungan<span class="required">*</span>
                        </label>
                        <input type="date" class="form-control" id="visit_date" name="visit_date" 
                               value="{{ old('visit_date') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                        <small class="form-text">
                            <i class="fas fa-info-circle"></i>
                            Pemesanan minimal H-1 dari tanggal kunjungan
                        </small>
                    </div>

                    <div class="mb-4">
                        <label for="quantity" class="form-label">
                            Jumlah Tiket<span class="required">*</span>
                        </label>
                        <input type="number" class="form-control" id="quantity" name="quantity" 
                               value="{{ old('quantity', 1) }}" min="1" max="{{ $package->max_capacity }}" required>
                        <small class="form-text">
                            <i class="fas fa-users"></i>
                            Maksimal {{ $package->max_capacity }} tiket per pemesanan
                        </small>
                    </div>

                    <div class="total-display-card">
                        <div class="total-label">Total Pembayaran</div>
                        <div class="total-amount" id="total_amount">Rp {{ number_format($package->price * (old('quantity', 1) ?: 1), 0, ',', '.') }}</div>
                    </div>
                </div>

                <!-- Step 3: Pembayaran -->
                <div class="step-content" data-step="3">
                    <h2 class="step-title">
                        <i class="fas fa-credit-card"></i>
                        Pembayaran
                    </h2>
                    <p class="step-description">Transfer sesuai total pembayaran dan upload bukti transfer</p>

                    <div class="payment-info">
                        <h6>
                            <i class="fas fa-university"></i>
                            Informasi Rekening Pembayaran
                        </h6>
                        <p class="mb-2">Silakan transfer sesuai total pembayaran ke rekening berikut:</p>
                        <div class="bank-details">
                            <p class="mb-1">
                                <strong>Bank BCA</strong>
                            </p>
                            <p class="mb-1">
                                No. Rekening: <strong>1234567890</strong>
                            </p>
                            <p class="mb-0">
                                Atas Nama: <strong>PT Wisata Lapade Indonesia</strong>
                            </p>
                        </div>
                        <p class="mb-0 mt-3">
                            <small>
                                <i class="fas fa-exclamation-circle me-1"></i>
                                Pastikan nominal transfer sesuai dengan total pembayaran
                            </small>
                        </p>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">
                            Upload Bukti Transfer<span class="required">*</span>
                        </label>
                        <div class="file-upload-wrapper">
                            <label for="payment_proof" class="file-upload-label">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <div class="file-upload-text">
                                    <strong>Klik untuk memilih file</strong>
                                    <small class="form-text d-block">Format: JPG, PNG, JPEG (Maks. 2MB)</small>
                                </div>
                            </label>
                            <input type="file" id="payment_proof" name="payment_proof" accept="image/*" required>
                        </div>
                    </div>

                    <div class="alert alert-info" style="background: #e7f3ff; border-left: 4px solid var(--primary-color); border-radius: 12px; padding: 1rem;">
                        <small>
                            <i class="fas fa-info-circle me-1"></i>
                            <strong>Informasi Penting:</strong><br>
                            • E-Tiket akan dikirim via email setelah pembayaran terverifikasi (maks. 2x24 jam)<br>
                            • Tunjukkan QR Code pada E-Tiket saat check-in<br>
                            • Simpan E-Tiket dengan baik hingga hari kunjungan
                        </small>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="form-navigation">
                    <button type="button" class="btn-nav btn-prev" id="prevBtn" onclick="changeStep(-1)" style="display: none;">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali</span>
                    </button>
                    <button type="button" class="btn-nav btn-next" id="nextBtn" onclick="changeStep(1)">
                        <span>Selanjutnya</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                    <button type="submit" class="btn-nav btn-submit" id="submitBtn" style="display: none;">
                        <i class="fas fa-paper-plane"></i>
                        <span>Kirim Pemesanan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentStep = 1;
        const totalSteps = 3;
        const packagePrice = parseFloat({{ $package->price }});

        // Initialize
        showStep(currentStep);

        function showStep(step) {
            const stepContents = document.querySelectorAll('.step-content');
            const steps = document.querySelectorAll('.step');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const submitBtn = document.getElementById('submitBtn');
            const progressLine = document.getElementById('progressLine');

            // Hide all steps
            stepContents.forEach(content => {
                content.classList.remove('active');
            });

            // Show current step
            document.querySelector(`.step-content[data-step="${step}"]`).classList.add('active');

            // Update step indicators
            steps.forEach((stepEl, index) => {
                stepEl.classList.remove('active', 'completed');
                if (index + 1 < step) {
                    stepEl.classList.add('completed');
                } else if (index + 1 === step) {
                    stepEl.classList.add('active');
                }
            });

            // Update progress line
            const progress = ((step - 1) / (totalSteps - 1)) * 100;
            progressLine.style.width = progress + '%';

            // Handle button visibility
            prevBtn.style.display = step === 1 ? 'none' : 'flex';
            nextBtn.style.display = step === totalSteps ? 'none' : 'flex';
            submitBtn.style.display = step === totalSteps ? 'flex' : 'none';

            // Update total if step 2 is shown
            if (step === 2) {
                updateTotal();
            }

            // Scroll to top
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function changeStep(direction) {
            // Validate current step before moving
            if (direction === 1 && !validateStep(currentStep)) {
                return;
            }

            currentStep += direction;
            
            if (currentStep < 1) currentStep = 1;
            if (currentStep > totalSteps) currentStep = totalSteps;

            showStep(currentStep);
        }

        function validateStep(step) {
            const currentStepContent = document.querySelector(`.step-content[data-step="${step}"]`);
            const inputs = currentStepContent.querySelectorAll('input[required]');
            
            let isValid = true;
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                alert('Mohon lengkapi semua field yang wajib diisi');
            }

            return isValid;
        }

        // Calculate total
        function updateTotal() {
            const quantityInput = document.getElementById('quantity');
            const totalAmountDiv = document.getElementById('total_amount');
            
            if (!quantityInput || !totalAmountDiv) {
                return;
            }
            
            const quantity = parseInt(quantityInput.value) || 1;
            const total = quantity * packagePrice;
            totalAmountDiv.textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        // Setup event listener for quantity input (using event delegation)
        document.addEventListener('input', function(e) {
            if (e.target && e.target.id === 'quantity') {
                updateTotal();
            }
        });
        
        document.addEventListener('change', function(e) {
            if (e.target && e.target.id === 'quantity') {
                updateTotal();
            }
        });

        // File upload feedback
        const fileInput = document.getElementById('payment_proof');
        const fileLabel = document.querySelector('.file-upload-label');

        fileInput.addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            if (fileName) {
                fileLabel.innerHTML = `
                    <i class="fas fa-check-circle" style="color: var(--success-color); font-size: 2.5rem;"></i>
                    <div class="file-upload-text">
                        <strong style="color: var(--success-color);">✓ ${fileName}</strong>
                        <small class="form-text d-block">Klik untuk mengganti file</small>
                    </div>
                `;
            }
        });

        // Form validation
        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            if (!validateStep(3)) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
