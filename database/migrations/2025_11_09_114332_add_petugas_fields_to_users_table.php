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
        Schema::table('users', function (Blueprint $table) {
            $table->string('employee_id')->nullable()->unique();
            $table->string('phone')->nullable();
            $table->enum('shift', ['pagi', 'siang', 'malam', 'full'])->nullable();
            $table->date('start_date')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('can_scan')->default(true);
            $table->boolean('can_view_reports')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['employee_id', 'phone', 'shift', 'start_date', 'notes', 'can_scan', 'can_view_reports']);
        });
    }
};
