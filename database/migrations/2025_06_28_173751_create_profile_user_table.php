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
<<<<<<< HEAD:database/migrations/2025_06_28_173751_create_profile_user_table.php
        Schema::create('profile_user', function (Blueprint $table) {
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->string('username')->unique();
            $table->string('full_name')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('phone_number')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->text('bio')->nullable();
            $table->json('favorite_sports')->nullable(); // Simpan array olahraga favorit sebagai JSON
            $table->string('avatar')->nullable(); // Path ke gambar avatar
=======
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
>>>>>>> bb5addc04e56a4ec8fa6c893357a1810e909a985:database/migrations/2025_06_28_173751_create_profils_user_table.php
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
<<<<<<< HEAD:database/migrations/2025_06_28_173751_create_profile_user_table.php
        Schema::dropIfExists('profil_user');
    }
};
=======
        Schema::dropIfExists('bookings');
    }
};



>>>>>>> bb5addc04e56a4ec8fa6c893357a1810e909a985:database/migrations/2025_06_28_173751_create_profils_user_table.php
