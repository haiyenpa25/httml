@extends('layouts.app')

@section('title', 'Lịch Sử Thao Tác')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Lịch Sử Thao Tác</h1>
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
                    <h3 class="card-title">Danh Sách Lịch Sử Thao Tác</h3>
                </div>
                <div class="card-body">
                    <table id="lichSuTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Người Dùng</th>
                                <th>Hành Động</th>
                                <th>Bảng Tác Động</th>
                                <th>Thời Gian</th>
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
    @include('_thu_quy.scripts.lich_su')
@endsection