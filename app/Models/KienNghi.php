<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KienNghi extends Model
{
    use HasFactory;

    protected $table = 'kien_nghi';

    protected $fillable = [
        'ban_nganh_id',
        'tieu_de',
        'noi_dung',
        'nguoi_de_xuat_id',
        'thang',
        'nam',
        'trang_thai',
        'phan_hoi',
    ];

    protected $casts = [
        'thang' => 'integer',
        'nam' => 'integer',
    ];

    public function banNganh()
    {
        return $this->belongsTo(BanNganh::class, 'ban_nganh_id');
    }

    public function nguoiDeXuat()
    {
        return $this->belongsTo(TinHuu::class, 'nguoi_de_xuat_id');
    }
}
