@extends('layouts.app')

@section('title', 'Quản Lý Quỹ Tài Chính')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Quản Lý Quỹ Tài Chính</h1>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('_thu_quy.quy.create') }}" class="btn btn-primary float-sm-right">
                        <i class="fas fa-plus"></i> Thêm Quỹ Mới
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh Sách Quỹ Tài Chính</h3>
                </div>
                <div class="card-body">
                    <table id="quyTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Tên Quỹ</th>
                                <th>Số Dư Hiện Tại</th>
                                <th>Người Quản Lý</th>
                                <th>Trạng Thái</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page-scripts')
    @include('_thu_quy.scripts.quy_tai_chinh')
@endsection