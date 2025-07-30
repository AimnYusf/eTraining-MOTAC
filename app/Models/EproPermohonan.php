<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EproPermohonan extends Model
{
    protected $table = 'epro_permohonan';

    protected $primaryKey = 'per_id';

    protected $fillable = [
        'per_idusers',
        'per_idkursus',
        'per_tkhmohon',
        'per_tkhtindakan',
        'per_pengangkutan',
        'per_makanan',
        'per_status',
    ];

    public function etraPengguna()
    {
        return $this->belongsTo(EtraPengguna::class, 'per_idusers', 'pen_idusers');
    }

    public function eproKursus()
    {
        return $this->belongsTo(EproKursus::class, 'per_idkursus', 'kur_id');
    }

    public function etraStatus()
    {
        return $this->belongsTo(EtraStatus::class, 'per_status', 'stp_id');
    }
}
