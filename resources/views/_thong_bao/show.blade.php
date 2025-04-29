@extends('layouts.app')

@section('title', 'Chi tiết thông báo')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Chi tiết thông báo</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('thong-bao.index') }}">Thông báo</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('thong-bao.inbox') }}">Hộp thư đến</a></li>
                    <li class="breadcrumb-item active">Chi tiết thông báo</li>
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

        <!-- Chi tiết thông báo -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">{{ $thongBao->tieu_de }}</h3>
                <div class="card-tools">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm" id="archive-btn" data-id="{{ $thongBao->id }}" title="{{ $thongBao->luu_tru ? 'Bỏ lưu trữ' : 'Lưu trữ' }}">
                            <i class="fas fa-archive"></i> {{ $thongBao->luu_tru ? 'Bỏ lưu trữ' : 'Lưu trữ' }}
                        </button>
                        <button type="button" class="btn btn-default btn-sm" id="delete-btn" data-id="{{ $thongBao->id }}" title="Xóa">
                            <i class="fas fa-trash"></i> Xóa
                        </button>
                        <a href="{{ route('thong-bao.inbox') }}" class="btn btn-default btn-sm" title="Quay lại">
                            <i class="fas fa-reply"></i> Quay lại
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="mailbox-read-info mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Từ: {{ $thongBao->nguoiGui->tinHuu->ho_ten }}</h6>
                        </div>
                        <div class="col-md-6 text-right">
                            <span class="mailbox-read-time">{{ $thongBao->ngay_gui->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
                <!-- /.mailbox-read-info -->

                <div class="mailbox-read-message">
                    {!! $thongBao->noi_dung !!}
                </div>
                <!-- /.mailbox-read-message -->
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <div class="float-right">
                    <button type="button" class="btn btn-default" id="reply-btn" data-id="{{ $thongBao->nguoi_gui_id }}">
                        <i class="fas fa-reply"></i> Trả lời
                    </button>
                </div>
                <button type="button" class="btn btn-default" id="delete-btn2" data-id="{{ $thongBao->id }}">
                    <i class="far fa-trash-alt"></i> Xóa
                </button>
                <button type="button" class="btn btn-default" id="archive-btn2" data-id="{{ $thongBao->id }}">
                    <i class="fas fa-archive"></i> {{ $thongBao->luu_tru ? 'Bỏ lưu trữ' : 'Lưu trữ' }}
                </button>
            </div>
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<!-- Modal Xác nhận xóa -->
<div class="modal fade" id="modal-xoa-thong-bao">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Xác nhận xóa</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa thông báo này?</p>
                <p class="text-danger">Lưu ý: Thao tác này không thể khôi phục.</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-danger" id="confirm-delete">Xóa</button>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->
@endsection

@section('page-scripts')
<script>
    $(document).ready(function() {
        // Biến lưu ID thông báo đang xem
        const thongBaoId = {{ $thongBao->id }};
        
        // Xử lý nút lưu trữ
        function handleArchive() {
            const isArchived = {{ $thongBao->luu_tru ? 'true' : 'false' }};
            const url = isArchived 
                ? "{{ route('thong-bao.unarchive', ':id') }}".replace(':id', thongBaoId)
                : "{{ route('thong-bao.archive', ':id') }}".replace(':id', thongBaoId);
            
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    toastr.success(response.message);
                    window.location.reload();
                },
                error: function() {
                    toastr.error('Không thể thực hiện thao tác. Vui lòng thử lại.');
                }
            });
        }
        
        // Xử lý nút xóa
        function handleDelete() {
            $('#modal-xoa-thong-bao').modal('show');
        }
        
        // Xử lý nút trả lời
        function handleReply() {
            window.location.href = "{{ route('thong-bao.create') }}?reply_to=" + {{ $thongBao->nguoi_gui_id }};
        }
        
        // Nút lưu trữ
        $('#archive-btn, #archive-btn2').click(function() {
            handleArchive();
        });
        
        // Nút xóa
        $('#delete-btn, #delete-btn2').click(function() {
            handleDelete();
        });
        
        // Nút trả lời
        $('#reply-btn').click(function() {
            handleReply();
        });
        
        // Xác nhận xóa
        $('#confirm-delete').click(function() {
            $.ajax({
                url: "{{ route('thong-bao.destroy', ':id') }}".replace(':id', thongBaoId),
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: "DELETE"
                },
                success: function(response) {
                    toastr.success(response.message);
                    $('#modal-xoa-thong-bao').modal('hide');
                    window.location.href = "{{ route('thong-bao.inbox') }}";
                },
                error: function() {
                    toastr.error('Không thể xóa thông báo. Vui lòng thử lại.');
                    $('#modal-xoa-thong-bao').modal('hide');
                }
            });
        });
    });
</script>
@endsection