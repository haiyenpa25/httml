<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TinHuu extends Model
{
    use HasFactory;

    // QUAN TRỌNG: Đảm bảo tên bảng này khớp 100% với tên trong CSDL của bạn
    protected $table = 'tin_huu';

    protected $fillable = [
        'ho_ten',
        'ngay_sinh',
        'dia_chi',
        'vi_do',
        'kinh_do',
        'so_dien_thoai',
        'loai_tin_huu',
        'ngay_tin_chua',
        'ngay_tham_vieng_gan_nhat',
        'so_lan_vang_lien_tiep',
        'ho_gia_dinh_id',
        'moi_quan_he',
        'anh_dai_dien',
        'gioi_tinh',
        'tinh_trang_hon_nhan',
        'trang_thai', // Thêm cột trạng thái nếu có (ví dụ: 1 = active, 0 = inactive)
    ];

    // Các thuộc tính cần ép kiểu (ví dụ: date, boolean)
    protected $casts = [
        'ngay_sinh' => 'date',
        'ngay_tin_chua' => 'date',
        'ngay_tham_vieng_gan_nhat' => 'datetime',
        'trang_thai' => 'boolean', // Nếu dùng trạng thái
    ];

    /**
     * Quan hệ với Hộ gia đình
     */
    public function hoGiaDinh()
    {
        return $this->belongsTo(HoGiaDinh::class, 'ho_gia_dinh_id');
    }

    /**
     * Quan hệ Nhiều-Nhiều với Ban Ngành thông qua bảng tin_huu_ban_nganh
     */
    public function banNganhs()
    {
        return $this->belongsToMany(
            BanNganh::class,      // Model đích
            'tin_huu_ban_nganh', // Tên bảng trung gian (pivot table)
            'tin_huu_id',       // Khóa ngoại trên bảng pivot trỏ về model hiện tại (TinHuu)
            'ban_nganh_id'      // Khóa ngoại trên bảng pivot trỏ về model đích (BanNganh)
        )
            // ->using(TinHuuBanNganh::class) // Chỉ định model pivot nếu cần truy cập các thuộc tính riêng của pivot
            ->withPivot('chuc_vu') // Lấy thêm cột 'chuc_vu' từ bảng pivot nếu cần
            ->withTimestamps();      // Nếu bảng pivot có timestamps (created_at, updated_at)
    }

    /**
     * Quan hệ Một-Một với Người dùng (nếu có)
     */
    public function nguoiDung()
    {
        return $this->hasOne(NguoiDung::class, 'tin_huu_id');
    }

    /**
     * Quan hệ Một-Nhiều với Thiết bị (nếu có)
     */
    public function thietBis()
    {
        return $this->hasMany(ThietBi::class, 'nguoi_quan_ly_id');
    }

    /**
     * Quan hệ Một-Nhiều với Thân hữu (nếu có)
     */
    public function thanHuuGioiThieu()
    {
        return $this->hasMany(ThanHuu::class, 'tin_huu_gioi_thieu_id');
    }

    /**
     * Quan hệ Một-Nhiều với Thăm viếng (nếu có)
     */
    public function thamViengs()
    {
        return $this->hasMany(ThamVieng::class, 'nguoi_tham_id');
    }

    // --- Scopes (Ví dụ) ---
    /**
     * Scope để lấy các tín hữu đang hoạt động.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        // Giả sử có cột 'trang_thai' (1 = active)
        return $query->where('trang_thai', 1);
    }
}