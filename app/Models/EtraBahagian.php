<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EtraBahagian extends Model
{
    protected $table = 'etra_bahagian';
    protected $primaryKey = 'bah_id';
    protected $fillable = [
        'bah_ketring',
        'bah_ketpenu',
    ];

    public function etraPengguna()
    {
        return $this->hasMany(EtraPengguna::class, 'pen_idbahagian', 'bah_id');
    }
}
