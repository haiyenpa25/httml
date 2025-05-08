<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot; // Có thể dùng Pivot nếu muốn

// class TinHuuBanNganh extends Pivot // Dùng Pivot nếu bạn định nghĩa quan hệ belongsToMany()->using(TinHuuBanNganh::class)
class TinHuuBanNganh extends Model // Hoặc dùng Model bình thường
{
    use HasFactory;

    // QUAN TRỌNG: Đảm bảo tên bảng này khớp 100% với tên trong CSDL của bạn
    protected $table = 'tin_huu_ban_nganh';

    // Bỏ timestamps nếu bảng pivot không có cột created_at, updated_at
    public $timestamps = false; // Hoặc true nếu có

    protected $fillable = [
        'tin_huu_id',
        'ban_nganh_id',
        'chuc_vu', // Đảm bảo cột này tồn tại nếu bạn dùng fillable
        // Thêm các cột khác của bảng pivot nếu có
    ];

    // Khóa chính của bảng pivot (thường không cần nếu dùng Eloquent chuẩn)
    // protected $primaryKey = ['tin_huu_id', 'ban_nganh_id']; // Chỉ định khóa chính phức hợp nếu cần
    // public $incrementing = false; // Đặt là false nếu khóa chính không tự tăng

    /**
     * Quan hệ với Tín hữu
     */
    public function tinHuu()
    {
        return $this->belongsTo(TinHuu::class, 'tin_huu_id'); // Khóa ngoại trong bảng này
    }

    /**
     * Quan hệ với Ban Ngành
     */
    public function banNganh()
    {
        return $this->belongsTo(BanNganh::class, 'ban_nganh_id'); // Khóa ngoại trong bảng này
    }

    public function ban_nganh()
    {
        return $this->belongsTo(BanNganh::class, 'ban_nganh_id', 'id');
    }

    public function tin_huu()
    {
        return $this->belongsTo(TinHuu::class, 'tin_huu_id', 'id');
    }
}
