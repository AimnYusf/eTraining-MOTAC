<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EproKursus extends Model
{
    protected $table = 'epro_kursus';
    protected $primaryKey = 'kur_id';
    protected $fillable = [
        'kur_nama',
        'kur_objektif',
        'kur_idkategori',
        'kur_idpenganjur',
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
        'kur_poster',
        'kur_status',
    ];

    public function eproKategori()
    {
        return $this->belongsTo(EproKategori::class, 'kur_idkategori', 'kat_id');
    }

    public function eproPenganjur()
    {
        return $this->belongsTo(EproPenganjur::class, 'kur_idpenganjur', 'pjr_id');
    }

    public function eproTempat()
    {
        return $this->belongsTo(EproTempat::class, 'kur_idtempat', 'tem_id');
    }
    public function eproKumpulan()
    {
        return $this->belongsTo(EproKumpulan::class, 'kur_idkumpulan', 'kum_id');
    }

    public function eproPermohonan()
    {
        return $this->hasMany(EproPermohonan::class, 'per_idkursus', 'kur_id');
    }

    public function eproKehadiran()
    {
        return $this->hasMany(EproKehadiran::class, 'keh_idkursus', 'kur_id');
    }
}
