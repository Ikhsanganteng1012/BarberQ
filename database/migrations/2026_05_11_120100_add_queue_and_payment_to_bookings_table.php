<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('queue_code', 32)->nullable()->unique()->after('id');
            $table->string('payment_method', 20)->nullable()->after('status');
            $table->string('payment_status', 20)->default('pending')->after('payment_method');
            $table->decimal('amount', 10, 2)->nullable()->after('payment_status');
            $table->text('payment_note')->nullable()->after('amount');
        });

        $rows = DB::table('bookings')
            ->leftJoin('services', 'services.id', '=', 'bookings.service_id')
            ->whereNull('bookings.queue_code')
            ->select('bookings.id', 'services.price')
            ->get();

        foreach ($rows as $row) {
            do {
                $code = 'BRB-'.strtoupper(Str::random(8));
            } while (DB::table('bookings')->where('queue_code', $code)->exists());

            DB::table('bookings')->where('id', $row->id)->update([
                'queue_code' => $code,
                'amount' => $row->price,
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['queue_code', 'payment_method', 'payment_status', 'amount', 'payment_note']);
        });
    }
};
