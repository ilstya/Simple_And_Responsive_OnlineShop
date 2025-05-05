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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->foreignId('id_pesanan')
                  ->constrained('pesanans', 'id_pesanan')
                  ->onDelete('cascade');
            $table->string('Metode_pembayaran', 50);
            $table->string('Bukti_pembayaran', 250);
            $table->string('Status_pembayaran', 50);
            $table->dateTime('Tanggal_pembayaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
