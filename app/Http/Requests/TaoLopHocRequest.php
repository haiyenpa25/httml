<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaoLopHocRequest extends FormRequest
{
    public function authorize()
    {
        // Middleware CheckPermission đã kiểm tra quyền, chỉ cần kiểm tra đăng nhập
        return auth()->check();
    }

    public function rules()
    {
        return [
            'ten_lop' => 'required|string|max:255',
            'loai_lop' => 'required|in:bap_tem,thanh_nien,trung_lao,khac',
            'thoi_gian_bat_dau' => 'nullable|date',
            'thoi_gian_ket_thuc' => 'nullable|date|after_or_equal:thoi_gian_bat_dau',
            'tan_suat' => 'required|in:co_dinh,linh_hoat',
            'dia_diem' => 'required|string',
            'mo_ta' => 'nullable|string',
        ];
    }
}
