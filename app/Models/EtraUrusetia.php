<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EtraUrusetia extends Model
{
    protected $table = 'etra_urusetia';
    protected $primaryKey = 'urus_id';
    protected $fillable = [
        'urus_nama',
        'urus_notel',
        'urus_emel'
    ];
}
