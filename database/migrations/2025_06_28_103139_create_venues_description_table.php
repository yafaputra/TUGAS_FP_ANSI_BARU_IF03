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
        Schema::create('courts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('venue_mendaftars_id')->nullable();
            $table->foreign('venue_mendaftars_id')
                ->references('id')
                ->on('venue_mendaftars') // Pastikan nama tabel benar
                ->onDelete('cascade');
            $table->string('name'); // Nama lapangan, cth: Lapangan Futsal 1, Lapangan Badminton A
            $table->string('type'); // Jenis lapangan, cth: Futsal, Badminton
            $table->string('surface_type')->nullable(); // Tipe permukaan, cth: Vinyl, Sintetis
            $table->text('description')->nullable(); // Deskripsi singkat lapangan
            $table->string('image_url')->nullable(); // Gambar spesifik lapangan
            $table->decimal('base_price_per_hour', 10, 2); // Harga dasar per jam
            $table->boolean('is_indoor')->default(true); // Lapangan indoor/outdoor
            $table->timestamps();
        });
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('courts');
    }
};
