# Fitur Logout System

Sistem logout yang comprehensive dengan security features, session management, logging, dan multi-role support untuk semua user dalam aplikasi E-Tiket Wisata.

## 🎯 Fitur Utama

### 1. **Standard Logout** (`POST /logout`)
- ✅ **Session Invalidation**: Complete session cleanup
- ✅ **CSRF Protection**: Secure logout dengan token validation
- ✅ **Activity Logging**: Log semua aktivitas logout untuk audit
- ✅ **Remember Token Cleanup**: Clear persistent login tokens
- ✅ **Multi-device Support**: Logout dari device yang sedang aktif
- ✅ **Redirect Management**: Smart redirect ke login dengan message

### 2. **Enhanced Login System** (`AuthController`)
- ✅ **Role-based Redirect**: Otomatis redirect sesuai user role
- ✅ **Account Status Check**: Validasi user aktif sebelum login
- ✅ **Login Activity Logging**: Track semua login attempts
- ✅ **Last Login Tracking**: Update timestamp login terakhir
- ✅ **Remember Me Functionality**: Persistent login dengan secure tokens
- ✅ **Failed Login Protection**: Log failed attempts untuk security

### 3. **Force Logout** (Admin Only)
- ✅ **Admin Privilege**: Hanya admin yang dapat force logout user lain
- ✅ **Remote Session Kill**: Clear remember token untuk force re-login
- ✅ **Audit Trail**: Log force logout activities dengan admin info
- ✅ **API Endpoint**: AJAX-friendly untuk admin dashboard

### 4. **Profile Management**
- ✅ **View Profile**: Display user information dan last login
- ✅ **Update Profile**: Edit nama, email, password dengan validasi
- ✅ **Password Change**: Secure password update dengan current password check
- ✅ **Activity Logging**: Track profile updates untuk audit

## 🔐 Security Features

### Session Security
```php
// Complete session cleanup
Auth::logout();
$request->session()->invalidate();        // Destroy session data
$request->session()->regenerateToken();   // Regenerate CSRF token

// Clear remember token
if ($user && $user->remember_token) {
    $user->update(['remember_token' => null]);
}
```

### Activity Logging
```php
// Comprehensive logout logging
Log::info('User logged out', [
    'user_id' => $user->id,
    'email' => $user->email,
    'role' => $user->role,
    'ip_address' => $request->ip(),
    'user_agent' => $request->userAgent(),
    'logout_time' => now(),
    'session_duration' => $user->last_login ? now()->diffInMinutes($user->last_login) . ' minutes' : 'unknown'
]);
```

### Login Validation
```php
// Multi-layer validation
- User exists check
- Account active status
- Password verification
- Role validation
- Device fingerprinting
```

## 🎨 User Interface

### Login Page Features
- ✅ **Modern Design**: Bootstrap 5 dengan Remixicon
- ✅ **Error Handling**: Comprehensive error messages
- ✅ **Success Messages**: Feedback untuk user actions
- ✅ **Demo Accounts**: Click-to-fill untuk testing
- ✅ **Password Toggle**: Show/hide password functionality
- ✅ **Remember Me**: Checkbox untuk persistent login
- ✅ **Responsive Layout**: Mobile-friendly design

### Demo Account Integration
```javascript
// Auto-fill demo credentials
const demoAccounts = [
    { email: 'admin@etiket.com', password: 'admin123', role: 'Admin' },
    { email: 'petugas@etiket.com', password: 'petugas123', role: 'Petugas' },
    { email: 'bendahara@etiket.com', password: 'bendahara123', role: 'Bendahara' },
    { email: 'owner@etiket.com', password: 'owner123', role: 'Owner' }
];

function fillDemo(email, password) {
    document.getElementById('email').value = email;
    document.getElementById('password').value = password;
}
```

### Interactive Elements
- ✅ **Hover Effects**: Visual feedback pada demo accounts
- ✅ **Loading States**: Button states saat login process
- ✅ **Form Validation**: Real-time validation feedback
- ✅ **Auto Focus**: Email field auto-focus untuk UX

## 🔄 Multi-Role Authentication

### Role-based Redirect Logic
```php
private function redirectBasedOnRole(User $user)
{
    // Security check - verify user still active
    if (!$user->is_active) {
        Auth::logout();
        return redirect()->route('login')->withErrors(['email' => 'Akun Anda telah dinonaktifkan.']);
    }
    
    switch ($user->role) {
        case 'admin':
            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang, ' . $user->name . '!');
        case 'petugas':
            return redirect()->route('petugas.dashboard')->with('success', 'Selamat datang, ' . $user->name . '!');
        case 'bendahara':
            return redirect()->route('bendahara.dashboard')->with('success', 'Selamat datang, ' . $user->name . '!');
        case 'owner':
            return redirect()->route('owner.dashboard')->with('success', 'Selamat datang, ' . $user->name . '!');
        default:
            Auth::logout();
            return redirect()->route('login')->withErrors(['email' => 'Role tidak valid.']);
    }
}
```

### Dashboard Access Control
```php
// Middleware untuk setiap role
Route::middleware('auth')->group(function () {
    // Admin routes dengan role check
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function() {
            if (!auth()->user()->isAdmin()) {
                return redirect()->route('login')->with('error', 'Unauthorized access');
            }
            return view('admin.dashboard');
        });
    });
    
    // Similar untuk petugas, bendahara, owner
});
```

## 📊 Activity Monitoring

