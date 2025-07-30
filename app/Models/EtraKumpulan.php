<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EtraKumpulan extends Model
{
    protected $table = 'etra_kumpulan';
    protected $primaryKey = 'kum_id';
    protected $fillable = [
        'kum_ketring',
        'kum_ketpenu',
    ];

    public function etraKursus()
    {
        return $this->hasMany(EtraKursus::class, 'kur_idkumpulan', 'kum_id');
    }

    public function etraPengguna()
    {
        return $this->hasMany(EtraPengguna::class, 'pen_idkumpulan', 'kum_id');
    }
}
