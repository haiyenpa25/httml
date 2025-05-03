<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThongBaoTaiChinh extends Model
{
    use HasFactory;

    protected $table = 'thong_bao_tai_chinh';

    protected $fillable = [
        'tieu_de',
        'noi_dung',
        'loai',
        'nguoi_nhan_id',
        'reference_type',
        'reference_id',
        'da_doc',
        'ngay_doc'
    ];

    protected $casts = [
        'da_doc' => 'boolean',
        'ngay_doc' => 'datetime'
    ];

    public function nguoiNhan()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_nhan_id');
    }

    public function reference()
    {
        return $this->morphTo();
    }
}