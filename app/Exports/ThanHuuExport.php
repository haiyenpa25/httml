<?php

namespace App\Exports;

use App\Models\ThanHuu;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ThanHuuExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return ThanHuu::with('tinHuuGioiThieu')->orderBy('ho_ten')->get();
    }

    public function headings(): array
    {
        return [
            'Họ Tên',
            'Năm Sinh',
            'Số Điện Thoại',
            'Địa Chỉ',
            'Tín Hữu Giới Thiệu',
            'Trạng Thái',
            'Ghi Chú'
        ];
    }

    public function map($thanHuu): array
    {
        return [
            $thanHuu->ho_ten,
            $thanHuu->nam_sinh,
            $thanHuu->so_dien_thoai ?: '(Không có)',
            $thanHuu->dia_chi ?: '(Không có)',
            $thanHuu->tinHuuGioiThieu ? $thanHuu->tinHuuGioiThieu->ho_ten : '(Không có)',
            [
                'chua_tin' => 'Chưa tin',
                'da_tham_gia' => 'Đã tham gia',
                'da_tin_chua' => 'Đã tin Chúa'
            ][$thanHuu->trang_thai] ?? $thanHuu->trang_thai,
            $thanHuu->ghi_chu ?: '(Không có)'
        ];
    }
}
