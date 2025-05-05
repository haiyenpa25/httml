<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuyTaiChinh extends Model
{
    use HasFactory;

    protected $table = 'quy_tai_chinh';

    protected $fillable = [
        'ten_quy',
        'mo_ta',
        'so_du_hien_tai',
        'nguoi_quan_ly_id',
        'trang_thai'
    ];

    public function nguoiQuanLy()
    {
        return $this->belongsTo(TinHuu::class, 'nguoi_quan_ly_id');
    }

    public function giaoDich()
    {
        return $this->hasMany(GiaoDichTaiChinh::class, 'quy_tai_chinh_id');
    }

    public function chiDinhKy()
    {
        return $this->hasMany(ChiDinhKy::class, 'quy_tai_chinh_id');
    }

    public function baoCao()
    {
        return $this->hasMany(BaoCaoTaiChinh::class, 'quy_tai_chinh_id');
    }
}