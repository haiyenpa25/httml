@section('page-scripts')
<script>
    $(function () {
        // Khởi tạo Select2
        $('.select2bs4').select2({
            theme: 'bootstrap4',
            placeholder: 'Chọn một mục',
            allowClear: true,
            width: '100%'
        });

        // Định dạng số tiền
        $('.money-format').on('input', function () {
            let value = $(this).val().replace(/\D/g, '');
            $(this).val(formatCurrency(value));
        });

        function formatCurrency(value) {
            return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Cập nhật số lượng tham dự và dâng hiến (sử dụng event delegation)
        $(document).on('click', '.update-count', function () {
            const btn = $(this);
            const row = btn.closest('tr');
            const id = btn.data('id');
            const type = btn.data('type');

            let url = '';
            let data = {};

            if (type === 'bn') {
                const soLuong = row.find('input[name="buoi_nhom[' + id + '][so_luong]"]').val();
                let dangHien = row.find('input[name="buoi_nhom[' + id + '][dang_hien]"]').val();
                dangHien = dangHien.replace(/\./g, '');

                url = "{{ route('api._ban_co_doc_giao_duc.update_tham_du', ['banType' => 'ban-co-doc-giao-duc']) }}";
                data = {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    ban_nganh: "{{ $selectedBanNganh }}",
                    so_luong: soLuong,
                    dang_hien: dangHien
                };

                // Log dữ liệu gửi để debug
                console.log('Sending update request:', data);
            }

            if (url) {
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: data,
                    dataType: 'json',
                    beforeSend: function () {
                        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
                    },
                    success: function (response) {
                        console.log('Update response:', response);
                        if (response.success) {
                            toastr.success(response.message || 'Đã cập nhật thành công', 'Thành công');
                        } else {
                            toastr.error(response.message || 'Có lỗi xảy ra', 'Lỗi');
                        }
                    },
                    error: function (xhr) {
                        console.log('Update error:', xhr);
                        let message = 'Có lỗi xảy ra khi xử lý yêu cầu';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                            if (xhr.responseJSON.errors) {
                                message += ': ' + Object.values(xhr.responseJSON.errors).flat().join(', ');
                            }
                        }
                        toastr.error(message, 'Lỗi');
                    },
                    complete: function () {
                        btn.prop('disabled', false).html('<i class="fas fa-save"></i> Lưu');
                    }
                });
            }
        });

        // Xử lý form điểm danh (giữ nguyên)
        $('#thamdu-form').on('submit', function (e) {
            e.preventDefault();
            if ($(this).find('input[name^="buoi_nhom"]').length === 0) {
                toastr.warning('Không có dữ liệu để lưu', 'Cảnh báo');
                return;
            }

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend: function () {
                    $('#thamdu-form button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Đang lưu...');
                },
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message || 'Đã lưu thông tin tham dự và dâng hiến', 'Thành công');
                    } else {
                        toastr.error(response.message || 'Có lỗi xảy ra', 'Lỗi');
                    }
                },
                error: function (xhr) {
                    let message = 'Có lỗi xảy ra khi xử lý yêu cầu';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                        if (xhr.responseJSON.errors) {
                            message += ': ' + Object.values(xhr.responseJSON.errors).flat().join(', ');
                        }
                    }
                    toastr.error(message, 'Lỗi');
                },
                complete: function () {
                    $('#thamdu-form button[type="submit"]').prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Lưu tất cả');
                }
            });
        });

        // Xử lý thêm kế hoạch
        $('#add-kehoach').on('click', function () {
            const count = $('#kehoach-tbody .kehoach-row').length;
            const template = `
                <tr class="kehoach-row">
                    <td>${count + 1}</td>
                    <td>
                        <input type="text" class="form-control" name="kehoach[${count}][hoat_dong]" value="" required>
                        <input type="hidden" name="kehoach[${count}][id]" value="0">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="kehoach[${count}][thoi_gian]" value="">
                    </td>
                    <td>
                        <select class="form-control select2-new" name="kehoach[${count}][nguoi_phu_trach_id]">
                            <option value="">-- Chọn người phụ trách --</option>
                            @if (!empty($tinHuu) && $tinHuu instanceof \Illuminate\Support\Collection && $tinHuu->isNotEmpty())
                                @foreach ($tinHuu as $tinHuu)
                                    <option value="{{ $tinHuu->id }}">{{ $tinHuu->ho_ten }}</option>
                                @endforeach
                            @else
                                <option value="" disabled>Không có tín hữu nào</option>
                            @endif
                        </select>
                    </td>
                    <td>
                        <textarea class="form-control" name="kehoach[${count}][ghi_chu]"></textarea>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-kehoach">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            $('#kehoach-tbody').append(template);
            $('.select2-new').select2({
                theme: 'bootstrap4',
                placeholder: 'Chọn một mục',
                allowClear: true,
                width: '100%'
            }).removeClass('select2-new');
        });

        // Xóa một kế hoạch
        $(document).on('click', '.remove-kehoach', function () {
            if ($('#kehoach-tbody .kehoach-row').length > 1) {
                $(this).closest('.kehoach-row').remove();
                // Cập nhật STT và tên trường
                $('#kehoach-tbody .kehoach-row').each(function (index) {
                    $(this).find('td:first').text(index + 1);
                    $(this).find('input, select, textarea').each(function () {
                        const name = $(this).attr('name');
                        if (name) {
                            $(this).attr('name', name.replace(/\[\d+\]/, `[${index}]`));
                        }
                    });
                });
            } else {
                toastr.warning('Cần ít nhất một kế hoạch', 'Cảnh báo');
            }
        });

        // Xử lý form kế hoạch
        $('#kehoach-form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend: function () {
                    $('#kehoach-form button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Đang lưu...');
                },
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message || 'Đã lưu kế hoạch thành công', 'Thành công');
                    } else {
                        toastr.error(response.message || 'Có lỗi xảy ra', 'Lỗi');
                    }
                },
                error: function (xhr) {
                    let message = 'Có lỗi xảy ra khi xử lý yêu cầu';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                        if (xhr.responseJSON.errors) {
                            message += ': ' + Object.values(xhr.responseJSON.errors).flat().join(', ');
                        }
                    }
                    toastr.error(message, 'Lỗi');
                },
                complete: function () {
                    $('#kehoach-form button[type="submit"]').prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Lưu kế hoạch');
                }
            });
        });

        // Xử lý thêm kiến nghị
        $('#add-kiennghi').on('click', function () {
            const count = $('#kiennghi-container .kiennghi-card').length;
            const template = `
                <div class="card mb-3 kiennghi-card">
                    <div class="card-header bg-light">
                        <div class="row">
                            <div class="col">
                                <h6 class="m-0">Kiến nghị #${count + 1}</h6>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-danger btn-sm remove-kiennghi">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Tiêu đề</label>
                            <input type="text" class="form-control" name="kiennghi[${count}][tieu_de]" value="" required>
                            <input type="hidden" name="kiennghi[${count}][id]" value="0">
                        </div>
                        <div class="form-group">
                            <label>Nội dung</label>
                            <textarea class="form-control" name="kiennghi[${count}][noi_dung]" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Người đề xuất</label>
                            <select class="form-control select2-new" name="kiennghi[${count}][nguoi_de_xuat_id]">
                                <option value="">-- Chọn người đề xuất --</option>
                                @if (!empty($tinHuu) && $tinHuu instanceof \Illuminate\Support\Collection && $tinHuu->isNotEmpty())
                                    @foreach ($tinHuu as $tinHuu)
                                        <option value="{{ $tinHuu->id }}">{{ $tinHuu->ho_ten }}</option>
                                    @endforeach
                                @else
                                    <option value="" disabled>Không có tín hữu nào</option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            `;
            $('#kiennghi-container').append(template);
            $('.select2-new').select2({
                theme: 'bootstrap4',
                placeholder: 'Chọn một mục',
                allowClear: true,
                width: '100%'
            }).removeClass('select2-new');
        });

        // Xóa một kiến nghị
        $(document).on('click', '.remove-kiennghi', function () {
            if ($('#kiennghi-container .kiennghi-card').length > 1) {
                $(this).closest('.kiennghi-card').remove();
                // Cập nhật tiêu đề và tên trường
                $('#kiennghi-container .kiennghi-card').each(function (index) {
                    $(this).find('.card-header h6').text(`Kiến nghị #${index + 1}`);
                    $(this).find('input, select, textarea').each(function () {
                        const name = $(this).attr('name');
                        if (name) {
                            $(this).attr('name', name.replace(/\[\d+\]/, `[${index}]`));
                        }
                    });
                });
            } else {
                toastr.warning('Cần ít nhất một kiến nghị', 'Cảnh báo');
            }
        });

        // Xử lý form kiến nghị
        $('#kiennghi-form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend: function () {
                    $('#kiennghi-form button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Đang lưu...');
                },
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message || 'Đã lưu kiến nghị thành công', 'Thành công');
                    } else {
                        toastr.error(response.message || 'Có lỗi xảy ra', 'Lỗi');
                    }
                },
                error: function (xhr) {
                    let message = 'Có lỗi xảy ra khi xử lý yêu cầu';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                        if (xhr.responseJSON.errors) {
                            message += ': ' + Object.values(xhr.responseJSON.errors).flat().join(', ');
                        }
                    }
                    toastr.error(message, 'Lỗi');
                },
                complete: function () {
                    $('#kiennghi-form button[type="submit"]').prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Lưu kiến nghị');
                }
            });
        });

        // Xử lý form đánh giá điểm mạnh
        $('#add-diem-manh-form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend: function () {
                    $('#add-diem-manh-form button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Đang lưu...');
                },
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message || 'Đã thêm điểm mạnh thành công', 'Thành công');
                        $('#modal-add-diem-manh').modal('hide');
                        $('#add-diem-manh-form')[0].reset();
                        refreshDanhGia();
                    } else {
                        toastr.error(response.message || 'Có lỗi xảy ra', 'Lỗi');
                    }
                },
                error: function (xhr) {
                    let message = 'Có lỗi xảy ra khi xử lý yêu cầu';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                        if (xhr.responseJSON.errors) {
                            message += ': ' + Object.values(xhr.responseJSON.errors).flat().join(', ');
                        }
                    }
                    toastr.error(message, 'Lỗi');
                },
                complete: function () {
                    $('#add-diem-manh-form button[type="submit"]').prop('disabled', false).html('Lưu');
                }
            });
        });

        // Xử lý form đánh giá điểm yếu
        $('#add-diem-yeu-form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend: function () {
                    $('#add-diem-yeu-form button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Đang lưu...');
                },
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message || 'Đã thêm điểm cần cải thiện thành công', 'Thành công');
                        $('#modal-add-diem-yeu').modal('hide');
                        $('#add-diem-yeu-form')[0].reset();
                        refreshDanhGia();
                    } else {
                        toastr.error(response.message || 'Có lỗi xảy ra', 'Lỗi');
                    }
                },
                error: function (xhr) {
                    let message = 'Có lỗi xảy ra khi xử lý yêu cầu';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                        if (xhr.responseJSON.errors) {
                            message += ': ' + Object.values(xhr.responseJSON.errors).flat().join(', ');
                        }
                    }
                    toastr.error(message, 'Lỗi');
                },
                complete: function () {
                    $('#add-diem-yeu-form button[type="submit"]').prop('disabled', false).html('Lưu');
                }
            });
        });

        // Tải dữ liệu đánh giá
        function loadDanhGia() {
            const manh_url = "{{ route('api._ban_co_doc_giao_duc.danh_gia_list', ['banType' => 'ban-co-doc-giao-duc']) }}?month={{ $month }}&year={{ $year }}&ban_nganh_id={{ $config['id'] }}&loai=diem_manh";
            const yeu_url = "{{ route('api._ban_co_doc_giao_duc.danh_gia_list', ['banType' => 'ban-co-doc-giao-duc']) }}?month={{ $month }}&year={{ $year }}&ban_nganh_id={{ $config['id'] }}&loai=diem_yeu";

            // Hủy DataTables nếu đã tồn tại
            if ($.fn.DataTable.isDataTable('#diem-manh-table')) {
                $('#diem-manh-table').DataTable().destroy();
            }
            if ($.fn.DataTable.isDataTable('#diem-yeu-table')) {
                $('#diem-yeu-table').DataTable().destroy();
            }

            // Tải dữ liệu điểm mạnh
            $('#diem-manh-table').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: manh_url,
                    type: 'GET'
                },
                columns: [
                    {
                        data: null,
                        render: function (data, type, row, meta) {
                            return meta.row + 1;
                        },
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    { data: 'noi_dung', name: 'noi_dung' },
                    { data: 'nguoi_danh_gia', name: 'nguoi_danh_gia' },
                    {
                        data: 'id',
                        render: function (data) {
                            return '<button class="btn btn-danger btn-sm delete-danh-gia" data-id="' + data + '"><i class="fas fa-trash"></i></button>';
                        },
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ],
                language: {
                    url: '{{ asset("dist/js/Vietnamese.json") }}'
                },
                responsive: true,
                autoWidth: false
            });

            // Tải dữ liệu điểm yếu
            $('#diem-yeu-table').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: yeu_url,
                    type: 'GET'
                },
                columns: [
                    {
                        data: null,
                        render: function (data, type, row, meta) {
                            return meta.row + 1;
                        },
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    { data: 'noi_dung', name: 'noi_dung' },
                    { data: 'nguoi_danh_gia', name: 'nguoi_danh_gia' },
                    {
                        data: 'id',
                        render: function (data) {
                            return '<button class="btn btn-danger btn-sm delete-danh-gia" data-id="' + data + '"><i class="fas fa-trash"></i></button>';
                        },
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ],
                language: {
                    url: '{{ asset("dist/js/Vietnamese.json") }}'
                },
                responsive: true,
                autoWidth: false
            });
        }

        // Cập nhật dữ liệu đánh giá
        function refreshDanhGia() {
            loadDanhGia();
        }

        // Xóa đánh giá
        $(document).on('click', '.delete-danh-gia', function () {
            const id = $(this).data('id');
            // Sử dụng placeholder và thay thế bằng id
            const url = "{{ route('api._ban_co_doc_giao_duc.xoa_danh_gia', ['banType' => 'ban-co-doc-giao-duc', 'id' => ':id']) }}".replace(':id', id);

            Swal.fire({
                title: 'Xác nhận xóa',
                text: 'Bạn có chắc chắn muốn xóa đánh giá này?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        method: 'DELETE',
                        data: { _token: "{{ csrf_token() }}" },
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                toastr.success(response.message || 'Đã xóa đánh giá thành công', 'Thành công');
                                refreshDanhGia();
                            } else {
                                toastr.error(response.message || 'Có lỗi xảy ra', 'Lỗi');
                            }
                        },
                        error: function (xhr) {
                            let message = 'Có lỗi xảy ra khi xử lý yêu cầu';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            }
                            toastr.error(message, 'Lỗi');
                        }
                    });
                }
            });
        });

        // Khởi tạo DataTables khi trang tải xong
        loadDanhGia();

        // Cấu hình toastr
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 3000
        };

        // Nhấp vào tab
        $('#baocao-tabs a').on('click', function (e) {
            e.preventDefault();
            $(this).tab('show');
        });

        // Lưu trạng thái tab khi chuyển tab
        $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
            localStorage.setItem('activeReportTab', $(e.target).attr('id'));
        });

        // Khôi phục tab đã chọn trước đó
        var activeTab = localStorage.getItem('activeReportTab');
        if (activeTab) {
            $('#baocao-tabs #' + activeTab).tab('show');
        }
    });
</script>
@endsection