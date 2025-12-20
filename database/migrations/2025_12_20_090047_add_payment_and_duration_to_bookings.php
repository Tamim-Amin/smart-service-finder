<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('estimated_duration', 4, 2)->default(1)->after('service_time'); // in hours
            $table->decimal('estimated_cost', 10, 2)->nullable()->after('estimated_duration');
            $table->enum('payment_method', ['cash', 'bkash', 'nagad'])->default('cash')->after('estimated_cost');
            $table->enum('payment_status', ['pending', 'paid', 'refunded'])->default('pending')->after('payment_method');
            $table->string('transaction_id')->nullable()->after('payment_status');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'estimated_duration',
                'estimated_cost',
                'payment_method',
                'payment_status',
                'transaction_id'
            ]);
        });
    }
};