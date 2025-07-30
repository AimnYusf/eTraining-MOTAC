<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EtraKursus extends Model
{
    protected $table = 'etra_kursus';
    protected $primaryKey = 'kur_id';

    protected $casts = [
        'kur_urusetia' => 'array',
    ];
    protected $fillable = [
        'kur_nama',
        'kur_objektif',
        'kur_idkategori',
        'kur_tkhmula',
        'kur_msamula',
        'kur_tkhtamat',
        'kur_msatamat',
        'kur_bilhari',
        'kur_idtempat',
        'kur_tkhbuka',
        'kur_tkhtutup',
        'kur_bilpeserta',
        'kur_idkumpulan',
        'kur_idpenganjur',
        'kur_urusetia',
        'kur_poster',
        'kur_status',
    ];

    public function etraKategori()
    {
        return $this->belongsTo(EtraKategori::class, 'kur_idkategori', 'kat_id');
    }

    public function etraPenganjur()
    {
        return $this->belongsTo(EtraPenganjur::class, 'kur_idpenganjur', 'pjr_id');
    }

    public function etraTempat()
    {
        return $this->belongsTo(EtraTempat::class, 'kur_idtempat', 'tem_id');
    }
    public function etraKumpulan()
    {
        return $this->belongsTo(EtraKumpulan::class, 'kur_idkumpulan', 'kum_id');
    }

    public function etraPermohonan()
    {
        return $this->hasMany(EtraPermohonan::class, 'per_idkursus', 'kur_id');
    }

    public function etraKehadiran()
    {
        return $this->hasMany(EtraKehadiran::class, 'keh_idkursus', 'kur_id');
    }
}
