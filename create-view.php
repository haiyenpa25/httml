<?php

$controllers = [
    'TinHuu',
    'DienGia',
    'ThanHuu',
    'ThietBi',
    'TaiChinh',
    'ThoPhuong',
    'TaiLieu',
    'ThongBao',
    'BaoCao',
    'CaiDat',
];

$views = ['index', 'create', 'show', 'edit'];

$specialViews = [
    'TinHuu' => ['nhan_su'],
    'ThietBi' => ['bao_cao', 'thanh_ly'],
    'TaiChinh' => ['bao_cao'],
    'ThoPhuong' => ['buoi_nhom', 'ngay_le'],
    'BaoCao' => ['tho_phuong', 'thiet_bi', 'tai_chinh', 'ban_nganh'],
    'CaiDat' => ['he_thong'],
];

foreach ($controllers as $controller) {
    // Chuyển CamelCase thành snake_case
    $dirName = strtolower(preg_replace('/(?<!\ )[A-Z]/', '_$0', $controller));

    $dir = "resources/views/{$dirName}";

    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    // Tạo các view thông thường
    foreach ($views as $view) {
        $fileName = "{$dir}/{$view}.blade.php";
        if (!file_exists($fileName)) {
            touch($fileName);
            echo "Created: {$fileName}\n";
            // Thêm nội dung mặc định vào view, bao gồm kế thừa layout và section content
            file_put_contents($fileName, "@extends('layouts.base')\n\n@section('content')\n    <h1>" . ucfirst(str_replace('_', ' ', $dirName)) . " - " . ucfirst($view) . "</h1>\n    <p>Nội dung trang " . ucfirst(str_replace('_', ' ', $dirName)) . " - " . ucfirst($view) . " ở đây.</p>\n@endsection");
        } else {
            echo "Exists: {$fileName}\n";
        }
    }

    // Tạo các view đặc biệt
    if (isset($specialViews[$controller])) {
        foreach ($specialViews[$controller] as $view) {
            $fileName = "{$dir}/{$view}.blade.php";
            if (!file_exists($fileName)) {
                touch($fileName);
                echo "Created: {$fileName}\n";
                // Thêm nội dung mặc định vào view, bao gồm kế thừa layout và section content
                file_put_contents($fileName, "@extends('layouts.base')\n\n@section('content')\n    <h1>" . ucfirst(str_replace('_', ' ', $dirName)) . " - " . ucfirst($view) . "</h1>\n    <p>Nội dung trang " . ucfirst(str_replace('_', ' ', $dirName)) . " - " . ucfirst($view) . " ở đây.</p>\n@endsection");
            } else {
                echo "Exists: {$fileName}\n";
            }
        }
    }
}

echo "Done!\n";