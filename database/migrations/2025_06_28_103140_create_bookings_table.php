<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('court_id')->constrained('courts')->onDelete('cascade'); // Foreign key ke tabel court
            $table->date('booking_date'); // Tanggal booking
            $table->time('start_time'); // Waktu mulai booking
            $table->time('end_time'); // Waktu selesai booking (bisa dihitung dari start_time + duration)
            $table->integer('duration_hours'); // Durasi booking dalam jam
            $table->decimal('total_price', 10, 2); // Total harga booking
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('status')->default('pending'); // Status booking: pending, confirmed, cancelled, completed
            $table->timestamps();

            // Tambahkan unique constraint untuk mencegah double booking pada waktu yang sama di lapangan yang sama
            $table->unique(['court_id', 'booking_date', 'start_time', 'end_time']);
        });
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};