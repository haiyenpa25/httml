<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NguoiDungPhanQuyen extends Model
{
    use HasFactory;

    protected $table = 'nguoi_dung_phan_quyen';
    protected $fillable = ['nguoi_dung_id', 'quyen', 'id_ban_nganh', 'default_url'];

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }

    public function banNganh()
    {
        return $this->belongsTo(BanNganh::class, 'id_ban_nganh');
    }
}
