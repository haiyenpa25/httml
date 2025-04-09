@extends('layouts.app')
@section('title', 'Danh sách Buổi Nhóm')

@section('content')
    <div class="container">
        <h2>Danh sách Buổi Nhóm</h2>

        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Danh sách Buổi Nhóm</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped" id="buoi-nhom-table">
                    <thead>
                        <tr>
                            <th>Ngày</th>
                            <th>Chủ Đề</th>
                            <th>Diễn Giả</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Dữ liệu sẽ được tải bằng Ajax --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            loadBuoiNhoms(); // Tải danh sách buổi nhóm khi trang tải

            // Hàm tải danh sách buổi nhóm (giống như trong create.blade.php)
            function loadBuoiNhoms() {
                $.ajax({
                    url: '/get-buoi-nhoms', // Route cần định nghĩa
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let tableBody = $('#buoi-nhom-table tbody');
                        tableBody.empty();
                        $.each(data, function(key, value) {
                            tableBody.append('<tr>' +
                                '<td>' + value.ngay_dien_ra + '</td>' +
                                '<td>' + value.chu_de + '</td>' +
                                '<td>' + value.dien_gia.ho_ten + '</td>' +
                                '<td>' +
                                '<button class="btn btn-sm btn-warning edit-btn" data-id="' + value.id + '">Sửa</button> ' +
                                '<button class="btn btn-sm btn-danger delete-btn" data-id="' + value.id + '">Xóa</button>' +
                                '</td>' +
                                '</tr>');
                        });
                    }
                });
            }

            // Xử lý sự kiện click nút Sửa (giống như trong create.blade.php)
            $(document).on('click', '.edit-btn', function() {
                // ... (code xử lý nút Sửa)
            });

            // Xử lý sự kiện click nút Xóa (giống như trong create.blade.php)
            $(document).on('click', '.delete-btn', function() {
                // ... (code xử lý nút Xóa)
            });
        });
    </script>
@endsection