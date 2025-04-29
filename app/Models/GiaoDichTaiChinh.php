<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiaoDichTaiChinh extends Model
{
    protected $table = 'giao_dich_tai_chinh';

    protected $fillable = [
        'loai',
        'so_tien',
        'mo_ta',
        'ngay_giao_dich',
        'ban_nganh_id',
        'buoi_nhom_id'  // Thêm cột mới
    ];

    // Quan hệ với Buổi Nhóm
    public function buoiNhom()
    {
        return $this->belongsTo(BuoiNhom::class, 'buoi_nhom_id');
    }

    // Quan hệ với Ban Ngành
    public function banNganh()
    {
        return $this->belongsTo(BanNganh::class, 'ban_nganh_id');
    }
}
