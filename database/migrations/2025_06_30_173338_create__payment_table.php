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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->unsignedBigInteger('profils_user_id'); // To directly link to user's profile
            $table->decimal('amount', 10, 2);
            $table->string('payment_method'); // e.g., 'BRI', 'DANA'
            $table->string('transaction_id')->nullable(); // For external payment gateway ID
            $table->string('status')->default('pending'); // pending, paid, failed, expired, etc.
            $table->string('account_name')->nullable(); // For bank transfer beneficiary name
            $table->string('account_number')->nullable(); // For bank transfer account number
            $table->string('payment_code')->nullable(); // For Virtual Account / QRIS string / reference number

            $table->timestamp('paid_at')->nullable();
            $table->timestamp('expires_at')->nullable(); // For payment deadline

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->foreign('profils_user_id')->references('id')->on('profils_user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};