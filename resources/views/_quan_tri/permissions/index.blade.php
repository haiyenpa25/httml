@extends('adminlte::page')

@section('title', 'Quản lý quyền')

@section('content_header')
    <h1>Quản lý quyền</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách quyền</h3>
            <div class="card-tools">
                <button class="btn btn-primary" data-toggle="modal" data-target="#permissionModal" id="createPermission">
                    <i class="fas fa-plus"></i> Thêm quyền
                </button>
            </div>
        </div>
        <div class="card-body">
            <table id="permissionsTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên quyền</th>
                        <th>Guard</th>
                        <th>Ngày tạo</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    @include('quan-tri.permissions.partials.modal')
@stop

@section('js')
    @include('quan-tri.permissions.scripts')
@stop