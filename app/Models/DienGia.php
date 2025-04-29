<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DienGia extends Model
{
    use HasFactory;

    protected $table = 'dien_gia';

    protected $fillable = [
        'ho_ten',
        'chuc_danh',
        'hoi_thanh',
        'dia_chi',
        'so_dien_thoai',
    ];
}