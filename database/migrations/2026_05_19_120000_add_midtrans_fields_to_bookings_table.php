<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('midtrans_order_id', 64)->nullable()->unique()->after('payment_proof_path');
            $table->string('snap_token', 255)->nullable()->after('midtrans_order_id');
            $table->string('transaction_id', 64)->nullable()->after('snap_token');
            $table->string('transaction_status', 32)->nullable()->after('transaction_id');
            $table->string('payment_type', 32)->nullable()->after('transaction_status');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'midtrans_order_id',
                'snap_token',
                'transaction_id',
                'transaction_status',
                'payment_type',
            ]);
        });
    }
};
