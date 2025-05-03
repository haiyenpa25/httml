<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Báo Cáo Tài Chính: {{ $baoCao->tieu_de }}</title>
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
        <h1>Báo Cáo Tài Chính: {{ $baoCao->tieu_de }}</h1>
        <p>Từ ngày: {{ $baoCao->tu_ngay->format('d/m/Y') }} - Đến ngày: {{ $baoCao->den_ngay->format('d/m/Y') }}</p>
        <p>Ngày lập báo cáo: {{ now()->format('d/m/Y') }}</p>
    </div>

    <h3>Thông Tin Chung</h3>
    <p><strong>Quỹ:</strong> {{ $baoCao->quyTaiChinh->ten_quy ?? 'Tổng Hợp' }}</p>
    <p><strong>Người Tạo:</strong> {{ $baoCao->nguoiTao->tin_huu->ho_ten ?? 'N/A' }}</p>

    <h3>Thống Kê</h3>
    <p><strong>Tổng Thu:</strong> {{ $formatTien($baoCao->tong_thu) }}</p>
    <p><strong>Tổng Chi:</strong> {{ $formatTien($baoCao->tong_chi) }}</p>
    <p><strong>Số Dư Đầu Kỳ:</strong> {{ $formatTien($baoCao->so_du_dau_ky) }}</p>
    <p><strong>Số Dư Cuối Kỳ:</strong> {{ $formatTien($baoCao->so_du_cuoi_ky) }}</p>

    <h3>Danh Sách Giao Dịch</h3>
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
            @foreach ($baoCao->noi_dung_bao_cao['danh_sach_giao_dich'] as $gd)
                <tr>
                    <td>{{ $gd['ma_giao_dich'] }}</td>
                    <td>{{ $gd['quy_tai_chinh']['ten_quy'] ?? 'N/A' }}</td>
                    <td class="{{ $gd['loai'] == 'thu' ? 'text-success' : 'text-danger' }}">
                        {{ $gd['loai'] == 'thu' ? '+' : '-' }} {{ $formatTien($gd['so_tien']) }}
                    </td>
                    <td>{{ $gd['loai'] == 'thu' ? 'Thu' : 'Chi' }}</td>
                    <td>{{ \Carbon\Carbon::parse($gd['ngay_giao_dich'])->format('d/m/Y') }}</td>
                    <td>{{ $gd['mo_ta'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>