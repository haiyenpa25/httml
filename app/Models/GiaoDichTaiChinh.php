<?php

namespace App\Models;

<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
>>>>>>> ec1a0f61c7ea600ec569639c73f25435caec3111
use Illuminate\Database\Eloquent\Model;

class GiaoDichTaiChinh extends Model
{
<<<<<<< HEAD
    //
}
=======
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
>>>>>>> ec1a0f61c7ea600ec569639c73f25435caec3111
