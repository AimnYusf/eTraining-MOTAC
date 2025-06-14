<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EproJabatan extends Model
{
    protected $table = 'epro_jabatan';
    protected $primaryKey = 'jab_id';
    protected $fillable = [
        'jab_ketring',
        'jab_ketpenu',
    ];

    public function eproPengguna()
    {
        return $this->hasMany(EproPengguna::class, 'pen_idjabatan', 'jab_id');
    }
}
