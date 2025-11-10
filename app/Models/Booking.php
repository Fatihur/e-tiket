<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'booking_code',
        'wisata_package_id',
        'visitor_name',
        'visitor_email',
        'visitor_phone',
        'visit_date',
        'quantity',
        'total_amount',
        'payment_proof',
        'status',
        'validated_by',
        'validated_at',
        'verified_by',
        'verified_at',
        'notes',
    ];
    
    protected $casts = [
        'visit_date' => 'date',
        'total_amount' => 'decimal:2',
        'validated_at' => 'datetime',
        'verified_at' => 'datetime',
    ];
    
    // Relationships
    public function wisataPackage()
    {
        return $this->belongsTo(WisataPackage::class);
    }
    
    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }
    
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
    
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    
    // Helper methods
    public function getFormattedTotalAmountAttribute()
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }
    
    public function generateBookingCode()
    {
        return 'TIK-' . Carbon::now()->format('Ymd') . '-' . str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }
}
