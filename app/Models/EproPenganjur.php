<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EproPenganjur extends Model
{
    protected $table = 'epro_penganjur';
    protected $primaryKey = 'pjr_id';
    protected $fillable = [
        'pjr_keterangan',
    ];

    public function eproKursus()
    {
        return $this->hasMany(EproKursus::class, 'kur_idpenganjur', 'pjr_id');
    }
}