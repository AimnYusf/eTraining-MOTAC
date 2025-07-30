<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EtraTempat extends Model
{
    protected $table = 'etra_tempat';
    protected $primaryKey = 'tem_id';
    protected $fillable = [
        'tem_keterangan',
        'tem_alamat',
        'tem_gmaps'
    ];

    public function etraKursus()
    {
        return $this->hasMany(EtraKursus::class, 'kur_idtempat', 'tem_id');
    }
}
