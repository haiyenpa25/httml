<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NguoiDung extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'nguoi_dung';
    protected $fillable = [
        'tin_huu_id',
        'email',
        'mat_khau',
        'vai_tro',
    ];

    protected $hidden = [
        'mat_khau',
        'remember_token',
    ];

    protected $casts = [
        'mat_khau' => 'hashed',
    ];

    public function tinHuu()
    {
        return $this->belongsTo(TinHuu::class, 'tin_huu_id');
    }
    public function getAuthPassword()
    {
        return $this->MatKhau; // Trả về 'MatKhau' thay vì 'mat_khau'
    }
}