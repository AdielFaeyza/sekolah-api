<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'guru';

    protected $fillable = [
        'nip',
        'nama',
        'tempat_lahir',
        'tgl_lahir',
        'gender',
        'phone_number',
        'email',
        'alamat',
        'pendidikan'
    ];

    protected $dates = ['tgl_lahir'];

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'guru_id');
    }
}