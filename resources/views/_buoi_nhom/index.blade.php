{{-- ====================================================================== --}}
{{-- File: resources/views/_buoi_nhom/index.blade.php --}}
{{-- View để hiển thị danh sách buổi nhóm --}}
{{-- ====================================================================== --}}
@extends('layouts.app')
@section('title', 'Danh sách Buổi Nhóm')

@section('content')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Danh sách Buổi Nhóm</h1>
            </div>
            <div class="col-sm-6">
                <a href="{{ url('buoi-nhom/create') }}" class="btn btn-success float-sm-right">
                    <i class="fas fa-plus"></i> Thêm Buổi Nhóm Mới
                </a>
            </div>
        </div>

        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-list"></i> Danh sách Buổi Nhóm</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" onclick="loadBuoiNhoms()">
                        <i class="fas fa-sync-alt"></i> Tải lại
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-bordered table-striped table-hover" id="buoi-nhom-table">
                    <thead>
                        <tr>
                            <th style="width: 10%;">ID</th>
                            <th style="width: 15%;">Ngày</th>
                            <th style="width: 30%;">Chủ Đề</th>
                            <th style="width: 15%;">Ban Ngành</th>
                            <th style="width: 15%;">Diễn Giả</th>
                            <th style="width: 15%;">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody id="buoi-nhom-table-body">
                        <tr>
                            <td colspan="6" class="text-center">
                                <i class="fas fa-spinner fa-spin"></i> Đang tải dữ liệu...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            console.log('Script for _buoi_nhom/index.blade.php executing independently.');

            // Kiểm tra các thư viện cần thiết
            if (typeof $ === 'undefined') {
                console.error('jQuery is not loaded.');
                return;
            }
            if (typeof moment === 'undefined') {
                console.error('Moment.js is not loaded.');
                return;
            }

            // Thiết lập CSRF token cho Ajax
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // ----- Helper Functions -----
            const showAlert = (message, type = 'info') => {
                alert(`[${type.toUpperCase()}] ${message}`);
            };

            const formatDate = (dateStr) => {
                try {
                    return dateStr ? moment(dateStr).format('YYYY-MM-DD') : 'N/A';
                } catch (e) {
                    console.error('Error formatting date:', e);
                    return 'N/A';
                }
            };

            const escapeHtml = (unsafe) => {
                if (unsafe === null || unsafe === undefined) return '';
                return unsafe.toString()
                    .replace(/&/g, "&")
                    .replace(/</g, "<")
                    .replace(/>/g, ">")
                    .replace(/"/g, "&quot;") // Sửa lỗi cú pháp: thay thế " bằng thực thể HTML &quot;
                    .replace(/'/g, "'")
                    .replace(/\\/g, "\\\\")
                    .replace(/\n/g, "\\n")
                    .replace(/\r/g, "\\r")
                    .replace(/\t/g, "\\t")
                    .replace(/\0/g, ""); // Loại bỏ ký tự null
            };

            const loadBuoiNhoms = () => {
                const url = '{{ route("api.buoi_nhom.list") }}';
                console.log('Đang tải danh sách buổi nhóm từ:', url);

                $.ajax({
                    url: url,
                    method: 'GET',
                    dataType: 'json'
                }).done(function (data) {
                    console.log('Dữ liệu danh sách buổi nhóm:', data);
                    const tableBody = $('#buoi-nhom-table-body');
                    tableBody.empty();
                    if (!Array.isArray(data) || data.length === 0) {
                        tableBody.append('<tr><td colspan="6" class="text-center">Không có buổi nhóm nào.</td></tr>');
                        return;
                    }

                    data.forEach(bn => {
                        const displayDate = formatDate(bn.ngay_dien_ra);
                        const banNganhName = bn.ban_nganh?.ten || 'N/A';
                        const dienGiaName = bn.dien_gia ? `${bn.dien_gia.chuc_danh || ''} ${bn.dien_gia.ho_ten || ''}`.trim() : 'N/A';
                        const editUrl = '{{ url("buoi-nhom") }}/' + bn.id + '/edit';

                        // Log dữ liệu để kiểm tra ký tự đặc biệt
                        console.log('Chu De:', bn.chu_de);
                        console.log('Ban Nganh:', banNganhName);
                        console.log('Dien Gia:', dienGiaName);

                        // Tạo hàng bằng DOM manipulation để tránh lỗi cú pháp
                        const row = document.createElement('tr');
                        row.setAttribute('data-id', bn.id);

                        // Cột ID
                        const idCell = document.createElement('td');
                        idCell.textContent = bn.id;
                        row.appendChild(idCell);

                        // Cột Ngày
                        const dateCell = document.createElement('td');
                        dateCell.textContent = displayDate;
                        row.appendChild(dateCell);

                        // Cột Chủ Đề
                        const chuDeCell = document.createElement('td');
                        chuDeCell.textContent = escapeHtml(bn.chu_de) || 'N/A';
                        row.appendChild(chuDeCell);

                        // Cột Ban Ngành
                        const banNganhCell = document.createElement('td');
                        banNganhCell.textContent = escapeHtml(banNganhName);
                        row.appendChild(banNganhCell);

                        // Cột Diễn Giả
                        const dienGiaCell = document.createElement('td');
                        dienGiaCell.textContent = escapeHtml(dienGiaName);
                        row.appendChild(dienGiaCell);

                        // Cột Hành Động
                        const actionCell = document.createElement('td');

                        // Nút Sửa
                        const editLink = document.createElement('a');
                        editLink.href = editUrl;
                        editLink.className = 'btn btn-warning btn-sm';
                        editLink.title = 'Sửa';
                        editLink.innerHTML = '<i class="fas fa-edit"></i> Sửa';
                        actionCell.appendChild(editLink);

                        // Nút Xóa
                        const deleteButton = document.createElement('button');
                        deleteButton.type = 'button';
                        deleteButton.className = 'btn btn-danger btn-sm delete-btn';
                        deleteButton.setAttribute('data-id', bn.id);
                        deleteButton.title = 'Xóa';
                        deleteButton.innerHTML = '<i class="fas fa-trash-alt"></i> Xóa';
                        actionCell.appendChild(deleteButton);

                        row.appendChild(actionCell);

                        tableBody[0].appendChild(row);
                    });
                }).fail(function (jqXHR) {
                    console.error('Failed to load Buoi Nhoms:', jqXHR.status, jqXHR.statusText, jqXHR.responseText);
                    $('#buoi-nhom-table-body').html('<tr><td colspan="6" class="text-center text-danger">Lỗi tải danh sách buổi nhóm.</td></tr>');
                    showAlert('Lỗi tải danh sách buổi nhóm.');
                });
            };

            // Xử lý sự kiện xóa
            $('#buoi-nhom-table-body').on('click', '.delete-btn', function () {
                const buoiNhomId = $(this).data('id');
                if (!buoiNhomId) return;

                if (confirm(`Bạn có chắc muốn xóa Buổi Nhóm ID ${buoiNhomId}?`)) {
                    const url = '{{ route("api.buoi_nhom.destroy", ["buoi_nhom" => "__ID__"]) }}'.replace('__ID__', buoiNhomId);
                    console.log(`Deleting Buoi Nhom ID: ${buoiNhomId}`);

                    $.ajax({
                        url: url,
                        method: 'DELETE',
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                showAlert('Xóa buổi nhóm thành công!', 'success');
                                loadBuoiNhoms();
                            } else {
                                showAlert(response.message || 'Không thể xóa buổi nhóm.');
                            }
                        },
                        error: function (jqXHR) {
                            console.error("Ajax Error (Delete):", jqXHR.status, jqXHR.statusText, jqXHR.responseText);
                            showAlert(`Lỗi ${jqXHR.status} khi xóa buổi nhóm.`);
                        }
                    });
                }
            });

            // Load danh sách buổi nhóm khi trang được tải
            loadBuoiNhoms();

            console.log('Trang index buổi nhóm đã tải.');
        });
    </script>
@endpush
@include('scripts.buoi_nhom')