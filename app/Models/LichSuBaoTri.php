<?php

namespace App\Models;

<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
>>>>>>> ec1a0f61c7ea600ec569639c73f25435caec3111
use Illuminate\Database\Eloquent\Model;

class LichSuBaoTri extends Model
{
<<<<<<< HEAD
    //
}
=======
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
>>>>>>> ec1a0f61c7ea600ec569639c73f25435caec3111
