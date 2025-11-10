<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WisataPackage extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'description',
        'price',
        'max_capacity',
        'image',
        'facilities',
        'is_active',
        'featured',
    ];
    
    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'featured' => 'boolean',
    ];
    
    // Relationships
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    
    // Helper methods
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}
