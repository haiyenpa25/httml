<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TinHuuTrinhDo;


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
        'ngay_sinh_hoat_voi_hoi_thanh',
        'ngay_nhan_bap_tem',
        'hoan_thanh_bap_tem',
        'noi_xuat_than',
        'cccd',
        'ma_dinh_danh_tinh',
        'ngay_tham_vieng_gan_nhat',
        'so_lan_vang_lien_tiep',
        'ho_gia_dinh_id',
        'moi_quan_he',
        'anh_dai_dien',
        'gioi_tinh',
        'tinh_trang_hon_nhan',
    ];

    protected $casts = [
        'loai_tin_huu' => 'string',
        'gioi_tinh' => 'string',
        'tinh_trang_hon_nhan' => 'string',
        'moi_quan_he' => 'string',
        'hoan_thanh_bap_tem' => 'boolean',
        'ngay_sinh' => 'date',
        'ngay_tin_chua' => 'date',
        'ngay_sinh_hoat_voi_hoi_thanh' => 'date',
        'ngay_nhan_bap_tem' => 'date',
        'ngay_tham_vieng_gan_nhat' => 'date',
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

    /**
     * Lấy các ban ngành mà tín hữu làm trưởng ban.
     */
    public function banNganhLamTruongBan()
    {
        return $this->hasMany(BanNganh::class, 'truong_ban_id');
    }

    public function quanLyQuy()
    {
        return $this->hasMany(QuyTaiChinh::class, 'nguoi_quan_ly_id');
    }

    public function nguoi_dung()
    {
        return $this->hasOne(NguoiDung::class, 'tin_huu_id');
    }

    public function thiet_bis()
    {
        return $this->hasMany(ThietBi::class, 'nguoi_quan_ly_id');
    }

    public function than_huu_gioi_thieu()
    {
        return $this->hasMany(ThanHuu::class, 'tin_huu_gioi_thieu_id');
    }

    public function tham_viengs()
    {
        return $this->hasMany(ThamVieng::class, 'nguoi_tham_id');
    }

    public function trinh_do_kinh_thanh()
    {
        return $this->hasMany(TinHuuTrinhDo::class, 'tin_huu_id');
    }

    public function ban_nganh_lam_truong_ban()
    {
        return $this->hasMany(BanNganh::class, 'truong_ban_id');
    }

    public function quan_ly_quy()
    {
        return $this->hasMany(QuyTaiChinh::class, 'nguoi_quan_ly_id');
    }
    public function tinHuu()
    {
        return $this->belongsTo(TinHuu::class, 'tin_huu_id', 'id');
    }

    public function banNganh()
    {
        return $this->belongsTo(BanNganh::class, 'ban_nganh_id', 'id');
    }

    public function banNganhTinHuu()
    {
        return $this->hasMany(TinHuuBanNganh::class, 'tin_huu_id', 'id');
    }
}
