<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThongBao extends Model
{
    use HasFactory;

    /**
     * Tên bảng tương ứng với model.
     *
     * @var string
     */
    protected $table = 'thong_bao';

    /**
     * Các thuộc tính có thể gán giá trị hàng loạt.
     *
     * @var array
     */
    protected $fillable = [
        'tieu_de',
        'noi_dung',
        'loai',
        'nguoi_nhan_id',
        'nguoi_gui_id',
        'trang_thai',
        'ngay_gui',
        'da_doc',
        'luu_tru'
    ];

    /**
     * Các thuộc tính sẽ được cast.
     *
     * @var array
     */
    protected $casts = [
        'ngay_gui' => 'datetime',
        'da_doc' => 'boolean',
        'luu_tru' => 'boolean',
    ];

    /**
     * Lấy người nhận thông báo.
     */
    public function nguoiNhan()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_nhan_id');
    }

    /**
     * Lấy người gửi thông báo.
     */
    public function nguoiGui()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_gui_id');
    }
}
