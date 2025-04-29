<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NguoiDung extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Tên bảng tương ứng với model.
     *
     * @var string
     */
    protected $table = 'nguoi_dung';
    protected $fillable = [
        'tin_huu_id',
        'email',
        'mat_khau',
        'vai_tro',
    ];

    protected $hidden = [
        'mat_khau',
        'remember_token',
    ];

    protected $casts = [
        'mat_khau' => 'hashed',
    ];

    public function tinHuu()
    {
        return $this->belongsTo(TinHuu::class, 'tin_huu_id');
    }
    public function getAuthPassword()
    {
        return $this->MatKhau; // Trả về 'MatKhau' thay vì 'mat_khau'
    }



    /**
     * Lấy các thông báo đã gửi.
     */
    public function thongBaoDaGui()
    {
        return $this->hasMany(ThongBao::class, 'nguoi_gui_id');
    }

    /**
     * Lấy các thông báo đã nhận.
     */
    public function thongBaoDaNhan()
    {
        return $this->hasMany(ThongBao::class, 'nguoi_nhan_id');
    }

    /**
     * Kiểm tra xem người dùng có phải là quản trị viên không.
     */
    public function isAdmin()
    {
        return $this->vai_tro === 'quan_tri';
    }

    /**
     * Kiểm tra xem người dùng có phải là trưởng ban không.
     */
    public function isTruongBan()
    {
        return $this->vai_tro === 'truong_ban';
    }

    /**
     * Lấy các ban ngành mà người dùng tham gia.
     */
    public function cacBanNganh()
    {
        return $this->hasManyThrough(
            BanNganh::class,
            TinHuuBanNganh::class,
            'tin_huu_id', // Khóa ngoại ở TinHuuBanNganh
            'id', // Khóa chính ở BanNganh
            'tin_huu_id', // Khóa chính ở NguoiDung
            'ban_nganh_id' // Khóa ngoại ở TinHuuBanNganh
        );
    }

    /**
     * Lấy các ban ngành mà người dùng làm trưởng ban.
     */
    public function banNganhLamTruongBan()
    {
        return BanNganh::where('truong_ban_id', $this->tin_huu_id)->get();
    }
}
