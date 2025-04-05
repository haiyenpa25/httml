<?php

namespace App\Models;

<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
>>>>>>> ec1a0f61c7ea600ec569639c73f25435caec3111
use Illuminate\Database\Eloquent\Model;

class ThanHuu extends Model
{
<<<<<<< HEAD
    //
}
=======
    use HasFactory;

    protected $table = 'than_huu';

    protected $fillable = [
        'ho_ten',
        'nam_sinh',
        'so_dien_thoai',
        'dia_chi',
        'tin_huu_gioi_thieu_id',
        'trang_thai',
        'ghi_chu',
    ];

    public function tinHuuGioiThieu()
    {
        return $this->belongsTo(TinHuu::class, 'tin_huu_gioi_thieu_id');
    }

    public function thamViengs()
    {
        return $this->hasMany(ThamVieng::class, 'than_huu_id');
    }
}
>>>>>>> ec1a0f61c7ea600ec569639c73f25435caec3111
