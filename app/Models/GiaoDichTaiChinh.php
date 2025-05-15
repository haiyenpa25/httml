<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiaoDichTaiChinh extends Model
{
    use HasFactory;

    protected $table = 'giao_dich_tai_chinh';

    protected $fillable = [
        'quy_tai_chinh_id',
        'loai',
        'hinh_thuc',
        'so_tien',
        'mo_ta',
        'ngay_giao_dich',
        'phuong_thuc',
        'ma_giao_dich',
        'nguoi_nhan',
        'nguoi_duyet_id',
        'ngay_duyet',
        'trang_thai',
        'ly_do_tu_choi',
        'ban_nganh_id',
        'buoi_nhom_id',
        'ban_nganh_id_goi',
        'chi_dinh_ky_id',
        'duong_dan_hoa_don'
    ];

    protected $casts = [
        'ngay_giao_dich' => 'date',
        'ngay_duyet' => 'datetime',
        'so_tien' => 'decimal:2'
    ];

    public function quyTaiChinh()
    {
        return $this->belongsTo(QuyTaiChinh::class, 'quy_tai_chinh_id');
    }

    public function banNganh()
    {
        return $this->belongsTo(BanNganh::class, 'ban_nganh_id');
    }

    public function buoiNhom()
    {
        return $this->belongsTo(BuoiNhom::class, 'buoi_nhom_id');
    }

    public function chiDinhKy()
    {
        return $this->belongsTo(ChiDinhKy::class, 'chi_dinh_ky_id');
    }

    public function nguoiDuyet()
    {
        return $this->belongsTo(TinHuu::class, 'nguoi_duyet_id');
    }
}
