@extends('layouts.app')
@section('title', 'Thêm/Sửa Buổi Nhóm')

@section('content')
    <div class="container">
        <h2>Thêm/Sửa Buổi Nhóm</h2>

        <form id="buoi-nhom-form" action="{{ route('buoi_nhom.store') }}" method="POST">
            @csrf
            <input type="hidden" id="buoi_nhom_id" name="id"> {{-- Hidden input cho ID khi sửa --}}

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Phần 1: Thông Tin Chung</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="lich_buoi_nhom_id">Chọn Buổi Nhóm Lịch</label>
                        <select class="form-control select2" id="lich_buoi_nhom_id" name="lich_buoi_nhom_id" style="width: 100%;" required>
                            <option value="">-- Chọn Lịch --</option>
                            @foreach ($lichBuoiNhoms as $lich)
                                <option value="{{ $lich->id }}">{{ $lich->ten }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ban_nganh_id">Chọn Ban Ngành</label>
                        <select class="form-control select2" id="ban_nganh_id" name="ban_nganh_id" style="width: 100%;" required>
                            <option value="">-- Chọn Ban Ngành --</option>
                            @foreach ($banNganhs as $banNganh)
                                <option value="{{ $banNganh->id }}">{{ $banNganh->ten }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ngay_dien_ra">Ngày Diễn Ra</label>
                        <input type="date" class="form-control" id="ngay_dien_ra" name="ngay_dien_ra" required>
                    </div>
                    <div class="form-group">
                        <label for="gio_bat_dau">Giờ Bắt Đầu</label>
                        <input type="time" class="form-control" id="gio_bat_dau" name="gio_bat_dau" required>
                    </div>
                    <div class="form-group">
                        <label for="gio_ket_thuc">Giờ Kết Thúc</label>
                        <input type="time" class="form-control" id="gio_ket_thuc" name="gio_ket_thuc" required>
                    </div>
                    <div class="form-group">
                        <label for="dia_diem">Địa Điểm</label>
                        <input type="text" class="form-control" id="dia_diem" name="dia_diem">
                    </div>
                    <div class="form-group">
                        <label for="chu_de">Chủ Đề</label>
                        <input type="text" class="form-control" id="chu_de" name="chu_de">
                    </div>
                    <div class="form-group">
                        <label for="dien_gia_id">Diễn Giả</label>
                        <select class="form-control select2" id="dien_gia_id" name="dien_gia_id" style="width: 100%;">
                            <option value="">-- Chọn Diễn Giả --</option>
                            @foreach ($dienGias as $dienGia)
                                <option value="{{ $dienGia->id }}">{{ $dienGia->ho_ten }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ghi_chu">Ghi Chú</label>
                        <textarea class="form-control" id="ghi_chu" name="ghi_chu" rows="3"></textarea>
                    </div>
                </div>
            </div>

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Phần 2: Chọn Người Phụ Trách</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="id_tin_huu_hdct">Người Hướng Dẫn</label>
                        <select class="form-control select2" id="id_tin_huu_hdct" name="id_tin_huu_hdct" style="width: 100%;">
                            <option value="">-- Chọn Người Hướng Dẫn --</option>
                            {{-- Options sẽ được tải bằng Ajax --}}
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_tin_huu_do_kt">Người Đọc Kinh Thánh</label>
                        <select class="form-control select2" id="id_tin_huu_do_kt" name="id_tin_huu_do_kt" style="width: 100%;">
                            <option value="">-- Chọn Người Đọc Kinh Thánh --</option>
                            {{-- Options sẽ được tải bằng Ajax --}}
                        </select>
                    </div>
                </div>
            </div>

            <div class="card card-success">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary" id="submit-btn">Thêm</button>
                    <button type="button" class="btn btn-secondary" id="reset-btn">Làm Mới</button>
                </div>
            </div>
        </form>

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
            // Initialize Select2
            $('.select2').select2();

            // Load danh sách buổi nhóm khi trang tải
            loadBuoiNhoms();

            // Xử lý sự kiện thay đổi Ban Ngành
            const banNganhSelect = $('#ban_nganh_id'); // Lưu tham chiếu đến select
            banNganhSelect.change(async function() { // **Sử dụng async**
                let banNganhId = $(this).val();
                resetTinHuuSelects(); // **Làm mới select trước khi tải dữ liệu mới**
                if (banNganhId) {
                    await loadTinHuuOptions(banNganhId, '#id_tin_huu_hdct'); // **Sử dụng await**
                    await loadTinHuuOptions(banNganhId, '#id_tin_huu_do_kt'); // **Sử dụng await**
                }
            });

            // Hàm tải options cho select TinHuu
            function loadTinHuuOptions(banNganhId, selectElementId) {
                return new Promise((resolve) => { // **Trả về Promise**
                    $.ajax({
                        url: '/get-tin-huu-by-ban-nganh/' + banNganhId, // Route cần định nghĩa
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            let select = $(selectElementId);
                            select.empty().append('<option value="">-- Chọn --</option>');
                            $.each(data, function(key, value) {
                                select.append('<option value="' + value.id + '">' + value.ho_ten + '</option>');
                            });
                            resolve(); // **Giải quyết Promise khi hoàn thành**
                        }
                    });
                });
            }

            // Xử lý submit form
            $('#buoi-nhom-form').submit(async function(e) { // **Sử dụng async**
                e.preventDefault();
                let formData = $(this).serialize();
                let url = $(this).attr('action');
                let type = $('#buoi_nhom_id').val() ? 'PUT' : 'POST'; // Xác định là thêm hay sửa

                try { // **Sử dụng try-catch để bắt lỗi**
                    const response = await $.ajax({ // **Sử dụng await**
                        url: url,
                        type: type,
                        data: formData,
                        dataType: 'json'
                    });

                    if (response.success) {
                        alert(response.message);
                        $('#buoi-nhom-form')[0].reset();
                        resetTinHuuSelects();
                        loadBuoiNhoms();
                    } else {
                        alert('Lỗi: ' + response.message);
                    }
                } catch (error) { // **Bắt lỗi Ajax**
                    console.error(error);
                    alert('Đã xảy ra lỗi khi xử lý.');
                }
            });

            // Hàm tải danh sách buổi nhóm
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
                        }
                    }
                });
            }

            // Xử lý sự kiện click nút Sửa
            $(document).on('click', '.edit-btn', async function() { // **Sử dụng async**
                let id = $(this).data('id');
                try {
                    const data = await $.ajax({ // **Sử dụng await**
                        url: '/get-buoi-nhom/' + id, // Route cần định nghĩa
                        type: 'GET',
                        dataType: 'json'
                    });

                    $('#buoi_nhom_id').val(data.id);
                    $('#lich_buoi_nhom_id').val(data.lich_buoi_nhom_id).trigger('change');
                    banNganhSelect.val(data.ban_nganh_id).trigger('change');
                    $('#ngay_dien_ra').val(data.ngay_dien_ra);
                    $('#gio_bat_dau').val(data.gio_bat_dau);
                    $('#gio_ket_thuc').val(data.gio_ket_thuc);
                    $('#chu_de').val(data.chu_de);
                    $('#dien_gia_id').val(data.dien_gia_id).trigger('change');
                    $('#id_tin_huu_hdct').val(data.id_tin_huu_hdct).trigger('change');
                    $('#id_tin_huu_do_kt').val(data.id_tin_huu_do_kt).trigger('change');
                    $('#dia_diem').val(data.dia_diem);
                    $('#ghi_chu').val(data.ghi_chu);
                    $('#submit-btn').text('Cập Nhật');
                    window.scrollTo({ top: 0, behavior: 'smooth' }); // Cuộn lên đầu trang
                } catch (error) { // **Bắt lỗi Ajax**
                    console.error(error);
                    alert('Đã xảy ra lỗi khi tải dữ liệu.');
                }
            });

            // Xử lý sự kiện click nút Xóa
            $(document).on('click', '.delete-btn', async function() { // **Sử dụng async**
                let id = $(this).data('id');
                if (confirm('Bạn có chắc chắn muốn xóa?')) {
                    try {
                        const response = await $.ajax({ // **Sử dụng await**
                            url: '/delete-buoi-nhom/' + id, // Route cần định nghĩa
                            type: 'DELETE',
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        if (response.success) {
                            alert(response.message);
                            loadBuoiNhoms();
                        } else {
                            alert('Lỗi: ' + response.message);
                        }
                    } catch (error) { // **Bắt lỗi Ajax**
                        console.error(error);
                        alert('Đã xảy ra lỗi khi xóa.');
                    }
                }
            });

            // Xử lý nút làm mới form
            $('#reset-btn').click(function() {
                $('#buoi-nhom-form')[0].reset();
                $('#buoi_nhom_id').val('');
                $('#submit-btn').text('Thêm');
                resetTinHuuSelects();
            });

            // Hàm reset các select TinHuu
            function resetTinHuuSelects() {
                $('#id_tin_huu_hdct').empty().append('<option value="">-- Chọn Người Hướng Dẫn --</option>');
                $('#id_tin_huu_do_kt').empty().append('<option value="">-- Chọn Người Đọc Kinh Thánh --</option>');
            }

        });
    </script>
@endsection