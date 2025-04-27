<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ThietBi extends Model
{
    use HasFactory;

    /**
     * Tên bảng trong cơ sở dữ liệu
     *
     * @var string
     */
    protected $table = 'thiet_bi';

    /**
     * Các trường có thể gán giá trị hàng loạt
     *
     * @var array
     */
    protected $fillable = [
        'ten',
        'loai',
        'tinh_trang',
        'nha_cung_cap_id',
        'ngay_mua',
        'gia_tri',
        'nguoi_quan_ly_id',
        'id_ban',
        'vi_tri_hien_tai',
        'thoi_gian_bao_hanh',
        'chu_ky_bao_tri',
        'ngay_het_han_su_dung',
        'ma_tai_san',
        'hinh_anh',
        'mo_ta'
    ];

    /**
     * Các thuộc tính cần cast
     *
     * @var array
     */
    protected $casts = [
        'ngay_mua' => 'date',
        'thoi_gian_bao_hanh' => 'date',
        'ngay_het_han_su_dung' => 'date',
        'gia_tri' => 'decimal:2'
    ];

    /**
     * Các loại thiết bị
     */
    const LOAI_THIET_BI = [
        'nhac_cu' => 'Nhạc cụ',
        'anh_sang' => 'Ánh sáng',
        'am_thanh' => 'Âm thanh',
        'hinh_anh' => 'Hình ảnh',
        'khac' => 'Khác'
    ];

    /**
     * Các trạng thái thiết bị
     */
    const TINH_TRANG = [
        'tot' => 'Tốt',
        'hong' => 'Hỏng',
        'dang_sua' => 'Đang sửa'
    ];

    /**
     * Lấy nhà cung cấp của thiết bị
     */
    public function nhaCungCap()
    {
        return $this->belongsTo(NhaCungCap::class, 'nha_cung_cap_id');
    }

    /**
     * Lấy ban ngành quản lý thiết bị
     */
    public function banNganh()
    {
        return $this->belongsTo(BanNganh::class, 'id_ban');
    }

    /**
     * Lấy người quản lý thiết bị
     */
    public function nguoiQuanLy()
    {
        return $this->belongsTo(TinHuu::class, 'nguoi_quan_ly_id');
    }

    /**
     * Lấy lịch sử bảo trì của thiết bị
     */
    public function lichSuBaoTris()
    {
        return $this->hasMany(LichSuBaoTri::class, 'thiet_bi_id');
    }

    /**
     * Lấy ngày bảo trì gần nhất
     */
    public function ngayBaoTriGanNhat()
    {
        $lichSuBaoTri = $this->lichSuBaoTris()->orderBy('ngay_bao_tri', 'desc')->first();
        return $lichSuBaoTri ? $lichSuBaoTri->ngay_bao_tri : null;
    }

    /**
     * Kiểm tra thiết bị có cần bảo trì không
     * 
     * @return bool
     */
    public function canBaoTri()
    {
        if (!$this->chu_ky_bao_tri) {
            return false;
        }

        $ngayBaoTriGanNhat = $this->ngayBaoTriGanNhat();
        if (!$ngayBaoTriGanNhat) {
            return true;
        }

        $ngayCanBaoTri = Carbon::parse($ngayBaoTriGanNhat)->addDays($this->chu_ky_bao_tri);
        return Carbon::now()->greaterThanOrEqualTo($ngayCanBaoTri);
    }

    /**
     * Kiểm tra thiết bị có sắp hết hạn bảo hành không (trong vòng 30 ngày)
     * 
     * @return bool
     */
    public function sapHetHanBaoHanh()
    {
        if (!$this->thoi_gian_bao_hanh) {
            return false;
        }

        $ngayHetHan = Carbon::parse($this->thoi_gian_bao_hanh);
        return Carbon::now()->diffInDays($ngayHetHan, false) <= 30 && Carbon::now()->diffInDays($ngayHetHan, false) >= 0;
    }

    /**
     * Kiểm tra thiết bị có sắp hết hạn sử dụng không (trong vòng 30 ngày)
     * 
     * @return bool
     */
    public function sapHetHanSuDung()
    {
        if (!$this->ngay_het_han_su_dung) {
            return false;
        }

        $ngayHetHan = Carbon::parse($this->ngay_het_han_su_dung);
        return Carbon::now()->diffInDays($ngayHetHan, false) <= 30 && Carbon::now()->diffInDays($ngayHetHan, false) >= 0;
    }

    /**
     * Tính tổng chi phí bảo trì
     * 
     * @param string|null $tuNgay Ngày bắt đầu format Y-m-d
     * @param string|null $denNgay Ngày kết thúc format Y-m-d
     * @return float
     */
    public function tongChiPhiBaoTri($tuNgay = null, $denNgay = null)
    {
        $query = $this->lichSuBaoTris();

        if ($tuNgay) {
            $query->where('ngay_bao_tri', '>=', $tuNgay);
        }

        if ($denNgay) {
            $query->where('ngay_bao_tri', '<=', $denNgay);
        }

        return $query->sum('chi_phi');
    }
}