<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuoiNhom extends Model
{
    use HasFactory;

    protected $table = 'buoi_nhom';

    protected $fillable = [
        'lich_buoi_nhom_id',
        'ngay_dien_ra',
        'gio_bat_dau',
        'gio_ket_thuc',
        'dia_diem',
        'so_luong_tham_gia',
        'ghi_chu',
        'trang_thai',
    ];

    public function lichBuoiNhom()
    {
        return $this->belongsTo(LichBuoiNhom::class, 'lich_buoi_nhom_id');
    }

    public function chiTietThamGias()
    {
        return $this->hasMany(ChiTietThamGia::class, 'buoi_nhom_id');
    }
}