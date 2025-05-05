@extends('layouts.app')

@section('title', 'Kết Quả Tìm Kiếm')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kết Quả Tìm Kiếm Giao Dịch</h1>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('thu_quy.giao_dich.xuat_pdf') }}" class="btn btn-sm btn-danger float-right mr-2">
                        <i class="fas fa-file-pdf"></i> Xuất PDF
                    </a>
                    <a href="{{ route('thu_quy.giao_dich.xuat_excel') }}" class="btn btn-sm btn-success float-right mr-2">
                        <i class="fas fa-file-excel"></i> Xuất Excel
                    </a>
                    <a href="{{ route('thu_quy.giao_dich.search') }}" class="btn btn-sm btn-info float-right mr-2">
                        <i class="fas fa-search"></i> Tìm Kiếm Lại
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            @include('_thu_quy.partials.messages')

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Kết Quả Tìm Kiếm</h3>
                </div>
                <div class="card-body">
                    <table id="searchResultsTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Mã Giao Dịch</th>
                                <th>Quỹ</th>
                                <th>Số Tiền</th>
                                <th>Loại</th>
                                <th>Trạng Thái</th>
                                <th>Ngày</th>
                                <th>Thao Tác</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page-scripts')
    <script>
        $(document).ready(function () {
            $('#searchResultsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("thu_quy.giao_dich.search.results") }}',
                    type: 'POST',
                    data: function (d) {
                        d._token = $('meta[name="csrf-token"]').attr('content');
                    }
                },
                columns: [
                    { data: 'ma_giao_dich', name: 'ma_giao_dich' },
                    { data: 'quy_tai_chinh', name: 'quy_tai_chinh' },
                    { data: 'so_tien', name: 'so_tien' },
                    { data: 'loai', name: 'loai' },
                    { data: 'trang_thai', name: 'trang_thai' },
                    { data: 'ngay_giao_dich', name: 'ngay_giao_dich' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Vietnamese.json'
                }
            });
        });
    </script>
@endsection