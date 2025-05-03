@extends('layouts.app')

@section('title', 'Danh Sách Báo Cáo')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Báo Cáo Tài Chính</h1>
                </div>
                <div class="col-sm-6">
                    @include('_thu_quy.partials.header_actions')
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            @include('_thu_quy.partials.messages')

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh Sách Báo Cáo</h3>
                </div>
                <div class="card-body">
                    <table id="baoCaoTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Tiêu Đề</th>
                                <th>Quỹ</th>
                                <th>Loại Báo Cáo</th>
                                <th>Từ Ngày</th>
                                <th>Đến Ngày</th>
                                <th>Tổng Thu</th>
                                <th>Tổng Chi</th>
                                <th>Công Khai</th>
                                <th>Thao Tác</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>

    @include('_thu_quy.partials.delete_modal')
@endsection

@section('page-scripts')
    @include('_thu_quy.scripts.bao_cao')
@endsection