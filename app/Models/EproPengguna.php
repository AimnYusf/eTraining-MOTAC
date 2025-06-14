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
        'pen_jawatan',
        'pen_gred',
        'pen_idkumpulan',
        'pen_idjabatan',
        'pen_idbahagian',
        'pen_jabatanlain',
        'pen_emel',
        'pen_notel',
        'pen_nofaks',
        'pen_nohp',
        'pen_kjnama',
        'pen_kjgelaran',
        'pen_kjemel',
        'pen_ppnama',
        'pen_ppemel'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'pen_idusers');
    }

    // public function eproKumpulan()
    // {
    //     return $this->belongsTo(EproKumpulan::class, 'pen_idkumpulan', 'kum_id');
    // }

    // public function eproBahagian()
    // {
    //     return $this->belongsTo(EproBahagian::class, 'pen_idbahagian', 'bah_id');
    // }

    // public function eproJabatan()
    // {
    //     return $this->belongsTo(EproJabatan::class, 'pen_idjabatan', 'jab_id');
    // }
}
