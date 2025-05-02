@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Danh Sách Thông Báo</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($thongBao->isEmpty())
            <p>Không có thông báo nào.</p>
        @else
            <div class="mb-3">
                <button id="mark-all-read" class="btn btn-primary">Đánh Dấu Tất Cả Đã Đọc</button>
            </div>
            <div class="list-group">
                @foreach ($thongBao as $tb)
                    <div class="list-group-item notification-item {{ $tb->da_doc ? 'read' : '' }}">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">{{ $tb->tieu_de }}</h5>
                            <small>{{ $tb->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        <p class="mb-1">{{ $tb->noi_dung }}</p>
                        @if (!$tb->da_doc)
                            <button class="btn btn-sm btn-outline-primary mark-as-read" data-id="{{ $tb->id }}">Đánh Dấu Đã Đọc</button>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $thongBao->links() }}
            </div>
        @endif
    </div>

    <script>
        $('#mark-all-read').click(function () {
            $.ajax({
                url: '{{ route("_thu_quy.thong_bao.danh_dau_tat_ca") }}',
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        $('.notification-item').addClass('read');
                        $('.mark-as-read').hide();
                        $('#notification-count').text(0).hide();
                    } else {
                        alert('Có lỗi xảy ra khi đánh dấu tất cả thông báo đã đọc.');
                    }
                },
                error: function () {
                    alert('Lỗi kết nối. Vui lòng thử lại sau.');
                }
            });
        });
    </script>
@endsection

<style>
    .notification-item.read {
        background-color: #f8f9fa;
    }

    .notification-item.read .mark-as-read {
        display: none;
    }
</style>