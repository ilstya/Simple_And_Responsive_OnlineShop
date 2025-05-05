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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->foreignId('id_pelanggan')
                  ->constrained('pelanggans', 'id_pelanggan')
                  ->onDelete('cascade');
            $table->foreignId('id_admin')
                  ->nullable()
                  ->constrained('admins', 'id_admin')
                  ->onDelete('set null');
            $table->string('status_pesanan', 50);
            $table->dateTime('tanggal_pesanan');
            $table->decimal('harga', 10, 2);
            // jika ingin created_at/updated_at, uncomment:
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
