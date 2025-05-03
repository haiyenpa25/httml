<div class="float-right">
    @if (request()->routeIs('thu_quy.quy.index'))
        <a href="{{ route('thu_quy.quy.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Tạo Quỹ Mới
        </a>
    @elseif (request()->routeIs('thu_quy.giao_dich.index'))
        <a href="{{ route('thu_quy.giao_dich.create') }}" class="btn btn-sm btn-primary mr-2">
            <i class="fas fa-plus"></i> Tạo Giao Dịch
        </a>
        <a href="{{ route('thu_quy.giao_dich.search') }}" class="btn btn-sm btn-info">
            <i class="fas fa-search"></i> Tìm Kiếm Nâng Cao
        </a>
    @elseif (request()->routeIs('thu_quy.chi_dinh_ky.index'))
        <a href="{{ route('thu_quy.chi_dinh_ky.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Tạo Chi Định Kỳ
        </a>
    @elseif (request()->routeIs('thu_quy.bao_cao.index'))
        <a href="{{ route('thu_quy.bao_cao.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Tạo Báo Cáo
        </a>
    @endif
</div>