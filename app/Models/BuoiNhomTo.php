<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BuoiNhomTo extends Model
{
    use HasFactory;

    protected $table = 'buoi_nhom_to';

    protected $fillable = [
        'id_ban_nganh',
        'ten_to',
        'id_to', // Có vẻ như đây là quan hệ tự tham chiếu (parent_id)
    ];

    public function banNganh(): BelongsTo
    {
        return $this->belongsTo(BanNganh::class, 'id_ban_nganh'); // Giả định có model BanNganh
    }

    public function parentTo(): BelongsTo
    {
        return $this->belongsTo(BuoiNhomTo::class, 'id_to'); // Quan hệ với chính nó (parent)
    }

    public function childrenTo(): HasMany
    {
        return $this->hasMany(BuoiNhomTo::class, 'id_to'); // Quan hệ với chính nó (children)
    }

    public function buoiNhoms(): HasMany
    {
        return $this->hasMany(BuoiNhom::class, 'id_to');
    }
}
