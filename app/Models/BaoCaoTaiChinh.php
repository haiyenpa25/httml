<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaoCaoTaiChinh extends Model
{
    use HasFactory;

    protected $table = 'bao_cao_tai_chinh';

    protected $fillable = [
        'tieu_de',
        'loai_bao_cao',
        'quy_tai_chinh_id',
        'tu_ngay',
        'den_ngay',
        'tong_thu',
        'tong_chi',
        'so_du_dau_ky',
        'so_du_cuoi_ky',
        'noi_dung_bao_cao',
        'duong_dan_file',
        'nguoi_tao_id',
        'cong_khai'
    ];

    protected $casts = [
        'tu_ngay' => 'date',
        'den_ngay' => 'date',
        'tong_thu' => 'decimal:2',
        'tong_chi' => 'decimal:2',
        'so_du_dau_ky' => 'decimal:2',
        'so_du_cuoi_ky' => 'decimal:2',
        'noi_dung_bao_cao' => 'array',
        'cong_khai' => 'boolean'
    ];

    public function quyTaiChinh()
    {
        return $this->belongsTo(QuyTaiChinh::class, 'quy_tai_chinh_id');
    }

    public function nguoiTao()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_tao_id');
    }
}
