{{-- ====================================================================== --}}
{{-- File: resources/views/_buoi_nhom/edit.blade.php --}}
{{-- View để chỉnh sửa thông tin buổi nhóm --}}
{{-- ====================================================================== --}}
@extends('layouts.app')
@section('title', 'Chỉnh sửa Buổi Nhóm')

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
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-edit"></i> Chỉnh sửa Buổi Nhóm</h3>
                    </div>
                    <div class="card-body">
                        <form id="edit-buoi-nhom-form"
                            action="{{ route('api.buoi_nhom.update', ['buoi_nhom' => $buoiNhom->id]) }}" method="POST"
                            novalidate>
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="buoi_nhom_id" name="buoi_nhom_id" value="{{ $buoiNhom->id }}">
                            <div class="row">
                                {{-- Cột Trái --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_lich_buoi_nhom_id">Lịch Buổi Nhóm</label>
                                        <select name="lich_buoi_nhom_id" id="edit_lich_buoi_nhom_id"
                                            class="form-control select2bs4-edit">
                                            <option value="">-- Chọn Lịch --</option>
                                            @foreach($lichBuoiNhoms as $lich)
                                                <option value="{{ $lich->id }}" {{ $buoiNhom->lich_buoi_nhom_id == $lich->id ? 'selected' : '' }}>{{ htmlspecialchars($lich->ten) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_ban_nganh_id">Ban Ngành</label>
                                        <select name="ban_nganh_id" id="edit_ban_nganh_id"
                                            class="form-control select2bs4-edit">
                                            <option value="">-- Chọn Ban Ngành --</option>
                                            @foreach($banNganhs as $banNganh)
                                                <option value="{{ $banNganh->id }}" {{ $buoiNhom->ban_nganh_id == $banNganh->id ? 'selected' : '' }}>{{ htmlspecialchars($banNganh->ten) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_ngay_dien_ra">Ngày Diễn Ra</label>
                                        <input type="date" name="ngay_dien_ra" id="edit_ngay_dien_ra" class="form-control"
                                            value="{{ $buoiNhom->ngay_dien_ra ? $buoiNhom->ngay_dien_ra->format('Y-m-d') : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_gio_bat_dau">Giờ Bắt Đầu</label>
                                        <input type="time" name="gio_bat_dau" id="edit_gio_bat_dau" class="form-control"
                                            value="{{ $buoiNhom->gio_bat_dau ? \Carbon\Carbon::parse($buoiNhom->gio_bat_dau)->format('H:i') : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_gio_ket_thuc">Giờ Kết Thúc</label>
                                        <input type="time" name="gio_ket_thuc" id="edit_gio_ket_thuc" class="form-control"
                                            value="{{ $buoiNhom->gio_ket_thuc ? \Carbon\Carbon::parse($buoiNhom->gio_ket_thuc)->format('H:i') : '' }}">
                                    </div>
                                </div>
                                {{-- Cột Phải --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_chu_de">Chủ Đề</label>
                                        <input type="text" name="chu_de" id="edit_chu_de" class="form-control"
                                            value="{{ htmlspecialchars($buoiNhom->chu_de) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_dien_gia_id">Diễn Giả</label>
                                        <select name="dien_gia_id" id="edit_dien_gia_id"
                                            class="form-control select2bs4-edit">
                                            <option value="">-- Chọn Diễn Giả --</option>
                                            @foreach($dienGias as $dienGia)
                                                <option value="{{ $dienGia->id }}" {{ $buoiNhom->dien_gia_id == $dienGia->id ? 'selected' : '' }}>
                                                    {{ htmlspecialchars($dienGia->chuc_danh . ' ' . $dienGia->ho_ten) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_id_tin_huu_hdct">Người Hướng Dẫn</label>
                                        <select name="id_tin_huu_hdct" id="edit_id_tin_huu_hdct"
                                            class="form-control select2bs4-edit">
                                            <option value="">-- Chọn Người Hướng Dẫn --</option>
                                            @foreach($tinHuuHdct as $tinHuu)
                                                <option value="{{ $tinHuu->id }}" {{ $buoiNhom->id_tin_huu_hdct == $tinHuu->id ? 'selected' : '' }}>{{ htmlspecialchars($tinHuu->ho_ten) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_id_tin_huu_do_kt">Người Đọc Kinh Thánh</label>
                                        <select name="id_tin_huu_do_kt" id="edit_id_tin_huu_do_kt"
                                            class="form-control select2bs4-edit">
                                            <option value="">-- Chọn Người Đọc Kinh Thánh --</option>
                                            @foreach($tinHuuDoKt as $tinHuu)
                                                <option value="{{ $tinHuu->id }}" {{ $buoiNhom->id_tin_huu_do_kt == $tinHuu->id ? 'selected' : '' }}>{{ htmlspecialchars($tinHuu->ho_ten) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_dia_diem">Địa Điểm</label>
                                        <input type="text" name="dia_diem" id="edit_dia_diem" class="form-control"
                                            value="{{ htmlspecialchars($buoiNhom->dia_diem) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_ghi_chu">Ghi Chú</label>
                                        <textarea name="ghi_chu" id="edit_ghi_chu"
                                            class="form-control">{{ htmlspecialchars($buoiNhom->ghi_chu) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-light border-top text-right">
                                <button type="submit" class="btn btn-primary" id="edit-submit-btn"><i
                                        class="fas fa-save"></i> Cập nhật</button>
                                <a href="{{ route('buoi_nhom.index') }}" class="btn btn-secondary"><i
                                        class="fas fa-list"></i> Xem Danh sách</a>
                                <button type="reset" class="btn btn-default" id="edit-reset-btn"><i
                                        class="fas fa-sync-alt"></i> Làm mới Form</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            console.log('Script for _buoi_nhom/edit.blade.php executing independently.');

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

            const escapeHtml = (unsafe) => {
                if (unsafe === null || unsafe === undefined) return '';
                return unsafe.toString()
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
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
                                selectElement.append(new Option(escapeHtml(item.ho_ten), item.id));
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

            // ----- Cache Selectors -----
            const editForm = $('#edit-buoi-nhom-form');
            const editBanNganhSelect = $('#edit_ban_nganh_id');
            const editTinHuuHdctSelect = $('#edit_id_tin_huu_hdct');
            const editTinHuuDoKtSelect = $('#edit_id_tin_huu_do_kt');
            const editSubmitBtn = $('#edit-submit-btn');
            const editDateInput = $('#edit_ngay_dien_ra');
            const editResetBtn = $('#edit-reset-btn');
            const editSelects = $('.select2bs4-edit', editForm);

            // ----- Initialize Plugins -----
            $('.select2bs4-edit').select2({ theme: 'bootstrap4', width: '100%', allowClear: true });

            // ----- Edit Buoi Nhom -----
            const resetEditTinHuuSelects = () => {
                const placeholder = '-- Chọn Ban Ngành trước --';
                editTinHuuHdctSelect.empty().append(`<option value=""></option>`).val(null).trigger('change');
                editTinHuuDoKtSelect.empty().append(`<option value=""></option>`).val(null).trigger('change');
                editTinHuuHdctSelect.select2({ placeholder: placeholder, theme: 'bootstrap4', width: '100%' });
                editTinHuuDoKtSelect.select2({ placeholder: placeholder, theme: 'bootstrap4', width: '100%' });
            };

            editBanNganhSelect.on('change', debounce(function () {
                const banNganhId = $(this).val();
                resetEditTinHuuSelects();
                if (banNganhId) {
                    loadTinHuuOptionsLocal(banNganhId, editTinHuuHdctSelect, '-- Chọn Người Hướng Dẫn --').then(() => {
                        const initialHdctId = '{{ $buoiNhom->id_tin_huu_hdct ?? '' }}';
                        if (initialHdctId) {
                            editTinHuuHdctSelect.val(initialHdctId).trigger('change');
                        }
                    });
                    loadTinHuuOptionsLocal(banNganhId, editTinHuuDoKtSelect, '-- Chọn Người Đọc KT --').then(() => {
                        const initialDoKtId = '{{ $buoiNhom->id_tin_huu_do_kt ?? '' }}';
                        if (initialDoKtId) {
                            editTinHuuDoKtSelect.val(initialDoKtId).trigger('change');
                        }
                    });
                }
            }, 350));

            editResetBtn.on('click', function () {
                setTimeout(() => {
                    editForm[0].reset();
                    editSelects.val(null).trigger('change');
                    resetEditTinHuuSelects();
                    $('#edit_lich_buoi_nhom_id').select2({ placeholder: '-- Chọn Lịch Buổi Nhóm --', theme: 'bootstrap4', width: '100%', allowClear: true });
                    $('#edit_ban_nganh_id').select2({ placeholder: '-- Chọn Ban Ngành --', theme: 'bootstrap4', width: '100%', allowClear: true });
                    $('#edit_dien_gia_id').select2({ placeholder: '-- Chọn Diễn Giả (nếu có) --', theme: 'bootstrap4', width: '100%', allowClear: true });
                    console.log('Edit form reset.');
                }, 0);
            });

            editForm.on('submit', function (e) {
                e.preventDefault();
                const form = $(this);
                const url = form.attr('action');
                const method = form.attr('method');
                const data = form.serialize();
                editSubmitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang cập nhật...');
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: data,
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            showAlert(response.message || 'Cập nhật buổi nhóm thành công!', 'success');
                            window.location.href = '{{ route("buoi_nhom.index") }}';
                        } else {
                            showAlert(response.message || 'Không thể cập nhật buổi nhóm.');
                        }
                    },
                    error: function (jqXHR) {
                        console.error("Ajax Error (Edit Form):", jqXHR.status, jqXHR.statusText, jqXHR.responseText);
                        let errorMsg = `Lỗi ${jqXHR.status}. Không thể cập nhật buổi nhóm.`;
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
                        editSubmitBtn.prop('disabled', false).html('<i class="fas fa-save"></i> Cập nhật');
                    }
                });
            });

            // Trigger change ban đầu để load danh sách tín hữu nếu ban ngành đã được chọn
            const initialBanNganhId = editBanNganhSelect.val();
            if (initialBanNganhId) {
                editBanNganhSelect.trigger('change');
            }

            console.log('Scripts chính đã khởi tạo xong.');
        });
    </script>
@endpush
@include('scripts.buoi_nhom')