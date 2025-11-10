<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PetugasController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'today_scanned' => Ticket::where('is_used', true)
                                   ->whereDate('used_at', today())
                                   ->count(),
            'total_scanned' => Ticket::where('is_used', true)->count(),
            'pending_tickets' => Ticket::where('is_used', false)
                                      ->whereHas('booking', function($q) {
                                          $q->where('status', 'confirmed');
                                      })
                                      ->count(),
        ];
        
        $recent_scans = Ticket::with(['booking', 'scanner'])
                             ->where('is_used', true)
                             ->orderBy('used_at', 'desc')
                             ->take(10)
                             ->get();
        
        return view('petugas.dashboard', compact('stats', 'recent_scans'));
    }
    
    public function scanner()
    {
        return view('petugas.scanner');
    }
    
    public function scanTicket(Request $request)
    {
        $request->validate([
            'qr_data' => 'required|string',
        ]);
        
        try {
            $qrData = json_decode($request->qr_data, true);
            
            if (!$qrData || !isset($qrData['ticket_code'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'QR Code tidak valid!'
                ]);
            }
            
            $ticket = Ticket::where('ticket_code', $qrData['ticket_code'])->first();
            
            if (!$ticket) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tiket tidak ditemukan!'
                ]);
            }
            
            if ($ticket->is_used) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tiket sudah pernah digunakan pada ' . $ticket->used_at->format('d/m/Y H:i:s')
                ]);
            }
            
            // Check if booking is confirmed
            if ($ticket->booking->status !== 'confirmed') {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking belum dikonfirmasi!'
                ]);
            }
            
            // Check visit date
            if ($ticket->booking->visit_date->format('Y-m-d') !== now()->format('Y-m-d')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tiket tidak berlaku untuk hari ini. Tanggal kunjungan: ' . $ticket->booking->visit_date->format('d/m/Y')
                ]);
            }
            
            // Mark ticket as used
            $ticket->update([
                'is_used' => true,
                'used_at' => now(),
                'scanned_by' => auth()->id(),
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Tiket berhasil discan!',
                'ticket' => [
                    'ticket_code' => $ticket->ticket_code,
                    'visitor_name' => $ticket->booking->visitor_name,
                    'package_name' => $ticket->booking->wisataPackage->name,
                    'visit_date' => $ticket->booking->visit_date->format('d/m/Y'),
                    'used_at' => $ticket->used_at->format('d/m/Y H:i:s'),
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses QR Code!'
            ]);
        }
    }
    
    public function validatedTickets()
    {
        $tickets = Ticket::with(['booking.wisataPackage', 'scanner'])
                         ->where('is_used', true)
                         ->orderBy('used_at', 'desc')
                         ->paginate(20);
        
        return view('petugas.validated-tickets', compact('tickets'));
    }
    
    public function ticketDetail($id)
    {
        $ticket = Ticket::with(['booking.wisataPackage', 'scanner'])->findOrFail($id);
        return view('petugas.ticket-detail', compact('ticket'));
    }
}
