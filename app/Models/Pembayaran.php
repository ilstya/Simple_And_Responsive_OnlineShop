<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{

    protected $primaryKey = 'id_pembayaran';

    public $timestamps = false; 

    protected $fillable = [
        'id_pesanan',
        'Metode_pembayaran',
        'Bukti_pembayaran',
        'Status_pembayaran',
        'Tanggal_pembayaran',
    ];

    /**
     * Relasi ke Pesanan
     */
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan');
    }
}
