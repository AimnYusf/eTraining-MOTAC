<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EtraPengguna extends Model
{
    protected $table = 'etra_pengguna';
    protected $primaryKey = 'pen_id';
    protected $fillable = [
        'pen_idusers',
        'pen_nama',
        'pen_nokp',
        'pen_jantina',
        'pen_emel',
        'pen_notel',
        'pen_nohp',
        'pen_jawatan',
        'pen_gred',
        'pen_idkumpulan',
        'pen_idjabatan',
        'pen_bahagianlain',
        'pen_idbahagian',
        'pen_ppnama',
        'pen_ppemel',
        'pen_ppgred'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'pen_idusers');
    }

    public function etraKumpulan()
    {
        return $this->belongsTo(EtraKumpulan::class, 'pen_idkumpulan', 'kum_id');
    }

    public function etraBahagian()
    {
        return $this->belongsTo(EtraBahagian::class, 'pen_idbahagian', 'bah_id');
    }

    public function etraJabatan()
    {
        return $this->belongsTo(EtraJabatan::class, 'pen_idjabatan', 'jab_id');
    }

    public function etraPermohonan()
    {
        return $this->hasMany(EtraPermohonan::class, 'per_idusers', 'pen_idusers');
    }

    public function etraKehadiran()
    {
        return $this->hasMany(EtraKehadiran::class, 'keh_idusers', 'pen_idusers');
    }

    public function etraIsytihar()
    {
        return $this->hasMany(EtraIsytihar::class, 'isy_idusers', 'pen_idusers');
    }
}
