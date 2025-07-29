<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EtraPeranan extends Model
{
    protected $table = 'etra_peranan';
    protected $primaryKey = 'prn_id';
    protected $fillable = [
        'prn_keterangan',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'role', 'prn_id');
    }
}
