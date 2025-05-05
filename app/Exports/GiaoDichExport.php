<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Collection;

class GiaoDichExport implements FromCollection, WithHeadings, WithMapping
{
    protected $giaoDich;
    protected $params;

    public function __construct($giaoDich, $params)
    {
        $this->giaoDich = $giaoDich;
        $this->params = $params;
    }

    /**
     * Trả về dữ liệu giao dịch dưới dạng Collection
     * 
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->giaoDich;
    }

    /**
     * Định nghĩa tiêu đề cột cho Excel
     * 
     * @return array
     */
    public function headings(): array
    {
        return [
            'Mã Giao Dịch',
            'Quỹ',
            'Số Tiền',
            'Loại',
            'Trạng Thái',
            'Ngày Giao Dịch',
            'Mô Tả',
            'Ban Ngành'
        ];
    }

    /**
     * Ánh xạ dữ liệu giao dịch sang các cột Excel
     * 
     * @param \App\Models\GiaoDichTaiChinh $giaoDich
     * @return array
     */
    public function map($giaoDich): array
    {
        $statusTexts = [
            'cho_duyet' => 'Chờ duyệt',
            'da_duyet' => 'Đã duyệt',
            'tu_choi' => 'Từ chối',
            'hoan_thanh' => 'Hoàn thành'
        ];

        return [
            $giaoDich->ma_giao_dich,
            $giaoDich->quyTaiChinh ? $giaoDich->quyTaiChinh->ten_quy : 'N/A',
            ($giaoDich->loai == 'thu' ? '+' : '-') . number_format($giaoDich->so_tien, 0, ',', '.') . ' VNĐ',
            $giaoDich->loai == 'thu' ? 'Thu' : 'Chi',
            $statusTexts[$giaoDich->trang_thai] ?? 'Không xác định',
            $giaoDich->ngay_giao_dich->format('d/m/Y'),
            $giaoDich->mo_ta,
            $giaoDich->banNganh ? $giaoDich->banNganh->ten : 'N/A'
        ];
    }
}