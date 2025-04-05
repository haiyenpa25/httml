<?php

namespace App\Models;

<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
>>>>>>> ec1a0f61c7ea600ec569639c73f25435caec3111
use Illuminate\Database\Eloquent\Model;

class ThamGiaSuKien extends Model
{
<<<<<<< HEAD
    //
}
=======
    use HasFactory;

    protected $table = 'tham_gia_su_kien';

    protected $fillable = [
        'su_kien_id',
        'tin_huu_id',
        'trang_thai',
    ];

    public function suKien()
    {
        return $this->belongsTo(SuKien::class, 'su_kien_id');
    }

    public function tinHuu()
    {
        return $this->belongsTo(TinHuu::class, 'tin_huu_id');
    }
}
>>>>>>> ec1a0f61c7ea600ec569639c73f25435caec3111
