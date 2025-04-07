<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TinHuuBanNganh extends Model
{
    use HasFactory;

    protected $table = 'tin_huu_ban_nganh';

    protected $fillable = ['tin_huu_id', 'ban_nganh_id'];

    public function tinHuu()
    {
        return $this->belongsTo(TinHuu::class);
    }

    public function banNganh()
    {
        return $this->belongsTo(BanNganh::class);
    }
}
