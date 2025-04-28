<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NhaCungCap extends Model
{
    use HasFactory;

    /**
     * Tên bảng trong cơ sở dữ liệu
     *
     * @var string
     */
    protected $table = 'nha_cung_cap';


    /**
     * Các trường có thể gán giá trị hàng loạt
     *
     * @var array
     */
    protected $fillable = [
        'ten_nha_cung_cap',
        'dia_chi',
        'so_dien_thoai',
        'email',
        'ghi_chu'
    ];

    /**
     * Lấy các thiết bị thuộc nhà cung cấp
     */
    public function thietBis()
    {
        return $this->hasMany(ThietBi::class, 'nha_cung_cap_id');
    }
}
