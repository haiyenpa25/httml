<?php

namespace App\Models;

<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
>>>>>>> ec1a0f61c7ea600ec569639c73f25435caec3111
use Illuminate\Database\Eloquent\Model;

class SuKien extends Model
{
<<<<<<< HEAD
    //
}
=======
    use HasFactory;

    protected $table = 'su_kien';

    protected $fillable = [
        'ten',
        'ngay_gio',
        'dia_diem',
        'mo_ta',
    ];

    public function thamGiaSuKiens()
    {
        return $this->hasMany(ThamGiaSuKien::class, 'su_kien_id');
    }
}
>>>>>>> ec1a0f61c7ea600ec569639c73f25435caec3111
