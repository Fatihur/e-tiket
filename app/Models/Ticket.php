<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Ticket extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'ticket_code',
        'booking_id',
        'qr_code',
        'is_used',
        'used_at',
        'scanned_by',
    ];
    
    protected $casts = [
        'is_used' => 'boolean',
        'used_at' => 'datetime',
    ];
    
    // Relationships
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
    
    public function scanner()
    {
        return $this->belongsTo(User::class, 'scanned_by');
    }
    
    // Helper methods
    public function generateQrCode()
    {
        $qrData = json_encode([
            'ticket_code' => $this->ticket_code,
            'booking_id' => $this->booking_id,
            'visitor_name' => $this->booking->visitor_name,
            'visit_date' => $this->booking->visit_date->format('Y-m-d'),
        ]);
        
        return QrCode::size(200)->generate($qrData);
    }
    
    public function generateTicketCode()
    {
        return 'T-' . str_pad($this->booking_id, 6, '0', STR_PAD_LEFT) . '-' . str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }
}
