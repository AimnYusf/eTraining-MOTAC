<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EproStatus extends Model
{
    protected $table = 'epro_status';
    protected $primaryKey = 'stp_id';
    protected $fillable = [
        'stp_ketring',
        'stp_ketpenu'
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
