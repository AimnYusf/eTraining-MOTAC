<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EtraPermohonan extends Model
{
    protected $table = 'etra_permohonan';

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

    public function etraKursus()
    {
        return $this->belongsTo(EtraKursus::class, 'per_idkursus', 'kur_id');
    }

    public function etraStatus()
    {
        return $this->belongsTo(EtraStatus::class, 'per_status', 'stp_id');
    }
}
