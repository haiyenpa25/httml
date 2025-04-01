<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TinHuu extends Model
{
    use HasFactory;

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
    ];

    public function hoGiaDinh()
    {
        return $this->belongsTo(HoGiaDinh::class, 'ho_gia_dinh_id');
    }

    public function banNganhs()
    {
        return $this->belongsToMany(BanNganh::class, 'tin_huu_ban_nganh', 'tin_huu_id', 'ban_nganh_id');
    }

    public function nguoiDung()
    {
        return $this->hasOne(NguoiDung::class, 'tin_huu_id');
    }

    public function thietBis()
    {
        return $this->hasMany(ThietBi::class, 'nguoi_quan_ly_id');
    }

    public function thanHuuGioiThieu()
    {
        return $this->hasMany(ThanHuu::class, 'tin_huu_gioi_thieu_id');
    }

    public function thamViengs()
    {
        return $this->hasMany(ThamVieng::class, 'nguoi_tham_id');
    }
}