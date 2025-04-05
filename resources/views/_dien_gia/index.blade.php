@extends('layouts.app')

@section('title', 'Danh Sách Diễn Giả')

@section('content')
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Danh Sách Diễn Giả</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Quản lý Diễn Giả</a></li>
                        <li class="breadcrumb-item active">Danh Sách</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Danh sách các diễn giả</h3>
                            <div class="card-tools">
                                <a href="{{ route('_dien_gia.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Thêm Mới
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <table id="table-diengia" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Họ Tên</th>
                                        <th>Chức Danh</th>
                                        <th>Hội Thánh</th>
                                        <th>SĐT</th>
                                        <th>Hành Động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dienGias as $dg)
                                        <tr>
                                            <td>{{ $dg->ho_ten }}</td>
                                            <td>{{ $dg->chuc_danh }}</td>
                                            <td>{{ $dg->hoi_thanh ?? '—' }}</td>
                                            <td>{{ $dg->so_dien_thoai ?? '—' }}</td>
                                            <td>
                                                <a href="{{ route('_dien_gia.show', ['dienGia' => $dg->id]) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> Xem
                                                </a>
                                                <a href="{{ route('_dien_gia.edit', ['dienGia' => $dg->id]) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i> Sửa
                                                </a>
                                                <form action="{{ route('_dien_gia.destroy', ['dienGia' => $dg->id]) }}" method="POST" style="display:inline-block;">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')">
                                                        <i class="fas fa-trash"></i> Xóa
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Họ Tên</th>
                                        <th>Chức Danh</th>
                                        <th>Hội Thánh</th>
                                        <th>SĐT</th>
                                        <th>Hành Động</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div> <!-- /.card-body -->
                    </div> <!-- /.card -->
                </div> <!-- /.col -->
            </div> <!-- /.row -->
        </div> <!-- /.container-fluid -->
    </section>
@endsection

@push('scripts')
    <!-- DataTables Plugin Scripts -->
    <script>
        $(function () {
            $("#table-diengia").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#table-diengia_wrapper .col-md-6:eq(0)');
        });
    </script>
@endpush
