<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->decimal('total_earnings', 10, 2)->default(0)->after('total_reviews');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('total_amount', 10, 2)->nullable()->after('status');
            $table->integer('total_hours')->nullable()->after('total_amount');
        });
    }

    public function down(): void
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->dropColumn('total_earnings');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['total_amount', 'total_hours']);
        });
    }
};