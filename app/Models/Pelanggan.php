<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pelanggan extends Authenticatable
{
    use Notifiable;

    // guard default untuk pelanggan (web)
    protected $guard = 'web';

    // primary key migration
    protected $primaryKey = 'id_pelanggan';

    // tabel 'pelanggans' (bawaan Laravel)
    public $timestamps = true;

    protected $fillable = [
        'nama',
        'email',
        'alamat',
        'no_telepon',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // relasi: one to many satu pelanggan punya banyak pesanan
    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'id_pelanggan');
    }

    // auto‑hash password
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
