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
        'isy_kos',
        'isy_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'isy_idusers');
    }

    public function eproStatus()
    {
        return $this->belongsTo(EproStatus::class, 'isy_status', 'stp_id');
    }
}
