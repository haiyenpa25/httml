<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiDinhKy extends Model
{
    use HasFactory;

    protected $table = 'chi_dinh_ky';

    protected $fillable = [
        'ten',
        'mo_ta',
        'so_tien',
        'quy_tai_chinh_id',
        'tan_suat',
        'ngay_thanh_toan',
        'thang_thanh_toan',
        'ngay_bat_dau',
        'ngay_ket_thuc',
        'nguoi_nhan',
        'thong_tin_thanh_toan',
        'tu_dong_tao',
        'nhac_truoc_ngay',
        'trang_thai'
    ];

    protected $casts = [
        'ngay_bat_dau' => 'date',
        'ngay_ket_thuc' => 'date',
        'so_tien' => 'decimal:2',
        'tu_dong_tao' => 'boolean'
    ];

    public function quyTaiChinh()
    {
        return $this->belongsTo(QuyTaiChinh::class, 'quy_tai_chinh_id');
    }

    public function giaoDich()
    {
        return $this->hasMany(GiaoDichTaiChinh::class, 'chi_dinh_ky_id');
    }
}