<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            
            // PERUBAHAN ADA DI SINI: Saya tambahkan 'qris' di akhir list
            $table->enum('payment_method', [
                'transfer_bca', 
                'transfer_bni', 
                'transfer_bri', 
                'transfer_mandiri', 
                'ewallet_dana', 
                'ewallet_gopay', 
                'ewallet_ovo',
                'qris' 
            ]);
            
            $table->string('payment_proof')->nullable();
            $table->decimal('amount', 12, 2);
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};