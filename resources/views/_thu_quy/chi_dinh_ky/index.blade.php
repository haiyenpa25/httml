@extends('layouts.app')

@section('title', 'Danh Sách Chi Định Kỳ')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Chi Định Kỳ</h1>
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
                    <h3 class="card-title">Danh Sách Chi Định Kỳ</h3>
                </div>
                <div class="card-body">
                    <table id="chiDinhKyTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Tên Chi</th>
                                <th>Quỹ</th>
                                <th>Số Tiền</th>
                                <th>Tần Suất</th>
                                <th>Trạng Thái</th>
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
    @include('_thu_quy.scripts.chi_dinh_ky')
@endsection