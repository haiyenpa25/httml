<script>
    $(function () {
        // Cập nhật thời gian hiện tại
        function updateCurrentTime() {
            const currentTime = new Date().toLocaleString('vi-VN', { 
                year: 'numeric', 
                month: '2-digit', 
                day: '2-digit',
                hour: '2-digit', 
                minute: '2-digit'
            });
            $('#update-time').text(currentTime);
        }
        
        // Cập nhật thời gian lần đầu
        updateCurrentTime();
    
        // Khởi tạo Select2 cho dropdown tín hữu (phiên bản đơn giản không dùng AJAX)
        $('.select2bs4').select2({
            theme: 'bootstrap4',
            allowClear: true,
            placeholder: 'Chọn tín hữu giới thiệu',
            width: '100%',
            language: {
                noResults: function() {
                    return 'Không tìm thấy kết quả phù hợp';
                },
                searching: function() {
                    return 'Đang tìm kiếm...';
                }
            },
            escapeMarkup: function(markup) {
                return markup;
            },
            templateResult: formatTinHuu,
            templateSelection: formatTinHuuSelection
        });
    
        // Format hiển thị kết quả tìm kiếm tín hữu
        function formatTinHuu(data) {
            if (!data.id) {
                return data.text;
            }
            
            return $(`
                <div class="d-flex align-items-center">
                    <div class="mr-2">
                        <i class="fas fa-user-circle text-primary" style="font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <div class="font-weight-bold">${data.text}</div>
                    </div>
                </div>
            `);
        }
    
        // Format hiển thị tín hữu đã chọn
        function formatTinHuuSelection(data) {
            return data.text || 'Chọn tín hữu giới thiệu';
        }
    
        // Khởi tạo DataTable
        let table = $('#than-huu-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('api.than_huu.list') }}",
                data: function (d) {
                    d.ho_ten = $('#filter_ho_ten').val();
                    d.trang_thai = $('#filter_trang_thai').val();
                    d.tin_huu_gioi_thieu_id = $('#filter_tin_huu_gioi_thieu_id').val();
                },
                error: function (xhr, error, thrown) {
                    console.error('DataTables AJAX error:', xhr.responseText);
                    showAlert('Không thể tải danh sách thân hữu: ' + (xhr.responseJSON?.message || 'Lỗi không xác định'), 'danger');
                    $('#than-huu-table_processing').hide();
                },
                complete: function () {
                    $('#than-huu-table_processing').hide();
                }
            },
            columns: [
                { 
                    data: 'DT_RowIndex', 
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                { 
                    data: 'ho_ten',
                    name: 'ho_ten',
                    render: function(data, type, row) {
                        return `<a href="javascript:void(0)" class="text-primary btn-view" data-id="${row.id}">${data}</a>`;
                    }
                },
                { 
                    data: 'nam_sinh',
                    name: 'nam_sinh'
                },
                { 
                    data: 'trang_thai',
                    name: 'trang_thai',
                    render: function(data, type, row) {
                        const badges = {
                            'chua_tin': 'badge-danger',
                            'da_tham_gia': 'badge-warning',
                            'da_tin_chua': 'badge-success'
                        };
                        const labels = {
                            'chua_tin': 'Chưa tin',
                            'da_tham_gia': 'Đã tham gia',
                            'da_tin_chua': 'Đã tin Chúa'
                        };
                        return `<span class="badge ${badges[data] || 'badge-secondary'}">${labels[data] || data}</span>`;
                    }
                },
                { 
                    data: 'tin_huu_gioi_thieu',
                    name: 'tin_huu_gioi_thieu.ho_ten',
                    render: function(data, type, row) {
                        return data || '<span class="text-muted">(Không có)</span>';
                    }
                },
                { 
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return `
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-info action-btn btn-edit" 
                                    data-id="${row.id}" title="Sửa thân hữu">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger action-btn btn-delete" 
                                    data-id="${row.id}" data-name="${row.ho_ten}" title="Xóa thân hữu">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>`;
                    }
                }
            ],
            language: {
                url: "{{ asset('vendor/datatables/i18n/Vietnamese.json') }}",
                processing: '<div class="d-flex justify-content-center align-items-center"><div class="spinner-border text-primary loading-spinner" role="status"><span class="sr-only">Đang tải...</span></div></div>'
            },
            responsive: true,
            autoWidth: false,
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Tất cả"]],
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            drawCallback: function () {
                $('[data-toggle="tooltip"]').tooltip();
                updateCurrentTime();
                $('#than-huu-table_processing').hide();
            }
        });
    
        // Xử lý form lọc
        $('#form-filter').submit(function (e) {
            e.preventDefault();
            table.ajax.reload();
            showAlert('Đã áp dụng bộ lọc', 'info');
        });
    
        // Reset form lọc
        $('#btn-reset-filter').click(function () {
            $('#form-filter')[0].reset();
            
            // Reset select2 nếu có trong form lọc
            if ($('#filter_tin_huu_gioi_thieu_id').hasClass('select2bs4')) {
                $('#filter_tin_huu_gioi_thieu_id').val(null).trigger('change');
            }
            
            table.ajax.reload();
            showAlert('Đã xóa bộ lọc', 'info');
        });
    
        // Hiển thị thông báo
        function showAlert(message, type = 'success') {
            const iconClass = type === 'success' ? 'check' : (type === 'info' ? 'info-circle' : 'ban');
            const title = type === 'success' ? 'Thành công!' : (type === 'info' ? 'Thông báo!' : 'Lỗi!');
            
            const alertHtml = `
                <div class="alert alert-${type} alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <h5><i class="icon fas fa-${iconClass}"></i> ${title}</h5>
                    ${message}
                </div>`;
                
            $('#alert-container').html(alertHtml);
            setTimeout(() => $('.alert').alert('close'), 5000);
            
            // Sử dụng toastr nếu đã được khai báo
            if (typeof toastr !== 'undefined') {
                toastr[type](message, title);
            }
        }
    
        // Xử lý nút Tải lại
        $('#btn-refresh').click(function () {
            $(this).find('i').addClass('fa-spin');
            table.ajax.reload();
            setTimeout(() => {
                $(this).find('i').removeClass('fa-spin');
                showAlert('Dữ liệu đã được cập nhật');
            }, 1000);
        });
    
        // Validation cho form
        function validateForm(formId) {
            const form = document.getElementById(formId);
            
            // Kiểm tra các trường required
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            let firstInvalid = null;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    if (!firstInvalid) firstInvalid = field;
                    
                    // Thêm class invalid
                    field.classList.add('is-invalid');
                    
                    // Tạo feedback message nếu chưa có
                    const parent = field.parentElement;
                    const formGroup = parent.closest('.form-group');
                    
                    if (!formGroup.querySelector('.invalid-feedback')) {
                        const feedback = document.createElement('div');
                        feedback.className = 'invalid-feedback';
                        feedback.textContent = 'Vui lòng điền thông tin này';
                        
                        if (parent.classList.contains('input-group')) {
                            parent.after(feedback);
                        } else {
                            field.after(feedback);
                        }
                    }
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            if (!isValid && firstInvalid) {
                firstInvalid.focus();
                
                // Chuyển đến tab chứa field lỗi
                const tabPane = firstInvalid.closest('.tab-pane');
                if (tabPane) {
                    const tabId = tabPane.id;
                    $(`a[href="#${tabId}"]`).tab('show');
                }
            }
            
            return isValid;
        }
    
        // Reset validation khi bắt đầu nhập liệu
        $(document).on('input', '.is-invalid', function() {
            $(this).removeClass('is-invalid');
        });
    
        // Xử lý nút xem chi tiết
        $(document).on('click', '.btn-view', function() {
            const id = $(this).data('id');
            
            $.ajax({
                url: `{{ url('api/than-huu') }}/${id}`,
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#view_ho_ten').text(data.ho_ten);
                    const trangThaiLabels = {
                        'chua_tin': 'Chưa tin',
                        'da_tham_gia': 'Đã tham gia',
                        'da_tin_chua': 'Đã tin Chúa'
                    };
                    const trangThaiBadges = {
                        'chua_tin': 'badge-danger',
                        'da_tham_gia': 'badge-warning',
                        'da_tin_chua': 'badge-success'
                    };
                    $('#view_trang_thai').text(trangThaiLabels[data.trang_thai] || data.trang_thai);
                    $('#view_trang_thai').removeClass().addClass('badge ' + (trangThaiBadges[data.trang_thai] || 'badge-secondary'));
                    $('#view_nam_sinh').text(data.nam_sinh || 'Không có');
                    $('#view_so_dien_thoai').html(data.so_dien_thoai ? 
                        `<a href="tel:${data.so_dien_thoai}" class="text-primary">${data.so_dien_thoai}</a>` : 
                        '<span class="text-muted">Không có</span>');
                    $('#view_dia_chi').text(data.dia_chi || 'Không có');
                    $('#view_tin_huu_gioi_thieu').text(data.tin_huu_gioi_thieu ? data.tin_huu_gioi_thieu.ho_ten : 'Không có');
                    $('#view_ghi_chu').text(data.ghi_chu || 'Không có');
                    $('#modal-xem-than-huu').modal('show');
                },
                error: function () {
                    showAlert('Không thể lấy thông tin thân hữu', 'danger');
                }
            });
        });
    
        // Xử lý submit form thêm thân hữu
        $('#form-than-huu').submit(function (e) {
            e.preventDefault();
            
            if (!validateForm('form-than-huu')) {
                return false;
            }
            
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.html('<i class="fas fa-spinner fa-spin mr-1"></i>Đang xử lý...');
            submitBtn.attr('disabled', true);
            
            $.ajax({
                url: "{{ route('api.than_huu.store') }}",
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        $('#modal-them-than-huu').modal('hide');
                        $('#form-than-huu')[0].reset();
                        
                        // Reset select2
                        $('#tin_huu_gioi_thieu_id').val(null).trigger('change');
                        
                        showAlert(response.message);
                        table.ajax.reload();
                    } else {
                        showAlert(response.message, 'danger');
                    }
                },
                error: function (xhr) {
                    let errorMessage = 'Đã xảy ra lỗi khi thêm thân hữu';
                    
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage = '';
                        const errors = xhr.responseJSON.errors;
                        
                        // Hiển thị validation errors lên form
                        Object.keys(errors).forEach(field => {
                            const fieldElement = document.getElementById(field);
                            if (fieldElement) {
                                fieldElement.classList.add('is-invalid');
                                
                                // Tạo feedback message
                                const parent = fieldElement.parentElement;
                                const formGroup = parent.closest('.form-group');
                                
                                if (!formGroup.querySelector('.invalid-feedback')) {
                                    const feedback = document.createElement('div');
                                    feedback.className = 'invalid-feedback';
                                    feedback.textContent = errors[field][0];
                                    
                                    if (parent.classList.contains('input-group')) {
                                        parent.after(feedback);
                                    } else {
                                        fieldElement.after(feedback);
                                    }
                                }
                            }
                            
                            errorMessage += errors[field].join('<br>') + '<br>';
                        });
                        
                        // Chuyển đến tab có lỗi đầu tiên
                        const firstErrorField = Object.keys(errors)[0];
                        const firstErrorElement = document.getElementById(firstErrorField);
                        if (firstErrorElement) {
                            const tabPane = firstErrorElement.closest('.tab-pane');
                            if (tabPane) {
                                const tabId = tabPane.id;
                                $(`a[href="#${tabId}"]`).tab('show');
                            }
                        }
                    }
                    
                    showAlert(errorMessage, 'danger');
                },
                complete: function() {
                    submitBtn.html(originalText);
                    submitBtn.attr('disabled', false);
                }
            });
        });
    
        // Xử lý nút sửa
        $(document).on('click', '.btn-edit', function () {
            const id = $(this).data('id');
            
            $(this).html('<i class="fas fa-spinner fa-spin"></i>');
            $(this).attr('disabled', true);
            
            $.ajax({
                url: `{{ url('api/than-huu') }}/${id}`,
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#edit_id').val(data.id);
                    $('#edit_ho_ten').val(data.ho_ten);
                    $('#edit_nam_sinh').val(data.nam_sinh);
                    $('#edit_so_dien_thoai').val(data.so_dien_thoai);
                    $('#edit_dia_chi').val(data.dia_chi);
                    $('#edit_trang_thai').val(data.trang_thai);
                    $('#edit_ghi_chu').val(data.ghi_chu);
                    
                    // Cập nhật select2 không dùng AJAX
                    if (data.tin_huu_gioi_thieu_id) {
                        $('#edit_tin_huu_gioi_thieu_id').val(data.tin_huu_gioi_thieu_id).trigger('change');
                    } else {
                        $('#edit_tin_huu_gioi_thieu_id').val(null).trigger('change');
                    }
                    
                    $('#modal-sua-than-huu').modal('show');
                    
                    // Hiển thị tab đầu tiên
                    $('#edit-info-tab').tab('show');
                },
                error: function () {
                    showAlert('Không thể lấy thông tin thân hữu', 'danger');
                },
                complete: function() {
                    $('.btn-edit[data-id="'+id+'"]').html('<i class="fas fa-edit"></i>');
                    $('.btn-edit[data-id="'+id+'"]').attr('disabled', false);
                }
            });
        });
    
        // Xử lý submit form sửa thân hữu
        $('#form-sua-than-huu').submit(function (e) {
            e.preventDefault();
            
            if (!validateForm('form-sua-than-huu')) {
                return false;
            }
            
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.html('<i class="fas fa-spinner fa-spin mr-1"></i>Đang xử lý...');
            submitBtn.attr('disabled', true);
            
            const id = $('#edit_id').val();
            $.ajax({
                url: `{{ url('api/than-huu') }}/${id}`,
                method: 'PUT',
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        $('#modal-sua-than-huu').modal('hide');
                        showAlert(response.message);
                        table.ajax.reload();
                    } else {
                        showAlert(response.message, 'danger');
                    }
                },
                error: function (xhr) {
                    let errorMessage = 'Đã xảy ra lỗi khi cập nhật thân hữu';
                    
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage = '';
                        const errors = xhr.responseJSON.errors;
                        
                        // Hiển thị validation errors lên form
                        Object.keys(errors).forEach(field => {
                            const fieldElement = document.getElementById('edit_' + field);
                            if (fieldElement) {
                                fieldElement.classList.add('is-invalid');
                                
                                // Tạo feedback message
                                const parent = fieldElement.parentElement;
                                const formGroup = parent.closest('.form-group');
                                
                                if (!formGroup.querySelector('.invalid-feedback')) {
                                    const feedback = document.createElement('div');
                                    feedback.className = 'invalid-feedback';
                                    feedback.textContent = errors[field][0];
                                    
                                    if (parent.classList.contains('input-group')) {
                                        parent.after(feedback);
                                    } else {
                                        fieldElement.after(feedback);
                                    }
                                }
                            }
                            
                            errorMessage += errors[field].join('<br>') + '<br>';
                        });
                        
                        // Chuyển đến tab có lỗi đầu tiên
                        const firstErrorField = 'edit_' + Object.keys(errors)[0];
                        const firstErrorElement = document.getElementById(firstErrorField);
                        if (firstErrorElement) {
                            const tabPane = firstErrorElement.closest('.tab-pane');
                            if (tabPane) {
                                const tabId = tabPane.id;
                                $(`a[href="#${tabId}"]`).tab('show');
                            }
                        }
                    }
                    
                    showAlert(errorMessage, 'danger');
                },
                complete: function() {
                    submitBtn.html(originalText);
                    submitBtn.attr('disabled', false);
                }
            });
        });
    
        // Xử lý nút xóa
        $(document).on('click', '.btn-delete', function () {
            const id = $(this).data('id');
            const name = $(this).data('name');
            $('#delete_id').val(id);
            $('#delete_name').text(name);
            $('#modal-xoa-than-huu').modal('show');
        });
    
        // Xử lý xác nhận xóa
        $('#confirm-delete').click(function () {
            const submitBtn = $(this);
            const originalText = submitBtn.html();
            submitBtn.html('<i class="fas fa-spinner fa-spin mr-1"></i>Đang xử lý...');
            submitBtn.attr('disabled', true);
            
            const id = $('#delete_id').val();
            $.ajax({
                url: `{{ url('api/than-huu') }}/${id}`,
                method: 'DELETE',
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        $('#modal-xoa-than-huu').modal('hide');
                        showAlert(response.message);
                        table.ajax.reload();
                    } else {
                        showAlert(response.message, 'danger');
                    }
                },
                error: function () {
                    showAlert('Không thể xóa thân hữu', 'danger');
                },
                complete: function() {
                    submitBtn.html(originalText);
                    submitBtn.attr('disabled', false);
                }
            });
        });
    
        // Reset form khi mở modal thêm mới
        $('#modal-them-than-huu').on('show.bs.modal', function () {
            $('#form-than-huu')[0].reset();
            $('#tin_huu_gioi_thieu_id').val(null).trigger('change');
            $('#form-than-huu .is-invalid').removeClass('is-invalid');
            $('#form-than-huu .invalid-feedback').remove();
            $('#info-tab').tab('show');
        });
    
        // Reset form khi mở modal sửa
        $('#modal-sua-than-huu').on('hidden.bs.modal', function () {
            $('#form-sua-than-huu .is-invalid').removeClass('is-invalid');
            $('#form-sua-than-huu .invalid-feedback').remove();
        });
    
        // Khởi tạo tooltips
        $('[data-toggle="tooltip"]').tooltip();
    });
    </script>