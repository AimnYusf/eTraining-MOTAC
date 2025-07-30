<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EtraStatus extends Model
{
    protected $table = 'etra_status';
    protected $primaryKey = 'stp_id';
    protected $fillable = [
        'stp_keterangan'
    ];

    public function etraPermohonan()
    {
        return $this->hasMany(EtraPermohonan::class, 'per_status', 'stp_id');
    }

    public function etraIsytihar()
    {
        return $this->hasMany(EtraIsytihar::class, 'isy_status', 'stp_id');
    }
}
