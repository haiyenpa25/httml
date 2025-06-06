@extends('layouts.app')

@section('title', 'Thông báo đã lưu trữ')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Thông báo đã lưu trữ</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('thong-bao.index') }}">Thông báo</a></li>
                    <li class="breadcrumb-item active">Đã lưu trữ</li>
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
                            <a href="{{ route('thong-bao.sent') }}" class="btn btn-secondary">
                                <i class="fas fa-paper-plane"></i> Đã gửi
                            </a>
                            <a href="{{ route('thong-bao.archived') }}" class="btn btn-warning active">
                                <i class="fas fa-archive"></i> Lưu trữ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Danh sách thông báo đã lưu trữ -->
        <div class="card card-warning card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-archive"></i>
                    Thông báo đã lưu trữ
                </h3>
                <div class="card-tools">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" placeholder="Tìm kiếm" id="search-archived">
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
                    <!-- Check all button -->
                    <button type="button" class="btn btn-default btn-sm checkbox-toggle">
                        <i class="far fa-square"></i>
                    </button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm unarchive-btn" disabled>
                            <i class="fas fa-archive"></i> Bỏ lưu trữ
                        </button>
                        <button type="button" class="btn btn-default btn-sm delete-btn" disabled>
                            <i class="far fa-trash-alt"></i> Xóa
                        </button>
                    </div>
                    <!-- /.btn-group -->
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
                        <tbody>
                            @foreach ($thongBaos as $thongBao)
                            <tr>
                                <td>
                                    <div class="icheck-primary">
                                        <input type="checkbox" value="{{ $thongBao->id }}" id="check{{ $thongBao->id }}" class="message-checkbox">
                                        <label for="check{{ $thongBao->id }}"></label>
                                    </div>
                                </td>
                                <td class="mailbox-star text-center">
                                    <i class="fas fa-archive text-warning"></i>
                                </td>
                                <td class="mailbox-name">
                                    <a href="{{ route('thong-bao.show', $thongBao->id) }}">
                                        {{ $thongBao->nguoiGui->tinHuu->ho_ten }}
                                    </a>
                                </td>
                                <td class="mailbox-subject">
                                    <a href="{{ route('thong-bao.show', $thongBao->id) }}" class="text-dark">
                                        {{ $thongBao->tieu_de }}
                                    </a>
                                </td>
                                <td class="mailbox-date">{{ $thongBao->ngay_gui->format('d/m/Y H:i') }}</td>
                                <td class="mailbox-actions">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-sm unarchive-single-btn" data-id="{{ $thongBao->id }}" title="Bỏ lưu trữ">
                                            <i class="fas fa-archive"></i>
                                        </button>
                                        <button type="button" class="btn btn-default btn-sm delete-single-btn" data-id="{{ $thongBao->id }}" title="Xóa">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- /.table -->
                </div>
                <!-- /.mail-box-messages -->
                @else
                <div class="text-center py-5">
                    <i class="fas fa-archive fa-4x text-muted mb-3"></i>
                    <h5>Không có thông báo nào đã lưu trữ</h5>
                    <p class="text-muted">Bạn chưa lưu trữ thông báo nào.</p>
                </div>
                @endif
            </div>
            <!-- /.card-body -->
            <div class="card-footer p-0">
                <div class="mailbox-controls">
                    @if ($thongBaos->count() > 0)
                    <!-- Check all button -->
                    <button type="button" class="btn btn-default btn-sm checkbox-toggle">
                        <i class="far fa-square"></i>
                    </button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm unarchive-btn" disabled>
                            <i class="fas fa-archive"></i> Bỏ lưu trữ
                        </button>
                        <button type="button" class="btn btn-default btn-sm delete-btn" disabled>
                            <i class="far fa-trash-alt"></i> Xóa
                        </button>
                    </div>
                    <!-- /.btn-group -->
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
                <p>Bạn có chắc chắn muốn xóa <span id="delete-count"></span> thông báo đã chọn?</p>
                <p class="text-danger">Lưu ý: Thao tác này không thể khôi phục.</p>
                <input type="hidden" id="delete_ids">
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
        // Check/uncheck all
        $('.checkbox-toggle').click(function() {
            const checkboxes = $('.mailbox-messages input[type="checkbox"]');
            checkboxes.prop('checked', !checkboxes.prop('checked'));
            updateButtonState();
        });

        // Update button state based on checkbox selection
        function updateButtonState() {
            const checkedCount = $('.mailbox-messages input[type="checkbox"]:checked').length;
            
            if (checkedCount > 0) {
                $('.unarchive-btn, .delete-btn').prop('disabled', false);
                $('#delete-count').text(checkedCount);
            } else {
                $('.unarchive-btn, .delete-btn').prop('disabled', true);
            }
        }

        // Listen for checkbox changes
        $('.message-checkbox').on('change', function() {
            updateButtonState();
        });

        // Refresh button
        $('.refresh-btn').click(function() {
            window.location.reload();
        });

        // Unarchive button (multiple)
        $('.unarchive-btn').click(function() {
            const selectedIds = getSelectedIds();
            
            if (selectedIds.length === 0) {
                return;
            }
            
            unarchiveMessages(selectedIds);
        });

        // Delete button (multiple)
        $('.delete-btn').click(function() {
            const selectedIds = getSelectedIds();
            
            if (selectedIds.length === 0) {
                return;
            }
            
            $('#delete_ids').val(JSON.stringify(selectedIds));
            $('#modal-xoa-thong-bao').modal('show');
        });

        // Unarchive button (single)
        $('.unarchive-single-btn').click(function() {
            const id = $(this).data('id');
            unarchiveMessages([id]);
        });

        // Delete button (single)
        $('.delete-single-btn').click(function() {
            const id = $(this).data('id');
            $('#delete_ids').val(JSON.stringify([id]));
            $('#modal-xoa-thong-bao').modal('show');
        });

        // Confirm delete
        $('#confirm-delete').click(function() {
            const ids = JSON.parse($('#delete_ids').val());
            
            if (ids.length === 0) {
                return;
            }
            
            deleteMessages(ids);
        });

        // Search archived
        $('#search-archived').on('keyup', function() {
            const searchTerm = $(this).val().toLowerCase();
            
            $('.mailbox-messages tr').each(function() {
                const sender = $(this).find('.mailbox-name').text().toLowerCase();
                const subject = $(this).find('.mailbox-subject').text().toLowerCase();
                
                if (sender.includes(searchTerm) || subject.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Helper function to get selected IDs
        function getSelectedIds() {
            return $('.mailbox-messages input[type="checkbox"]:checked').map(function() {
                return $(this).val();
            }).get();
        }

        // Helper function to unarchive messages
        function unarchiveMessages(ids) {
            $.ajax({
                url: "{{ route('thong-bao.unarchive-multiple') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    ids: ids
                },
                success: function(response) {
                    toastr.success(response.message);
                    window.location.reload();
                },
                error: function() {
                    toastr.error('Không thể bỏ lưu trữ thông báo. Vui lòng thử lại.');
                }
            });
        }

        // Helper function to delete messages
        function deleteMessages(ids) {
            $.ajax({
                url: "{{ route('thong-bao.delete-multiple') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: "DELETE",
                    ids: ids
                },
                success: function(response) {
                    toastr.success(response.message);
                    $('#modal-xoa-thong-bao').modal('hide');
                    window.location.reload();
                },
                error: function() {
                    toastr.error('Không thể xóa thông báo. Vui lòng thử lại.');
                    $('#modal-xoa-thong-bao').modal('hide');
                }
            });
        }
    });
</script>
@endsection