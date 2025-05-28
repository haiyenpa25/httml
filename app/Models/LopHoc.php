<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LopHoc extends Model
{
    protected $table = 'lop_hoc';

    protected $fillable = [
        'ten_lop',
        'loai_lop',
        'thoi_gian_bat_dau',
        'thoi_gian_ket_thuc',
        'tan_suat',
        'dia_diem',
        'mo_ta',
    ];

    protected $casts = [
        'loai_lop' => 'string',
        'tan_suat' => 'string',
        'thoi_gian_bat_dau' => 'datetime',
        'thoi_gian_ket_thuc' => 'datetime',
    ];

    public function tinHuus()
    {
        return $this->belongsToMany(TinHuu::class, 'lop_hoc_tin_huu')
            ->withPivot('vai_tro')
            ->withTimestamps();
    }

    public function giaoViens()
    {
        return $this->tinHuus()->wherePivot('vai_tro', 'giao_vien');
    }

    public function hocViens()
    {
        return $this->tinHuus()->wherePivot('vai_tro', 'hoc_vien');
    }
}
