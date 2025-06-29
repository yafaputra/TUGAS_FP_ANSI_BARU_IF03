<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('sparrings', function (Blueprint $table) {
            $table->id();
            $table->string('team_name');
            $table->string('team_initials');
            $table->string('sport_type');
            $table->string('level')->nullable();
            $table->decimal('rating', 3, 2)->nullable();
            $table->dateTime('datetime');
            $table->string('location');
            $table->integer('total_cost')->nullable();
            $table->integer('down_payment')->default(0);
            $table->string('city');
            $table->string('team_color')->default('green'); // For the avatar gradient
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('sparrings');
    }
};