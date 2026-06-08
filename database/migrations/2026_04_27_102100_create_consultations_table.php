<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('recommended_hair_style_id')->nullable()->constrained('hair_styles')->nullOnDelete();

            $table->string('status')->default('pending'); // pending | replied | closed

            $table->string('selfie_path');
            $table->text('user_message')->nullable();

            $table->text('admin_message')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};

