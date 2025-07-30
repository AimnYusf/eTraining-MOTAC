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

    public function eproKursus()
    {
        return $this->hasMany(EproKursus::class, 'kur_idkumpulan', 'kum_id');
    }

    public function eproPengguna()
    {
        return $this->hasMany(EproPengguna::class, 'pen_idkumpulan', 'kum_id');
    }
}
