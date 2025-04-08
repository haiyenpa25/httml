@if(count($members))
  <div class="card">
    <div class="card-header bg-success text-white">
      Danh sách Tín Hữu trong Ban Ngành
    </div>
    <div class="card-body p-0">
      <table class="table table-bordered mb-0">
        <thead>
          <tr>
            <th>#</th>
            <th>Họ tên</th>
            <th>Chức vụ</th>
            <th>Thao tác</th>
          </tr>
        </thead>
        <tbody>
          @foreach($members as $index => $m)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td>{{ $m->tinHuu->ho_ten }}</td>
              <td>{{ $m->chuc_vu ?? 'Chưa xác định' }}</td>
              <td>
                <button class="btn btn-danger btn-sm btn-delete" 
                        data-ban="{{ $m->ban_nganh_id }}" 
                        data-tinhuu="{{ $m->tin_huu_id }}">
                  Xóa
                </button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@else
  <div class="alert alert-warning mt-3">
    Chưa có thành viên nào trong ban ngành này.
  </div>
@endif