<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    protected $table = 'detail_pesanans'; // Nama tabel k

    protected $primaryKey = 'id_detail_pesanan'; // Primary key custom
    public $incrementing = true; //  id_detail_pesanan auto increment
    protected $keyType = 'int'; // Integer id

    public $timestamps = false;

    protected $fillable = [
        'id_pesanan',
        'id_model',
        'bahan',
        'ukuran',
        'jumlah',
        'harga_satuan',
    ];

    // Relasi Pesanan
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan');
    }

    // Relasi Model Katalog
    public function modelKatalog()
    {
        return $this->belongsTo(ModelKatalog::class, 'id_model');
    }
}
