<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\NguoiDungPhanQuyen;

class UpdateLopHocRequest extends FormRequest
{
    /**
     * Xác định xem người dùng có quyền thực hiện yêu cầu này không.
     *
     * @return bool
     */
    public function authorize()
    {
        // Lấy người dùng hiện tại
        /** @var \App\Models\NguoiDung|null $user */
        $user = auth()->user();

        // Nếu không có người dùng đăng nhập, trả về false
        if (!$user) {
            return false;
        }

        // Kiểm tra xem người dùng có quyền "edit-lop-hoc" trong bảng nguoi_dung_phan_quyen
        return NguoiDungPhanQuyen::where('nguoi_dung_id', $user->id)
            ->where('quyen', 'edit-lop-hoc')
            ->exists();
    }

    /**
     * Các quy tắc validation cho yêu cầu cập nhật lớp học.
     *
     * @return array
     */
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

    /**
     * Tùy chỉnh thông báo lỗi.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'ten_lop.required' => 'Tên lớp là bắt buộc.',
            'ten_lop.string' => 'Tên lớp phải là chuỗi ký tự.',
            'ten_lop.max' => 'Tên lớp không được vượt quá 255 ký tự.',
            'loai_lop.required' => 'Loại lớp là bắt buộc.',
            'loai_lop.in' => 'Loại lớp không hợp lệ.',
            'thoi_gian_bat_dau.date' => 'Thời gian bắt đầu không đúng định dạng.',
            'thoi_gian_ket_thuc.date' => 'Thời gian kết thúc không đúng định dạng.',
            'thoi_gian_ket_thuc.after_or_equal' => 'Thời gian kết thúc phải lớn hơn hoặc bằng thời gian bắt đầu.',
            'tan_suat.required' => 'Tần suất là bắt buộc.',
            'tan_suat.in' => 'Tần suất không hợp lệ.',
            'dia_diem.required' => 'Địa điểm là bắt buộc.',
            'dia_diem.string' => 'Địa điểm phải là chuỗi ký tự.',
        ];
    }
}
