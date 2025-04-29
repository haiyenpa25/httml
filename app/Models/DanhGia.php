<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhGia extends Model
{
    use HasFactory;

    protected $table = 'danh_gia';

    protected $fillable = [
        'ban_nganh_id',
        'loai',
        'noi_dung',
        'thang',
        'nam',
        'nguoi_danh_gia_id',
    ];

    protected $casts = [
        'thang' => 'integer',
        'nam' => 'integer',
    ];

    public function banNganh()
    {
        return $this->belongsTo(BanNganh::class, 'ban_nganh_id');
    }

    public function nguoiDanhGia()
    {
        return $this->belongsTo(TinHuu::class, 'nguoi_danh_gia_id');
    }
}
