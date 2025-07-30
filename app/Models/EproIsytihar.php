<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EproIsytihar extends Model
{
    protected $table = 'epro_isytihar';
    protected $primaryKey = 'isy_id';
    protected $fillable = [
        'isy_idusers',
        'isy_nama',
        'isy_tkhmula',
        'isy_nama',
        'isy_tkhtamat',
        'isy_jam',
        'isy_tempat',
        'isy_anjuran',
        'isy_status',
    ];

    public function etraPengguna()
    {
        return $this->belongsTo(EtraPengguna::class, 'isy_idusers', 'pen_idusers');
    }

    public function etraStatus()
    {
        return $this->belongsTo(EtraStatus::class, 'isy_status', 'stp_id');
    }
}
