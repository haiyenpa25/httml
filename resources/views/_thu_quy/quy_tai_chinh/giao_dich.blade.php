@extends('layouts.app')

@section('title', 'Giao Dịch Quỹ')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Giao Dịch Quỹ: {{ $quy->ten_quy }}</h1>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('thu_quy.quy.show', $quy->id) }}" class="btn btn-sm btn-info float-right">
                        <i class="fas fa-arrow-left"></i> Quay Lại
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
                    <h3 class="card-title">Danh Sách Giao Dịch</h3>
                </div>
                <div class="card-body">
                    <table id="giaoDichTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Mã Giao Dịch</th>
                                <th>Số Tiền</th>
                                <th>Loại</th>
                                <th>Hình Thức</th>
                                <th>Ban Ngành</th>
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
            $('#giaoDichTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("thu_quy.quy.giao_dich.data", $quy->id) }}',
                columns: [
                    { data: 'ma_giao_dich', name: 'ma_giao_dich' },
                    { data: 'so_tien', name: 'so_tien' },
                    { data: 'loai', name: 'loai' },
                    { data: 'hinh_thuc', name: 'hinh_thuc' },
                    { data: 'ban_nganh', name: 'ban_nganh' },
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