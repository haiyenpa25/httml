<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThamGiaSuKien extends Model
{
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
