<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ModelKatalog;

class ModelKatalog extends Model
{
    protected $table = 'models';

    protected $primaryKey = 'id_model';

    public $timestamps = false;

    protected $fillable = [
        'Nama_model',
        'harga',
        'Foto_model',
        'deskripsi',
    ];

    
    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class, 'id_model');
    }
}
