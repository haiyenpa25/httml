<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoGiaDinh extends Model
{
    use HasFactory;

    protected $table = 'ho_gia_dinh';

    protected $fillable = [
        'so_ho',
        'dia_chi',
    ];

    public function tinHuuS()
    {
        return $this->hasMany(TinHuu::class, 'ho_gia_dinh_id');
    }
}
