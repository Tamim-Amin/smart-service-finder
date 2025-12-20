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
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('provider_id')->constrained('providers')->onDelete('cascade');
        $table->text('problem_description');
        $table->date('service_date');
        $table->time('service_time');
        $table->decimal('estimated_duration', 8, 2)->nullable();
        $table->decimal('estimated_cost', 10, 2)->nullable();
        $table->string('payment_method')->nullable();
        $table->enum('payment_status', ['pending', 'completed', 'failed', 'paid'])->default('pending');
        $table->string('transaction_id')->nullable()->unique();
        $table->decimal('total_amount', 10, 2)->nullable();
        $table->decimal('total_hours', 8, 2)->nullable();
        $table->enum('status', ['pending', 'accepted', 'rejected', 'completed', 'cancelled'])->default('pending');
        $table->timestamps();
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