### Login Activity Tracking
```php
// Successful login logging
Log::info('User logged in successfully', [
    'user_id' => auth()->user()->id,
    'email' => auth()->user()->email,
    'role' => auth()->user()->role,
    'ip_address' => $request->ip(),
    'user_agent' => $request->userAgent(),
    'login_time' => now(),
    'remember_me' => $request->boolean('remember')
]);

// Failed login logging
Log::warning('Failed login attempt', [
    'email' => $request->email,
    'ip_address' => $request->ip(),
    'user_agent' => $request->userAgent(),
    'attempt_time' => now(),
    'reason' => 'Invalid credentials'
]);
```

### Force Logout Monitoring
```php
// Admin force logout logging
Log::warning('User force logged out by admin', [
    'target_user_id' => $targetUser->id,
    'target_email' => $targetUser->email,
    'admin_user_id' => auth()->user()->id,
    'admin_email' => auth()->user()->email,
    'force_logout_time' => now()
]);
```

## 🚀 Routes Structure

### Authentication Routes
```php
// Guest routes (not authenticated)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/force-logout/{userId}', [AuthController::class, 'forceLogout'])->name('force.logout');
});

// Role-specific dashboard redirects
Route::get('/dashboard', function () {
    if (!auth()->check()) return redirect()->route('login');
    
    return match(auth()->user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'petugas' => redirect()->route('petugas.dashboard'),
        'bendahara' => redirect()->route('bendahara.dashboard'),
        'owner' => redirect()->route('owner.dashboard'),
        default => redirect()->route('login')
    };
})->name('dashboard');
```

## 💾 Database Schema

### User Model Enhancement
```php
protected $fillable = [
    'name', 'email', 'password', 'role', 'is_active',
    'employee_id', 'phone', 'shift', 'start_date', 'notes',
    'can_scan', 'can_view_reports', 'last_login'
];

protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
    'is_active' => 'boolean',
    'can_scan' => 'boolean',
    'can_view_reports' => 'boolean',
    'start_date' => 'date',
    'last_login' => 'datetime'
];

// Helper methods
public function isAdmin() { return $this->role === 'admin'; }
public function isPetugas() { return $this->role === 'petugas'; }
public function isBendahara() { return $this->role === 'bendahara'; }
public function isOwner() { return $this->role === 'owner'; }
```

## 🔧 Implementation Details

### AuthController Methods
```php
public function showLogin()              // Display login form
public function login(Request $request)  // Process login
public function logout(Request $request) // Process logout
public function forceLogout($userId)     // Admin force logout
public function profile()                // View profile
public function updateProfile()          // Update profile
private function redirectBasedOnRole()   // Role-based routing
```

### Security Validations
```php
// Login validation
$request->validate([
    'email' => 'required|email',
    'password' => 'required|min:6',
], [
    'email.required' => 'Email wajib diisi.',
    'email.email' => 'Format email tidak valid.',
    'password.required' => 'Password wajib diisi.',
    'password.min' => 'Password minimal 6 karakter.',
]);

// User status checks
if (!$user) return back()->withErrors(['email' => 'Email tidak terdaftar dalam sistem.']);
if (!$user->is_active) return back()->withErrors(['email' => 'Akun Anda tidak aktif.']);
```

## 📱 User Experience

### Logout Flow
```
1. User clicks logout button/link
2. POST request to /logout dengan CSRF token
3. Server validates session dan user
4. Log logout activity dengan details
5. Clear session, invalidate tokens
6. Redirect ke login dengan success message
7. Login page shows confirmation message
```

### Login Flow
```
1. User access /login (redirect if authenticated)
2. Fill credentials atau click demo account
3. Submit form dengan validation
4. Server validates user, password, status
5. Log login activity dengan metadata
6. Update last_login timestamp
7. Redirect based on user role
8. Dashboard shows welcome message
```

### Force Logout Flow (Admin)
```
1. Admin access user management
2. Click "Force Logout" pada specific user
3. AJAX request ke /force-logout/{userId}
4. Server validates admin permission
5. Clear target user's remember_token
6. Log force logout activity
7. Return JSON response
8. Update UI dengan confirmation
```

## ⚡ Performance & Security

### Session Management
- ✅ **Session Rotation**: New session ID after login
- ✅ **Token Regeneration**: CSRF token refresh
- ✅ **Memory Cleanup**: Complete session data clearing
- ✅ **Cookie Security**: Secure cookie configuration

### Audit Trail
- ✅ **Login Tracking**: IP, user agent, timestamp
- ✅ **Logout Monitoring**: Session duration tracking
- ✅ **Failed Attempts**: Security incident logging
- ✅ **Admin Actions**: Force logout audit trail

### Error Handling
- ✅ **Graceful Failures**: User-friendly error messages
- ✅ **Security Logging**: Silent security event logging
- ✅ **Validation Feedback**: Real-time form validation
- ✅ **Redirect Protection**: Prevent logout loops

## 🧪 Testing Scenarios

### Manual Testing
1. **Standard Login/Logout**: Test semua 4 role users
2. **Remember Me**: Test persistent login functionality
3. **Failed Logins**: Test dengan wrong credentials
4. **Inactive Account**: Test dengan deactivated user
5. **Force Logout**: Test admin force logout functionality
6. **Session Security**: Test multiple device sessions

### Security Testing
1. **CSRF Protection**: Test logout tanpa token
2. **Session Fixation**: Test session security
3. **Unauthorized Access**: Test role-based access
4. **Brute Force**: Test failed login protection
5. **Token Validation**: Test remember token security

Fitur logout ini memberikan foundation yang solid untuk authentication dan authorization system dengan security yang robust dan user experience yang excellent! 🔐✨