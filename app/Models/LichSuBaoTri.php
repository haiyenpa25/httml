<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LichSuBaoTri extends Model
{
    use HasFactory;

    protected $table = 'lich_su_bao_tri';

    protected $fillable = [
        'thiet_bi_id',
        'ngay_bao_tri',
        'chi_phi',
        'nguoi_thuc_hien',
        'mo_ta',
    ];

    public function thietBi()
    {
        return $this->belongsTo(ThietBi::class, 'thiet_bi_id');
    }
}