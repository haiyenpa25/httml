<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'chu_de',
        'kinh_thanh',
        'cau_goc',
        'so_luong_trung_lao',
        'so_luong_thanh_trang',
        'so_luong_thanh_nien',
        'so_luong_thieu_nhi_au',
        'so_luong_tin_huu_khac',
        'so_luong_tin_huu',
        'so_luong_than_huu',
        'so_nguoi_tin_chua',
        'id_to',
        'id_tin_huu_hdct',
        'id_tin_huu_do_kt',
        'dien_gia_id',
        'trang_thai',
        'ghi_chu',
        'ban_nganh_id', // Xóa nếu bảng không có cột này
    ];

    protected $casts = [
        'ngay_dien_ra' => 'date',
        'lich_buoi_nhom_id' => 'integer',
        'id_to' => 'integer',
        'id_tin_huu_hdct' => 'integer',
        'id_tin_huu_do_kt' => 'integer',
        'dien_gia_id' => 'integer',
        'ban_nganh_id' => 'integer', // Xóa nếu bảng không có cột này
        'so_luong_trung_lao' => 'integer',
        'so_luong_thanh_trang' => 'integer',
        'so_luong_thanh_nien' => 'integer',
        'so_luong_thieu_nhi_au' => 'integer',
        'so_luong_tin_huu_khac' => 'integer',
        'so_luong_tin_huu' => 'integer',
        'so_luong_than_huu' => 'integer',
        'so_nguoi_tin_chua' => 'integer',
        'trang_thai' => 'boolean',
    ];

    // --- Relationships ---
    public function lichBuoiNhom(): BelongsTo
    {
        return $this->belongsTo(BuoiNhomLich::class, 'lich_buoi_nhom_id');
    }

    public function to(): BelongsTo
    {
        return $this->belongsTo(BuoiNhomTo::class, 'id_to');
    }

    public function tinHuuHdct(): BelongsTo
    {
        return $this->belongsTo(TinHuu::class, 'id_tin_huu_hdct');
    }

    public function tinHuuDoKt(): BelongsTo
    {
        return $this->belongsTo(TinHuu::class, 'id_tin_huu_do_kt');
    }

    public function dienGia(): BelongsTo
    {
        return $this->belongsTo(DienGia::class, 'dien_gia_id');
    }

    public function banNganh(): BelongsTo
    {
        return $this->belongsTo(BanNganh::class, 'ban_nganh_id');
    }
    public function giaoDichTaiChinh()
    {
        return $this->hasOne(GiaoDichTaiChinh::class, 'buoi_nhom_id')
            ->where('loai', 'thu')
            ->where('ban_nganh_id', 1);
    }
}
