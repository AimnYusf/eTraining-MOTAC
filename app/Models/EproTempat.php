<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EproTempat extends Model
{
    protected $table = 'epro_tempat';
    protected $primaryKey = 'tem_id';
    protected $fillable = [
        'tem_keterangan',
        'tem_alamat',
        'tem_gmaps'
    ];

    public function eproKursus()
    {
        return $this->hasMany(EproKursus::class, 'kur_idtempat', 'tem_id');
    }
}
