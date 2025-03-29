<?php

$controllers = [
    'BanChapSu',
    'BanAmThuc',
    'BanCauNguyen',
    'BanChungDao',
    'BanCoDocGiaoDuc',
    'BanDan',
    'BanHauCan',
    'BanHatThoPhuong',
    'BanKhanhTiet',
    'BanKyThuatAmThanh',
    'BanLeTan',
    'BanMayChieu',
    'BanThamVieng',
    'BanTratTu',
    'BanTruyenGiang',
    'BanTruyenThongMayChieu',
    'BanThanhNien',
    'BanThanhTrang',
    'BanThieuNhiAu',
    'BanTrungLao',
];

$views = ['index', 'create', 'show', 'edit'];

foreach ($controllers as $controller) {
    // Chuyển CamelCase thành snake_case
    $dirName = strtolower(preg_replace('/(?<!\ )[A-Z]/', '_$0', $controller));

    $dir = "resources/views/{$dirName}";

    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

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
}

echo "Done!\n";

?>