<?php

// php artisan make:migration create_bookings_table --create=bookings
// Kemudian isi file migrasi dengan ini:
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
       // Pastikan ini sudah dijalankan: php artisan migrate
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profils_user_id');
            $table->unsignedBigInteger('court_id');
            $table->date('booking_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('duration_hours');
            $table->decimal('total_price', 10, 2);
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('payment_method') ->nullable(); // Jika ingin menyimpan metode pembayaran
            $table->string('status')->default('pending');
            $table->timestamps();

            $table->foreign('profils_user_id')->references('id')->on('profils_user')->onDelete('cascade');
            $table->foreign('court_id')->references('id')->on('courts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};



