<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EproBahagian extends Model
{
    protected $table = 'epro_bahagian';
    protected $primaryKey = 'bah_id';
    protected $fillable = [
        'bah_ketring',
        'bah_ketpenu',
    ];

    public function eproPengguna()
    {
        return $this->hasMany(EproPengguna::class, 'pen_idbahagian', 'bah_id');
    }
}
