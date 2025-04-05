<?php

namespace App\Models;

<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
>>>>>>> ec1a0f61c7ea600ec569639c73f25435caec3111
use Illuminate\Database\Eloquent\Model;

class ThongBao extends Model
{
<<<<<<< HEAD
    //
}
=======
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
>>>>>>> ec1a0f61c7ea600ec569639c73f25435caec3111
