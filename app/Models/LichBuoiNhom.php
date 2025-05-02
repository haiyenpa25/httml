<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LichBuoiNhom extends Model
{
    use HasFactory;

    protected $table = 'buoi_nhom_lich';

    protected $fillable = [
        'ten',
        'id_buoi_nhom_loai', // cập nhật tên mới thay vì 'loai'
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

    public function loai()
    {
        return $this->belongsTo(BuoiNhomLoai::class, 'id_buoi_nhom_loai');
    }
}
