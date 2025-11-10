<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Ticket;
use Carbon\Carbon;

class BendaharaController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_revenue' => Booking::where('status', 'confirmed')->sum('total_amount'),
            'today_revenue' => Booking::where('status', 'confirmed')
                                    ->whereDate('created_at', today())
                                    ->sum('total_amount'),
            'pending_verification' => Booking::where('status', 'confirmed')
                                           ->whereNull('verified_at')
                                           ->count(),
            'verified_transactions' => Booking::where('status', 'confirmed')
                                             ->whereNotNull('verified_at')
                                             ->count(),
        ];
        
        return view('bendahara.dashboard', compact('stats'));
    }
    
    public function transactions()
    {
        $transactions = Booking::with(['wisataPackage', 'validator'])
                              ->where('status', 'confirmed')
                              ->orderBy('created_at', 'desc')
                              ->get();
        
        return view('bendahara.transactions', compact('transactions'));
    }
    
    public function reports()
    {
        $daily = Booking::where('status', 'confirmed')
                       ->whereDate('created_at', today())
                       ->sum('total_amount');
        
        $weekly = Booking::where('status', 'confirmed')
                        ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                        ->sum('total_amount');
        
        $monthly = Booking::where('status', 'confirmed')
                         ->whereMonth('created_at', now()->month)
                         ->whereYear('created_at', now()->year)
                         ->sum('total_amount');
        
        $yearly = Booking::where('status', 'confirmed')
                        ->whereYear('created_at', now()->year)
                        ->sum('total_amount');
        
        // Monthly breakdown for current year
        $monthlyBreakdown = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyBreakdown[] = Booking::where('status', 'confirmed')
                                        ->whereMonth('created_at', $i)
                                        ->whereYear('created_at', now()->year)
                                        ->sum('total_amount');
        }
        
        return view('bendahara.reports', compact('daily', 'weekly', 'monthly', 'yearly', 'monthlyBreakdown'));
    }
    
    public function verifyReport(Request $request)
    {
        $request->validate([
            'booking_ids' => 'required|array',
            'booking_ids.*' => 'exists:bookings,id',
        ]);
        
        Booking::whereIn('id', $request->booking_ids)
               ->update([
                   'verified_at' => now(),
                   'verified_by' => auth()->id(),
               ]);
        
        return redirect()->back()->with('success', 'Laporan berhasil diverifikasi!');
    }
}
