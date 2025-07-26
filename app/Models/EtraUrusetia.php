<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EtraUrusetia extends Model
{
    protected $table = 'etra_urusetia';
    protected $primaryKey = 'pic_id';
    protected $fillable = [
        'pic_nama',
        'pic_emel',
        'pic_notel'
    ];
}
