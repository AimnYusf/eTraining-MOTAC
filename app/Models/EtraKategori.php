<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EtraKategori extends Model
{
    protected $table = 'etra_kategori';
    protected $primaryKey = 'kat_id';
    protected $fillable = [
        'kat_keterangan',
    ];

    public function etraKursus()
    {
        return $this->hasMany(EtraKursus::class, 'kur_idkategori', 'kat_id');
    }
}
