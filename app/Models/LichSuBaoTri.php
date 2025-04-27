<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LichSuBaoTri extends Model
{
    use HasFactory;

    /**
     * Tên bảng trong cơ sở dữ liệu
     *
     * @var string
     */
    protected $table = 'lich_su_bao_tri';

    /**
     * Các trường có thể gán giá trị hàng loạt
     *
     * @var array
     */
    protected $fillable = [
        'thiet_bi_id',
        'ngay_bao_tri',
        'chi_phi',
        'nguoi_thuc_hien',
        'mo_ta'
    ];

    /**
     * Các thuộc tính cần cast
     *
     * @var array
     */
    protected $casts = [
        'ngay_bao_tri' => 'date',
        'chi_phi' => 'decimal:2'
    ];

    /**
     * Lấy thiết bị được bảo trì
     */
    public function thietBi()
    {
        return $this->belongsTo(ThietBi::class, 'thiet_bi_id');
    }
}