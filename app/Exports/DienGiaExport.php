<?php

namespace App\Exports;

use App\Models\DienGia;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DienGiaExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return DienGia::orderBy('ho_ten')->get();
    }

    public function headings(): array
    {
        return [
            'Họ Tên',
            'Chức Danh',
            'Hội Thánh',
            'Địa Chỉ',
            'Số Điện Thoại'
        ];
    }

    public function map($dienGia): array
    {
        return [
            $dienGia->ho_ten,
            $dienGia->chuc_danh,
            $dienGia->hoi_thanh ?: '(Không có)',
            $dienGia->dia_chi ?: '(Không có)',
            $dienGia->so_dien_thoai ?: '(Không có)'
        ];
    }
}
