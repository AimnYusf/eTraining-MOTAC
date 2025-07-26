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

    public function eproPermohonan()
    {
        return $this->hasMany(EproPermohonan::class, 'per_status', 'stp_id');
    }

    public function eproIsytihar()
    {
        return $this->hasMany(EproIsytihar::class, 'isy_status', 'stp_id');
    }
}
