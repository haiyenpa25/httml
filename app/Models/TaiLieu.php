<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaiLieu extends Model
{
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
