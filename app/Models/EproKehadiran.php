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

    public function user()
    {
        return $this->belongsTo(User::class, 'keh_idusers');
    }

    public function eproKursus()
    {
        return $this->belongsTo(EproKursus::class, 'keh_id', 'kur_id');
    }
}
