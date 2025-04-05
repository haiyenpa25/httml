<?php

namespace App\Models;

<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
>>>>>>> ec1a0f61c7ea600ec569639c73f25435caec3111
use Illuminate\Database\Eloquent\Model;

class HoGiaDinh extends Model
{
<<<<<<< HEAD
    //
}
=======
    use HasFactory;

    protected $table = 'ho_gia_dinh';

    protected $fillable = [
        'so_ho',
        'dia_chi',
    ];

    public function tinHuuS()
    {
        return $this->hasMany(TinHuu::class, 'ho_gia_dinh_id');
    }
}
>>>>>>> ec1a0f61c7ea600ec569639c73f25435caec3111
