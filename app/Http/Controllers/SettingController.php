<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

class SettingController extends Controller
{
    public function index()
    {
        $generalSettings = Setting::where('group', 'general')->get();
        $emailSettings = Setting::where('group', 'email')->get();
        
        return view('admin.settings.index', compact('generalSettings', 'emailSettings'));
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'settings' => 'required|array',
        ]);
        
        foreach ($request->settings as $key => $value) {
            Setting::set($key, $value);
        }
        
        // Clear settings cache
        Setting::clearCache();
        
        // Update mail configuration in config
        $this->updateMailConfig();
        
        return redirect()->route('admin.settings.index')
                        ->with('success', 'Pengaturan berhasil diperbarui!');
    }
    
    public function testEmail(Request $request)
    {
        $request->validate([
            'test_email' => 'required|email',
        ]);
        
        try {
            // Update mail configuration
            $this->updateMailConfig();
            
            // Send test email
            Mail::raw('Ini adalah email test dari E-Tiket Wisata Lapade. Jika Anda menerima email ini, konfigurasi email Anda sudah benar!', function ($message) use ($request) {
                $message->to($request->test_email)
                       ->subject('Test Email - E-Tiket Wisata Lapade');
            });
            
            return response()->json([
                'success' => true,
                'message' => 'Email test berhasil dikirim ke ' . $request->test_email
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim email: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Update mail configuration from database settings
     */
    private function updateMailConfig()
    {
        $mailHost = Setting::get('mail_host', 'smtp.gmail.com');
        $mailPort = Setting::get('mail_port', '587');
        $mailUsername = Setting::get('mail_username', '');
        $mailPassword = Setting::get('mail_password', '');
        $mailEncryption = Setting::get('mail_encryption', 'tls');
        $mailFromAddress = Setting::get('mail_from_address', 'noreply@wisatalapade.com');
        $mailFromName = Setting::get('mail_from_name', 'E-Tiket Wisata Lapade');
        
        Config::set('mail.mailers.smtp.host', $mailHost);
        Config::set('mail.mailers.smtp.port', $mailPort);
        Config::set('mail.mailers.smtp.username', $mailUsername);
        Config::set('mail.mailers.smtp.password', $mailPassword);
        Config::set('mail.mailers.smtp.encryption', $mailEncryption);
        Config::set('mail.from.address', $mailFromAddress);
        Config::set('mail.from.name', $mailFromName);
        
        // Purge mailer to apply new config
        Mail::purge('smtp');
    }
}
