<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LichBuoiNhom extends Model
{
    use HasFactory;

    protected $table = 'lich_buoi_nhom';

    protected $fillable = [
        'ten',
        'loai',
        'ban_nganh_id',
        'thu',
        'gio_bat_dau',
        'gio_ket_thuc',
        'tan_suat',
        'dia_diem',
        'mo_ta',
    ];

    public function banNganh()
    {
        return $this->belongsTo(BanNganh::class, 'ban_nganh_id');
    }

    public function buoiNhoms()
    {
        return $this->hasMany(BuoiNhom::class, 'lich_buoi_nhom_id');
    }
}
