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
        Schema::create('detail_pesanans', function (Blueprint $table) {
            $table->id('id_detail_pesanan');
            $table->foreignId('id_pesanan')
                  ->constrained('pesanans', 'id_pesanan')
                  ->onDelete('cascade');
            $table->foreignId('id_model')
                  ->constrained('models', 'id_model')
                  ->onDelete('restrict');
            $table->string('bahan', 50);
            $table->string('ukuran', 20);
            $table->integer('jumlah');
            $table->decimal('Harga_satuan', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pesanan');
    }
};
