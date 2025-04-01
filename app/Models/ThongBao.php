<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThongBao extends Model
{
    use HasFactory;

    protected $table = 'thong_bao';

    protected $fillable = [
        'tieu_de',
        'noi_dung',
        'loai',
        'nguoi_nhan_id',
        'trang_thai',
        'ngay_gui',
    ];

    public function nguoiNhan()
    {
        return $this->belongsTo(TinHuu::class, 'nguoi_nhan_id');
    }
}