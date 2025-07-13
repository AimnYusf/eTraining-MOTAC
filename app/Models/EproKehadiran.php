<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EproKehadiran extends Model
{
    protected $table = 'epro_kehadiran';
    protected $primaryKey = 'keh_id';
    protected $fillable = [
        'keh_idusers',
        'keh_idkursus',
        'keh_tkhmasuk',
    ];

    public function eproPengguna()
    {
        return $this->belongsTo(EproPengguna::class, 'keh_idusers', 'pen_idusers');
    }

    public function eproKursus()
    {
        return $this->belongsTo(EproKursus::class, 'keh_idkursus', 'kur_id');
    }
}
