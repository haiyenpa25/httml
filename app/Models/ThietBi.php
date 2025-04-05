<?php

namespace App\Models;

<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
>>>>>>> ec1a0f61c7ea600ec569639c73f25435caec3111
use Illuminate\Database\Eloquent\Model;

class ThietBi extends Model
{
<<<<<<< HEAD
    //
}
=======
    use HasFactory;

    protected $table = 'thiet_bi';

    protected $fillable = [
        'ten',
        'loai',
        'tinh_trang',
        'ngay_mua',
        'nguoi_quan_ly_id',
        'id_ban',
        'vi_tri',
        'mo_ta',
    ];

    public function nguoiQuanLy()
    {
        return $this->belongsTo(TinHuu::class, 'nguoi_quan_ly_id');
    }

    public function banNganh()
    {
        return $this->belongsTo(BanNganh::class, 'id_ban');
    }

    public function lichSuBaoTris()
    {
        return $this->hasMany(LichSuBaoTri::class, 'thiet_bi_id');
    }
}
>>>>>>> ec1a0f61c7ea600ec569639c73f25435caec3111
