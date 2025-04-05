<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiaoDichTaiChinh extends Model
{
    use HasFactory;

    protected $table = 'giao_dich_tai_chinh';

    protected $fillable = [
        'loai',
        'so_tien',
        'mo_ta',
        'ngay_giao_dich',
        'ban_nganh_id',
    ];

    public function banNganh()
    {
        return $this->belongsTo(BanNganh::class, 'ban_nganh_id');
    }
}
