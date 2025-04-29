@extends('layouts.app')

@section('title', 'Thông báo đã gửi')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Thông báo đã gửi</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('thong-bao.index') }}">Thông báo</a></li>
                    <li class="breadcrumb-item active">Đã gửi</li>
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
                        <div>
                            <a href="{{ route('thong-bao.create') }}" class="btn btn-primary">
                                <i class="fas fa-envelope"></i> Soạn thông báo mới
                            </a>
                        </div>
                        <div class="btn-group">
                            <a href="{{ route('thong-bao.inbox') }}" class="btn btn-info">
                                <i class="fas fa-inbox"></i> Hộp thư đến
                            </a>
                            <a href="{{ route('thong-bao.sent') }}" class="btn btn-secondary active">
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

        <!-- Danh sách thông báo đã gửi -->
        <div class="card card-secondary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-paper-plane"></i>
                    Thông báo đã gửi
                </h3>
                <div class="card-tools">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" placeholder="Tìm kiếm" id="search-sent">
                        <div class="input-group-append">
                            <div class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                @if ($thongBaos->count() > 0)
                <div class="mailbox-controls">
                    <!-- Buttons if needed -->
                    <button type="button" class="btn btn-default btn-sm refresh-btn">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                    <div class="float-right">
                        {{ $thongBaos->firstItem() ?? 0 }}-{{ $thongBaos->lastItem() ?? 0 }}/{{ $thongBaos->total() }}
                        <div class="btn-group">
                            <a href="{{ $thongBaos->previousPageUrl() }}" class="btn btn-default btn-sm {{ $thongBaos->onFirstPage() ? 'disabled' : '' }}">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                            <a href="{{ $thongBaos->nextPageUrl() }}" class="btn btn-default btn-sm {{ !$thongBaos->hasMorePages() ? 'disabled' : '' }}">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                        <!-- /.btn-group -->
                    </div>
                    <!-- /.float-right -->
                </div>

                <div class="table-responsive mailbox-messages">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="5%"></th>
                                <th width="30%">Người nhận</th>
                                <th width="45%">Tiêu đề</th>
                                <th width="20%">Ngày gửi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($thongBaos as $thongBao)
                            <tr>
                                <td class="mailbox-star text-center">
                                    <i class="fas fa-paper-plane text-secondary"></i>
                                </td>
                                <td class="mailbox-name">
                                    {{ $thongBao->nguoiNhan->tinHuu->ho_ten }}
                                </td>
                                <td class="mailbox-subject">
                                    <a href="{{ route('thong-bao.show-sent', $thongBao->id) }}" class="text-dark">
                                        {{ $thongBao->tieu_de }}
                                    </a>
                                </td>
                                <td class="mailbox-date">{{ $thongBao->ngay_gui->format('d/m/Y H:i') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- /.table -->
                </div>
                <!-- /.mail-box-messages -->
                @else
                <div class="text-center py-5">
                    <i class="far fa-paper-plane fa-4x text-muted mb-3"></i>
                    <h5>Chưa có thông báo nào được gửi</h5>
                    <p class="text-muted">Bạn chưa gửi thông báo nào.</p>
                </div>
                @endif
            </div>
            <!-- /.card-body -->
            <div class="card-footer p-0">
                <div class="mailbox-controls">
                    @if ($thongBaos->count() > 0)
                    <button type="button" class="btn btn-default btn-sm refresh-btn">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                    <div class="float-right">
                        {{ $thongBaos->firstItem() ?? 0 }}-{{ $thongBaos->lastItem() ?? 0 }}/{{ $thongBaos->total() }}
                        <div class="btn-group">
                            <a href="{{ $thongBaos->previousPageUrl() }}" class="btn btn-default btn-sm {{ $thongBaos->onFirstPage() ? 'disabled' : '' }}">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                            <a href="{{ $thongBaos->nextPageUrl() }}" class="btn btn-default btn-sm {{ !$thongBaos->hasMorePages() ? 'disabled' : '' }}">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                        <!-- /.btn-group -->
                    </div>
                    <!-- /.float-right -->
                    @endif
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
        // Refresh button
        $('.refresh-btn').click(function() {
            window.location.reload();
        });

        // Search sent messages
        $('#search-sent').on('keyup', function() {
            const searchTerm = $(this).val().toLowerCase();
            
            $('.mailbox-messages tbody tr').each(function() {
                const receiver = $(this).find('.mailbox-name').text().toLowerCase();
                const subject = $(this).find('.mailbox-subject').text().toLowerCase();
                
                if (receiver.includes(searchTerm) || subject.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
</script>
@endsection