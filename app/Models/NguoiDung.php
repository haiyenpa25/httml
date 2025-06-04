<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

class NguoiDung extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $table = 'nguoi_dung';
    protected $fillable = [
        'tin_huu_id',
        'email',
        'mat_khau',
        'vai_tro',
        'default_url',
    ];

    protected $hidden = [
        'mat_khau',
        'remember_token',
    ];

    public function tinHuu()
    {
        return $this->belongsTo(TinHuu::class, 'tin_huu_id');
    }

    public function getAuthPassword()
    {
        return $this->mat_khau;
    }

    public function thongBaoDaGui()
    {
        return $this->hasMany(ThongBao::class, 'nguoi_gui_id');
    }

    public function thongBaoDaNhan()
    {
        return $this->hasMany(ThongBao::class, 'nguoi_nhan_id');
    }

    public function isAdmin()
    {
        return $this->hasRole('quan_tri');
    }

    public function isTruongBan()
    {
        return $this->hasRole('truong_ban');
    }

    public function cacBanNganh()
    {
        return $this->hasManyThrough(
            BanNganh::class,
            TinHuuBanNganh::class,
            'tin_huu_id',
            'id',
            'tin_huu_id',
            'ban_nganh_id'
        );
    }

    public function banNganhLamTruongBan()
    {
        return BanNganh::where('truong_ban_id', $this->tin_huu_id)->get();
    }

    public function banNganhs()
    {
        return $this->tinHuu ? $this->tinHuu->banNganhs : collect();
    }

    public function getBanNganhIds()
    {
        if (!$this->tinHuu) {
            return [];
        }
        return $this->tinHuu->banNganhs()->pluck('ban_nganh_id')->toArray();
    }

    public function hasPermission($permission, $banNganhId = null)
    {
        // Kiểm tra quyền bằng Spatie Permission
        return $this->hasPermissionTo($permission);
    }

    public function hasQuyen($quyen, $banNganhId = null)
    {
        // Tương thích với Spatie Permission
        return $this->hasPermissionTo($quyen);
    }
}
