<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeHoach extends Model
{
    use HasFactory;

    protected $table = 'ke_hoach';

    protected $fillable = [
        'ban_nganh_id',
        'hoat_dong',
        'thoi_gian',
        'nguoi_phu_trach_id',
        'ghi_chu',
        'thang',
        'nam',
        'trang_thai',
    ];

    protected $casts = [
        'thang' => 'integer',
        'nam' => 'integer',
    ];

    public function banNganh()
    {
        return $this->belongsTo(BanNganh::class, 'ban_nganh_id');
    }

    public function nguoiPhuTrach()
    {
        return $this->belongsTo(TinHuu::class, 'nguoi_phu_trach_id');
    }
}
