{{-- File: resources/views/_buoi_nhom/create.blade.php --}}
@extends('layouts.app')
@section('title', 'Quản lý Buổi Nhóm & Số Lượng')

@section('content')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@yield('title')</h1>
            </div>
            <div class="col-sm-6">
                <a href="{{ route('buoi_nhom.index') }}" class="btn btn-secondary float-sm-right"
                    title="Quay lại Danh sách Buổi nhóm">
                    <i class="fas fa-list"></i> Danh sách
                </a>
            </div>
        </div>

        <div class="row">
            {{-- ========================= Phần 1: Tạo Buổi Nhóm Mới ========================= --}}
            <div class="col-md-12">
                <div class="card card-primary card-outline collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-plus-circle"></i> Tạo Buổi Nhóm Mới</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Mở rộng/Thu gọn">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" style="display: none;">
                        <form id="create-buoi-nhom-form" action="{{ route('api.buoi_nhom.store') }}" method="POST"
                            novalidate>
                            @csrf
                            <input type="hidden" name="trang_thai" value="0"> <!-- Thêm trường trang_thai mặc định -->
                            <div class="row">
                                {{-- Cột Trái --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="create_lich_buoi_nhom_id">Lịch Buổi Nhóm</label>
                                        <select name="lich_buoi_nhom_id" id="create_lich_buoi_nhom_id"
                                            class="form-control select2bs4-create" required>
                                            <option value="">-- Chọn Lịch --</option>
                                            @foreach($lichBuoiNhoms as $lich)
                                                <option value="{{ $lich->id }}">{{ $lich->ten }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="create_ban_nganh_id">Ban Ngành</label>
                                        <select name="ban_nganh_id" id="create_ban_nganh_id"
                                            class="form-control select2bs4-create" required>
                                            <option value="">-- Chọn Ban Ngành --</option>
                                            @foreach($banNganhs as $banNganh)
                                                <option value="{{ $banNganh->id }}">{{ $banNganh->ten }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="create_ngay_dien_ra">Ngày Diễn Ra</label>
                                        <input type="date" name="ngay_dien_ra" id="create_ngay_dien_ra" class="form-control"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="create_gio_bat_dau">Giờ Bắt Đầu</label>
                                        <input type="time" name="gio_bat_dau" id="create_gio_bat_dau" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="create_gio_ket_thuc">Giờ Kết Thúc</label>
                                        <input type="time" name="gio_ket_thuc" id="create_gio_ket_thuc"
                                            class="form-control">
                                    </div>
                                </div>
                                {{-- Cột Phải --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="create_chu_de">Chủ Đề</label>
                                        <input type="text" name="chu_de" id="create_chu_de" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="create_dien_gia_id">Diễn Giả</label>
                                        <select name="dien_gia_id" id="create_dien_gia_id"
                                            class="form-control select2bs4-create">
                                            <option value="">-- Chọn Diễn Giả --</option>
                                            @foreach($dienGias as $dienGia)
                                                <option value="{{ $dienGia->id }}">{{ $dienGia->ho_ten }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="create_id_tin_huu_hdct">Người Hướng Dẫn</label>
                                        <select name="id_tin_huu_hdct" id="create_id_tin_huu_hdct"
                                            class="form-control select2bs4-create">
                                            <option value="">-- Chọn Người Hướng Dẫn --</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="create_id_tin_huu_do_kt">Người Đố Kinh Thánh</label>
                                        <select name="id_tin_huu_do_kt" id="create_id_tin_huu_do_kt"
                                            class="form-control select2bs4-create">
                                            <option value="">-- Chọn Người Đố Kinh Thánh --</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="create_dia_diem">Địa Điểm</label>
                                        <input type="text" name="dia_diem" id="create_dia_diem" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="create_ghi_chu">Ghi Chú</label>
                                        <textarea name="ghi_chu" id="create_ghi_chu" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-light border-top text-right">
                                <button type="submit" class="btn btn-primary" id="create-submit-btn"><i
                                        class="fas fa-plus"></i> Thêm Buổi Nhóm</button>
                                <a href="{{ route('buoi_nhom.index') }}" class="btn btn-secondary"><i
                                        class="fas fa-list"></i> Xem Danh sách</a>
                                <button type="reset" class="btn btn-default" id="create-reset-btn"><i
                                        class="fas fa-sync-alt"></i> Làm mới Form</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- ====================== Phần 2: Điền/Sửa Số Lượng Tham Gia ====================== --}}
            <div class="col-md-12">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-users"></i> Điền/Sửa Số Lượng Tham Gia</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Mở rộng/Thu gọn">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="update-counts-form" action="#" method="POST" novalidate>
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-sm-right">Lọc theo Tháng/Năm:</label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <select class="form-control" id="filter_month" name="filter_month">
                                                @for ($i = 1; $i <= 12; $i++)
                                                    <option value="{{ $i }}" {{ $i == now()->month ? 'selected' : '' }}>{{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <select class="form-control" id="filter_year" name="filter_year">
                                                @php
                                                    $currentYear = now()->year;
                                                    $startYear = $currentYear - 5; // Hiển thị 5 năm trước
                                                    $endYear = $currentYear + 5;   // Hiển thị 5 năm sau
                                                @endphp
                                                @for ($year = $startYear; $year <= $endYear; $year++)
                                                    <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>
                                                        {{ $year }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="select_buoi_nhom_for_counts" class="col-sm-3 col-form-label text-sm-right">Chọn
                                    Buổi Nhóm:</label>
                                <div class="col-sm-9">
                                    <select class="form-control select2bs4-counts" id="select_buoi_nhom_for_counts"
                                        name="buoi_nhom_id_selected" style="width: 100%;" required
                                        data-placeholder="-- Chọn buổi nhóm để điền/sửa số lượng --">
                                        <option value=""></option>
                                    </select>
                                    <div class="invalid-feedback d-block" id="select-buoi-nhom-error"
                                        style="display: none;">Vui lòng chọn buổi nhóm.</div>
                                </div>
                            </div>
                            <div id="count-fields-container" class="mt-4" style="display: none;">
                                <input type="hidden" id="buoi_nhom_id_for_counts" name="buoi_nhom_id">
                                <h5 class="mb-3 text-info font-weight-bold" id="form-counts-title">Nhập số lượng cho buổi
                                    nhóm đã chọn:</h5>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        @php
                                            function renderCountInputBlade3($id, $label, $name)
                                            {
                                                echo '<div class="form-group row mb-2">';
                                                echo '<label for="' . $id . '" class="col-sm-7 col-form-label col-form-label-sm">' . $label . ':</label>';
                                                echo '<div class="col-sm-5">';
                                                echo '<input type="number" min="0" step="1" class="form-control form-control-sm count-input" id="' . $id . '" name="' . $name . '" value="0">';
                                                echo '</div>';
                                                echo '</div>';
                                            }
                                        @endphp
                                        {{ renderCountInputBlade3('so_luong_trung_lao', 'Trung Lão', 'so_luong_trung_lao') }}
                                        {{ renderCountInputBlade3('so_luong_thanh_trang', 'Thanh Tráng', 'so_luong_thanh_trang') }}
                                        {{ renderCountInputBlade3('so_luong_thanh_nien', 'Thanh Niên', 'so_luong_thanh_nien') }}
                                        {{ renderCountInputBlade3('so_luong_thieu_nhi_au', 'Thiếu Nhi/Ấu', 'so_luong_thieu_nhi_au') }}
                                    </div>
                                    <div class="col-md-6">
                                        {{ renderCountInputBlade3('so_luong_tin_huu_khac', 'Tín hữu Khác', 'so_luong_tin_huu_khac') }}
                                        {{ renderCountInputBlade3('so_luong_tin_huu', 'Tổng Số Tín Hữu (*)', 'so_luong_tin_huu') }}
                                        {{ renderCountInputBlade3('so_luong_than_huu', 'Thân Hữu', 'so_luong_than_huu') }}
                                        {{ renderCountInputBlade3('so_nguoi_tin_chua', 'Số người Tin Chúa', 'so_nguoi_tin_chua') }}
                                    </div>
                                </div>
                                <p class="text-muted"><small>(*) Tổng số tín hữu có thể tự động tính hoặc nhập thủ
                                        công.</small></p>
                                <div class="text-right">
                                    <button type="button" class="btn btn-secondary" id="update-counts-cancel-btn"
                                        style="display: none;"><i class="fas fa-times"></i> Hủy Sửa</button>
                                </div>
                            </div>
                            <div class="card-footer bg-light border-top text-right mt-3">
                                <button type="submit" class="btn btn-info" id="update-counts-submit-btn"><i
                                        class="fas fa-save"></i> Cập nhật Số Lượng</button>
                                <a href="{{ route('buoi_nhom.index') }}" class="btn btn-secondary"><i
                                        class="fas fa-list"></i> Xem Danh sách</a>
                            </div>
                        </form>

                        {{-- ====================== Bảng Hiển thị Số Lượng ====================== --}}
                        <div class="mt-5">
                            <h4 class="mb-3"><i class="fas fa-table"></i> Danh sách số lượng đã nhập</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm" id="counts-table">
                                    <thead>
                                        <tr>
                                            <th>ID Buổi Nhóm</th>
                                            <th>Tên Ban Ngành</th>
                                            <th>Ngày</th>
                                            <th>Chủ Đề</th>
                                            <th>Tr.Lão</th>
                                            <th>T.Tráng</th>
                                            <th>T.Niên</th>
                                            <th>T.Nhi/Ấu</th>
                                            <th>TH Khác</th>
                                            <th>Tổng TH</th>
                                            <th>Thân Hữu</th>
                                            <th>Tin Chúa</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody id="counts-table-body">
                                        <tr>
                                            <td colspan="13" class="text-center">Đang tải dữ liệu...</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- ====================== Hết Bảng ====================== --}}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            console.log('Script for _buoi_nhom/create.blade.php executing independently.');

            // Kiểm tra các thư viện cần thiết
            if (typeof $ === 'undefined') {
                console.error('jQuery is not loaded.');
                return;
            }
            if (typeof $.fn.select2 === 'undefined') {
                console.error('Select2 is not loaded.');
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
            const debounce = (func, wait) => {
                let timeout;
                return function (...args) {
                    const later = () => { clearTimeout(timeout); func.apply(this, args); };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            };

            const loadTinHuuOptionsLocal = (banNganhId, selectElement, placeholder) => {
                const defaultPlaceholder = '-- Vui lòng chọn --';
                const targetPlaceholder = placeholder || selectElement.data('placeholder') || defaultPlaceholder;
                if (!selectElement || !selectElement.length) {
                    console.error("Target select element missing.");
                    return Promise.reject("Target select missing.");
                }
                if (!banNganhId) {
                    selectElement.empty().append('<option value=""></option>').val(null).trigger('change');
                    selectElement.select2({ placeholder: '-- Chọn Ban Ngành trước --', theme: 'bootstrap4', width: '100%', allowClear: true });
                    return Promise.resolve();
                }
                let url;
                try {
                    url = '{{ route("api.tin_huu.by_ban_nganh", ["ban_nganh_id" => "__ID__"]) }}'.replace('__ID__', encodeURIComponent(banNganhId));
                } catch (e) {
                    console.error("Route error:", e);
                    url = `/api/tin-huu/by-ban-nganh/${encodeURIComponent(banNganhId)}`;
                }
                console.log(`Loading Tin Huu: ${url} for #${selectElement.attr('id')}`);
                selectElement.prop('disabled', true).empty().append('<option value="">Đang tải...</option>').trigger('change.select2');
                selectElement.select2({ placeholder: 'Đang tải...', theme: 'bootstrap4', width: '100%' });
                return $.ajax({
                    url: url,
                    method: 'GET',
                    dataType: 'json'
                }).done(data => {
                    selectElement.empty().append(`<option value=""></option>`);
                    if (Array.isArray(data) && data.length > 0) {
                        data.forEach(item => {
                            if (item && item.id && item.ho_ten) {
                                selectElement.append(new Option(item.ho_ten, item.id));
                            }
                        });
                    } else {
                        selectElement.append('<option value="" disabled>Không có tín hữu</option>');
                    }
                }).fail(error => {
                    console.error(`Load Tin Huu Fail #${selectElement.attr('id')}:`, error.status, error.statusText, error.responseText);
                    selectElement.empty().append('<option value="" disabled>Lỗi tải dữ liệu tín hữu</option>');
                }).always(() => {
                    selectElement.prop('disabled', false).val(null).trigger('change');
                    selectElement.select2({ placeholder: targetPlaceholder, theme: 'bootstrap4', width: '100%', allowClear: true });
                });
            };

            const getNextSunday = () => {
                const d = new Date();
                let daysUntilSunday = (7 - d.getDay()) % 7;
                if (daysUntilSunday === 0) daysUntilSunday = 7;
                d.setDate(d.getDate() + daysUntilSunday);
                return d.toISOString().split('T')[0];
            };

            const showAlert = (message, type = 'info') => {
                alert(`[${type.toUpperCase()}] ${message}`);
            };

            const formatDate = (dateStr) => {
                try {
                    return dateStr ? moment(dateStr).format('DD/MM/YY') : 'N/A';
                } catch (e) {
                    console.error('Error formatting date:', e);
                    return 'N/A';
                }
            };

            const escapeHtml = (unsafe) => {
                if (!unsafe) return '';
                const htmlEntities = {
                    '&': '&',
                    '<': '<',
                    '>': '>',
                    '"': '"',
                    "'": "'",
                    '\\': '\\\\',
                    '\n': '\\n',
                    '\r': '\\r',
                    '\t': '\\t',
                    '\0': ''
                };
                return unsafe.toString().replace(/[&<>"'\\\n\r\t\0]/g, char => htmlEntities[char]);
            };

            // Hàm mã hóa JSON an toàn để tránh lỗi cú pháp trong template string
            const encodeJsonForHtml = (jsonStr) => {
                return jsonStr
                    .replace(/"/g, '"')
                    .replace(/'/g, "'")
                    .replace(/</g, "<")
                    .replace(/>/g, ">")
                    .replace(/\\/g, "\\\\")
                    .replace(/\n/g, "\\n")
                    .replace(/\r/g, "\\r")
                    .replace(/\t/g, "\\t")
                    .replace(/\0/g, "");
            };

            // ----- Cache Selectors -----
            const createForm = $('#create-buoi-nhom-form');
            const createBanNganhSelect = $('#create_ban_nganh_id');
            const createTinHuuHdctSelect = $('#create_id_tin_huu_hdct');
            const createTinHuuDoKtSelect = $('#create_id_tin_huu_do_kt');
            const createSubmitBtn = $('#create-submit-btn');
            const createDateInput = $('#create_ngay_dien_ra');
            const createResetBtn = $('#create-reset-btn');
            const createSelects = $('.select2bs4-create', createForm);

            const countsForm = $('#update-counts-form');
            const selectBuoiNhom = $('#select_buoi_nhom_for_counts');
            const filterMonthSelect = $('#filter_month');
            const filterYearSelect = $('#filter_year');
            const countsContainer = $('#count-fields-container');
            const updateCountsBtn = $('#update-counts-submit-btn');
            const updateCountsCancelBtn = $('#update-counts-cancel-btn');
            const hiddenBuoiNhomIdInput = $('#buoi_nhom_id_for_counts');
            const selectBuoiNhomError = $('#select-buoi-nhom-error');
            const countInputs = $('input.count-input', countsContainer);
            const countsTableBody = $('#counts-table-body');
            const formCountsTitle = $('#form-counts-title');

            // ----- Initialize Plugins -----
            $('.select2bs4-create, .select2bs4-counts').select2({ theme: 'bootstrap4', width: '100%', allowClear: true });

            // ----- Part 1: Create Buoi Nhom -----
            const resetCreateTinHuuSelects = () => {
                const placeholder = '-- Chọn Ban Ngành trước --';
                createTinHuuHdctSelect.empty().append(`<option value=""></option>`).val(null).trigger('change');
                createTinHuuDoKtSelect.empty().append(`<option value=""></option>`).val(null).trigger('change');
                createTinHuuHdctSelect.select2({ placeholder: placeholder, theme: 'bootstrap4', width: '100%' });
                createTinHuuDoKtSelect.select2({ placeholder: placeholder, theme: 'bootstrap4', width: '100%' });
            };

            if (createDateInput.length && !createDateInput.val()) {
                createDateInput.val(getNextSunday());
            }

            createBanNganhSelect.on('change', debounce(function () {
                const banNganhId = $(this).val();
                resetCreateTinHuuSelects();
                if (banNganhId) {
                    loadTinHuuOptionsLocal(banNganhId, createTinHuuHdctSelect, '-- Chọn Người Hướng Dẫn --');
                    loadTinHuuOptionsLocal(banNganhId, createTinHuuDoKtSelect, '-- Chọn Người Đọc KT --');
                }
            }, 350));

            createResetBtn.on('click', function () {
                setTimeout(() => {
                    createSelects.val(null).trigger('change');
                    resetCreateTinHuuSelects();
                    if (createDateInput.length) createDateInput.val(getNextSunday());
                    $('#create_lich_buoi_nhom_id').select2({ placeholder: '-- Chọn Lịch Buổi Nhóm --', theme: 'bootstrap4', width: '100%', allowClear: true });
                    $('#create_ban_nganh_id').select2({ placeholder: '-- Chọn Ban Ngành --', theme: 'bootstrap4', width: '100%', allowClear: true });
                    $('#create_dien_gia_id').select2({ placeholder: '-- Chọn Diễn Giả (nếu có) --', theme: 'bootstrap4', width: '100%', allowClear: true });
                    console.log('Create form reset.');
                }, 0);
            });

            createForm.on('submit', function (e) {
                e.preventDefault();
                const form = $(this);
                const url = form.attr('action');
                const method = form.attr('method');
                const data = form.serialize();

                // Log dữ liệu gửi lên để kiểm tra
                console.log('Dữ liệu gửi lên:', data);

                createSubmitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang thêm...');
                $.ajax({
                    url: url,
                    method: method,
                    data: data,
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            showAlert(response.message || 'Thêm buổi nhóm thành công!', 'success');
                            createResetBtn.click();
                            loadBuoiNhomsForSelectAndTable();
                        } else {
                            showAlert(response.message || 'Không thể thêm buổi nhóm.');
                        }
                    },
                    error: function (jqXHR) {
                        console.error("Ajax Error (Create Form):", jqXHR.status, jqXHR.statusText, jqXHR.responseText);
                        let errorMsg = `Lỗi ${jqXHR.status}. Không thể thêm buổi nhóm.`;
                        if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                            errorMsg = `Lỗi: ${jqXHR.responseJSON.message}`;
                        } else if (jqXHR.responseJSON && jqXHR.responseJSON.errors) {
                            errorMsg += "\nLỗi dữ liệu:";
                            $.each(jqXHR.responseJSON.errors, function (key, value) {
                                errorMsg += `\n- ${value.join(', ')}`;
                            });
                        }
                        showAlert(errorMsg);
                    },
                    complete: function () {
                        createSubmitBtn.prop('disabled', false).html('<i class="fas fa-plus"></i> Thêm Buổi Nhóm');
                    }
                });
            });

            // ----- Part 2: Update Counts -----
            const resetCountsForm = () => {
                selectBuoiNhom.val(null).trigger('change');
                hiddenBuoiNhomIdInput.val('');
                countsForm.attr('action', '#');
                countInputs.val(0);
                countsContainer.slideUp();
                updateCountsBtn.prop('disabled', true);
                updateCountsBtn.html('<i class="fas fa-save"></i> Cập nhật Số Lượng');
                updateCountsCancelBtn.hide();
                formCountsTitle.text('Nhập số lượng cho buổi nhóm đã chọn:');
                selectBuoiNhomError.hide();
            };

            const populateCountsTable = (buoiNhomData) => {
                countsTableBody.empty();
                if (!Array.isArray(buoiNhomData) || buoiNhomData.length === 0) {
                    const month = filterMonthSelect.val();
                    const year = filterYearSelect.val();
                    countsTableBody.append(`<tr><td colspan="13" class="text-center">Không có buổi nhóm nào trong tháng ${month}/${year}.</td></tr>`);
                    return;
                }

                buoiNhomData.forEach(bn => {
                    const counts = {
                        so_luong_trung_lao: bn.so_luong_trung_lao ?? 0,
                        so_luong_thanh_trang: bn.so_luong_thanh_trang ?? 0,
                        so_luong_thanh_nien: bn.so_luong_thanh_nien ?? 0,
                        so_luong_thieu_nhi_au: bn.so_luong_thieu_nhi_au ?? 0,
                        so_luong_tin_huu_khac: bn.so_luong_tin_huu_khac ?? 0,
                        so_luong_tin_huu: bn.so_luong_tin_huu ?? 0,
                        so_luong_than_huu: bn.so_luong_than_huu ?? 0,
                        so_nguoi_tin_chua: bn.so_nguoi_tin_chua ?? 0
                    };
                    const countsJsonString = JSON.stringify(counts);
                    const safeCountsJsonString = encodeJsonForHtml(countsJsonString); // Mã hóa an toàn

                    const banNganhName = bn.ban_nganh?.ten || 'N/A';
                    const displayDate = formatDate(bn.ngay_dien_ra);

                    // Sử dụng DOM manipulation để tạo hàng
                    const row = document.createElement('tr');
                    row.setAttribute('data-id', bn.id);
                    row.setAttribute('data-counts', safeCountsJsonString);

                    // Cột ID Buổi Nhóm
                    const idCell = document.createElement('td');
                    idCell.textContent = bn.id;
                    row.appendChild(idCell);

                    // Cột Tên Ban Ngành
                    const banNganhCell = document.createElement('td');
                    banNganhCell.textContent = escapeHtml(banNganhName);
                    row.appendChild(banNganhCell);

                    // Cột Ngày
                    const dateCell = document.createElement('td');
                    dateCell.textContent = displayDate;
                    row.appendChild(dateCell);

                    // Cột Chủ Đề
                    const chuDeCell = document.createElement('td');
                    chuDeCell.textContent = escapeHtml(bn.chu_de) || 'N/A';
                    row.appendChild(chuDeCell);

                    // Cột Tr.Lão
                    const trungLaoCell = document.createElement('td');
                    trungLaoCell.textContent = counts.so_luong_trung_lao;
                    row.appendChild(trungLaoCell);

                    // Cột T.Tráng
                    const thanhTrangCell = document.createElement('td');
                    thanhTrangCell.textContent = counts.so_luong_thanh_trang;
                    row.appendChild(thanhTrangCell);

                    // Cột T.Niên
                    const thanhNienCell = document.createElement('td');
                    thanhNienCell.textContent = counts.so_luong_thanh_nien;
                    row.appendChild(thanhNienCell);

                    // Cột T.Nhi/Ấu
                    const thieuNhiAuCell = document.createElement('td');
                    thieuNhiAuCell.textContent = counts.so_luong_thieu_nhi_au;
                    row.appendChild(thieuNhiAuCell);

                    // Cột TH Khác
                    const tinHuuKhacCell = document.createElement('td');
                    tinHuuKhacCell.textContent = counts.so_luong_tin_huu_khac;
                    row.appendChild(tinHuuKhacCell);

                    // Cột Tổng TH
                    const tongTinHuuCell = document.createElement('td');
                    tongTinHuuCell.textContent = counts.so_luong_tin_huu;
                    row.appendChild(tongTinHuuCell);

                    // Cột Thân Hữu
                    const thanHuuCell = document.createElement('td');
                    thanHuuCell.textContent = counts.so_luong_than_huu;
                    row.appendChild(thanHuuCell);

                    // Cột Tin Chúa
                    const tinChuaCell = document.createElement('td');
                    tinChuaCell.textContent = counts.so_nguoi_tin_chua;
                    row.appendChild(tinChuaCell);

                    // Cột Hành động
                    const actionCell = document.createElement('td');

                    // Nút Sửa số lượng
                    const editButton = document.createElement('button');
                    editButton.type = 'button';
                    editButton.className = 'btn btn-warning btn-sm edit-counts-btn';
                    editButton.title = 'Sửa số lượng';
                    editButton.innerHTML = '<i class="fas fa-pencil-alt"></i>';
                    actionCell.appendChild(editButton);

                    // Nút Xóa số lượng
                    const deleteButton = document.createElement('button');
                    deleteButton.type = 'button';
                    deleteButton.className = 'btn btn-danger btn-sm delete-counts-btn';
                    deleteButton.title = 'Xóa số lượng (đặt về 0)';
                    deleteButton.innerHTML = '<i class="fas fa-trash-alt"></i>';
                    actionCell.appendChild(deleteButton);

                    row.appendChild(actionCell);

                    countsTableBody[0].appendChild(row);
                });
            };

            let cachedBuoiNhomData = [];
            const loadBuoiNhomsForSelectAndTable = (month = null, year = null) => {
                month = month || filterMonthSelect.val();
                year = year || filterYearSelect.val();

                let selectUrl = '{{ route("api.buoi_nhom.list") }}?include_counts=1';
                if (month && year) {
                    selectUrl += `&month=${month}&year=${year}`;
                }
                console.log('Loading Buoi Nhoms for select & table:', selectUrl);

                selectBuoiNhom.prop('disabled', true).empty().append('<option value="">Đang tải...</option>').trigger('change');
                selectBuoiNhom.select2({ placeholder: 'Đang tải...', theme: 'bootstrap4', width: '100%' });
                countsContainer.hide();
                updateCountsBtn.prop('disabled', true);
                countsTableBody.html('<tr><td colspan="13" class="text-center"><i class="fas fa-spinner fa-spin"></i> Đang tải...</td></tr>');

                return $.ajax({
                    url: selectUrl,
                    method: 'GET',
                    dataType: 'json'
                }).done(function (data) {
                    console.log('Data received:', data);
                    cachedBuoiNhomData = Array.isArray(data) ? data : [];
                    selectBuoiNhom.empty().append('<option value=""></option>');
                    if (cachedBuoiNhomData.length > 0) {
                        cachedBuoiNhomData.sort((a, b) => new Date(b.ngay_dien_ra) - new Date(a.ngay_dien_ra));
                        cachedBuoiNhomData.forEach(function (bn) {
                            const counts = {
                                so_luong_trung_lao: bn.so_luong_trung_lao ?? 0,
                                so_luong_thanh_trang: bn.so_luong_thanh_trang ?? 0,
                                so_luong_thanh_nien: bn.so_luong_thanh_nien ?? 0,
                                so_luong_thieu_nhi_au: bn.so_luong_thieu_nhi_au ?? 0,
                                so_luong_tin_huu_khac: bn.so_luong_tin_huu_khac ?? 0,
                                so_luong_tin_huu: bn.so_luong_tin_huu ?? 0,
                                so_luong_than_huu: bn.so_luong_than_huu ?? 0,
                                so_nguoi_tin_chua: bn.so_nguoi_tin_chua ?? 0
                            };
                            const countsJsonString = JSON.stringify(counts);
                            const safeCountsJsonString = encodeJsonForHtml(countsJsonString); // Mã hóa an toàn
                            const displayDate = formatDate(bn.ngay_dien_ra);
                            const banNganhName = bn.ban_nganh?.ten || 'N/A';
                            const displayText = `${displayDate} - ${bn.chu_de || 'Chưa có chủ đề'} - ${banNganhName} (ID: ${bn.id})`;
                            selectBuoiNhom.append(new Option(displayText, bn.id, false, false)).find('option:last').attr('data-counts', safeCountsJsonString);
                        });
                        populateCountsTable(cachedBuoiNhomData);
                    } else {
                        selectBuoiNhom.append('<option value="" disabled>Chưa có buổi nhóm</option>');
                        populateCountsTable([]);
                    }
                }).fail(function (jqXHR) {
                    console.error('Failed to load Buoi Nhoms:', jqXHR.status, jqXHR.statusText, jqXHR.responseText);
                    selectBuoiNhom.empty().append('<option value="" disabled>Lỗi tải danh sách</option>');
                    countsTableBody.html('<tr><td colspan="13" class="text-center text-danger">Lỗi tải danh sách buổi nhóm.</td></tr>');
                    showAlert('Lỗi tải danh sách buổi nhóm.');
                }).always(function () {
                    selectBuoiNhom.prop('disabled', false).val(null).trigger('change');
                    selectBuoiNhom.select2({ placeholder: '-- Chọn buổi nhóm để điền/sửa số lượng --', theme: 'bootstrap4', width: '100%', allowClear: true });
                });
            };

            selectBuoiNhom.on('change', function () {
                const selectedOption = $(this).find('option:selected');
                const buoiNhomId = $(this).val();
                const countsDataString = selectedOption.attr('data-counts')?.replace(/"/g, '"');

                countsContainer.slideUp();
                updateCountsBtn.prop('disabled', true);
                updateCountsBtn.html('<i class="fas fa-save"></i> Cập nhật Số Lượng');
                updateCountsCancelBtn.hide();
                hiddenBuoiNhomIdInput.val('');
                countsForm.attr('action', '#');
                countInputs.val(0);
                selectBuoiNhomError.hide();
                formCountsTitle.text('Nhập số lượng cho buổi nhóm đã chọn:');

                if (buoiNhomId) {
                    hiddenBuoiNhomIdInput.val(buoiNhomId);
                    let currentCounts = {};
                    try {
                        if (countsDataString) {
                            currentCounts = JSON.parse(countsDataString);
                        }
                    } catch (e) {
                        console.error("Error parsing counts data:", e, "Raw:", countsDataString);
                    }
                    $('#so_luong_trung_lao').val(currentCounts?.so_luong_trung_lao ?? 0);
                    $('#so_luong_thanh_trang').val(currentCounts?.so_luong_thanh_trang ?? 0);
                    $('#so_luong_thanh_nien').val(currentCounts?.so_luong_thanh_nien ?? 0);
                    $('#so_luong_thieu_nhi_au').val(currentCounts?.so_luong_thieu_nhi_au ?? 0);
                    $('#so_luong_tin_huu_khac').val(currentCounts?.so_luong_tin_huu_khac ?? 0);
                    $('#so_luong_tin_huu').val(currentCounts?.so_luong_tin_huu ?? 0);
                    $('#so_luong_than_huu').val(currentCounts?.so_luong_than_huu ?? 0);
                    $('#so_nguoi_tin_chua').val(currentCounts?.so_nguoi_tin_chua ?? 0);
                    countsContainer.slideDown();
                    updateCountsBtn.prop('disabled', false);
                    let updateUrl = '#';
                    try {
                        updateUrl = '{{ route("api.buoi_nhom.update_counts", ["buoi_nhom" => "__ID__"]) }}'.replace('__ID__', encodeURIComponent(buoiNhomId));
                    } catch (e) {
                        console.error("Route error:", e);
                        updateUrl = `/api/buoi-nhom/${encodeURIComponent(buoiNhomId)}/update-counts`;
                    }
                    countsForm.attr('action', updateUrl);
                }
            });

            countsTableBody.on('click', '.edit-counts-btn', function () {
                const row = $(this).closest('tr');
                const buoiNhomId = row.data('id');
                const countsDataString = row.attr('data-counts')?.replace(/"/g, '"');

                console.log(`Edit counts for Buoi Nhom ID: ${buoiNhomId}`);

                selectBuoiNhom.val(buoiNhomId).trigger('change');
                formCountsTitle.text(`Sửa số lượng cho Buổi Nhóm ID: ${buoiNhomId}`);
                updateCountsBtn.html('<i class="fas fa-save"></i> Cập Nhật Số Lượng');
                updateCountsCancelBtn.show();

                $('html, body').animate({ scrollTop: countsForm.offset().top - 20 }, 'smooth');
            });

            countsTableBody.on('click', '.delete-counts-btn', function () {
                const row = $(this).closest('tr');
                const buoiNhomId = row.data('id');

                if (!buoiNhomId) return;

                if (confirm(`Bạn có chắc muốn xóa (đặt về 0) toàn bộ số lượng của Buổi Nhóm ID ${buoiNhomId}?`)) {
                    console.log(`Deleting counts for Buoi Nhom ID: ${buoiNhomId}`);

                    let deleteUrl = '#';
                    try {
                        deleteUrl = '{{ route("api.buoi_nhom.update_counts", ["buoi_nhom" => "__ID__"]) }}'.replace('__ID__', encodeURIComponent(buoiNhomId));
                    } catch (e) {
                        console.error("Route error:", e);
                        deleteUrl = `/api/buoi-nhom/${encodeURIComponent(buoiNhomId)}/update-counts`;
                    }

                    const zeroCountsData = {
                        _method: 'PUT',
                        so_luong_trung_lao: 0,
                        so_luong_thanh_trang: 0,
                        so_luong_thanh_nien: 0,
                        so_luong_thieu_nhi_au: 0,
                        so_luong_tin_huu_khac: 0,
                        so_luong_tin_huu: 0,
                        so_luong_than_huu: 0,
                        so_nguoi_tin_chua: 0
                    };

                    $.ajax({
                        url: deleteUrl,
                        method: 'POST',
                        data: zeroCountsData,
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                showAlert('Xóa số lượng thành công!', 'success');
                                loadBuoiNhomsForSelectAndTable();
                                resetCountsForm();
                            } else {
                                showAlert(response.message || 'Không thể xóa số lượng.');
                            }
                        },
                        error: function (jqXHR) {
                            console.error("Ajax Error (Delete Counts):", jqXHR.status, jqXHR.statusText, jqXHR.responseText);
                            showAlert(`Lỗi ${jqXHR.status} khi xóa số lượng.`);
                        }
                    });
                }
            });

            countsForm.on('submit', function (e) {
                e.preventDefault();
                const form = $(this);
                const url = form.attr('action');
                const method = $('input[name="_method"]', form).val();
                const data = form.serialize();
                const selectedBuoiNhomId = hiddenBuoiNhomIdInput.val();

                if (!selectedBuoiNhomId || url === '#') {
                    selectBuoiNhomError.show();
                    return;
                }
                selectBuoiNhomError.hide();

                updateCountsBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang lưu...');

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: data,
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            showAlert(response.message || 'Cập nhật số lượng thành công!', 'success');
                            resetCountsForm();
                            loadBuoiNhomsForSelectAndTable();
                        } else {
                            showAlert(response.message || 'Không thể cập nhật số lượng.');
                        }
                    },
                    error: function (jqXHR) {
                        console.error("Ajax Error (Update Counts):", jqXHR.status, jqXHR.statusText, jqXHR.responseText);
                        let errorMsg = `Lỗi ${jqXHR.status}. Không thể cập nhật số lượng.`;
                        if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                            errorMsg = `Lỗi: ${jqXHR.responseJSON.message}`;
                        }
                        showAlert(errorMsg);
                    },
                    complete: function () {
                        updateCountsBtn.prop('disabled', false);
                        if (formCountsTitle.text().startsWith('Nhập')) {
                            updateCountsBtn.html('<i class="fas fa-save"></i> Cập nhật Số Lượng');
                        }
                    }
                });
            });

            updateCountsCancelBtn.on('click', function () {
                resetCountsForm();
            });

            // Thêm sự kiện thay đổi cho filter month và year với spinner
            filterMonthSelect.on('change', function () {
                localStorage.setItem('filter_month', $(this).val());
                countsTableBody.html('<tr><td colspan="13" class="text-center"><i class="fas fa-spinner fa-spin"></i> Đang tải...</td></tr>');
                loadBuoiNhomsForSelectAndTable();
                resetCountsForm();
            });

            filterYearSelect.on('change', function () {
                localStorage.setItem('filter_year', $(this).val());
                countsTableBody.html('<tr><td colspan="13" class="text-center"><i class="fas fa-spinner fa-spin"></i> Đang tải...</td></tr>');
                loadBuoiNhomsForSelectAndTable();
                resetCountsForm();
            });

            // ----- Initial Load với giá trị từ localStorage -----
            const savedMonth = localStorage.getItem('filter_month');
            const savedYear = localStorage.getItem('filter_year');
            if (savedMonth) filterMonthSelect.val(savedMonth);
            if (savedYear) filterYearSelect.val(savedYear);
            loadBuoiNhomsForSelectAndTable();
            resetCreateTinHuuSelects();

            console.log('Scripts chính đã khởi tạo xong.');
        });
    </script>
@endpush