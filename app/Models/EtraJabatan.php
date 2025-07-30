<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EtraJabatan extends Model
{
    protected $table = 'etra_jabatan';
    protected $primaryKey = 'jab_id';
    protected $fillable = [
        'jab_ketring',
        'jab_ketpenu',
    ];

    public function etraPengguna()
    {
        return $this->hasMany(EtraPengguna::class, 'pen_idjabatan', 'jab_id');
    }
}
