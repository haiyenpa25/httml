<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BuoiNhomLoai extends Model
{
    use HasFactory;

    protected $table = 'buoi_nhom_loai';

    protected $fillable = [
        'ten_loai',
    ];
    public function lichBuoiNhoms(): HasMany
    {
        return $this->hasMany(BuoiNhomLich::class, 'buoi_nhom_loai_id');
    }
    public function buoiNhomLich()
    {
        return $this->hasMany(BuoiNhomLich::class, 'id_buoi_nhom_loai');
    }
}
