<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LichSuThaoTac extends Model
{
    use HasFactory;

    protected $table = 'lich_su_thao_tac';

    protected $fillable = [
        'nguoi_dung_id',
        'hanh_dong',
        'bang_tac_dong',
        'id_tac_dong',
        'du_lieu_cu',
        'du_lieu_moi',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'du_lieu_cu' => 'array',
        'du_lieu_moi' => 'array'
    ];

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }
}