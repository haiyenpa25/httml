<?php

namespace App\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Model;

class NguoiDung extends Model
{
    //
}
=======
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
>>>>>>> ec1a0f61c7ea600ec569639c73f25435caec3111
