<?php

namespace App\Models;

<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
>>>>>>> ec1a0f61c7ea600ec569639c73f25435caec3111
use Illuminate\Database\Eloquent\Model;

class TaiLieu extends Model
{
<<<<<<< HEAD
    //
}
=======
    use HasFactory;

    protected $table = 'tai_lieu';

    protected $fillable = [
        'tieu_de',
        'duong_dan_tai_lieu',
        'danh_muc',
        'nguoi_tai_len_id',
    ];

    public function nguoiTaiLen()
    {
        return $this->belongsTo(TinHuu::class, 'nguoi_tai_len_id');
    }
}
>>>>>>> ec1a0f61c7ea600ec569639c73f25435caec3111
