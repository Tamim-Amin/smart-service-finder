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
    Schema::create('providers', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        $table->text('bio')->nullable();
        $table->integer('experience_years')->default(0);
        $table->decimal('hourly_rate', 8, 2);
        $table->string('location');
        $table->boolean('is_available')->default(true);
        $table->boolean('is_verified')->default(false);
        $table->decimal('average_rating', 3, 2)->default(0);
        $table->integer('total_reviews')->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};
