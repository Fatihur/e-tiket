<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WisataPackage;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LandingController extends Controller
{
    public function index()
    {
        $packages = WisataPackage::where('is_active', true)->get();
        return view('landing.index', compact('packages'));
    }
    
    public function packageDetail($id)
    {
        $package = WisataPackage::findOrFail($id);
        return view('landing.package-detail', compact('package'));
    }
    
    public function booking($id)
    {
        $package = WisataPackage::findOrFail($id);
        return view('landing.booking', compact('package'));
    }
    
    public function storeBooking(Request $request)
    {
        $request->validate([
            'wisata_package_id' => 'required|exists:wisata_packages,id',
            'visitor_name' => 'required|string|max:255',
            'visitor_email' => 'required|email|max:255',
            'visitor_phone' => 'required|string|max:20',
            'visit_date' => 'required|date|after:today',
            'quantity' => 'required|integer|min:1',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        $package = WisataPackage::findOrFail($request->wisata_package_id);
        $totalAmount = $package->price * $request->quantity;
        
        // Upload payment proof
        $paymentProof = null;
        if ($request->hasFile('payment_proof')) {
            $paymentProof = $request->file('payment_proof')->store('payment-proofs', 'public');
        }
        
        // Create booking
        $booking = Booking::create([
            'booking_code' => 'TIK-' . Carbon::now()->format('YmdHis') . '-' . Str::random(4),
            'wisata_package_id' => $request->wisata_package_id,
            'visitor_name' => $request->visitor_name,
            'visitor_email' => $request->visitor_email,
            'visitor_phone' => $request->visitor_phone,
            'visit_date' => $request->visit_date,
            'quantity' => $request->quantity,
            'total_amount' => $totalAmount,
            'payment_proof' => $paymentProof,
            'status' => 'pending',
        ]);
        
        return redirect()->route('landing.booking.success', $booking->id)
                        ->with('success', 'Booking berhasil dibuat! Silakan tunggu konfirmasi dari admin.');
    }
    
    public function bookingSuccess($id)
    {
        $booking = Booking::with(['wisataPackage', 'tickets'])->findOrFail($id);
        return view('landing.booking-success', compact('booking'));
    }
}
