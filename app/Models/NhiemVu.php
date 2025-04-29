<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NhiemVu extends Model
{
    use HasFactory;

    protected $table = 'nhiem_vu'; // Đảm bảo đúng tên bảng

    protected $fillable = [
        'ten_nhiem_vu',
        'id_ban_nganh',
        'mo_ta'
    ];

    public function banNganh()
    {
        return $this->belongsTo(BanNganh::class, 'id_ban_nganh');
    }
}
