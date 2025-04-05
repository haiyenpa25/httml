<?php

namespace App\Models;

<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
>>>>>>> ec1a0f61c7ea600ec569639c73f25435caec3111
use Illuminate\Database\Eloquent\Model;

class LichBuoiNhom extends Model
{
<<<<<<< HEAD
    //
}
=======
    use HasFactory;

    protected $table = 'lich_buoi_nhom';

    protected $fillable = [
        'ten',
        'loai',
        'ban_nganh_id',
        'thu',
        'gio_bat_dau',
        'gio_ket_thuc',
        'tan_suat',
        'dia_diem',
        'mo_ta',
    ];

    public function banNganh()
    {
        return $this->belongsTo(BanNganh::class, 'ban_nganh_id');
    }

    public function buoiNhoms()
    {
        return $this->hasMany(BuoiNhom::class, 'lich_buoi_nhom_id');
    }
}
>>>>>>> ec1a0f61c7ea600ec569639c73f25435caec3111
