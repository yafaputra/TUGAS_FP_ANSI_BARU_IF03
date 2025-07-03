<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('image')->nullable();
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->string('location');
            $table->decimal('price', 10, 2)->default(0);
            $table->integer('max_participants')->nullable();
            $table->enum('status', ['active', 'inactive', 'cancelled'])->default('active');
            
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
};