@extends('layouts.app')

@section('title', 'Quản lý Thông báo')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Quản lý Thông báo</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Thông báo</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Thông báo -->
        <div id="alert-container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-check"></i> Thành công!</h5>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-ban"></i> Lỗi!</h5>
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <!-- Các nút chức năng -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body d-flex justify-content-between">
                        <a href="{{ route('thong-bao.create') }}" class="btn btn-primary">
                            <i class="fas fa-envelope"></i> Soạn thông báo mới
                        </a>
                        <div class="btn-group">
                            <a href="{{ route('thong-bao.inbox') }}" class="btn btn-info position-relative">
                                <i class="fas fa-inbox"></i> Hộp thư đến
                                @if($thongBaoChuaDoc > 0)
                                    <span class="badge badge-danger badge-notification">{{ $thongBaoChuaDoc }}</span>
                                @endif
                            </a>
                            <a href="{{ route('thong-bao.sent') }}" class="btn btn-secondary">
                                <i class="fas fa-paper-plane"></i> Đã gửi
                            </a>
                            <a href="{{ route('thong-bao.archived') }}" class="btn btn-warning">
                                <i class="fas fa-archive"></i> Lưu trữ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thống kê -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $thongBaoChuaDoc }}</h3>
                        <p>Thông báo chưa đọc</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <a href="{{ route('thong-bao.inbox') }}" class="small-box-footer">
                        Xem ngay <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- Có thể thêm các thống kê khác ở đây -->
        </div>

        <!-- Thông báo gần đây -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-bell"></i>
                    Thông báo gần đây
                </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <div class="table-responsive mailbox-messages">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="5%"></th>
                                <th width="20%">Người gửi</th>
                                <th width="55%">Tiêu đề</th>
                                <th width="20%">Ngày gửi</th>
                            </tr>
                        </thead>
                        <tbody id="recent-notifications">
                            <!-- Dữ liệu sẽ được nạp bằng AJAX -->
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer bg-white">
                <div class="float-right">
                    <a href="{{ route('thong-bao.inbox') }}" class="btn btn-default">
                        Xem tất cả thông báo <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- /.card -->

    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection

@section('page-scripts')
<script>
    $(document).ready(function() {
        // Lấy thông báo gần đây
        function loadRecentNotifications() {
            $.ajax({
                url: "{{ route('thong-bao.latest', ['limit' => 5]) }}",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    var html = '';
                    
                    if (response.notifications.length === 0) {
                        html = '<tr><td colspan="4" class="text-center">Không có thông báo nào.</td></tr>';
                    } else {
                        $.each(response.notifications, function(index, notification) {
                            html += '<tr class="' + (notification.da_doc ? '' : 'font-weight-bold') + '">';
                            html += '<td class="text-center">';
                            html += notification.da_doc ? '<i class="far fa-envelope-open text-muted"></i>' : '<i class="fas fa-envelope text-primary"></i>';
                            html += '</td>';
                            html += '<td>' + notification.nguoi_gui + '</td>';
                            html += '<td><a href="' + "{{ url('thong-bao') }}/" + notification.id + '">' + notification.tieu_de + '</a></td>';
                            html += '<td>' + notification.ngay_gui + '</td>';
                            html += '</tr>';
                        });
                    }
                    
                    $('#recent-notifications').html(html);
                },
                error: function() {
                    $('#recent-notifications').html('<tr><td colspan="4" class="text-center text-danger">Không thể tải thông báo. Vui lòng thử lại sau.</td></tr>');
                }
            });
        }
        
        // Tải thông báo khi trang được tải
        loadRecentNotifications();
        
        // Cập nhật số lượng thông báo chưa đọc mỗi 30 giây
        setInterval(function() {
            $.ajax({
                url: "{{ route('thong-bao.count-unread') }}",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.count > 0) {
                        $('.badge-notification').text(response.count).show();
                    } else {
                        $('.badge-notification').hide();
                    }
                }
            });
        }, 30000);
    });
</script>
@endsection