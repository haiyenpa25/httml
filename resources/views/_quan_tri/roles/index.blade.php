@extends('adminlte::page')

@section('title', 'Quản lý vai trò')

@section('content_header')
    <h1>Quản lý vai trò</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách vai trò</h3>
            <div class="card-tools">
                <button class="btn btn-primary" data-toggle="modal" data-target="#roleModal" id="createRole">
                    <i class="fas fa-plus"></i> Thêm vai trò
                </button>
            </div>
        </div>
        <div class="card-body">
            <table id="rolesTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên vai trò</th>
                        <th>Guard</th>
                        <th>Ngày tạo</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    @include('quan-tri.roles.partials.modal')
@stop

@section('js')
    @include('quan-tri.roles.scripts')
@stop