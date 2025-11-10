<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (auth()->check()) {
            return $this->redirectBasedOnRole(auth()->user());
        }

        return view("auth.login");
    }

    public function login(Request $request)
    {
        $request->validate(
            [
                "email" => "required|email",
                "password" => "required|min:6",
            ],
            [
                "email.required" => "Email wajib diisi.",
                "email.email" => "Format email tidak valid.",
                "password.required" => "Password wajib diisi.",
                "password.min" => "Password minimal 6 karakter.",
            ],
        );

        // Check if user exists and is active
        $user = User::where("email", $request->email)->first();

        if (!$user) {
            return back()
                ->withErrors(["email" => "Email tidak terdaftar dalam sistem."])
                ->withInput();
        }

        if (!$user->is_active) {
            return back()
                ->withErrors([
                    "email" => "Akun Anda tidak aktif. Hubungi administrator.",
                ])
                ->withInput();
        }

        // Attempt login
        $credentials = $request->only("email", "password");
        $remember = $request->boolean("remember");

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Log successful login
            Log::info("User logged in successfully", [
                "user_id" => auth()->user()->id,
                "email" => auth()->user()->email,
                "role" => auth()->user()->role,
                "ip_address" => $request->ip(),
                "user_agent" => $request->userAgent(),
                "login_time" => now(),
            ]);

            // Update last login
            auth()
                ->user()
                ->update(["last_login" => now()]);

            return $this->redirectBasedOnRole(auth()->user());
        }

        // Log failed login attempt
        Log::warning("Failed login attempt", [
            "email" => $request->email,
            "ip_address" => $request->ip(),
            "user_agent" => $request->userAgent(),
            "attempt_time" => now(),
        ]);

        return back()
            ->withErrors(["email" => "Email atau password tidak sesuai."])
            ->withInput();
    }

    public function logout(Request $request)
    {
        $user = auth()->user();

        // Log logout activity
        if ($user) {
            Log::info("User logged out", [
                "user_id" => $user->id,
                "email" => $user->email,
                "role" => $user->role,
                "ip_address" => $request->ip(),
                "user_agent" => $request->userAgent(),
                "logout_time" => now(),
                "session_duration" => $user->last_login
                    ? now()->diffInMinutes($user->last_login) . " minutes"
                    : "unknown",
            ]);
        }

        // Clear all session data
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Clear remember token if exists
        if ($user && $user->remember_token) {
            $user->update(["remember_token" => null]);
        }

        return redirect()
            ->route("login")
            ->with("success", "Anda telah berhasil logout. Terima kasih!");
    }

    public function forceLogout(Request $request, $userId = null)
    {
        // Admin can force logout other users
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            return response()->json(["error" => "Unauthorized"], 403);
        }

        if ($userId) {
            $targetUser = User::findOrFail($userId);

            // Log force logout
            Log::warning("User force logged out by admin", [
                "target_user_id" => $targetUser->id,
                "target_email" => $targetUser->email,
                "admin_user_id" => auth()->user()->id,
                "admin_email" => auth()->user()->email,
                "force_logout_time" => now(),
            ]);

            // Clear user's remember token to force re-login
            $targetUser->update(["remember_token" => null]);

            return response()->json([
                "message" => "User berhasil di-logout paksa.",
            ]);
        }

        return response()->json(["error" => "User ID tidak ditemukan"], 404);
    }

    private function redirectBasedOnRole(User $user)
    {
        // Check if user still active (in case status changed during session)
        if (!$user->is_active) {
            Auth::logout();
            return redirect()
                ->route("login")
                ->withErrors(["email" => "Akun Anda telah dinonaktifkan."]);
        }

        switch ($user->role) {
            case "admin":
                return redirect()
                    ->route("admin.dashboard")
                    ->with("success", "Selamat datang, " . $user->name . "!");
            case "petugas":
                return redirect()
                    ->route("petugas.dashboard")
                    ->with("success", "Selamat datang, " . $user->name . "!");
            case "bendahara":
                return redirect()
                    ->route("bendahara.dashboard")
                    ->with("success", "Selamat datang, " . $user->name . "!");
            case "owner":
                return redirect()
                    ->route("owner.dashboard")
                    ->with("success", "Selamat datang, " . $user->name . "!");
            default:
                Auth::logout();
                return redirect()
                    ->route("login")
                    ->withErrors(["email" => "Role tidak valid."]);
        }
    }

    public function profile()
    {
        return view("auth.profile", ["user" => auth()->user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate(
            [
                "name" => "required|string|max:255",
                "email" => "required|email|unique:users,email," . $user->id,
                "current_password" => "nullable|required_with:password",
                "password" => "nullable|min:8|confirmed",
            ],
            [
                "name.required" => "Nama wajib diisi.",
                "email.required" => "Email wajib diisi.",
                "email.unique" => "Email sudah digunakan user lain.",
                "current_password.required_with" =>
                    "Password saat ini wajib diisi untuk mengubah password.",
                "password.min" => "Password baru minimal 8 karakter.",
                "password.confirmed" => "Konfirmasi password tidak sesuai.",
            ],
        );

        // Check current password if user wants to change password
        if ($request->filled("password")) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors([
                    "current_password" => "Password saat ini tidak sesuai.",
                ]);
            }
        }

        // Update user data
        $updateData = [
            "name" => $request->name,
            "email" => $request->email,
        ];

        if ($request->filled("password")) {
            $updateData["password"] = Hash::make($request->password);
        }

        $user->update($updateData);

        Log::info("User updated profile", [
            "user_id" => $user->id,
            "email" => $user->email,
            "updated_fields" => array_keys($updateData),
            "update_time" => now(),
        ]);

        return back()->with("success", "Profil berhasil diperbarui!");
    }
}
