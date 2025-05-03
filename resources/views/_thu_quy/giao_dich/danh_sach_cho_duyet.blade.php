@extends('layouts.app')

@section('title', 'Giao Dịch Chờ Duyệt')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Giao Dịch Chờ Duyệt</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            @include('_thu_quy.partials.messages')

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh Sách Giao Dịch Chờ Duyệt</h3>
                </div>
                <div class="card-body">
                    <table id="giaoDichChoDuyetTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Mã Giao Dịch</th>
                                <th>Quỹ</th>
                                <th>Số Tiền</th>
                                <th>Loại</th>
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
            $('#giaoDichChoDuyetTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("thu_quy.giao_dich.duyet.data") }}',
                columns: [
                    { data: 'ma_giao_dich', name: 'ma_giao_dich' },
                    { data: 'quy_tai_chinh', name: 'quy_tai_chinh' },
                    { data: 'so_tien', name: 'so_tien' },
                    { data: 'loai', name: 'loai' },
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