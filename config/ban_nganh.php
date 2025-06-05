<?php

return [
    'co_doc_giao_duc' => [
        'id' => 6,
        'hoi_thanh_id' => 20,
        'name' => 'Ban Cơ Đốc Giáo Dục',
        'view_prefix' => '_ban_co_doc_giao_duc',
        'route_prefix' => 'ban-co-doc-giao-duc',
        'quantity_field' => 'so_luong_trung_lao',
        'quantity_field2' => 'so_luong_thanh_trang',
        'quantity_field3' => 'so_luong_thanh_nien',
    ],
    'trung_lao' => [
        'id' => 1,
        'hoi_thanh_id' => 20,
        'name' => 'Ban Trung Lão',
        'view_prefix' => '_ban_nganh',
        'route_prefix' => 'ban-trung-lao',
        'quantity_field' => 'so_luong_trung_lao',
    ],
    'thanh_trang' => [
        'id' => 2,
        'hoi_thanh_id' => 20,
        'name' => 'Ban Thanh Tráng',
        'view_prefix' => '_ban_nganh',
        'route_prefix' => 'ban-thanh-trang',
        'quantity_field' => 'so_luong_thanh_trang',
    ],
    'thanh_nien' => [
        'id' => 3,
        'hoi_thanh_id' => 20,
        'name' => 'Ban Thanh Niên',
        'view_prefix' => '_ban_nganh',
        'route_prefix' => 'ban-thanh-nien',
        'quantity_field' => 'so_luong_thanh_nien',
    ],
    'thieu_nhi' => [
        'id' => 7,
        'hoi_thanh_id' => 20,
        'name' => 'Ban Thiếu Nhi',
        'view_prefix' => '_ban_nganh',
        'route_prefix' => 'ban-thieu-nhi',
        'quantity_field' => 'so_luong_thieu_nhi',
    ],
    'features' => [
        'index' => [
            'name' => 'Tổng quan',
            'permission' => 'view-ban-nganh-{banType}',
            'route' => 'index',
            'icon' => 'th-large',
            'method' => 'GET',
        ],
        'diem_danh' => [
            'name' => 'Điểm danh',
            'permission' => 'diem-danh-ban-nganh-{banType}',
            'route' => 'diem_danh',
            'icon' => 'clipboard-check',
            'method' => 'GET',
        ],
        'tham_vieng' => [
            'name' => 'Thăm viếng',
            'permission' => 'tham-vieng-ban-nganh-{banType}',
            'route' => 'tham_vieng',
            'icon' => 'handshake',
            'method' => 'GET',
        ],
        'phan_cong' => [
            'name' => 'Phân công',
            'permission' => 'phan-cong-ban-nganh-{banType}',
            'route' => 'phan_cong',
            'icon' => 'tasks',
            'method' => 'GET',
        ],
        'phan_cong_chi_tiet' => [
            'name' => 'Phân công chi tiết',
            'permission' => 'phan-cong-chi-tiet-ban-nganh-{banType}',
            'route' => 'phan_cong_chi_tiet',
            'icon' => 'list-check',
            'method' => 'GET',
        ],
        'bao_cao' => [
            'name' => 'Báo cáo',
            'permission' => [
                'nhap_lieu_bao_cao' => 'nhap-lieu-bao-cao-ban-nganh-{banType}',
                'bao_cao' => 'bao-cao-ban-nganh-{banType}',
            ],
            'route' => [
                'nhap_lieu_bao_cao' => 'nhap_lieu_bao_cao',
                'bao_cao' => 'bao_cao',
            ],
            'icon' => 'chart-line',
            'children' => [
                'nhap_lieu_bao_cao' => [
                    'name' => 'Nhập liệu báo cáo',
                    'icon' => 'keyboard',
                ],
                'bao_cao' => [
                    'name' => 'Xem báo cáo',
                    'icon' => 'file-alt',
                ],
            ],
            'method' => 'GET',
        ],
    ],
];
