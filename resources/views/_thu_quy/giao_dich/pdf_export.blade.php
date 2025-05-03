<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>{{ $tieuDe }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .text-success {
            color: green;
        }

        .text-danger {
            color: red;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .summary {
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>{{ $tieuDe }}</h1>
        <p>Ngày lập báo cáo: {{ now()->format('d/m/Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Mã Giao Dịch</th>
                <th>Quỹ</th>
                <th>Số Tiền</th>
                <th>Loại</th>
                <th>Ngày</th>
                <th>Mô Tả</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($giaoDich as $gd)
                <tr>
                    <td>{{ $gd->ma_giao_dich }}</td>
                    <td>{{ $gd->quyTaiChinh->ten_quy ?? 'N/A' }}</td>
                    <td class="{{ $gd->loai == 'thu' ? 'text-success' : 'text-danger' }}">
                        {{ $gd->loai == 'thu' ? '+' : '-' }} {{ number_format($gd->so_tien, 0, ',', '.') }} VNĐ
                    </td>
                    <td>{{ $gd->loai == 'thu' ? 'Thu' : 'Chi' }}</td>
                    <td>{{ $gd->ngay_giao_dich->format('d/m/Y') }}</td>
                    <td>{{ $gd->mo_ta }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <p>Tổng Thu: {{ number_format($tongThu, 0, ',', '.') }} VNĐ</p>
        <p>Tổng Chi: {{ number_format($tongChi, 0, ',', '.') }} VNĐ</p>
        <p>Số Dư: {{ number_format($soDu, 0, ',', '.') }} VNĐ</p>
    </div>
</body>

</html>