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
        Schema::create('profils_user', function (Blueprint $table) {
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->string('username')->unique();
            $table->string('full_name')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('phone_number')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->text('bio')->nullable();
            $table->json('favorite_sports')->nullable(); // Simpan array olahraga favorit sebagai JSON
            $table->string('avatar')->nullable(); // Path ke gambar avatar
            $table->timestamps();

            $table->primary('user_id'); // Menjadikan user_id sebagai primary key
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profils_user');
    }
};