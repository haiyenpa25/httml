<?php

namespace App\Models;

<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
>>>>>>> ec1a0f61c7ea600ec569639c73f25435caec3111
use Illuminate\Database\Eloquent\Model;

class ThamVieng extends Model
{
<<<<<<< HEAD
    //
}
=======
    use HasFactory;

    protected $table = 'tham_vieng';

    protected $fillable = [
        'tin_huu_id',
        'than_huu_id',
        'nguoi_tham_id',
        'id_ban',
        'ngay_tham',
        'noi_dung',
        'ket_qua',
        'trang_thai',
    ];

    public function tinHuu()
    {
        return $this->belongsTo(TinHuu::class, 'tin_huu_id');
    }

    public function thanHuu()
    {
        return $this->belongsTo(ThanHuu::class, 'than_huu_id');
    }

    public function nguoiTham()
    {
        return $this->belongsTo(TinHuu::class, 'nguoi_tham_id');
    }

    public function banNganh()
    {
        return $this->belongsTo(BanNganh::class, 'id_ban');
    }
}
>>>>>>> ec1a0f61c7ea600ec569639c73f25435caec3111
