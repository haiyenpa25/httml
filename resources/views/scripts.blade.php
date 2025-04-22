<!-- Meta CSRF để Ajax hoạt động -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

<!-- Các thư viện cần thiết -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script>$.widget.bridge('uibutton', $.ui.button);</script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('dist/js/adminlte.js') }}"></script>

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

<!-- DataTables  & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

<!-- CSRF setup cho Ajax -->
<script>
  $.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
  });
</script>

<!-- Scripts chính (có thể đặt trong file js riêng hoặc ở đây) -->
<script>
   // Chuyển PHP $item sang JS object
    const ngayDienRa = formatDate(item.ngay_dien_ra);
    function formatDate(dateString) {
      
        return dateString ? moment(dateString).format('DD/MM/YYYY') : 'N/A';
      }

// Trong hàm loadBuoiNhoms(), thay đổi dòng ngayDienRa

    // ----- Khởi tạo các biến toàn cục -----
    const banNganhSelect = $('#ban_nganh_id');
    const tinHuuHdctSelect = $('#id_tin_huu_hdct');
    const tinHuuDoKtSelect = $('#id_tin_huu_do_kt');
    const buoiNhomForm = $('#buoi-nhom-form');
    const buoiNhomTableBody = $('#buoi-nhom-table tbody');

    // const sundaySelect = $('#sunday-select'); // Bỏ đi nếu không dùng hoặc sửa hàm populateSundays


      
    // ----- Khởi tạo các plugin -----
    // Đảm bảo các selector này tồn tại trên trang hiện tại trước khi khởi tạo
    if ($('.select2bs4').length) {
      $('.select2bs4').select2({ theme: 'bootstrap4' });
    }
    if ($('#visit-date').length) { // Ví dụ thêm kiểm tra
      $('#visit-date').datetimepicker({ format: 'L' });
    }
    // Khởi tạo Select2 cho các select trong form (nếu có)
    if (banNganhSelect.length) banNganhSelect.select2({ theme: 'bootstrap4' });
    if (tinHuuHdctSelect.length) tinHuuHdctSelect.select2({ theme: 'bootstrap4' });
    if (tinHuuDoKtSelect.length) tinHuuDoKtSelect.select2({ theme: 'bootstrap4' });
    if ($('#lich_buoi_nhom_id').length) $('#lich_buoi_nhom_id').select2({ theme: 'bootstrap4' });
    if ($('#dien_gia_id').length) $('#dien_gia_id').select2({ theme: 'bootstrap4' });
    // Thêm khởi tạo cho các select khác nếu cần

    // ----- Hàm tiện ích -----
    function resetTinHuuSelects() {
      // Reset và giữ lại option mặc định
      tinHuuHdctSelect.html('<option value="">-- Chọn Người Hướng Dẫn --</option>').trigger('change'); // Trigger change cho select2
      tinHuuDoKtSelect.html('<option value="">-- Chọn Người Đọc Kinh Thánh --</option>').trigger('change'); // Trigger change cho select2
    }

    function loadTinHuuOptions(banNganhId, selectElement) {
      // Kiểm tra selectElement tồn tại
      if (!selectElement || selectElement.length === 0) {
        console.warn("Select element không tồn tại để load tín hữu.");
        return Promise.reject("Select element không tồn tại."); // Trả về Promise bị reject
      }

      // SỬA ĐỔI Ở ĐÂY: Sử dụng route name mới
      const url = '{{ route("api.tin_huu.by_ban_nganh", ["ban_nganh_id" => "__ID__"]) }}'.replace('__ID__', banNganhId);
      // Hoặc dùng chuỗi trực tiếp (ít khuyến khích hơn):
      // const url = `/api/tin-huu/by-ban-nganh/${banNganhId}`;

      console.log('Đang tải tín hữu từ URL mới:', url); // Log URL mới

      // Thêm hiệu ứng loading (tùy chọn)
      selectElement.prop('disabled', true).html('<option value="">-- Đang tải... --</option>').trigger('change'); // Trigger change

      return $.get(url) // Đảm bảo $.get dùng biến url mới
        .done(data => { // Sử dụng .done() thay vì .then() cho $.get (hoặc dùng .then() cũng được)
          console.log('Dữ liệu tín hữu nhận được cho', selectElement.attr('id'), ':', data); // Log dữ liệu
          const $select = $(selectElement);
          // Reset lại trước khi thêm mới, giữ option mặc định
          if (selectElement.is(tinHuuHdctSelect)) {
            $select.html('<option value="">-- Chọn Người Hướng Dẫn --</option>');
          } else if (selectElement.is(tinHuuDoKtSelect)) {
            $select.html('<option value="">-- Chọn Người Đọc Kinh Thánh --</option>');
          } else {
            $select.html('<option value="">-- Chọn --</option>');
          }

          if (Array.isArray(data) && data.length > 0) {
            data.forEach(item => {
              // Kiểm tra kỹ item và thuộc tính trước khi dùng
              if (item && typeof item.id !== 'undefined' && typeof item.ho_ten !== 'undefined') {
                $select.append(`<option value="${item.id}">${item.ho_ten}</option>`);
              } else {
                console.warn('Dữ liệu tín hữu không hợp lệ:', item);
              }
            });
          } else if (Array.isArray(data) && data.length === 0) {
            console.log('Không có tín hữu nào thuộc ban ngành này.');
            // Có thể thêm option thông báo không có dữ liệu nếu muốn
            // $select.append('<option value="" disabled>Không có tín hữu</option>');
          } else {
            console.warn('Dữ liệu trả về không phải là mảng hoặc có lỗi:', data);
            // Giữ option mặc định nếu có lỗi
          }
        })
        .fail(error => { // Sử dụng .fail() để bắt lỗi Ajax
          console.error(`Lỗi tải tín hữu cho ${selectElement.attr('id')}:`, error.statusText, error.responseText);
          alert('Đã xảy ra lỗi khi tải dữ liệu tín hữu. Vui lòng kiểm tra console (F12).');
          // Reset về trạng thái mặc định nếu lỗi
          if (selectElement.is(tinHuuHdctSelect)) {
            $(selectElement).html('<option value="">-- Lỗi tải Người Hướng Dẫn --</option>');
          } else if (selectElement.is(tinHuuDoKtSelect)) {
            $(selectElement).html('<option value="">-- Lỗi tải Người Đọc KT --</option>');
          } else {
            $(selectElement).html('<option value="">-- Lỗi tải --</option>');
          }
        })
        .always(() => { // Sử dụng .always() để thực hiện sau khi success hoặc fail
          // Bỏ disable và trigger change để Select2 cập nhật giao diện
          selectElement.prop('disabled', false).trigger('change'); // Trigger change
          console.log('Hoàn tất tải tín hữu cho:', selectElement.attr('id'));
        });
    }

    function loadBuoiNhoms() {
      // Chỉ thực hiện nếu bảng tồn tại trên trang
      if (buoiNhomTableBody.length === 0) return;

      // SỬA ĐỔI Ở ĐÂY: Sử dụng route name mới cho danh sách
      const url = '{{ route("api.buoi_nhom.list") }}';
      console.log('Đang tải danh sách buổi nhóm từ:', url);

      $.get(url)
        .done(data => {
          console.log('Dữ liệu danh sách buổi nhóm:', data);
          buoiNhomTableBody.empty(); // Xóa dữ liệu cũ

          if (Array.isArray(data) && data.length > 0) {
            data.forEach(item => {
              // Kiểm tra dữ liệu trước khi append
              const dienGiaTen = (item.dien_gia && item.dien_gia.ho_ten) ? item.dien_gia.ho_ten : 'Chưa có';
              const ngayDienRa = item.ngay_dien_ra || 'N/A';
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
          alert('Đã xảy ra lỗi khi tải danh sách buổi nhóm. Vui lòng kiểm tra console (F12).');
        });
    }


    // Hàm debounce để tránh gọi Ajax nhiều lần
    function debounce(func, wait) {
      let timeout;
      return function (...args) {
        const context = this;
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(context, args), wait);
      };
    }

    // ----- Sự kiện -----

    // Chỉ gán sự kiện nếu element tồn tại
    if (banNganhSelect.length) {
      banNganhSelect.on('change', debounce(function () {
        const banNganhId = this.value;
        console.log('Ban ngành đã chọn:', banNganhId);
        resetTinHuuSelects(); // Reset trước khi tải
        if (banNganhId) {
          // Load cho cả hai select
          Promise.all([
            loadTinHuuOptions(banNganhId, tinHuuHdctSelect),
            loadTinHuuOptions(banNganhId, tinHuuDoKtSelect)
          ]).catch(error => {
            // Lỗi chung đã được xử lý trong fail() của loadTinHuuOptions
            console.error('Một hoặc cả hai quá trình tải tín hữu bị lỗi.');
          });
        } else {
          console.log('Không chọn ban ngành, không tải tín hữu.');
          // Đảm bảo các select đã được reset nếu không chọn ban ngành
          resetTinHuuSelects();
        }
      }, 300)); // Chờ 300ms sau khi người dùng ngừng chọn
    }

    // Chỉ gán sự kiện nếu form tồn tại
    if (buoiNhomForm.length) {
      buoiNhomForm.on('submit', function (e) {
        e.preventDefault();
        console.log('Form submitted');
        const formData = $(this).serialize();
        const buoiNhomId = $('#buoi_nhom_id').val();

        // SỬA ĐỔI Ở ĐÂY: Sử dụng route name mới cho store và update
        const url = buoiNhomId
          ? '{{ route("api.buoi_nhom.update", ["buoi_nhom" => "__ID__"]) }}'.replace('__ID__', buoiNhomId)
          : '{{ route("api.buoi_nhom.store") }}';
        const method = buoiNhomId ? 'PUT' : 'POST';

        console.log('Submitting to URL:', url, 'with method:', method, 'and data:', formData);

        // Disable nút submit để tránh double click
        $('#submit-btn').prop('disabled', true).text(buoiNhomId ? 'Đang cập nhật...' : 'Đang thêm...');

        $.ajax({
          url: url,
          method: method,
          data: formData,
          dataType: 'json' // Mong đợi nhận về JSON
        })
          .done(response => { // Sử dụng done()
            console.log('Server response:', response);
            if (response.success) {
              alert(response.message); // Hoặc dùng thư viện thông báo đẹp hơn
              buoiNhomForm[0].reset(); // Reset form
              $('#buoi_nhom_id').val(''); // Xóa ID ẩn
              // Reset các select2 về giá trị mặc định
              $('.select2bs4').val(null).trigger('change'); // Dùng class .select2bs4
              resetTinHuuSelects(); // Reset select tín hữu
              $('#submit-btn').text('Thêm Buổi Nhóm'); // Đặt lại text nút gốc
              // Kiểm tra nếu có bảng thì load lại
              if (buoiNhomTableBody.length > 0) {
                loadBuoiNhoms();
              }
              // Nếu đang ở trang edit thì có thể chuyển hướng về index
              // if(buoiNhomId) { window.location.href = '{{ route("buoi_nhom.index") }}'; }

            } else {
              // Hiển thị lỗi validation hoặc lỗi logic từ server
              let errorMsg = 'Lỗi: ' + (response.message || 'Đã xảy ra lỗi không xác định.');
              if (response.errors) {
                errorMsg = "Lỗi dữ liệu:\n";
                $.each(response.errors, function (key, value) {
                  errorMsg += `- ${value.join(', ')}\n`;
                });
              }
              alert(errorMsg);
            }
          })
          .fail(error => { // Sử dụng fail()
            console.error('Lỗi submit form:', error.status, error.statusText, error.responseText);
            let errorMsg = 'Đã xảy ra lỗi khi gửi dữ liệu.';
            if (error.status === 422 && error.responseJSON) { // Lỗi validation từ server
              try {
                const errors = error.responseJSON.errors;
                errorMsg = "Lỗi dữ liệu:\n";
                $.each(errors, function (key, value) {
                  // Tìm label tương ứng hoặc dùng tên key
                  let fieldName = $(`label[for="${key}"]`).text() || key;
                  // Bỏ dấu * nếu có
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
            alert(errorMsg);
          })
          .always(() => { // Sử dụng always()
            // Enable lại nút submit dù thành công hay thất bại
            $('#submit-btn').prop('disabled', false).text(buoiNhomId ? 'Cập Nhật' : 'Thêm Buổi Nhóm'); // Đặt lại text nút gốc
          });
      });
    }

    // Sử dụng event delegation cho các nút edit/delete trong bảng
    $(document).on('click', '.edit-btn', function () {
      const id = $(this).data('id');
      // SỬA ĐỔI Ở ĐÂY: Lấy URL trang edit thông thường
      const editUrl = '{{ route("buoi_nhom.edit", ["buoi_nhom" => "__ID__"]) }}'.replace('__ID__', id);
      console.log('Edit button clicked for ID:', id, 'Redirecting to:', editUrl);
      // Chuyển hướng đến trang edit thay vì load dữ liệu bằng Ajax vào form hiện tại
      window.location.href = editUrl;

        /* // ----- BỎ Đoạn Ajax load dữ liệu vào form hiện tại ----
        const url = '{{ route("api.buoi_nhom.details", ["buoi_nhom" => "__ID__"]) }}'.replace('__ID__', id);
      console.log('Edit button clicked for ID:', id, 'Fetching from:', url);

      $.get(url)
        .done(data => {
          // ... (code cũ để đổ data vào form) ...
          // Code này chỉ cần nếu bạn muốn form dùng chung cho cả create/edit trên CÙNG 1 trang
        })
        .fail(error => {
          console.error('Lỗi tải dữ liệu chỉnh sửa:', error.statusText, error.responseText);
          alert('Đã xảy ra lỗi khi tải dữ liệu để sửa. Vui lòng kiểm tra console (F12).');
        });
        */
    });


    $(document).on('click', '.delete-btn', function () {
      const id = $(this).data('id');
      // SỬA ĐỔI Ở ĐÂY: Sử dụng route name mới cho destroy
      const url = '{{ route("api.buoi_nhom.destroy", ["buoi_nhom" => "__ID__"]) }}'.replace('__ID__', id);
      console.log('Delete button clicked for ID:', id, 'URL:', url);

      if (confirm('Bạn có chắc chắn muốn xóa buổi nhóm này?')) {
        $.ajax({
          url: url,
          method: 'DELETE', // Phương thức DELETE
          dataType: 'json' // Mong đợi JSON response
        })
          .done(response => {
            console.log('Delete response:', response);
            if (response.success) {
              alert(response.message);
              // Kiểm tra nếu có bảng thì load lại
              if (buoiNhomTableBody.length > 0) {
                loadBuoiNhoms();
              }
            } else {
              alert('Lỗi: ' + (response.message || 'Không thể xóa buổi nhóm.'));
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
            alert(errorMsg);
          });
      }
    });

    // Chỉ gán sự kiện nếu nút reset tồn tại
    if ($('#reset-btn').length) {
      $('#reset-btn').on('click', function () {
        console.log('Reset button clicked');
        buoiNhomForm[0].reset(); // Reset các trường input cơ bản
        $('#buoi_nhom_id').val(''); // Xóa ID ẩn
        // Reset các select2 về giá trị mặc định (null hoặc '')
        $('.select2bs4').val(null).trigger('change'); // Dùng class .select2bs4
        resetTinHuuSelects(); // Reset select tín hữu
        $('#submit-btn').text('Thêm Buổi Nhóm'); // Đặt lại text nút submit
        // Có thể thêm cuộn lên đầu form nếu cần
        // $('html, body').animate({ scrollTop: buoiNhomForm.offset().top - 20 }, 'smooth');
      });
    }

    // ----- Khởi chạy khi tải trang -----
    // populateSundays(); // Bỏ đi nếu không dùng select ngày chủ nhật

    // Kiểm tra xem có bảng danh sách trên trang không để tải
    if (buoiNhomTableBody.length > 0) {
      loadBuoiNhoms(); // Tải danh sách buổi nhóm ban đầu
    }

    console.log('Scripts chính đã khởi tạo xong.');

    // ---- Script dành riêng cho trang Edit ----
    // Trigger change ban đầu cho Ban ngành nếu đang ở trang edit
    const editId = $('#buoi_nhom_id').val();
    const initialBanNganhId = $('#ban_nganh_id').val();
    if (editId && initialBanNganhId) {
      console.log('Trang Edit: Triggering change cho ban ngành ID:', initialBanNganhId);
      // Dùng setTimeout nhỏ để đảm bảo các select khác đã được khởi tạo và JS sẵn sàng
      setTimeout(() => {
        $('#ban_nganh_id').trigger('change');
        // Sau khi trigger change, cần set lại giá trị selected ban đầu cho tín hữu
        // vì Ajax sẽ ghi đè. Cần lấy giá trị này từ PHP truyền xuống view edit.
        const initialHdctId = '{{ $buoiNhom->id_tin_huu_hdct ?? '' }}'; // Lấy từ biến $buoiNhom trong view edit
        const initialDoKtId = '{{ $buoiNhom->id_tin_huu_do_kt ?? '' }}'; // Lấy từ biến $buoiNhom trong view edit

        if (initialHdctId || initialDoKtId) {
          // Đợi Ajax load xong mới set lại (dùng promise hoặc timeout lớn hơn)
          setTimeout(() => {
            console.log('Re-setting selected Tín hữu after initial load:', initialHdctId, initialDoKtId);
            if (initialHdctId) tinHuuHdctSelect.val(initialHdctId).trigger('change');
            if (initialDoKtId) tinHuuDoKtSelect.val(initialDoKtId).trigger('change');
          }, 1500); // Tăng thời gian chờ Ajax load xong
        }
      }, 200); // Chờ 200ms
    } else {
      // Nếu là form create, reset các select tín hữu ban đầu (đảm bảo)
      resetTinHuuSelects();
    }
    // ------------------------------------------


</script>

{{-- Đảm bảo @stack('scripts') được đặt ở cuối layout nếu các view con cần thêm script riêng --}}
@stack('scripts')