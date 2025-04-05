<?php

namespace App\Models;

<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
>>>>>>> ec1a0f61c7ea600ec569639c73f25435caec3111
use Illuminate\Database\Eloquent\Model;

class ChiTietThamGia extends Model
{
<<<<<<< HEAD
    //
}
=======
    use HasFactory;

    protected $table = 'chi_tiet_tham_gia';

    protected $fillable = [
        'buoi_nhom_id',
        'tin_huu_id',
        'trang_thai',
        'ghi_chu',
    ];

    public function buoiNhom()
    {
        return $this->belongsTo(BuoiNhom::class, 'buoi_nhom_id');
    }

    public function tinHuu()
    {
        return $this->belongsTo(TinHuu::class, 'tin_huu_id');
    }
}
>>>>>>> ec1a0f61c7ea600ec569639c73f25435caec3111
