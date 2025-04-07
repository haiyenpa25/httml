@extends('layouts.app')

@section('content')
<div class="container-fluid">
  {{-- PHẦN 1: Chọn Ban Ngành --}}
  <div class="card border-primary">
    <div class="card-header bg-primary text-white"><strong>Phần 1: Chọn Ban Ngành</strong></div>
    <div class="card-body">
      <div class="form-group">
        <select name="ban_nganh_id" id="ban_nganh_id" class="form-control select2bs4">
          <option value="">-- Chọn Ban Ngành --</option>
          @foreach($bannganhs as $ban)
            <option value="{{ $ban->id }}">{{ $ban->ten }}</option>
          @endforeach
        </select>
      </div>
    </div>
  </div>

  {{-- PHẦN 2: Chọn Tín Hữu --}}
  <div class="card border-info mt-3">
    <div class="card-header bg-info text-white"><strong>Phần 2: Chọn Tín Hữu</strong></div>
    <div class="card-body">
      <div class="form-group">
        <select name="tin_huu_id" id="tin_huu_id" class="form-control select2bs4">
          <option value="">-- Chọn Tín Hữu --</option>
          @foreach($tinhuus as $th)
            <option value="{{ $th->id }}">{{ $th->ho_ten }}</option>
          @endforeach
        </select>
      </div>
    </div>
  </div>

  {{-- PHẦN 3: Thao Tác --}}
  <div class="text-center mt-3">
    <button class="btn btn-success" id="btn-them">Thêm vào Ban</button>
    <button class="btn btn-secondary" id="btn-huy">Hủy</button>
  </div>

  {{-- PHẦN 4: Danh Sách Thành Viên --}}
  <div id="thanhvien-container" class="mt-4">
    <!-- Nội dung bảng thành viên sẽ được load bằng Ajax -->
  </div>
</div>

<!-- Modal xác nhận xóa -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="deleteLabel">Xác nhận xóa</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Bạn có chắc chắn muốn xóa Tín Hữu này khỏi Ban Ngành?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
        <button type="button" class="btn btn-danger" id="btn-confirm-delete">Xóa</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<!-- Select2 JS -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

<script>
    
  $(function () {
    $('.select2bs4').select2({ theme: 'bootstrap4' });

    function loadMembers() {
      let banNganhId = $('#ban_nganh_id').val();
      if (banNganhId) {
        $.get("{{ route('_tin_huu_ban_nganh.members') }}", { ban_nganh_id: banNganhId }, function (data) {
          $('#thanhvien-container').html(data.html);
        });
      }
    }

    $('#ban_nganh_id').on('change', function () {
      loadMembers();
    });

    $('#btn-them').on('click', function () {
      let banNganhId = $('#ban_nganh_id').val();
      let tinHuuId = $('#tin_huu_id').val();

      if (!banNganhId || !tinHuuId) {
        alert("Vui lòng chọn đủ thông tin.");
        return;
      }

      $.post("{{ route('_tin_huu_ban_nganh.store') }}", {
        _token: "{{ csrf_token() }}",
        ban_nganh_id: banNganhId,
        tin_huu_id: tinHuuId
      }, function () {
        $('#tin_huu_id').val('').trigger('change');
        loadMembers();
      });
    });

    $('#btn-huy').on('click', function () {
      $('#tin_huu_id').val('').trigger('change');
    });

    // Delete logic
    let banToDelete = null;
    let tinHuuToDelete = null;

    $(document).on('click', '.btn-delete', function () {
      banToDelete = $(this).data('ban');
      tinHuuToDelete = $(this).data('tinhuu');
      $('#confirmDeleteModal').modal('show');
    });

    $('#btn-confirm-delete').on('click', function () {
      if (banToDelete && tinHuuToDelete) {
        $.ajax({
          url: "{{ route('_tin_huu_ban_nganh.destroy') }}",
          method: 'DELETE',
          data: {
            _token: "{{ csrf_token() }}",
            ban_nganh_id: banToDelete,
            tin_huu_id: tinHuuToDelete
          },
          success: function () {
            $('#confirmDeleteModal').modal('hide');
            loadMembers();
          }
        });
      }
    });
  });
</script>
@endpush
