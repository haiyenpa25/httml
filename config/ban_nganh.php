<?php

return [

    'trung_lao' => [
        'id' => 1,
        'hoi_thanh_id' => 20,
        'quantity_field' => 'so_luong_trung_lao',
        'view_prefix' => '_ban_nganh',
        'name' => 'Ban Trung Lão',
    ],
    'thanh_trang' => [
        'id' => 2, // Giả sử ID của Ban Thanh Tráng
        'hoi_thanh_id' => 20,
        'quantity_field' => 'so_luong_thanh_trang',
        'view_prefix' => '_ban_nganh',
        'name' => 'Ban Thanh Tráng',
    ],
    'thanh_nien' => [
        'id' => 3, // Giả sử ID của Ban Thanh Niên
        'hoi_thanh_id' => 20,
        'quantity_field' => 'so_luong_thanh_nien',
        'view_prefix' => '_ban_nganh',
        'name' => 'Ban Thanh Niên',
    ],
    'thieu_nhi' => [
        'id' => 4, // Giả sử ID của Ban Thiếu Nhi
        'hoi_thanh_id' => 20,
        'quantity_field' => 'so_luong_thieu_nhi',
        'view_prefix' => '_ban_nganh',
        'name' => 'Ban Thiếu Nhi',
    ],
    'co_doc_giao_duc' => [
        'id' => 6, // ID của Ban Cơ Đốc Giáo Dục trong bảng ban_nganh
        'hoi_thanh_id' => 20, // ID của Hội Thánh
        'name' => 'Ban Cơ Đốc Giáo Dục',
        'view_prefix' => '_ban_co_doc_giao_duc',
        'quantity_field' => 'so_luong_trung_lao',
        'quantity_field2' => 'so_luong_thanh_trang',
        'quantity_field3' => 'so_luong_thanh_nien',
    ],
];
