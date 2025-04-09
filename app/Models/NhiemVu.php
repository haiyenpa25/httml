<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NhiemVu extends Model
{
    public function banNganh()
    {
        return $this->belongsTo(BanNganh::class, 'id_ban_nganh');
    }
}
