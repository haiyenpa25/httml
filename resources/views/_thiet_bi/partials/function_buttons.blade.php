<!-- resources/views/_thiet_bi/partials/function_buttons.blade.php -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-them-thiet-bi">
                        <i class="fas fa-plus"></i> Thêm Thiết Bị
                    </button>
                    <a href="{{ route('nha-cung-cap.index') }}" class="btn btn-success">
                        <i class="fas fa-building"></i> Nhà Cung Cấp
                    </a>
                    <a href="{{ route('thiet-bi.canh-bao') }}" class="btn btn-warning">
                        <i class="fas fa-exclamation-triangle"></i> Cảnh Báo
                    </a>
                    <a href="{{ route('thiet-bi.bao-cao') }}" class="btn btn-info">
                        <i class="fas fa-chart-bar"></i> Báo Cáo
                    </a>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-info" id="btn-refresh">
                        <i class="fas fa-sync"></i> Tải lại
                    </button>
                    <a href="{{ route('thiet-bi.export-excel') }}" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> Xuất Excel
                    </a>
                    <a href="{{ route('thiet-bi.export-pdf') }}" class="btn btn-danger">
                        <i class="fas fa-file-pdf"></i> Xuất PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>