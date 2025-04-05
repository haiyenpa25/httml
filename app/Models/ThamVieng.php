<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThamVieng extends Model
{
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
