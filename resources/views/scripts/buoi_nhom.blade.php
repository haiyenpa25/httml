@section('page-scripts')
<script>
  $(function() {
    // ----- Khởi tạo các biến toàn cục -----
    const banNganhSelect = $('#ban_nganh_id');
    const tinHuuHdctSelect = $('#id_tin_huu_hdct');
    const tinHuuDoKtSelect = $('#id_tin_huu_do_kt');
    const buoiNhomForm = $('#buoi-nhom-form');
    const buoiNhomTableBody = $('#buoi-nhom-table tbody');

    // ----- Hàm tiện ích -----
    function resetTinHuuSelects() {
      // Reset và giữ lại option mặc định
      tinHuuHdctSelect.html('<option value="">-- Chọn Người Hướng Dẫn --</option>').trigger('change');
      tinHuuDoKtSelect.html('<option value="">-- Chọn Người Đọc Kinh Thánh --</option>').trigger('change');
    }

    function loadTinHuuOptions(banNganhId, selectElement) {
      // Kiểm tra selectElement tồn tại
      if (!selectElement || selectElement.length === 0) {
        console.warn("Select element không tồn tại để load tín hữu.");
        return Promise.reject("Select element không tồn tại.");
      }

      const url = '{{ route("api.tin_huu.by_ban_nganh", ["ban_nganh_id" => "__ID__"]) }}'.replace('__ID__', banNganhId);
      console.log('Đang tải tín hữu từ URL:', url);

      // Thêm hiệu ứng loading
      selectElement.prop('disabled', true).html('<option value="">-- Đang tải... --</option>').trigger('change');

      return $.get(url)
        .done(data => {
          console.log('Dữ liệu tín hữu nhận được cho', selectElement.attr('id'), ':', data);
          const $select = $(selectElement);
          
          // Reset lại trước khi thêm mới
          if (selectElement.is(tinHuuHdctSelect)) {
            $select.html('<option value="">-- Chọn Người Hướng Dẫn --</option>');
          } else if (selectElement.is(tinHuuDoKtSelect)) {
            $select.html('<option value="">-- Chọn Người Đọc Kinh Thánh --</option>');
          } else {
            $select.html('<option value="">-- Chọn --</option>');
          }

          if (Array.isArray(data) && data.length > 0) {
            data.forEach(item => {
              if (item && typeof item.id !== 'undefined' && typeof item.ho_ten !== 'undefined') {
                $select.append(`<option value="${item.id}">${item.ho_ten}</option>`);
              } else {
                console.warn('Dữ liệu tín hữu không hợp lệ:', item);
              }
            });
          } else if (Array.isArray(data) && data.length === 0) {
            console.log('Không có tín hữu nào thuộc ban ngành này.');
          } else {
            console.warn('Dữ liệu trả về không phải là mảng hoặc có lỗi:', data);
          }
        })
        .fail(error => {
          console.error(`Lỗi tải tín hữu cho ${selectElement.attr('id')}:`, error.statusText, error.responseText);
          toastr.error('Đã xảy ra lỗi khi tải dữ liệu tín hữu');
          
          if (selectElement.is(tinHuuHdctSelect)) {
            $(selectElement).html('<option value="">-- Lỗi tải Người Hướng Dẫn --</option>');
          } else if (selectElement.is(tinHuuDoKtSelect)) {
            $(selectElement).html('<option value="">-- Lỗi tải Người Đọc KT --</option>');
          } else {
            $(selectElement).html('<option value="">-- Lỗi tải --</option>');
          }
        })
        .always(() => {
          selectElement.prop('disabled', false).trigger('change');
          console.log('Hoàn tất tải tín hữu cho:', selectElement.attr('id'));
        });
    }

    function loadBuoiNhoms() {
      if (buoiNhomTableBody.length === 0) return;

      const url = '{{ route("api.buoi_nhom.list") }}';
      console.log('Đang tải danh sách buổi nhóm từ:', url);

      $.get(url)
        .done(data => {
          console.log('Dữ liệu danh sách buổi nhóm:', data);
          buoiNhomTableBody.empty();

          if (Array.isArray(data) && data.length > 0) {
            data.forEach(item => {
              const dienGiaTen = (item.dien_gia && item.dien_gia.ho_ten) ? item.dien_gia.ho_ten : 'Chưa có';
              const ngayDienRa = formatDate(item.ngay_dien_ra);
              const chuDe = item.chu_de || 'N/A';

              buoiNhomTableBody.append(`
                <tr>
                  <td>${ngayDienRa}</td>
                  <td>${chuDe}</td>
                  <td>${dienGiaTen}</td>
                  <td>
                    <button class="btn btn-sm btn-warning edit-btn" data-id="${item.id}" title="Sửa"><i class="fas fa-edit"></i> Sửa</button>
                    <button class="btn btn-sm btn-danger delete-btn" data-id="${item.id}" title="Xóa"><i class="fas fa-trash"></i> Xóa</button>
                  </td>
                </tr>
              `);
            });
          } else {
            buoiNhomTableBody.append('<tr><td colspan="4" class="text-center">Không có dữ liệu buổi nhóm.</td></tr>');
          }
        })
        .fail(error => {
          console.error('Lỗi tải danh sách buổi nhóm:', error.statusText, error.responseText);
          buoiNhomTableBody.html('<tr><td colspan="4" class="text-center text-danger">Lỗi tải dữ liệu. Vui lòng thử lại.</td></tr>');
          toastr.error('Đã xảy ra lỗi khi tải danh sách buổi nhóm');
        });
    }

    // ----- Sự kiện -----
    // Event for Ban Nganh select change
    if (banNganhSelect.length) {
      banNganhSelect.on('change', debounce(function() {
        const banNganhId = this.value;
        console.log('Ban ngành đã chọn:', banNganhId);
        resetTinHuuSelects();
        
        if (banNganhId) {
          Promise.all([
            loadTinHuuOptions(banNganhId, tinHuuHdctSelect),
            loadTinHuuOptions(banNganhId, tinHuuDoKtSelect)
          ]).catch(error => {
            console.error('Một hoặc cả hai quá trình tải tín hữu bị lỗi.');
          });
        } else {
          console.log('Không chọn ban ngành, không tải tín hữu.');
          resetTinHuuSelects();
        }
      }, 300));
    }

    // Form submit handling
    if (buoiNhomForm.length) {
      buoiNhomForm.on('submit', function(e) {
        e.preventDefault();
        console.log('Form submitted');
        const formData = $(this).serialize();
        const buoiNhomId = $('#buoi_nhom_id').val();

        const url = buoiNhomId
          ? '{{ route("api.buoi_nhom.update", ["buoi_nhom" => "__ID__"]) }}'.replace('__ID__', buoiNhomId)
          : '{{ route("api.buoi_nhom.store") }}';
        const method = buoiNhomId ? 'PUT' : 'POST';

        console.log('Submitting to URL:', url, 'with method:', method);

        $('#submit-btn').prop('disabled', true).text(buoiNhomId ? 'Đang cập nhật...' : 'Đang thêm...');

        $.ajax({
          url: url,
          method: method,
          data: formData,
          dataType: 'json'
        })
          .done(response => {
            console.log('Server response:', response);
            if (response.success) {
              toastr.success(response.message);
              buoiNhomForm[0].reset();
              $('#buoi_nhom_id').val('');
              $('.select2bs4').val(null).trigger('change');
              resetTinHuuSelects();
              $('#submit-btn').text('Thêm Buổi Nhóm');
              
              if (buoiNhomTableBody.length > 0) {
                loadBuoiNhoms();
              }
            } else {
              let errorMsg = 'Lỗi: ' + (response.message || 'Đã xảy ra lỗi không xác định.');
              if (response.errors) {
                errorMsg = "Lỗi dữ liệu:\n";
                $.each(response.errors, function(key, value) {
                  errorMsg += `- ${value.join(', ')}\n`;
                });
              }
              toastr.error(errorMsg);
            }
          })
          .fail(error => {
            console.error('Lỗi submit form:', error.status, error.statusText, error.responseText);
            let errorMsg = 'Đã xảy ra lỗi khi gửi dữ liệu.';
            
            if (error.status === 422 && error.responseJSON) {
              try {
                const errors = error.responseJSON.errors;
                errorMsg = "Lỗi dữ liệu:\n";
                $.each(errors, function(key, value) {
                  let fieldName = $(`label[for="${key}"]`).text() || key;
                  fieldName = fieldName.replace('*', '').trim();
                  errorMsg += `- ${fieldName}: ${value.join(', ')}\n`;
                });
              } catch (e) {
                errorMsg = 'Lỗi validation không xác định.';
                console.error("Error parsing validation errors:", e);
              }
            } else if (error.responseJSON && error.responseJSON.message) {
              errorMsg = 'Lỗi Server: ' + error.responseJSON.message;
            } else if (error.statusText) {
              errorMsg += ` (${error.status} ${error.statusText})`;
            }
            
            toastr.error(errorMsg);
          })
          .always(() => {
            $('#submit-btn').prop('disabled', false).text(buoiNhomId ? 'Cập Nhật' : 'Thêm Buổi Nhóm');
          });
      });
    }

    // Event delegation for edit and delete buttons
    $(document).on('click', '.edit-btn', function() {
      const id = $(this).data('id');
      const editUrl = '{{ route("buoi_nhom.edit", ["buoi_nhom" => "__ID__"]) }}'.replace('__ID__', id);
      console.log('Edit button clicked for ID:', id, 'Redirecting to:', editUrl);
      window.location.href = editUrl;
    });

    $(document).on('click', '.delete-btn', function() {
      const id = $(this).data('id');
      const url = '{{ route("api.buoi_nhom.destroy", ["buoi_nhom" => "__ID__"]) }}'.replace('__ID__', id);
      console.log('Delete button clicked for ID:', id, 'URL:', url);

      if (confirm('Bạn có chắc chắn muốn xóa buổi nhóm này?')) {
        $.ajax({
          url: url,
          method: 'DELETE',
          dataType: 'json'
        })
          .done(response => {
            console.log('Delete response:', response);
            if (response.success) {
              toastr.success(response.message);
              if (buoiNhomTableBody.length > 0) {
                loadBuoiNhoms();
              }
            } else {
              toastr.error('Lỗi: ' + (response.message || 'Không thể xóa buổi nhóm.'));
            }
          })
          .fail(error => {
            console.error('Lỗi xóa:', error.statusText, error.responseText);
            let errorMsg = 'Đã xảy ra lỗi khi xóa buổi nhóm.';
            if (error.responseJSON && error.responseJSON.message) {
              errorMsg = 'Lỗi Server: ' + error.responseJSON.message;
            } else if (error.statusText) {
              errorMsg += ` (${error.status} ${error.statusText})`;
            }
            toastr.error(errorMsg);
          });
      }
    });

    // Reset button handling
    if ($('#reset-btn').length) {
      $('#reset-btn').on('click', function() {
        console.log('Reset button clicked');
        buoiNhomForm[0].reset();
        $('#buoi_nhom_id').val('');
        $('.select2bs4').val(null).trigger('change');
        resetTinHuuSelects();
        $('#submit-btn').text('Thêm Buổi Nhóm');
      });
    }

    // ----- Initialization for Edit Page -----
    const editId = $('#buoi_nhom_id').val();
    const initialBanNganhId = $('#ban_nganh_id').val();
    if (editId && initialBanNganhId) {
      console.log('Trang Edit: Triggering change cho ban ngành ID:', initialBanNganhId);
      
      setTimeout(() => {
        $('#ban_nganh_id').trigger('change');
        const initialHdctId = '{{ $buoiNhom->id_tin_huu_hdct ?? "" }}';
        const initialDoKtId = '{{ $buoiNhom->id_tin_huu_do_kt ?? "" }}';

        if (initialHdctId || initialDoKtId) {
          setTimeout(() => {
            console.log('Re-setting selected Tín hữu after initial load:', initialHdctId, initialDoKtId);
            if (initialHdctId) tinHuuHdctSelect.val(initialHdctId).trigger('change');
            if (initialDoKtId) tinHuuDoKtSelect.val(initialDoKtId).trigger('change');
          }, 1500);
        }
      }, 200);
    } else {
      resetTinHuuSelects();
    }

    // ----- Khởi chạy khi tải trang -----
    // Load buổi nhóm table if exists
    if (buoiNhomTableBody.length > 0) {
      loadBuoiNhoms();
    }

    console.log('Buổi Nhóm scripts initialized.');
  });
</script>
@endsection