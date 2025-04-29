<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuKien extends Model
{
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
