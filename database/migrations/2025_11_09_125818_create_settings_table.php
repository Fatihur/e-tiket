<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('text'); // text, email, number, boolean, textarea
            $table->string('group')->default('general'); // general, email, system
            $table->timestamps();
        });

        // Insert default settings
        DB::table('settings')->insert([
            // General Settings
            ['key' => 'app_name', 'value' => 'E-Tiket Wisata Lapade', 'type' => 'text', 'group' => 'general', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'app_tagline', 'value' => 'Sistem Pemesanan Tiket Online', 'type' => 'text', 'group' => 'general', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'app_phone', 'value' => '+62 812-3456-7890', 'type' => 'text', 'group' => 'general', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'app_email', 'value' => 'info@wisatalapade.com', 'type' => 'email', 'group' => 'general', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'app_address', 'value' => 'Lapade, Indonesia', 'type' => 'textarea', 'group' => 'general', 'created_at' => now(), 'updated_at' => now()],
            
            // Email Settings
            ['key' => 'mail_mailer', 'value' => 'smtp', 'type' => 'text', 'group' => 'email', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'mail_host', 'value' => 'smtp.gmail.com', 'type' => 'text', 'group' => 'email', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'mail_port', 'value' => '587', 'type' => 'number', 'group' => 'email', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'mail_username', 'value' => '', 'type' => 'email', 'group' => 'email', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'mail_password', 'value' => '', 'type' => 'password', 'group' => 'email', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'mail_encryption', 'value' => 'tls', 'type' => 'text', 'group' => 'email', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'mail_from_address', 'value' => 'noreply@wisatalapade.com', 'type' => 'email', 'group' => 'email', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'mail_from_name', 'value' => 'E-Tiket Wisata Lapade', 'type' => 'text', 'group' => 'email', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
