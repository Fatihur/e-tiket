<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\WisataPackage;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@etiket.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_active' => true,
        ]);
        
        // Create Petugas User
        User::create([
            'name' => 'Petugas Tiket',
            'email' => 'petugas@etiket.com',
            'password' => Hash::make('petugas123'),
            'role' => 'petugas',
            'is_active' => true,
        ]);
        
        // Create Bendahara User
        User::create([
            'name' => 'Bendahara',
            'email' => 'bendahara@etiket.com',
            'password' => Hash::make('bendahara123'),
            'role' => 'bendahara',
            'is_active' => true,
        ]);
        
        // Create Owner User
        User::create([
            'name' => 'Owner Wisata',
            'email' => 'owner@etiket.com',
            'password' => Hash::make('owner123'),
            'role' => 'owner',
            'is_active' => true,
        ]);
        
        // Create Sample Wisata Packages
        WisataPackage::create([
            'name' => 'Paket Wisata Pantai',
            'description' => 'Nikmati keindahan pantai dengan berbagai fasilitas menarik. Paket ini mencakup akses ke pantai, area bermain, dan spot foto yang Instagramable.',
            'price' => 50000,
            'max_capacity' => 100,
            'facilities' => 'Toilet, Musholla, Warung makan, Tempat parkir, Area bermain anak',
            'is_active' => true,
        ]);
        
        WisataPackage::create([
            'name' => 'Paket Wisata Gunung',
            'description' => 'Rasakan pengalaman mendaki gunung dengan pemandangan yang spektakuler. Cocok untuk pecinta alam dan adventure.',
            'price' => 75000,
            'max_capacity' => 50,
            'facilities' => 'Guide profesional, Peralatan hiking, Rest area, First aid kit',
            'is_active' => true,
        ]);
        
        WisataPackage::create([
            'name' => 'Paket Wisata Air Terjun',
            'description' => 'Jelajahi keindahan air terjun tersembunyi dengan trekking yang menantang. Sempurna untuk refreshing dan foto-foto cantik.',
            'price' => 35000,
            'max_capacity' => 75,
            'facilities' => 'Gazebo, Toilet, Area piknik, Bridge viewing',
            'is_active' => true,
        ]);
        
        WisataPackage::create([
            'name' => 'Paket Wisata Budaya',
            'description' => 'Pelajari budaya lokal melalui pertunjukan seni, kerajinan tradisional, dan kuliner khas daerah.',
            'price' => 40000,
            'max_capacity' => 80,
            'facilities' => 'Museum mini, Workshop kerajinan, Pertunjukan seni, Kuliner tradisional',
            'is_active' => true,
        ]);
    }
}
