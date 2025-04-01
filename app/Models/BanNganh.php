<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BanNganh extends Model
{
    use HasFactory;

    protected $table = 'ban_nganh';

    protected $fillable = [
        'ten',
        'loai',
        'mo_ta',
        'truong_ban_id',
    ];

    public function truongBan()
    {
        return $this->belongsTo(TinHuu::class, 'truong_ban_id');
    }

    public function tinHuuS()
    {
        return $this->belongsToMany(TinHuu::class, 'tin_huu_ban_nganh', 'ban_nganh_id', 'tin_huu_id');
    }

    public function lichBuoiNhoms()
    {
        return $this->hasMany(LichBuoiNhom::class, 'ban_nganh_id');
    }

    public function giaoDichTaiChinhs()
    {
        return $this->hasMany(GiaoDichTaiChinh::class, 'ban_nganh_id');
    }

    public function thietBis()
    {
        return $this->hasMany(ThietBi::class, 'id_ban');
    }

    public function thamViengs()
    {
        return $this->hasMany(ThamVieng::class, 'id_ban');
    }
}