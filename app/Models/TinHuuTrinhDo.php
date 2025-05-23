<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TinHuuTrinhDo extends Model
{
    use HasFactory;

    protected $table = 'tin_huu_trinh_do';

    protected $fillable = [
        'tin_huu_id',
        'ten_khoa_hoc',
        'ngay_tot_nghiep',
        'chung_chi',
        'ghi_chu',
    ];

    protected $casts = [
        'ngay_tot_nghiep' => 'date',
    ];

    public function tin_huu()
    {
        return $this->belongsTo(TinHuu::class, 'tin_huu_id');
    }
}
