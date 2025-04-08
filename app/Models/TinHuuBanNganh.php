<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TinHuuBanNganh extends Model
{
    use HasFactory;

    protected $table = 'tin_huu_ban_nganh';

    protected $fillable = ['tin_huu_id', 'ban_nganh_id', 'chuc_vu'];

    public function tinHuu()
    {
        return $this->belongsTo(TinHuu::class, 'tin_huu_id');
    }

    public function banNganh()
    {
        return $this->belongsTo(BanNganh::class, 'ban_nganh_id');
    }
}