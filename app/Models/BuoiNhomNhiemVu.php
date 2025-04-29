<?php

namespace App\Models;

use App\Models\BuoiNhom;
use App\Models\NhiemVu;
use App\Models\TinHuu;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

use Illuminate\Database\Eloquent\Model;

class BuoiNhomNhiemVu extends Model
{
    use HasFactory;

    protected $table = 'buoi_nhom_nhiem_vu';

    protected $fillable = [
        'buoi_nhom_id',
        'nhiem_vu_id',
        'vi_tri',
        'tin_huu_id',
        'ghi_chu',
    ];

    /**
     * Get the buổi nhóm that this nhiệm vụ belongs to.
     */
    public function buoiNhom(): BelongsTo
    {
        return $this->belongsTo(BuoiNhom::class, 'buoi_nhom_id');
    }

    /**
     * Get the nhiệm vụ that this phân công belongs to.
     */
    public function nhiemVu(): BelongsTo
    {
        return $this->belongsTo(NhiemVu::class, 'nhiem_vu_id');
    }

    /**
     * Get the tín hữu that this phân công belongs to.
     */
    public function tinHuu(): BelongsTo
    {
        return $this->belongsTo(TinHuu::class, 'tin_huu_id');
    }
}
