<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'employee_id',
        'phone',
        'shift',
        'start_date',
        'notes',
        'can_scan',
        'can_view_reports',
        'last_login',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'can_scan' => 'boolean',
            'can_view_reports' => 'boolean',
            'start_date' => 'date',
            'last_login' => 'datetime',
        ];
    }
    
    // Relationships
    public function validatedBookings()
    {
        return $this->hasMany(Booking::class, 'validated_by');
    }
    
    public function scannedTickets()
    {
        return $this->hasMany(Ticket::class, 'scanned_by');
    }
    
    // Helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    
    public function isPetugas()
    {
        return $this->role === 'petugas';
    }
    
    public function isBendahara()
    {
        return $this->role === 'bendahara';
    }
    
    public function isOwner()
    {
        return $this->role === 'owner';
    }
    
    // Generate Employee ID
    public function generateEmployeeId()
    {
        if (!$this->employee_id) {
            $prefix = 'PTK';
            $lastId = User::where('employee_id', 'LIKE', $prefix . '%')
                         ->orderBy('employee_id', 'desc')
                         ->first();
            
            if ($lastId) {
                $number = intval(substr($lastId->employee_id, 3)) + 1;
            } else {
                $number = 1;
            }
            
            $this->employee_id = $prefix . str_pad($number, 3, '0', STR_PAD_LEFT);
            $this->save();
        }
        
        return $this->employee_id;
    }
    
    // Get formatted shift
    public function getFormattedShiftAttribute()
    {
        $shifts = [
            'pagi' => 'Pagi (07:00 - 15:00)',
            'siang' => 'Siang (15:00 - 23:00)', 
            'malam' => 'Malam (23:00 - 07:00)',
            'full' => 'Full Time'
        ];
        
        return $shifts[$this->shift] ?? '-';
    }
}
