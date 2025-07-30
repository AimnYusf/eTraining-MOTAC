<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EproPengguna extends Model
{
    protected $table = 'epro_pengguna';
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

    public function eproJabatan()
    {
        return $this->belongsTo(EproJabatan::class, 'pen_idjabatan', 'jab_id');
    }

    public function eproPermohonan()
    {
        return $this->hasMany(EproPermohonan::class, 'per_idusers', 'pen_idusers');
    }

    public function eproKehadiran()
    {
        return $this->hasMany(EproKehadiran::class, 'keh_idusers', 'pen_idusers');
    }

    public function eproIsytihar()
    {
        return $this->hasMany(EproIsytihar::class, 'isy_idusers', 'pen_idusers');
    }
}
